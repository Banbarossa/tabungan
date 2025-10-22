<?php

namespace App\Livewire\Admin\Account;

use App\Models\Student;
use App\Services\StudentApi;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;


class MasterAccount extends Component
{
    use WithPagination;

    #[Layout('components.layouts.app')]
    #[Title('Dashboard')]
    public $search;
    public $status;
    public $boolStatus;
    public $headings;
    public $ids=[];
    public $select_all;

    public function mount($status = null)
    {
        if(session()->has('saved')){
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
        $students = $this->dataStudent();
        $breads =[
            ['url'=>url()->current(),'title'=>'Santri'],
        ];
        return view('livewire.admin.account.master-account', compact('students'))->layoutData(['breads'=>$breads]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function dataStudent()
    {
        $students = Student::orderBy('name')
            ->where('status', $this->boolStatus)
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->get()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nisn' => $item->nisn,
                    'Nama' => $item->name,
                    'No Id' => $item->no_id,
                    'Kelas' => $item->kelas,
                    'Hp Ibu' => $item->notification_account,
                    'Hp Ayah' => $item->no_hp_ayah,
                    'Saldo' => format_rupiah($item->saldo),

                ];
            });
        $this->headings = ['Nama', 'No Id', 'Kelas', 'Hp Ibu','Hp Ayah', 'Saldo'];
        return $students;

    }

    public function updatedSelectAll(){
        $students = $this->dataStudent();

        foreach ($students as $student) {
            if (!empty($student['nisn'])) {
                $this->ids[$student['id']] = true;
            }
        }

    }

    public function importAbsen()
    {

        $service =new StudentApi();
        $import = $service->importData();
        if ($import['status'] == 'success') {
            LivewireAlert::title('Success')
                ->text($import['message'])
                ->success()
                ->position(Position::Center)
                ->show();
        }

    }

    public function cetakKartu(){
        $selectedIds = array_keys(array_filter($this->ids));
        if(count($selectedIds) === 0){
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

    public function updateKelasSiswa(){
        $service =new StudentApi();
        $update = $service->updateKelas();
        if ($update['status']) {
            LivewireAlert::title('Success')
                ->text($update['message'])
                ->success()
                ->position(Position::Center)
                ->show();
        }
    }
}
