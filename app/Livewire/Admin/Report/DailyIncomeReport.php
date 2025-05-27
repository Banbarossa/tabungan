<?php

namespace App\Livewire\Admin\Report;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Exports\ExportDailyReport;
use App\Traits\DailyReportDataTrait;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class DailyIncomeReport extends Component
{

    use DailyReportDataTrait;

    public $date;
    #[Layout('components.layouts.app')]
    #[Title('Laporan Setoran')]

    public function mount($date = null){
        if($date){
            $this->date = Carbon::parse($date)->toDateString();
        }else{
            $this->date = Carbon::now()->toDateString();
        }
    }


    public function render()
    {
        $summary =$this->byDateIncome($this->date);
        return view('livewire.admin.report.daily-income-report',compact('summary'));
    }

    public function downloadExcel(){
        $filename='Laporan Setoran Tabungan '.$this->date.'.xlsx';
        $models=$this->byDateIncome($this->date);
        return Excel::download(new ExportDailyReport($models,$this->date),$filename);
    }

    public function verification(){
        $summary =$this->byDateIncome($this->date);

        $allTransactions = $summary->pluck('transactions')->flatten();

        foreach($allTransactions as $tr){
            $tr->update(['verifiedBy'=>Auth::user()->id]);
        }
        $this->dispatch('data-updated');
    }
}
