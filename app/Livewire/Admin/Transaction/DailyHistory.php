<?php

namespace App\Livewire\Admin\Transaction;

use App\Exports\DinamicExport;
use App\Models\Transaction;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class DailyHistory extends Component
{
    #[Title('Riwayat transaksi')]
    public $search;

    public $date;
    public $headings = ['No Faktur', 'Nama', 'Debit', 'Kredit', 'Metode', 'Tanggal', 'Cashier'];
    public function mount(){
        $this->date = Carbon::today()->toDateString();
    }
    public function render()
    {


        $breadcrumbs=[
            ['url'=>url()->current(),'title'=>'Riwayat'],
        ];
        // $transactions =$this->data();
        return view('livewire.admin.transaction.daily-history')->layoutData(['breads'=>$breadcrumbs]);
    }

    #[Computed()]
    public function transactions(){
        $transactions =Transaction::with('student','verifiedByUser')
            ->when($this->search,function ($query){
                $query->whereHas('student',function ($query){
                    $query->where('name','like','%'.$this->search.'%');
                });
            })
            ->whereDate('date',$this->date)
            ->latest()
            ->get()
            ->map(function($item){
                return [
                    'id'=>$item->id,
                    'No Faktur'=>$item->invoice_number,
                    'Nama'=>$item->student->name,
                    'Debit'=>$item->type == 'setor' ?format_rupiah($item->amount) : null,
                    'Kredit'=>$item->type !== 'setor' ?format_rupiah($item->amount) : null,
                    'Metode'=>$item->metode?$item->metode->nama:'',
                    'Tanggal'=>$item->date,
                    'Cashier'=>$item->handledbyUser?->name,

                ];
            });
        return $transactions;
    }

    public function export(){
        $this->search ='';
        $date = $this->date;
        $headings = $this->headings;
        $data=[
            'headings' => $headings,
            'rows' => $this->transactions(),
            'title' => 'TRANSAKSI '.$date,
        ];
        $file_name = 'tansaksi-'.$date.'.xlsx';
        return Excel::download(new DinamicExport($data),$file_name);

    }
}
