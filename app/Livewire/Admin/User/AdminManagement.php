<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminManagement extends Component
{
    public $search;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public $role;

    #[Layout('components.layouts.app')]
    #[Title('Manajemen Admin')]

    public $headings=['Nama','Email',];
    public function mount($role='admin'){
        $this->role = $role;
        if(session()->has('saved')){
            LivewireAlert::title(session('saved.title'))
                ->text(session('saved.text'))
                ->success()
                ->position(Position::Center)
                ->show();
        }
    }

    public function render()
    {
        $users = User::where('role',$this->role)
//            ->where('status',true)
            ->when($this->search,function($query){
                $query->where('name','like','%'.$this->search.'%');
            })
            ->orderBy('name')
            ->get()->map(function($user){
                return [
                    'id' => $user->id,
                    'Nama' => $user->name,
                    'Email' => $user->email,
                    'role' => $user->role,
                    'status' => $user->status,
                ];
            });

        $breads=[
            ['url'=>url()->current(),'title'=>ucwords($this->role)],
        ];

        return view('livewire.admin.user.admin-management',compact('users'))->layoutData(['breads'=>$breads]);
    }

    public function register(){
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
        ]);
        $validated['role']=$this->role;
        $validated['status']=true;

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        $this->dispatch('modal-close','add-user');
        $this->dispatch('user-updated');

    }

    public function ubahStatus($id){
        $akun = User::find($id);
        $akun->status=!$akun->status;
        $akun->save();

        LivewireAlert::title('success')
            ->text('Data berhasil diubah')
            ->success()
            ->position(Position::Center)
            ->show();
    }

}
