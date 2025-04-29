<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Exports\ProductsMultiSheetExport;
use App\Imports\SingleSheetProductImport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ProductExport extends Component
{
    use WithFileUploads;

    public int $count = 10_000;

    public $file;

    public bool $isImporting = false;

    public ?string $importError = null;

    public ?string $successMessage = null;

    protected $rules = [
        'file' => 'required|file|mimes:xlsx,xls',
    ];

    public function import(): void
    {
        $this->validate();
        $this->resetImportStatus();

        try {
            $this->isImporting = true;
            $path = $this->file->getRealPath();
            $spreadsheet = IOFactory::load($path);

            $this->importSheets($spreadsheet);

            $this->successMessage = 'Товары успешно импортированы!';
        } catch (\Throwable $e) {
            $this->handleImportError($e);
        } finally {
            $this->isImporting = false;
            $this->file = null;
        }
    }

    public function export(): BinaryFileResponse
    {
        $filename = sprintf('products_export_%s.xlsx', now()->format('Ymd_His'));

        return Excel::download(
            new ProductsMultiSheetExport($this->count),
            $filename
        );
    }

    public function render()
    {
        return view('livewire.product-export');
    }

    private function importSheets(\PhpOffice\PhpSpreadsheet\Spreadsheet $spreadsheet): void
    {
        $sheetCount = $spreadsheet->getSheetCount();

        for ($i = 0; $i < $sheetCount; $i++) {
            Excel::import(
                new SingleSheetProductImport,
                $this->file->getRealPath(),
                null,
                \Maatwebsite\Excel\Excel::XLSX,
                ['sheetIndex' => $i]
            );
        }
    }

    private function resetImportStatus(): void
    {
        $this->importError = null;
        $this->successMessage = null;
    }

    private function handleImportError(\Throwable $e): void
    {
        logger()->error('Product import failed: '.$e->getMessage(), [
            'exception' => $e,
            'file' => $this->file?->getClientOriginalName(),
        ]);

        $this->importError = 'Ошибка импорта: '.$e->getMessage();
    }
}
