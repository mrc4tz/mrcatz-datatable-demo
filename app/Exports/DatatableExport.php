<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;

class DatatableExport implements FromView, ShouldAutoSize
{
    public function __construct(
        private string $title,
        private array $headers,
        private array $rows,
    ) {}

    public function view(): View
    {
        return view('exports.datatable-excel', [
            'title' => $this->title,
            'headers' => $this->headers,
            'rows' => $this->rows,
        ]);
    }
}
