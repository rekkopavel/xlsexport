<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProductsMultiSheetExport implements WithMultipleSheets
{
    public function __construct(protected int $totalCount)
    {
    }

    public function sheets(): array
    {
        $sheets = [];
        $perSheet = 10000;
        $chunks = ceil($this->totalCount / $perSheet);

        for ($i = 0; $i < $chunks; $i++) {
            $offset = $i * $perSheet;
            $sheets[] = new ProductsExport($perSheet, $offset, $i + 1);
        }

        return $sheets;
    }
}
