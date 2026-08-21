<?php

namespace App\Livewire\Admin\TopupJajan;

use App\Models\TopupRequest;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ListTopupRequest extends Component
{
    public string $status = 'pending';
    public string $search = '';
    public function mount(string $status = 'pending')
    {
        $this->status = $status;
        if(session()->has('success')){
            LivewireAlert::title('Berhasil')
                ->text(session('success'))
                ->position(Position::Center)
                ->success()
                ->show();
        }
    }

    public function render()
    {
        $breads = [
            ['url' => url()->current(), 'title' => 'Topup Jajan'],
        ];
        return view('livewire.admin.topup-jajan.list-topup-request')->layoutData(['breads' => $breads]);
    }
    public function changeStatus()
    {
        $this->dataRiwayat();
    }

    #[Computed()]
    public function dataRiwayat()
    {
        return TopupRequest::with('student')
            ->where('status', $this->status)
            ->when($this->search, function ($q) {
                $q->whereHas('student', function ($pq) {
                    $pq->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('created_at')
            ->where('type', 'wallet')
            ->paginate(20)->through(function ($item) {
                return [
                    'id' => $item->id,
                    'encript_id' => vinclaEncode($item->id),
                    'ref_number' => $item->reference_number,
                    'student_name' => $item->student?->name,
                    'student_nisn' => $item->student?->nisn,
                    'jumlah' => $item->jumlah,
                    'keterangan' => $item->keterangan,
                    'tanggal' => Carbon::parse($item->dateTime)->toDateString(),
                    'status' => $item->status,
                    'waktu_verifikasi' => $item->verification_at ?
                        Carbon::parse($item->verification_at)->locale('id')->translatedFormat('d F Y H:i:s')
                        : 'Belum Verifikasi',
                    'catatan' => $item->catatan_admin,
                    'verifikator' => $item->user?->name,
                    'resi' => $item->image_resi,
                ];
            });
    }
}
