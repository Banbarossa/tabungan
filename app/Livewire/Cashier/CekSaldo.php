<?php

namespace App\Livewire\Cashier;

use App\Models\OneTimeToken;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class CekSaldo extends Component
{
    public $nisn;
    public ?Student $student;
    #[Layout('components.layouts.app.cashier-new')]
    #[Title('Cek Saldo')]
    public function render()
    {
        return view('livewire.cashier.cek-saldo');
    }

    public function nisnManual() {
        $this->validate([
            'nisn'=>'required'
        ]);
        $this->processQr($this->nisn);
    }

    public function processQr($qrResult)
    {
        $qrResult = trim($qrResult);
        if (empty($qrResult)) return;

        // Cari berdasarkan NISN atau NIS
        $student = Student::where('nisn', $qrResult)
            ->orWhere('nis', $qrResult)
            ->first();

        if (!$student) {
            LivewireAlert::title('Tidak Ditemukan!')
                ->text("Siswa dengan ID/NISN '$qrResult' tidak terdaftar.")
                ->error()
                ->toast()
                ->position(Position::TopEnd)
                ->show();
            return;
        }
        $this->student =$student;

    }

    public function clear(){
        $this->student =null;
        $this->dispatch('start_camera');
    }

    public function processStudentToken()
    {
        $student = $this->student;
        if(!$student){
             LivewireAlert::title('Error!')
                ->text('Tidak ada data siswa')
                ->error()
                ->show();
            return;
        }
        $token = Str::random(30);
        try {
            DB::beginTransaction();
            OneTimeToken::create([
                'student_id' => $student->id,
                'user_id' => auth()->user()->id,
                'token' => $token,
                'is_used' => false,
                'is_success_transaction' => false,
                'expires_at' => now()->addMinutes(5),
            ]);
            DB::commit();

            return $this->redirect(route('cashier.tarik-tunai', $token), navigate: true);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('QR Scanner Error: ' . $th->getMessage());

            LivewireAlert::title('Error!')
                ->text('Gagal membuat token transaksi')
                ->error()
                ->show();
        }
    }
}
