<?php

namespace App\Livewire\Student\LoginArea\Tahfidz;

use App\Services\TahfidzDataService;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

class StatistikTahfidz extends Component
{
    #[Layout('components.tahfidz.layout')]

    public $pilihanBulan = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    public $data = [];
    public $kehadiran = [];
    public string|int $selectedMonth;
    public int $selectedYear;
    public $header=[];


    public function mount()
    {
        $this->selectedMonth = now()->month;
        $this->selectedYear = now()->year;
        $this->prosesData();
        $this->dataKehadiran();
        $this->dataInfoHalaqah();
    }
    public function render()
    {
        return view('livewire.student.login-area.tahfidz.statistik-tahfidz');
    }
    public function updatedSelectedMonth()
    {
        $this->prosesData();
        $this->dataKehadiran();

        $this->dispatch(
            'grafik-updated',
            grafik: data_get($this->data, 'grafik')
        );
    }

    public function updatedSelectedYear()
    {
        $this->prosesData();
        $this->dataKehadiran();

        $this->dispatch(
            'grafik-updated',
            grafik: data_get($this->data, 'grafik')
        );
    }
    public function dataInfoHalaqah()
    {
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
        $this->header=$response['data'];

    }

    public function prosesData()
    {
        $service = app(TahfidzDataService::class);
        $endpoint = 'statistik-hafalan';
        $filter = [
            'absen_id' => auth()->user()->absen_id,
            'month' => $this->selectedMonth,
            'year' => $this->selectedYear,
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

    public function dataKehadiran()
    {
        $service = app(TahfidzDataService::class);
        $endpoint = 'kehadiran';
        $filter = [
            'absen_id' => auth()->user()->absen_id,
            'month' => $this->selectedMonth,
            'year' => $this->selectedYear,
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
        $this->kehadiran = $response['data'];
    }
}
