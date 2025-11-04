<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Redirect based on user role
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('cashier')) {
            return redirect()->route('cashier.pos');
        }

        if ($user->hasRole('waiter')) {
            return redirect()->route('waiter.tables.index');
        }

        if ($user->hasRole('kitchen')) {
            return redirect()->route('kitchen.orders.index');
        }

        if ($user->hasRole('bar')) {
            return redirect()->route('bar.orders.index');
        }

        // Default fallback
        return view('dashboard');
    }
}
