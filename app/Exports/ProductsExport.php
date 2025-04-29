<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductsExport implements FromCollection
{


    public function __construct(protected int $count)
    {

    }

    public function collection()
    {
        return Product::with('category')->limit($this->count)->get();
    }
}
