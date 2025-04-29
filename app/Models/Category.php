<?php

namespace App\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[HasFactory(CategoryFactory::class)]
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];
}
