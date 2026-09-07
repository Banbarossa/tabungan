<?php

namespace App\Livewire\Cashier;

use App\Models\OneTimeToken;
use App\Models\Student;
use App\Models\Transaction;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class QrCodeScanner extends Component
{
    #[Layout('components.layouts.app.cashier-new')]
    #[Title('Mobile Scanner')]

    public $nisn;
    public function mount()
    {
        if (session()->has('success')) {
            LivewireAlert::title('Success')
                ->success()
                ->text(session('success'))
                ->position(Position::Center)
                ->show();
        }
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

        $this->processStudentToken($student);
    }

    private function processStudentToken(Student $student)
    {
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

    public function render()
    {
        $histories = Transaction::where('handledby', auth()->user()->id)
            ->whereDate('created_at', now())
            ->latest()
            ->take(15)
            ->get();

        return view('livewire.cashier.qr-code-scanner', [
            'histories' => $histories,
        ]);
    }
}
