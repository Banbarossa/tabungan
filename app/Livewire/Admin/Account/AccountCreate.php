<?php

namespace App\Livewire\Admin\Account;

use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

class AccountCreate extends Component
{
    #[Layout('components.layouts.app')]
    #[Title('Account')]

    public ?Student $student = null;

    public $name;
    public $nisn;
    public $nis;
    public $nama_ayah;
    public $no_hp_ayah;
    public $nama_ibu;
    public $no_hp_ibu;
    public $send_notification;
    public $notification_target;
    public $notification_account;
    public $daily_limit;
    public $kelas;
    public $status;
    public $previousUrl;
    public $input_limit;
    public $new_password;
    public $confirmation_password;


    public function mount($code = null)
    {
        $this->previousUrl = url()->previous();

        if ($code) {
            $id = vinclaDecode($code);
            $student = Student::find($id);
            $this->student = $student;
            $this->name = $student->name;
            $this->nisn = $student->nisn;
            $this->nis = $student->nis;
            $this->kelas = $student->kelas;
            $this->nama_ayah = $student->nama_ayah;
            $this->no_hp_ayah = $student->no_hp_ayah;
            //            $this->no_hp_ibu=$student->no_hp_ibu;
            $this->nama_ibu = $student->nama_ibu;
            $this->send_notification = $student->send_notification;
            $this->notification_target = $student->notification_target;
            $this->notification_account = $student->notification_account;
            $this->daily_limit = $student->daily_limit;
            $this->status = $student->status;
            $this->input_limit = $student->daily_limit;
        }
    }


    public function render()
    {
        $breads = [
            ['url' => $this->previousUrl, 'title' => __('Santri')],
            ['url' => url()->current(), 'title' => __('Formulir')],
        ];
        $daftar_kelas = Student::select('kelas')->distinct()->orderBy('kelas', 'asc')->get()->pluck('kelas')->toArray();
        return view('livewire.admin.account.account-create', compact('daftar_kelas'))->layoutData(['breads' => $breads]);
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'nisn' => 'nullable',
            'nis' => 'nullable',
            'nama_ayah' => 'nullable',
            'nama_ibu' => 'nullable',
            'no_hp_ayah' => 'nullable',
            //            'no_hp_ibu'=>'nullable',
            'kelas' => 'nullable',
            'send_notification' => 'required',
            'notification_target' => 'nullable',
            'notification_account' => 'nullable',
            'daily_limit' => 'nullable',
            'status' => 'nullable',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        if ($this->student) {
            Student::find($this->student->id)->update($validated);
        } else {
            $validated['status'] = true;
            Student::create($validated);
            $this->clear();
        }
        session()->flash('saved', [
            'title' => __('Saved'),
            'text' => 'Data berhasil disimpan',
        ]);
        //        $this->dispatch('student_updated');
        $this->redirect($this->previousUrl, true);
    }

    public function changePassword()
    {
        if (!$this->student) return;
        $this->validate([
            'new_password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Za-z]/',
                'regex:/[0-9]/',
                'regex:/[^A-Za-z0-9]/',
                'same:confirmation_password',
            ],

            'confirmation_password' => [
                'required',
                'same:new_password',
            ],
        ]);
        $student = $this->student;
        if (Hash::check($this->new_password, $student->password)) {
            $this->addError(
                'new_password',
                'Password baru harus berbeda dari password lama.'
            );

            return;
        }

        $student->update([
            'password' => Hash::make($this->new_password),
            'is_default_password' => false,
        ]);

        $this->new_password = '';
        $this->confirmation_password = '';
        session()->flash('saved', [
            'title' => __('Saved'),
            'text' => 'Data berhasil disimpan',
        ]);
        $this->redirect($this->previousUrl, true);
    }
    public function changeLimit()
    {
        if (!$this->student) return;
        $this->validate([
            'input_limit' => [
                'required',
                'string',
                'regex:/^\d{1,3}(,\d{3})*$/',
            ],
        ]);

        $limit = (int) str_replace(',', '', $this->input_limit);


        $this->student->update([
            'daily_limit' => $limit,
        ]);
        session()->flash('saved', [
            'title' => __('Saved'),
            'text' => 'Data berhasil disimpan',
        ]);
        $this->redirect($this->previousUrl, true);
    }

    public function clear()
    {
        $this->name = '';
        $this->nisn = '';
        $this->nis = '';
        $this->kelas = '';
        $this->nama_ayah = '';
        $this->no_hp_ayah = '';
        $this->nama_ibu = '';
        $this->no_hp_ibu = '';
        $this->send_notification = '';
        $this->notification_target = '';
        $this->notification_account = '';
        $this->daily_limit = '';
        $this->status = '';
    }
}
