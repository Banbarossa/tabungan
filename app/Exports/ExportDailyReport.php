<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class ExportDailyReport implements FromView,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $models;
    public $date;

    public function __construct($models,$date)
    {
        $this->models= $models;
        $this->date= $date;
    }

    public function view() :View
    {
        $models= $this->models;
        return view('export-excel.export-daily-report',[
            'models'=>$models,
            'user_name'=>Auth::user()->name,
            'date'=>Carbon::parse($this->date)->format('d/m/Y'),
        ]);
    }

}
