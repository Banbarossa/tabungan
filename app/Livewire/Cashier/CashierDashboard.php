<?php

namespace App\Livewire\Cashier;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

class CashierDashboard extends Component
{

    #[Layout('components.layouts.cashier')]
    #[Title('Home')]
    public function render()
    {
        return view('livewire.cashier.cashier-dashboard');
    }
}
