<?php

namespace App\Livewire\Student\LoginArea\Tahfidz;

use App\Services\TahfidzDataService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

class TahfidzHistory extends Component
{
    #[Layout('components.tahfidz.layout')]

    public $data =[];
    public $periode ="monthly";
    public $pilihan_periode = [
        'weekly' => 'Minggu Ini',
        'monthly' => 'Bulan Ini',
        'all' => 'Semua',
    ];
    public function mount()
    {
        $this->prosesData();

    }
    public function render()
    {
        return view('livewire.student.login-area.tahfidz.tahfidz-history');
    }
    public function changePeriode(string $periode)
    {

        $this->periode = $periode;
        $this->prosesData();
    }

    public function prosesData()
    {
        $service = app(TahfidzDataService::class);
        $endpoint = 'riwayat-hafalan';
        $filter = [
            'absen_id' => auth()->user()->absen_id,
            'filter'=>$this->periode,
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
