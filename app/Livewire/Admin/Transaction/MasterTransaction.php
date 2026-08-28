<?php

namespace App\Livewire\Admin\Transaction;

use App\Models\Student;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

class MasterTransaction extends Component
{
    use WithPagination;
    #[Layout('components.layouts.app')]
    #[Title('Saldo')]

    public $search;
    public function render()
    {
        $breads = [
            ['url' => url()->current(), 'title' => 'Transaction'],
        ];
        return view('livewire.admin.transaction.master-transaction')->layoutData(['breads' => $breads]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[Computed()]
    public function students()
    {
        $students = Student::orderBy('name')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate(100)->through(function ($item) {
                return (object) [
                    'id' => $item->id,
                    'name' => $item->name,
                    'nisn' => $item->nisn,
                    'saldo' => $item->saldo,
                    'limit' => $item->daily_limit,
                    'photo' => $item->avatar,
                    'status' => $item->can_transaction,
                ];
            });
        return $students;
    }
    public function toggleFreeze(int $studentId)
    {
        $student = Student::findOrFail($studentId);
        $student->update([
            'can_transaction' => !$student->can_transaction
        ]);

        LivewireAlert::title('Successs!')
            ->text('Data berhasil diperbaharui.')
            ->success()
            ->toast()
            ->position('top-end')
            ->timer(3000)
            ->show();
    }
}
