@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-12">
    <h1 class="mb-4 fw-bold fs-3">Tambah Rental</h1>
    <div class="shadow-sm card">
      <div class="card-body">
        <form method="POST" action="{{ route('rentals.store') }}" id="rental-form" enctype="multipart/form-data">
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
          <div class="mb-4">
            <label for="proof_of_payment" class="text-gray-700 form-label">Upload Foto Bukti Jaminan <span
                class="text-red-500">*</span></label>
            <div
              class="relative p-6 text-center border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 focus-within:ring-2 focus-within:ring-blue-500">
              <input type="file" name="proof_of_payment" id="proof_of_payment" accept="image/*"
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
              <div id="image-preview" class="hidden mt-2">
                <div class="relative inline-block">
                  <img id="preview-img" src="#" alt="Preview" class="h-auto max-w-full rounded-lg"
                    style="max-width: 150px; max-height: 150px;" />
                  <button type="button" id="remove-image"
                    class="absolute text-red-500 -top-2 -right-2 hover:text-red-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                      stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </div>
              </div>
              <div id="default-message">
                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18">
                  </path>
                </svg>
                <p class="mt-1 text-sm text-gray-600">Drag and drop gambar di sini, atau klik untuk pilih file</p>
                <p class="mt-1 text-xs text-gray-500">Hanya file gambar (jpg, png), maksimal 2MB</p>
              </div>
              <div id="loading-spinner" class="hidden mt-2">
                <svg class="w-8 h-8 mx-auto text-blue-500 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                  viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                <p class="mt-1 text-sm text-gray-600">Mengunggah...</p>
              </div>
            </div>
            @error('proof_of_payment')
            <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
            @enderror
            <div id="proof_of_payment-error" class="hidden mt-1 text-sm text-red-500"></div>
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
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const startDateError = document.getElementById('start_date-error');
    const endDateError = document.getElementById('end_date-error');

    const startDatePicker = flatpickr("#start_date", {
        dateFormat: "Y-m-d",
        minDate: "today",
        defaultDate: "{{ old('start_date') ?: date('Y-m-d') }}",
        onChange: function(selectedDates, dateStr, instance) {
            startDateError.classList.add('hidden');
            startDateInput.classList.remove('border-red-500');

            if (selectedDates.length > 0) {
                const startDate = selectedDates[0];
                const minEndDate = new Date(startDate);
                minEndDate.setDate(minEndDate.getDate() + 1);
                endDatePicker.set('minDate', minEndDate);

                if (new Date(endDateInput.value) <= startDate) {
                    endDatePicker.clear();
                }
            }
        }
    });

    const endDatePicker = flatpickr("#end_date", {
        dateFormat: "Y-m-d",
        defaultDate: "{{ old('end_date') ?: null }}",
        minDate: function() {
            const startDate = new Date(startDateInput.value || "{{ date('Y-m-d') }}");
            const minEndDate = new Date(startDate);
            minEndDate.setDate(minEndDate.getDate() + 1);
            return minEndDate;
        },
        onChange: function(selectedDates, dateStr, instance) {
            endDateError.classList.add('hidden');
            endDateInput.classList.remove('border-red-500');
        }
    });

    // Image Upload Preview and Remove
    const fileInput = document.getElementById('proof_of_payment');
    const defaultMessage = document.getElementById('default-message');
    const imagePreview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    const removeButton = document.getElementById('remove-image');
    const proofOfPaymentError = document.getElementById('proof_of_payment-error');

    fileInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const allowedTypes = ['image/jpeg', 'image/png'];
            const maxSize = 2 * 1024 * 1024; // 2MB dalam bytes

            if (!allowedTypes.includes(file.type)) {
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Hanya file gambar (jpg, png) yang diperbolehkan!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                fileInput.value = '';
                return;
            }

            if (file.size > maxSize) {
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Ukuran gambar maksimal 2MB!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                fileInput.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                defaultMessage.classList.add('hidden');
                imagePreview.classList.remove('hidden');
                removeButton.classList.remove('hidden');
            };
            reader.readAsDataURL(file);

            proofOfPaymentError.classList.add('hidden');
            fileInput.parentElement.classList.remove('border-red-500');
        }
    });

    removeButton.addEventListener('click', function() {
        fileInput.value = '';
        imagePreview.classList.add('hidden');
        removeButton.classList.add('hidden');
        defaultMessage.classList.remove('hidden');
        previewImg.src = '#';
        proofOfPaymentError.classList.add('hidden');
        fileInput.parentElement.classList.remove('border-red-500');
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
const proofOfPaymentInput = document.getElementById('proof_of_payment');
const customerNameError = document.getElementById('customer_name-error');
const customerEmailError = document.getElementById('customer_email-error');
const customerPhoneError = document.getElementById('customer_phone-error');
const productIdError = document.getElementById('product_id-error');
const startDateError = document.getElementById('start_date-error');
const endDateError = document.getElementById('end_date-error');
const proofOfPaymentError = document.getElementById('proof_of_payment-error');

if (form && customerNameInput && customerEmailInput && customerPhoneInput && productIdInput && startDateInput && endDateInput && proofOfPaymentInput && customerNameError && customerEmailError && customerPhoneError && productIdError && startDateError && endDateError && proofOfPaymentError) {
    document.addEventListener('DOMContentLoaded', function() {
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

    form.addEventListener('submit', function(event) {
        let hasError = false;

        customerNameError.classList.add('hidden');
        customerEmailError.classList.add('hidden');
        customerPhoneError.classList.add('hidden');
        productIdError.classList.add('hidden');
        startDateError.classList.add('hidden');
        endDateError.classList.add('hidden');
        proofOfPaymentError.classList.add('hidden');
        customerNameInput.classList.remove('border-red-500');
        customerEmailInput.classList.remove('border-red-500');
        customerPhoneInput.classList.remove('border-red-500');
        productIdInput.classList.remove('border-red-500');
        startDateInput.classList.remove('border-red-500');
        endDateInput.classList.remove('border-red-500');
        proofOfPaymentInput.parentElement.classList.remove('border-red-500');

        if (!customerNameInput.value.trim()) {
            customerNameError.textContent = 'Nama penyewa wajib diisi.';
            customerNameError.classList.remove('hidden');
            customerNameInput.classList.add('border-red-500');
            customerNameInput.focus();
            hasError = true;
        }

        if (customerEmailInput.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(customerEmailInput.value)) {
            customerEmailError.textContent = 'Email tidak valid.';
            customerEmailError.classList.remove('hidden');
            customerEmailInput.classList.add('border-red-500');
            if (!hasError) { customerEmailInput.focus(); hasError = true; }
        }

        if (customerPhoneInput.value && !/^\d{10,15}$/.test(customerPhoneInput.value.replace(/\D/g, ''))) {
            customerPhoneError.textContent = 'Nomor telepon tidak valid (minimal 10 digit).';
            customerPhoneError.classList.remove('hidden');
            customerPhoneInput.classList.add('border-red-500');
            if (!hasError) { customerPhoneInput.focus(); hasError = true; }
        }

        if (!productIdInput.value) {
            productIdError.textContent = 'Produk wajib dipilih.';
            productIdError.classList.remove('hidden');
            productIdInput.classList.add('border-red-500');
            if (!hasError) { productIdInput.focus(); hasError = true; }
        }

        const today = new Date().toISOString().split('T')[0];
        if (!startDateInput.value) {
            startDateError.textContent = 'Tanggal mulai wajib diisi.';
            startDateError.classList.remove('hidden');
            startDateInput.classList.add('border-red-500');
            if (!hasError) { startDateInput.focus(); hasError = true; }
        } else if (startDateInput.value < today) {
            startDateError.textContent = 'Tanggal mulai tidak boleh sebelum hari ini.';
            startDateError.classList.remove('hidden');
            startDateInput.classList.add('border-red-500');
            if (!hasError) { startDateInput.focus(); hasError = true; }
        }

        if (!endDateInput.value) {
            endDateError.textContent = 'Tanggal selesai wajib diisi.';
            endDateError.classList.remove('hidden');
            endDateInput.classList.add('border-red-500');
            if (!hasError) { endDateInput.focus(); hasError = true; }
        } else if (startDateInput.value && endDateInput.value) {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);
            if (endDate <= startDate) {
                endDateError.textContent = 'Tanggal selesai harus setelah tanggal mulai.';
                endDateError.classList.remove('hidden');
                endDateInput.classList.add('border-red-500');
                if (!hasError) { endDateInput.focus(); hasError = true; }
            }
        }

        if (!proofOfPaymentInput.files || proofOfPaymentInput.files.length === 0) {
            proofOfPaymentError.textContent = 'Foto bukti jaminan wajib diunggah.';
            proofOfPaymentError.classList.remove('hidden');
            proofOfPaymentInput.parentElement.classList.add('border-red-500');
            if (!hasError) { proofOfPaymentInput.focus(); hasError = true; }
        }

        if (hasError) {
            event.preventDefault();
            console.log('Form validation failed');
            return;
        }

        Swal.fire({
            title: 'Menyimpan...',
            text: 'Harap tunggu, sedang menyimpan rental.',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        const loadingSpinner = document.getElementById('loading-spinner');
        const defaultMessage = document.getElementById('default-message');
        const imagePreview = document.getElementById('image-preview');

        if (loadingSpinner && defaultMessage && imagePreview) {
            loadingSpinner.classList.remove('hidden');
            defaultMessage.classList.add('hidden');
            imagePreview.classList.add('hidden');
        }
    });

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
    endDateInput.addEventListener('change', function() {
        endDateError.classList.add('hidden');
        endDateInput.classList.remove('border-red-500');
    });
} else {
    console.error('Elements not found:', { form, customerNameInput, customerEmailInput, customerPhoneInput, productIdInput, startDateInput, endDateInput, proofOfPaymentInput, customerNameError, customerEmailError, customerPhoneError, productIdError, startDateError, endDateError, proofOfPaymentError });
}
</script>
@endsection