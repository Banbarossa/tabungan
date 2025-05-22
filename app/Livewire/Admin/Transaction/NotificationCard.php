<?php

namespace App\Livewire\Admin\Transaction;

use App\Models\Student;
use Livewire\Component;

class NotificationCard extends Component
{

    public Student $student;

    public $sendnotif;
    public function render()
    {
        $this->sendnotif = $this->student->send_notification;
        return view('livewire.admin.transaction.notification-card');
    }

    public function updatedSendnotif(){
        $this->student->send_notification = !$this->student->send_notification;
        $this->student->save();
        $this->dispatch('student_updated');
    }
}
