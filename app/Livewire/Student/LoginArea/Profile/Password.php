<?php

namespace App\Livewire\Student\LoginArea\Profile;

use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Password extends Component
{

    #[Layout('components.profile.layout')]
    public $old_password;
    public $new_password;
    public $confirmation_password;
    public function render()
    {
        return view('livewire.student.login-area.profile.password');
    }

    public function rules()
    {
        return [
            'old_password' => [
                'required',
                'string',
            ],

            'new_password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Za-z]/',
                'regex:/[0-9]/',
                'regex:/[^A-Za-z0-9]/',
                'same:confirmation_password',
            ],

            'confirmation_password' => [
                'required',
                'same:new_password',
            ],
        ];
    }
    public function messages()
    {
        return [
            'old_password.required' => 'Password lama wajib diisi.',

            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_password.regex' => 'Password harus mengandung huruf, angka, dan simbol.',
            'new_password.same' => 'Password baru dan konfirmasi password harus sama.',

            'confirmation_password.required' => 'Konfirmasi password wajib diisi.',
            'confirmation_password.same' => 'Konfirmasi password tidak sama.',
        ];
    }

    public function changePassword()
    {
        $this->validate();

        $user = auth()->user();

        if (! Hash::check($this->old_password, $user->password)) {
            $this->addError(
                'old_password',
                'Password lama tidak benar.'
            );

            return;
        }

        if (Hash::check($this->new_password, $user->password)) {
            $this->addError(
                'new_password',
                'Password baru harus berbeda dari password lama.'
            );

            return;
        }
        $user->update([
            'password' => Hash::make($this->new_password),
            'is_default_password'=>false,
        ]);
        $this->reset([
            'old_password',
            'new_password',
            'confirmation_password',
        ]);
        LivewireAlert::title('Sukses')->text('Password Berhasil diperbaharui')
            ->success()
            ->position(Position::Center)
            ->show();
    }
}
