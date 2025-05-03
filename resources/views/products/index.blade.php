@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4 fw-bold fs-3">Daftar Produk</h1>
        <div class="flex justify-between mb-4">
            <a href="{{ route('products.create') }}" class="px-4 py-2 btn btn-primary">Tambah Produk</a>
            <div>
                <form method="GET" action="{{ route('products.index') }}" class="flex space-x-2" id="filter-form">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari produk..."
                        value="{{ request()->query('keyword', '') }}" oninput="debounceSubmit()">
                    <select name="status" id="status-filter" class="form-select" onchange="this.form.submit()">
                        <option value="all" {{ $statusFilter==='all' ? 'selected' : '' }}>Semua Status</option>
                        <option value="active" {{ $statusFilter==='active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ $statusFilter==='inactive' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                    <select name="category_id" id="category-filter" class="form-select" onchange="this.form.submit()">
                        <option value="all" {{ $categoryId==='all' ? 'selected' : '' }}>Semua Kategori</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $categoryId===$category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    <select name="per_page" id="per-page-filter" class="form-select" onchange="this.form.submit()">
                        <option value="5" {{ $perPage==5 ? 'selected' : '' }}>Tampilkan 5</option>
                        <option value="10" {{ $perPage==10 ? 'selected' : '' }}>Tampilkan 10</option>
                        <option value="15" {{ $perPage==15 ? 'selected' : '' }}>Tampilkan 15</option>
                        <option value="25" {{ $perPage==25 ? 'selected' : '' }}>Tampilkan 25</option>
                    </select>
                </form>
            </div>
        </div>
        @if($products->count() > 0)
        <div class="shadow-sm card">
            <div class="card-body">
                <table class="table table-bordered" id="product-table">
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
                        @foreach($products as $index => $product)
                        <tr data-product-id="{{ $product->id }}">
                            <td>{{ $products->firstItem() + $index }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category ? $product->category->name : 'Kategori Tidak Ditemukan' }}</td>
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
                                <span class="badge {{ $product->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $product->status === 'active' ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </td>
                            <td>
                                <div class="space-x-2 d-flex">
                                    <a href="{{ route('products.edit', $product) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <button type="button"
                                        class="btn btn-sm {{ $product->status === 'active' ? 'btn-secondary' : 'btn-success' }} toggle-status"
                                        data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}"
                                        data-current-status="{{ $product->status }}">
                                        {{ $product->status === 'active' ? 'Non-Aktifkan' : 'Aktifkan' }}
                                    </button>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST"
                                        class="delete-form" data-product-name="{{ $product->name }}"
                                        data-product-id="{{ $product->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Tambah keterangan total data dan showing data -->
                <div class="mt-4">
                    {{-- <p class="text-muted">
                        Total: {{ $products->total() }} produk
                    </p>
                    <p class="text-muted">
                        Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }}
                    </p> --}}
                    {{ $products->links() }}
                </div>
            </div>
        </div>
        @else
        <div class="shadow-sm card">
            <div class="card-body">
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
                            <tr>
                                <td colspan="8" class="text-center">Belum ada produk.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Fungsi debounce untuk input keyword
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Submit form dengan debounce untuk input keyword
    const debounceSubmit = debounce(() => {
        document.getElementById('filter-form').submit();
    }, 500);

    document.addEventListener('DOMContentLoaded', function () {
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
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
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
                                throw new Error(data.message || 'Terjadi kesalahan saat menghapus produk.');
                            }
                        })
                        .catch(error => {
                            Swal.close();
                            console.error('Error:', error);

                            let errorMessage = 'Terjadi kesalahan saat menghapus produk. Silakan coba lagi atau hubungi admin.';
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
                            },
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

        // Handle flash message untuk create dan edit produk
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