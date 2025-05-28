<?php

namespace App\Livewire\Admin\Report;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Exports\CommonDailyExport;
use App\Traits\DailyReportDataTrait;
use Maatwebsite\Excel\Facades\Excel;

class CommonDailyReport extends Component
{
    use DailyReportDataTrait;
    #[Layout('components.layouts.app')]
    #[Title('Laporan Penarikan')]

    public $date;

    public function mount($date){
        $this->date=$date;
    }

    public function render()
    {

        $transactions = $this->nativeDate($this->date);

        return view('livewire.admin.report.common-daily-report',compact('transactions'));
    }


    public function downloadExcel(){
        $filename = 'Laporan Transaksi - '.$this->date.'.xlsx';
        $models = $this->nativeDate($this->date);
        $date = Carbon::parse($this->date)->format('d-m-Y');

        return Excel::download(new CommonDailyExport($models,$date),$filename);
    }



}
