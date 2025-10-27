<?php

namespace App\Livewire\Admin\Account;

use App\Models\Absen;
use App\Models\Absendetail;
use App\Models\Halaqah;
use App\Models\Student;
use App\Services\WhatsappService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class TakePhoto extends Component
{
    public Student $student;
    use WithFileUploads;
    public $photo;
    public function mount(Student $student){
        $this->student = $student;
    }
    public function render()
    {
        return view('livewire.admin.account.take-photo');
    }

    public function store()
    {
        $this->validate([
            'photo' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $student = $this->student;
        try {

            if ($student->photo && Storage::disk('public')->exists($student->photo)) {
                Storage::disk('public')->delete($student->photo);
            }

            $path = $this->photo->store('photos', 'public');

            $student->photo = $path;
            $student->save();
            session()->flash('saved',[
                'title' => "Berhasil",
                'text'=>"Photo Berhasil Diupload"
            ]);
            return redirect()->route('account.index', ['status'=>'aktif']);

        } catch (\Throwable $th) {
            Log::error($th->getMessage());

        }

    }
}
