<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Rental extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'rental_code',
        'customer_name',
        'customer_email',
        'customer_phone',
        'product_id',
        'start_date',
        'end_date',
        'total_price',
        'status',
        'proof_of_payment',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Generate UUID untuk ID
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }

            // Generate rental_code (format: RENTAL-XXX)
            $latestRental = self::latest()->first();
            $number = $latestRental ? (int) substr($latestRental->rental_code, 7) + 1 : 1;
            $model->rental_code = 'RENTAL-' . str_pad($number, 3, '0', STR_PAD_LEFT);
        });
    }

    // Accessor untuk duration (dihitung dari end_date - start_date)
    public function getDurationAttribute()
    {
        return $this->start_date->diffInDays($this->end_date);
    }
}
