<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class ProductsExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    public function __construct(
        protected int $count,
        protected int $offset = 0,
        protected int $sheetNumber = 1
    ) {
    }

    public function collection(): Collection
    {
        return Product::with('category')
            ->offset($this->offset)
            ->limit($this->count)
            ->get();
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

    public function title(): string
    {
        return "Товары " . (($this->offset + 1) . '–' . ($this->offset + $this->count));
    }
}
