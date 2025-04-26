@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="fw-bold fs-3 mb-4">Daftar Produk</h1>
        <div class="mb-4 flex justify-between">
            <a href="{{ route('products.create') }}" class="btn btn-primary px-4 py-2">Tambah Produk</a>
            <div>
                <form method="GET" action="{{ route('products.index') }}" class="flex space-x-2">
                    <select name="status" id="status-filter" class="form-select">
                        <option value="all" {{ $statusFilter==='all' ? 'selected' : '' }}>Semua Status</option>
                        <option value="active" {{ $statusFilter==='active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ $statusFilter==='inactive' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                    <button type="submit" class="btn btn-primary px-4 py-2">Filter</button>
                </form>
            </div>
        </div>
        @if($products->count() > 0)
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered">
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
                        <tr>
                            <td>{{ $index + 1 }}</td>
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
                                <div class="d-flex space-x-2">
                                    <a href="{{ route('products.edit', $product) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <button type="button"
                                        class="btn btn-sm {{ $product->status === 'active' ? 'btn-secondary' : 'btn-success' }} toggle-status"
                                        data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}"
                                        data-current-status="{{ $product->status }}">
                                        {{ $product->status === 'active' ? 'Non-Aktifkan' : 'Aktifkan' }}
                                    </button>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST"
                                        class="delete-form" data-product-name="{{ $product->name }}">
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
            </div>
        </div>
        @else
        <div class="alert alert-info">
            Belum ada produk. <a href="{{ route('products.create') }}" class="text-blue-500 hover:underline">Tambah
                produk sekarang</a>.
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const deleteForms = document.querySelectorAll('.delete-form');

    deleteForms.forEach(form => {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            const productName = form.getAttribute('data-product-name');

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
                        title: 'Menyimpan...',
                        text: 'Harap tunggu, sedang menghapus produk.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    form.submit();
                }
            });
        });
    });

    const toggleButtons = document.querySelectorAll('.toggle-status');
    toggleButtons.forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-product-id');
            const productName = this.getAttribute('data-product-name');
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