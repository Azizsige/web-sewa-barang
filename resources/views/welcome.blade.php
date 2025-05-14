<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Belajar FLowbite</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-100 w-[460px] mx-auto relative">
    <nav class="sticky top-0 bg-blue-600 border-gray-200">
        <div class="flex flex-wrap items-center justify-between max-w-screen-xl p-4 mx-auto">
            <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Flowbite</span>
            </a>
            <button data-collapse-toggle="navbar-default" type="button"
                class="inline-flex bg-[#FFFDF6] items-center hover:cursor-pointer p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
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
                        <a href="#"
                            class="block px-3 py-2 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Products</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>



    <section
        class="shadow-lg bg-center bg-no-repeat bg-[url('https://flowbite.s3.amazonaws.com/docs/jumbotron/conference.jpg')] bg-gray-700 bg-blend-multiply">
        <div class="max-w-screen-xl px-4 py-24 mx-auto text-center">
            <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-white md:text-5xl lg:text-6xl">Sewa
                Alat Praktis untuk Sukses Bisnismu!</h1>
            <p class="mb-8 text-lg font-normal text-gray-300 lg:text-xl sm:px-16">Dari alat konstruksi hingga
                fotografi, temukan semua yang kamu butuh di sini. Sewa mudah, cepat, langsung dari HP!
            </p>
            <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-3">
                <a href="#"
                    class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-white bg-green-500 rounded-lg hover:bg-green-600 focus:ring-4 focus:ring-blue-300">
                    Sewa Sekarang
                    <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </a>
                <a href="#"
                    class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-white bg-blue-600 border rounded-lg hover:text-gray-900 hover:bg-blue-700 hover:bg-gray-100 focus:ring-4 focus:ring-gray-400">
                    Lihat Produk
                </a>
            </div>
        </div>
    </section>

    {{-- 👉 Category --}}
    <div class="h-[10rem] flex justify-center bg-white">
        <div class="h-[100%] swiper">
            <div class="swiper-wrapper">
                @foreach (['Elektronik', 'Pakaian', 'Kamera', 'Motor', 'Laptop'] as $kategori)
                <div class="swiper-slide w-[200px]"> {{-- ini penting: kasih width tetap --}}
                    <div
                        class="group h-[100px] hover:bg-green-500 hover:cursor-pointer p-3 text-center flex flex-col items-center justify-center gap-[5px] bg-white border border-gray-200 rounded-lg shadow-xl transition-transform duration-300">
                        <img src="https://flowbite.com/docs/images/logo.svg" class="h-20" alt="Flowbite Logo" />
                        <p class="font-normal text-green-500 transition-colors duration-200 group-hover:text-white">
                            {{ $kategori }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
            {{-- <div class="mt-4 swiper-pagination"></div> --}}
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>