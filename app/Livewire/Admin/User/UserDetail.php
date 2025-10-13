<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Couchbase\Role;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

class UserDetail extends Component
{

    public $user;
    public $previousUrl;
    public $role;


    #[Layout('components.layouts.app')]
    #[Title('Detail')]
    public function mount($role,$code){
        $this->role=$role;
        $id = vinclaDecode($code);

        $this->user= User::find($id);
        $this->previousUrl = url()->previous();
    }

    public function render()
    {
        $breads=[
            ['url'=>route('user.index',[$this->role]),'title'=>ucwords($this->role) ],
            ['url'=>url()->current(),'title'=>'Detail'],
        ];

        return view('livewire.admin.user.user-detail')->layoutData(['breads'=>$breads]);
    }
    public function ubahRole(){
        $user_role = $this->user->role;
        $role =$user_role == 'admin'? 'cashier':'admin';
        $this->user->update([
            'role' => $role
        ]);
        LivewireAlert::title('Berhasil')
            ->text('Data berhasil diubah')
            ->success()
            ->position(Position::Center)
            ->show();
    }
}
