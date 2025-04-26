@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <h1 class="fw-bold fs-3">Daftar Riwayat Rental</h1>
      <a href="{{ route('rentals.create') }}" class="btn btn-primary mb-3">Tambah Rental</a>
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table text-nowrap mb-0 align-middle">
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
                <tr>
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
                    <form action="{{ route('rentals.destroy', $rental->id) }}" method="POST" class="delete-form inline"
                      data-rental-code="{{ $rental->rental_code }}">
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

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
        // Konfirmasi delete dengan SweetAlert
        const deleteForms = document.querySelectorAll('.delete-form');

        deleteForms.forEach(form => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                const rentalCode = form.getAttribute('data-rental-code');

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

                        form.submit();
                    }
                });
            });
        });

        // Pesan sukses
        @if (session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif

        // Pesan error
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