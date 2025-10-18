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
    public $nama_ayah;
    public $no_hp_ayah;
    public $nama_ibu;
    public $no_hp_ibu;
    public $send_notification;
    public $notification_target;
    public $notification_account;
    public $daily_limit;
    public $kelas;
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
            $this->kelas=$student->kelas;
            $this->nama_ayah=$student->nama_ayah;
            $this->no_hp_ayah=$student->no_hp_ayah;
//            $this->no_hp_ibu=$student->no_hp_ibu;
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
        $daftar_kelas=Student::select('kelas')->distinct()->orderBy('kelas','asc')->get()->pluck('kelas')->toArray();
        return view('livewire.admin.account.account-create',compact('daftar_kelas'))->layoutData(['breads'=>$breads]);
    }

    public function rules(){
        return[
            'name'=>'required',
            'nisn'=>'nullable',
            'nis'=>'nullable',
            'nama_ayah'=>'nullable',
            'nama_ibu'=>'nullable',
            'no_hp_ayah'=>'nullable',
//            'no_hp_ibu'=>'nullable',
            'kelas'=>'nullable',
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
       $this->kelas='';
       $this->nama_ayah='';
       $this->no_hp_ayah='';
       $this->nama_ibu='';
       $this->no_hp_ibu='';
       $this->send_notification='';
       $this->notification_target='';
       $this->notification_account='';
       $this->daily_limit='';
       $this->status='';
    }
}
