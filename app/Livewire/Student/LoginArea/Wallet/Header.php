<?php

namespace App\Livewire\Student\LoginArea\Wallet;

use App\Models\Transaction;
use Livewire\Attributes\On;
use Livewire\Component;

class Header extends Component
{
    public $quickActions = [
        [
            'label' => 'Riwayat',
            'icon' => 'clock',
            'action' => 'riwayat',
            'routeName'=>'student.dompet'
        ],
        [
            'label' => 'Top Up',
            'icon' => 'plus-circle',
            'action' => 'topup',
            'routeName'=>'student.topup-dompet'
        ],
        [
            'label' => 'Statistik',
            'icon' => 'chart-bar',
            'action' => 'statistik',
            'routeName'=>'student.statistik-dompet'
        ],
        [
            'label' => 'Info',
            'icon' => 'information-circle',
            'action' => 'info',
            'routeName'=>'student.informasi-dompet'
        ],
    ];
    public $tabs = [
        ["id" => "riwayat", "label" => "Riwayat",'routeName'=>'student.dompet'],
        ["id" => "topup", "label" => "Top Up",'routeName'=>'student.topup-dompet'],
        ["id" => "statistik", "label" => "Statistik",'routeName'=>'student.statistik-dompet'],
        ["id" => "info", "label" => "Info Akun",'routeName'=>'student.informasi-dompet'],
    ];

    public array $data=[];

    public function mount(){
        $this->data=$this->prosesData();
    }

    public function render()
    {
        return view('livewire.student.login-area.wallet.header');
    }

    public function prosesData(){
        $student =auth()->user();
        $transaksi =Transaction::where('student_id',$student->id)
        ->whereYear('date',now()->year)
        ->whereMonth('date',now()->month);
        $jumlahPenarikan = (clone $transaksi)->where('type','!=','setor')->sum('amount');
        $jumlahTopup = (clone $transaksi)->where('type','setor')->sum('amount');

        return [
            'nisn'=>$student->nisn,
            'saldo'=>$student->saldo,
            'nama'=>$student->name,
            'limit'=>filled($student->daily_limit)?format_rupiah($student->daily_limit):'-',
            'stats'=>[
                ['label'=>'Pengeluaran Bulan Ini','value'=>'Rp. '.number_format($jumlahPenarikan,0,',','.')],
                ['label'=>'Top Up Bulan Ini','value'=>'Rp. '.number_format($jumlahTopup,0,',','.')],
                ['label'=>'Transaksi Bulan Ini','value'=>(clone $transaksi)->get()->count().' Kali']
            ]
        ];
    }

    #[On('limit_updated')]
    public function refreshComponent(){
        $this->data=$this->prosesData();
    }
}
