<?php

namespace App\Livewire\Cashier\Dashboard;

use Livewire\Component;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class TodayHistory extends Component
{

    #[On('transaction_updated')]
    public function render()
    {
        $user = Auth::user();
        $history = Transaction::with('student')->whereDate('created_at',now())
        ->where('handledby',$user->id)
        ->get();
        return view('livewire.cashier.dashboard.today-history',compact('history'));
    }
}
