<?php

namespace App\Livewire\Admin\Report;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Transaction;

class ByDateAndCashierReport extends Component
{

    public $date;
    public $user_id;

    public function mount($date ,$user_code){
        $this->user_id = vinclaDecode($user_code);
        $this->date = Carbon::parse($date)->toDateString();
    }

    public function render()
    {
        $transactions = $this->data();

        // dd($transactions);
        $sum= $transactions->sum('amount');
        return view('livewire.admin.report.by-date-and-cashier-report',compact('transactions','sum'));
    }

    public function data(){
        $transactions= Transaction::with('handledbyUser','student')
            ->whereNull('verifiedBy')
            ->where('handledby',$this->user_id)
            ->where('type','!=','setor')
            ->whereDate('created_at',$this->date)
            ->get();



        return $transactions;
    }
}
