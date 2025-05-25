<?php

namespace App\Livewire\Admin\Transaction;

use App\Models\Savinglimit;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

class DailyLimitManagement extends Component
{

    #[Layout('components.layouts.app')]
    #[Title('Daily Limit')]

    public $minggu;
    public $senin;
    public $selasa;
    public $rabu;
    public $kamis;
    public $jumat;
    public $sabtu;

    public function mount(){
        $this->propDefault();
    }

    public function render()
    {


        return view('livewire.admin.transaction.daily-limit-management');
    }


    public function save(){

        $hariList = ['minggu', 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
        $rules=[];
        $messages=[];
        foreach($hariList as $hari){
            $rules[$hari]=['required', 'regex:/^[0-9.]+$/'];
            $messages["{$hari}.required"]='Jumlah wajib diisi';
            $messages["{$hari}.regex"]='Tidak menerima selain angka dan desimal';
        }
        $this->validate($rules,$messages);

        $data=[];
        foreach($hariList as $hari){
            $sanitize = str_replace('.','',$this->$hari);
            $data[$hari]=(int) $sanitize;
        }

        foreach ($data as $key=>$value){
            Savinglimit::updateOrCreate([
                'day_name'=>$key
            ],[
                'limit_amount'=>$value
            ]);
        }
        $this->dispatch('modal-close','daily_limit');
        $this->propDefault();

    }

    public function propDefault(){
        $hariList = ['minggu', 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
        foreach($hariList as $hari){
            $value = Savinglimit::where('day_name',$hari)->first();
            if($value){
                $this->$hari =$value->limit_amount;
            }
        }
    }
}
