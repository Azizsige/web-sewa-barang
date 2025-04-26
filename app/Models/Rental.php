<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Rental extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'rental_code',
        'customer_name',
        'customer_email',
        'customer_phone',
        'product_id',
        'start_date',
        'duration',
        'end_date',
        'total_price',
        'status',
        'proof_of_payment',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
            // Generate rental_code (format: RENTAL-XXX)
            if (empty($model->rental_code)) {
                $latest = static::latest('created_at')->first();
                $number = $latest ? (int) substr($latest->rental_code, 7) + 1 : 1;
                $model->rental_code = 'RENTAL-' . str_pad($number, 3, '0', STR_PAD_LEFT);
            }
            // Hitung end_date berdasarkan start_date dan duration
            if ($model->start_date && $model->duration) {
                $model->end_date = date('Y-m-d', strtotime($model->start_date . ' + ' . $model->duration . ' days'));
            }
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
