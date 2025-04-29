<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[HasFactory(ProductFactory::class)]
class Product extends Model
{

    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
