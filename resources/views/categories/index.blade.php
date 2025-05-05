@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="flex items-center justify-between mb-3">
        <h1 class="mb-3 fw-bold fs-6">Daftar Kategori Produk</h1>
        <div class="flex mb-3 space-x-3">
          <a href="{{ route('categories.create') }}" class="btn btn-primary">Tambah Kategori</a>
        </div>
      </div>
      <div class="mb-4 shadow-sm card">
        <div class="card-body">
          <form method="GET" action="{{ route('categories.index') }}" class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4"
            id="filter-form">
            <div>
              <label for="keyword" class="block mb-2 text-sm font-medium text-gray-700">Cari</label>
              <input type="text" name="keyword" id="keyword" class="w-full form-control"
                value="{{ request('keyword') }}" placeholder="Masukkan nama kategori">
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
              <a href="{{ route('categories.index') }}" class="px-4 py-2 btn btn-secondary">Reset Filter</a>
            </div>
          </form>
        </div>
      </div>
      <div class="shadow-sm card">
        <div class="p-4 card-body">
          <div class="table-responsive">
            <table class="table mb-0 align-middle text-nowrap" id="category-table">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Gambar</th>
                  <th>Nama Kategori</th>
                  <th>Slug</th>
                  <th>Deskripsi</th>
                  <th>Jumlah Produk</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($categories as $index => $category)
                <tr data-category-id="{{ $category->id }}">
                  <td>{{ $categories->firstItem() + $index }}</td>
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
                      class="inline delete-form" data-category-name="{{ $category->name }}"
                      data-category-id="{{ $category->id }}">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="7" class="text-center">Belum ada kategori.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          <div class="mt-3">
            {{ $categories->links() }}
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
    const perPageSelect = document.getElementById('per_page');
    const searchInput = document.getElementById('keyword');

    // Event listener untuk select per_page
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

    // Handle hapus kategori via AJAX
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
      form.addEventListener('submit', function (event) {
        event.preventDefault();

        const categoryName = form.getAttribute('data-category-name');
        const categoryId = form.getAttribute('data-category-id');
        const url = form.getAttribute('action');
        const token = document.querySelector('meta[name="csrf-token"]')?.content || form.querySelector('input[name="_token"]').value;

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
            Swal.fire({
              title: 'Menghapus...',
              text: 'Harap tunggu, sedang menghapus kategori.',
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
                const row = document.querySelector(`tr[data-category-id="${categoryId}"]`);
                if (row) row.remove();

                const tbody = document.querySelector('#category-table tbody');
                if (tbody.children.length === 0) {
                  tbody.innerHTML = '<tr><td colspan="7" class="text-center">Belum ada kategori.</td></tr>';
                }

                Swal.fire({
                  title: 'Berhasil!',
                  text: data.message || 'Kategori berhasil dihapus.',
                  icon: 'success',
                  confirmButtonText: 'OK'
                });
              } else {
                Swal.fire({
                  title: 'Gagal!',
                  text: data.message || 'Terjadi kesalahan saat menghapus kategori.',
                  icon: 'error',
                  confirmButtonText: 'OK'
                });
              }
            })
            .catch(error => {
              Swal.close();
              console.error('Error:', error);

              let errorMessage = 'Terjadi kesalahan saat menghapus kategori. Silakan coba lagi.';
              if (error.message) {
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