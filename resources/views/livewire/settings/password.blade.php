<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component {
    public string $password = '';
    public string $password_confirmation = '';

    public $user;
    public $user_id;

    /**
     * Update the password for the currently authenticated user.
     */
    public function mount($code = null){
        if($code){
            $id = vinclaDecode($code);
            $user = User::find($id);
            $this->user = $user;
            $this->user = $user->id;
        }else{
            $this->user= Auth::user();
            $this->user_id= Auth::user()->id;
        }
    }

    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }
        $user = User::find($this->user_id);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section class="w-full">

    <x-settings.layout :heading="__('Update password')" :subheading="__('Ensure your account is using a long, random password to stay secure')">
        <form wire:submit="updatePassword" class="mt-6 space-y-6">
            <flux:input
                wire:model="password"
                :label="__('New password')"
                type="password"
                required
                autocomplete="new-password"
                viewable
            />
            <flux:input
                wire:model="password_confirmation"
                :label="__('Confirm Password')"
                type="password"
                required
                autocomplete="new-password"
                viewable
            />

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>

                <x-toast class="me-3" on="password-updated">
                    {{ __('Saved.') }}
                </x-toast>
            </div>
        </form>
    </x-settings.layout>
</section>
