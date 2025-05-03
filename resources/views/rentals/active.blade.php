@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <h1 class="fw-bold fs-3">Daftar Rental Aktif</h1>
      <div class="card mb-3">
        <div class="card-body">
          <form method="GET" action="{{ route('rentals.active') }}">
            <div class="row">
              <div class="col-md-4 mb-3">
                <label for="customer_name" class="form-label">Nama Penyewa</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name"
                  value="{{ request('customer_name') }}" placeholder="Cari nama penyewa...">
              </div>
              <div class="col-md-4 mb-3">
                <label for="product_name" class="form-label">Nama Produk</label>
                <input type="text" class="form-control" id="product_name" name="product_name"
                  value="{{ request('product_name') }}" placeholder="Cari nama produk...">
              </div>
              <div class="col-md-4 mb-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">Filter</button>
                <a href="{{ route('rentals.active') }}" class="btn btn-secondary">Reset</a>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
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
                    @if($rental->status === 'ongoing')
                    <span class="badge bg-info">Sedang Disewa</span>
                    @endif
                  </td>
                  <td>
                    <a href="{{ route('rentals.show', $rental) }}" class="btn btn-sm btn-info">Detail</a>
                    <a href="{{ route('rentals.edit', $rental) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('rentals.confirm-return', $rental) }}" method="POST"
                      class="inline confirm-return-form" data-rental-code="{{ $rental->rental_code }}"
                      data-rental-id="{{ $rental->id }}">
                      @csrf
                      <button type="submit" class="btn btn-sm btn-success">Konfirmasi Pengembalian</button>
                    </form>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="9" class="text-center">Belum ada rental aktif.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          <div class="mt-3">
            {{ $rentals->appends(request()->query())->links() }}
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
    // Konfirmasi pengembalian dengan SweetAlert dan AJAX
    const confirmReturnForms = document.querySelectorAll('.confirm-return-form');

    confirmReturnForms.forEach(form => {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            const rentalCode = form.getAttribute('data-rental-code');
            const rentalId = form.getAttribute('data-rental-id');
            const url = form.getAttribute('action');
            const token = document.querySelector('meta[name="csrf-token"]')?.content || form.querySelector('input[name="_token"]').value;

            Swal.fire({
                title: `Konfirmasi Pengembalian "${rentalCode}"?`,
                text: "Pastikan barang telah dikembalikan oleh penyewa!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Konfirmasi!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Harap tunggu, sedang memproses pengembalian.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Kirim request POST via AJAX
                    fetch(url, {
                        method: 'POST',
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
                                tbody.innerHTML = '<tr><td colspan="9" class="text-center">Belum ada rental aktif.</td></tr>';
                            }

                            Swal.fire({
                                title: 'Berhasil!',
                                text: data.message || 'Rental berhasil dikembalikan.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: data.message || 'Terjadi kesalahan saat mengkonfirmasi pengembalian.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                    .catch(error => {
                        Swal.close();
                        console.error('Error:', error);

                        let errorMessage = 'Terjadi kesalahan saat mengkonfirmasi pengembalian. Silakan coba lagi.';
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

    // Pesan sukses atau error
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