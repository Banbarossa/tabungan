<?php

namespace App\Livewire\Admin\Transaction;

use App\Exports\DinamicExport;
use App\Models\JenisTransaksi;
use App\Models\Student;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Computed;
use Livewire\Component;
use App\Models\Transaction;
use App\Services\TransactionService;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
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

    // Riwayat filters
    public $filterYear;
    public $filterMonths = [];

    public function mount($code){
        $this->code = $code;
        $id = vinclaDecode($code);
        $this->student = Student::find($id);
        $this->tanggal=Carbon::now()->toDateString();
        $this->headings = ['Tanggal','Metode','Cashier','Setoran','Penarikan','Saldo','Keterangan'];
        $methods=JenisTransaksi::orderBy('no_urut','asc')->get();
        $this->methods=$methods;
        $this->jenis_transaksi_id=$methods->first()?$methods->first()->id:null;

        $now = Carbon::now();
        $this->filterYear = (int) $now->year;
        $this->filterMonths = [(int) $now->month];

    }

    public function render()
    {
//        $tran = Transaction::latest()->limit(5)->get();
//        dd($tran);


        $breads=[
            ['url'=>route('transaction'),'title'=>'Transaction'],
            ['url'=>url()->current(),'title'=>'Detail'],
        ];

        return view('livewire.admin.transaction.setor-transaction')->layoutData([
            'breads'=>$breads
        ]);
    }

    #[Computed]
    public function histories()
    {
        return $this->historiesRows(limit: 200);
    }

    #[Computed]
    public function availableYears()
    {
        $driver = DB::connection()->getDriverName();
        $yearExpr = $driver === 'sqlite'
            ? "strftime('%Y', date)"
            : "YEAR(date)";

        $years = Transaction::query()
            ->where('student_id', $this->student->id)
            ->whereNotNull('date')
            ->selectRaw("DISTINCT {$yearExpr} as year")
            ->orderByDesc('year')
            ->pluck('year')
            ->map(fn ($y) => (int) $y)
            ->values()
            ->all();

        $currentYear = (int) Carbon::now()->year;
        if (!in_array($currentYear, $years, true)) {
            $years[] = $currentYear;
        }
        rsort($years);

        return $years;
    }

    public function resetRiwayatFilter()
    {
        $now = Carbon::now();
        $this->filterYear = (int) $now->year;
        $this->filterMonths = [(int) $now->month];
    }

    public function downloadExcel()
    {
        $rows = $this->historiesRows(limit: null);
        $overall = $this->overallTotals();
        $name = $this->student?->name ? Str::slug($this->student->name) : 'student';
        $filename=$name.'.xlsx';

        $exportRows = $rows->map(fn ($r) => collect($r)->only($this->headings)->all());
        $exportRows = $exportRows->concat(collect([
            array_fill_keys($this->headings, ''),
            [
                'Tanggal' => '',
                'Metode' => '',
                'Cashier' => '',
                'Setoran' => $overall['formatted']['setor'],
                'Penarikan' => '',
                'Saldo' => '',
                'Keterangan' => 'TOTAL SETORAN (SEMUA DATA)',
            ],
            [
                'Tanggal' => '',
                'Metode' => '',
                'Cashier' => '',
                'Setoran' => '',
                'Penarikan' => $overall['formatted']['tarik'],
                'Saldo' => '',
                'Keterangan' => 'TOTAL PENARIKAN (SEMUA DATA)',
            ],
            [
                'Tanggal' => '',
                'Metode' => '',
                'Cashier' => '',
                'Setoran' => '',
                'Penarikan' => '',
                'Saldo' => $overall['formatted']['selisih'],
                'Keterangan' => 'SELISIH (SETORAN - PENARIKAN)',
            ],
        ]));

        return Excel::download(new DinamicExport([
            'title' => 'Riwayat Transaksi',
            'headings' => $this->headings,
            'rows' => $exportRows,
        ]), $filename);
    }

    public function downloadPdf()
    {
        $rows = $this->historiesRows(limit: null);
        $overall = $this->overallTotals();

        $path = public_path('images/team.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $log = @file_get_contents($path);
        $logo = $log ? ('data:image/' . $type . ';base64,' . base64_encode($log)) : null;



        $pdf = Pdf::loadView('pdf.transaction-history', [
            'student' => $this->student,
            'headings' => $this->headings,
            'rows' => $rows->map(fn ($r) => collect($r)->only($this->headings)->all()),
            'filterYear' => $this->filterYear,
            'filterMonths' => $this->filterMonths,
            'overall' => $overall,
            'logo' => $logo,
            'downloadedBy' => Auth::user()?->name,
            'downloadedAt' => Carbon::now()->format('d-m-Y H:i:s'),
        ])->setPaper('A4', 'landscape');

        $filename = $this->downloadBaseFilename('pdf');
        return response()->streamDownload(
            fn () => print($pdf->output()),
            $filename,
            ['Content-Type' => 'application/pdf']
        );
    }

    #[Computed]
    public function overallTotals(): array
    {
        $row = Transaction::query()
            ->where('student_id', $this->student->id)
            ->selectRaw("COALESCE(SUM(CASE WHEN type = 'setor' THEN amount ELSE 0 END), 0) as total_setor")
            ->selectRaw("COALESCE(SUM(CASE WHEN type <> 'setor' THEN amount ELSE 0 END), 0) as total_tarik")
            ->first();

        $setor = (int) ($row?->total_setor ?? 0);
        $tarik = (int) ($row?->total_tarik ?? 0);
        $selisih = $setor - $tarik;

        return [
            'setor' => $setor,
            'tarik' => $tarik,
            'selisih' => $selisih,
            'formatted' => [
                'setor' => format_rupiah($setor),
                'tarik' => format_rupiah($tarik),
                'selisih' => format_rupiah($selisih),
            ],
        ];
    }

    private function historiesRows(?int $limit)
    {
        $months = collect($this->filterMonths ?? [])
            ->filter(fn ($m) => is_numeric($m))
            ->map(fn ($m) => (int) $m)
            ->filter(fn ($m) => $m >= 1 && $m <= 12)
            ->values()
            ->all();

        $query = Transaction::query()
            ->with(['metode', 'handledbyUser'])
            ->where('student_id', $this->student->id)
            ->when($this->filterYear, fn ($q) => $q->whereYear('date', (int) $this->filterYear));

        if (!empty($months)) {
            $year = (int) ($this->filterYear ?: Carbon::now()->year);
            $query->where(function ($q) use ($months, $year) {
                foreach ($months as $m) {
                    $start = Carbon::create($year, $m, 1)->startOfMonth()->toDateString();
                    $end = Carbon::create($year, $m, 1)->endOfMonth()->toDateString();
                    $q->orWhereBetween('date', [$start, $end]);
                }
            });
        }

        if ($limit !== null) {
            $query->limit($limit);
        }

        return $query->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'Code' => vinclaEncode($item->id),
                'Tanggal' => $item->date,
                'Setoran' => $item->type == 'setor' ? format_rupiah($item->amount) : '',
                'Penarikan' => $item->type !== 'setor' ? format_rupiah($item->amount) : '',
                'Saldo' => format_rupiah($item->latest_saldo),
                'Metode' => $item->metode ? $item->metode->nama : '',
                'Cashier' => $item->handledbyUser?->name,
                'Keterangan' => $item->description,
            ];
        });
    }

    private function downloadBaseFilename(string $ext): string
    {
        $year = $this->filterYear ?: Carbon::now()->year;
        $months = collect($this->filterMonths ?? [])
            ->filter(fn ($m) => is_numeric($m))
            ->map(fn ($m) => str_pad((string) ((int) $m), 2, '0', STR_PAD_LEFT))
            ->values()
            ->all();

//        $range = empty($months) ? ((string) $year) : ($year . '-' . implode('-', $months));
        $student = $this->student?->name ? Str::slug($this->student->name) : 'student';

        return "riwayat-{$student}-{$year}." . $ext;
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
