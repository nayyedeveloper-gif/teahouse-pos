<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QrMenuController;

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Public Menu (No authentication required)
Route::get('/menu', App\Livewire\Public\Menu::class)->name('public.menu');

// Digital Signage Display
Route::get('/display/signage', App\Livewire\Display\MenuBoard::class)->name('display.signage');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LogoutController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    
    // Dashboard - redirect based on role
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');
    
    // Admin routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
        
        Route::get('/categories', function () {
            return view('admin.categories.index');
        })->name('categories.index');
        
        Route::get('/items', function () {
            return view('admin.items.index');
        })->name('items.index');
        
        Route::get('/tables', function () {
            return view('admin.tables.index');
        })->name('tables.index');
        
        Route::get('/users', \App\Livewire\Admin\UsersManagement::class)->name('users.index');
        
        Route::get('/printers', function () {
            return view('admin.printers.index');
        })->name('printers.index');
        
        Route::get('/settings', function () {
            return view('admin.settings.index');
        })->name('settings.index');
        
        Route::get('/error-logs', \App\Livewire\Admin\ErrorLogs::class)->name('error-logs.index');
        
        Route::get('/reports', function () {
            return view('admin.reports.index');
        })->name('reports.index');
        
        Route::get('/qr-menu', function () {
            return view('admin.qr-menu');
        })->name('qr-menu.index');
        
        Route::get('/orders', function () {
            return view('admin.orders.index');
        })->name('orders.index');
        
        Route::get('/expenses', function () {
            return view('admin.expenses.index');
        })->name('expenses.index');
        
        Route::get('/signage-media', \App\Livewire\Admin\SignageMediaManagement::class)->name('signage-media.index');
        Route::get('/signage-analytics', \App\Livewire\Admin\SignageAnalytics::class)->name('signage-analytics.index');
        
        Route::get('/customers', \App\Livewire\Admin\CustomerManagement::class)->name('customers.index');
        
        Route::get('/cards', \App\Livewire\Admin\CardManagement::class)->name('cards.index');
        
        // Inventory routes
        Route::prefix('inventory')->name('inventory.')->group(function () {
            Route::get('/suppliers', \App\Livewire\Admin\Inventory\SupplierManagement::class)->name('suppliers');
            Route::get('/stock-items', \App\Livewire\Admin\Inventory\StockItemManagement::class)->name('stock-items');
            Route::get('/purchase-orders', \App\Livewire\Admin\Inventory\PurchaseOrderManagement::class)->name('purchase-orders');
        });
        
        // Reports routes
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/sales-by-item', \App\Livewire\Admin\Reports\SalesByItem::class)->name('sales-by-item');
            Route::get('/daily-summary', \App\Livewire\Admin\Reports\DailySummary::class)->name('daily-summary');
        });
    });
    
    // Cashier routes
    Route::middleware(['role:cashier'])->prefix('cashier')->name('cashier.')->group(function () {
        Route::get('/dashboard', \App\Livewire\Cashier\Dashboard::class)->name('dashboard');
        
        Route::get('/pos', function () {
            return view('cashier.pos');
        })->name('pos');
        
        Route::get('/orders', function () {
            return view('cashier.orders.index');
        })->name('orders.index');
        
        Route::get('/orders/{order}', function ($order) {
            return view('cashier.orders.show', ['order' => $order]);
        })->name('orders.show');
    });
    
    // Waiter routes
    Route::middleware(['role:waiter'])->prefix('waiter')->name('waiter.')->group(function () {
        Route::get('/dashboard', \App\Livewire\Waiter\Dashboard::class)->name('dashboard');
        
        Route::get('/tables', function () {
            return view('waiter.tables.index');
        })->name('tables.index');
        
        Route::get('/orders', function () {
            return view('waiter.orders.index');
        })->name('orders.index');
        
        Route::get('/orders/create', function () {
            return view('waiter.orders.create');
        })->name('orders.create');
        
        Route::get('/orders/{order}', function ($order) {
            return view('waiter.orders.show', ['order' => $order]);
        })->name('orders.show');
    });
    
});
