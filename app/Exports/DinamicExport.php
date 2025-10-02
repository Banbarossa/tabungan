<?php

namespace App\Exports;

use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DinamicExport implements FromView,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $data;
    public function __construct($data)
    {
        $this->data = $data;

    }
    public function view():View
    {
        $title = $this->data['title'];
        $headings = $this->data['headings'];
        $rows = $this->data['rows'];
        $time_download = now();
        return view('export-excel.dinamic-excel',[
            'title' => $title,
            'headings' => $headings,
            'rows' => $rows,
            'time_download' => $time_download,
        ]);
    }
}
