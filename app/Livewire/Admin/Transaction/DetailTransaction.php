<?php

namespace App\Livewire\Admin\Transaction;

use App\Models\Student;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Attributes\Title;
use Livewire\Component;
use Riskihajar\Terbilang\Facades\Terbilang;

class DetailTransaction extends Component
{

    public Transaction $transaction;
    public string $student_code='';
    public array $data_siswa=[];
    public array $data_transaksi=[];
    #[Title('Detail Transaction')]

    public function mount(string $code)
    {
        $this->student_code = $code;
        $this->dataModel();


    }

    public function dataModel() : void {
        $transaction=$this->transaction;
        $transaction->load('student','handledbyUser','metode');
        $student =Student::find($transaction->student_id);

        $this->data_siswa=[
            'nama'=>$student->name,
            'nisn'=>$student->nisn,
            'kelas'=>$student->kelas,
            'status'=>$student->status?'Aktif':'Tidak Aktif',
        ];

        $this->data_transaksi = [
            'no_invoice'=>$transaction->invoice_number,
            'jumlah'=>format_rupiah($transaction->amount),
            'type'=>$transaction->type,
            'tanggal'=>Carbon::parse($transaction->date)->locale('id')->translatedFormat('d F Y'),
            'petugas'=>$transaction->handledbyUser?->name,
            'description'=>$transaction->description,
            'metode'=>$transaction->metode?->nama,
            'terbilang'=>ucwords(Terbilang::make($transaction->amount, ' rupiah')->value),
        ];
    }
    public function render()
    {
        $breads=[
            ['url'=>route('transaction'),'title'=>"Santri"],
            ['url'=>route('transaction.setor',$this->student_code),'title'=>"Transaction"],
            ['url'=>url()->current(),'title'=>"Detail"],
        ];

        return view('livewire.admin.transaction.detail-transaction')->layoutData(['breads'=>$breads]);
    }
    public function unduhPdf(){
        $pdf = Pdf::loadView('pdf.struk-transaksi-jajan',[
            'transaksi'=>$this->data_transaksi,
            'student'=>$this->data_siswa,
        ]);
        $pdf->setPaper('a4','potrait');
        $fileName=$this->data_transaksi['no_invoice'].'.pdf';
        $content=$pdf->output();
        return response()->streamDownload(function()use($content){
            echo $content;
        },$fileName,[
            'Content-Type'=>'application/pdf'
        ]);


    }
}
