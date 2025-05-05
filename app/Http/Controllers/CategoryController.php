<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->query('keyword', '');
        $perPage = $request->query('per_page', 10);

        $query = Category::withCount('products');

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('slug', 'like', '%' . $keyword . '%');
            });
        }

        $query->orderBy('created_at', 'desc');
        $categories = $query->paginate($perPage);
        $categories->appends(['keyword' => $keyword, 'per_page' => $perPage]);

        return view('categories.index', compact('categories', 'keyword', 'perPage'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:1000',
            'image' => 'required|image|mimes:jpeg,png,gif|max:2048',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.max' => 'Nama kategori maksimal 255 karakter.',
            'name.unique' => 'Nama kategori sudah digunakan. Silakan gunakan nama lain.',
            'description.max' => 'Deskripsi maksimal 1000 karakter.',
            'image.required' => 'Gambar kategori wajib diunggah.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Hanya file gambar (jpg, png, gif) yang diperbolehkan.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        $category = Category::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'image' => $imagePath,
        ]);

        if (auth()->check() && auth()->user()->role === 'admin') {
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'created',
                'model_type' => 'Category',
                'model_id' => $category->id,
                'description' => 'Admin ' . auth()->user()->name . ' menambah category ' . $category->name,
            ]);
        }

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,gif|max:2048',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.max' => 'Nama kategori maksimal 255 karakter.',
            'name.unique' => 'Nama kategori sudah digunakan. Silakan gunakan nama lain.',
            'description.max' => 'Deskripsi maksimal 500 karakter.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Hanya file gambar (jpg, png, gif) yang diperbolehkan.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];

        $oldCategory = $category->replicate();
        if ($request->hasFile('image')) {
            if ($category->image) {
                \Storage::disk('public')->delete($category->image);
            }
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);
        $newCategory = $category->refresh();

        if (auth()->check() && auth()->user()->role === 'admin') {
            $changes = array_diff_assoc($newCategory->getAttributes(), $oldCategory->getAttributes());
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'updated',
                'model_type' => 'Category',
                'model_id' => $category->id,
                'old_values' => array_intersect_key($oldCategory->getAttributes(), $changes),
                'new_values' => array_intersect_key($newCategory->getAttributes(), $changes),
                'description' => 'Admin ' . auth()->user()->name . ' mengedit category ' . $category->name,
            ]);
        }

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->exists()) {
            return redirect()->route('categories.index')->with('error', 'Kategori tidak bisa dihapus karena masih ada produk terkait.');
        }

        if ($category->image) {
            \Storage::disk('public')->delete($category->image);
        }

        if (auth()->check() && auth()->user()->role === 'admin') {
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'deleted',
                'model_type' => 'Category',
                'model_id' => $category->id,
                'description' => 'Admin ' . auth()->user()->name . ' menghapus category ' . $category->name,
            ]);
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
