<?php

namespace App\Livewire\Admin\Whatsapp;

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

        $url= config('absen.simaq_url');
        $token= config('absen.simaq_token');
        $response = Http::withHeaders([
            'Authorization' => $token
        ])->get($url.'get_whatsapp/tabungan');

        $messages=$response->json();
        if($messages){
            $messages=$messages;
        }{
            $messages=[];
        }

        // dd($messages);
        return view('livewire.admin.whatsapp.history-message',compact('messages'));
    }
}
