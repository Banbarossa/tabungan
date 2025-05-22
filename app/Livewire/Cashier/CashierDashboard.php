<?php

namespace App\Livewire\Cashier;

use App\Models\Student;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

class CashierDashboard extends Component
{
    #[Layout('components.layouts.cashier')]
    #[Title('Home')]

    public string $qrResult = '';
    public ?Student $student = null;

    public function updatedQrResult($value)
    {
        $this->student = Student::where('name', $value)->first();
    }

    public function render()
    {
        return view('livewire.cashier.cashier-dashboard');
    }
}
