<div>
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Log in to your account')" :description="__('Enter your nisn and password below to log in')" />
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form wire:submit="login" class="space-y-4">
            <flux:input wire:model="nisn" :label="__('NISN')" type="NISN" required autofocus autocomplete="NISN"
                placeholder="NISN SISWA" />


            <div class="relative">
                <flux:input wire:model="password" :label="__('Password')" type="password" required
                    autocomplete="current-password" :placeholder="__('Password')" viewable />


            </div>

            <label class="flex items-center gap-2">

                <input type="checkbox" wire:model="remember">

                <span>Remember Me</span>

            </label>

            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full">{{ __('Log in') }}</flux:button>
            </div>

            <p class="text-xs text-muted mt-1.5">
                    Lupa Pasword Login, silahkan hubungi bagian Keuangan?
                </p>

        </form>

    </div>
</div>
