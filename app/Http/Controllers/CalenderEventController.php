<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalenderEventController extends Controller
{
    public function getCalendarEvents(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');


        $summary = Transaction::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(CASE WHEN type = "setor" THEN amount ELSE 0 END) as total_setor'),
            DB::raw('SUM(CASE WHEN type != "setor" THEN amount ELSE 0 END) as total_non_setor')
        )
        ->whereBetween('created_at', [$start, $end])
        ->groupBy('date')
        ->get();

        $events = [];
        foreach ($summary as $item) {
            if ($item->total_setor > 0) {
                $events[] = [
                    'id' => 'setor-' . $item->date,
                    'title' => 'Setor: ' . format_rupiah($item->total_setor),
                    'start' => $item->date,
                    'color' => 'green',
                    'url' => route('report.daily.income', ['date' => $item->date])
                ];
            }
            if ($item->total_non_setor > 0) {
                $events[] = [
                    'id' => 'nonsetor-' . $item->date,
                    'title' => 'tarik: ' . format_rupiah($item->total_non_setor),
                    'start' => $item->date,
                    'color' => 'red',
                    'url' => route('report.daily', ['date' => $item->date])
                ];
            }
        }


        return response()->json($events);
    }
}
