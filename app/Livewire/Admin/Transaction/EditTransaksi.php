<?php

namespace App\Livewire\Admin\Transaction;

use App\Models\JenisTransaksi;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class EditTransaksi extends Component
{


    public Transaction $transaction;
    public $date;
//    public $amount;
    public $updated_reason;
    public $description;

    public $jenis_transaksi_id;

    public function mount(Transaction $transaction)
    {
        $this->date = $transaction->date;
        $this->description = $transaction->description;
        $this->updated_reason = $transaction->updated_reason;
        $this->jenis_transaksi_id = $transaction->jenis_transaksi_id;
    }

    public function render()
    {
        $jenis = JenisTransaksi::orderBy('no_urut')->get();
        return view('livewire.admin.transaction.edit-transaksi', compact('jenis'));
    }

    public function save()
    {
        $this->validate([
            'date' => 'required|date',
            'updated_reason' => 'required',
        ]);
        try {
            $this->transaction->update(
                [
                    'date' => $this->date,
                    'updated_reason' => $this->updated_reason,
                    'description' => $this->description,
                    'jenis_transaksi_id' => $this->jenis_transaksi_id,
                ]
            );
            LivewireAlert::title('success')
                ->text('Data berhasil disimpan')
                ->position(Position::Center)
                ->success()
                ->show();

        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            LivewireAlert::title('Gagal')
                ->text('Data Gagal disimpan')
                ->position(Position::Center)
                ->error()
                ->show();
        }

    }
}
