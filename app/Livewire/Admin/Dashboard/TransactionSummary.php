<?php

namespace App\Livewire\Admin\Dashboard;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Transaction;

class TransactionSummary extends Component
{
    public function render()
    {
        $transactions= Transaction::with('handledbyUser')
            ->whereNull('verifiedBy')
            ->where('type','!=','setor')
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->created_at)->toDateString();
            });


        $handledUsers = $transactions
            ->flatten()
            ->mapWithKeys(function ($item) {
                return [
                    $item->handledby => [
                        'id' => $item->handledby, // bisa null
                        'name' => optional($item->handledbyUser)->name ?? 'undefined',
                    ]
                ];
            })
            ->unique()
            ->sortKeys();



        $summary = [];

        foreach ($transactions as $date => $items) {
            $summary[$date] = [];

            foreach ($handledUsers as $userId => $userData) {
                $sum = $items->where('handledby', $userId)->sum('amount');

                $summary[$date][] = [
                    'id' => $userId,
                    'name' => $userData['name'],
                    'total' => $sum,
                ];
            }
        }



        return view('livewire.admin.dashboard.transaction-summary',compact('handledUsers','summary'));
    }
}
