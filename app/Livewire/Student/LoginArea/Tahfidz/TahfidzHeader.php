<?php

namespace App\Livewire\Student\LoginArea\Tahfidz;

use App\Services\TahfidzDataService;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class TahfidzHeader extends Component
{
    public $tabs = [
        ["id" => "rekap", "label" => "Rekapitulasi",'routeName'=>'student.tahfidz'],
        ["id" => "riwayat", "label" => "Riwayat",'routeName'=>'student.tahfidz.histories'],
        ["id" => "target", "label" => "Target",'routeName'=>'student.tahfidz.target'],
        ["id" => "info", "label" => "Informasi",'routeName'=>'student.tahfidz.information'],
    ];

    public $halaqah=[];
    public $target=[];
    public function mount(){
        $this->dataHalaqah();
        $this->dataTarget();
    }
    public function render()
    {
        return view('livewire.student.login-area.tahfidz.tahfidz-header');
    }

    public function dataHalaqah(){
        $service = app(TahfidzDataService::class);
        $endpoint = 'info-halaqah';
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
        $this->halaqah=$response['data'];
    }
    public function dataTarget(){
        $service = app(TahfidzDataService::class);
        $endpoint = 'target-aktif';
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
        $this->target=$response['data'];
    }

}
