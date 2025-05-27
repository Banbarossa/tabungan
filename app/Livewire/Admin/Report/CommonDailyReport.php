<?php

namespace App\Livewire\Admin\Report;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Traits\DailyReportDataTrait;

class CommonDailyReport extends Component
{
    use DailyReportDataTrait;
    #[Layout('components.layouts.app')]
    #[Title('Laporan Penarikan')]

    public $date;

    public function mount($date){
        $this->date=$date;
    }

    public function render()
    {

        $transactions = $this->nativeDate($this->date);

        return view('livewire.admin.report.common-daily-report',compact('transactions'));
    }
}
