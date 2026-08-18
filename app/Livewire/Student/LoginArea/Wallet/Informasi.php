<?php

namespace App\Livewire\Student\LoginArea\Wallet;

use App\Models\Transaction;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class Informasi extends Component
{
    public $student;
    public $accountInfo = [];

    public $limits = [];
    #[Layout('components.wallet.layout')]

    public function mount()
    {
        $this->student = auth()->user();
        $this->accountInfo = $this->identitas();
        $this->limits = $this->dataLimit();
    }
    public function render()
    {
        return view('livewire.student.login-area.wallet.informasi');
    }

    public function identitas()
    {

        $student = $this->student;
        return [
            [
                "label" => "ID Akun",
                "value" => filled($student->account_number) ? $student->account_number : '-',
            ],
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
                "label" => "Batas Harian",
                "value" => $student->daily_limit,
            ],
        ];
    }

    public function dataLimit()
    {
        $penarikan_harian = Transaction::where('student_id', $this->student->id)
            ->whereDate('date', now()->toDateString())
            ->where('type', '!=', 'setor')
            ->sum('amount');
        $limit = $this->student->daily_limit;
        $persen = $limit > 0
            ? ($penarikan_harian / $limit) * 100
            : 0;

        return [
            'used' => number_format($penarikan_harian, 0, ',', '.'),
            'limit_harian' => number_format($limit, 0, ',', '.'),
            'persen' => $persen,
            'sisa' => number_format(
                ($limit ?? 0) - ($penarikan_harian ?? 0),
                0,
                ',',
                '.'
            )
        ];
    }

    #[On('limit_updated')]
    public function refreshComponent(){
        $this->accountInfo =$this->identitas();
        $this->limits=$this->dataLimit();
    }


}
