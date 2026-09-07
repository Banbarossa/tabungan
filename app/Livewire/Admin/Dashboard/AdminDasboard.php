<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\TopupRequest;
use Livewire\Component;

class AdminDasboard extends Component
{



    public $pending_topup=0;
    public function mount(){
        $this->pending_topup = TopupRequest::where('status','pending')->count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard.admin-dasboard');
    }
}
