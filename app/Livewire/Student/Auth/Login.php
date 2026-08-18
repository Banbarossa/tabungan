<?php

namespace App\Livewire\Student\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Login extends Component
{
    public string $nisn = '';
    public string $password = '';
    public bool $remember = false;

    #[Layout('components.layouts.auth.student-layout')]
    #[Title('Login')]
    public function login()
    {
        $this->validate([
            'nisn' => ['required'],
            'password' => ['required'],
        ]);

        if (! Auth::guard('student')->attempt([
            'nisn' => $this->nisn,
            'password' => $this->password,
        ], $this->remember)) {

            $this->addError('nisn', 'NISN atau password salah.');
            return;
        }

        session()->regenerate();

        return redirect()->intended(route('student.dashboard'));
    }
    public function render()
    {
        return view('livewire.student.auth.login');
    }
}
