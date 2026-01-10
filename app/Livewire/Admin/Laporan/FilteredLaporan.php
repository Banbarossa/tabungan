<?php

namespace App\Livewire\Admin\Laporan;

use App\Models\JenisTransaksi;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\Title;
use Livewire\Component;

class FilteredLaporan extends Component
{

    public $jenis;

    public $start_date;
    public $end_date;
    public $user_id;
    public $metode=[];
    #[Title('Laporan')]

    public function mount(){
        $this->start_date = Carbon::now()->toDateString();
        $this->end_date = Carbon::now()->toDateString();
        $jenis=JenisTransaksi::orderBy('no_urut','ASC')->get();

        $this->jenis=$jenis;
        $this->metode = $jenis->pluck('id')->toArray();
    }
    public function render()
    {
        $breads =[
            ['url'=>url()->current(),'title'=>'Laporan']
        ];
        $users =User::orderBy('name','ASC')->get();

        return view('livewire.admin.laporan.filtered-laporan',[
            'users'=>$users,
        ])->layoutData(['breads'=>$breads]);
    }

    public function filterData(){
        $this->validate([
            'start_date' => 'required',
            'end_date' => 'required',
            'metode' => 'nullable',
        ]);
    }
}
