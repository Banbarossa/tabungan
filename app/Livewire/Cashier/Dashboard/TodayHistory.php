<?php

namespace App\Livewire\Cashier\Dashboard;

use Livewire\Component;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class TodayHistory extends Component
{


    public function render()
    {
        $user = Auth::user();
        $history = Transaction::with('student')->whereDate('date',now())
            ->where('handledby',$user->id)
            ->latest()->get();
        return view('livewire.cashier.dashboard.today-history',compact('history'));
    }

    #[On('transaction_updated')]
    public function refreshData()
    {
        $this->dispatch('$refresh');
    }
}
