<?php

namespace App\Livewire\Admin\Transaction;

use App\Models\MetaSetting;
use App\Models\Savinglimit;
use App\Models\User;
use App\Models\UserOverrideLimit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Livewire;
use PHPUnit\Framework\Constraint\Count;

class DailyLimitManagement extends Component
{

    #[Layout('components.layouts.app')]
    #[Title('Limit Harian')]

    public $minggu;
    public $senin;
    public $selasa;
    public $rabu;
    public $kamis;
    public $jumat;
    public $sabtu;

    public $limitByOptions = [
        ['value' => 'student', 'label' => 'Santri', 'description' => 'Limit Berdasarkan Akun Siswa'],
        ['value' => 'petugas', 'label' => 'Petugas', 'description' => 'Limit Berdasarkan Petugas'],
        ['value' => 'hari', 'label' => 'Hari', 'description' => 'Limit Berdasarkan Hari'],
    ];
    public $users_list = [];
    public $limitBySelected;
    public $limit_petugas_input = [];

    public function mount()
    {
        $this->propDefault();
        $this->dataLimitPetugas();
        $this->limitBySelected = MetaSetting::where('name', 'wallet_limit_by')->first()?->value;
    }

    public function render()
    {

        $breads = [
            ['url' => url()->current(), 'title' => 'Limit Harian']
        ];

        return view('livewire.admin.transaction.daily-limit-management')->layoutData(['breads' => $breads]);
    }
    public function limitBySave()
    {
        $this->validate([
            'limitBySelected' => ['required', Rule::in(['student', 'petugas', 'hari'])]
        ]);
        MetaSetting::updateOrCreate(
            ['name' => 'wallet_limit_by'],
            ['value' => $this->limitBySelected]
        );
        LivewireAlert::title('Success')
            ->text('Data Berhasil di perbaharui')
            ->success()
            ->position(Position::Center)
            ->show();
    }

    public function dataLimitPetugas()
    {
        $users = User::with('overrideLimit')
            ->where('status', true)
            ->whereRole('cashier') // Pastikan scope/method whereRole terdefinisi di model User
            ->orderBy('name')
            ->get();

        $this->users_list = [];
        $this->limit_petugas_input = [];

        foreach ($users as $user) {
            $this->users_list[] = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ];

            $this->limit_petugas_input[$user->id] = $user->overrideLimit?->limit ?? 0;
        }
    }

    public function saveDataLimitPetugas()
    {
        $this->validate([
            'limit_petugas_input.*' => 'required|string',
        ], [
            'limit_petugas_input.*.required' => 'Nominal limit tidak boleh kosong.',
        ]);

        DB::beginTransaction();

        try {
            foreach ($this->limit_petugas_input as $userId => $formattedLimit) {
                $cleanLimit = sanitizeRupiah($formattedLimit);
                UserOverrideLimit::updateOrCreate(
                    ['user_id' => $userId],
                    ['limit'   => $cleanLimit]
                );
            }

            DB::commit();
            LivewireAlert::title('Success')
                ->text('Data Berhasil di perbaharui')
                ->success()
                ->position(Position::Center)
                ->show();

            $this->dataLimitPetugas();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            LivewireAlert::title('Gagal')
                ->text('Data gagal di perbaharui')
                ->error()
                ->position(Position::Center)
                ->show();
        }
    }


    public function save()
    {

        $hariList = ['minggu', 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
        $rules = [];
        $messages = [];
        foreach ($hariList as $hari) {
            $rules[$hari] = ['required', 'regex:/^[0-9.]+$/'];
            $messages["{$hari}.required"] = 'Jumlah wajib diisi';
            $messages["{$hari}.regex"] = 'Tidak menerima selain angka dan desimal';
        }
        $this->validate($rules, $messages);

        $data = [];
        foreach ($hariList as $hari) {
            $sanitize = str_replace('.', '', $this->$hari);
            $data[$hari] = (int) $sanitize;
        }

        foreach ($data as $key => $value) {
            Savinglimit::updateOrCreate([
                'day_name' => $key
            ], [
                'limit_amount' => $value
            ]);
        }
        $this->dispatch('modal-close', 'daily_limit');
        $this->propDefault();
    }

    public function propDefault()
    {
        $hariList = ['minggu', 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
        foreach ($hariList as $hari) {
            $value = Savinglimit::where('day_name', $hari)->first();
            if ($value) {
                $this->$hari = $value->limit_amount;
            }
        }
    }
}
