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
                        <a href="{{ route('produk') }}"
                            class="block px-3 py-2 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Produk</a>
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
                    class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-white bg-green-500 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-blue-300">
                    Sewa Sekarang
                    <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </a>
                <a href="{{ route('produk') }}"
                    class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-white bg-blue-600 border rounded-lg hover:text-gray-900 hover:bg-blue-700 hover:bg-gray-100 focus:ring-4 focus:ring-gray-400">
                    Lihat Produk
                </a>
            </div>
        </div>
    </section>

    {{-- 👉 Category --}}
    <div class="h-[100%] flex justify-center bg-white">
        <div class="h-[15rem] swiper">
            <div>
                <p class="mb-5 text-xl font-medium text-center text-gray-900">Kategori</p>
            </div>
            <div class="swiper-wrapper">
                @foreach ($categories as $kategori)
                <div class="swiper-slide w-[200px]">
                    <a href="{{ route('produk') }}?category={{ $kategori->slug }}"
                        class="group h-[100px] hover:bg-emerald-500 hover:cursor-pointer p-3 text-center flex flex-col items-center justify-center gap-[5px] bg-white border border-blue-200 rounded-lg shadow-xl transition-transform duration-300">
                        <img src="{{ $kategori->image ?? 'https://flowbite.com/docs/images/logo.svg' }}" class="h-20"
                            alt="{{ $kategori->name }} Icon" />
                        <p class="font-normal text-blue-800 transition-colors duration-200 group-hover:text-white">
                            {{ $kategori->name }}
                        </p>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>


    {{-- 👉 Product --}}
    <!-- 👉 Product -->
    <div class="container pt-10 pb-10 bg-white">
        <div class="wrapper-product">
            <div class="flex items-center justify-between px-3 mb-6 header-product">
                <div class="header-product__title">
                    <h1 class="text-xl font-medium text-center text-gray-900">Cari Barang Kamu</h1>
                </div>
                <div class="header-product_category">
                    <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown"
                        class="text-black bg-white border border-gray-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-regular rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center"
                        type="button">
                        {{ $selectedCategory ? $categories->firstWhere('slug', $selectedCategory)->name ?? 'Semua
                        Kategori' : 'Semua Kategori' }}
                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <div id="dropdown"
                        class="z-10 hidden bg-white border border-emerald-500 divide-y divide-gray-100 rounded-lg shadow-sm w-44">
                        <ul class="py-2 text-sm text-black" aria-labelledby="dropdownDefaultButton">
                            <li>
                                <a href="#" data-category=""
                                    class="block px-4 py-2 hover:bg-blue-100 hover:text-blue-800">Semua Kategori</a>
                            </li>
                            @foreach ($categories as $kategori)
                            <li>
                                <a href="#" data-category="{{ $kategori->slug }}"
                                    class="block px-4 py-2 hover:bg-blue-100 hover:text-blue-800">{{ $kategori->name
                                    }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div id="product-list"
                class="flex flex-wrap justify-center w-full gap-4 mx-auto text-center list-product relative">
                <div id="loading" class="hidden flex justify-center items-center bg-white bg-opacity-50">
                    <div role="status">
                        <svg aria-hidden="true"
                            class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
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
                @if ($products->isEmpty())
                <p class="text-gray-500">Tidak ada produk untuk kategori ini.</p>
                @else
                @foreach ($products as $product)
                <div class="w-[17rem] bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="flex justify-center items-center mt-2">
                        <img class="rounded-t-lg w-[12rem]"
                            src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                            alt="{{ $product->name }}" />
                    </div>
                    <div class="p-5">
                        <a href="{{ route('produk.detail', ['slug' => $product->slug]) }}">
                            <h5 class="justify-start mb-2 text-xl font-bold tracking-tight text-gray-900 text-start">
                                {{ $product->name }}
                            </h5>
                        </a>
                        <p class="mb-3 font-normal text-gray-700 text-start dark:text-gray-400">
                            Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}
                        </p>
                        <div class="text-end">
                            <a href="{{ route('produk.detail', ['slug' => $product->slug]) }}"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-500 rounded-lg hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                Detail
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
            <div id="see-more-button" class="button-see-more w-full flex justify-center mt-5 mb-5">
                @if ($products->count() > 0)
                <a href="{{ route('produk') }}"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-600 border rounded-lg hover:text-gray-900 hover:bg-blue-700 hover:bg-gray-100 focus:ring-4 focus:ring-gray-400">
                    Lihat Semua
                </a>
                @endif
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dropdownButton = document.getElementById('dropdownDefaultButton');
            const dropdownItems = document.querySelectorAll('#dropdown a');
            const productList = document.getElementById('product-list');
            const seeMoreButton = document.getElementById('see-more-button');
            const loadingSpinner = document.getElementById('loading');
    
            dropdownItems.forEach(item => {
                item.addEventListener('click', function (e) {
                    e.preventDefault();
    
                    // Hide product list and show loading spinner
                    productList.classList.add('hidden');
                    loadingSpinner.classList.remove('hidden');
                    loadingSpinner.classList.add('flex');
    
                    // Update teks tombol dropdown
                    const selectedText = this.textContent;
                    dropdownButton.childNodes[0].textContent = selectedText;
    
                    // Ambil kategori dari data attribute
                    const category = this.getAttribute('data-category');
    
                    // Kirim AJAX request
                    fetch(`/api/products?category=${category}`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                        },
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(products => {
                        // Kosongkan list produk
                        productList.innerHTML = '';
    
                        // Update tombol "Lihat Semua"
                        if (products.length > 0) {
                            seeMoreButton.innerHTML = `
                                <a href="{{ route('produk') }}"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-600 border rounded-lg hover:text-gray-900 hover:bg-blue-700 hover:bg-gray-100 focus:ring-4 focus:ring-gray-400">
                                    Lihat Semua
                                </a>
                            `;
                        } else {
                            seeMoreButton.innerHTML = '';
                        }
    
                        // Kalau nggak ada produk
                        if (products.length === 0) {
                            productList.innerHTML = '<p class="text-gray-500">Tidak ada produk untuk kategori ini.</p>';
                            return;
                        }
    
                        // Render produk baru
                        products.forEach(product => {
                            const productCard = `
                                <div class="w-[17rem] bg-white border border-gray-200 rounded-lg shadow-sm">
                                    <div class="flex justify-center items-center mt-2">
                                        <img class="rounded-t-lg w-[12rem]"
                                            src="/storage/${product.primary_image.image_path}"
                                            alt="${product.name}" />
                                    </div>
                                    <div class="p-5">
                                        <a href="/detail-produk/${product.slug}">
                                            <h5 class="justify-start mb-2 text-xl font-bold tracking-tight text-gray-900 text-start">
                                                ${product.name}
                                            </h5>
                                        </a>
                                        <p class="mb-3 font-normal text-gray-700 text-start dark:text-gray-400">
                                            Rp ${new Intl.NumberFormat('id-ID').format(product.price || 0)}
                                        </p>
                                        <div class="text-end">
                                            <a href="/detail-produk/${product.slug}"
                                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-500 rounded-lg hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                                Detail
                                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            `;
                            productList.innerHTML += productCard;
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching products:', error);
                        productList.innerHTML = '<p class="text-red-500">Terjadi kesalahan saat memuat produk.</p>';
                    })
                    .finally(() => {
                        // Show product list and hide loading spinner
                        productList.classList.remove('hidden');
                        loadingSpinner.classList.add('hidden');
                        loadingSpinner.classList.remove('flex');
                    });
                });
            });
        });
    </script>
</body>

</html>