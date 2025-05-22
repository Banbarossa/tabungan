<?php

namespace App\Livewire\Cashier;

use App\Models\Student;
use Livewire\Component;

class StudendDetailCard extends Component
{

    public Student $student;
    public function render()
    {
        return view('livewire.cashier.studend-detail-card');
    }
}
