<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

#[HasFactory(ProductFactory::class)]
class Product extends Model
{

    use HasFactory;

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
