<?php

namespace App\Livewire\Cashier\Dashboard;

use App\Models\MetaSetting;
use App\Models\Student;
use App\Models\UserOverrideLimit;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\Savinglimit;
use App\Models\Transaction;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Services\TransactionService;

class BarcodeTransaction extends Component
{

    #[Layout('components.layouts.cashier')]
    #[Title('Home')]

    public $student;


    public $amount;

    public $dailyLimit;

    public $limitToday;

    public $search;

    public $description;
    public $limitBy = 'student';


    // public $idCardCode;

    public function mount()
    {

        $set = MetaSetting::where('name', 'wallet_limit_by')->value('value') ?? 'student';

        $this->limitBy = $set;

        $this->limitToday = match ($set) {
            'hari'    => Savinglimit::where('day_name', today_name())->value('limit_amount'),
            'petugas' => UserOverrideLimit::where('user_id', auth()->id())->value('limit'),
            default   => null,
        };
    }


    public function render()
    {
        $history = [];
        if ($this->student) {
            $history = Transaction::where('student_id', $this->student->id)->latest()->get();
            $todayWithDraw = Transaction::where('student_id', $this->student->id)
                ->where('type', '!=', 'setor')
                ->whereDate('created_at', now())
                ->sum('amount');
            $this->dailyLimit = max(0, $this->limitToday - $todayWithDraw);
        }
        return view('livewire.cashier.dashboard.barcode-transaction', compact('history'));
    }

    public function updatedSearch()
    {

        $student = Student::where('nisn', $this->search)->first();
        $this->student = $student;
        if($this->limitBy ==='student'){
            $this->limitToday = $student?->daily_limit;
        }
    }

    public function transaction()
    {

        $this->validate([
            'amount' => ['required', 'regex:/^[0-9.]+$/'],
        ], [
            'amount.required' => 'Jumlah wajib diisi',
            'amount.regex' => 'Tidak menerima selain angka dan desimal'
        ]);

        $sanitize = str_replace('.', '', $this->amount);
        $amount = (int) $sanitize;
        if ($amount < 1000) {
            $this->addError('amount', 'Jumlah minimal penarikan adalah 1000.');
            return;
        }

        if ($this->student->saldo < $amount) {
            $this->addError('amount', 'Saldo tidak mencukupi.');
            return;
        }
        if ($amount > $this->dailyLimit) {
            $this->addError('amount', 'Penarikan Diatas Limit Harian');
            return;
        }

        $service = new TransactionService($this->student);
        $date = Carbon::now()->toDateString();
        $description = $this->description;
        $service->transaction($amount, '-', 'tarik', $date, $description);
        $this->student = null;
        $this->search = '';

        $this->dispatch('transaction_updated');
        $this->redirect(route('cashier.home'));
    }
}
