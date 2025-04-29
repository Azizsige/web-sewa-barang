@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <h1 class="fw-bold fs-3">Daftar Kategori Produk</h1>
      <a href="{{ route('categories.create') }}" class="mb-3 btn btn-primary">Tambah Kategori</a>
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table mb-0 align-middle text-nowrap">
              <thead>
                <tr>
                  <th>Gambar</th>
                  <th>Nama Kategori</th>
                  <th>Slug</th>
                  <th>Deskripsi</th>
                  <th>Jumlah Produk</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($categories as $category)
                <tr>
                  <td>
                    @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                      class="object-cover w-12 h-12 rounded">
                    @else
                    <span>-</span>
                    @endif
                  </td>
                  <td>{{ $category->name }}</td>
                  <td>{{ $category->slug }}</td>
                  <td>{{ $category->description ?? '-' }}</td>
                  <td>{{ $category->products_count }} produk</td>
                  <td>
                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                      class="inline delete-form" data-category-name="{{ $category->name }}">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" class="text-center">Belum ada kategori.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Konfirmasi delete dengan SweetAlert
    const deleteForms = document.querySelectorAll('.delete-form');

    deleteForms.forEach(form => {
        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent form dari submit langsung

            // Ambil nama kategori dari data attribute
            const categoryName = form.getAttribute('data-category-name');

            // Tampilkan SweetAlert konfirmasi
            Swal.fire({
                title: `Hapus Kategori "${categoryName}"?`,
                text: "Kategori yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan SweetAlert loading
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Harap tunggu, sedang menghapus kategori.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Submit form setelah loading muncul
                    form.submit();
                }
            });
        });
    });

    // Tampilkan SweetAlert untuk pesan sukses
    @if (session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    @endif

    // Tampilkan SweetAlert untuk pesan error
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