<?php

namespace App\Livewire\Cashier;

use App\Models\MetaSetting;
use App\Models\OneTimeToken;
use App\Models\Savinglimit;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\UserOverrideLimit;
use App\Notifications\NewAnnouncementNotification;
use App\Services\TransactionService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class WithdrawalPage extends Component
{

    #[Layout('components.layouts.app.cashier-new')]
    #[Title('Tarik Tunai')]

    public ?Student $student;
    public ?OneTimeToken $OneTimeToken;
    public $optionAmount = [
        ['label' => 'Rp 5.000', 'value' => "5.000"],
        ['label' => 'Rp 10.000', 'value' => "10.000"],
        ['label' => 'Rp 15.000', 'value' => "15.000"],
        ['label' => 'Rp 20.000', 'value' => "20.000"],
        ['label' => 'Rp 25.000', 'value' => "25.000"],
        ['label' => 'Rp 30.000', 'value' => "30.000"],
    ];

    public $is_freeze_account = false;

    public $data_default = [];
    public $withdrawal_limit = 0;
    public $maximum_allowed_transaction = 0;

    public $withdrawal_request;
    public $description="Tarik Tunai";
    public $previous_url;

    public function mount(string $token)
    {
        $previous_url = url()->previous() !== request()->url()
            ? url()->previous()
            : '/mobile-scan';
            $this->previous_url =$previous_url;
        $record = OneTimeToken::where('token', $token)->first();

        if (!$record || $record->is_used || $record->expires_at->isPast()) {
            session()->flash('error', 'Url tidak valid atau sudah pernah digunakan');
            $this->redirect($previous_url, true);
            return;
        }
        // $record->update(['is_used'=>true]);
        $this->OneTimeToken = $record;
        $student = Student::findOrFail($record->student_id);
        $this->student = $student;
        $this->is_freeze_account = $student->can_transaction ? false : true;
        $set = MetaSetting::where('name', 'wallet_limit_by')->value('value') ?? 'student';

        $this->withdrawal_limit = match ($set) {
            'hari'    => Savinglimit::where('day_name', today_name())->value('limit_amount'),
            'petugas' => UserOverrideLimit::where('user_id', auth()->id())->value('limit'),
            default   => $student->daily_limit,
        };
        $todayWithdrawAmount = Transaction::where('student_id', $student->id)
            ->where('type', '!=', 'setor')
            ->whereDate('date', now())
            ->sum('amount');
        $this->maximum_allowed_transaction = max(0, $this->withdrawal_limit - $todayWithdrawAmount);
    }

    public function requestWithdrawal($value)
    {
        $this->withdrawal_request = $value;
    }

    public function render()
    {
        $histories = $this->histories();
        return view('livewire.cashier.withdrawal-page', [
            'histories' => $histories,
        ]);
    }

    public function store()
    {
        $this->validate([
            'withdrawal_request' => ['required', 'string', 'max:255'],
        ],);

        $amount = str_replace('.', '', $this->withdrawal_request);
        if ($amount < 1000) {
            $this->addError('withdrawal_request', 'Jumlah minimal penarikan adalah 1000.');
            return;
        }

        if ($this->student->saldo < $amount) {
            $this->addError('withdrawal_request', 'Saldo tidak mencukupi.');
            LivewireAlert::title('Error')
                ->title('Saldo tidak mencukupi')
                ->error()
                ->position(Position::Center)
                ->show();
            return;
        }
        if ($amount > $this->maximum_allowed_transaction) {
            LivewireAlert::title('Error')
                ->title('Penarikan diatas limit harian')
                ->error()
                ->position(Position::Center)
                ->show();

            $this->addError('withdrawal_request', 'Penarikan Diatas Limit Harian');
            return;
        }

        $date = Carbon::now()->toDateString();
        $description = $this->description;
        try {
            $service = new TransactionService($this->student);
            $service->transaction(
                amount: $amount,
                operator: '-',
                type: 'tarik',
                date: $date,
                description: $description
            );
            $this->OneTimeToken->update(['is_success_transaction' => true]);
            $this->student->notify(new NewAnnouncementNotification('Penarikan Jajan', $this->student->name . ' baru melakukan penarikan jajan'));
            session()->flash('success','Transaksi berhasil dilakukan');
            $this->redirect($this->previous_url);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            LivewireAlert::title('Error')
                ->text('Data Gagal disimpan')
                ->error()
                ->position(Position::Center)
                ->show();
        }
    }

    public function histories()
    {
        return  Transaction::where('student_id', $this->student->id)->latest()->take(5)->get();
    }
}
