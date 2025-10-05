<?php

namespace App\Livewire\Admin\Whatsapp;

use App\Models\Message;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Http;

class HistoryMessage extends Component
{
    #[Layout('components.layouts.app')]
    #[Title('Message History')]
    public function render()
    {


        $messages=Message::limit(100)->get();
        $breads=[
            ['url'=>url()->current(),'title'=>"Riwayat"]
        ];

        return view('livewire.admin.whatsapp.history-message',compact('messages'))->layoutData(['breads'=>$breads]);
    }
}
