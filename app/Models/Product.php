<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'sku',
        'status',
        'price',
        'currency',
        'image',
        'deletion_reason'
    ];

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    protected static function booted()
    {
        static::deleting(function ($product) {
            if (!$product->isForceDeleting()) {
                $product->variations()->delete();
            }
        });

        static::forceDeleted(function ($product) {
            $product->variations()->forceDelete();
        });
    }
}
