<?php

namespace App\Livewire\Student\LoginArea\Tahfidz;

use App\Services\TahfidzDataService;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class StatistikUjian extends Component
{

    public $data = [];

    public function mount()
    {
        $this->dataUjian();
    }
    public function render()
    {
        return view('livewire.student.login-area.tahfidz.statistik-ujian');
    }

    public function dataUjian()
    {
        $service = app(TahfidzDataService::class);
        $endpoint = 'ujian';
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

        $response = data_get($serv, 'data', ['data' => []]);
        $this->data = $response['data'];
    }
}
