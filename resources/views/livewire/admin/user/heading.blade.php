<div>
    <x-slot:breadcrumbs>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>User</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </x-slot:breadcrumbs>
    <div class="flex items-center justify-between">


        <flux:modal.trigger name="add-user">
            <flux:button icon="plus" variant="primary">Tambah Data</flux:button>
        </flux:modal.trigger>
    </div>


    <flux:modal name="add-user" variant="flyout" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="xl">Tambah Data</flux:heading>
            </div>
            <img src="{{ asset('images/admin-avatar.png') }}" alt="user" class="w-10 h-10 rounded-lg">

            <form wire:submit="register" class="flex flex-col gap-6">
                <flux:input
                    wire:model="name"
                    :label="__('Name')"
                    type="text"
                    autofocus
                    autocomplete="name"
                    :placeholder="__('Full name')"
                />

                <!-- Email Address -->
                <flux:input
                    wire:model="email"
                    :label="__('Email address')"
                    type="email"
                    autocomplete="email"
                    placeholder="email@example.com"
                />

                <!-- Password -->
                <flux:input
                    wire:model="password"
                    :label="__('Password')"
                    type="password"
                    autocomplete="new-password"
                    :placeholder="__('Password')"
                    viewable
                />

                <!-- Confirm Password -->
                <flux:input
                    wire:model="password_confirmation"
                    :label="__('Confirm password')"
                    type="password"
                    autocomplete="new-password"
                    :placeholder="__('Confirm password')"
                    viewable
                />
                <div class="flex">
                    <flux:spacer />

                    <flux:button type="submit" variant="primary" icon="plus">Tambah Data</flux:button>
                </div>
            </form>



        </div>
    </flux:modal>
</div>
