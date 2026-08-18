<?php

namespace App\Livewire\Student\LoginArea\Tahfidz;

use App\Services\TahfidzDataService;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

class TargetHafalan extends Component
{
    public $data =[];
    #[Layout('components.tahfidz.layout')]
    public function mount(){
        $this->getData();
    }
    public function render()
    {
        return view('livewire.student.login-area.tahfidz.target-hafalan');
    }

    public function getData(){
        $service = app(TahfidzDataService::class);
        $endpoint = 'semua-target';
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
