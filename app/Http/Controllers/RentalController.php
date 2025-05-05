<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rental;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class RentalController extends Controller
{
    public function index(Request $request)
    {
        $query = Rental::with('product')->latest();

        if ($request->has('status') && in_array($request->status, ['pending', 'ongoing', 'completed', 'canceled'])) {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('rental_code', 'like', "%{$search}%");
            });
        }

        if ($request->has('date_from') && $request->has('date_to')) {
            $dateFrom = $request->date_from;
            $dateTo = $request->date_to;
            if ($dateFrom && $dateTo) {
                $query->whereBetween('start_date', [$dateFrom, $dateTo]);
            }
        }

        $rentals = $query->paginate(10)->appends($request->query());

        return view('rentals.index', compact('rentals'));
    }

    public function export(Request $request)
    {
        $query = Rental::with('product');

        if ($request->has('status') && in_array($request->status, ['pending', 'ongoing', 'completed', 'canceled'])) {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('rental_code', 'like', "%{$search}%");
            });
        }

        if ($request->has('date_from') && $request->has('date_to')) {
            $dateFrom = $request->date_from;
            $dateTo = $request->date_to;
            if ($dateFrom && $dateTo) {
                $query->whereBetween('start_date', [$dateFrom, $dateTo]);
            }
        }

        $rentals = $query->latest()->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'A1' => 'Kode Rental',
            'B1' => 'Nama Penyewa',
            'C1' => 'Produk',
            'D1' => 'Tanggal Mulai',
            'E1' => 'Durasi (Hari)',
            'F1' => 'Tanggal Selesai',
            'G1' => 'Total Harga',
            'H1' => 'Status'
        ];
        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        $headerRange = 'A1:H1';
        $sheet->getStyle($headerRange)->getFont()->setBold(true);
        $sheet->getStyle($headerRange)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCCCCC');
        $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $row = 2;
        foreach ($rentals as $rental) {
            $sheet->setCellValue('A' . $row, $rental->rental_code);
            $sheet->setCellValue('B' . $row, $rental->customer_name);
            $sheet->setCellValue('C' . $row, $rental->product->name);
            $sheet->setCellValue('D' . $row, \Carbon\Carbon::parse($rental->start_date)->format('d M Y'));
            $sheet->setCellValue('E' . $row, $rental->duration);
            $sheet->setCellValue('F' . $row, \Carbon\Carbon::parse($rental->end_date)->format('d M Y'));
            $sheet->setCellValue('G' . $row, $rental->total_price);
            $sheet->setCellValue('H' . $row, $rental->status === 'pending' ? 'Pending' : ($rental->status === 'ongoing' ? 'Sedang Disewa' : ($rental->status === 'completed' ? 'Selesai' : 'Dibatalkan')));
            $row++;
        }

        $sheet->getStyle('G2:G' . ($row - 1))->getNumberFormat()->setFormatCode('Rp #,##0');
        $styleArray = [
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000']]],
        ];
        $sheet->getStyle('A1:H' . ($row - 1))->applyFromArray($styleArray);

        foreach (range('A', 'H') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $filename = 'rentals_export_' . date('Ymd_His') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $tempFile = storage_path('app/public/' . $filename);
        $writer->save($tempFile);

        if (auth()->check() && auth()->user()->role === 'admin') {
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'exported',
                'model_type' => 'Rental',
                'description' => 'Admin ' . auth()->user()->name . ' mengekspor data rental.',
            ]);
        }

        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }

    public function show(Rental $rental)
    {
        $rental->load('product');
        return view('rentals.show', compact('rental'));
    }

    public function create()
    {
        $products = Product::active()->where('stock', '>', 0)->with('primaryImage')->get();
        return view('rentals.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email',
            'customer_phone' => 'nullable|string|max:15',
            'product_id' => 'required|exists:products,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'proof_of_payment' => 'required|image|mimes:jpg,png|max:2048',
        ]);

        try {
            $rental = DB::transaction(function () use ($request) {
                $product = Product::lockForUpdate()->findOrFail($request->product_id);

                if ($product->status !== 'active') {
                    throw new \Exception('Produk yang dipilih tidak aktif.');
                }

                $start_date = \Carbon\Carbon::parse($request->start_date);
                $end_date = \Carbon\Carbon::parse($request->end_date);
                $overlappingRentals = Rental::where('product_id', $product->id)
                    ->where('status', 'ongoing')
                    ->where(function ($query) use ($start_date, $end_date) {
                        $query->whereBetween('start_date', [$start_date, $end_date])
                            ->orWhereBetween('end_date', [$start_date, $end_date])
                            ->orWhere(function ($q) use ($start_date, $end_date) {
                                $q->where('start_date', '<=', $start_date)
                                    ->where('end_date', '>=', $end_date);
                            });
                    })
                    ->exists();

                if ($overlappingRentals) {
                    throw new \Exception('Produk sudah disewa pada rentang tanggal tersebut.');
                }

                if ($product->stock <= 0) {
                    throw new \Exception('Stok produk tidak cukup.');
                }

                $duration = $start_date->diffInDays($end_date);
                $total_price = $product->price * $duration;

                $proofOfPaymentPath = null;
                if ($request->hasFile('proof_of_payment')) {
                    $proofOfPaymentPath = $request->file('proof_of_payment')->store('rentals/jaminan', 'public');
                }

                $rental = Rental::create([
                    'customer_name' => $request->customer_name,
                    'customer_email' => $request->customer_email,
                    'customer_phone' => $request->customer_phone,
                    'product_id' => $request->product_id,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'total_price' => $total_price,
                    'status' => 'ongoing',
                    'proof_of_payment' => $proofOfPaymentPath,
                ]);

                $product->decrement('stock');

                if (auth()->check() && auth()->user()->role === 'admin') {
                    ActivityLog::create([
                        'user_id' => auth()->id(),
                        'action' => 'created',
                        'model_type' => 'Rental',
                        'model_id' => $rental->id,
                        'description' => 'Admin ' . auth()->user()->name . ' menambah rental ' . $rental->rental_code,
                    ]);
                }

                return $rental;
            });

            return redirect('/rentals')->with('success', 'Rental berhasil ditambahkan.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withErrors(['product_id' => 'Produk tidak ditemukan.']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit(Rental $rental)
    {
        if (Auth::user()->role === 'admin' && in_array($rental->status, ['completed', 'canceled'])) {
            return redirect()->back()->withErrors(['error' => 'Rental ini sudah selesai atau dibatalkan, Anda tidak dapat mengeditnya. Hubungi Super User untuk perubahan.']);
        }

        $products = Product::active()
            ->where(function ($query) use ($rental) {
                $query->where('stock', '>', 0)
                    ->orWhere('id', $rental->product_id);
            })
            ->with('primaryImage')
            ->get();

        return view('rentals.edit', compact('rental', 'products'));
    }

    public function update(Request $request, Rental $rental)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email',
            'customer_phone' => 'nullable|string|max:15',
            'product_id' => 'required|exists:products,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:pending,ongoing,completed,canceled',
        ]);

        try {
            $rental = DB::transaction(function () use ($request, $rental) {
                $product = Product::lockForUpdate()->findOrFail($request->product_id);

                if ($product->status !== 'active') {
                    throw new \Exception('Produk yang dipilih tidak aktif.');
                }

                $start_date = \Carbon\Carbon::parse($request->start_date);
                $end_date = \Carbon\Carbon::parse($request->end_date);
                $overlappingRentals = Rental::where('product_id', $product->id)
                    ->where('status', 'ongoing')
                    ->where('id', '!=', $rental->id)
                    ->where(function ($query) use ($start_date, $end_date) {
                        $query->whereBetween('start_date', [$start_date, $end_date])
                            ->orWhereBetween('end_date', [$start_date, $end_date])
                            ->orWhere(function ($q) use ($start_date, $end_date) {
                                $q->where('start_date', '<=', $start_date)
                                    ->where('end_date', '>=', $end_date);
                            });
                    })
                    ->exists();

                if ($overlappingRentals) {
                    throw new \Exception('Produk sudah disewa pada rentang tanggal tersebut.');
                }

                if ($rental->status === 'ongoing') {
                    if (in_array($request->status, ['completed', 'canceled'])) {
                        $rental->product->increment('stock');
                    } elseif ($rental->product_id !== $request->product_id) {
                        $rental->product->increment('stock');
                        if ($product->stock <= 0) {
                            throw new \Exception('Stok produk yang dipilih tidak cukup.');
                        }
                        $product->decrement('stock');
                    }
                } elseif ($rental->status === 'pending') {
                    if ($request->status === 'ongoing') {
                        if ($product->stock <= 0) {
                            throw new \Exception('Stok produk yang dipilih tidak cukup.');
                        }
                        $product->decrement('stock');
                    }
                } elseif (in_array($rental->status, ['completed', 'canceled'])) {
                    if ($request->status === 'ongoing') {
                        if ($product->stock <= 0) {
                            throw new \Exception('Stok produk yang dipilih tidak cukup.');
                        }
                        $product->decrement('stock');
                    }
                }

                $duration = $start_date->diffInDays($end_date);
                $total_price = $product->price * $duration;

                $oldRental = $rental->replicate();
                $rental->update([
                    'customer_name' => $request->customer_name,
                    'customer_email' => $request->customer_email,
                    'customer_phone' => $request->customer_phone,
                    'product_id' => $request->product_id,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'total_price' => $total_price,
                    'status' => $request->status,
                ]);
                $newRental = $rental->refresh();

                if (auth()->check() && auth()->user()->role === 'admin') {
                    $changes = array_diff_assoc($newRental->getAttributes(), $oldRental->getAttributes());
                    ActivityLog::create([
                        'user_id' => auth()->id(),
                        'action' => 'updated',
                        'model_type' => 'Rental',
                        'model_id' => $rental->id,
                        'old_values' => array_intersect_key($oldRental->getAttributes(), $changes),
                        'new_values' => array_intersect_key($newRental->getAttributes(), $changes),
                        'description' => 'Admin ' . auth()->user()->name . ' mengedit rental ' . $rental->rental_code,
                    ]);
                }

                return $rental;
            });

            return redirect('/rentals')->with('success', 'Rental berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Rental $rental)
    {
        if (in_array($rental->status, ['completed', 'canceled'])) {
            return redirect()->back()->withErrors(['error' => 'Rental yang sudah selesai atau dibatalkan tidak dapat dihapus.']);
        }

        if ($rental->status === 'ongoing') {
            $rental->product->increment('stock');
        }

        if (auth()->check() && auth()->user()->role === 'admin') {
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'deleted',
                'model_type' => 'Rental',
                'model_id' => $rental->id,
                'description' => 'Admin ' . auth()->user()->name . ' menghapus rental ' . $rental->rental_code,
            ]);
        }

        $rental->delete();

        return redirect('/rentals')->with('success', 'Rental berhasil dihapus.');
    }

    public function createPublic()
    {
        $products = Product::active()->where('stock', '>', 0)->with('primaryImage')->get();
        return view('welcome', compact('products'));
    }

    public function storePublic(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email',
            'customer_phone' => 'nullable|string|max:15',
            'product_id' => 'required|exists:products,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        try {
            $rental = DB::transaction(function () use ($request) {
                $product = Product::lockForUpdate()->findOrFail($request->product_id);

                if ($product->status !== 'active') {
                    throw new \Exception('Produk yang dipilih tidak aktif.');
                }

                $start_date = \Carbon\Carbon::parse($request->start_date);
                $end_date = \Carbon\Carbon::parse($request->end_date);
                $overlappingRentals = Rental::where('product_id', $product->id)
                    ->where('status', 'ongoing')
                    ->where(function ($query) use ($start_date, $end_date) {
                        $query->whereBetween('start_date', [$start_date, $end_date])
                            ->orWhereBetween('end_date', [$start_date, $end_date])
                            ->orWhere(function ($q) use ($start_date, $end_date) {
                                $q->where('start_date', '<=', $start_date)
                                    ->where('end_date', '>=', $end_date);
                            });
                    })
                    ->exists();

                if ($overlappingRentals) {
                    throw new \Exception('Produk sudah disewa pada rentang tanggal tersebut.');
                }

                if ($product->stock <= 0) {
                    throw new \Exception('Stok produk tidak cukup.');
                }

                $duration = $start_date->diffInDays($end_date);
                $total_price = $product->price * $duration;

                $rental = Rental::create([
                    'customer_name' => $request->customer_name,
                    'customer_email' => $request->customer_email,
                    'customer_phone' => $request->customer_phone,
                    'product_id' => $request->product_id,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'total_price' => $total_price,
                    'status' => 'ongoing',
                ]);

                $product->decrement('stock');

                return $rental;
            });

            return redirect('/')->with('success', 'Rental berhasil ditambahkan. Silakan login untuk melihat detail.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withErrors(['product_id' => 'Produk tidak ditemukan.']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
