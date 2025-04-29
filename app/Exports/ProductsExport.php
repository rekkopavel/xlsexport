<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(protected int $count)
    {
    }

    public function collection(): Collection
    {
        return Product::with('category')->limit($this->count)->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Категория',
            'Название',
            'SKU',
            'Цена',
            'Остаток',
            'Описание',
        ];
    }

    public function map($product): array
    {
        return [
            $product->id,
            $product->category?->name ?? '—',
            $product->name,
            $product->sku,
            $product->priceRub,
            $product->stock,
            $product->description,
        ];
    }
}

