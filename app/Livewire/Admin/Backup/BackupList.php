<?php

namespace App\Livewire\Admin\Backup;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Livewire;

class BackupList extends Component
{
    public $files = [];
    public $running = false;

    #[Title('Backup')]
    public function mount()
    {
        $this->loadFiles();
    }

    public function loadFiles()
    {
        $this->files = Storage::disk('local')->files('Tabsis');
        rsort($this->files);
    }

    public function runBackup()
    {
        $this->running = true;

        Artisan::call('backup:run');

        $this->running = false;
        $this->loadFiles();

        session()->flash('message', 'Backup berhasil dibuat.');
    }

    public function download($file)
    {
        return response()->download(storage_path('app/private/' . $file));
    }

    public function render()
    {
        $breads=[
            ['url'=>url()->current(),'title'=>"Backup"],
        ];
        return view('livewire.admin.backup.backup-list')->layoutData(['breads'=>$breads]);
    }
    public function delete($file)
    {
        Storage::disk('local')->delete($file);
        $this->loadFiles();
        LivewireAlert::title('Success')
            ->text("Data Berhasil Dihapus!")
            ->position(Position::Center)
            ->success()
            ->show();

    }

}
