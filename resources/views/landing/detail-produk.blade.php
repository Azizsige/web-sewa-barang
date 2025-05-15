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


  {{-- 👉 Product --}}
  <div class="container pt-10 pb-10 bg-white">
    <div class="wrapper-product">
      <div class="flex items-center justify-between px-3 mb-6 header-product">
        <div class="header-product__title">
          <h1 class="text-xl font-medium text-center text-gray-900">Cari Barang Kamu </h1>
        </div>
        <div class="header-product_category">

          <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown"
            class="text-black bg-white border border-grey-100 focus:ring-4 focus:outline-none focus:ring-blue-300 font-regular rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center  "
            type="button">Kategori <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
              fill="none" viewBox="0 0 10 6">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 4 4 4-4" />
            </svg>
          </button>

          <!-- Dropdown menu -->
          <div id="dropdown"
            class="z-10 hidden bg-white border border-green-500 divide-y divide-gray-100 rounded-lg shadow-sm w-44">
            <ul class="py-2 text-sm text-black " aria-labelledby="dropdownDefaultButton">
              <li>
                <a href="#"
                  class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
              </li>
              <li>
                <a href="#"
                  class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
              </li>
              <li>
                <a href="#"
                  class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Earnings</a>
              </li>
              <li>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sign
                  out</a>
              </li>
            </ul>
          </div>

        </div>
      </div>
      <div class="flex flex-wrap justify-center w-full gap-4 mx-auto text-center list-product">
        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm ">
          <a href="#">
            <img class="rounded-t-lg" src="https://flowbite.com/docs/images/blog/image-1.jpg" alt="" />
          </a>
          <div class="p-5">
            <a href="#">
              <h5 class="justify-start mb-2 text-2xl font-bold tracking-tight text-gray-900 text-start">
                Nama Barang
              </h5>
            </a>
            <p class="mb-3 font-normal text-gray-700 text-start dark:text-gray-400">Harga Barang</p>
            <div class="text-end">
              <a href="#"
                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-500 rounded-lg hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-blue-300">
                Detail
                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                  fill="none" viewBox="0 0 14 10">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 5h12m0 0L9 1m4 4L9 9" />
                </svg>
              </a>
            </div>
          </div>
        </div>
        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm ">
          <a href="#">
            <img class="rounded-t-lg" src="https://flowbite.com/docs/images/blog/image-1.jpg" alt="" />
          </a>
          <div class="p-5">
            <a href="#">
              <h5 class="justify-start mb-2 text-2xl font-bold tracking-tight text-gray-900 text-start">
                Nama Barang
              </h5>
            </a>
            <p class="mb-3 font-normal text-gray-700 text-start dark:text-gray-400">Harga Barang</p>
            <div class="text-end">
              <a href="#"
                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-500 rounded-lg hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-blue-300">
                Detail
                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                  fill="none" viewBox="0 0 14 10">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 5h12m0 0L9 1m4 4L9 9" />
                </svg>
              </a>
            </div>
          </div>
        </div>
        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm ">
          <a href="#">
            <img class="rounded-t-lg" src="https://flowbite.com/docs/images/blog/image-1.jpg" alt="" />
          </a>
          <div class="p-5">
            <a href="#">
              <h5 class="justify-start mb-2 text-2xl font-bold tracking-tight text-gray-900 text-start">
                Nama Barang
              </h5>
            </a>
            <p class="mb-3 font-normal text-gray-700 text-start dark:text-gray-400">Harga Barang</p>
            <div class="text-end">
              <a href="#"
                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-500 rounded-lg hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-blue-300">
                Detail
                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                  fill="none" viewBox="0 0 14 10">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 5h12m0 0L9 1m4 4L9 9" />
                </svg>
              </a>
            </div>
          </div>
        </div>
        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm ">
          <a href="#">
            <img class="rounded-t-lg" src="https://flowbite.com/docs/images/blog/image-1.jpg" alt="" />
          </a>
          <div class="p-5">
            <a href="#">
              <h5 class="justify-start mb-2 text-2xl font-bold tracking-tight text-gray-900 text-start">
                Nama Barang
              </h5>
            </a>
            <p class="mb-3 font-normal text-gray-700 text-start dark:text-gray-400">Harga Barang</p>
            <div class="text-end">
              <a href="#"
                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-500 rounded-lg hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-blue-300">
                Detail
                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                  fill="none" viewBox="0 0 14 10">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 5h12m0 0L9 1m4 4L9 9" />
                </svg>
              </a>
            </div>
          </div>
        </div>
        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm ">
          <a href="#">
            <img class="rounded-t-lg" src="https://flowbite.com/docs/images/blog/image-1.jpg" alt="" />
          </a>
          <div class="p-5">
            <a href="#">
              <h5 class="justify-start mb-2 text-2xl font-bold tracking-tight text-gray-900 text-start">
                Nama Barang
              </h5>
            </a>
            <p class="mb-3 font-normal text-gray-700 text-start dark:text-gray-400">Harga Barang</p>
            <div class="text-end">
              <a href="#"
                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-500 rounded-lg hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-blue-300">
                Detail
                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                  fill="none" viewBox="0 0 14 10">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 5h12m0 0L9 1m4 4L9 9" />
                </svg>
              </a>
            </div>
          </div>
        </div>

        <div class="button-see-more">
          <a href="#"
            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-600 border rounded-lg hover:text-gray-900 hover:bg-blue-700 hover:bg-gray-100 focus:ring-4 focus:ring-gray-400">
            Tampilkan Lainnya
          </a>
        </div>

      </div>
    </div>
  </div>


  {{-- 👉 Footer --}}


  <footer class="bg-white border-t border-gray-200 shadow-sm ">
    <div class="w-full max-w-screen-xl p-4 mx-auto md:py-8">
      <div class="flex flex-col items-start justify-between gap-4">
        <a href="https://flowbite.com/" class="flex items-center mb-4 space-x-3 sm:mb-0 rtl:space-x-reverse">
          <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" />
          <span class="self-center text-2xl font-semibold whitespace-nowrap ">Rentalin</span>
        </a>
        <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 ">
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
      <span class="block text-sm text-gray-500 sm:text-center ">© 2025 <a href="https://flowbite.com/"
          class="hover:underline">Rentalin™</a>. All Rights Reserved.</span>
    </div>
  </footer>




  <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>