<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $statusFilter = $request->query('status', 'all');
        $query = Product::with('category', 'primaryImage');

        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        $products = $query->get();
        return view('products.index', compact('products', 'statusFilter'));
    }

    public function create()
    {
        $categories = Category::all();
        Log::info('ProductController@create: Categories count', ['count' => $categories->count()]);
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        Log::info('ProductController@store: Request data', $request->all());

        try {
            $validated = $request->validate([
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255|unique:products,name',
                'slug' => 'required|string|max:255|unique:products,slug',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'images.*' => 'required|image|mimes:jpeg,png,gif|max:2048',
                'is_bundle' => 'nullable|boolean',
                'status' => 'required|in:active,inactive',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('ProductController@store: Validation failed', ['errors' => $e->errors()]);
            throw $e;
        }

        Log::info('ProductController@store: Validated data', $validated);

        if (!isset($validated['category_id'])) {
            Log::error('ProductController@store: category_id is missing in validated data');
            return redirect()->back()->with('error', 'Kategori wajib dipilih.')->withInput();
        }
        if (!isset($validated['price'])) {
            Log::error('ProductController@store: price is missing in validated data');
            return redirect()->back()->with('error', 'Harga wajib diisi.')->withInput();
        }
        if (!isset($validated['stock'])) {
            Log::error('ProductController@store: stock is missing in validated data');
            return redirect()->back()->with('error', 'Stok wajib diisi.')->withInput();
        }
        if (!$request->hasFile('images')) {
            Log::error('ProductController@store: images are missing in request');
            return redirect()->back()->with('error', 'Setidaknya satu gambar wajib diunggah.')->withInput();
        }

        $validated['id'] = Str::uuid()->toString();
        $validated['is_bundle'] = $request->has('is_bundle') ? 1 : 0;

        Log::info('ProductController@store: Data to insert', $validated);

        $product = Product::create($validated);

        // Simpan multiple gambar
        $images = $request->file('images');
        foreach ($images as $index => $image) {
            $path = $image->store('product_images', 'public');
            ProductImage::create([
                'id' => Str::uuid()->toString(),
                'product_id' => $product->id,
                'image_path' => $path,
                'is_primary' => $index === 0,
                'order' => $index, // Set order berdasarkan urutan upload
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show($slug)
    {
        $product = Product::with('images')->where('slug', $slug)->firstOrFail();
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('images');
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255|unique:products,name,' . $product->id,
            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,gif|max:2048',
            'is_bundle' => 'nullable|boolean',
            'status' => 'required|in:active,inactive',
            'primary_image_id' => 'nullable|exists:product_images,id',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:product_images,id',
        ]);

        $validated['is_bundle'] = $request->has('is_bundle') ? 1 : 0;
        $product->update($validated);

        // Hapus gambar yang dipilih
        if ($request->has('delete_images')) {
            $deleteImages = $request->input('delete_images');
            $imagesToDelete = ProductImage::whereIn('id', $deleteImages)->where('product_id', $product->id)->get();
            foreach ($imagesToDelete as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
        }

        // Upload gambar baru
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $hasPrimary = $product->images()->where('is_primary', true)->exists();
            $maxOrder = $product->images()->max('order') ?? -1;
            foreach ($images as $index => $image) {
                $path = $image->store('product_images', 'public');
                ProductImage::create([
                    'id' => Str::uuid()->toString(),
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => !$hasPrimary && $index === 0,
                    'order' => $maxOrder + 1 + $index, // Tambah di urutan terakhir
                ]);
            }
        }

        // Update primary image
        if ($request->filled('primary_image_id')) {
            $product->images()->update(['is_primary' => false]);
            $product->images()->where('id', $request->input('primary_image_id'))->update(['is_primary' => true]);
        }

        // Reorder images after deletion
        $remainingImages = $product->images()->orderBy('order')->get();
        foreach ($remainingImages as $index => $image) {
            $image->update(['order' => $index]);
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function toggleStatus(Request $request, Product $product)
    {
        $newStatus = $product->status === 'active' ? 'inactive' : 'active';
        $product->update(['status' => $newStatus]);

        return response()->json([
            'success' => true,
            'message' => 'Status produk berhasil diubah.',
            'new_status' => $newStatus,
        ], 200);
    }

    public function updateImageOrder(Request $request, Product $product)
    {
        $request->validate([
            'image_ids' => 'required|array',
            'image_ids.*' => 'exists:product_images,id',
        ]);

        $imageIds = $request->input('image_ids');

        // Pastikan semua image_ids milik produk ini
        $images = ProductImage::where('product_id', $product->id)
            ->whereIn('id', $imageIds)
            ->get();

        if ($images->count() !== count($imageIds)) {
            return response()->json([
                'success' => false,
                'message' => 'Beberapa gambar tidak ditemukan atau tidak sesuai dengan produk ini.',
            ], 400);
        }

        // Update urutan berdasarkan array image_ids
        foreach ($imageIds as $index => $imageId) {
            ProductImage::where('id', $imageId)
                ->where('product_id', $product->id)
                ->update(['order' => $index]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Urutan gambar berhasil diperbarui.',
        ], 200);
    }
}
