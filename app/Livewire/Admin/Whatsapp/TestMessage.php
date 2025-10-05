<?php

namespace App\Livewire\Admin\Whatsapp;

use App\Services\WhatsappService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use PhpOffice\PhpSpreadsheet\Calculation\Web\Service;

class TestMessage extends Component
{
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
    }
}
