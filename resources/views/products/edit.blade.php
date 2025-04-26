@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-12">
    <h1 class="fw-bold fs-3 mb-4">Edit Produk</h1>
    <div class="card shadow-sm">
      <div class="card-body">
        <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data"
          id="product-form">
          @csrf
          @method('PUT')
          <div class="mb-4">
            <label for="category_id" class="form-label text-gray-700">Kategori</label>
            @if($categories && $categories->count() > 0)
            <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
              <option value="">Pilih Kategori</option>
              @foreach($categories as $category)
              <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ?
                'selected' : '' }}>{{ $category->name }}</option>
              @endforeach
            </select>
            @else
            <p class="text-red-500 text-sm">Belum ada kategori. <a href="{{ route('categories.create') }}"
                class="text-blue-500 hover:underline">Tambah kategori dulu</a>.</p>
            <select name="category_id" id="category_id" class="form-select" disabled>
              <option value="">Pilih Kategori</option>
            </select>
            @endif
            @error('category_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="category-error" class="text-red-500 text-sm mt-1 hidden"></div>
          </div>
          <div class="mb-4">
            <label for="name" class="form-label text-gray-700">Nama Produk</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
              value="{{ old('name', $product->name) }}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="name-error" class="text-red-500 text-sm mt-1 hidden"></div>
          </div>
          <div class="mb-4">
            <label for="slug" class="form-label text-gray-700">Slug (Otomatis)</label>
            <input type="text" name="slug" id="slug" class="form-control bg-gray-100" readonly
              value="{{ old('slug', $product->slug) }}">
            <p class="text-sm text-gray-500 mt-1">Slug akan otomatis di-generate dari nama produk.</p>
          </div>
          <div class="mb-4">
            <label for="description" class="form-label text-gray-700">Deskripsi</label>
            <textarea name="description" id="description"
              class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
            @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-4">
            <label for="price" class="form-label text-gray-700">Harga Sewa (per hari)</label>
            <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror"
              value="{{ old('price', $product->price) }}">
            @error('price')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="price-error" class="text-red-500 text-sm mt-1 hidden"></div>
          </div>
          <div class="mb-4">
            <label for="stock" class="form-label text-gray-700">Stok</label>
            <input type="number" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror"
              value="{{ old('stock', $product->stock) }}">
            @error('stock')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="stock-error" class="text-red-500 text-sm mt-1 hidden"></div>
          </div>
          <div class="mb-4">
            <label class="form-label text-gray-700 font-semibold">Gambar Produk Saat Ini</label>
            @if($product->images->count() > 0)
            <p class="text-sm text-gray-600 mb-3">Drag gambar untuk mengatur ulang urutan, pilih gambar utama, atau
              hapus gambar.</p>
            <div id="image-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
              @foreach($product->images as $image)
              <div
                class="image-item relative bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 cursor-move p-3"
                data-image-id="{{ $image->id }}">
                <div class="relative">
                  <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product Image"
                    class="w-full h-48 object-cover rounded-md">
                  @if($image->is_primary)
                  <span
                    class="absolute top-2 left-2 bg-green-500 text-white text-xs font-semibold px-2 py-1 rounded">Gambar
                    Utama</span>
                  @endif
                </div>
                <div class="mt-3 flex items-center justify-between">
                  <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="radio" name="primary_image_id" value="{{ $image->id }}"
                      class="primary-image-radio form-radio h-5 w-5 text-green-600 border-gray-300 focus:ring-green-500"
                      {{ $image->is_primary ? 'checked' : '' }}>
                    <span class="text-sm text-gray-700 font-medium">Jadikan Utama</span>
                  </label>
                  <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="delete_images[]" value="{{ $image->id }}"
                      class="delete-image-checkbox form-checkbox h-5 w-5 text-red-600 border-gray-300 focus:ring-red-500">
                    <span class="text-sm text-red-600 font-medium">Hapus</span>
                  </label>
                </div>
              </div>
              @endforeach
            </div>
            @else
            <p class="text-gray-500 italic">Belum ada gambar untuk produk ini.</p>
            @endif
          </div>
          <div class="mb-4">
            <label for="images" class="form-label text-gray-700 font-semibold">Tambah Gambar Baru (Opsional)</label>
            <div
              class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gray-400 focus-within:ring-2 focus-within:ring-blue-500 transition-all duration-200">
              <input type="file" name="images[]" id="images" accept="image/*" multiple
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
              <div id="image-previews" class="mt-2 flex flex-wrap gap-4"></div>
              <div id="default-message">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18">
                  </path>
                </svg>
                <p class="mt-1 text-sm text-gray-600">Drag and drop gambar di sini, atau klik untuk pilih file</p>
                <p class="mt-1 text-xs text-gray-500">Hanya file gambar (jpg, png, gif), maksimal 2MB per file</p>
              </div>
              <div id="loading-spinner" class="hidden mt-2">
                <svg class="animate-spin h-8 w-8 text-blue-500 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none"
                  viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                <p class="mt-1 text-sm text-gray-600">Mengunggah...</p>
              </div>
            </div>
            @error('images.*')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
            <div id="images-error" class="text-red-500 text-sm mt-1 hidden"></div>
          </div>
          <div class="mb-4">
            <label class="form-check-label flex items-center space-x-2">
              <input type="checkbox" name="is_bundle"
                class="form-check-input h-5 w-5 text-blue-600 border-gray-300 focus:ring-blue-500" {{ old('is_bundle',
                $product->is_bundle) ? 'checked' : '' }}>
              <span class="text-gray-700 font-medium">Apakah ini paket (bundle)?</span>
            </label>
          </div>
          <div class="mb-4">
            <label for="status" class="form-label text-gray-700 font-semibold">Status</label>
            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
              <option value="active" {{ old('status', $product->status) === 'active' ? 'selected' : '' }}>Aktif</option>
              <option value="inactive" {{ old('status', $product->status) === 'inactive' ? 'selected' : '' }}>Non-Aktif
              </option>
            </select>
            @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="status-error" class="text-red-500 text-sm mt-1 hidden"></div>
          </div>
          <div class="flex space-x-3">
            <button type="submit" class="btn btn-primary px-4 py-2">Simpan Perubahan</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary px-4 py-2">Batal</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  function generateSlug(name) {
    if (!name) return '';
    return name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/-+/g, '-').trim();
}

