<?php

namespace App\Livewire\Admin\Transaction;

use App\Models\JenisTransaksi;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use App\Models\Transaction;
use App\Services\TransactionService;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use function Livewire\Volt\updated;

class SetorTransaction extends Component
{
    #[Layout('components.layouts.app')]
    #[Title('Dashboard')]

    public $student;

    public $tanggal;
    public $description;

    public $amount_setor;
    public $amount_tarik;

    public $headings=[];
    public $jenis_transaksi_id;
    public $methods;
    public $code;

    public function mount($code){
        $this->code = $code;
        $id = vinclaDecode($code);
        $this->student = Student::find($id);
        $this->tanggal=Carbon::now()->toDateString();
        $this->headings = ['Tanggal','Metode','Cashier','Setoran','Penarikan','Saldo','Keterangan'];
        $methods=JenisTransaksi::orderBy('no_urut','asc')->get();
        $this->methods=$methods;
        $this->jenis_transaksi_id=$methods->first()?$methods->first()->id:null;


    }

    public function render()
    {
        $tran = Transaction::latest()->limit(5)->get();
//        dd($tran);
        $transaksi= Transaction::where('student_id',$this->student->id)
            ->latest()
            ->limit(200)
            ->get()
            ->map(function($item){
                return[
                    'id'=>$item->id,
                    'Code'=>vinclaEncode($item->id),
                    'Tanggal'=>$item->date,
                    'Setoran'=>$item->type == 'setor' ? format_rupiah($item->amount): '',
                    'Penarikan'=>$item->type !== 'setor' ? format_rupiah($item->amount): '',
                    'Saldo'=> format_rupiah($item->latest_saldo),
                    'Metode'=>$item->metode?$item->metode->nama:'',
                    'Cashier'=>$item->handledbyUser?->name,
                    'Keterangan'=>$item->description,
                ];
            });

        $breads=[
            ['url'=>route('transaction'),'title'=>'Transaction'],
            ['url'=>url()->current(),'title'=>'Detail'],
        ];

        return view('livewire.admin.transaction.setor-transaction',compact('transaksi',))->layoutData([
            'breads'=>$breads
        ]);
    }

    public function setor(){

        $this->validate([
            'amount_setor' => ['required', 'regex:/^[0-9.]+$/'],
        ],[
            'amount_setor.required'=>'Jumlah wajib diisi',
            'amount_setor.regex'=>'Tidak menerima selain angka dan desimal'
        ]);

        $sanitize = str_replace('.','',$this->amount_setor);
        $amount_setor = (int) $sanitize;

        if ($amount_setor < 1000) {
            $this->addError('amount_setor', 'Jumlah minimal Setoran adalah 1000.');
            return;
        }

        $date = $this->tanggal;
        $description = $this->description;

        $service = new TransactionService($this->student);

        $service->transaction(
            amount:$amount_setor,
            operator:'+',
            type:'setor',
            date:$date,
            description: $description,
            jenis_transaksi_id:$this->jenis_transaksi_id,
        );
        $this->amount_setor ='';



        $this->student->refresh();
        $this->dispatch('modal-close','setor');


    }

    public function tarik(){

        $this->validate([
            'amount_tarik' => ['required', 'regex:/^[0-9.]+$/'],
        ],[
            'amount_tarik.required'=>'Jumlah wajib diisi',
            'amount_tarik.regex'=>'Tidak menerima selain angka dan desimal'
        ]);

        $sanitize = str_replace('.','',$this->amount_tarik);
        $amount_tarik = (int) $sanitize;

        if ($amount_tarik < 1000) {
            $this->addError('amount_tarik', 'Jumlah minimal Setoran adalah 1000.');
            return;
        }
        if ($amount_tarik > $this->student->saldo) {
            $this->addError('amount_tarik', 'Jumlah melebihi dari saldo.');
            return;
        }

        $service = new TransactionService($this->student);
        $date = Carbon::now()->toDateString();
        $description = $this->description;
        //        $amount,$operator,$type,$date,$description=null,$jenis_transaksi_id=null
        $service->transaction(
            amount:$amount_tarik,
            operator:'-',
            type:'tarik',
            date:$this->tanggal??$date,
            description: $description,
            jenis_transaksi_id:$this->jenis_transaksi_id,
        );

        $this->amount_tarik ='';
        $this->description ='';

        $this->student->refresh();
        $this->dispatch('modal-close','tarik');


    }

    public function confirmDelete($id){
        LivewireAlert::title('Delete Item')
            ->withOptions([
                'input' => 'textarea',
                'inputPlaceholder' => 'Tuliskan alasan menghapus data',
            ])
            ->text('Anda Yakin? Menghapus data akan menyebabkan penyesuain saldo pada trasnsaksi setelahnya')
            ->asConfirm()
            ->onConfirm('deleteItem', ['id' => $id])
            ->show();
    }
    public function deleteItem($data){
        try {
            DB::transaction(function () use ($data) {
                $deleted_reason = $data['value'];
                $item_id = $data['id'];

                $tran = Transaction::findOrFail($item_id);

                $next_trans = Transaction::where('student_id', $tran->student_id)
                    ->where('id', '>', $tran->id)
                    ->orderBy('id', 'asc')
                    ->get();

                if ($next_trans->isNotEmpty()) {
                    foreach ($next_trans as $next) {
                        $adjusted_saldo = $tran->type === 'setor'
                            ? $next->latest_saldo - $tran->amount
                            : $next->latest_saldo + $tran->amount;

                        $next->update(['latest_saldo' => $adjusted_saldo]);
                    }

                    $final_saldo = $next_trans->last()->latest_saldo;
                } else {
                    $student = Student::find($tran->student_id);
                    $current_saldo = $student->saldo ?? 0;

                    $final_saldo = $tran->type === 'setor'
                        ? $current_saldo - $tran->amount
                        : $current_saldo + $tran->amount;
                }

                Student::find($tran->student_id)->update([
                    'saldo' => $final_saldo,
                ]);

                $tran->update([
                    'deleted_reason' => $deleted_reason,
                    'deleted_by' => Auth::id(),
                ]);

                $tran->delete();
            });

            LivewireAlert::title('Berhasil')
                ->text('Data berhasil dihapus')
                ->success()
                ->position(Position::Center)
                ->show();
        }catch (\Exception $e){
            Log::error('Gagal Hapus', ['error' => $e->getMessage()]);
            LivewireAlert::title('Gagal')
            ->text('Data gagal dihapus')
            ->error()
            ->position(Position::Center)
            ->show();
        }


    }


}
