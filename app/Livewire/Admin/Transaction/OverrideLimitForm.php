<?php

namespace App\Livewire\Admin\Transaction;

use App\Models\User;
use App\Models\UserOverrideLimit;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Title;
use Livewire\Component;

class OverrideLimitForm extends Component
{
    public ? UserOverrideLimit $userOverrideLimit =null;

    public $user_id;
    public $limit;
    #[Title('Formulir')]
    public function mount($userOverrideLimit = null ){
        if($userOverrideLimit){
            $this->userOverrideLimit = $userOverrideLimit;
            $this->user_id = $userOverrideLimit->user_id;
            $this->limit = $userOverrideLimit->limit;
        }
    }
    public function render()
    {
        $breads = [
            ['url'=>route('limit.khusus'),'title'=>'Petugas'],
            ['url'=>url()->current(),'title'=>'Formulir'],
        ];
        $petugas = User::where('status',true)->where('role','cashier')->orderBy('name')->get();
        return view('livewire.admin.transaction.override-limit-form',[
            'petugas'=>$petugas,
        ])->layoutData(['breads'=>$breads]);


    }

    public function save(){
        $this->validate([
            'user_id' => 'required',
            'limit' => 'required',
        ],[
            'user_id.required'=>'Data tidak boleh kosong',
            'limit.required'=>'Data tidak boleh kosong',
        ]);

        $sanitize = str_replace('.','',$this->limit);
        $limit = (int) $sanitize;
        try {
            if($this->userOverrideLimit){
                $this->userOverrideLimit->update([
                    'limit'=>$limit,
                ]);
            }else{
                UserOverrideLimit::create([
                    'user_id'=>$this->user_id,
                    'limit'=>$limit,
                ]);
            }
            session()->flash('saved',[
                'title'=>'Berhasil',
                'text'=>'Data berhasil disimpan',
            ]);
            $this->redirect(route('limit.khusus'),true);
        }catch (\Exception $e){
            Log::error($e->getMessage());
        }

    }
}
