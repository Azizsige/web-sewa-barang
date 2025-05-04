@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <h1 class="mb-4 fw-bold fs-3">Daftar Kategori Produk</h1>
      <div class="flex justify-between mb-4">
        <a href="{{ route('categories.create') }}" class="px-4 py-2 btn btn-primary">Tambah Kategori</a>
        <div>
          <form method="GET" action="{{ route('categories.index') }}" class="flex space-x-2" id="filter-form">
            <input type="text" name="keyword" class="form-control" placeholder="Cari kategori..."
              value="{{ request()->query('keyword', '') }}" oninput="debounceSubmit()">
            <select name="per_page" id="per-page-filter" class="form-select" onchange="this.form.submit()">
              <option value="5" {{ $perPage==5 ? 'selected' : '' }}>Tampilkan 5</option>
              <option value="10" {{ $perPage==10 ? 'selected' : '' }}>Tampilkan 10</option>
              <option value="15" {{ $perPage==15 ? 'selected' : '' }}>Tampilkan 15</option>
              <option value="25" {{ $perPage==25 ? 'selected' : '' }}>Tampilkan 25</option>
            </select>
          </form>
        </div>
      </div>
      @if($categories->count() > 0)
      <div class="shadow-sm card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table mb-0 align-middle text-nowrap">
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
                @foreach($categories as $index => $category)
                <tr>
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
                      class="inline delete-form" data-category-name="{{ $category->name }}">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="mt-4">
            {{ $categories->links() }}
          </div>
        </div>
      </div>
      @else
      <div class="shadow-sm card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table mb-0 align-middle text-nowrap">
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
                <tr>
                  <td colspan="7" class="text-center">Belum ada kategori.</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      @endif
    </div>
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