<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Belajar FLowbite</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
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

    .modal__overlay {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.5);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 50;
      display: none;
    }

    .modal__overlay.is-open {
      display: flex;
    }

    .modal__container {
      max-height: 90vh;
      overflow-y: auto;
      width: 100%;
      max-width: 400px;
    }

    .modal__header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1rem;
    }

    .modal__title {
      margin: 0;
    }

    .modal__close::before {
      content: '\2715';
      font-size: 1.25rem;
    }

    .modal__content {
      margin-bottom: 1.5rem;
    }

    .modal__footer {
      display: flex;
      justify-content: flex-end;
      gap: 0.5rem;
    }

    .modal__btn {
      transition: background-color 0.2s ease;
    }
  </style>
</head>

<body class="bg-gray-100 w-[460px] mx-auto relative">
  <nav class="sticky top-0 z-10 bg-blue-600 border-gray-200">
    <div class="flex flex-wrap items-center justify-between max-w-screen-xl p-4 mx-auto">
      <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
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
            <a href="#"
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
          <a href="#"
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
            <a href="#"
              class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Templates</a>
          </div>
        </li>
        <li aria-current="page">
          <div class="flex items-center">
            <svg class="rtl:rotate-180 w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
              fill="none" viewBox="0 0 6 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 9 4-4-4-4" />
            </svg>
            <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Flowbite</span>
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
            <img class="h-auto max-w-full rounded-lg"
              src="https://flowbite.s3.amazonaws.com/docs/gallery/featured/image.jpg" alt="">
          </div>
        </div>
        <swiper-container class="mySwiper" space-between="30" slides-per-view="4">
          <swiper-slide>
            <img class="h-auto max-w-full rounded-lg hover:cursor-pointer"
              src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-1.jpg" alt="">
          </swiper-slide>
          <swiper-slide>
            <img class="h-auto max-w-full rounded-lg hover:cursor-pointer"
              src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-2.jpg" alt="">
          </swiper-slide>
          <swiper-slide>
            <img class="h-auto max-w-full rounded-lg hover:cursor-pointer"
              src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-3.jpg" alt="">
          </swiper-slide>
          <swiper-slide>
            <img class="h-auto max-w-full rounded-lg hover:cursor-pointer"
              src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-4.jpg" alt="">
          </swiper-slide>
          <swiper-slide>
            <img class="h-auto max-w-full rounded-lg hover:cursor-pointer"
              src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-5.jpg" alt="">
          </swiper-slide>
        </swiper-container>
      </div>
      <hr class="mt-6 mb-3 border-gray-200 mx-auto lg:my-8 w-[25rem]" />
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
          <h5 class="mb-1 text-md font-medium tracking-tight text-gray-900">Nama Produk : Nama Produknya</h5>
          <h5 class="mb-1 text-md font-medium tracking-tight text-gray-900">Jenis Produk : Jenis Produknya</h5>
          <h5 class="text-md font-medium tracking-tight text-gray-900">Stok Produk : Stok Produknya</h5>
          <hr class="my-3 border-gray-200 mx-auto lg:my-8 w-[25rem]" />
          <h5 class="mb-1 text-md font-medium tracking-tight text-gray-900">Deskripsi Produk :</h5>
          <h5 class="mb-1 text-sm font-medium tracking-tight text-gray-900">Deskripsi Produknya</h5>
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
          <p class="text-sm text-gray-500">This is some placeholder content the <strong
              class="font-medium text-gray-800">Dashboard tab's associated content</strong>. Clicking
            another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control
            the content visibility and styling.</p>
        </div>
      </div>

      <!-- Button Sewa Sekarang -->
      <div class="flex justify-center py-5 w-full bg-gray-50">
        <button id="sewa-sekarang-btn"
          class="inline-flex items-center justify-center w-full text-center mx-4 px-4 py-2 text-sm font-medium text-center text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
          data-micromodal-trigger="modal-sewa">
          Sewa Sekarang
        </button>
      </div>

      <!-- Modal Sewa -->
      <div class="modal micromodal-slide" id="modal-sewa" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
          <div class="modal__container bg-white rounded-lg p-6 max-w-sm mx-auto" role="dialog" aria-modal="true"
            aria-labelledby="modal-sewa-title">
            <header class="modal__header">
              <h2 class="modal__title text-lg font-semibold text-gray-900" id="modal-sewa-title">
                Sewa Produk
              </h2>
              <button class="modal__close text-gray-500 hover:text-gray-700" aria-label="Close modal"
                data-micromodal-close></button>
            </header>
            <main class="modal__content">
              <p class="text-sm text-gray-600 mb-4">
                Silakan masukkan detail sewa untuk produk ini.
              </p>
              <form>
                <div class="mb-4">
                  <label for="rental-date" class="block text-sm font-medium text-gray-700">Tanggal Sewa</label>
                  <input type="date" id="rental-date" name="rental-date"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                </div>
                <div class="mb-4">
                  <label for="rental-duration" class="block text-sm font-medium text-gray-700">Durasi Sewa
                    (hari)</label>
                  <input type="number" id="rental-duration" name="rental-duration" min="1"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                </div>
              </form>
            </main>
            <footer class="modal__footer">
              <button
                class="modal__btn modal__btn-primary bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700"
                data-micromodal-close>
                Konfirmasi
              </button>
              <button class="modal__btn text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-100" data-micromodal-close>
                Batal
              </button>
            </footer>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-white border-t border-gray-200 shadow-sm">
    <div class="w-full max-w-screen-xl p-4 mx-auto md:py-8">
      <div class="flex flex-col items-start justify-between gap-4">
        <a href="https://flowbite.com/" class="flex items-center mb-4 space-x-3 sm:mb-0 rtl:space-x-reverse">
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
      <span class="block text-sm text-gray-500 sm:text-center">© 2025 <a href="https://flowbite.com/"
          class="hover:underline">Rentalin™</a>. All Rights Reserved.</span>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
  <script src="https://unpkg.com/micromodal/dist/micromodal.min.js"></script>
  <script>
    MicroModal.init({})
    // document.addEventListener('DOMContentLoaded', function () {
    //         MicroModal.init({
    //             onShow: modal => console.log(`${modal.id} is shown`),
    //             onClose: modal => console.log(`${modal.id} is closed`),
    //             openTrigger: 'data-micromodal-trigger',
    //             closeTrigger: 'data-micromodal-close',
    //             disableScroll: true,
    //             awaitCloseAnimation: true,
    //             openClass: 'is-open',
    //             disableFocus: false
    //         });

    //         const modal = document.querySelector('#modal-sewa');
    //         if (modal.classList.contains('is-open')) {
    //             console.log('Modal terbuka otomatis saat render!');
    //             MicroModal.close('modal-sewa');
    //         }

    //         const sewaButton = document.querySelector('#sewa-sekarang-btn');
    //         sewaButton.addEventListener('click', () => {
    //             console.log('Tombol Sewa Sekarang diklik manual!');
    //         });
    //     });
  </script>
</body>

</html>