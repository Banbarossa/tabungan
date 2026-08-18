<?php

namespace App\Livewire\Admin\Pengaturan;

use App\Models\MetaSetting;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class AccountBank extends Component
{

    public $keys = [
        ['key' => 'nomor_rekening_jajan', 'label' => 'Nomor Rekening'],
        ['key' => 'nama_rekening_jajan', 'label' => 'Nama Rekening'],
        ['key' => 'nama_bank_jajan', 'label' => 'Nama bank'],
        ['key' => 'hp_konfirmasi_jajan', 'label' => 'No HP Konfirmasi']
    ];

    public $inputs = [];

    public function mount()
    {
        $this->dataModel();
    }
    public function render()
    {
        $breads = [
            ['url' => url()->current(), 'title' => 'Account Bank'],
        ];
        return view('livewire.admin.pengaturan.account-bank')->layoutData(['breads' => $breads]);;
    }

    public function dataModel()
    {
        $keys = array_column($this->keys, 'key');
        $data = MetaSetting::whereIn('name', $keys)->get();
        foreach ($data as $d) {
            $this->inputs[$d->name] = $d->value;
        }
    }

    protected function rules()
    {
        $rules = [];

        // Looping key yang terdaftar untuk membuat validation rules dinamis
        foreach ($this->keys as $item) {
            $key = $item['key'];

            // Atur rule sesuai kebutuhan (misal: required, numeric, dll)
            if ($key === 'nomor_rekening_jajan') {
                $rules["inputs.{$key}"] = 'required|numeric';
            } elseif ($key === 'hp_konfirmasi_jajan') {
                $rules["inputs.{$key}"] = 'required|numeric|digits_between:10,14';
            } else {
                $rules["inputs.{$key}"] = 'required|string|max:255';
            }
        }

        return $rules;
    }

    public function save()
    {
        $this->validate();

        foreach ($this->inputs as $key => $input) {
            $set = MetaSetting::where('name', $key)->first();
            if (!$set) continue;
            $set->update(['value' => $input]);
        }
        LivewireAlert::title('Success')
            ->text('Data Berhasil Diperbaharui')
            ->position(Position::Center)
            ->success()
            ->show();
    }
}
