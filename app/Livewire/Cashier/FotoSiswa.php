<?php

namespace App\Livewire\Cashier;

use App\Models\Student;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class FotoSiswa extends Component
{

    #[Layout('components.layouts.cashier')]
    #[Title('Foto')]
    public Student $student;
    public $previous;
    public function mount(Student $student){
        $this->student = $student;
        $this->previous = url()->previous();

    }
    public function render()
    {
        return view('livewire.cashier.foto-siswa');
    }
}
