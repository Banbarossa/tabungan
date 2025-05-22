<?php

namespace App\Livewire\Admin\Account;

use App\Models\Student;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Vinkla\Hashids\Facades\Hashids;

class AccountCreate extends Component
{
    #[Layout('components.layouts.app')]
    #[Title('Account')]

    public ?Student $student =null;

    public $name;
    public $nisn;
    public $nis;
    public $nama_ibu;
    public $send_notification;
    public $notification_target;
    public $notification_account;

    public $vincla;

    public function mount($code = null){

        if($code){
            $id= vinclaDecode($code);
            $student = Student::find($id);
            $this->student = $student;
            $this->name=$student->name;
            $this->nisn=$student->nisn;
            $this->nis=$student->nis;
            $this->nama_ibu=$student->nama_ibu;
            $this->send_notification=$student->send_notification;
            $this->notification_target=$student->notification_target;
            $this->notification_account=$student->notification_account;
        }
    }


    public function render()
    {
        return view('livewire.admin.account.account-create');
    }

    public function rules(){
        return[
            'name'=>'required',
            'nisn'=>'nullable',
            'nis'=>'nullable',
            'nama_ibu'=>'nullable',
            'send_notification'=>'required',
            'notification_target'=>'nullable',
            'notification_account'=>'nullable',
        ];
    }

    public function save(){
        $validated=$this->validate();

        if($this->student){
            Student::find($this->student->id)->update($validated);
        }else{
            $validated['status']=true;
            Student::create($validated);
            $this->clear();
        }
        $this->dispatch('student_updated');



    }
    public function clear(){
       $this->name='';
       $this->nisn='';
       $this->nis='';
       $this->nama_ibu='';
       $this->send_notification='';
       $this->notification_target='';
       $this->notification_account='';
    }
}
