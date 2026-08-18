<?php

namespace App\Livewire\Student\LoginArea\Profile;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Information extends Component
{
    #[Layout('components.profile.layout')]
    public $accountInfo = [];
    public function mount(){
        $student=auth()->user();

        $this->accountInfo=[
            [
                "label" => "NISN Santri",
                "value" => $student->nisn,
            ],
            [
                "label" => "Nama Santri",
                "value" => $student->name
            ],
            [
                "label" => "Kelas",
                "value" => "-"
            ],
            [
                "label" => "Asrama",
                "value" => '-'
            ],
            [
                "label" => "Nama Ayah",
                "value" => $student->nama_ayah,
            ],
            [
                "label" => "Nama Ibu",
                "value" => $student->nama_ibu,
            ],
        ];
    }
    public function render()
    {
        return view('livewire.student.login-area.profile.information');
    }
}
