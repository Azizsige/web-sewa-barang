@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="text-xl font-bold card-header">{{ __('Detail Rental') }}</div>

        <div class="card-body">
          <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div class="space-y-4">
              <p><strong>Kode Rental:</strong> <span class="text-gray-700">{{ $rental->rental_code }}</span></p>
              <p><strong>Nama Penyewa:</strong> <span class="text-gray-700">{{ $rental->customer_name }}</span></p>
              <p><strong>Email Penyewa:</strong> <span class="text-gray-700">{{ $rental->customer_email ?? '-' }}</span>
              </p>
              <p><strong>Nomor Telepon Penyewa:</strong> <span class="text-gray-700">{{ $rental->customer_phone ?? '-'
                  }}</span></p>
              <p><strong>Produk:</strong> <span class="text-gray-700">{{ $rental->product->name }}</span></p>
            </div>
            <div class="space-y-4">
              <p><strong>Tanggal Mulai:</strong> <span class="text-gray-700">{{ $rental->start_date->format('d-m-Y')
                  }}</span></p>
              <p><strong>Tanggal Selesai:</strong> <span class="text-gray-700">{{ $rental->end_date->format('d-m-Y')
                  }}</span></p>
              <p><strong>Durasi:</strong> <span class="text-gray-700">{{ $rental->duration }} hari</span></p>
              <p><strong>Total Harga:</strong> <span class="text-gray-700">Rp {{ number_format($rental->total_price, 0,
                  ',', '.') }}</span></p>
              <p><strong>Status:</strong>
                @if($rental->status == 'pending')
                <span class="text-white badge bg-warning">{{ __('Pending') }}</span>
                @elseif($rental->status == 'ongoing')
                <span class="text-white badge bg-primary">{{ __('Ongoing') }}</span>
                @elseif($rental->status == 'completed')
                <span class="text-white badge bg-success">{{ __('Completed') }}</span>
                @else
                <span class="text-white badge bg-danger">{{ __('Canceled') }}</span>
                @endif
              </p>
              <p><strong>Foto Bukti Jaminan:</strong>
                @if($rental->proof_of_payment)
              <div class="mt-2">
                <img src="{{ Storage::url($rental->proof_of_payment) }}" alt="Bukti Jaminan"
                  class="h-auto max-w-xs rounded-lg shadow-md">
              </div>
              @else
              <span class="italic text-gray-500">Belum ada foto</span>
              @endif
              </p>
            </div>
          </div>

          <div class="mt-6">
            <a href="{{ route('rentals.index') }}" class="px-4 py-2 btn btn-secondary">{{ __('Kembali') }}</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection