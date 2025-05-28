<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CommonDailyExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $models;
    public $date;

    public function __construct($models,$date)
    {
        $this->models=$models;
        $this->date=$date;
    }

    public function view():View
    {
        return view('export-excel.common-daily-export',[
            'models'=>$this->models,
            'date'=>$this->date,
        ]);
    }
}
