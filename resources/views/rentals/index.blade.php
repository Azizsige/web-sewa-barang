@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="flex items-center justify-between mb-3">
        <h1 class="mb-3 fw-bold fs-6">Daftar Riwayat Rental</h1>
        <div class="flex mb-3 space-x-3">
          <a href="{{ route('rentals.create') }}" class="btn btn-primary">Tambah Rental</a>
          <a href="{{ route('rentals.export') }}?{{ http_build_query(request()->query()) }}"
            class="btn btn-success">Export ke Excel</a>
        </div>
      </div>
      <div class="mb-4 card">
        <div class="card-body">
          <form method="GET" action="{{ route('rentals.index') }}" class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4"
            id="filter-form">
            <div>
              <label for="status" class="block mb-2 text-sm font-medium text-gray-700">Status</label>
              <select name="status" id="status" class="w-full form-select">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status')==='pending' ? 'selected' : '' }}>Pending</option>
                <option value="ongoing" {{ request('status')==='ongoing' ? 'selected' : '' }}>Sedang Disewa</option>
                <option value="completed" {{ request('status')==='completed' ? 'selected' : '' }}>Selesai</option>
                <option value="canceled" {{ request('status')==='canceled' ? 'selected' : '' }}>Dibatalkan</option>
              </select>
            </div>
            <div>
              <label for="search" class="block mb-2 text-sm font-medium text-gray-700">Cari</label>
              <input type="text" name="search" id="search" class="w-full form-control" value="{{ request('search') }}"
                placeholder="Masukkan nama atau kode rental">
            </div>
            <div>
              <label for="date_from" class="block mb-2 text-sm font-medium text-gray-700">Tanggal Mulai (Dari)</label>
              <input type="text" name="date_from" id="date_from" class="w-full form-control datepicker"
                value="{{ request('date_from') }}" placeholder="Pilih tanggal">
            </div>
            <div>
              <label for="date_to" class="block mb-2 text-sm font-medium text-gray-700">Tanggal Mulai (Sampai)</label>
              <input type="text" name="date_to" id="date_to" class="w-full form-control datepicker"
                value="{{ request('date_to') }}" placeholder="Pilih tanggal">
            </div>
            <div class="flex space-x-3 md:col-span-4">
              <a href="{{ route('rentals.index') }}" class="px-4 py-2 btn btn-secondary">Reset Filter</a>
            </div>
          </form>
        </div>
      </div>
      <div class="card">
        <div class="p-4 card-body">
          <div class="table-responsive">
            <table class="table mb-0 align-middle text-nowrap" id="rental-table">
              <thead>
                <tr>
                  <th>Kode Rental</th>
                  <th>Nama Penyewa</th>
                  <th>Produk</th>
                  <th>Tanggal Mulai</th>
                  <th>Durasi (Hari)</th>
                  <th>Tanggal Selesai</th>
                  <th>Total Harga</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($rentals as $rental)
                <tr data-rental-id="{{ $rental->id }}">
                  <td>{{ $rental->rental_code }}</td>
                  <td>{{ $rental->customer_name }}</td>
                  <td>{{ $rental->product->name }}</td>
                  <td>{{ \Carbon\Carbon::parse($rental->start_date)->format('d M Y') }}</td>
                  <td>{{ $rental->duration }}</td>
                  <td>{{ \Carbon\Carbon::parse($rental->end_date)->format('d M Y') }}</td>
                  <td>Rp {{ number_format($rental->total_price, 0, ',', '.') }}</td>
                  <td>
                    @if($rental->status === 'pending')
                    <span class="badge bg-warning">Pending</span>
                    @elseif($rental->status === 'ongoing')
                    <span class="badge bg-info">Sedang Disewa</span>
                    @elseif($rental->status === 'completed')
                    <span class="badge bg-success">Selesai</span>
                    @elseif($rental->status === 'canceled')
                    <span class="badge bg-danger">Dibatalkan</span>
                    @endif
                  </td>
                  <td>
                    <a href="{{ route('rentals.show', $rental) }}" class="btn btn-sm btn-info">Detail</a>
                    <a href="{{ route('rentals.edit', $rental) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('rentals.destroy', $rental->id) }}" method="POST" class="inline delete-form"
                      data-rental-code="{{ $rental->rental_code }}" data-rental-id="{{ $rental->id }}">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="9" class="text-center">Belum ada riwayat rental.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          <div class="mt-3">
            {{ $rentals->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Inisialisasi Flatpickr untuk datepicker
    flatpickr('.datepicker', {
      dateFormat: 'Y-m-d',
      maxDate: 'today',
      onChange: function(selectedDates, dateStr, instance) {
        // Submit form otomatis pas tanggal berubah
        document.getElementById('filter-form').submit();
      }
    });

    // Ambil elemen form dan input-nya
    const filterForm = document.getElementById('filter-form');
    const statusSelect = document.getElementById('status');
    const searchInput = document.getElementById('search');

    // Event listener untuk select status
    statusSelect.addEventListener('change', function() {
      filterForm.submit();
    });

    // Event listener untuk input search
    searchInput.addEventListener('input', function() {
      // Tambah sedikit delay biar nggak terlalu agresif submit
      clearTimeout(searchInput.timeout);
      searchInput.timeout = setTimeout(() => {
        filterForm.submit();
      }, 500); // Delay 500ms
    });

    // Event listener untuk tombol hapus
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
      form.addEventListener('submit', function (event) {
        event.preventDefault();

        const rentalCode = form.getAttribute('data-rental-code');
        const rentalId = form.getAttribute('data-rental-id');
        const url = form.getAttribute('action');
        const token = document.querySelector('meta[name="csrf-token"]')?.content || form.querySelector('input[name="_token"]').value;

        Swal.fire({
          title: `Hapus Rental "${rentalCode}"?`,
          text: "Rental yang dihapus tidak dapat dikembalikan!",
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
              text: 'Harap tunggu, sedang menghapus rental.',
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
                const row = document.querySelector(`tr[data-rental-id="${rentalId}"]`);
                if (row) row.remove();

                const tbody = document.querySelector('#rental-table tbody');
                if (tbody.children.length === 0) {
                  tbody.innerHTML = '<tr><td colspan="9" class="text-center">Belum ada riwayat rental.</td></tr>';
                }

                Swal.fire({
                  title: 'Berhasil!',
                  text: data.message || 'Rental berhasil dihapus.',
                  icon: 'success',
                  confirmButtonText: 'OK'
                });
              } else {
                Swal.fire({
                  title: 'Gagal!',
                  text: data.message || 'Terjadi kesalahan saat menghapus rental.',
                  icon: 'error',
                  confirmButtonText: 'OK'
                });
              }
            })
            .catch(error => {
              Swal.close();
              console.error('Error:', error);

              let errorMessage = 'Terjadi kesalahan saat menghapus rental. Silakan coba lagi.';
              if (error.message.includes('DELETE method is not supported')) {
                errorMessage = 'Gagal menghapus rental. Sistem tidak mendukung operasi ini. Silakan hubungi administrator.';
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