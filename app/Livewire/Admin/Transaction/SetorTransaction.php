<?php

namespace App\Livewire\Admin\Transaction;

use App\Models\Student;
use Livewire\Component;
use App\Models\Transaction;
use App\Services\TransactionService;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SetorTransaction extends Component
{
    #[Layout('components.layouts.app')]
    #[Title('Dashboard')]

    public $student;

    public $amount;

    public function mount($code){
        $id = vinclaDecode($code);
        $this->student = Student::find($id);
    }

    public function render()
    {
        $transaksi= Transaction::where('student_id',$this->student->id)->latest()->limit(200)->get();
        return view('livewire.admin.transaction.setor-transaction',compact('transaksi'));
    }

    public function transaction(){

        $this->validate([
            'amount' => ['required', 'regex:/^[0-9.]+$/'],
        ],[
            'amount.required'=>'Jumlah wajib diisi',
            'amount.regex'=>'Tidak menerima selain angka dan desimal'
        ]);

        $sanitize = str_replace('.','',$this->amount);
        $amount = (int) $sanitize;

        $service = new TransactionService($this->student);
        $service->transaction($amount,'+','setor');

        $this->student->refresh();
        $this->dispatch('modal-close','setor');


    }




}
