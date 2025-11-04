<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsersManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';
    public $statusFilter = '';
    
    public $userId;
    public $name;
    public $email;
    public $phone;
    public $password;
    public $password_confirmation;
    public $selectedRole;
    public $is_active = true;
    
    public $showModal = false;
    public $editMode = false;
    public $deleteConfirm = false;
    public $userToDelete;

    protected $queryString = ['search', 'roleFilter', 'statusFilter'];

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . ($this->userId ?? 'NULL'),
            'phone' => 'nullable|string|max:20',
            'selectedRole' => 'required|exists:roles,name',
            'is_active' => 'boolean',
        ];

        if (!$this->editMode) {
            $rules['password'] = 'required|string|min:8|confirmed';
        } else {
            $rules['password'] = 'nullable|string|min:8|confirmed';
        }

        return $rules;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->selectedRole = $user->roles->first()?->name ?? '';
        $this->is_active = $user->is_active;
        
        $this->editMode = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'is_active' => $this->is_active,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->editMode) {
            $user = User::findOrFail($this->userId);
            $user->update($data);
            
            // Update role
            $user->syncRoles([$this->selectedRole]);
            
            session()->flash('message', 'အသုံးပြုသူကို အောင်မြင်စွာ ပြင်ဆင်ပြီးပါပြီ။');
        } else {
            $user = User::create($data);
            
            // Assign role
            $user->assignRole($this->selectedRole);
            
            session()->flash('message', 'အသုံးပြုသူကို အောင်မြင်စွာ ထည့်သွင်းပြီးပါပြီ။');
        }

        $this->closeModal();
    }

    public function confirmDelete($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting current user
        if ($user->id === auth()->id()) {
            session()->flash('error', 'သင့်ကိုယ်သင် ဖျက်၍မရပါ။');
            return;
        }
        
        $this->userToDelete = $id;
        $this->deleteConfirm = true;
    }

    public function delete()
    {
        $user = User::findOrFail($this->userToDelete);
        $user->delete();
        
        session()->flash('message', 'အသုံးပြုသူကို အောင်မြင်စွာ ဖျက်ပြီးပါပြီ။');
        $this->deleteConfirm = false;
        $this->userToDelete = null;
    }

    public function toggleActive($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deactivating current user
        if ($user->id === auth()->id()) {
            session()->flash('error', 'သင့်ကိုယ်သင် ပိတ်၍မရပါ။');
            return;
        }
        
        $user->update(['is_active' => !$user->is_active]);
        session()->flash('message', 'အသုံးပြုသူ အခြေအနေကို ပြောင်းလဲပြီးပါပြီ။');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'userId',
            'name',
            'email',
            'phone',
            'password',
            'password_confirmation',
            'selectedRole',
            'is_active',
        ]);
        $this->is_active = true;
        $this->resetValidation();
    }
    
    public function exportExcel()
    {
        $query = User::with('roles');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->roleFilter) {
            $query->role($this->roleFilter);
        }

        if ($this->statusFilter === 'active') {
            $query->where('is_active', true);
        } elseif ($this->statusFilter === 'inactive') {
            $query->where('is_active', false);
        }

        $users = $query->get();
        
        $filename = 'users_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header row
            fputcsv($file, ['Name', 'Email', 'Phone', 'Role', 'Status', 'Created At']);
            
            // Data rows
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->name,
                    $user->email,
                    $user->phone ?? '',
                    $user->roles->first()?->name ?? '',
                    $user->is_active ? 'Active' : 'Inactive',
                    $user->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        $query = User::with('roles');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->roleFilter) {
            $query->role($this->roleFilter);
        }

        if ($this->statusFilter === 'active') {
            $query->where('is_active', true);
        } elseif ($this->statusFilter === 'inactive') {
            $query->where('is_active', false);
        }

        $users = $query->latest()->paginate(20);
        $roles = Role::all();

        return view('livewire.admin.users-management', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }
}
