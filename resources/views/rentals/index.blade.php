@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <h1 class="fw-bold fs-3">Daftar Riwayat Rental</h1>
      <a href="{{ route('rentals.create') }}" class="mb-3 btn btn-primary">Tambah Rental</a>
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

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Konfirmasi delete dengan SweetAlert dan AJAX
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

                    // Kirim request DELETE via AJAX
                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        // Cek apakah response OK (status 200-299)
                        if (!response.ok) {
                            return response.json().then(errorData => {
                                throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        Swal.close(); // Tutup loading

                        if (data.success) {
                            // Hapus baris dari tabel
                            const row = document.querySelector(`tr[data-rental-id="${rentalId}"]`);
                            if (row) row.remove();

                            // Cek apakah tabel kosong setelah hapus
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
                        Swal.close(); // Tutup loading
                        console.error('Error:', error);

                        // Ganti pesan error teknis dengan pesan user-friendly
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

    // Pesan sukses (jika halaman di-refresh)
    @if (session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    @endif

    // Pesan error (jika halaman di-refresh)
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