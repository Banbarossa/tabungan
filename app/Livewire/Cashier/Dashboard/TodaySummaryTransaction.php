<?php

namespace App\Livewire\Cashier\Dashboard;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TodaySummaryTransaction extends Component
{
    public function render()
    {
        $auth_id = Auth::user()->id;
        $summary=Transaction::where('handledby',$auth_id)->whereDate('created_at',now())->where('type','!=','setor')->sum('amount');
        return view('livewire.cashier.dashboard.today-summary-transaction',compact('summary'));
    }
}
