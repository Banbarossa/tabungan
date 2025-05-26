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

    /**
     * Update the password for the currently authenticated user.
     */
    public function mount($code = null){
        if($code){
            $id = vinclaDecode($code);
            $this->user = User::find($id);
        }else{
            $user= Auth::user();
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

        $this->user->update([
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
            />
            <flux:input
                wire:model="password_confirmation"
                :label="__('Confirm Password')"
                type="password"
                required
                autocomplete="new-password"
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
