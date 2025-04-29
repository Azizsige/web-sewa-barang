@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-12">
    <h1 class="mb-4 fw-bold fs-3">Tambah Rental</h1>
    <div class="shadow-sm card">
      <div class="card-body">
        <form method="POST" action="{{ route('rentals.store') }}" id="rental-form">
          @csrf
          <div class="mb-4">
            <label for="customer_name" class="text-gray-700 form-label">Nama Penyewa</label>
            <input type="text" name="customer_name" id="customer_name"
              class="form-control @error('customer_name') is-invalid @enderror" value="{{ old('customer_name') }}">
            @error('customer_name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="customer_name-error" class="hidden mt-1 text-sm text-red-500"></div>
          </div>
          <div class="mb-4">
            <label for="customer_email" class="text-gray-700 form-label">Email Penyewa (Opsional)</label>
            <input type="email" name="customer_email" id="customer_email"
              class="form-control @error('customer_email') is-invalid @enderror" value="{{ old('customer_email') }}">
            @error('customer_email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="customer_email-error" class="hidden mt-1 text-sm text-red-500"></div>
          </div>
          <div class="mb-4">
            <label for="customer_phone" class="text-gray-700 form-label">Nomor Telepon Penyewa (Opsional)</label>
            <input type="text" name="customer_phone" id="customer_phone"
              class="form-control @error('customer_phone') is-invalid @enderror" value="{{ old('customer_phone') }}">
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
              <option value="{{ $product->id }}" {{ old('product_id')==$product->id ? 'selected' : '' }}>
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
              class="form-control flatpickr @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}"
              readonly>
            @error('start_date')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="start_date-error" class="hidden mt-1 text-sm text-red-500"></div>
          </div>
          <div class="mb-4">
            <label for="end_date" class="text-gray-700 form-label">Tanggal Selesai Sewa</label>
            <input type="text" name="end_date" id="end_date"
              class="form-control flatpickr @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}"
              readonly>
            @error('end_date')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="end_date-error" class="hidden mt-1 text-sm text-red-500"></div>
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

@section('scripts')
<script>
  // Inisialisasi Flatpickr untuk start_date dan end_date
document.addEventListener('DOMContentLoaded', function() {
    const startDatePicker = flatpickr("#start_date", {
        dateFormat: "Y-m-d",
        minDate: "today",
        defaultDate: "{{ old('start_date') ?: date('Y-m-d') }}",
        onChange: function(selectedDates, dateStr, instance) {
            startDateError.classList.add('hidden');
            startDateInput.classList.remove('border-red-500');
            // Update minDate untuk end_date
            if (selectedDates.length > 0) {
                const startDate = selectedDates[0];
                const minEndDate = new Date(startDate);
                minEndDate.setDate(minEndDate.getDate() + 1); // Minimal 1 hari setelah start_date
                endDatePicker.set('minDate', minEndDate);
            }
        }
    });

    const endDatePicker = flatpickr("#end_date", {
        dateFormat: "Y-m-d",
        minDate: "tomorrow", // Default minimal besok, bakal diupdate setelah start_date dipilih
        defaultDate: "{{ old('end_date') ?: null }}",
        onChange: function(selectedDates, dateStr, instance) {
            endDateError.classList.add('hidden');
            endDateInput.classList.remove('border-red-500');
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
const customerNameError = document.getElementById('customer_name-error');
const customerEmailError = document.getElementById('customer_email-error');
const customerPhoneError = document.getElementById('customer_phone-error');
const productIdError = document.getElementById('product_id-error');
const startDateError = document.getElementById('start_date-error');
const endDateError = document.getElementById('end_date-error');

if (form && customerNameInput && customerEmailInput && customerPhoneInput && productIdInput && startDateInput && endDateInput && customerNameError && customerEmailError && customerPhoneError && productIdError && startDateError && endDateError) {
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
    form.addEventListener('submit', function(event) {
        let hasError = false;

        // Reset error state
        customerNameError.classList.add('hidden');
        customerEmailError.classList.add('hidden');
        customerPhoneError.classList.add('hidden');
        productIdError.classList.add('hidden');
        startDateError.classList.add('hidden');
        endDateError.classList.add('hidden');
        customerNameInput.classList.remove('border-red-500');
        customerEmailInput.classList.remove('border-red-500');
        customerPhoneInput.classList.remove('border-red-500');
        productIdInput.classList.remove('border-red-500');
        startDateInput.classList.remove('border-red-500');
        endDateInput.classList.remove('border-red-500');

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
        } else if (startDateInput.value < today) {
            startDateError.textContent = 'Tanggal mulai tidak boleh sebelum hari ini.';
            startDateError.classList.remove('hidden');
            startDateInput.classList.add('border-red-500');
            if (!hasError) {
                startDateInput.focus();
                hasError = true;
            }
        }

        // Cek end_date
        if (!endDateInput.value) {
            endDateError.textContent = 'Tanggal selesai wajib diisi.';
            endDateError.classList.remove('hidden');
            endDateInput.classList.add('border-red-500');
            if (!hasError) {
                endDateInput.focus();
                hasError = true;
            }
        } else if (startDateInput.value && endDateInput.value) {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);
            if (endDate <= startDate) {
                endDateError.textContent = 'Tanggal selesai harus setelah tanggal mulai.';
                endDateError.classList.remove('hidden');
                endDateInput.classList.add('border-red-500');
                if (!hasError) {
                    endDateInput.focus();
                    hasError = true;
                }
            }
        }

        if (hasError) {
            event.preventDefault();
            console.log('Form validation failed');
            return;
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
        productIdInput.classList.add('border-red-500');
    });

    startDateInput.addEventListener('change', function() {
        startDateError.classList.add('hidden');
        startDateInput.classList.remove('border-red-500');
    });

    endDateInput.addEventListener('change', function() {
        endDateError.classList.add('hidden');
        endDateInput.classList.remove('border-red-500');
    });
} else {
    console.error('Elements not found:', { form, customerNameInput, customerEmailInput, customerPhoneInput, productIdInput, startDateInput, endDateInput, customerNameError, customerEmailError, customerPhoneError, productIdError, startDateError, endDateError });
}
</script>
@endsection