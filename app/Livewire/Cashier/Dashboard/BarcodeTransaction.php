<?php

namespace App\Livewire\Cashier\Dashboard;

use App\Models\Student;
use Livewire\Component;
use App\Models\Savinglimit;
use App\Models\Transaction;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Services\TransactionService;

class BarcodeTransaction extends Component{

    #[Layout('components.layouts.cashier')]
    #[Title('Home')]

    public string $qrResult = '';
    public ?Student $student = null;


    public $amount;

    public $dailyLimit;

    public $limitToday;

    public $idCardCode;

    public function mount(){

        $savingLimit = Savinglimit::where('day_name',today_name())->first();
        if($savingLimit){
            $this->limitToday = $savingLimit->limit_amount;
        }


    }


    public function render()
    {
        $history=[];
         if($this->student){
            $history=Transaction::where('student_id',$this->student->id)->latest()->get();
            $todayWithDraw = Transaction::where('student_id',$this->student->id)
                ->where('type','!=','setor')
                ->whereDate('created_at', now())
                ->sum('amount');
            $this->dailyLimit =max(0, $this->limitToday - $todayWithDraw);

        }
        return view('livewire.cashier.dashboard.barcode-transaction',compact('history'));
    }

    public function getData()
    {
        $id = vinclaDecode($this->idCardCode);
        $student = Student::findorFail($id);
        $this->student=$student;


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
        if ($amount < 1000) {
            $this->addError('amount', 'Jumlah minimal penarikan adalah 1000.');
            return;
        }

        if($this->student->saldo < $amount){
            $this->addError('amount', 'Saldo tidak mencukupi.');
            return;
        }
        if($amount > $this->dailyLimit){
            $this->addError('amount','Penarikan Diatas Limit Harian');
            return;
        }

        $service = new TransactionService($this->student);
        $service->transaction($amount,'-','tarik');
        $this->student=null;
        $this->idCardCode='';

        $this->dispatch('transaction_updated');

    }
}
