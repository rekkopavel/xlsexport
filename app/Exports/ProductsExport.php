<?php

declare(strict_types=1);

namespace App\Exports;

use App\Models\Product;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class ProductsExport implements FromQuery, WithHeadings, WithMapping, WithTitle
{
    public function __construct(
        protected int $count,
        protected int $offset = 0,
        protected int $sheetNumber = 1
    ) {
    }

    public function query(): Builder
    {
        return Product::query()
            ->with('category')
            ->offset($this->offset)
            ->limit($this->count);
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

