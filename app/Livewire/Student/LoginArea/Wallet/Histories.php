<?php

namespace App\Livewire\Student\LoginArea\Wallet;

use App\Models\Transaction;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Histories extends Component
{

    use WithPagination;
    public $student_id;

    public string $filter = "all";



    public $filterOptions = [
        ['value' => 'all', 'label' => 'Semua'],
        ['value' => 'setor', 'label' => 'Top Up'],
        ['value' => 'tarik', 'label' => 'Tarik'],
        ['value' => 'today', 'label' => 'Hari ini'],
    ];

    public $perPage = 10;

    #[Layout('components.wallet.layout')]
    public function mount()
    {
        $student = auth()->user();
        $this->student_id = $student->id;
    }
    public function render()
    {
        return view('livewire.student.login-area.wallet.histories');
    }

    public function changeFilter($filter)
    {
        $this->filter = $filter;
    }

    #[Computed()]
    public function dataRiwayat()
    {
        return Transaction::with('handledbyUser')
            ->where('student_id', $this->student_id)
            ->when($this->filter !== 'all', function ($query) {
                if ($this->filter === 'today') {
                    $query->whereDate('date', today());
                } else {
                    $query->where('type', $this->filter);
                }
            })
            ->latest('date')
            ->paginate($this->perPage)
            ->through(function ($item) {
                return (object) [
                    'tanggal' => Carbon::parse($item->date)->format('d/m/Y'),
                    'type' => $item->type,
                    'petugas' => $item->handledbyUser?->name ?? '-',
                    'jumlah' => number_format($item->amount, 0, ',', '.'),
                ];
            });
    }
}
