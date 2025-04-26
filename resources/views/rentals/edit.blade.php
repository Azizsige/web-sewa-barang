@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-12">
    <h1 class="fw-bold fs-3 mb-4">Edit Rental</h1>
    <div class="card shadow-sm">
      <div class="card-body">
        <form method="POST" action="{{ route('rentals.update', $rental) }}" id="rental-form">
          @csrf
          @method('PUT')
          <div class="mb-4">
            <label for="customer_name" class="form-label text-gray-700">Nama Penyewa</label>
            <input type="text" name="customer_name" id="customer_name"
              class="form-control @error('customer_name') is-invalid @enderror"
              value="{{ old('customer_name', $rental->customer_name) }}">
            @error('customer_name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="customer_name-error" class="text-red-500 text-sm mt-1 hidden"></div>
          </div>
          <div class="mb-4">
            <label for="customer_email" class="form-label text-gray-700">Email Penyewa (Opsional)</label>
            <input type="email" name="customer_email" id="customer_email"
              class="form-control @error('customer_email') is-invalid @enderror"
              value="{{ old('customer_email', $rental->customer_email) }}">
            @error('customer_email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="customer_email-error" class="text-red-500 text-sm mt-1 hidden"></div>
          </div>
          <div class="mb-4">
            <label for="customer_phone" class="form-label text-gray-700">Nomor Telepon Penyewa (Opsional)</label>
            <input type="text" name="customer_phone" id="customer_phone"
              class="form-control @error('customer_phone') is-invalid @enderror"
              value="{{ old('customer_phone', $rental->customer_phone) }}">
            @error('customer_phone')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="customer_phone-error" class="text-red-500 text-sm mt-1 hidden"></div>
          </div>
          <div class="mb-4">
            <label for="product_id" class="form-label text-gray-700">Produk</label>
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
            <p class="text-red-500 text-sm">Belum ada produk dengan stok tersedia. <a
                href="{{ route('products.create') }}" class="text-blue-500 hover:underline">Tambah produk dulu</a>.</p>
            <select name="product_id" id="product_id" class="form-select" disabled>
              <option value="">Pilih Produk</option>
            </select>
            @endif
            @error('product_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="product_id-error" class="text-red-500 text-sm mt-1 hidden"></div>
          </div>
          <div class="mb-4">
            <label for="start_date" class="form-label text-gray-700">Tanggal Mulai Sewa</label>
            <input type="text" name="start_date" id="start_date"
              class="form-control flatpickr @error('start_date') is-invalid @enderror"
              value="{{ old('start_date', $rental->start_date) }}" readonly>
            @error('start_date')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="start_date-error" class="text-red-500 text-sm mt-1 hidden"></div>
          </div>
          <div class="mb-4">
            <label for="duration" class="form-label text-gray-700">Durasi Sewa (Hari)</label>
            <input type="number" name="duration" id="duration"
              class="form-control @error('duration') is-invalid @enderror"
              value="{{ old('duration', $rental->duration) }}" min="1">
            @error('duration')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="duration-error" class="text-red-500 text-sm mt-1 hidden"></div>
          </div>
          <div class="mb-4">
            <label for="total_price" class="form-label text-gray-700">Total Harga (Otomatis)</label>
            <input type="text" id="total_price" class="form-control bg-gray-100"
              value="Rp {{ number_format(old('total_price', $rental->total_price), 0, ',', '.') }}" readonly>
          </div>
          <div class="mb-4">
            <label for="status" class="form-label text-gray-700">Status</label>
            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
              <option value="pending" {{ old('status', $rental->status) === 'pending' ? 'selected' : '' }}>Pending
              </option>
              <option value="ongoing" {{ old('status', $rental->status) === 'ongoing' ? 'selected' : '' }}>Sedang Disewa
              </option>
              <option value="completed" {{ old('status', $rental->status) === 'completed' ? 'selected' : '' }}>Selesai
              </option>
              <option value="canceled" {{ old('status', $rental->status) === 'canceled' ? 'selected' : '' }}>Dibatalkan
              </option>
            </select>
            @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="status-error" class="text-red-500 text-sm mt-1 hidden"></div>
          </div>
          <div class="flex space-x-3">
            <button type="submit" class="btn btn-primary px-4 py-2">Simpan</button>
            <a href="{{ route('rentals.index') }}" class="btn btn-secondary px-4 py-2">Batal</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  // Inisialisasi Flatpickr untuk start_date
document.addEventListener('DOMContentLoaded', function() {
    flatpickr("#start_date", {
        dateFormat: "Y-m-d",
        minDate: "today",
        defaultDate: "{{ old('start_date', $rental->start_date) }}",
        onChange: function(selectedDates, dateStr, instance) {
            startDateError.classList.add('hidden');
            startDateInput.classList.remove('border-red-500');
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
const durationInput = document.getElementById('duration');
const statusInput = document.getElementById('status');
const customerNameError = document.getElementById('customer_name-error');
const customerEmailError = document.getElementById('customer_email-error');
const customerPhoneError = document.getElementById('customer_phone-error');
const productIdError = document.getElementById('product_id-error');
const startDateError = document.getElementById('start_date-error');
const durationError = document.getElementById('duration-error');
const statusError = document.getElementById('status-error');

if (form && customerNameInput && customerEmailInput && customerPhoneInput && productIdInput && startDateInput && durationInput && statusInput && customerNameError && customerEmailError && customerPhoneError && productIdError && startDateError && durationError && statusError) {
    // Cek role user untuk konfirmasi (khusus Dev)
    const userRole = '{{ auth()->user()->role }}';
    const currentStatus = '{{ $rental->status }}';

    // Generate pesan error pas halaman dibuka dan cek pesan error
    document.addEventListener('DOMContentLoaded', function() {
        // Cek apakah ada flash message error (validasi gagal), kalau ada tampilkan SweetAlert
        @if (session('error'))
            Swal.fire({
                title: 'Gagal!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                title: 'Gagal!',
                html: `@foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach`,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif
    });

    // Validasi pas submit dan tampilkan loading
    form.addEventListener('submit', async function(event) {
        let hasError = false;

        // Reset error state
        customerNameError.classList.add('hidden');
        customerEmailError.classList.add('hidden');
        customerPhoneError.classList.add('hidden');
        productIdError.classList.add('hidden');
        startDateError.classList.add('hidden');
        durationError.classList.add('hidden');
        statusError.classList.add('hidden');
        customerNameInput.classList.remove('border-red-500');
        customerEmailInput.classList.remove('border-red-500');
        customerPhoneInput.classList.remove('border-red-500');
        productIdInput.classList.remove('border-red-500');
        startDateInput.classList.remove('border-red-500');
        durationInput.classList.remove('border-red-500');
        statusInput.classList.remove('border-red-500');

        // Cek customer_name
        if (!customerNameInput.value.trim()) {
            customerNameError.textContent = 'Nama penyewa wajib diisi.';
            customerNameError.classList.remove('hidden');
            customerNameInput.classList.add('border-red-500');
            customerNameInput.focus();
            hasError = true;
        }

        // Cek customer_email (opsional, tapi kalau diisi harus valid)
        if (customerEmailInput.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(customerEmailInput.value)) {
            customerEmailError.textContent = 'Email tidak valid.';
            customerEmailError.classList.remove('hidden');
            customerEmailInput.classList.add('border-red-500');
            if (!hasError) {
                customerEmailInput.focus();
                hasError = true;
            }
        }

        // Cek customer_phone (opsional, tapi kalau diisi minimal 10 digit)
        if (customerPhoneInput.value && !/^\d{10,15}$/.test(customerPhoneInput.value.replace(/\D/g, ''))) {
            customerPhoneError.textContent = 'Nomor telepon tidak valid (minimal 10 digit).';
            customerPhoneError.classList.remove('hidden');
            customerPhoneInput.classList.add('border-red-500');
            if (!hasError) {
                customerPhoneInput.focus();
                hasError = true;
            }
        }

        // Cek product_id
        if (!productIdInput.value) {
            productIdError.textContent = 'Produk wajib dipilih.';
            productIdError.classList.remove('hidden');
            productIdInput.classList.add('border-red-500');
            if (!hasError) {
                productIdInput.focus();
                hasError = true;
            }
        }

        // Cek start_date
        const today = new Date().toISOString().split('T')[0];
        if (!startDateInput.value) {
            startDateError.textContent = 'Tanggal mulai wajib diisi.';
            startDateError.classList.remove('hidden');
            startDateInput.classList.add('border-red-500');
            if (!hasError) {
                startDateInput.focus();
                hasError = true;
            }
        } else if (startDateInput.value < today && startDateInput.value !== '{{ $rental->start_date }}') {
            startDateError.textContent = 'Tanggal mulai tidak boleh sebelum hari ini.';
            startDateError.classList.remove('hidden');
            startDateInput.classList.add('border-red-500');
            if (!hasError) {
                startDateInput.focus();
                hasError = true;
            }
        }

        // Cek duration
        if (!durationInput.value || durationInput.value < 1) {
            durationError.textContent = 'Durasi wajib diisi dan minimal 1 hari.';
            durationError.classList.remove('hidden');
            durationInput.classList.add('border-red-500');
            if (!hasError) {
                durationInput.focus();
                hasError = true;
            }
        }

        // Cek status
        if (!statusInput.value) {
            statusError.textContent = 'Status wajib dipilih.';
            statusError.classList.remove('hidden');
            statusInput.classList.add('border-red-500');
            if (!hasError) {
                statusInput.focus();
                hasError = true;
            }
        }

        if (hasError) {
            event.preventDefault();
            console.log('Form validation failed');
            return;
        }

        // Konfirmasi untuk Dev kalau status completed/canceled
        if (userRole === 'dev' && (currentStatus === 'completed' || currentStatus === 'canceled')) {
            event.preventDefault();
            const result = await Swal.fire({
                title: 'Konfirmasi Perubahan',
                text: 'Rental ini sudah selesai atau dibatalkan. Mengedit data dapat memengaruhi stok produk. Lanjutkan?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Batal'
            });

            if (!result.isConfirmed) {
                return;
            }
        }

        // Tampilkan SweetAlert loading
        Swal.fire({
            title: 'Menyimpan...',
            text: 'Harap tunggu, sedang menyimpan rental.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        form.submit();
    });

    // Hapus pesan error pas user pilih/isi input
    customerNameInput.addEventListener('input', function() {
        customerNameError.classList.add('hidden');
        customerNameInput.classList.remove('border-red-500');
    });

    customerEmailInput.addEventListener('input', function() {
        customerEmailError.classList.add('hidden');
        customerEmailInput.classList.remove('border-red-500');
    });

    customerPhoneInput.addEventListener('input', function() {
        customerPhoneError.classList.add('hidden');
        customerPhoneInput.classList.remove('border-red-500');
    });

    productIdInput.addEventListener('change', function() {
        productIdError.classList.add('hidden');
        productIdInput.classList.remove('border-red-500');
    });

    startDateInput.addEventListener('change', function() {
        startDateError.classList.add('hidden');
        startDateInput.classList.remove('border-red-500');
    });

    durationInput.addEventListener('input', function() {
        durationError.classList.add('hidden');
        durationInput.classList.remove('border-red-500');
    });

    statusInput.addEventListener('change', function() {
        statusError.classList.add('hidden');
        statusInput.classList.remove('border-red-500');
    });
} else {
    console.error('Elements not found:', { form, customerNameInput, customerEmailInput, customerPhoneInput, productIdInput, startDateInput, durationInput, statusInput, customerNameError, customerEmailError, customerPhoneError, productIdError, startDateError, durationError, statusError });
}
</script>
@endsection