const form = document.getElementById('product-form');
const categoryInput = document.getElementById('category_id');
const nameInput = document.getElementById('name');
const slugInput = document.getElementById('slug');
const priceInput = document.getElementById('price');
const stockInput = document.getElementById('stock');
const imagesInput = document.getElementById('images');
const statusInput = document.getElementById('status');
const categoryError = document.getElementById('category-error');
const nameError = document.getElementById('name-error');
const priceError = document.getElementById('price-error');
const stockError = document.getElementById('stock-error');
const imagesError = document.getElementById('images-error');
const statusError = document.getElementById('status-error');

if (form && categoryInput && nameInput && slugInput && priceInput && stockInput && imagesInput && statusInput && categoryError && nameError && priceError && stockError && imagesError && statusError) {
    nameInput.addEventListener('input', function() {
        console.log('Input event triggered, name:', this.value);
        const slug = generateSlug(this.value);
        console.log('Generated slug:', slug);
        slugInput.value = slug;

        nameError.classList.add('hidden');
        nameInput.classList.remove('border-red-500');
    });

    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOMContentLoaded, name value:', nameInput.value);
        if (nameInput.value) {
            slugInput.value = generateSlug(nameInput.value);
        }

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

        // Validasi primary image radio dan delete checkbox
        const primaryRadios = document.querySelectorAll('.primary-image-radio');
        const deleteCheckboxes = document.querySelectorAll('.delete-image-checkbox');
        
        deleteCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const primaryRadio = this.closest('.image-item').querySelector('.primary-image-radio');
                if (this.checked) {
                    primaryRadio.disabled = true;
                    primaryRadio.checked = false;
                } else {
                    primaryRadio.disabled = false;
                }

                // Pastikan minimal 1 primary image dipilih
                const checkedPrimary = document.querySelector('.primary-image-radio:checked');
                if (!checkedPrimary) {
                    const firstAvailableRadio = document.querySelector('.primary-image-radio:not([disabled])');
                    if (firstAvailableRadio) {
                        firstAvailableRadio.checked = true;
                    }
                }
            });
        });

        // Drag-and-drop untuk urutkan gambar
        const imageList = document.getElementById('image-list');
        if (imageList) {
            let draggedItem = null;

            imageList.addEventListener('dragstart', function(e) {
                if (e.target.classList.contains('image-item')) {
                    draggedItem = e.target;
                    setTimeout(() => {
                        draggedItem.classList.add('opacity-60', 'scale-95');
                    }, 0);
                }
            });

            imageList.addEventListener('dragend', function() {
                if (draggedItem) {
                    draggedItem.classList.remove('opacity-60', 'scale-95');
                    draggedItem = null;

                    // Ambil urutan baru
                    const imageItems = Array.from(imageList.querySelectorAll('.image-item'));
                    const imageIds = imageItems.map(item => item.dataset.imageId);

                    // Kirim urutan baru ke server
                    fetch('{{ route('products.updateImageOrder', $product) }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ image_ids: imageIds }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: data.message,
                                icon: 'success',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1500,
                            });
                        } else {
                            throw new Error(data.message || 'Gagal memperbarui urutan.');
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Gagal!',
                            text: error.message || 'Terjadi kesalahan saat memperbarui urutan.',
                            icon: 'error',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 1500,
                        });
                        console.error('Error:', error);
                    });
                }
            });

            imageList.addEventListener('dragover', function(e) {
                e.preventDefault();
            });

            imageList.addEventListener('dragenter', function(e) {
                e.preventDefault();
                const target = e.target.closest('.image-item');
                if (target && target !== draggedItem) {
                    target.classList.add('border-blue-400', 'shadow-lg');
                }
            });

            imageList.addEventListener('dragleave', function(e) {
                const target = e.target.closest('.image-item');
                if (target && target !== draggedItem) {
                    target.classList.remove('border-blue-400', 'shadow-lg');
                }
            });

            imageList.addEventListener('drop', function(e) {
                e.preventDefault();
                const target = e.target.closest('.image-item');
                if (target && target !== draggedItem) {
                    target.classList.remove('border-blue-400', 'shadow-lg');
                    const allItems = Array.from(imageList.children);
                    const draggedIndex = allItems.indexOf(draggedItem);
                    const targetIndex = allItems.indexOf(target);

                    if (draggedIndex < targetIndex) {
                        target.after(draggedItem);
                    } else {
                        target.before(draggedItem);
                    }
                }
            });

            // Tambah atribut draggable ke semua image-item
            document.querySelectorAll('.image-item').forEach(item => {
                item.setAttribute('draggable', true);
            });
        }
    });

    form.addEventListener('submit', function(event) {
        let hasError = false;

        categoryError.classList.add('hidden');
        nameError.classList.add('hidden');
        priceError.classList.add('hidden');
        stockError.classList.add('hidden');
        imagesError.classList.add('hidden');
        statusError.classList.add('hidden');
        categoryInput.classList.remove('border-red-500');
        nameInput.classList.remove('border-red-500');
        priceInput.classList.remove('border-red-500');
        stockInput.classList.remove('border-red-500');
        imagesInput.parentElement.classList.remove('border-red-500');
        statusInput.classList.remove('border-red-500');

        if (!categoryInput.value) {
            categoryError.textContent = 'Kategori wajib dipilih.';
            categoryError.classList.remove('hidden');
            categoryInput.classList.add('border-red-500');
            categoryInput.focus();
            hasError = true;
        }

        if (!nameInput.value.trim()) {
            nameError.textContent = 'Nama produk wajib diisi.';
            nameError.classList.remove('hidden');
            nameInput.classList.add('border-red-500');
            if (!hasError) {
                nameInput.focus();
                hasError = true;
            }
        }

        if (!priceInput.value || priceInput.value < 0) {
            priceError.textContent = 'Harga wajib diisi dan tidak boleh negatif.';
            priceError.classList.remove('hidden');
            priceInput.classList.add('border-red-500');
            if (!hasError) {
                priceInput.focus();
                hasError = true;
            }
        }

        if (!stockInput.value || stockInput.value < 0) {
            stockError.textContent = 'Stok wajib diisi dan tidak boleh negatif.';
            stockError.classList.remove('hidden');
            stockInput.classList.add('border-red-500');
            if (!hasError) {
                stockInput.focus();
                hasError = true;
            }
        }

        const deleteImages = document.querySelectorAll('input[name="delete_images[]"]:checked');
        const remainingImages = {{ $product->images->count() }} - deleteImages.length;
        const newImages = imagesInput.files ? imagesInput.files.length : 0;
        if (remainingImages + newImages === 0) {
            imagesError.textContent = 'Produk harus memiliki setidaknya satu gambar.';
            imagesError.classList.remove('hidden');
            imagesInput.parentElement.classList.add('border-red-500');
            if (!hasError) {
                imagesInput.focus();
                hasError = true;
            }
        }

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

        Swal.fire({
            title: 'Menyimpan...',
            text: 'Harap tunggu, sedang menyimpan produk.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    });

    categoryInput.addEventListener('change', function() {
        categoryError.classList.add('hidden');
        categoryInput.classList.remove('border-red-500');
    });

    nameInput.addEventListener('input', function() {
        nameError.classList.add('hidden');
        nameInput.classList.remove('border-red-500');
    });

    priceInput.addEventListener('input', function() {
        priceError.classList.add('hidden');
        priceInput.classList.remove('border-red-500');
    });

    stockInput.addEventListener('input', function() {
        stockError.classList.add('hidden');
        stockInput.classList.remove('border-red-500');
    });

    statusInput.addEventListener('change', function() {
        statusError.classList.add('hidden');
        statusInput.classList.remove('border-red-500');
    });

    imagesInput.addEventListener('change', function(event) {
        console.log('Images input changed, files:', event.target.files);
        const files = event.target.files;
        const defaultMessage = document.getElementById('default-message');
        const imagePreviews = document.getElementById('image-previews');

        imagePreviews.innerHTML = '';
        imagesError.classList.add('hidden');
        imagesInput.parentElement.classList.remove('border-red-500');

        if (files.length > 0) {
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            const maxSize = 2 * 1024 * 1024;

            for (let i = 0; i < files.length; i++) {
                const file = files[i];

                if (!allowedTypes.includes(file.type)) {
                    imagesError.textContent = 'Hanya file gambar (jpg, png, gif) yang diperbolehkan!';
                    imagesError.classList.remove('hidden');
                    imagesInput.parentElement.classList.add('border-red-500');
                    imagesInput.value = '';
                    imagePreviews.innerHTML = '';
                    return;
                }

                if (file.size > maxSize) {
                    imagesError.textContent = 'Ukuran gambar maksimal 2MB per file!';
                    imagesError.classList.remove('hidden');
                    imagesInput.parentElement.classList.add('border-red-500');
                    imagesInput.value = '';
                    imagePreviews.innerHTML = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgContainer = document.createElement('div');
                    imgContainer.classList.add('relative');
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('max-w-[100px]', 'h-auto', 'rounded-lg');
                    imgContainer.appendChild(img);
                    imagePreviews.appendChild(imgContainer);
                };
                reader.readAsDataURL(file);
            }

            defaultMessage.classList.add('hidden');
        }
    });

    form.addEventListener('submit', function() {
        if (!categoryInput.value || !nameInput.value.trim() || !priceInput.value || priceInput.value < 0 || !stockInput.value || stockInput.value < 0) return;
        const loadingSpinner = document.getElementById('loading-spinner');
        const defaultMessage = document.getElementById('default-message');
        const imagePreviews = document.getElementById('image-previews');

        if (loadingSpinner && defaultMessage && imagePreviews) {
            loadingSpinner.classList.remove('hidden');
            defaultMessage.classList.add('hidden');
            imagePreviews.classList.add('hidden');
        }
    });
}
</script>
@endsection