<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $isAdmin = auth()->user()->role === 'admin';
        $isDeveloper = auth()->user()->role === 'developer';

        if ($isAdmin) {
            // Ambil bulan dari request, default ke bulan sekarang
            $selectedMonth = $request->input('month', now()->format('Y-m'));
            $startDate = Carbon::parse($selectedMonth)->startOfMonth();
            $endDate = Carbon::parse($selectedMonth)->endOfMonth();

            // Debug request dan rentang tanggal
            \Log::info('Request Input Month: ' . $request->input('month'));
            \Log::info('Selected Month: ' . $selectedMonth);
            \Log::info('Start Date: ' . $startDate->toDateString());
            \Log::info('End Date: ' . $endDate->toDateString());

            // Data untuk grafik Rental Overview
            $rentals = Rental::whereBetween('created_at', [$startDate, $endDate])
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            // Debug data rentals
            \Log::info('Rentals Data: ', $rentals->toArray());

            $labels = [];
            $data = [];
            $currentDate = $startDate->copy();
            $dayCount = 0;
            while ($currentDate <= $endDate) {
                $labels[] = $currentDate->format('d M');
                $data[] = $rentals->where('date', $currentDate->toDateString())->first()->count ?? 0;
                $currentDate->addDay();
                $dayCount++;
            }

            // Debug jumlah hari dan data
            \Log::info('Total Days: ' . $dayCount);
            \Log::info('Generated Data: ', $data);

            // Data lainnya untuk dashboard
            $totalProducts = Product::count();
            $activeProducts = Product::where('status', 'active')->count();
            $inactiveProducts = Product::where('status', 'inactive')->count();
            $activeRentals = Rental::where('status', 'ongoing')->count();
            $totalCategories = Category::count();

            return view('dashboard', compact(
                'isAdmin',
                'isDeveloper',
                'selectedMonth',
                'labels',
                'data',
                'totalProducts',
                'activeProducts',
                'inactiveProducts',
                'activeRentals',
                'totalCategories'
            ));
        } elseif ($isDeveloper) {
            $shops = User::where('role', 'shop_owner')->get();
            return view('dashboard', compact('isDeveloper', 'shops'));
        }

        return view('dashboard', ['isAdmin' => false, 'isDeveloper' => false]);
    }
}
