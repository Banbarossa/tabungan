<?php

namespace App\Livewire\Cashier;

use App\Models\Transaction;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class RiwayatTransaksi extends Component
{
    #[Layout('components.layouts.app.cashier-new')]
    #[Title('Riwayat')]

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
        $data = Transaction::with('student')->whereDate('created_at', $this->tanggal)
            ->orderBy('created_at')
            ->where('handledby', auth()->user()->id);
        $histories= (clone $data)->get();
        $amount =(clone $data)->sum('amount');
        $jumlah_transaksi=(clone $data)->count();
        return view('livewire.cashier.riwayat-transaksi', [
            'amount' => format_rupiah($amount),
            'jumlah_transaksi' => $jumlah_transaksi,
            'histories' => $histories
        ]);
    }
}
