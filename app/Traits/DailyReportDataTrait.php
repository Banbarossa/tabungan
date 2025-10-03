<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\Transaction;

trait DailyReportDataTrait
{

    public function nativeDate($date){
        $date = Carbon::parse($date)->toDateString();

        $transactions= Transaction::with('handledbyUser','student')
            ->whereDate('date',$date)
            ->orderBy('created_at','desc')
            ->get();

            return $transactions;

    }


    public function byDate($date){

        $date = Carbon::parse($date)->toDateString();

        $transactions= Transaction::with('handledbyUser','student')
                ->where('type','!=','setor')
                ->whereDate('date',$date)
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

            return $summary;
    }

    public function byDateIncome($date){

        $date = Carbon::parse($date)->toDateString();

        $transactions= Transaction::with('handledbyUser','student')
                ->where('type','=','setor')
                ->whereDate('date',$date)
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

            return $summary;
    }

    public function byDateUser($date,$user_id){
        $date = Carbon::parse($date)->toDateString();
        $transactions= Transaction::with('handledbyUser','student')
        ->where('handledby',$user_id)
        ->where('type','!=','setor')
        ->whereDate('date',$date)
        ->get();

        return $transactions;
    }
}
