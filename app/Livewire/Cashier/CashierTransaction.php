<?php

namespace App\Livewire\Cashier;

use App\Models\Student;
use App\Models\Transaction;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Services\TransactionService;

class CashierTransaction extends Component
{
    #[Layout('components.layouts.cashier')]
    #[Title('Home')]

    public string $qrResult = '';
    public ?Student $student = null;


    public $amount;

    public $dailyLimit;




    public function render()
    {
        $history=[];
         if($this->student){
            $history=Transaction::where('student_id',$this->student->id)->latest()->get();
            $todayWithDraw = Transaction::where('student_id',$this->student->id)
                ->where('type','!=','setor')
                ->whereDate('created_at', now())
                ->sum('amount');
            $this->dailyLimit =max(0, $this->student->daily_limit - $todayWithDraw);

        }
        return view('livewire.cashier.cashier-transaction',compact('history'));
    }

    public function getData($value)
    {
        $id = vinclaDecode($value);
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

        $this->student->refresh();
        $this->student=null;


    }

    public function cancel(){
        $this->student=null;
    }

}
