<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800">
<flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 ">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark"/>

    <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
        <x-app-logo/>
    </a>

    <flux:navlist variant="outline">
        <flux:navlist.group :heading="__('Identitas')" class="grid">
            <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                               wire:navigate>Dashboard
            </flux:navlist.item>
            <flux:navlist.group heading="Santri" expandable :expanded="Request::is('account*')">
                <flux:navlist.item href="{{route('account.index',['status'=>'aktif'])}}"
                                   :current="Request::is('account/aktif')" wire:navigate>Aktif
                </flux:navlist.item>
                <flux:navlist.item href="{{route('account.index',['status'=>'nonaktif'])}}"
                                   :current="Request::is('account/nonaktif')" wire:navigate>Tidak Aktif
                </flux:navlist.item>

            </flux:navlist.group>

        </flux:navlist.group>
        <flux:navlist.group :heading="__('Transaction')" class="grid">
            <flux:navlist.item icon="banknotes" :href="route('transaction')"
                               :current="request()->routeIs('transaction')" wire:navigate>Transaction
            </flux:navlist.item>
            <flux:navlist.item icon="tag" :href="route('daily-limit-management')"
                               :current="request()->routeIs('daily-limit-management')" wire:navigate>Limit Harian
            </flux:navlist.item>
            <flux:navlist.item icon="arrow-path" :href="route('daily-history')"
                               :current="request()->routeIs('daily-history')" wire:navigate>Daily History
            </flux:navlist.item>
            <flux:navlist.item icon="calendar-days" :href="route('calendar')" :current="request()->is('calendar')">
                Calendar
            </flux:navlist.item>
        </flux:navlist.group>
        <flux:navlist.group :heading="__('Laporan')" class="grid">
            <flux:navlist.group heading="Laporan" expandable :expanded="Request::is('laporan*')">
                <flux:navlist.item href="{{route('laporan.filter',)}}"
                                   :current="Request::is('laporan-filter')" wire:navigate>Harian
                </flux:navlist.item>
            </flux:navlist.group>
        </flux:navlist.group>

        <flux:navlist.group :heading="__('User')" class="grid">
            <flux:navlist.item icon="users" :href="route('user.admin')" :current="request()->routeIs('user.admin')"
                               wire:navigate>Servicer
            </flux:navlist.item>
        </flux:navlist.group>
        <flux:navlist.group :heading="__('Pengaturan')" class="grid">
            <flux:navlist.item icon="chat-bubble-left-ellipsis" :href="route('whatsapp.history')"
                               :current="request()->routeIs('whatsapp.history')" wire:navigate>Riwayat Pesan
            </flux:navlist.item>
            <flux:navlist.item icon="cog-6-tooth" :href="route('whatsapp.setting')"
                               :current="request()->routeIs('whatsapp.setting')" wire:navigate>Whatsapp
            </flux:navlist.item>
            <flux:navlist.item icon="cog-6-tooth" :href="route('pengaturan.jenis-transaksi')"
                               :current="request()->routeIs('pengaturan.jenis-transaksi')" wire:navigate>Jenis transaksi
            </flux:navlist.item>
        </flux:navlist.group>
    </flux:navlist>

    <!-- Desktop User Menu -->
</flux:sidebar>

<!-- Mobile User Menu -->
<flux:header sticky class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 ">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left"/>

    <flux:spacer/>

    <flux:dropdown position="top" align="end">
        <flux:profile
            :initials="auth()->user()->initials()"
            icon-trailing="chevron-down"
        />

        <flux:menu>
            <flux:menu.radio.group>
                <div class="p-0 text-sm font-normal">
                    <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                        <div class="grid flex-1 text-start text-sm leading-tight">
                            <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                            <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                        </div>
                    </div>
                </div>
            </flux:menu.radio.group>

            <flux:menu.separator/>
            <flux:menu.radio.group>
                <flux:modal.trigger name="edit-appearance">
                    <button type="button"
                            class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
                        <flux:icon.adjustments-horizontal
                            class="hover:text-indigo-600"></flux:icon.adjustments-horizontal>
                        <span
                            class="text-xs text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-500">Settings</span>
                    </button>
                </flux:modal.trigger>
                <flux:modal.trigger name="edit-profile">
                    <button type="button"
                            class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
                        <flux:icon.user class="hover:text-indigo-600"></flux:icon.user>
                        <span
                            class="text-xs text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-500">Profile</span>
                    </button>
                </flux:modal.trigger>
                <flux:modal.trigger name="edit-password">
                    <button type="button"
                            class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
                        <flux:icon.key class="hover:text-indigo-600"></flux:icon.key>
                        <span
                            class="text-xs text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-500">Password</span>
                    </button>
                </flux:modal.trigger>
            </flux:menu.radio.group>

            <flux:menu.separator/>

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                    {{ __('Log Out') }}
                </flux:menu.item>
            </form>
        </flux:menu>
    </flux:dropdown>
</flux:header>

{{ $slot }}


<x-settings.modal-setting/>

@stack('script')
@fluxScripts
</body>
</html>
