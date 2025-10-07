<?php

namespace App\Livewire\Admin\Transaction;

use App\Models\UserOverrideLimit;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

class OverrideLimit extends Component
{

    public $headings=['Nama','limit'];
    public $search;

    #[Title('Petugas Khusus')]
    public function mount(){
        if(session()->has('saved')){
            LivewireAlert::title(session('saved.title'))
            ->text(session('saved.text'))
            ->position(Position::Center)
            ->success()
            ->show();
        }
    }
    public function render()
    {
        $breads = [
            ['url'=>url()->current(),'title'=>"Petugas"],
        ];
        $data =UserOverrideLimit::with('user')
            ->when($this->search,function($query){
                $query->whereHas('user',function($sq){
                    $sq->where('name','like','%'.$this->search.'%');
                });
            })
            ->latest()
            ->get()
            ->map(function($item){
            return[
                'id'=>$item->id,
                'Nama'=>$item->user->name,
                'limit'=>format_rupiah($item->limit) ,
            ];
        });

        return view('livewire.admin.transaction.override-limit',[
            'data'=>$data,
        ])->layoutData(['breads'=>$breads]);
    }

    public function confirmHapus($id){
        LivewireAlert::title('Delete Item')
            ->text('Are you sure you want to delete this item?')
            ->asConfirm()
            ->onConfirm('deleteItem', ['id' => $id])
            ->show();

    }

    public function destroy($data){
        $itemId = $data['id'];
        UserOverrideLimit::find($itemId)->delete();
        LivewireAlert::title('Berhasil')
            ->text('Data berhasil dihapus')
            ->success()
            ->position(Position::Center)
            ->show();

    }
}
