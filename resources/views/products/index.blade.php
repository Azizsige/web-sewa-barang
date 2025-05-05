@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="flex items-center justify-between mb-3">
                <h1 class="mb-3 fw-bold fs-6">Daftar Produk</h1>
                <div class="flex mb-3 space-x-3">
                    <a href="{{ route('products.create') }}" class="btn btn-primary">Tambah Produk</a>
                </div>
            </div>
            <div class="mb-4 shadow-sm card">
                <div class="card-body">
                    <form method="GET" action="{{ route('products.index') }}"
                        class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4" id="filter-form">
                        <div>
                            <label for="keyword" class="block mb-2 text-sm font-medium text-gray-700">Cari</label>
                            <input type="text" name="keyword" id="keyword" class="w-full form-control"
                                value="{{ request('keyword') }}" placeholder="Masukkan nama produk">
                        </div>
                        <div>
                            <label for="status" class="block mb-2 text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" class="w-full form-select">
                                <option value="all" {{ $statusFilter==='all' ? 'selected' : '' }}>Semua Status</option>
                                <option value="active" {{ $statusFilter==='active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ $statusFilter==='inactive' ? 'selected' : '' }}>Non-Aktif
                                </option>
                            </select>
                        </div>
                        <div>
                            <label for="category_id"
                                class="block mb-2 text-sm font-medium text-gray-700">Kategori</label>
                            <select name="category_id" id="category_id" class="w-full form-select">
                                <option value="all" {{ $categoryId==='all' ? 'selected' : '' }}>Semua Kategori</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $categoryId===$category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="per_page" class="block mb-2 text-sm font-medium text-gray-700">Tampilkan</label>
                            <select name="per_page" id="per_page" class="w-full form-select">
                                <option value="5" {{ $perPage==5 ? 'selected' : '' }}>Tampilkan 5</option>
                                <option value="10" {{ $perPage==10 ? 'selected' : '' }}>Tampilkan 10</option>
                                <option value="15" {{ $perPage==15 ? 'selected' : '' }}>Tampilkan 15</option>
                                <option value="25" {{ $perPage==25 ? 'selected' : '' }}>Tampilkan 25</option>
                            </select>
                        </div>
                        <div class="flex space-x-3 md:col-span-4">
                            <a href="{{ route('products.index') }}" class="px-4 py-2 btn btn-secondary">Reset Filter</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="shadow-sm card">
                <div class="p-4 card-body">
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle text-nowrap" id="product-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Harga Sewa (per hari)</th>
                                    <th>Stok</th>
                                    <th>Gambar Utama</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $index => $product)
                                <tr data-product-id="{{ $product->id }}">
                                    <td>{{ $products->firstItem() + $index }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category ? $product->category->name : 'Kategori Tidak Ditemukan' }}
                                    </td>
                                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>
                                        @if($product->primaryImage)
                                        <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                                            alt="{{ $product->name }}" class="img-thumbnail" style="max-width: 100px;">
                                        @else
                                        Tidak Ada Gambar
                                        @endif
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ $product->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $product->status === 'active' ? 'Aktif' : 'Non-Aktif' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="space-x-2 d-flex">
                                            <a href="{{ route('products.edit', $product) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <button type="button"
                                                class="btn btn-sm {{ $product->status === 'active' ? 'btn-secondary' : 'btn-success' }} toggle-status"
                                                data-product-id="{{ $product->id }}"
                                                data-product-name="{{ $product->name }}"
                                                data-current-status="{{ $product->status }}">
                                                {{ $product->status === 'active' ? 'Non-Aktifkan' : 'Aktifkan' }}
                                            </button>
                                            <form action="{{ route('products.destroy', $product) }}" method="POST"
                                                class="inline delete-form" data-product-name="{{ $product->name }}"
                                                data-product-id="{{ $product->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">Belum ada produk.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    // Ambil elemen form dan input-nya
    const filterForm = document.getElementById('filter-form');
    const statusSelect = document.getElementById('status');
    const categorySelect = document.getElementById('category_id');
    const perPageSelect = document.getElementById('per_page');
    const searchInput = document.getElementById('keyword');

    // Event listener untuk select status, category, dan per_page
    statusSelect.addEventListener('change', function() {
      filterForm.submit();
    });
    categorySelect.addEventListener('change', function() {
      filterForm.submit();
    });
    perPageSelect.addEventListener('change', function() {
      filterForm.submit();
    });

    // Event listener untuk input search
    searchInput.addEventListener('input', function() {
      clearTimeout(searchInput.timeout);
      searchInput.timeout = setTimeout(() => {
        filterForm.submit();
      }, 500);
    });

    // Handle hapus produk via AJAX
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
      form.addEventListener('submit', function (event) {
        event.preventDefault();

        const productName = form.getAttribute('data-product-name');
        const productId = form.getAttribute('data-product-id');
        const url = form.getAttribute('action');
        const token = document.querySelector('meta[name="csrf-token"]')?.content || form.querySelector('input[name="_token"]').value;

        Swal.fire({
          title: `Hapus Produk "${productName}"?`,
          text: "Produk yang dihapus tidak dapat dikembalikan!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Ya, Hapus!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire({
              title: 'Menghapus...',
              text: 'Harap tunggu, sedang menghapus produk.',
              allowOutsideClick: false,
              didOpen: () => {
                Swal.showLoading();
              }
            });

            fetch(url, {
              method: 'DELETE',
              headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
              }
            })
            .then(response => {
              if (!response.ok) {
                return response.json().then(errorData => {
                  throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
                });
              }
              return response.json();
            })
            .then(data => {
              Swal.close();

              if (data.success) {
                const row = document.querySelector(`tr[data-product-id="${productId}"]`);
                if (row) row.remove();

                const tbody = document.querySelector('#product-table tbody');
                if (tbody.children.length === 0) {
                  tbody.innerHTML = '<tr><td colspan="8" class="text-center">Belum ada produk.</td></tr>';
                }

                Swal.fire({
                  title: 'Berhasil!',
                  text: data.message || 'Produk berhasil dihapus.',
                  icon: 'success',
                  confirmButtonText: 'OK'
                });
              } else {
                Swal.fire({
                  title: 'Gagal!',
                  text: data.message || 'Terjadi kesalahan saat menghapus produk.',
                  icon: 'error',
                  confirmButtonText: 'OK'
                });
              }
            })
            .catch(error => {
              Swal.close();
              console.error('Error:', error);

              let errorMessage = 'Terjadi kesalahan saat menghapus produk. Silakan coba lagi.';
              if (error.message.includes('masih digunakan di rental aktif')) {
                errorMessage = error.message;
              } else if (error.message) {
                errorMessage = error.message;
              }

              Swal.fire({
                title: 'Gagal!',
                text: errorMessage,
                icon: 'error',
                confirmButtonText: 'OK'
              });
            });
          }
        });
      });
    });

    // Handle toggle status produk
    const toggleButtons = document.querySelectorAll('.toggle-status');
    toggleButtons.forEach(button => {
      button.addEventListener('click', function () {
        const productName = this.getAttribute('data-product-name');
        const productId = this.getAttribute('data-product-id');
        const currentStatus = this.getAttribute('data-current-status');
        const newStatus = currentStatus === 'active' ? 'Non-Aktif' : 'Aktif';

        Swal.fire({
          title: `Ubah Status Produk "${productName}"?`,
          text: `Status produk akan diubah menjadi ${newStatus}.`,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, Ubah!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire({
              title: 'Mengubah status...',
              text: 'Harap tunggu.',
              allowOutsideClick: false,
              didOpen: () => {
                Swal.showLoading();
              }
            });

            fetch(`/products/${productId}/toggle-status`, {
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
              }
            })
            .then(response => {
              if (!response.ok) {
                throw new Error('Network response was not ok');
              }
              return response.json();
            })
            .then(data => {
              if (data.success) {
                Swal.fire({
                  title: 'Berhasil!',
                  text: data.message || 'Status produk berhasil diubah.',
                  icon: 'success',
                  confirmButtonText: 'OK'
                }).then(() => {
                  location.reload();
                });
              } else {
                throw new Error(data.message || 'Gagal mengubah status.');
              }
            })
            .catch(error => {
              Swal.fire({
                title: 'Gagal!',
                text: error.message || 'Terjadi kesalahan saat mengubah status.',
                icon: 'error',
                confirmButtonText: 'OK'
              });
              console.error('Error:', error);
            });
          }
        });
      });
    });

    @if (session('success'))
    Swal.fire({
      title: 'Berhasil!',
      text: '{{ session('success') }}',
      icon: 'success',
      confirmButtonText: 'OK'
    });
    @endif

    @if (session('error'))
    Swal.fire({
      title: 'Gagal!',
      text: '{{ session('error') }}',
      icon: 'error',
      confirmButtonText: 'OK'
    });
    @endif
  });
</script>
@endsection