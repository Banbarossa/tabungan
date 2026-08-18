<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light" style="color-scheme: light;">

<head>
    @include('partials.head')
    @PwaHead
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        html {
            color-scheme: light !important;
        }

        body {
            color-scheme: light !important;
        }

        .dark {
            color-scheme: light !important;
        }
    </style>
</head>

<body class="min-h-screen" style="background:#F8F7F5;">
    {{-- <header
        class="hidden lg:flex items-center justify-between bg-white border-b border-gray-100 fixed top-0 left-0 right-0 z-30 px-8"
        style="box-shadow: 0 2px 12px rgba(0,0,0,0.05); height:64px;">
        <div class="flex items-center gap-3 shrink-0">
            <div class="w-8 h-8 rounded-xl header-gradient flex items-center justify-center">
                <x-icon name="academic" :size="16" class="text-white" />
            </div>
            <div>
                <p class="font-display font-bold text-[#7F1D1D] text-sm leading-tight">Pesantren Imam Syafi'i</p>
                <p class="text-gray-400 text-[10px]">Portal Wali Santri</p>
            </div>
        </div>

        <nav class="flex items-center gap-1">
            @foreach ([['id' => 'home', 'label' => 'Beranda', 'icon' => 'home'], ['id' => 'tahfidz', 'label' => 'Tahfidz', 'icon' => 'tahfidz'], ['id' => 'academic', 'label' => 'Akademik', 'icon' => 'academic'], ['id' => 'finance', 'label' => 'Keuangan', 'icon' => 'finance'], ['id' => 'attendance', 'label' => 'Kehadiran', 'icon' => 'attendance'], ['id' => 'announce', 'label' => 'Pengumuman', 'icon' => 'announce', 'badge' => 3], ['id' => 'messages', 'label' => 'Pesan', 'icon' => 'messages', 'badge' => 2]] as $item)
                <button
                    class="relative flex items-center gap-1.5 px-3 py-2 rounded-xl text-sm font-medium transition-base bg-red-50 text-[#7F1D1D]">
                    text-gray-500 hover:bg-gray-50 hover:text-gray-700
                    <x-icon :name="$item['icon']" :size="15" />
                    {{ $item['label'] }}
                    @if (!empty($item['badge']))
                        <span
                            class="min-w-[16px] h-[16px] bg-red-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center px-1 leading-none">{{ $item['badge'] }}</span>
                    @endif
                    @if ($activeNav === $item['id'])
                    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-4 h-0.5 bg-[#7F1D1D] rounded-full">
                    </div>
                    @endif
                </button>
            @endforeach
        </nav>

        <div class="flex items-center gap-2 shrink-0">
            <button class="relative p-2 rounded-xl bg-gray-50 hover:bg-gray-100 transition-base">
                <flux:icon name="bell" class="text-gray-600 size-6" />
                <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
            <div class="flex items-center gap-2 bg-gray-50 rounded-xl px-3 py-1.5">
                <flux:dropdown position="top" align="end">
                    <flux:profile circle class="cursor-pointer" :initials="auth()->user()->initials()" />

                    <flux:menu>
                        <flux:menu.radio.group>
                            <div class="p-0 text-sm font-normal">
                                <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                    <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                        <span
                                            class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                            {{ auth()->user()->initials() }}
                                        </span>
                                    </span>

                                    <div class="grid flex-1 text-start text-sm leading-tight">
                                        <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                        <span class="truncate text-xs">{{ auth()->user()->notification_account }}</span>
                                    </div>
                                </div>
                            </div>
                        </flux:menu.radio.group>


                        <flux:menu.radio.group>
                            <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                                {{ __('Settings') }}</flux:menu.item>
                        </flux:menu.radio.group>

                        <flux:menu.separator />

                        <form method="POST" action="{{ route('student.logout') }}" class="w-full">
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                                class="w-full">
                                Log Out
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
            </div>
        </div>
    </header> --}}
    {{-- <flux:header container sticky stashable  class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 ">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <a href="{{ route('student.dashboard') }}" class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0" wire:navigate>
                <x-app-logo />
            </a>



            <flux:spacer />

            <flux:navbar class="me-1.5 space-x-0.5 rtl:space-x-reverse py-0!">
                <flux:tooltip :content="__('Search')" position="bottom">
                    <flux:navbar.item class="!h-10 [&>div>svg]:size-5" icon="phone" href="#" :label="__('Search')" />
                </flux:tooltip>
            </flux:navbar>

            <!-- Desktop User Menu -->
            <flux:dropdown position="top" align="end">
                <flux:profile
                    circle
                    class="cursor-pointer"
                    :initials="auth()->user()->initials()"
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
                                    <span class="truncate text-xs">{{ auth()->user()->notification_account }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('student.logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            Log Out
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        <!-- Mobile Menu -->
        <flux:sidebar stashable sticky class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('student.dashboard') }}" class="ms-1 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')">
                    <flux:navlist.item icon="layout-grid" :href="route('student.dashboard')" :current="request()->routeIs('student.dashboard')" wire:navigate>
                      Dashboard
                    </flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

        </flux:sidebar> --}}



    <main class="max-w-2xl mx-auto pb-28 ">
        {{ $slot }}
    </main>

    {{-- ═══════════════════════ BOTTOM NAV (mobile) ═══════════════════════ --}}
    <nav class="fixed bottom-2 left-0 right-0 bottom-nav z-40">
        <div
            class="flex items-stretch max-w-2xl mx-auto rounded-xl bg-white/95 border border-gray-100 shadow backdrop-blur-sm">

            {{-- Item Navigasi Utama --}}
            @foreach ([['id' => 'home', 'routeName' => 'student.dashboard', 'prefix' => 'student/dashboard', 'label' => 'Beranda', 'icon' => 'home'], ['id' => 'Tahfidz', 'routeName' => 'student.tahfidz', 'prefix' => 'student/tahfidz', 'label' => 'Tahfidz', 'icon' => 'book-open'], ['id' => 'finance', 'routeName' => 'student.dompet', 'prefix' => 'student/dompet', 'label' => 'Dompet', 'icon' => 'shopping-cart'], ['id' => 'profile', 'routeName' => 'student.profile.detail', 'prefix' => 'student/profile', 'label' => 'Profil', 'icon' => 'user-circle']] as $tab)
                @php $isActive = Request::is($tab['prefix'].'*'); @endphp

                <a href="{{ route($tab['routeName']) }}" wire:navigate
                    class="flex-1 flex flex-col items-center justify-center py-2.5 gap-0.5 relative touch-feedback group">

                    {{-- Indicator Aktif (Pindah ke bawah agar tidak menutupi icon) --}}
                    @if ($isActive)
                        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-8 h-0.5 bg-[#7F1D1D] rounded-b-full">
                        </div>
                    @endif

                    <div class="relative">
                        <x-icon :name="$tab['icon']" :size="20"
                            class="transition-colors {{ $isActive ? 'text-[#7F1D1D]' : 'text-gray-400 group-hover:text-gray-600' }}" />
                    </div>

                    <span
                        class="text-[10px] font-medium transition-colors {{ $isActive ? 'text-[#7F1D1D] font-semibold' : 'text-gray-400 group-hover:text-gray-600' }}">
                        {{ $tab['label'] }}
                    </span>
                </a>
            @endforeach

            {{-- Item Logout (Menggunakan struktur & ukuran yang sama persis) --}}
            <form method="POST" action="{{ route('student.logout') }}" class="flex-1 flex" x-data="{ submitting: false }"
                x-on:submit="
        if (submitting) { $event.preventDefault(); return; }
        submitting = true;
    ">
                @csrf
                <button type="submit" :disabled="submitting"
                    class="w-full flex flex-col items-center justify-center py-2.5 gap-0.5 relative touch-feedback text-gray-400 hover:text-red-600 transition-colors group">
                    <div class="relative">
                        <x-icon name="arrow-left-end-on-rectangle" :size="20"
                            class="transition-colors group-hover:text-red-600" />
                    </div>
                    <span class="text-[10px] font-medium transition-colors group-hover:text-red-600">
                        Keluar
                    </span>
                </button>
            </form>

        </div>
    </nav>

    {{-- ═══════════════════════ FAB ═══════════════════════ --}}
    {{-- <div class="fixed bottom-24 right-4 z-50 lg:bottom-6 lg:right-6 flex flex-col items-end gap-2"
        x-data="{ open: false }">
        <div class="flex flex-col gap-2 mb-2" x-show="open" x-transition x-cloak>
            @foreach ([['label' => 'WhatsApp Wali Kelas', 'color' => '#25D366'], ['label' => 'Hubungi Admin', 'color' => '#7F1D1D'], ['label' => 'Laporan Darurat', 'color' => '#DC2626']] as $item)
                <button
                    class="flex items-center gap-2 bg-white rounded-full px-4 py-2 shadow text-xs font-semibold text-gray-700 hover:scale-105 transition-base">
                    <div class="w-2 h-2 rounded-full" style="background: {{ $item['color'] }};"></div>
                    {{ $item['label'] }}
                </button>
            @endforeach
        </div>
        <button x-on:click="open = !open"
            class="rounded-full flex items-center justify-center fab-shadow transition-base hover:scale-105"
            style="background: linear-gradient(135deg, #7F1D1D 0%, #B91C1C 100%); width:52px; height:52px;">
            <template x-if="!open">
                <flux:icon name="phone" class="text-white size-6" />
            </template>
            <template x-if="open">
                icon2
                <flux:icon name="x-mark" class="text-white size-6" />
            </template>
        </button>
    </div> --}}


    {{-- push Banner --}}
    <x-layouts.partials.push-banner />

    @fluxScripts
    @RegisterServiceWorkerScript
    <script>
        document.documentElement.classList.remove('dark');
        document.documentElement.classList.add('light');
    </script>
</body>

</html>
