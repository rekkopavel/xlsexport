<?php

namespace App\Livewire;

use App\Exports\ProductsExport;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class ProductExport extends Component
{

    public int $count = 10000;

    public function export()
    {
        $filename = 'products_' . now()->timestamp . '.xlsx';
        Excel::store(new ProductsExport($this->count), $filename, 'public');

        return response()->download(storage_path("app/public/{$filename}"))->deleteFileAfterSend(true);
    }
    public function render()
    {
        return view('livewire.product-export');
    }
}
