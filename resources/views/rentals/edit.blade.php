@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-12">
    <h1 class="mb-4 fw-bold fs-3">Edit Rental</h1>
    <div class="shadow-sm card">
      <div class="card-body">
        <form method="POST" action="{{ route('rentals.update', $rental) }}" id="rental-form">
          @csrf
          @method('PUT')
          <div class="mb-4">
            <label for="customer_name" class="text-gray-700 form-label">Nama Penyewa</label>
            <input type="text" name="customer_name" id="customer_name"
              class="form-control @error('customer_name') is-invalid @enderror"
              value="{{ old('customer_name', $rental->customer_name) }}">
            @error('customer_name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="customer_name-error" class="hidden mt-1 text-sm text-red-500"></div>
          </div>
          <div class="mb-4">
            <label for="customer_email" class="text-gray-700 form-label">Email Penyewa (Opsional)</label>
            <input type="email" name="customer_email" id="customer_email"
              class="form-control @error('customer_email') is-invalid @enderror"
              value="{{ old('customer_email', $rental->customer_email) }}">
            @error('customer_email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="customer_email-error" class="hidden mt-1 text-sm text-red-500"></div>
          </div>
          <div class="mb-4">
            <label for="customer_phone" class="text-gray-700 form-label">Nomor Telepon Penyewa (Opsional)</label>
            <input type="text" name="customer_phone" id="customer_phone"
              class="form-control @error('customer_phone') is-invalid @enderror"
              value="{{ old('customer_phone', $rental->customer_phone) }}">
            @error('customer_phone')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="customer_phone-error" class="hidden mt-1 text-sm text-red-500"></div>
          </div>
          <div class="mb-4">
            <label for="product_id" class="text-gray-700 form-label">Produk</label>
            @if($products && $products->count() > 0)
            <select name="product_id" id="product_id" class="form-select @error('product_id') is-invalid @enderror">
              <option value="">Pilih Produk</option>
              @foreach($products as $product)
              <option value="{{ $product->id }}" {{ old('product_id', $rental->product_id) == $product->id ? 'selected'
                : '' }}>
                {{ $product->name }} (Stok: {{ $product->stock }})
              </option>
              @endforeach
            </select>
            @else
            <p class="text-sm text-red-500">Belum ada produk dengan stok tersedia. <a
                href="{{ route('products.create') }}" class="text-blue-500 hover:underline">Tambah produk dulu</a>.</p>
            <select name="product_id" id="product_id" class="form-select" disabled>
              <option value="">Pilih Produk</option>
            </select>
            @endif
            @error('product_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="product_id-error" class="hidden mt-1 text-sm text-red-500"></div>
          </div>
          <div class="mb-4">
            <label for="start_date" class="text-gray-700 form-label">Tanggal Mulai Sewa</label>
            <input type="text" name="start_date" id="start_date"
              class="form-control flatpickr @error('start_date') is-invalid @enderror"
              value="{{ old('start_date', $rental->start_date->format('Y-m-d')) }}" readonly>
            @error('start_date')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="start_date-error" class="hidden mt-1 text-sm text-red-500"></div>
          </div>
          <div class="mb-4">
            <label for="end_date" class="text-gray-700 form-label">Tanggal Selesai Sewa</label>
            <input type="text" name="end_date" id="end_date"
              class="form-control flatpickr @error('end_date') is-invalid @enderror"
              value="{{ old('end_date', $rental->end_date->format('Y-m-d')) }}" readonly>
            @error('end_date')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="end_date-error" class="hidden mt-1 text-sm text-red-500"></div>
          </div>
          <div class="mb-4">
            <label for="status" class="text-gray-700 form-label">Status</label>
            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
              <option value="pending" {{ old('status', $rental->status) == 'pending' ? 'selected' : '' }}>Pending
              </option>
              <option value="ongoing" {{ old('status', $rental->status) == 'ongoing' ? 'selected' : '' }}>Sedang Disewa
              </option>
              <option value="completed" {{ old('status', $rental->status) == 'completed' ? 'selected' : '' }}>Selesai
              </option>
              <option value="canceled" {{ old('status', $rental->status) == 'canceled' ? 'selected' : '' }}>Dibatalkan
              </option>
            </select>
            @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="status-error" class="hidden mt-1 text-sm text-red-500"></div>
          </div>
          <div class="flex space-x-3">
            <button type="submit" class="px-4 py-2 btn btn-primary">Simpan</button>
            <a href="{{ route('rentals.index') }}" class="px-4 py-2 btn btn-secondary">Batal</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('styles')
<style>
  .error-highlight {
    animation: pulse 1s infinite;
  }

  @keyframes pulse {
    0% {
      box-shadow: 0 0 0 0 rgba(255, 0, 0, 0.7);
    }

    70% {
      box-shadow: 0 0 0 10px rgba(255, 0, 0, 0);
    }

    100% {
      box-shadow: 0 0 0 0 rgba(255, 0, 0, 0);
    }
  }
</style>
@endsection

@section('scripts')
<!-- Pastikan SweetAlert2 terload -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  // Inisialisasi Flatpickr untuk start_date dan end_date
document.addEventListener('DOMContentLoaded', function() {
    const startDatePicker = flatpickr("#start_date", {
        dateFormat: "Y-m-d",
        minDate: "today",
        defaultDate: "{{ old('start_date', $rental->start_date->format('Y-m-d')) }}",
        onChange: function(selectedDates, dateStr, instance) {
            startDateError.classList.add('hidden');
            startDateInput.classList.remove('border-red-500', 'error-highlight');
            if (selectedDates.length > 0) {
                const startDate = selectedDates[0];
                const minEndDate = new Date(startDate);
                minEndDate.setDate(minEndDate.getDate() + 1);
                endDatePicker.set('minDate', minEndDate);
            }
        }
    });

    const endDatePicker = flatpickr("#end_date", {
        dateFormat: "Y-m-d",
        minDate: "tomorrow",
        defaultDate: "{{ old('end_date', $rental->end_date->format('Y-m-d')) }}",
        onChange: function(selectedDates, dateStr, instance) {
            endDateError.classList.add('hidden');
            endDateInput.classList.remove('border-red-500', 'error-highlight');
        }
    });
});

// Validasi form sebelum submit
const form = document.getElementById('rental-form');
const customerNameInput = document.getElementById('customer_name');
const customerEmailInput = document.getElementById('customer_email');
const customerPhoneInput = document.getElementById('customer_phone');
const productIdInput = document.getElementById('product_id');
const startDateInput = document.getElementById('start_date');
const endDateInput = document.getElementById('end_date');
const statusInput = document.getElementById('status');
const customerNameError = document.getElementById('customer_name-error');
const customerEmailError = document.getElementById('customer_email-error');
const customerPhoneError = document.getElementById('customer_phone-error');
const productIdError = document.getElementById('product_id-error');
const startDateError = document.getElementById('start_date-error');
const endDateError = document.getElementById('end_date-error');
const statusError = document.getElementById('status-error');

if (form && customerNameInput && customerEmailInput && customerPhoneInput && productIdInput && startDateInput && endDateInput && statusInput && customerNameError && customerEmailError && customerPhoneError && productIdError && startDateError && endDateError && statusError) {
    // Generate pesan error pas halaman dibuka
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('error'))
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            } else {
                console.error('SweetAlert2 tidak terload. Error: {{ session('error') }}');
                alert('Gagal! {{ session('error') }}');
            }
        @endif

        @if ($errors->any())
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Gagal!',
                    html: `@foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach`,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            } else {
                console.error('SweetAlert2 tidak terload. Errors: @foreach ($errors->all() as $error) {{ $error }} @endforeach');
                alert('Gagal! @foreach ($errors->all() as $error) {{ $error }}\n @endforeach');
            }
        @endif
    });

    // Validasi pas submit
    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Cegah submit langsung
        let hasError = false;
        let errors = [];
        let firstErrorInput = null;

        console.log('Debug - Mulai validasi form');

        // Reset error state
        customerNameError.classList.add('hidden');
        customerEmailError.classList.add('hidden');
        customerPhoneError.classList.add('hidden');
        productIdError.classList.add('hidden');
        startDateError.classList.add('hidden');
        endDateError.classList.add('hidden');
        statusError.classList.add('hidden');
        customerNameInput.classList.remove('border-red-500', 'error-highlight');
        customerEmailInput.classList.remove('border-red-500', 'error-highlight');
        customerPhoneInput.classList.remove('border-red-500', 'error-highlight');
        productIdInput.classList.remove('border-red-500', 'error-highlight');
        startDateInput.classList.remove('border-red-500', 'error-highlight');
        endDateInput.classList.remove('border-red-500', 'error-highlight');
        statusInput.classList.remove('border-red-500', 'error-highlight');

        // Cek customer_name
        if (!customerNameInput.value.trim()) {
            console.log('Debug - customer_name kosong');
            customerNameError.textContent = 'Nama penyewa wajib diisi.';
            customerNameError.classList.remove('hidden');
            customerNameInput.classList.add('border-red-500', 'error-highlight');
            if (!firstErrorInput) firstErrorInput = customerNameInput;
            errors.push('Nama penyewa wajib diisi.');
            hasError = true;
        }

        // Cek customer_email (opsional, tapi kalau diisi harus valid)
        const emailValue = customerEmailInput.value.trim();
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        console.log('Debug - customer_email value:', emailValue);
        console.log('Debug - emailRegex test result:', emailRegex.test(emailValue));
        if (emailValue && !emailRegex.test(emailValue)) {
            console.log('Debug - customer_email tidak valid:', emailValue);
            customerEmailError.textContent = 'Email tidak valid (contoh: user@domain.com).';
            customerEmailError.classList.remove('hidden');
            customerEmailInput.classList.add('border-red-500', 'error-highlight');
            if (!firstErrorInput) firstErrorInput = customerEmailInput;
            errors.push('Email tidak valid (contoh: user@domain.com).');
            hasError = true;
        }

        // Cek customer_phone (opsional, tapi kalau diisi minimal 10 digit)
        if (customerPhoneInput.value && !/^\d{10,15}$/.test(customerPhoneInput.value.replace(/\D/g, ''))) {
            console.log('Debug - customer_phone tidak valid:', customerPhoneInput.value);
            customerPhoneError.textContent = 'Nomor telepon tidak valid (minimal 10 digit).';
            customerPhoneError.classList.remove('hidden');
            customerPhoneInput.classList.add('border-red-500', 'error-highlight');
            if (!firstErrorInput) firstErrorInput = customerPhoneInput;
            errors.push('Nomor telepon tidak valid (minimal 10 digit).');
            hasError = true;
        }

        // Cek product_id
        if (!productIdInput.value) {
            console.log('Debug - product_id tidak dipilih');
            productIdError.textContent = 'Produk wajib dipilih.';
            productIdError.classList.remove('hidden');
            productIdInput.classList.add('border-red-500', 'error-highlight');
            if (!firstErrorInput) firstErrorInput = productIdInput;
            errors.push('Produk wajib dipilih.');
            hasError = true;
        }

        // Cek start_date
        const today = new Date().toISOString().split('T')[0];
        if (!startDateInput.value) {
            console.log('Debug - start_date kosong');
            startDateError.textContent = 'Tanggal mulai wajib diisi.';
            startDateError.classList.remove('hidden');
            startDateInput.classList.add('border-red-500', 'error-highlight');
            if (!firstErrorInput) firstErrorInput = startDateInput;
            errors.push('Tanggal mulai wajib diisi.');
            hasError = true;
        } else if (startDateInput.value < today) {
            console.log('Debug - start_date sebelum hari ini:', startDateInput.value);
            startDateError.textContent = 'Tanggal mulai tidak boleh sebelum hari ini.';
            startDateError.classList.remove('hidden');
            startDateInput.classList.add('border-red-500', 'error-highlight');
            if (!firstErrorInput) firstErrorInput = startDateInput;
            errors.push('Tanggal mulai tidak boleh sebelum hari ini.');
            hasError = true;
        }

        // Cek end_date
        if (!endDateInput.value) {
            console.log('Debug - end_date kosong');
            endDateError.textContent = 'Tanggal selesai wajib diisi.';
            endDateError.classList.remove('hidden');
            endDateInput.classList.add('border-red-500', 'error-highlight');
            if (!firstErrorInput) firstErrorInput = endDateInput;
            errors.push('Tanggal selesai wajib diisi.');
            hasError = true;
        } else if (startDateInput.value && endDateInput.value) {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);
            if (endDate <= startDate) {
                console.log('Debug - end_date tidak valid:', endDateInput.value);
                endDateError.textContent = 'Tanggal selesai harus setelah tanggal mulai.';
                endDateError.classList.remove('hidden');
                endDateInput.classList.add('border-red-500', 'error-highlight');
                if (!firstErrorInput) firstErrorInput = endDateInput;
                errors.push('Tanggal selesai harus setelah tanggal mulai.');
                hasError = true;
            }
        }

        // Cek status
        if (!statusInput.value) {
            console.log('Debug - status tidak dipilih');
            statusError.textContent = 'Status wajib dipilih.';
            statusError.classList.remove('hidden');
            statusInput.classList.add('border-red-500', 'error-highlight');
            if (!firstErrorInput) firstErrorInput = statusInput;
            errors.push('Status wajib dipilih.');
            hasError = true;
        }

        // Jika ada error, tampilkan SweetAlert
        if (hasError) {
            console.log('Debug - hasError true, errors:', errors);
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Gagal!',
                    html: errors.join('<br>'),
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then(() => {
                    if (firstErrorInput) {
                        firstErrorInput.focus();
                        firstErrorInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                });
            } else {
                console.error('SweetAlert2 tidak terload. Errors:', errors);
                alert('Gagal!\n' + errors.join('\n'));
            }
            return;
        }

        // Cek role dev dan status completed/canceled
        const userRole = '{{ Auth::user()->role }}';
        const currentStatus = '{{ $rental->status }}';
        console.log('Debug - userRole:', userRole);
        console.log('Debug - currentStatus:', currentStatus);

        const normalizedUserRole = userRole ? userRole.toLowerCase().trim() : '';
        const normalizedCurrentStatus = currentStatus ? currentStatus.toLowerCase().trim() : '';

        if (normalizedUserRole === 'developer' && (normalizedCurrentStatus === 'completed' || normalizedCurrentStatus === 'canceled')) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Rental ini sudah selesai atau dibatalkan. Apakah Anda yakin ingin melanjutkan?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Lanjutkan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Menyimpan...',
                            text: 'Harap tunggu, sedang menyimpan rental.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        form.submit();
                    }
                });
            } else {
                console.error('SweetAlert2 tidak terload. Konfirmasi dibatalkan.');
                alert('Rental ini sudah selesai atau dibatalkan. Apakah Anda yakin ingin melanjutkan?');
                form.submit();
            }
        } else {
            console.log('Debug - Kondisi tidak terpenuhi:', {
                normalizedUserRole,
                normalizedCurrentStatus,
                isDev: normalizedUserRole === 'dev',
                isCompletedOrCanceled: normalizedCurrentStatus === 'completed' || normalizedCurrentStatus === 'canceled'
            });

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Menyimpan...',
                    text: 'Harap tunggu, sedang menyimpan rental.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            } else {
                console.error('SweetAlert2 tidak terload. Langsung submit form.');
            }
            form.submit();
        }
    });

    // Hapus pesan error pas user pilih/isi input
    customerNameInput.addEventListener('input', function() {
        customerNameError.classList.add('hidden');
        customerNameInput.classList.remove('border-red-500', 'error-highlight');
    });

    customerEmailInput.addEventListener('input', function() {
        customerEmailError.classList.add('hidden');
        customerEmailInput.classList.remove('border-red-500', 'error-highlight');
    });

    customerPhoneInput.addEventListener('input', function() {
        customerPhoneError.classList.add('hidden');
        customerPhoneInput.classList.remove('border-red-500', 'error-highlight');
    });

    productIdInput.addEventListener('change', function() {
        productIdError.classList.add('hidden');
        productIdInput.classList.remove('border-red-500', 'error-highlight');
    });

    startDateInput.addEventListener('change', function() {
        startDateError.classList.add('hidden');
        startDateInput.classList.remove('border-red-500', 'error-highlight');
    });

    endDateInput.addEventListener('change', function() {
        endDateError.classList.add('hidden');
        endDateInput.classList.remove('border-red-500', 'error-highlight');
    });

    statusInput.addEventListener('change', function() {
        statusError.classList.add('hidden');
        statusInput.classList.remove('border-red-500', 'error-highlight');
    });
} else {
    console.error('Elements not found:', { form, customerNameInput, customerEmailInput, customerPhoneInput, productIdInput, startDateInput, endDateInput, statusInput, customerNameError, customerEmailError, customerPhoneError, productIdError, startDateError, endDateError, statusError });
}
</script>
@endsection