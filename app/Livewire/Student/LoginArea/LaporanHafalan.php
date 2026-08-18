<?php

namespace App\Livewire\Student\LoginArea;

use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class LaporanHafalan extends Component
{
    public $pilihan_periode = [
        'weekly' => 'Minggu Ini',
        'monthly' => 'Bulan Ini',
        'all' => 'Semua',
    ];
    public string $periode = 'monthly';
    public bool $success_get_data = false;
    public string $message = "";

    public array $identitas=[];


    public string $nisn;

    public null|array $laporan = [];

    #[Layout('components.layouts.student-layout-app')]
    #[Title('Hafalan')]

    public function mount()
    {

        $santri =auth()->user();
        $this->nisn =$santri->nisn;
        $this->identitas = [
            'nama'=>strtoupper($santri->name),
            'nisn'=>$santri->nisn,
            'status'=>$santri->status,
        ];
        $this->setoranTerakhir();
    }
    public function render()
    {
        return view('livewire.student.login-area.laporan-hafalan');
    }
    public function changePeriode(string $periode)
    {

        $this->periode = $periode;
        $this->setoranTerakhir();
    }

    public function setoranTerakhir()
    {

        $this->validate([
            'nisn' => ['required', 'digits:10'],
            'periode' => ['required', Rule::in(['weekly', 'monthly', 'all'])]

        ], [
            'nisn.required' => 'NISN wajib diisi',
            'nisn.digits' => 'NISN harus berjumlah 10 Digit',
        ]);


        try {
            $response = Http::timeout(15)
                ->acceptJson()
                ->get('https://simaq.pis.sch.id/api/laporan-hafalan-santri', [
                    'nisn'   => $this->nisn,
                    'filter' => $this->periode,
                ]);


            if (!$response->successful()) {
                return $this->resetData(
                    'Api mengembalikan status ' . $response->status()
                );
            }
            $json = $response->json();
            if (!data_get($json, 'success')) {
                return $this->resetData(
                    data_get($json, 'message', 'Terjadi Kesalahan')
                );
            }
            $data = data_get($json, 'data');
            $this->laporan = $data;
            $this->success_get_data = true;
            $this->dispatch('laporan-updated', grafik: $data['grafik']);
            // dd($data);
        } catch (\Throwable $e) {
            report($e);
            return $this->resetData(
                'Tidak dapat menghubungi server'
            );
        }
    }

    protected function resetData(string $message)
    {
        $this->success_get_data = false;
        $this->message = $message;
        $this->laporan = [];
        LivewireAlert::title('Gagal')
            ->text($message)
            ->error()
            ->position(Position::Center)
            ->show();

        return false;
    }
}
