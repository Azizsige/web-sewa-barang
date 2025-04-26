@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <h1 class="fw-bold fs-3">Detail Rental</h1>
      <a href="{{ route('rentals.index') }}" class="btn btn-secondary mb-3">Kembali</a>
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <p><strong>Kode Rental:</strong> {{ $rental->rental_code }}</p>
              <p><strong>Nama Penyewa:</strong> {{ $rental->customer_name }}</p>
              <p><strong>Email Penyewa:</strong> {{ $rental->customer_email ?? '-' }}</p>
              <p><strong>Nomor Telepon:</strong> {{ $rental->customer_phone ?? '-' }}</p>
              <p><strong>Produk:</strong> {{ $rental->product->name }}</p>
              <p><strong>Tanggal Mulai:</strong> {{ \Carbon\Carbon::parse($rental->start_date)->format('d M Y') }}</p>
              <p><strong>Durasi:</strong> {{ $rental->duration }} hari</p>
              <p><strong>Tanggal Selesai:</strong> {{ \Carbon\Carbon::parse($rental->end_date)->format('d M Y') }}</p>
              <p><strong>Total Harga:</strong> Rp {{ number_format($rental->total_price, 0, ',', '.') }}</p>
              <p><strong>Status:</strong>
                @if($rental->status === 'pending')
                <span class="badge bg-warning">Pending</span>
                @elseif($rental->status === 'ongoing')
                <span class="badge bg-info">Sedang Disewa</span>
                @elseif($rental->status === 'completed')
                <span class="badge bg-success">Selesai</span>
                @elseif($rental->status === 'canceled')
                <span class="badge bg-danger">Dibatalkan</span>
                @endif
              </p>
            </div>
            <div class="col-md-6">
              @if($rental->proof_of_payment)
              <p><strong>Bukti Pembayaran:</strong></p>
              <img src="{{ asset('storage/' . $rental->proof_of_payment) }}" alt="Bukti Pembayaran" class="img-fluid"
                style="max-width: 300px;">
              @else
              <p><strong>Bukti Pembayaran:</strong> Tidak ada</p>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection