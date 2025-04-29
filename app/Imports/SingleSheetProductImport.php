<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class SingleSheetProductImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    public function __construct()
    {
        HeadingRowFormatter::default('none');
    }

    public function collection(Collection $rows): void
    {
        $productsToInsert = [];

        foreach ($rows as $row) {


            $category = Category::firstOrCreate(['name' => $row['Категория'] ?? 'Без категории']);

            $productsToInsert[] = [
                'name' => $row['Название'],
                'sku' => $row['SKU'],
                'price' => $this->parsePrice($row['Цена']),
                'stock' => (int)$row['Остаток'],
                'description' => $row['Описание'] ?? null,
                'category_id' => $category->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($productsToInsert)) {
            Product::insert($productsToInsert);
        }
    }

    public function chunkSize(): int
    {
        return 500; // можно изменить при необходимости
    }

    protected function parsePrice(string $rawPrice): int
    {
        // Убираем пробелы и заменяем запятую на точку, если есть
        $normalized = str_replace([' ', ','], ['', '.'], $rawPrice);
        return (int)round(floatval($normalized) * 100);
    }
}
