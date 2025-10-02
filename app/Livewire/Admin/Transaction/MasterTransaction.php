<?php

namespace App\Livewire\Admin\Transaction;

use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

class MasterTransaction extends Component
{
    use WithPagination;
    #[Layout('components.layouts.app')]
    #[Title('Saldo')]

    public $search;
    public function render()
    {
        $students=$this->dataStudent();
        $breads=[
            ['url'=>url()->current(),'title'=>'Transaction'],
        ];
        return view('livewire.admin.transaction.master-transaction',compact('students'))->layoutData(['breads'=>$breads]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function dataStudent(){
        $students = Student::orderBy('name')
        ->when($this->search,function($query){
            $query->where('name','like','%'.$this->search.'%');
        })
        ->paginate(100);
        return $students;

    }
}
