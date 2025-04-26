@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-12">
    <h1 class="fw-bold fs-3 mb-4">Detail Produk: {{ $product->name }}</h1>
    <div class="card shadow-sm">
      <div class="card-body">
        <div class="mb-4">
          <h5 class="font-semibold">Nama Produk</h5>
          <p>{{ $product->name }}</p>
        </div>
        <div class="mb-4">
          <h5 class="font-semibold">Kategori</h5>
          <p>{{ $product->category ? $product->category->name : 'Kategori Tidak Ditemukan' }}</p>
        </div>
        <div class="mb-4">
          <h5 class="font-semibold">Harga Sewa (per hari)</h5>
          <p>Rp {{ number_format($product->price, 0, ',', '.') }}</p>
        </div>
        <div class="mb-4">
          <h5 class="font-semibold">Stok</h5>
          <p>{{ $product->stock }}</p>
        </div>
        <div class="mb-4">
          <h5 class="font-semibold">Deskripsi</h5>
          <p>{{ $product->description ?? 'Tidak ada deskripsi.' }}</p>
        </div>
        <div class="mb-4">
          <h5 class="font-semibold">Status</h5>
          <span class="badge {{ $product->status === 'active' ? 'bg-success' : 'bg-danger' }}">
            {{ $product->status === 'active' ? 'Aktif' : 'Non-Aktif' }}
          </span>
        </div>
        <div class="mb-4">
          <h5 class="font-semibold">Gambar Produk</h5>
          @if($product->images->count() > 0)
          <div class="flex flex-wrap gap-4">
            @foreach($product->images as $image)
            <div class="relative">
              <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}"
                class="max-w-[150px] h-auto rounded-lg">
              @if($image->is_primary)
              <span class="absolute top-0 right-0 bg-green-500 text-white text-xs px-2 py-1 rounded">Utama</span>
              @endif
            </div>
            @endforeach
          </div>
          @else
          <p>Tidak ada gambar.</p>
          @endif
        </div>
        <div class="flex space-x-3">
          <a href="{{ route('products.edit', $product) }}" class="btn btn-warning px-4 py-2">Edit</a>
          <a href="{{ route('products.index') }}" class="btn btn-secondary px-4 py-2">Kembali</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection