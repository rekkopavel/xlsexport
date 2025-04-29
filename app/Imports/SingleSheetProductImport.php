<?php

declare(strict_types=1);

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class SingleSheetProductImport implements ToCollection, WithChunkReading, WithHeadingRow
{
    private const REQUIRED_COLUMNS = ['Название', 'SKU', 'Цена', 'Остаток'];

    private const CHUNK_SIZE = 500;

    private const DEFAULT_CATEGORY = 'Без категории';

    public function __construct()
    {
        HeadingRowFormatter::default('none');
    }

    public function collection(Collection $rows): void
    {
        $validRows = $this->validateRows($rows);

        if ($validRows->isEmpty()) {
            Log::warning('No valid rows found for import');

            return;
        }

        $productsToInsert = $this->prepareProductsData($validRows);

        try {
            Product::insert($productsToInsert);
        } catch (\Exception $e) {
            Log::error('Product import failed: '.$e->getMessage());
            throw $e;
        }
    }

    public function chunkSize(): int
    {
        return self::CHUNK_SIZE;
    }

    private function validateRows(Collection $rows): Collection
    {
        return $rows->filter(function ($row) {
            foreach (self::REQUIRED_COLUMNS as $column) {
                if (! isset($row[$column])) {
                    Log::warning("Missing required column: {$column} in row");

                    return false;
                }
            }

            return true;
        });
    }

    private function prepareProductsData(Collection $rows): array
    {
        $now = now();
        $categoryCache = [];

        return $rows->map(function ($row) use ($now, &$categoryCache) {
            $categoryName = $row['Категория'] ?? self::DEFAULT_CATEGORY;

            if (! isset($categoryCache[$categoryName])) {
                $categoryCache[$categoryName] = Category::firstOrCreate(['name' => $categoryName]);
            }

            return [
                'name' => $this->cleanString($row['Название']),
                'sku' => $this->cleanString($row['SKU']),
                'price' => $this->parsePrice($row['Цена']),
                'stock' => (int) $row['Остаток'],
                'description' => $this->cleanString($row['Описание'] ?? null),
                'category_id' => $categoryCache[$categoryName]->id,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        })->all();
    }

    private function parsePrice(string $rawPrice): int
    {
        $normalized = str_replace([' ', ','], ['', '.'], trim($rawPrice));

        return (int) round((float) $normalized * 100);
    }

    private function cleanString(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return trim(strip_tags($value));
    }
}
