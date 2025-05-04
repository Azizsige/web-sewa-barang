@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-12">
    <h1 class="mb-4 fw-bold fs-3">Edit Produk</h1>
    <div class="shadow-sm card">
      <div class="card-body">
        <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data"
          id="product-form">
          @csrf
          @method('PUT')
          <div class="mb-4">
            <label for="category_id" class="text-gray-700 form-label">Kategori</label>
            @if($categories && $categories->count() > 0)
            <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
              <option value="">Pilih Kategori</option>
              @foreach($categories as $category)
              <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ?
                'selected' : '' }}>{{ $category->name }}</option>
              @endforeach
            </select>
            @else
            <p class="text-sm text-red-500">Belum ada kategori. <a href="{{ route('categories.create') }}"
                class="text-blue-500 hover:underline">Tambah kategori dulu</a>.</p>
            <select name="category_id" id="category_id" class="form-select" disabled>
              <option value="">Pilih Kategori</option>
            </select>
            @endif
            @error('category_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="category-error" class="hidden mt-1 text-sm text-red-500"></div>
          </div>
          <div class="mb-4">
            <label for="name" class="text-gray-700 form-label">Nama Produk</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
              value="{{ old('name', $product->name) }}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="name-error" class="hidden mt-1 text-sm text-red-500"></div>
          </div>
          <div class="mb-4">
            <label for="slug" class="text-gray-700 form-label">Slug (Otomatis)</label>
            <input type="text" name="slug" id="slug" class="bg-gray-100 form-control" readonly
              value="{{ old('slug', $product->slug) }}">
            <p class="mt-1 text-sm text-gray-500">Slug akan otomatis di-generate dari nama produk.</p>
          </div>
          <div class="mb-4">
            <label for="description" class="text-gray-700 form-label">Deskripsi</label>
            <textarea name="description" id="description"
              class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
            @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-4">
            <label for="price" class="text-gray-700 form-label">Harga Sewa (per hari)</label>
            <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror"
              value="{{ old('price', $product->price) }}">
            @error('price')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="price-error" class="hidden mt-1 text-sm text-red-500"></div>
          </div>
          <div class="mb-4">
            <label for="stock" class="text-gray-700 form-label">Stok</label>
            <input type="number" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror"
              value="{{ old('stock', $product->stock) }}">
            @error('stock')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="stock-error" class="hidden mt-1 text-sm text-red-500"></div>
          </div>
          <div class="mb-4">
            <label class="font-semibold text-gray-700 form-label">Gambar Produk Saat Ini</label>
            @if($product->images->count() > 0)
            <p class="mb-3 text-sm text-gray-600">Drag gambar ke kiri/kanan untuk mengatur ulang urutan, pilih gambar
              utama, atau hapus gambar.</p>
            <div id="image-list" class="flex flex-row pb-4 space-x-4 overflow-x-auto">
              @foreach($product->images as $image)
              <div
                class="flex-none w-48 p-3 transition-shadow duration-200 bg-white border border-gray-200 rounded-lg shadow-sm cursor-move image-item hover:shadow-md"
                data-image-id="{{ $image->id }}">
                <div class="relative">
                  <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product Image"
                    class="object-cover w-full rounded-md h-36">
                  @if($image->is_primary)
                  <span
                    class="absolute px-2 py-1 text-xs font-semibold text-white bg-green-500 rounded top-2 left-2">Gambar
                    Utama</span>
                  @endif
                </div>
                <div class="flex items-center justify-between mt-3">
                  <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="radio" name="primary_image_id" value="{{ $image->id }}"
                      class="w-5 h-5 text-green-600 border-gray-300 primary-image-radio form-radio focus:ring-green-500"
                      {{ $image->is_primary ? 'checked' : '' }}>
                    <span class="text-sm font-medium text-gray-700">Utama</span>
                  </label>
                  <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="delete_images[]" value="{{ $image->id }}"
                      class="w-5 h-5 text-red-600 border-gray-300 delete-image-checkbox form-checkbox focus:ring-red-500">
                    <span class="text-sm font-medium text-red-600">Hapus</span>
                  </label>
                </div>
              </div>
              @endforeach
            </div>
            @else
            <p class="italic text-gray-500">Belum ada gambar untuk produk ini.</p>
            @endif
          </div>
          <div class="mb-4">
            <label for="images" class="font-semibold text-gray-700 form-label">Tambah Gambar Baru (Opsional)</label>
            <div
              class="relative p-6 text-center transition-all duration-200 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 focus-within:ring-2 focus-within:ring-blue-500">
              <input type="file" name="images[]" id="images" accept="image/*" multiple
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
              <div id="image-previews" class="flex flex-wrap gap-4 mt-2"></div>
              <div id="default-message">
                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18">
                  </path>
                </svg>
                <p class="mt-1 text-sm text-gray-600">Drag and drop gambar di sini, atau klik untuk pilih file</p>
                <p class="mt-1 text-xs text-gray-500">Hanya file gambar (jpg, png, gif), maksimal 2MB per file</p>
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
            @error('images.*')
            <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
            @enderror
            <div id="images-error" class="hidden mt-1 text-sm text-red-500"></div>
          </div>
          <div class="mb-4">
            <label class="flex items-center space-x-2 form-check-label">
              <input type="checkbox" name="is_bundle"
                class="w-5 h-5 text-blue-600 border-gray-300 form-check-input focus:ring-blue-500" {{ old('is_bundle',
                $product->is_bundle) ? 'checked' : '' }}>
              <span class="font-medium text-gray-700">Apakah ini paket (bundle)?</span>
            </label>
          </div>
          <div class="mb-4">
            <label for="status" class="font-semibold text-gray-700 form-label">Status</label>
            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
              <option value="active" {{ old('status', $product->status) === 'active' ? 'selected' : '' }}>Aktif</option>
              <option value="inactive" {{ old('status', $product->status) === 'inactive' ? 'selected' : '' }}>Non-Aktif
              </option>
            </select>
            @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="status-error" class="hidden mt-1 text-sm text-red-500"></div>
          </div>
          <div class="flex space-x-3">
            <button type="submit" class="px-4 py-2 btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('products.index') }}" class="px-4 py-2 btn btn-secondary">Batal</a>
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
  const loadingSpinner = document.getElementById('loading-spinner');
  const defaultMessage = document.getElementById('default-message');
  const imagePreviews = document.getElementById('image-previews');

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

      @if ($errors->any())
        let errorMessage = `@foreach ($errors->all() as $error)
          {{ $error }}<br>
        @endforeach`;
        Swal.fire({
          title: 'Gagal!',
          html: errorMessage,
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

          // Update validasi minimal 1 gambar secara real-time
          const deleteImages = document.querySelectorAll('input[name="delete_images[]"]:checked');
          const remainingImages = {{ $product->images->count() }} - deleteImages.length;
          const newImages = imagesInput.files ? imagesInput.files.length : 0;
          if (remainingImages + newImages === 0) {
            imagesError.textContent = 'Produk harus memiliki setidaknya satu gambar.';
            imagesError.classList.remove('hidden');
            imagesInput.parentElement.classList.add('border-red-500');
          } else {
            imagesError.classList.add('hidden');
            imagesInput.parentElement.classList.remove('border-red-500');
          }
        });
      });

      // Drag-and-drop untuk urutkan gambar
      const imageList = document.getElementById('image-list');
      if (imageList) {
        let draggedItem = null;

        const imageItems = document.querySelectorAll('.image-item');
        imageItems.forEach(item => {
          const imageId = item.dataset.imageId;
          if (!imageId) {
            console.error('Image item missing data-image-id:', item);
            item.style.border = '2px solid red';
            return;
          }
          item.setAttribute('draggable', true);
        });

        imageList.addEventListener('dragstart', function(e) {
          const target = e.target.closest('.image-item');
          if (target) {
            draggedItem = target;
            setTimeout(() => {
              draggedItem.classList.add('opacity-60', 'scale-95');
            }, 0);
            console.log('Drag started on:', draggedItem.dataset.imageId);
          }
        });

        imageList.addEventListener('dragend', function() {
          if (draggedItem) {
            draggedItem.classList.remove('opacity-60', 'scale-95');
            console.log('Drag ended on:', draggedItem.dataset.imageId);

            const imageItems = Array.from(imageList.querySelectorAll('.image-item'));
            const imageIds = imageItems
              .map(item => item.dataset.imageId)
              .filter(id => id);

            if (imageIds.length === 0) {
              Swal.fire({
                title: 'Gagal!',
                text: 'Tidak ada gambar yang valid untuk diurutkan.',
                icon: 'error',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
              });
              draggedItem = null;
              return;
            }

            fetch('{{ route('products.updateImageOrder', $product) }}', {
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
              },
              body: JSON.stringify({ image_ids: imageIds }),
            })
            .then(response => {
              console.log('Fetch response status:', response.status);
              if (!response.ok) {
                throw new Error('Server responded with status: ' + response.status);
              }
              return response.json();
            })
            .then(data => {
              console.log('Server response:', data);
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
              console.error('Error during fetch:', error);
              Swal.fire({
                title: 'Gagal!',
                text: error.message || 'Terjadi kesalahan saat memperbarui urutan.',
                icon: 'error',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
              });
            });

            draggedItem = null;
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
            console.log(`Moved from index ${draggedIndex} to ${targetIndex}`);
          }
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

      // Tampilkan spinner hanya setelah validasi lolos
      if (loadingSpinner && defaultMessage && imagePreviews) {
        loadingSpinner.classList.remove('hidden');
        defaultMessage.classList.add('hidden');
        imagePreviews.classList.add('hidden');
      }
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
            img.setAttribute('style', 'max-width: 150px; max-height: 150px;');
            img.classList.add('rounded-lg');
            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.classList.add('-top-2', '-right-2', 'text-red-500', 'hover:text-red-700', 'absolute');
            removeButton.innerHTML = `
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            `;
            removeButton.addEventListener('click', function() {
              imgContainer.remove();
              const dataTransfer = new DataTransfer();
              const remainingFiles = Array.from(imagesInput.files).filter((_, index) => index !== i);
              remainingFiles.forEach(file => dataTransfer.items.add(file));
              imagesInput.files = dataTransfer.files;
              if (imagePreviews.children.length === 0) {
                defaultMessage.classList.remove('hidden');
              }
              // Update validasi minimal 1 gambar
              const deleteImages = document.querySelectorAll('input[name="delete_images[]"]:checked');
              const remainingImages = {{ $product->images->count() }} - deleteImages.length;
              const newImages = imagesInput.files ? imagesInput.files.length : 0;
              if (remainingImages + newImages === 0) {
                imagesError.textContent = 'Produk harus memiliki setidaknya satu gambar.';
                imagesError.classList.remove('hidden');
                imagesInput.parentElement.classList.add('border-red-500');
              } else {
                imagesError.classList.add('hidden');
                imagesInput.parentElement.classList.remove('border-red-500');
              }
            });
            imgContainer.appendChild(img);
            imgContainer.appendChild(removeButton);
            imagePreviews.appendChild(imgContainer);
          };
          reader.readAsDataURL(file);
        }

        defaultMessage.classList.add('hidden');
      }

      // Update validasi minimal 1 gambar secara real-time
      const deleteImages = document.querySelectorAll('input[name="delete_images[]"]:checked');
      const remainingImages = {{ $product->images->count() }} - deleteImages.length;
      const newImages = imagesInput.files ? imagesInput.files.length : 0;
      if (remainingImages + newImages === 0) {
        imagesError.textContent = 'Produk harus memiliki setidaknya satu gambar.';
        imagesError.classList.remove('hidden');
        imagesInput.parentElement.classList.add('border-red-500');
      } else {
        imagesError.classList.add('hidden');
        imagesInput.parentElement.classList.remove('border-red-500');
      }
    });
  }
</script>
@endsection