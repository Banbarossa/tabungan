<?php

namespace App\Livewire\Cashier;

use App\Models\OneTimeToken;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class CancelledTransaksi extends Component
{
    #[Layout('components.layouts.app.cashier-new')]
    #[Title('Transaksi Batal')]

    public $tanggal;

    public function mount()
    {
        $this->tanggal = Carbon::now()->toDateString();
    }
    public function previousDate()
    {
        $this->tanggal = Carbon::parse($this->tanggal)->subDay()->toDateString();
    }
    public function nextDate()
    {
        $this->tanggal = Carbon::parse($this->tanggal)->addDay()->toDateString();
    }
    public function render()
    {
        $cancelledTransactions = OneTimeToken::with('student')->where('user_id', auth()->user()->id)
            ->whereDate('created_at', $this->tanggal)
            ->where('is_success_transaction', 0)
            ->get()->map(function ($item) {
                return (object) [
                    'student_name' => $item->student?->name,
                    'student_nisn' => $item->student?->nisn,
                    'waktu_scan' => Carbon::parse($item->created_at)->format('H:i:s')
                ];
            });
        return view('livewire.cashier.cancelled-transaksi', [
            'datas' => $cancelledTransactions
        ]);
    }
}
