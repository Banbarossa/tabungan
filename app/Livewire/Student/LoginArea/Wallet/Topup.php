<?php

namespace App\Livewire\Student\LoginArea\Wallet;

use App\Models\MetaSetting;
use App\Models\Transaction;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Topup extends Component
{

    use WithPagination;

    public $steps = [
        [
            "step"  => "1",
            "title" => "Transfer ke Rekening Pesantren",
            "desc"  => "Transfer ke rek yang tertera dibagian bawah ini"
        ],
        [
            "step"  => "2",
            "title" => "Gunakan Kode Unik Santri",
            "desc"  => "Masukkan NIS santri di berita transfer"
        ],
        [
            "step"  => "3",
            "title" => "Konfirmasi ke Admin",
            "desc"  => "Hubungi admin pesantren di Nomor"
        ],
        [
            "step"  => "4",
            "title" => "Saldo Diperbarui",
            "desc"  => "Saldo akan masuk dalam 1×24 jam kerja"
        ],
    ];

    public $bank = [];

    #[Layout('components.wallet.layout')]

    public function mount()
    {
        $this->dataAccount();
    }
    public function render()
    {
        return view('livewire.student.login-area.wallet.topup');
    }

    #[Computed]
    public function riwayat()
    {
        return Transaction::where('student_id', auth()->user()->id)->where('type', 'setor')->latest('date')->paginate(15)->through(function ($item) {
            return (object) [
                'tanggal' => Carbon::parse($item->date)->format('d/m/Y'),
                'type' => $item->type,
                'petugas' => $item->handledbyUser?->name ?? '-',
                'jumlah' => number_format($item->amount, 0, ',', '.'),
            ];
        });
    }

    public function dataAccount()
    {

        $keys = ['nomor_rekening_jajan', 'nama_rekening_jajan', 'nama_bank_jajan', 'hp_konfirmasi_jajan'];
        $setting = MetaSetting::whereIn('name',$keys)->pluck('value', 'name');
        $this->bank = [
            'bank' => $setting->get('nama_bank_jajan','-'),
            'rek' => $setting->get('nomor_rekening_jajan'),
            'logo' => asset('logo/bsi.png'),
            'nama' => $setting->get('nama_rekening_jajan'),
            'hp_konfirmasi' => $setting->get('hp_konfirmasi_jajan'),

        ];
    }
}
