<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class byDateAndUserReport implements FromView, ShouldAutoSize
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public $models;
    public $sum;
    public $user_name;
    public $date;

    public function __construct($models,$user_name,$date){
        $this->models= $models;
        $this->sum=$models->sum('amount');
        $this->date=Carbon::parse($date)->format('d/m/Y');
        $this->user_name=strtoupper($user_name);
    }

    public function view():View
    {

        $models= $this->models;
        $sum= $this->sum;
        $user_name= $this->user_name;
        $date= $this->date;
        return view('export-excel.by-date-end-user',[
            'models'=>$models,
            'sum'=>$sum,
            'user_name'=>$user_name,
            'date'=>$date,
        ]);
    }
}
