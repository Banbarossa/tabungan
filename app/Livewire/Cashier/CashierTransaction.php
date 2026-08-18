<?php

namespace App\Livewire\Cashier;

use App\Models\MetaSetting;
use App\Models\Savinglimit;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\UserOverrideLimit;
use App\Services\TransactionService;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Livewire;
use Livewire\WithPagination;

class CashierTransaction extends Component
{
    use WithPagination;
    #[Layout('components.layouts.cashier')]
    #[Title('Home')]

    public string $qrResult = '';
    public ?Student $student = null;


    public $amount;

    public $dailyLimit;

    public $limitToday;

    public $description;

    public $limitBy = 'student';

    public function mount()
    {

        $set = MetaSetting::where('name', 'wallet_limit_by')->value('value') ?? 'student';

        $this->limitBy = $set;

        $this->limitToday = match ($set) {
            'hari'    => Savinglimit::where('day_name', today_name())->value('limit_amount'),
            'petugas' => UserOverrideLimit::where('user_id', auth()->id())->value('limit'),
            default   => null,
        };
        $this->getData('0124358717');
    }

    public function render()
    {
        $history = [];
        if ($this->student) {
            $history = Transaction::where('student_id', $this->student->id)->latest()->paginate(15);
            $todayWithDraw = Transaction::where('student_id', $this->student->id)
                ->where('type', '!=', 'setor')
                ->whereDate('date', now())
                ->sum('amount');
            $this->dailyLimit = max(0, $this->limitToday - $todayWithDraw);
        }
        return view('livewire.cashier.cashier-transaction', compact('history'));
    }

    public function getData($value)
    {
        $student = Student::where('nisn', $value)->first();
        $this->student = $student;
        if ($this->limitBy === 'student') {
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
            LivewireAlert::title('Error')
                ->title('Saldo tidak mencukupi')
                ->error()
                ->position(Position::Center)
                ->show();
            return;
        }
        if ($amount > $this->dailyLimit) {
            LivewireAlert::title('Error')
                ->title('Penarikan diatas limit harian')
                ->error()
                ->position(Position::Center)
                ->show();

            $this->addError('amount', 'Penarikan Diatas Limit Harian');
            return;
        }

        $date = Carbon::now()->toDateString();
        $description = $this->description;
        $service = new TransactionService($this->student);
        $service->transaction(
            amount: $amount,
            operator: '-',
            type: 'tarik',
            date: $date,
            description: $description
        );

        $this->dispatch('transaction_updated');
    }
}
