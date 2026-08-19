<?php

namespace App\Livewire\Student\LoginArea;

use App\Notifications\NewAnnouncementNotification;
use Carbon\Carbon;
use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Component;

class StudentDashboard extends Component
{

    public $menus = [];
    public array $identitas = [];
    public bool $isDefaultPassword=true;
    #[Layout('components.layouts.student-layout-app')]
    public function mount()
    {
        $this->menus = $this->menuData();
        $santri = auth()->user();
        $this->isDefaultPassword =$santri->is_default_password;
        $this->identitas = [
            'nama' => strtoupper($santri->name),
            'nisn' => $santri->nisn,
            'saldo' => number_format($santri->saldo, 0, '.', ','),
            'waktu' => Carbon::now()->format('H i'),
            'status' => $santri->status,
        ];
    }
    public function render()
    {
        return view('livewire.student.login-area.student-dashboard');
    }




    public function menuData()
    {
        return [
            [
                'id' => 'wallet',
                'label' => 'Uang Saku',
                'grad' => 'grad-wallet',
                'icon' => 'wallet',
                'badge' => 0,
                'routeName' => 'student.dompet'
            ],
            [
                'id' => 'tahfidz',
                'label' => 'Tahfidz',
                'grad' => 'grad-tahfidz',
                'icon' => 'book-open',
                'badge' => 1,
                'routeName' => 'student.tahfidz'
            ],
            [
                'id' => 'profile',
                'label' => 'Profile',
                'grad' => 'grad-messages',
                'icon' => 'user-circle',
                'badge' => 2,
                'routeName' => 'student.profile.detail'
            ],

            [
                'id' => 'academic',
                'label' => 'Rapor Akademik',
                'grad' => 'grad-gray',
                'icon' => 'academic-cap',
                'badge' => 0,
                'routeName' => 'student.tahfidz'
            ],

            [
                'id' => 'attendance',
                'label' => 'Kehadiran',
                'grad' => 'grad-gray',
                'icon' => 'academic-cap',
                'badge' => 2,
                'routeName' => 'student.tahfidz'
            ],

            [
                'id' => 'finance',
                'label' => 'Pembayaran',
                'grad' => 'grad-gray',
                'icon' => 'academic-cap',
                'badge' => 1,
                'routeName' => 'student.tahfidz'
            ],
            [
                'id' => 'achievement',
                'label' => 'Prestasi',
                'grad' => 'grad-gray',
                'icon' => 'academic-cap',
                'badge' => 0,
                'routeName' => 'student.tahfidz'
            ],
            [
                'id' => 'behavior',
                'label' => 'Catatan Sikap',
                'grad' => 'grad-gray',
                'icon' => 'academic-cap',
                'badge' => 0,
                'routeName' => 'student.tahfidz'
            ],
            [
                'id' => 'health',
                'label' => 'Kesehatan',
                'grad' => 'grad-gray',
                'icon' => 'academic-cap',
                'badge' => 0,
                'routeName' => 'student.tahfidz'
            ],
            [
                'id' => 'permission',
                'label' => 'Perizinan',
                'grad' => 'grad-gray',
                'icon' => 'academic-cap',
                'badge' => 0,
                'routeName' => 'student.tahfidz'
            ],
            [
                'id' => 'schedule',
                'label' => 'Jadwal',
                'grad' => 'grad-gray',
                'icon' => 'academic-cap',
                'badge' => 0,
                'routeName' => 'student.tahfidz'
            ],
            [
                'id' => 'announce',
                'label' => 'Pengumuman',
                'grad' => 'grad-gray',
                'icon' => 'academic-cap',
                'badge' => 3,
                'routeName' => 'student.tahfidz'
            ],

        ];
    }

    // public function testNotif(){
    //     $user = auth('student')->user();
    //     $user->notify(new NewAnnouncementNotification('test','Tems Message','/'));
    // }
}
