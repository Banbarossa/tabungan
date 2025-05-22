<?php

namespace App\Livewire\Admin\Account;

use App\Models\Student;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

class MasterAccount extends Component
{
    use WithPagination;
    #[Layout('components.layouts.app')]
    #[Title('Dashboard')]

    public $search;



    public function render()
    {
        $students=$this->dataStudent();
        return view('livewire.admin.account.master-account',compact('students'));
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
        ->paginate(30);
        return $students;

    }
}
