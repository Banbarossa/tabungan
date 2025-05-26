<div>
    <x-slot:breadcrumbs>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>User</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </x-slot:breadcrumbs>
    <x-toast on="user-updated"></x-toast>
    <div class="flex items-center justify-between">

        <flux:button.group>

            <flux:button
                href="{{ route('user.admin') }}"
                >
                <span class="{{ request()->routeIs('user.admin') ? 'font-bold':'font-extralight text-gray-500' }}">Admin</span>
            </flux:button>
            <flux:button
                href="{{ route('user.cashier') }}"
                >
                 <span class="{{ request()->routeIs('user.cashier') ? 'font-bold':'font-extralight text-gray-500' }}">Cashier</span>
            </flux:button>

        </flux:button.group>

        <flux:modal.trigger name="add-user">
            <flux:button icon="plus" variant="primary">Tambah Data</flux:button>
        </flux:modal.trigger>
    </div>
    <div class="mt-4 max-w-lg">
        <flux:input icon="magnifying-glass" wire:model.live="search" placeholder="Search......"  size="sm" class=" mb-4"/>
        <flux:separator/>
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
