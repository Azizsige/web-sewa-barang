@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="flex items-center justify-between mb-3">
        <h1 class="mb-3 fw-bold fs-6">Manajemen Admin</h1>
        <div class="flex mb-3 space-x-3">
          <a href="{{ route('admin-users.create') }}" class="btn btn-primary">Tambah Admin Baru</a>
        </div>
      </div>
      <div class="shadow-sm card">
        <div class="p-4 card-body">
          <div class="table-responsive">
            <table class="table mb-0 align-middle text-nowrap" id="admin-users-table">
              <thead>
                <tr>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Dibuat Pada</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($admins as $admin)
                <tr data-admin-id="{{ $admin->id }}">
                  <td>{{ $admin->name }}</td>
                  <td>{{ $admin->email }}</td>
                  <td>{{ $admin->role }}</td>
                  <td>{{ \Carbon\Carbon::parse($admin->created_at)->format('d M Y') }}</td>
                  <td>
                    <a href="{{ route('admin-users.edit', $admin) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin-users.destroy', $admin) }}" method="POST" class="inline delete-form"
                      data-admin-name="{{ $admin->name }}" data-admin-id="{{ $admin->id }}">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="5" class="text-center">Belum ada admin.</td>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Event listener untuk tombol hapus
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
      form.addEventListener('submit', function (event) {
        event.preventDefault();

        const adminName = form.getAttribute('data-admin-name');
        const adminId = form.getAttribute('data-admin-id');
        const url = form.getAttribute('action');
        const token = document.querySelector('meta[name="csrf-token"]')?.content || form.querySelector('input[name="_token"]').value;

        Swal.fire({
          title: `Hapus Admin "${adminName}"?`,
          text: "Admin yang dihapus tidak dapat dikembalikan!",
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
              text: 'Harap tunggu, sedang menghapus admin.',
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
                const row = document.querySelector(`tr[data-admin-id="${adminId}"]`);
                if (row) row.remove();

                const tbody = document.querySelector('#admin-users-table tbody');
                if (tbody.children.length === 0) {
                  tbody.innerHTML = '<tr><td colspan="5" class="text-center">Belum ada admin.</td></tr>';
                }

                Swal.fire({
                  title: 'Berhasil!',
                  text: data.message || 'Admin berhasil dihapus.',
                  icon: 'success',
                  confirmButtonText: 'OK'
                });
              } else {
                Swal.fire({
                  title: 'Gagal!',
                  text: data.message || 'Terjadi kesalahan saat menghapus admin.',
                  icon: 'error',
                  confirmButtonText: 'OK'
                });
              }
            })
            .catch(error => {
              Swal.close();
              console.error('Error:', error);

              let errorMessage = 'Terjadi kesalahan saat menghapus admin. Silakan coba lagi.';
              if (error.message.includes('DELETE method is not supported')) {
                errorMessage = 'Gagal menghapus admin. Sistem tidak mendukung operasi ini. Silakan hubungi administrator.';
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