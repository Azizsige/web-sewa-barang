@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="flex items-center justify-between mb-3">
        <h1 class="mb-3 fw-bold fs-6">Activity Logs</h1>
      </div>
      <div class="mb-4 shadow-sm card">
        <div class="card-body">
          <form method="GET" action="{{ route('activity_logs.index') }}"
            class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4" id="filter-form">
            <div>
              <label for="user_id" class="block mb-2 text-sm font-medium text-gray-700">User</label>
              <select name="user_id" id="user_id" class="w-full form-select">
                <option value="">Semua User</option>
                @foreach (\App\Models\User::where('role', 'admin')->get() as $user)
                <option value="{{ $user->id }}" {{ request()->user_id == $user->id ? 'selected' : '' }}>
                  {{ $user->name }}
                </option>
                @endforeach
              </select>
            </div>
            <div>
              <label for="action" class="block mb-2 text-sm font-medium text-gray-700">Aksi</label>
              <select name="action" id="action" class="w-full form-select">
                <option value="">Semua Aksi</option>
                @foreach (['login', 'logout', 'created', 'updated', 'deleted', 'exported'] as $act)
                <option value="{{ $act }}" {{ request()->action == $act ? 'selected' : '' }}>
                  {{ ucfirst($act) }}
                </option>
                @endforeach
              </select>
            </div>
            <div>
              <label for="model_type" class="block mb-2 text-sm font-medium text-gray-700">Model</label>
              <select name="model_type" id="model_type" class="w-full form-select">
                <option value="">Semua Model</option>
                @foreach (['Rental', 'Product', 'Category', 'User'] as $model)
                <option value="{{ $model }}" {{ request()->model_type == $model ? 'selected' : '' }}>
                  {{ $model }}
                </option>
                @endforeach
              </select>
            </div>
            <div>
              <label for="keyword" class="block mb-2 text-sm font-medium text-gray-700">Cari Deskripsi</label>
              <input type="text" name="keyword" id="keyword" class="w-full form-control"
                value="{{ request('keyword') }}" placeholder="Masukkan deskripsi">
            </div>
            <div>
              <label for="date_from" class="block mb-2 text-sm font-medium text-gray-700">Dari Tanggal</label>
              <input type="text" name="date_from" id="date_from" class="w-full form-control flatpickr"
                value="{{ request('date_from') }}" placeholder="Pilih tanggal">
            </div>
            <div>
              <label for="date_to" class="block mb-2 text-sm font-medium text-gray-700">Ke Tanggal</label>
              <input type="text" name="date_to" id="date_to" class="w-full form-control flatpickr"
                value="{{ request('date_to') }}" placeholder="Pilih tanggal">
            </div>
            <div class="flex space-x-3 md:col-span-4">
              <a href="{{ route('activity_logs.index') }}" class="px-4 py-2 btn btn-secondary">Reset Filter</a>
            </div>
          </form>
        </div>
      </div>
      <div class="shadow-sm card">
        <div class="p-4 card-body">
          <div class="table-responsive">
            <table class="table mb-0 align-middle text-nowrap" id="activity-logs-table">
              <thead>
                <tr>
                  <th>User</th>
                  <th>Action</th>
                  <th>Model</th>
                  <th>ID</th>
                  <th>Changes</th>
                  <th>Description</th>
                  <th>Time</th>
                </tr>
              </thead>
              <tbody>
                @if (!isset($logs) || !is_iterable($logs))
                <tr>
                  <td colspan="7" class="text-center">Data log tidak tersedia.</td>
                </tr>
                @else
                @forelse ($logs as $log)
                <tr>
                  <td>{{ $log->user->name ?? 'Unknown User' }}</td>
                  <td>{{ $log->action ?? '-' }}</td>
                  <td>{{ $log->model_type ?? '-' }}</td>
                  <td>{{ $log->model_id ?? '-' }}</td>
                  <td>
                    @php
                    $oldValues = is_array($log->old_values) ? $log->old_values : (is_string($log->old_values) ?
                    json_decode($log->old_values, true) : []);
                    $newValues = is_array($log->new_values) ? $log->new_values : (is_string($log->new_values) ?
                    json_decode($log->new_values, true) : []);
                    $changes = array_keys(array_merge($oldValues ?: [], $newValues ?: []));
                    @endphp
                    @if (!empty($changes))
                    <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                      data-bs-target="#changesModal{{ $log->id }}">Lihat Perubahan</button>
                    <div class="modal fade" id="changesModal{{ $log->id }}" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Perubahan pada {{ $log->model_type ?? 'Unknown' }} ID: {{
                              $log->model_id ?? 'N/A' }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th>Field</th>
                                  <th>Old Value</th>
                                  <th>New Value</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($changes as $key)
                                <tr>
                                  <td>{{ $key }}</td>
                                  <td>{{ $oldValues[$key] ?? '-' }}</td>
                                  <td>{{ $newValues[$key] ?? '-' }}</td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    @else
                    -
                    @endif
                  </td>
                  <td>{{ $log->description ?? '-' }}</td>
                  <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="7" class="text-center">Belum ada log aktivitas.</td>
                </tr>
                @endforelse
                @endif
              </tbody>
            </table>
          </div>
          <div class="mt-3">
            {{ $logs->appends(request()->query())->links() }}
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
    flatpickr('.flatpickr', {
      dateFormat: 'd-m-Y',
      onChange: function(selectedDates, dateStr, instance) {
        document.getElementById('filter-form').submit();
      }
    });

    // Ambil elemen form dan input-nya
    const filterForm = document.getElementById('filter-form');
    const userSelect = document.getElementById('user_id');
    const actionSelect = document.getElementById('action');
    const modelSelect = document.getElementById('model_type');
    const searchInput = document.getElementById('keyword');

    // Event listener untuk select
    userSelect.addEventListener('change', function() {
      filterForm.submit();
    });
    actionSelect.addEventListener('change', function() {
      filterForm.submit();
    });
    modelSelect.addEventListener('change', function() {
      filterForm.submit();
    });

    // Event listener untuk input search
    searchInput.addEventListener('input', function() {
      clearTimeout(searchInput.timeout);
      searchInput.timeout = setTimeout(() => {
        filterForm.submit();
      }, 500);
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