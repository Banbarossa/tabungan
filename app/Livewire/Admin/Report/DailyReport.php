<?php

namespace App\Livewire\Admin\Report;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Transaction;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

class DailyReport extends Component
{
    public $date;
    #[Layout('components.layouts.app')]
    #[Title('Laporan Harian')]
    public function mount($date = null){
        if($date){
            $this->date = Carbon::parse($date)->toDateString();
        }else{
            $this->date = Carbon::now()->toDateString();
        }
    }
    public function render()
    {
        $transactions= Transaction::with('handledbyUser','student')
            ->whereNull('verifiedBy')
            ->where('type','!=','setor')
            ->whereDate('created_at',$this->date)
            ->get()
            ->groupBy('handledby');


        $summary = $transactions->map(function ($items, $handledbyId) {
            $user = $items->first()->handledbyUser;

            return [
                'user_id' => $handledbyId,
                'user_name' => $user ? $user->name : 'undefined',
                'total_amount' => $items->sum('amount'),
                'transactions' => $items,
            ];
        });


        return view('livewire.admin.report.daily-report',compact('summary'));
    }
}
