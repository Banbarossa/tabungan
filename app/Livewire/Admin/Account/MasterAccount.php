<?php

namespace App\Livewire\Admin\Account;

use App\Models\Student;
use App\Services\StudentApi;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;


class MasterAccount extends Component
{
    use WithPagination;

    #[Layout('components.layouts.app')]
    #[Title('Dashboard')]
    public string $search = "";
    public $status;
    public $boolStatus;
    public $headings = ['Kelas', 'HP Ortu', 'Saldo'];
    public $ids = [];
    public $select_all;

    public $orderDirection = 'ASC';
    public $orderColumn = 'name';

    public function mount($status = null)
    {
        if (session()->has('saved')) {
            LivewireAlert::title(session('saved.title'))
                ->text(session('saved.text'))
                ->success()
                ->position(Position::Center)
                ->show();
        }

        if (!in_array($status, ['aktif', 'nonaktif'])) {
            return 404;
        }
        if ($status == 'aktif') {
            $this->boolStatus = true;
        } elseif ($status == 'nonaktif') {
            $this->boolStatus = false;
        }
    }

    public function render()
    {
        $breads = [
            ['url' => url()->current(), 'title' => 'Santri'],
        ];
        return view('livewire.admin.account.master-account')->layoutData(['breads' => $breads]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function dataModel()
    {
        return Student::orderBy('name')
            ->where('status', $this->boolStatus)
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });
    }

    #[Computed()]
    public function students()
    {

        return $this->dataModel()->paginate(30)->through(function ($item) {
            return [
                'id' => $item->id,
                'nisn' => $item->nisn,
                'Nama' => $item->name,
                'No Id' => $item->no_id,
                'Kelas' => $item->kelas,
                'Hp Ibu' => $item->notification_account,
                'Hp Ayah' => $item->no_hp_ayah,
                'Saldo' => $item->saldo ?? 0,
                'Limit' => $item->daily_limit ?? 0,
                'Photo' => $item->avatar,

            ];
        });
    }

    public function updatedSelectAll($value)
    {

        if ($value) {
            foreach ($this->students() as $student) {
                if (!empty($student['nisn'])) {
                    $this->ids[$student['id']] = true;
                }
            }
        } else {
            $this->ids = [];
        }
    }

    public function importAbsen()
    {

        $service = new StudentApi();
        $import = $service->importData();

        if ($import['success']) {
            LivewireAlert::title('Success')
                ->text($import['message'])
                ->success()
                ->position(Position::Center)
                ->show();
        }
    }

    public function cetakKartu()
    {
        $selectedIds = array_keys(array_filter($this->ids));
        if (count($selectedIds) === 0) {
            LivewireAlert::title('Error')
                ->text('Silahkan centang data yang ingin dicetak kartu')
                ->error()
                ->position(Position::Center)
                ->show();
            return;
        }
        $idString = implode(',', $selectedIds);


        return redirect()->route('account.single-card', ['ids' => $idString]);
    }

    public function updateKelasSiswa()
    {
        $service = new StudentApi();
        $update = $service->updateKelas();
        if ($update['success']) {
            LivewireAlert::title('Success')
                ->text($update['message'])
                ->success()
                ->position(Position::Center)
                ->show();
        }
    }
}
