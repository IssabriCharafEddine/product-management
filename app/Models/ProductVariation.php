<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'options',
        'quantity',
        'is_available'
    ];

    protected $casts = [
        'options' => 'array',
        'is_available' => 'boolean'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}