<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

class UserDetail extends Component
{

    public $user;
    public $previousUrl;


    #[Layout('components.layouts.app')]
    #[Title('Detail')]
    public function mount($code){
        $id = vinclaDecode($code);
        $this->user= User::find($id);
         $this->previousUrl = url()->previous();
    }

    public function render()
    {
        return view('livewire.admin.user.user-detail');
    }
}
