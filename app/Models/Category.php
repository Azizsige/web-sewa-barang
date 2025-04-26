<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'slug',
        'image',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
            // Generate slug dari name kalau belum diisi
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
                // Pastikan slug unik
                $originalSlug = $model->slug;
                $count = 1;
                while (static::where('slug', $model->slug)->exists()) {
                    $model->slug = $originalSlug . '-' . $count++;
                }
            }
        });

        static::updating(function ($model) {
            // Update slug kalau name berubah
            if ($model->isDirty('name')) {
                $model->slug = Str::slug($model->name);
                // Pastikan slug unik
                $originalSlug = $model->slug;
                $count = 1;
                while (static::where('slug', $model->slug)->where('id', '!=', $model->id)->exists()) {
                    $model->slug = $originalSlug . '-' . $count++;
                }
            }
        });
    }
}
