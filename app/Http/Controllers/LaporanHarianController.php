<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanHarianController extends Controller
{
    public function filterPDF(Request $request){

        $start = $request->start_date;
        $end   = $request->end_date;

        $userId = $request->user_id;
        $petugas =$userId? User::find($userId)->name:'Semua Petugas';
        $metodes = $request->metode ? explode(',', $request->metode) : [];

        $tanggal = $start == $end ? $start : Carbon::parse($start)->format('d-m-Y') .' - '.Carbon::parse($end)->format('d-m-Y');

        $data = Transaction::with('student')->whereBetween('date', [$start, $end])
            ->when($userId, fn($q) => $q->where('handledby', $userId))
            ->when($metodes, fn($q) => $q->whereIn('jenis_transaksi_id', $metodes))
            ->get()->map(function($item){
                return [
                    'No Id' => $item->student?->noId,
                    'Nama' => $item->student?->name,
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

        $path = public_path('images/team.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $log = file_get_contents($path);
        $logo = 'data:image/' . $type . ';base64,' . base64_encode($log);
        $headings=['No Id','Nama','Kelas','Nomor Transaksi','Petugas','Deskripsi','Debet','Kredit'];

        $pdf = Pdf::loadView('pdf.filter-laporan',compact('data','headings','totalDebet','totalKredit','tanggal','petugas','logo','selisih'))
            ->setPaper('A4', 'landscape');



        return $pdf->download('daily-report.pdf');

    }
}
