<?php

namespace App\Livewire\Admin\Whatsapp;

use App\Models\Settingwhatsapp;
use App\Services\WhatsappService;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

class SettingSendingMessage extends Component
{



    public $deviceStatus;
    public $template_setor;
    public $template_tarik;
    public $send_when_setor =0;
    public $send_when_tarik =0;
    public $token_wa;
    #[Layout('components.layouts.app')]
    #[Title('Message History')]

    public function mount(){
        $this->dataDefault();
        $service = new WhatsappService();
        $this->deviceStatus =$service->cekKoneksi();
    }

    public function render()
    {
        $breads=[
            ['url'=>url()->current(),'title'=>'Pengaturan'],
        ];
        return view('livewire.admin.whatsapp.setting-sending-message')->layoutData(['breads'=>$breads]);
    }


    public function save(){
        $data=[
            'send_when_setor' => (int) $this->send_when_setor,
            'send_when_tarik' => (int) $this->send_when_tarik,
            'template_setor' => $this->template_setor,
            'template_tarik' => $this->template_tarik,
            'token_wa' => $this->token_wa,
        ];

        $s = Settingwhatsapp::latest()->first();
        if($s){
            $s->update($data);
        }else{
            Settingwhatsapp::create($data);
        }
        $this->dataDefault();
        LivewireAlert::title('Success')
            ->text('Data berhasil disimpan')
            ->success()
            ->position(Position::Center)
            ->show();

    }

    public function dataDefault(){
        $s = Settingwhatsapp::latest()->first();
        if($s){
            $this->template_setor = $s->template_setor;
            $this->template_tarik = $s->template_tarik;
            $this->send_when_setor = $s->send_when_setor;
            $this->send_when_tarik = $s->send_when_tarik;
            $this->token_wa = $s->token_wa;
        }else{
            $this->template_setor = $this->setorDefaultMessage();
            $this->template_tarik = $this->tarikDefaultMessage();
        }
    }


    public function setorDefaultMessage(){


        $message ="
INFO TRANSAKSI TABUNGAN
PESANTREN IMAM SYAFI'I - SIBREH

اَلسَّلَامُ عَلَيْكُمْ وَرَحْمَةُ اللهِ وَبَرَكَا تُهُ

Alhamdulillah, Setoran tabungan dengan rincian:
Nomor    : TAB202505009820
Tanggal  : {{tanggal}}
Nama     : {{nama_santri}}
Kelas    : {{kelas}}
Jumlah   : {{jumlah}}
Berita   : Setoran tabungan santri
telah kami proses.

Saldo akhir sebesar {{saldo_akhir}}

Hormat kami,
{{cashier}}
";
return $message;
    }



    public function tarikDefaultMessage(){


        $message ="
INFO TRANSAKSI TABUNGAN
PESANTREN IMAM SYAFI'I - SIBREH

اَلسَّلَامُ عَلَيْكُمْ وَرَحْمَةُ اللهِ وَبَرَكَا تُهُ

Alhamdulillah, penarikan tabungan dengan rincian:
Nomor    : TAB202505009820
Tanggal  : {{tanggal}}
Nama     : {{nama_santri}}
Kelas    : {{kelas}}
Jumlah   : {{jumlah}}
Berita   : Penarikan tabungan santri
telah kami proses.
Keterangan   : {{keterangan}}

Saldo akhir sebesar {{saldo_akhir}}

Hormat kami,
{{cashier}}
        ";

        return $message;

    }







}
