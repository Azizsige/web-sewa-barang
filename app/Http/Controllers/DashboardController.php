<?php

// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Cek role user
        $user = auth()->user();

        if ($user->role === 'admin') {
            // Data untuk admin toko
            return view('dashboard', [
                'isAdmin' => true,
                'isDeveloper' => false,
            ]);
        } elseif ($user->role === 'developer') {
            // Data untuk developer
            $shops = User::where('role', 'admin')->get(); // Ambil semua pemilik toko
            return view('dashboard', [
                'isAdmin' => false,
                'isDeveloper' => true,
                'shops' => $shops,
            ]);
        }

        // Fallback kalau role nggak dikenal
        abort(403, 'Unauthorized');
    }
}
