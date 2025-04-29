@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">{{ __('Detail Rental') }}</div>

        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <p><strong>Kode Rental:</strong> {{ $rental->rental_code }}</p>
              <p><strong>Nama Penyewa:</strong> {{ $rental->customer_name }}</p>
              <p><strong>Email Penyewa:</strong> {{ $rental->customer_email ?? '-' }}</p>
              <p><strong>Nomor Telepon Penyewa:</strong> {{ $rental->customer_phone ?? '-' }}</p>
              <p><strong>Produk:</strong> {{ $rental->product->name }}</p>
            </div>
            <div class="col-md-6">
              <p><strong>Tanggal Mulai:</strong> {{ $rental->start_date->format('d-m-Y') }}</p>
              <p><strong>Tanggal Selesai:</strong> {{ $rental->end_date->format('d-m-Y') }}</p>
              <p><strong>Durasi:</strong> {{ $rental->duration }} hari</p>
              <p><strong>Total Harga:</strong> Rp {{ number_format($rental->total_price, 0, ',', '.') }}</p>
              <p><strong>Status:</strong>
                @if($rental->status == 'pending')
                <span class="badge bg-warning">{{ __('Pending') }}</span>
                @elseif($rental->status == 'ongoing')
                <span class="badge bg-primary">{{ __('Ongoing') }}</span>
                @elseif($rental->status == 'completed')
                <span class="badge bg-success">{{ __('Completed') }}</span>
                @else
                <span class="badge bg-danger">{{ __('Canceled') }}</span>
                @endif
              </p>
              <p><strong>Bukti Pembayaran:</strong> {{ $rental->proof_of_payment ? 'Ada' : 'Tidak Ada' }}</p>
            </div>
          </div>

          <a href="{{ route('rentals.index') }}" class="mt-3 btn btn-secondary">{{ __('Kembali') }}</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection