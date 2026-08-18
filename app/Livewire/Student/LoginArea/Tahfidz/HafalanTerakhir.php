<?php

namespace App\Livewire\Student\LoginArea\Tahfidz;

use App\Services\TahfidzDataService;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class HafalanTerakhir extends Component
{

    public $data=[];
    public function mount(){
        $this->prosesData();
    }
    public function render()
    {
        return view('livewire.student.login-area.tahfidz.hafalan-terakhir');
    }
    public function prosesData(){
        $service = app(TahfidzDataService::class);
        $endpoint = 'hafalan-terakhir';
        $filter = [
            'absen_id' => auth()->user()->absen_id,
        ];

        $serv = $service->getData(endpoint: $endpoint, filter: $filter);
        if (!$serv['success']) {
            LivewireAlert::title('error')
                ->text($serv['message'])
                ->error()
                ->position(Position::Center)
                ->show();
            return;
        }

        $response = data_get($serv,'data',['data'=>[]]);
        $this->data=$response['data'];
    }
}
