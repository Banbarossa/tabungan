<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\TopupRequest;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

class MasterDasboard extends Component
{

    #[Layout('components.layouts.app')]
    #[Title('Dashboard')]

    public $pending_topup=0;
    public function mount(){
        $this->pending_topup = TopupRequest::where('status','pending')->count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard.master-dasboard');
    }
}
