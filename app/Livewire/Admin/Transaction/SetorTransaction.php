<?php

namespace App\Livewire\Admin\Transaction;

use App\Models\Student;
use Carbon\Carbon;
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

    public $tanggal;
    public $description;

    public $amount_setor;
    public $amount_tarik;

    public $headings=[];

    public function mount($code){
        $id = vinclaDecode($code);
        $this->student = Student::find($id);
        $this->tanggal=Carbon::now()->toDateString();
        $this->headings = ['Tanggal','Debit','Kredit','Cashier'];


    }

    public function render()
    {
        $transaksi= Transaction::where('student_id',$this->student->id)
            ->latest()
            ->limit(200)
            ->get()
            ->map(function($item){
                return[
                    'id'=>$item->id,
                    'Tanggal'=>$item->date,
                    'Debit'=>$item->type == 'setor' ? format_rupiah($item->amount): '',
                    'Kredit'=>$item->type !== 'setor' ? format_rupiah($item->amount): '',
                    'Cashier'=>$item->handledbyUser?->name,
                ];
            });

        $breads=[
            ['url'=>route('transaction'),'title'=>'Transaction'],
            ['url'=>url()->current(),'title'=>'Detail'],
        ];
        return view('livewire.admin.transaction.setor-transaction',compact('transaksi'))->layoutData([
            'breads'=>$breads
        ]);
    }

    public function setor(){

        $this->validate([
            'amount_setor' => ['required', 'regex:/^[0-9.]+$/'],
        ],[
            'amount_setor.required'=>'Jumlah wajib diisi',
            'amount_setor.regex'=>'Tidak menerima selain angka dan desimal'
        ]);

        $sanitize = str_replace('.','',$this->amount_setor);
        $amount_setor = (int) $sanitize;

        if ($amount_setor < 1000) {
            $this->addError('amount_setor', 'Jumlah minimal Setoran adalah 1000.');
            return;
        }

        $date = $this->tanggal;
        $description = $this->description;

        $service = new TransactionService($this->student);
        $service->transaction($amount_setor,'+','setor',$date,$description);
        $this->amount_setor ='';


        $this->student->refresh();
        $this->dispatch('modal-close','setor');


    }

    public function tarik(){

        $this->validate([
            'amount_tarik' => ['required', 'regex:/^[0-9.]+$/'],
        ],[
            'amount_tarik.required'=>'Jumlah wajib diisi',
            'amount_tarik.regex'=>'Tidak menerima selain angka dan desimal'
        ]);

        $sanitize = str_replace('.','',$this->amount_tarik);
        $amount_tarik = (int) $sanitize;

        if ($amount_tarik < 1000) {
            $this->addError('amount_tarik', 'Jumlah minimal Setoran adalah 1000.');
            return;
        }
        if ($amount_tarik > $this->student->saldo) {
            $this->addError('amount_tarik', 'Jumlah melebihi dari saldo.');
            return;
        }

        $service = new TransactionService($this->student);
        $service->transaction($amount_tarik,'-','tarik');

        $this->amount_tarik ='';

        $this->student->refresh();
        $this->dispatch('modal-close','tarik');


    }




}
