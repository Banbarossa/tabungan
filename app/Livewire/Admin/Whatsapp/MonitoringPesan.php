<?php

namespace App\Livewire\Admin\Whatsapp;

use App\Models\Message;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class MonitoringPesan extends Component
{
    #[Layout('components.layouts.app')]
    #[Title('Message History')]
    public $status;
    public $search;

    public $headings =['Nama','Target','Waktu'];

    public $messages = [];

    public function mount($status)
    {
        $this->status = $status;
        $this->dataPesan();
    }
    public function render()
    {
        $breads=[
            ['url'=>url()->current(), 'title'=> ucfirst($this->status)],
        ];
        return view('livewire.admin.whatsapp.monitoring-pesan')->layoutData(['breads'=>$breads]);
    }

    public function dataPesan()
    {
        $messages= Message::where('sending_status', $this->status)
            ->when($this->status == 'pending', function ($query) {
                return $query->whereNull('message_id');
            })
            ->when($this->search, function ($query) {
                $query->whereHas('student', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->limit(200)
            ->get()
            ->map(function ($item) {
            return [
                'Nama'=>$item->student?->name,
                'Target'=>$item->target,
                'Waktu'=>Carbon::parse($item->created_at)->format('d/m/Y H:i'),
            ];
        });
        $this->messages = $messages;
    }
}
