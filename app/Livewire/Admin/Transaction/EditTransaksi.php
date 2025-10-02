<?php

namespace App\Livewire\Admin\Transaction;

use App\Models\Transaction;
use Livewire\Component;

class EditTransaksi extends Component
{


    public Transaction $transaksi;
    public $date;
    public $amount;

    public function mount(Transaction $transaksi){
        $this->date =$transaksi->date();
        $this->amount=$transaksi->amount;
    }
    public function render()
    {
        return view('livewire.admin.transaction.edit-transaksi');
    }
}
