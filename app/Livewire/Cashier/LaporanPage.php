<?php

namespace App\Livewire\Cashier;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class LaporanPage extends Component
{
    #[Layout('components.layouts.app.cashier-new')]
    #[Title('Transaksi Batal')]

    public $pilihanBulan=[1,2,3,4,5,6,7,8,9,10,11,12];
    public $pilihanTahun=[];
    public $bulan;
    public $tahun;
    public function mount()
    {
        $sekarang = now()->year;
        $this->pilihanTahun=range($sekarang,$sekarang-4,1);

        $this->bulan = now()->month;
        $this->tahun = now()->year;
    }


    public function render()
    {

        $data = Transaction::select(
            DB::raw('DATE(created_at) as tanggal'),
            DB::raw('COUNT(*) as jumlah_transaksi'),
            DB::raw('SUM(amount) as total_transaksi')
        )
            ->where('handledby', auth()->user()->id)
            ->where('type', '!=', 'setor')
            ->whereMonth('created_at', $this->bulan)
            ->whereYear('created_at', $this->tahun)
            ->groupBy('tanggal')
            ->orderBy('tanggal','asc')
            ->get();

            $rekapJumlahTransaksi=$data->sum('jumlah_transaksi');
            $rekapTotalTransaksi=$data->sum('total_transaksi');
            $summaries =$data->map(function($item){
                return [
                    'tanggal'=>$item->tanggal,
                    'tanggal_label'=>Carbon::parse($item->tanggal)->locale('id')->translatedFormat('d F Y'),
                    'jumlah_transaksi'=>$item->jumlah_transaksi,
                    'total_transaksi'=>$item->total_transaksi,
                    'total_transaksi_label'=>format_rupiah($item->total_transaksi),
                ];
            });


        return view('livewire.cashier.laporan-page',[
            'summaries'=>$summaries,
            'rekapJumlahTransaksi'=>$rekapJumlahTransaksi,
            'rekapTotalTransaksi'=>format_rupiah($rekapTotalTransaksi),
        ]);
    }
}
