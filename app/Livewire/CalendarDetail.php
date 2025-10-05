<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;

class CalendarDetail extends Component
{
    #[Layout('components.layouts.app')]
    #[Title('Calendar')]
    public function render()
    {
        $summary = Transaction::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(CASE WHEN type = "setor" THEN amount ELSE 0 END) as total_setor'),
            DB::raw('SUM(CASE WHEN type != "setor" THEN amount ELSE 0 END) as total_non_setor')
        )
        ->groupByRaw('DATE(created_at)')
        ->get();

        $events = [];
        foreach ($summary as $item) {
            if ($item->total_setor > 0) {
                $events[] = [
                    'id' => 'setor-' . $item->date,
                    'title' => 'Setor: ' . number_format($item->total_setor, 0, ',', '.'),
                    'start' => $item->date,
                    'color' => 'green',
                ];
            }
            if ($item->total_non_setor > 0) {
                $events[] = [
                    'id' => 'nonsetor-' . $item->date,
                    'title' => 'Pengeluaran: ' . number_format($item->total_non_setor, 0, ',', '.'),
                    'start' => $item->date,
                    'color' => 'red',
                ];
            }
        }

        $breads=[
            ['url'=>url()->current(),'title'=>'Kalender'],
        ];



        return view('livewire.calendar-detail',compact('events'))->layoutData(['breads'=>$breads]);
    }
}
