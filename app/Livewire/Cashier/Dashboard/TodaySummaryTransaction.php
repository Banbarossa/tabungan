<?php

namespace App\Livewire\Cashier\Dashboard;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Override;

class TodaySummaryTransaction extends Component
{
    public $summary;

    public function mount()
    {
        $this->dataSummary();
    }
    public function render()
    {


        return view('livewire.cashier.dashboard.today-summary-transaction');
    }

    #[On('transaction_updated')]
    public function updateSummary() {
        $this->dataSummary();
    }

    public function dataSummary()
    {
        $auth_id = Auth::user()->id;
        $this->summary = Transaction::where('handledby', $auth_id)
            ->whereDate('created_at', now())
            ->where('type', '!=', 'setor')
            ->sum('amount');
    }
}
