<?php

namespace App\Livewire\Student\LoginArea\Profile;

use Livewire\Component;

class ProfileHeader extends Component
{


    public $tabs = [
        ["id" => "detail", "label" => "Detail",'routeName'=>'student.profile.detail'],
        ["id" => "Password", "label" => "Password",'routeName'=>'student.profile.password'],
    ];
    public function render()
    {
        return view('livewire.student.login-area.profile.profile-header');
    }
}
