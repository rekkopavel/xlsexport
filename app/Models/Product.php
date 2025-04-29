<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[HasFactory(ProductFactory::class)]
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'sku',
        'price',
        'stock',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected function priceRub(): Attribute
    {
        return Attribute::make(
            get: fn () => number_format($this->price / 100, 2, ',', ' '),
            set: fn (string $value) => (int) (str_replace([' ', ','], ['', '.'], $value) * 100),
        );
    }
}
