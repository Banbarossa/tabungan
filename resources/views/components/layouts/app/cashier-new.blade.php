<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <div class=" text-white pt-6 py-8 px-4 md:px-8 shadow-lg sticky top-0 z-100"
        style="background: linear-gradient(155deg, #7f1d1d 0%, #991b1b 45%, #5a0f0f 100%);">
        <div class="max-w-7xl mx-auto flex  items-center justify-between gap-4">
            <div class="flex items-center space-x-3">
                <div
                    class="w-12 h-12 flex-none  rounded-2xl bg-red-800/80 border border-red-400 flex items-center justify-center font-bold text-xl text-white shadow-inner">
                    {{ strtoupper(substr(auth()->user()->name ?? 'K', 0, 1)) }}
                </div>
                <div>
                    <p class="text-xs text-indigo-200 uppercase font-semibold tracking-wider">Kasir</p>
                    <h1 class="text-lg md:text-xl font-bold leading-tight line-clamp-1">{{ auth()->user()->name }}</h1>
                </div>
            </div>
            @php
                $menu = [
                    ['label' => 'Dashboard', 'url' => '/dashboard', 'icon' => 'home'],
                    ['label' => 'Tarik', 'url' => '/mobile-scan', 'icon' => 'camera'],
                    ['label' => 'Cek Saldo', 'url' => '/cek-saldo', 'icon' => 'calculator'],
                    ['label' => 'Riwayat', 'url' => '/riwayat', 'icon' => 'clock'],
                    ['label' => 'Laporan', 'url' => '/laporan', 'icon' => 'document'],
                ];
            @endphp

            <!-- Menus for Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-1 bg-red-900/50 p-1.5 rounded-xl border border-red-500/30">
                @foreach ($menu as $item)
                    <a href="{{ $item['url'] }}"
                        class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->is(ltrim($item['url'], '/')) ? 'bg-white text-red-600 shadow' : 'text-red-100 hover:bg-red-500/50' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>
            <div class="border rounded-lg overflow-hidden bg-white/10 flex-none">
                <flux:dropdown position="top" align="end">
                    <flux:profile :initials="substr(auth()->user()->name??'K',0,1)" icon-trailing="chevron-down" />

                    <flux:menu>
                        <flux:menu.radio.group>
                            <div class="p-0 text-sm font-normal">
                                <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                    <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                        <span
                                            class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                            {{ substr(auth()->user()->name ?? 'K', 0, 1) }}
                                        </span>
                                    </span>

                                    <div class="grid flex-1 text-start text-sm leading-tight">
                                        <span
                                            class="truncate font-semibold line-clamp-1">{{ auth()->user()->name }}</span>
                                        <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                    </div>
                                </div>
                            </div>
                        </flux:menu.radio.group>

                        <flux:menu.separator />
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

                        <flux:menu.separator />

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                                class="w-full">
                                {{ __('Log Out') }}
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
            </div>

            {{-- <div
                class="flex items-center w-auto justify-between md:justify-end space-x-3 text-xs bg-indigo-700/40 border border-indigo-500/40 px-3.5 py-2 rounded-xl text-indigo-100">
                <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Sistem Siap • {{ now()->format('d M Y') }}</span>
            </div> --}}
        </div>
    </div>

    <div class="max-w-7xl mx-auto mt-4 lg:mt-8 px-4 md:px-0 mb-32">
        {{ $slot }}
    </div>

    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 py-2.5 px-6 lg:hidden z-50 shadow-lg">
        <div class="flex justify-around items-center max-w-md mx-auto">
            @foreach ($menu as $item)
                <a href="{{ $item['url'] }}"
                    class="flex flex-col items-center space-y-1 text-xs {{ request()->is(ltrim($item['url'], '/')) ? 'text-red-800 font-bold' : 'text-slate-400 font-medium hover:text-slate-600' }}">
                    <flux:icon name="{{ $item['icon'] }}" class="w-4 h-4"></flux:icon>
                    <span class="capitalize text-[9px]">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </div>
    </div>
    <x-settings.modal-setting />

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    @fluxScripts
</body>

</html>
