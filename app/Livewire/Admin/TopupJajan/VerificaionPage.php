<?php

namespace App\Livewire\Admin\TopupJajan;

use App\Livewire\Student\LoginArea\Wallet\Topup;
use App\Models\JenisTransaksi;
use App\Models\Student;
use App\Models\TopupRequest;
use App\Models\Transaction;
use App\Services\TransactionService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\Livewire;

class VerificaionPage extends Component
{
    public ?TopupRequest $topupRequest = null;
    public $student_name;
    public $student_nisn;
    public $jumlah;
    public $tanggal;
    public $catatan_admin;
    public $methods;
    public $jenis_transaksi_id;

    public function mount(string $encripted_id)
    {

        $this->topupRequest = TopupRequest::find(vinclaDecode($encripted_id));
        $this->jumlah = $this->topupRequest->jumlah;
        $this->tanggal = Carbon::parse($this->topupRequest->dateTime)->format('Y-m-d\TH:i');
        $this->catatan_admin = $this->topupRequest->catatan_admin;
        $student = Student::find($this->topupRequest->student_id);
        if ($student) {
            $this->student_name = $student->name;
            $this->student_nisn = $student->nisn;
        }
        $methods = JenisTransaksi::orderBy('no_urut', 'asc')->get();
        $this->methods = $methods;
        $this->jenis_transaksi_id = $methods->first() ? $methods->first()->id : null;
    }
    public function render()
    {
        $breads = [
            ['url' => route('riwayat-topup-jajan'), 'title' => 'Daftar Topup'],
            ['url' => url()->current(), 'title' => 'Verifikasi Topup'],
        ];
        return view('livewire.admin.topup-jajan.verificaion-page')->layoutData(['breads' => $breads]);
    }

    public function reject()
    {
        $this->validate([
            'catatan_admin' => 'nullable|string|min:3|max:255',
        ]);

        $this->topupRequest->update([
            'catatan_admin' => $this->catatan_admin,
            'status' => 'rejected',
            'verification_at' => now(),
            'verification_by' => auth()->id(),
        ]);

        session()->flash('message', 'Permintaan topup telah ditolak.');
    }


    public function approve()
    {
        $this->validate([
            'jumlah' => 'required|min:1',
            'tanggal' => 'required|date',
            'catatan_admin' => 'nullable|string|max:255',
            'jenis_transaksi_id' => 'required|numeric|max:255',
        ]);
        $jumlah = sanitizeRupiah($this->jumlah);
        if ($jumlah < 10000) {
            $this->addError('jumlah', 'Nominal topup minimal Rp 10.000.');
            return;
        }

        try {
            DB::beginTransaction();
            $invoice_number = Carbon::now()->format('Ymd') . '-' . Str::random(6);
            $student = Student::find($this->topupRequest->student_id);
            $latest_saldo = $student->saldo + $jumlah;
            $date = Carbon::parse($this->tanggal)->format('Y-m-d');
            $this->topupRequest->update([
                'jumlah' => $jumlah,
                'dateTime' => $this->tanggal,
                'catatan_admin' => $this->catatan_admin,
                'status' => 'approved',
                'verification_at' => now(),
                'verification_by' => auth()->id(),
            ]);


            Transaction::create([
                'invoice_number' => $invoice_number,
                'student_id' => $this->topupRequest->student_id,
                'amount' => $jumlah,
                'latest_saldo' => $latest_saldo,
                'type' => 'setor',
                'handledby' => auth()->id(),
                'date' => $date,
                'description' => $this->catatan_admin,
                'jenis_transaksi_id' => $this->jenis_transaksi_id,
                'topup_request_id' => $this->topupRequest->id,
            ]);
            $student->update([
                'saldo' => $latest_saldo,
            ]);

            DB::commit();
            session()->flash('success', 'Permintaan topup berhasil disetujui dan saldo telah ditambahkan.');
            $this->redirect(route('riwayat-topup-jajan'), true);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error approving topup request: ' . $e->getMessage(), ['exception' => $e]);
            LivewireAlert::title('Error')
                ->text('Terjadi kesalahan saat memproses topup. data tidak diperbaharui. Silakan coba lagi.')
                ->position(Position::Center)
                ->error()
                ->show();
        }
    }
}
