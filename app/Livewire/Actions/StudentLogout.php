<?php

namespace App\Livewire\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class StudentLogout
{
    /**
     * Log the current user out of the application.
     */
    public function __invoke()
    {
        Auth::guard('student')->logout();

        Session::invalidate();
        Session::regenerateToken();

        return redirect()->route('student.login');
    }
}
