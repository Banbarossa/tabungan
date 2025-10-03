<?php

namespace App\Livewire\Admin\Transaction;

use App\Models\Transaction;
use Livewire\Attributes\Title;
use Livewire\Component;

class DetailTransaction extends Component
{

    public Transaction $transaction;
    public $student_code;
    #[Title('Detail Transaction')]
    public function mount($code)
    {
        $this->student_code = $code;

    }
    public function render()
    {
        $breads=[
            ['url'=>route('transaction'),'title'=>"Santri"],
            ['url'=>route('transaction.setor',$this->student_code),'title'=>"Transaction"],
            ['url'=>url()->current(),'title'=>"Detail"],
        ];

        return view('livewire.admin.transaction.detail-transaction')->layoutData(['breads'=>$breads]);
    }
}
