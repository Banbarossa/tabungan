<?php

namespace App\Livewire\Student;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Install extends Component
{
    #[Layout('components.layouts.auth.student-layout')]
    #[Title('Login')]
    public function render()
    {
        return view('livewire.student.install');
    }
}
