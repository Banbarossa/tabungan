<?php

namespace App\Livewire\Cashier\Dashboard;

use App\Models\OneTimeToken;
use App\Models\Transaction;
use Livewire\Component;

class CashierDashboard extends Component
{



    public function render()
    {
        $today = now()->format('Y-m-d');

        $todayTransactions = Transaction::where('handledby', auth()->user()->id)
            ->whereDate('created_at', $today);

        $totalCountToday = (clone $todayTransactions)->whereIn('type', ['jajan', 'tarik'])->count();
        $totalTarikToday = (clone $todayTransactions)->where('type', '!=','setor')->sum('amount');
        $gagalTransaksi = OneTimeToken::whereDate('created_at', $today)->where('user_id', auth()->user()->id)->count();
        $todaySummary = [
            ['label' => 'Total Penarikan/jajan', 'value' => format_rupiah($totalTarikToday), 'url' => '/riwayat'],
            ['label' => 'Jumlah Transaksi Terlayani', 'value' => $totalCountToday.' Santri', 'url' => '/riwayat'],
            ['label' => 'Pembatalan Transaksi', 'value' => $gagalTransaksi.' Scan', 'url' => '/batal-transaksi'],
        ];


        $recentTransactions = Transaction::with('student')
            ->where('handledby', auth()->user()->id)
            ->where('type', '!=', 'setor')
            ->whereDate('created_at',now())
            ->latest()
            ->take(6)
            ->get();



        return view('livewire.cashier.dashboard.cashier-dashboard', [
            'totalTarikToday' => $totalTarikToday,
            'totalCountToday' => $totalCountToday,
            'todaySummaries' => $todaySummary,
            'recentTransactions' => $recentTransactions,
            'grafikData' => $this->dataGrafik(),
        ]);
    }

    public function dataGrafik()
    {
        $transactions = Transaction::where('handledby', auth()->user()->id)
            ->whereBetween('created_at', [now()->subDays(8)->startOfDay(), now()->endOfDay()])
            ->where('type', '!=', 'setor')
            ->get()
            ->groupBy(fn($item) => $item->created_at->format('Y-m-d'))
            ->map(fn($day) => $day->sum('amount'));

        $labels = [];
        $values = [];

        for ($i = 8; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('d M');
            $values[] = $transactions->get($date, 0);
        }

        return [
            'labels' => $labels,
            'values' => $values,
        ];
    }
}
