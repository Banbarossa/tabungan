<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
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

    #[Layout('components.layouts.app')]
    #[Title('Manajemen Admin')]

    public function render()
    {
        $users = User::where('role','admin')
            ->where('status',true)
            ->when($this->search,function($query){
                $query->where('name','like','%'.$this->search.'%');
            })
            ->orderBy('name')
            ->get();
        return view('livewire.admin.user.admin-management',compact('users'));
    }

    public function register(){
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
        ]);
        $validated['role']='admin';
        $validated['status']=true;

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        $this->dispatch('modal-close','add-user');
        $this->dispatch('user-updated');

    }

    public function nonactive($id){
        User::find($id)->update(['status'=>false]);
        $this->dispatch('user-updated');
    }
}
