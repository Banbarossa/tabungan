<?php

namespace App\Livewire\Admin\Report;

use App\Exports\byDateAndUserReport;
use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\Transaction;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Traits\DailyReportDataTrait;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ByDateAndCashierReport extends Component
{
    use DailyReportDataTrait;

    public $date;
    public $user_id;
    public $user_name;

    #[Layout('components.layouts.app')]
    #[Title('Laporan Harian')]

    public function mount($date ,$user_code){
        $this->user_id = vinclaDecode($user_code);
        $this->user_name = User::find($this->user_id)->name;
        $this->date = Carbon::parse($date)->toDateString();
    }

    public function render()
    {
        $transactions = $this->byDateUser($this->date,$this->user_id);

        $sum= $transactions->sum('amount');
        return view('livewire.admin.report.by-date-and-cashier-report',compact('transactions','sum'));
    }

    public function verification(){
        $transactions = $this->byDateUser($this->date,$this->user_id);

        foreach($transactions as $tr){
            $tr->update(['verifiedBy'=>Auth::user()->id]);
        }

        $this->dispatch('data-updated');
    }

    public function downloadExcel(){
        $filename = $this->user_name.' - '.$this->date.'.xlsx';
        $models=$transactions = $this->byDateUser($this->date,$this->user_id);
        $user_name=$this->user_name;
        $date = $this->date;

        return Excel::download(new byDateAndUserReport($models,$user_name,$date),$filename);
    }

}
