<?php

namespace App\Livewire\Admin\Whatsapp;

use App\Services\WhatsappService;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\Livewire;
use PhpOffice\PhpSpreadsheet\Calculation\Web\Service;

class TestMessage extends Component
{
    public $phone_number;
    public $message;

    public function render()
    {
        return view('livewire.admin.whatsapp.test-message');
    }
    public function kirimPesan(){
        $this->validate([
            'phone_number' => 'required',
            'message' => 'required',
        ]);
        $service = new WhatsappService();
        $service->send(
            target: $this->phone_number,
            message:$this->message,
            delay: 0,
            user_id: Auth::user()->id,
            source: 'tabsis',
        );
        $this->message = null;
        $this->phone_number = null;
        $this->dispatch('refreshMessages')->to(HistoryMessage::class);
        LivewireAlert::title('Success')
            ->text('Pesan Berhasil dikirim')
            ->success()
            ->position(Position::Center)
            ->show();
    }
}
