<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Exports\ProductsMultiSheetExport;

use App\Imports\SingleSheetProductImport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ProductExport extends Component
{
    use WithFileUploads;

    public int $count = 10000;
    public $file;

    public function import()
    {
        $this->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);


        $path = $this->file->getRealPath();


        $spreadsheet = IOFactory::load($path);


        $sheetCount = $spreadsheet->getSheetCount();


        for ($i = 0; $i < $sheetCount; $i++) {
            Excel::import(new SingleSheetProductImport, $this->file->getRealPath(), null, \Maatwebsite\Excel\Excel::XLSX, [
                'sheetIndex' => $i
            ]);
        }


    }

    public function export()
    {
        $filename = 'products_' . now()->timestamp . '.xlsx';
        return Excel::download(new ProductsMultiSheetExport($this->count), $filename);

        // return response()->download(storage_path("app/public/{$filename}"))->deleteFileAfterSend(true);
    }


    public function render()
    {
        return view('livewire.product-export');
    }
}
