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
    public $daily_limit;
    public $status;
    public $previousUrl;


    public function mount($code = null){
        $this->previousUrl = url()->previous();

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
            $this->daily_limit=$student->daily_limit;
            $this->status=$student->status;
        }
    }


    public function render()
    {
        $breads=[
            ['url'=>$this->previousUrl, 'title'=> __('Santri')],
            ['url'=>url()->current(), 'title'=> __('Formulir')],
        ];
        return view('livewire.admin.account.account-create')->layoutData(['breads'=>$breads]);
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
            'daily_limit'=>'nullable',
            'status'=>'nullable',
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
        session()->flash('saved', [
            'title' => __('Saved'),
            'text' => 'Data berhasil disimpan',
        ]);
//        $this->dispatch('student_updated');
        $this->redirect($this->previousUrl,true);



    }
    public function clear(){
       $this->name='';
       $this->nisn='';
       $this->nis='';
       $this->nama_ibu='';
       $this->send_notification='';
       $this->notification_target='';
       $this->notification_account='';
       $this->daily_limit='';
       $this->status='';
    }
}
