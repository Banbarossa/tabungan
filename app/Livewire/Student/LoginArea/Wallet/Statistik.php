<?php

namespace App\Livewire\Student\LoginArea\Wallet;

use App\Models\Transaction;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Statistik extends Component
{
    #[Layout('components.wallet.layout')]

    public $grafik=[];

    public $rata_rata=[];
    public function mount(){
        $this->grafik=$this->dataGrafik();
        $this->rata_rata=$this->dataRataRata();

    }
    public function render()
    {
        return view('livewire.student.login-area.wallet.statistik');
    }

    public function dataGrafik()
    {
        $start = now()->subMonths(5)->startOfMonth();
        $end = now()->endOfMonth();

        $transactions = Transaction::query()
            ->where('student_id', auth()->user()->id)
            ->where('type', '!=', 'setor')
            ->whereBetween('date', [$start, $end])
            ->selectRaw('
            YEAR(date) as tahun,
            MONTH(date) as bulan,
            SUM(amount) as total,
            COUNT(*) as transaksi
        ')
            ->groupByRaw('YEAR(date), MONTH(date)')
            ->orderByRaw('YEAR(date), MONTH(date)')
            ->get()
            ->keyBy(fn($item) => "{$item->tahun}-{$item->bulan}");

        $data = collect();

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);

            $key = "{$date->year}-{$date->month}";
            $item = $transactions->get($key);

            $data->push([
                'bulan' => $date->format('M'),
                'label' => $date->translatedFormat('F'),
                'total' => (int) ($item?->total ?? 0),
                'transaksi' => (int) ($item?->transaksi ?? 0),
            ]);
        }

        return $data->values();
    }

    public function DataRataRata()
    {
        $start = now()
            ->subMonths(6)
            ->startOfMonth();

        $end = now()
            ->endOfMonth();

        $total = Transaction::query()
            ->where('student_id', auth()->user()->id)
            ->where('type', '!=', 'setor')
            ->whereBetween('date', [$start, $end])
            ->sum('amount');

        $label=  sprintf(
            'Periode %s %s sampai dengan %s %s',
            $start->locale('id')->translatedFormat('F'),
            $start->year,
            $end->locale('id')->translatedFormat('F'),
            $end->year
        );
        if ($start->year === $end->year) {
            $label = sprintf(
                'Periode %s sampai dengan %s %s',
                $start->locale('id')->translatedFormat('F'),
                $end->locale('id')->translatedFormat('F'),
                $end->year
            );
        }


        return [
            'avg'=>format_rupiah((int) round($total / 6)),
            'label'=>$label,
            'total'=>format_rupiah($total),
        ];
    }
}
