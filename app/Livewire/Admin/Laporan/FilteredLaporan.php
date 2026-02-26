<?php

namespace App\Livewire\Admin\Laporan;

use App\Models\JenisTransaksi;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
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

    #[Computed]
    public function dataLaporan(){
        $data = Transaction::with('student')->whereBetween('date', [$this->start_date, $this->end_date])
            ->when($this->user_id, fn($q) => $q->where('handledby', $this->user_id))
            ->when(!empty($this->metode), fn($q) => $q->whereIn('jenis_transaksi_id', $this->metode))
            ->get()->map(function($item){
                return [
                    'No Id' => $item->student?->noId,
                    'Nama' => strtoupper($item->student?->name),
                    'Kelas' => $item->student?->kelas,
                    'Nomor Transaksi' => $item->invoice_number,
                    'Petugas' =>$item->handledbyUser?->name,
                    'Deskripsi'=>$item->description,
                    'to_Debet'=>$item->type=='setor'?$item->amount:0,
                    'Debet'=>$item->type=='setor'?format_rupiah( $item->amount):'',
                    'to_Kredit'=>$item->type !=='setor'?$item->amount:0,
                    'Kredit'=>$item->type !=='setor'?format_rupiah($item->amount) :'',


                ];
            });
        $totalDebet  = $data->sum('to_Debet');
        $totalKredit = $data->sum('to_Kredit');
        $selisih =$totalDebet - $totalKredit;

        return [
            'data'=>$data,
            'totalDebet'=>$totalDebet,
            'totalKredit'=>$totalKredit,
            'selisih'=>$selisih,
        ];
    }

    #[Computed]
    public function headings(){
        return [
            'No Id',
            'Nama',
            'Kelas',
            'Nomor Transaksi',
            'Petugas',
            'Deskripsi',
            'Debet',
            'Kredit',
        ];
    }
}
