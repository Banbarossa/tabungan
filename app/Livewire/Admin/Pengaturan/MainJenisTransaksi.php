<?php

namespace App\Livewire\Admin\Pengaturan;

use App\Models\JenisTransaksi;
use Flux\Flux;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Livewire;


class MainJenisTransaksi extends Component
{
    #[Title('Jenis Transaksi')]
    public $nama;
    public $no_urut;
    public $headings=['Nama'];
    public function render()
    {
        $breads =[
            ['url'=>url()->current(),'title'=>'Jenis Transaksi'],
        ];
        $jenis = JenisTransaksi::orderBy('no_urut','ASC')->get()->map(function($jenis){
            return [
                'id'=>$jenis->id,
                'Nama'=>$jenis->nama,
            ];
        });
        return view('livewire.admin.pengaturan.main-jenis-transaksi',compact('jenis'))
            ->layoutData(['breads'=>$breads]);
    }

    public function save(){

        $validated = $this->validate(['nama'=>'required','no_urut'=>'required']);
        JenisTransaksi::create($validated);

        Flux::modal('tambah-jenis')->close();
        LivewireAlert::title('Success')
            ->text('Data berhasil disimpan.')
            ->position(Position::Center)
            ->success()
            ->show();

    }
}
