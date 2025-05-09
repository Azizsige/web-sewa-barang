@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-12">
    <h1 class="mb-4 fw-bold fs-3">Edit Kategori Produk</h1>
    <div class="shadow-sm card">
      <div class="card-body">
        <form method="POST" action="{{ route('categories.update', $category) }}" enctype="multipart/form-data"
          id="category-form">
          @csrf
          @method('PUT')
          <div class="mb-4">
            <label for="name" class="text-gray-700 form-label">Nama Kategori</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
              value="{{ old('name', $category->name) }}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="name-error" class="hidden mt-1 text-sm text-red-500"></div>
          </div>
          <div class="mb-4">
            <label for="description" class="text-gray-700 form-label">Deskripsi</label>
            <textarea name="description" id="description"
              class="form-control @error('description') is-invalid @enderror"
              rows="3">{{ old('description', $category->description) }}</textarea>
            @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="description-error" class="hidden mt-1 text-sm text-red-500"></div>
          </div>
          <div class="mb-4">
            <label for="slug" class="text-gray-700 form-label">Slug (Otomatis)</label>
            <input type="text" name="slug" id="slug" class="bg-gray-100 form-control" readonly
              value="{{ old('slug', $category->slug) }}">
            <p class="mt-1 text-sm text-gray-500">Slug akan otomatis di-generate dari nama kategori.</p>
          </div>
          <div class="mb-4">
            <label for="image" class="text-gray-700 form-label">Gambar Kategori</label>
            <div
              class="relative p-6 text-center border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 focus-within:ring-2 focus-within:ring-blue-500">
              <input type="file" name="image" id="image" accept="image/*"
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
              <div id="image-preview" class="mt-2 {{ $category->image ? '' : 'hidden' }}">
                <div class="relative inline-block">
                  <img id="preview-img" src="{{ $category->image ? asset('storage/' . $category->image) : '#' }}"
                    alt="Preview" class="h-auto max-w-full rounded-lg" style="max-width: 150px; max-height: 150px;" />
                  <button type="button" id="remove-image"
                    class="absolute -top-2 -right-2 text-red-500 hover:text-red-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                      stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </div>
              </div>
              <div id="default-message" class="{{ $category->image ? 'hidden' : '' }}">
                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18">
                  </path>
                </svg>
                <p class="mt-1 text-sm text-gray-600">Drag and drop gambar di sini, atau klik untuk pilih file</p>
                <p class="mt-1 text-xs text-gray-500">Hanya file gambar (jpg, png, gif), maksimal 2MB</p>
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
            @error('image')
            <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
            @enderror
            <div id="image-error" class="hidden mt-1 text-sm text-red-500"></div>
          </div>
          <div class="flex space-x-3">
            <button type="submit" class="px-4 py-2 btn btn-primary">Simpan</button>
            <a href="{{ route('categories.index') }}" class="px-4 py-2 btn btn-secondary">Batal</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  // Fungsi untuk generate slug dari nama
  function generateSlug(name) {
    if (!name) return '';
    return name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/-+/g, '-').trim();
  }

  // Validasi form sebelum submit
  const form = document.getElementById('category-form');
  const nameInput = document.getElementById('name');
  const descriptionInput = document.getElementById('description');
  const slugInput = document.getElementById('slug');
  const imageInput = document.getElementById('image');
  const nameError = document.getElementById('name-error');
  const descriptionError = document.getElementById('description-error');
  const imageError = document.getElementById('image-error');

  if (form && nameInput && descriptionInput && slugInput && imageInput && nameError && descriptionError && imageError) {
    // Update slug secara real-time saat user ketik
    nameInput.addEventListener('input', function() {
      console.log('Input event triggered, name:', this.value);
      const slug = generateSlug(this.value);
      console.log('Generated slug:', slug);
      slugInput.value = slug;

      // Hapus pesan error pas user mulai ketik
      nameError.classList.add('hidden');
      nameInput.classList.remove('border-red-500');
    });

    // Generate slug pas halaman dibuka dan cek pesan error
    document.addEventListener('DOMContentLoaded', function() {
      console.log('DOMContentLoaded, name value:', nameInput.value);
      if (nameInput.value) {
        slugInput.value = generateSlug(nameInput.value);
      }

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
      nameError.classList.add('hidden');
      descriptionError.classList.add('hidden');
      imageError.classList.add('hidden');
      nameInput.classList.remove('border-red-500');
      descriptionInput.classList.remove('border-red-500');
      imageInput.parentElement.classList.remove('border-red-500');

      // Cek nama kategori
      if (!nameInput.value.trim()) {
        nameError.textContent = 'Nama kategori wajib diisi.';
        nameError.classList.remove('hidden');
        nameInput.classList.add('border-red-500');
        nameInput.focus();
        hasError = true;
      }

      // Cek deskripsi (opsional, tapi kalau diisi, maksimal 500 karakter)
      if (descriptionInput.value && descriptionInput.value.length > 500) {
        descriptionError.textContent = 'Deskripsi maksimal 500 karakter.';
        descriptionError.classList.remove('hidden');
        descriptionInput.classList.add('border-red-500');
        if (!hasError) {
          descriptionInput.focus();
          hasError = true;
        }
      }

      // Cek gambar (hanya kalau user pilih file baru)
      if (imageInput.files && imageInput.files.length > 0) {
        const file = imageInput.files[0];
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        const maxSize = 2 * 1024 * 1024; // 2MB dalam bytes

        if (!allowedTypes.includes(file.type)) {
          imageError.textContent = 'Hanya file gambar (jpg, png, gif) yang diperbolehkan!';
          imageError.classList.remove('hidden');
          imageInput.parentElement.classList.add('border-red-500');
          if (!hasError) {
            imageInput.focus();
            hasError = true;
          }
        } else if (file.size > maxSize) {
          imageError.textContent = 'Ukuran gambar maksimal 2MB!';
          imageError.classList.remove('hidden');
          imageInput.parentElement.classList.add('border-red-500');
          if (!hasError) {
            imageInput.focus();
            hasError = true;
          }
        }
      }

      if (hasError) {
        event.preventDefault();
        console.log('Form validation failed');
        return;
      }

      // Tampilkan SweetAlert loading dan loading spinner di input gambar
      Swal.fire({
        title: 'Menyimpan...',
        text: 'Harap tunggu, sedang menyimpan kategori.',
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });

      // Tampilkan loading spinner di input gambar
      const loadingSpinner = document.getElementById('loading-spinner');
      const defaultMessage = document.getElementById('default-message');
      const imagePreview = document.getElementById('image-preview');

      if (loadingSpinner && defaultMessage && imagePreview) {
        loadingSpinner.classList.remove('hidden');
        defaultMessage.classList.add('hidden');
        imagePreview.classList.add('hidden');
      } else {
        console.error('Submit elements not found:', { loadingSpinner, defaultMessage, imagePreview });
      }
    });

    // Hapus pesan error pas user isi input
    nameInput.addEventListener('input', function() {
      nameError.classList.add('hidden');
      nameInput.classList.remove('border-red-500');
    });

    descriptionInput.addEventListener('input', function() {
      descriptionError.classList.add('hidden');
      descriptionInput.classList.remove('border-red-500');
    });

    // Handle preview gambar dan validasi
    imageInput.addEventListener('change', function(event) {
      console.log('Image input changed, file:', event.target.files[0]);
      const file = event.target.files[0];
      const defaultMessage = document.getElementById('default-message');
      const imagePreview = document.getElementById('image-preview');
      const previewImg = document.getElementById('preview-img');
      const removeButton = document.getElementById('remove-image');

      if (file) {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        const maxSize = 2 * 1024 * 1024; // 2MB dalam bytes

        if (!allowedTypes.includes(file.type)) {
          Swal.fire({
            title: 'Gagal!',
            text: 'Hanya file gambar (jpg, png, gif) yang diperbolehkan!',
            icon: 'error',
            confirmButtonText: 'OK'
          });
          imageInput.value = '';
          imageError.classList.remove('hidden');
          imageInput.parentElement.classList.add('border-red-500');
          return;
        }

        if (file.size > maxSize) {
          Swal.fire({
            title: 'Gagal!',
            text: 'Ukuran gambar maksimal 2MB!',
            icon: 'error',
            confirmButtonText: 'OK'
          });
          imageInput.value = '';
          imageError.classList.remove('hidden');
          imageInput.parentElement.classList.add('border-red-500');
          return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
          console.log('FileReader onload, result:', e.target.result);
          previewImg.src = e.target.result;
          defaultMessage.classList.add('hidden');
          imagePreview.classList.remove('hidden');
          removeButton.classList.remove('hidden');
        };
        reader.onerror = function(e) {
          console.error('FileReader error:', e);
        };
        reader.readAsDataURL(file);

        // Hapus pesan error
        imageError.classList.add('hidden');
        imageInput.parentElement.classList.remove('border-red-500');
      }
    });

    // Hapus gambar dari preview
    const removeButton = document.getElementById('remove-image');
    if (removeButton) {
      removeButton.addEventListener('click', function() {
        const defaultMessage = document.getElementById('default-message');
        const imagePreview = document.getElementById('image-preview');
        const previewImg = document.getElementById('preview-img');
        imageInput.value = ''; // Reset input file
        imagePreview.classList.add('hidden');
        removeButton.classList.add('hidden');
        defaultMessage.classList.remove('hidden');
        previewImg.src = '#'; // Reset src preview
        imageError.classList.add('hidden');
        imageInput.parentElement.classList.remove('border-red-500');
      });
    }
  } else {
    console.error('Elements not found:', { form, nameInput, descriptionInput, slugInput, imageInput, nameError, descriptionError, imageError });
  }
</script>
@endsection