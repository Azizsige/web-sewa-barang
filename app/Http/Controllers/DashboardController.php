<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Rental;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Cek role user
        $user = auth()->user();

        if ($user->role === 'admin') {
            // Data untuk admin toko
            $totalProducts = Product::count();
            $activeProducts = Product::where('status', 'active')->count();
            $inactiveProducts = Product::where('status', 'inactive')->count();
            $activeRentals = Rental::whereIn('status', ['pending', 'ongoing'])->count();
            $totalCategories = Category::count();

            // Data untuk grafik rental per bulan
            $selectedMonth = $request->query('month', now()->format('Y-m'));
            $rentalsPerMonth = Rental::select(
                DB::raw('DATE_FORMAT(start_date, "%Y-%m") as month'),
                DB::raw('COUNT(*) as total')
            )
                ->where('start_date', '>=', now()->subMonths(12))
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total', 'month')
                ->toArray();

            // Format data untuk grafik
            $labels = [];
            $data = [];
            for ($i = 11; $i >= 0; $i--) {
                $month = now()->subMonths($i)->format('Y-m');
                $labels[] = now()->subMonths($i)->format('M Y');
                $data[] = $rentalsPerMonth[$month] ?? 0;
            }

            return view('dashboard', [
                'isAdmin' => true,
                'isDeveloper' => false,
                'totalProducts' => $totalProducts,
                'activeProducts' => $activeProducts,
                'inactiveProducts' => $inactiveProducts,
                'activeRentals' => $activeRentals,
                'totalCategories' => $totalCategories,
                'labels' => $labels,
                'data' => $data,
                'selectedMonth' => $selectedMonth,
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
