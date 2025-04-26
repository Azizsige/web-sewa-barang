<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $shops = User::where('role', 'admin')->get(); // Ambil semua pemilik toko
        return view('developer.dashboard', compact('shops'));
    }
}
