<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::with('product')->latest()->paginate(10);
        return view('rentals.index', compact('rentals'));
    }

    public function show(Rental $rental)
    {
        $rental->load('product');
        return view('rentals.show', compact('rental'));
    }

    public function create()
    {
        $products = Product::active()->where('stock', '>', 0)->with('primaryImage')->get();
        return view('rentals.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email',
            'customer_phone' => 'nullable|string|max:15',
            'product_id' => 'required|exists:products,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        try {
            // Gunakan transaksi untuk mencegah race condition
            $rental = DB::transaction(function () use ($request) {
                $product = Product::lockForUpdate()->findOrFail($request->product_id);

                if ($product->status !== 'active') {
                    throw new \Exception('Produk yang dipilih tidak aktif.');
                }

                // Cek tanggal bertabrakan
                $start_date = \Carbon\Carbon::parse($request->start_date);
                $end_date = \Carbon\Carbon::parse($request->end_date);
                $overlappingRentals = Rental::where('product_id', $product->id)
                    ->where('status', 'ongoing')
                    ->where(function ($query) use ($start_date, $end_date) {
                        $query->whereBetween('start_date', [$start_date, $end_date])
                            ->orWhereBetween('end_date', [$start_date, $end_date])
                            ->orWhere(function ($q) use ($start_date, $end_date) {
                                $q->where('start_date', '<=', $start_date)
                                    ->where('end_date', '>=', $end_date);
                            });
                    })
                    ->exists();

                if ($overlappingRentals) {
                    throw new \Exception('Produk sudah disewa pada rentang tanggal tersebut.');
                }

                // Cek stok
                if ($product->stock <= 0) {
                    throw new \Exception('Stok produk tidak cukup.');
                }

                // Hitung total_price
                $duration = $start_date->diffInDays($end_date);
                $total_price = $product->price * $duration;

                // Buat rental
                $rental = Rental::create([
                    'customer_name' => $request->customer_name,
                    'customer_email' => $request->customer_email,
                    'customer_phone' => $request->customer_phone,
                    'product_id' => $request->product_id,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'total_price' => $total_price,
                    'status' => 'ongoing',
                ]);

                // Kurangi stok
                $product->decrement('stock');

                return $rental;
            });

            return redirect('/rentals')->with('success', 'Rental berhasil ditambahkan.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withErrors(['product_id' => 'Produk tidak ditemukan.']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit(Rental $rental)
    {
        if (Auth::user()->role === 'admin' && in_array($rental->status, ['completed', 'canceled'])) {
            return redirect()->back()->withErrors(['error' => 'Rental ini sudah selesai atau dibatalkan, Anda tidak dapat mengeditnya. Hubungi Super User untuk perubahan.']);
        }

        $products = Product::active()
            ->where(function ($query) use ($rental) {
                $query->where('stock', '>', 0)
                    ->orWhere('id', $rental->product_id);
            })
            ->with('primaryImage')
            ->get();

        return view('rentals.edit', compact('rental', 'products'));
    }

    public function update(Request $request, Rental $rental)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email',
            'customer_phone' => 'nullable|string|max:15',
            'product_id' => 'required|exists:products,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:pending,ongoing,completed,canceled',
        ]);

        try {
            // Gunakan transaksi untuk mencegah race condition
            $rental = DB::transaction(function () use ($request, $rental) {
                $product = Product::lockForUpdate()->findOrFail($request->product_id);

                if ($product->status !== 'active') {
                    throw new \Exception('Produk yang dipilih tidak aktif.');
                }

                // Cek tanggal bertabrakan (kecuali untuk rental ini sendiri)
                $start_date = \Carbon\Carbon::parse($request->start_date);
                $end_date = \Carbon\Carbon::parse($request->end_date);
                $overlappingRentals = Rental::where('product_id', $product->id)
                    ->where('status', 'ongoing')
                    ->where('id', '!=', $rental->id)
                    ->where(function ($query) use ($start_date, $end_date) {
                        $query->whereBetween('start_date', [$start_date, $end_date])
                            ->orWhereBetween('end_date', [$start_date, $end_date])
                            ->orWhere(function ($q) use ($start_date, $end_date) {
                                $q->where('start_date', '<=', $start_date)
                                    ->where('end_date', '>=', $end_date);
                            });
                    })
                    ->exists();

                if ($overlappingRentals) {
                    throw new \Exception('Produk sudah disewa pada rentang tanggal tersebut.');
                }

                // Atur stok berdasarkan perubahan status atau produk
                if ($rental->status === 'ongoing') {
                    if (in_array($request->status, ['completed', 'canceled'])) {
                        $rental->product->increment('stock');
                    } elseif ($rental->product_id !== $request->product_id) {
                        $rental->product->increment('stock');
                        // Cek stok produk baru sebelum decrement
                        if ($product->stock <= 0) {
                            throw new \Exception('Stok produk yang dipilih tidak cukup.');
                        }
                        $product->decrement('stock');
                    }
                } elseif ($rental->status === 'pending') {
                    if ($request->status === 'ongoing') {
                        if ($product->stock <= 0) {
                            throw new \Exception('Stok produk yang dipilih tidak cukup.');
                        }
                        $product->decrement('stock');
                    }
                } elseif (in_array($rental->status, ['completed', 'canceled'])) {
                    if ($request->status === 'ongoing') {
                        if ($product->stock <= 0) {
                            throw new \Exception('Stok produk yang dipilih tidak cukup.');
                        }
                        $product->decrement('stock');
                    }
                }

                // Hitung total_price
                $duration = $start_date->diffInDays($end_date);
                $total_price = $product->price * $duration;

                // Update rental
                $rental->update([
                    'customer_name' => $request->customer_name,
                    'customer_email' => $request->customer_email,
                    'customer_phone' => $request->customer_phone,
                    'product_id' => $request->product_id,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'total_price' => $total_price,
                    'status' => $request->status,
                ]);

                return $rental;
            });

            return redirect('/rentals')->with('success', 'Rental berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Rental $rental)
    {
        // Blokir penghapusan kalau status completed atau canceled
        if (in_array($rental->status, ['completed', 'canceled'])) {
            return redirect()->back()->withErrors(['error' => 'Rental yang sudah selesai atau dibatalkan tidak dapat dihapus.']);
        }

        if ($rental->status === 'ongoing') {
            $rental->product->increment('stock');
        }

        $rental->delete();

        return redirect('/rentals')->with('success', 'Rental berhasil dihapus.');
    }

    public function createPublic()
    {
        $products = Product::active()->where('stock', '>', 0)->with('primaryImage')->get();
        return view('welcome', compact('products'));
    }

    public function storePublic(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email',
            'customer_phone' => 'nullable|string|max:15',
            'product_id' => 'required|exists:products,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        try {
            // Gunakan transaksi untuk mencegah race condition
            $rental = DB::transaction(function () use ($request) {
                $product = Product::lockForUpdate()->findOrFail($request->product_id);

                if ($product->status !== 'active') {
                    throw new \Exception('Produk yang dipilih tidak aktif.');
                }

                // Cek tanggal bertabrakan
                $start_date = \Carbon\Carbon::parse($request->start_date);
                $end_date = \Carbon\Carbon::parse($request->end_date);
                $overlappingRentals = Rental::where('product_id', $product->id)
                    ->where('status', 'ongoing')
                    ->where(function ($query) use ($start_date, $end_date) {
                        $query->whereBetween('start_date', [$start_date, $end_date])
                            ->orWhereBetween('end_date', [$start_date, $end_date])
                            ->orWhere(function ($q) use ($start_date, $end_date) {
                                $q->where('start_date', '<=', $start_date)
                                    ->where('end_date', '>=', $end_date);
                            });
                    })
                    ->exists();

                if ($overlappingRentals) {
                    throw new \Exception('Produk sudah disewa pada rentang tanggal tersebut.');
                }

                // Cek stok
                if ($product->stock <= 0) {
                    throw new \Exception('Stok produk tidak cukup.');
                }

                // Hitung total_price
                $duration = $start_date->diffInDays($end_date);
                $total_price = $product->price * $duration;

                // Buat rental
                $rental = Rental::create([
                    'customer_name' => $request->customer_name,
                    'customer_email' => $request->customer_email,
                    'customer_phone' => $request->customer_phone,
                    'product_id' => $request->product_id,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'total_price' => $total_price,
                    'status' => 'ongoing',
                ]);

                // Kurangi stok
                $product->decrement('stock');

                return $rental;
            });

            return redirect('/')->with('success', 'Rental berhasil ditambahkan. Silakan login untuk melihat detail.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withErrors(['product_id' => 'Produk tidak ditemukan.']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
