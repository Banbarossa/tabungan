<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

class MasterDasboard extends Component
{

    #[Layout('components.layouts.app')]
    #[Title('Dashboard')]
    public function render()
    {
        return view('livewire.admin.dashboard.master-dasboard');
    }
}
