<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Detail Produk - {{ $product->name }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <style>
    .swiper {
      padding: 2rem 0 4rem 0 !important;
    }

    swiper-container {
      width: 100%;
      height: 120px;
      padding: 0 1rem;
    }

    swiper-slide {
      text-align: center;
      font-size: 18px;
      background: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    swiper-slide img {
      display: block;
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    div:where(.swal2-container) input:where(.swal2-input),
    div:where(.swal2-container) input:where(.swal2-file),
    div:where(.swal2-container) textarea:where(.swal2-textarea),
    div:where(.swal2-container) select:where(.swal2-select),
    div:where(.swal2-container) div:where(.swal2-radio),
    div:where(.swal2-container) label:where(.swal2-checkbox) {
      margin: 0 !important;
    }

    .flatpickr-input {
      width: 100%;
      padding: 0.5rem;
      border: 1px solid #d1d5db;
      border-radius: 0.375rem;
      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .flatpickr-input:focus {
      outline: none;
      border-color: #3b82f6;
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
    }
  </style>
</head>

<body class="bg-gray-100 w-[460px] mx-auto relative">
  <!-- Spinner Loading -->
  <div id="loading-overlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
    <div role="status">
      <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
        viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
          d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
          fill="currentColor" />
        <path
          d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
          fill="currentFill" />
      </svg>
      <span class="sr-only">Loading...</span>
    </div>
  </div>

  <nav class="sticky top-0 z-10 bg-blue-600 border-gray-200">
    <div class="flex flex-wrap items-center justify-between max-w-screen-xl p-4 mx-auto">
      <a href="{{ route('landing') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
        <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" />
        <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Rentalin</span>
      </a>
      <button data-collapse-toggle="navbar-default" type="button"
        class="inline-flex bg-[#FFFDF6] items-center hover:cursor-pointer p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
        aria-controls="navbar-default" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M1 1h15M1 7h15M1 13h15" />
        </svg>
      </button>
      <div class="hidden w-full mt-5 duration-300 ease-in-out md:block md:w-auto" id="navbar-default">
        <ul
          class="font-medium flex gap-[1rem] p-[1rem] flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
          <li class="mr-0 me-0 me-[0px]">
            <a href="{{ route('landing') }}"
              class="block px-3 py-2 text-white bg-blue-700 rounded-sm md:bg-transparent md:text-blue-700 dark:text-white md:dark:text-blue-500"
              aria-current="page">Home</a>
          </li>
          <li>
            <a href="{{ route('produk') }}"
              class="block px-3 py-2 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Produk</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Breadcrumb -->
  <div class="bg-white pt-[1rem]">
    <nav class="flex px-5 ml-[1rem] mr-[1rem] py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50"
      aria-label="Breadcrumb">
      <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
        <li class="inline-flex items-center">
          <a href="{{ route('landing') }}"
            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
            <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
              viewBox="0 0 20 20">
              <path
                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
            </svg>
            Home
          </a>
        </li>
        <li>
          <div class="flex items-center">
            <svg class="rtl:rotate-180 block w-3 h-3 mx-1 text-gray-400" aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 9 4-4-4-4" />
            </svg>
            <a href="{{ route('produk') }}"
              class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Produk</a>
          </div>
        </li>
        <li aria-current="page">
          <div class="flex items-center">
            <svg class="rtl:rotate-180 w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
              fill="none" viewBox="0 0 6 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 9 4-4-4-4" />
            </svg>
            <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">{{ $product->name }}</span>
          </div>
        </li>
      </ol>
    </nav>
  </div>

  <!-- Product -->
  <div class="container pt-10 pb-10 bg-white">
    <div class="wrapper-product border border-gray-200 rounded-lg shadow-sm ml-[1rem] mr-[1rem]">
      <div class="flex flex-wrap justify-center w-full gap-4 mx-auto text-center list-product">
        <div>
          <div>
            <img class="h-[15rem] max-w-full rounded-lg"
              src="{{ asset('storage/' . $product->primaryImage->image_path) }}" alt="{{ $product->name }}">
          </div>
        </div>
        <swiper-container class="mySwiper" space-between="30" slides-per-view="4">
          @foreach ($product->images as $image)
          <swiper-slide>
            <img class="h-auto max-w-full rounded-lg hover:cursor-pointer"
              src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }} Image">
          </swiper-slide>
          @endforeach
        </swiper-container>
      </div>
      <hr class="mt-6 mb-0 border-gray-200 mx-auto lg:my-8 w-[25rem]" />
      <div class="border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
          data-tabs-toggle="#default-tab-content" role="tablist">
          <li class="me-2 hover:cursor-pointer" role="presentation">
            <button class="inline-block hover:cursor-pointer p-4 border-b-2 rounded-t-lg" id="profile-tab"
              data-tabs-target="#profile" type="button" role="tab" aria-controls="profile"
              aria-selected="false">Keterangan Produk</button>
          </li>
          <li class="me-2 hover:cursor-pointer" role="presentation">
            <button class="inline-block p-4 border-b-2 hover:cursor-pointer rounded-t-lg" id="dashboard-tab"
              data-tabs-target="#dashboard" type="button" role="tab" aria-controls="dashboard"
              aria-selected="false">Ketentuan Sewa</button>
          </li>
        </ul>
      </div>
      <div id="default-tab-content">
        <div class="hidden p-4 rounded-lg bg-gray-50" id="profile" role="tabpanel" aria-labelledby="profile-tab">
          <h5 class="mb-1 text-md font-medium tracking-tight text-gray-900">Nama Produk: {{ $product->name }}</h5>
          <h5 class="mb-1 text-md font-medium tracking-tight text-gray-900">Jenis Produk: {{ $product->category->name }}
          </h5>
          <h5 class="text-md font-medium tracking-tight text-gray-900">Stok Produk: {{ $product->stock }}</h5>
          <h5 class="text-md font-medium tracking-tight text-gray-900">Harga: Rp {{ number_format($product->price, 0,
            ',', '.') }}</h5>
          <hr class="my-3 border-gray-200 mx-auto lg:my-8 w-[25rem]" />
          <h5 class="mb-1 text-md font-medium tracking-tight text-gray-900">Deskripsi Produk:</h5>
          <p class="mb-1 text-sm font-medium tracking-tight text-gray-900">{{ $product->description ?? 'Tidak ada
            deskripsi.' }}</p>
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
          <p class="text-sm text-gray-500">Syarat dan ketentuan sewa produk ini akan ditambahkan nanti.</p>
        </div>
      </div>

      <!-- Button Sewa Sekarang -->
      <div class="flex justify-center py-5 w-full bg-gray-50">
        <button id="sewa-sekarang-btn"
          class="inline-flex items-center justify-center w-full text-center mx-4 px-4 py-2 text-sm font-medium text-center text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
          Sewa Sekarang
        </button>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-white border-t border-gray-200 shadow-sm">
    <div class="w-full max-w-screen-xl p-4 mx-auto md:py-8">
      <div class="flex flex-col items-start justify-between gap-4">
        <a href="{{ route('landing') }}" class="flex items-center mb-4 space-x-3 sm:mb-0 rtl:space-x-reverse">
          <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" />
          <span class="self-center text-2xl font-semibold whitespace-nowrap">Rentalin</span>
        </a>
        <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0">
          <li>
            <a href="#" class="hover:underline me-4 md:me-6">About</a>
          </li>
          <li>
            <a href="#" class="hover:underline me-4 md:me-6">Privacy Policy</a>
          </li>
          <li>
            <a href="#" class="hover:underline me-4 md:me-6">Licensing</a>
          </li>
          <li>
            <a href="#" class="hover:underline">Contact</a>
          </li>
        </ul>
      </div>
      <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
      <span class="block text-sm text-gray-500 sm:text-center">© 2025 <a href="{{ route('landing') }}"
          class="hover:underline">Rentalin™</a>. All Rights Reserved.</span>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
            const sewaButton = document.querySelector('#sewa-sekarang-btn');
            sewaButton.addEventListener('click', function () {
                Swal.fire({
                    title: 'Sewa Produk',
                    html: `
                        <p class="text-sm text-gray-600 mb-4">Silakan masukkan detail sewa untuk produk ini.</p>
                        <form id="sewa-form">
                            <div class="mb-4">
                                <label for="first_name" class="block mb-2 text-sm text-left font-medium text-gray-900">Nama Lengkap</label>
                                <input type="text" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="John" required />
                            </div>
                            <div class="mb-4">
                                <label for="wa" class="block mb-2 text-sm text-left font-medium text-gray-900">Nomor Whatsapp</label>
                                <input type="number" id="wa" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="ex: 089122xxxxxx" required />
                            </div>
                            <div class="mb-4">
                                <label for="rental-date" class="block text-left mb-2 text-sm font-medium text-gray-700">Tanggal Sewa</label>
                                <input type="text" id="rental-date" name="rental-date" class="flatpickr-input m-0 swal2-input mt-1 block w-full rounded-md bg-gray-50 border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            </div>
                            <div class="mb-4">
                                <label for="rental-duration" class="text-left mb-2 block text-sm font-medium text-gray-700">Durasi Sewa (hari)</label>
                                <input type="number" id="rental-duration" name="rental-duration" min="1" class="m-0 swal2-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            </div>
                            <div class="mb-4">
                                <label for="message" class="block text-left mb-2 text-sm font-medium text-gray-900">Catatan</label>
                                <textarea id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Konfirmasi',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    preConfirm: () => {
                        const firstName = document.getElementById('first_name').value;
                        const wa = document.getElementById('wa').value;
                        const rentalDate = document.getElementById('rental-date').value;
                        const rentalDuration = document.getElementById('rental-duration').value;
                        const message = document.getElementById('message').value;
                        if (!firstName || !wa || !rentalDate || !rentalDuration) {
                            Swal.showValidationMessage('Nama Lengkap, Nomor Whatsapp, Tanggal Sewa, dan Durasi harus diisi!');
                            return false;
                        }
                        return { firstName, wa, rentalDate, rentalDuration, message };
                    },
                    allowOutsideClick: false,
                    didOpen: () => {
                        flatpickr('#rental-date', {
                            dateFormat: 'Y-m-d',
                            minDate: 'today',
                            disableMobile: true,
                        });
                        document.getElementById('first_name').focus();
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log('Data Sewa:', result.value);
                        fetch('/api/sewa', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                product_id: '{{ $product->id }}',
                                first_name: result.value.firstName,
                                whatsapp: result.value.wa,
                                rental_date: result.value.rentalDate,
                                rental_duration: result.value.rentalDuration,
                                message: result.value.message
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            Swal.fire('Sukses!', 'Sewa berhasil disimpan!', 'success');
                        })
                        .catch(error => {
                            Swal.fire('Error!', 'Gagal menyimpan sewa.', 'error');
                        });
                    }
                });
            });

            // Sembunyiin spinner pas halaman selesai load
            const loadingOverlay = document.getElementById('loading-overlay');
            loadingOverlay.classList.add('hidden');

            // Script untuk mengubah gambar utama saat klik thumbnail
            const mainImage = document.querySelector('.list-product img:first-child');
            const thumbnails = document.querySelectorAll('.mySwiper swiper-slide img');

            thumbnails.forEach(thumbnail => {
                thumbnail.addEventListener('click', function () {
                    const newSrc = this.src;
                    mainImage.src = newSrc;
                    mainImage.alt = this.alt;
                });
            });
        });
  </script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</body>

</html>