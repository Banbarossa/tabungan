<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Traits\DailyReportDataTrait;
use Illuminate\Support\Facades\Auth;

class DailyReportController extends Controller
{
    use DailyReportDataTrait;


    public function exportPdf($date){
        $models =$this->byDate($date);
        $user_name =Auth::user()->name;
        $date =Carbon::parse($date)->format('d/m/Y');


        $pdf = Pdf::loadView('pdf.daily-report', compact('models','user_name','date'))
                ->setPaper('A4', 'portrait');

        return $pdf->stream('daily-report.pdf');

    }
    public function byDateAndCashier($date,$user_code){

        $user_id = vinclaDecode($user_code);
        $user_name = User::find($user_id)->name;

        $models =$this->byDateUser($date,$user_id);
        $sum =$models->sum('amount');
        $date =Carbon::parse($date)->format('d-m-Y');


        $pdf = Pdf::loadView('pdf.by-cashier-report', compact('models','user_name','date','sum'))
                ->setPaper('A4', 'portrait');

        return $pdf->stream('daily-report.pdf');

    }
}
