<?php

namespace App\Exports;

use App\Models\Rental;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RentalsExport implements FromCollection, WithHeadings, WithMapping
{
  protected $rentals;

  public function __construct($rentals)
  {
    $this->rentals = $rentals;
  }

  public function collection()
  {
    return $this->rentals;
  }

  public function headings(): array
  {
    return [
      'Kode Rental',
      'Nama Penyewa',
      'Produk',
      'Tanggal Mulai',
      'Durasi (Hari)',
      'Tanggal Selesai',
      'Total Harga',
      'Status',
    ];
  }

  public function map($rental): array
  {
    return [
      $rental->rental_code,
      $rental->customer_name,
      $rental->product->name,
      \Carbon\Carbon::parse($rental->start_date)->format('d M Y'),
      $rental->duration,
      \Carbon\Carbon::parse($rental->end_date)->format('d M Y'),
      'Rp ' . number_format($rental->total_price, 0, ',', '.'),
      $rental->status === 'pending' ? 'Pending' : ($rental->status === 'ongoing' ? 'Sedang Disewa' : ($rental->status === 'completed' ? 'Selesai' : 'Dibatalkan')),
    ];
  }
}
