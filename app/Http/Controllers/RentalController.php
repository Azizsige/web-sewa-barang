<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'nullable|string|max:15',
            'product_id' => 'required|exists:products,id',
            'start_date' => 'required|date|after_or_equal:today',
            'duration' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        if ($product->status !== 'active') {
            return redirect()->back()->with('error', 'Produk yang dipilih tidak aktif.')->withInput();
        }

        $total_price = $product->price * $validated['duration'];

        $rentalData = array_merge($validated, [
            'total_price' => $total_price,
            'status' => 'ongoing',
        ]);

        $rental = Rental::create($rentalData);

        $product->decrement('stock');

        return redirect()->route('rentals.index')->with('success', 'Rental berhasil ditambahkan.');
    }

    public function edit(Rental $rental)
    {
        $userRole = auth()->user()->role;

        if ($userRole === 'admin' && in_array($rental->status, ['completed', 'canceled'])) {
            return redirect()->route('rentals.index')->with('error', 'Rental ini sudah selesai atau dibatalkan, Anda tidak dapat mengeditnya. Hubungi Super User untuk perubahan.');
        }

        $products = Product::active()->where('stock', '>', 0)->orWhere('id', $rental->product_id)->with('primaryImage')->get();
        return view('rentals.edit', compact('rental', 'products'));
    }

    public function update(Request $request, Rental $rental)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'nullable|string|max:15',
            'product_id' => 'required|exists:products,id',
            'start_date' => 'required|date',
            'duration' => 'required|integer|min:1',
            'status' => 'required|in:pending,ongoing,completed,canceled',
        ]);

        $oldProductId = $rental->product_id;
        $oldStatus = $rental->status;
        $newStatus = $validated['status'];
        $newProductId = $validated['product_id'];

        $product = Product::findOrFail($newProductId);
        if ($product->status !== 'active') {
            return redirect()->back()->with('error', 'Produk yang dipilih tidak aktif.')->withInput();
        }

        $validated['total_price'] = $product->price * $validated['duration'];

        if ($oldStatus === 'ongoing') {
            if ($newStatus === 'completed' || $newStatus === 'canceled') {
                Product::findOrFail($oldProductId)->increment('stock');
            } elseif ($oldProductId !== $newProductId) {
                Product::findOrFail($oldProductId)->increment('stock');
                Product::findOrFail($newProductId)->decrement('stock');
            }
        } elseif ($oldStatus === 'pending' && $newStatus === 'ongoing') {
            Product::findOrFail($newProductId)->decrement('stock');
        } elseif ($oldStatus === 'pending' && $newStatus === 'canceled') {
            // Tidak perlu ubah stok
        } elseif (in_array($oldStatus, ['completed', 'canceled']) && $newStatus === 'ongoing') {
            Product::findOrFail($newProductId)->decrement('stock');
        }

        $rental->update($validated);

        return redirect()->route('rentals.index')->with('success', 'Rental berhasil diperbarui.');
    }

    public function destroy(Rental $rental)
    {
        if ($rental->status === 'ongoing') {
            $rental->product->increment('stock');
        }

        $rental->delete();

        return redirect()->route('rentals.index')->with('success', 'Rental berhasil dihapus.');
    }
}
