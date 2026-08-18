<?php

namespace App\Livewire\Student\LoginArea\Wallet;

use Flux\Flux;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class ModalLimit extends Component
{

    public $text_color='';

    public string $input_limit;
    public $pilihan_limits=[
        ['label'=>'Rp. 5.000','value'=>5000],
        ['label'=>'Rp. 10.000','value'=>10000],
        ['label'=>'Rp. 20.000','value'=>20000],
        ['label'=>'Rp. 30.000','value'=>30000],
        ['label'=>'Rp. 40.000','value'=>40000],
        ['label'=>'Rp. 50.000','value'=>50000],
        ['label'=>'Rp. 100.000','value'=>100000],
    ];
    public function mount(string $text_color="text-gray-700"){
        $this->text_color =$text_color;
        $this->input_limit =auth()->user()->daily_limit;
    }

    public function render()
    {
        return view('livewire.student.login-area.wallet.modal-limit');
    }

    public function changeButtonLimit($value){
        auth()->user()->update([
            'daily_limit' => $value,
        ]);
        Flux::modals('edit-profile')->close();
        $this->dispatch('limit_updated');
        $this->input_limit=$value;
        LivewireAlert::title('Success')
            ->text('Limit harian berhasil diperbaharui')
            ->success()
            ->position(Position::Center)
            ->show();
    }
    public function changeDailyLimit()
    {
        $this->validate([
            'input_limit' => [
                'required',
                'string',
                'regex:/^\d{1,3}(,\d{3})*$/',
            ],
        ]);

        $limit = (int) str_replace(',', '', $this->input_limit);

        auth()->user()->update([
            'daily_limit' => $limit,
        ]);
        Flux::modals('edit-profile')->close();
        $this->dispatch('limit_updated');
        LivewireAlert::title('Success')
            ->text('Limit harian berhasil diperbaharui')
            ->success()
            ->position(Position::Center)
            ->show();
    }
}
