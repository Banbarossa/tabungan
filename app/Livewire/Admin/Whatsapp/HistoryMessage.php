<?php

namespace App\Livewire\Admin\Whatsapp;

use App\Models\Message;
use App\Services\WhatsappService;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Http;

class HistoryMessage extends Component
{
    #[Layout('components.layouts.app')]
    #[Title('Message History')]
    public $deviceStatus;

    public function mount(){
        $service = new WhatsappService();
        $this->deviceStatus=$service->cekKoneksi();
    }
    public function render()
    {


        $messages=Message::limit(100)->get();
        $breads=[
            ['url'=>url()->current(),'title'=>"Riwayat"]
        ];

        return view('livewire.admin.whatsapp.history-message',compact('messages'))->layoutData(['breads'=>$breads]);
    }
    #[On('refreshMessages')]
    public function refreshMessages()
    {
    }
}
