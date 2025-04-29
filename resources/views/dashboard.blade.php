@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @if($isAdmin)
    <!-- Dashboard untuk Admin -->
    <!-- Row 1 -->
    <div class="row">
        <div class="col-lg-8 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Rental Overview</h5>
                        </div>
                        <div>
                            <form method="GET" action="{{ route('dashboard') }}">
                                <select name="month" class="form-select" onchange="this.form.submit()">
                                    @for($i = 0; $i < 12; $i++) <option
                                        value="{{ now()->subMonths($i)->format('Y-m') }}" {{ $selectedMonth==now()->
                                        subMonths($i)->format('Y-m') ? 'selected' : '' }}>
                                        {{ now()->subMonths($i)->format('M Y') }}
                                        </option>
                                        @endfor
                                </select>
                            </form>
                        </div>
                    </div>
                    <div id="chart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Product Status Breakdown -->
                    <div class="overflow-hidden card">
                        <div class="p-4 card-body">
                            <h5 class="card-title mb-9 fw-semibold">Product Status Breakdown</h5>
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h4 class="mb-3 fw-semibold">{{ $totalProducts }} Products</h4>
                                    <div class="mb-3 d-flex align-items-center">
                                        <span
                                            class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-arrow-up-left text-success"></i>
                                        </span>
                                        <p class="mb-0 text-dark me-1 fs-3">{{ $activeProducts }} Active</p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="me-4">
                                            <span class="round-8 bg-primary rounded-circle me-2 d-inline-block"></span>
                                            <span class="fs-2">Active</span>
                                        </div>
                                        <div>
                                            <span
                                                class="round-8 bg-light-primary rounded-circle me-2 d-inline-block"></span>
                                            <span class="fs-2">Inactive</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="d-flex justify-content-center">
                                        <div id="breakup"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <!-- Active Rentals -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-start">
                                <div class="col-8">
                                    <h5 class="card-title mb-9 fw-semibold">Active Rentals</h5>
                                    <h4 class="mb-3 fw-semibold">{{ $activeRentals }}</h4>
                                    <div class="pb-1 d-flex align-items-center">
                                        <span
                                            class="me-2 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-arrow-up-left text-success"></i>
                                        </span>
                                        <p class="mb-0 text-dark me-1 fs-3">{{ $totalCategories }}</p>
                                        <p class="mb-0 fs-3">Categories</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="d-flex justify-content-end">
                                        <div
                                            class="p-6 text-white bg-secondary rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="ti ti-box fs-6"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="earning"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="p-4 card-body">
                    <div class="mb-4">
                        <h5 class="card-title fw-semibold">Recent Rentals</h5>
                    </div>
                    <ul class="mb-0 timeline-widget position-relative mb-n5">
                        @forelse(\App\Models\Rental::with('product')->latest()->take(5)->get() as $rental)
                        <li class="overflow-hidden timeline-item d-flex position-relative">
                            <div class="flex-shrink-0 timeline-time text-dark text-end">
                                {{ $rental->created_at->format('H:i') }}
                            </div>
                            <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                <span
                                    class="timeline-badge border-2 border border-{{ $rental->status == 'pending' ? 'warning' : ($rental->status == 'ongoing' ? 'success' : 'primary') }} flex-shrink-0 my-8"></span>
                                <span class="flex-shrink-0 timeline-badge-border d-block"></span>
                            </div>
                            <div class="timeline-desc fs-3 text-dark mt-n1">
                                {{ $rental->product ? $rental->product->name : 'Product Not Found' }} rented by {{
                                $rental->customer_name }}
                            </div>
                        </li>
                        @empty
                        <li class="overflow-hidden timeline-item d-flex position-relative">
                            <div class="timeline-desc fs-3 text-dark mt-n1">No recent rentals found.</div>
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-8 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="p-4 card-body">
                    <h5 class="mb-4 card-title fw-semibold">Rental History</h5>
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle text-nowrap">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="mb-0 fw-semibold">ID</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="mb-0 fw-semibold">Product</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="mb-0 fw-semibold">User</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="mb-0 fw-semibold">Status</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="mb-0 fw-semibold">Start Date</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(\App\Models\Rental::with('product')->latest()->take(5)->get() as $index =>
                                $rental)
                                <tr>
                                    <td class="border-bottom-0">
                                        <h6 class="mb-0 fw-semibold">{{ $index + 1 }}</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="mb-1 fw-semibold">{{ $rental->product ? $rental->product->name :
                                            'Product Not Found' }}</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal">{{ $rental->customer_name }}</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <div class="gap-2 d-flex align-items-center">
                                            <span
                                                class="badge bg-{{ $rental->status == 'pending' ? 'warning' : ($rental->status == 'ongoing' ? 'success' : 'primary') }} rounded-3 fw-semibold">
                                                {{ ucfirst($rental->status) }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="mb-0 fw-semibold fs-4">{{ $rental->start_date->format('d M Y') }}
                                        </h6>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center border-bottom-0">
                                        <p class="mb-0 fw-normal">No rentals found.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @forelse(\App\Models\Product::with('primaryImage')->latest()->take(4)->get() as $product)
        <div class="col-sm-6 col-xl-3">
            <div class="overflow-hidden card rounded-2">
                <div class="position-relative">
                    <a href="{{ route('products.show', $product->slug) }}">
                        <img src="{{ $product->primaryImage ? asset('storage/' . $product->primaryImage->image_path) : '../assets/images/products/placeholder.jpg' }}"
                            class="card-img-top rounded-0" alt="{{ $product->name }}">
                    </a>
                </div>
                <div class="p-4 pt-3 card-body">
                    <h6 class="fw-semibold fs-4">{{ $product->name }}</h6>
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="mb-0 fw-semibold fs-4">Rp {{ number_format($product->price, 0, ',', '.') }}</h6>
                        <span class="badge bg-{{ $product->status == 'active' ? 'success' : 'danger' }}">{{
                            ucfirst($product->status) }}</span>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p class="text-center">No products available.</p>
        </div>
        @endforelse
    </div>
    @elseif($isDeveloper)
    <!-- Dashboard untuk Developer -->
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4 fw-bold fs-3">Developer Dashboard</h1>
            <div class="shadow-sm card">
                <div class="card-body">
                    <h5 class="mb-4 card-title fw-semibold">Daftar Pemilik Toko</h5>
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle text-nowrap">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="mb-0 fw-semibold">ID</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="mb-0 fw-semibold">Nama</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="mb-0 fw-semibold">Email</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="mb-0 fw-semibold">Tanggal Bergabung</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($shops as $index => $shop)
                                <tr>
                                    <td class="border-bottom-0">
                                        <h6 class="mb-0 fw-semibold">{{ $index + 1 }}</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="mb-1 fw-semibold">{{ $shop->name }}</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal">{{ $shop->email }}</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="mb-0 fw-semibold fs-4">{{ $shop->created_at->format('d M Y') }}</h6>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center border-bottom-0">
                                        <p class="mb-0 fw-normal">No shops found.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger">
                Unauthorized access.
            </div>
        </div>
    </div>
    @endif

    <div class="px-6 py-6 text-center">
        <p class="mb-0 fs-4">Design and Developed by <a href="https://adminmart.com/" target="_blank"
                class="pe-1 text-primary text-decoration-underline">AdminMart.com</a> Distributed by <a
                href="https://themewagon.com">ThemeWagon</a></p>
    </div>
</div>
@endsection

@section('scripts')
@if($isAdmin)
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Grafik Rental Overview
        var options = {
            series: [{
                name: 'Rentals',
                data: @json($data)
            }],
            chart: {
                height: 350,
                type: 'area'
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            xaxis: {
                categories: @json($labels)
            },
            tooltip: {
                x: {
                    format: 'MMM YYYY'
                },
            },
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();

        // Grafik Product Status Breakdown (Donut Chart)
        var breakupOptions = {
            series: [{{ $activeProducts }}, {{ $inactiveProducts }}],
            chart: {
                type: 'donut',
                width: 150,
            },
            labels: ['Active', 'Inactive'],
            colors: ['#1ab394', '#d7d7d7'],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 100
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var breakupChart = new ApexCharts(document.querySelector("#breakup"), breakupOptions);
        breakupChart.render();
    });
</script>
@endif
@endsection