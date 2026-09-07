<?php

namespace App\Livewire\Layouts;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class AppDashboard extends Component
{

    #[Title('Dashboard')]
    public function render()
    {

        $layout = auth()->user()->role === 'cashier'
            ? 'components.layouts.app.cashier-new'
            : 'components.layouts.app';
        return view('livewire.layouts.app-dashboard')->layout($layout);
    }
}
