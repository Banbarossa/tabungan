<div>




    {{-- ═══════════════════════ MOBILE LAYOUT ═══════════════════════ --}}
    <div>

        <div class="header-gradient rounded-b-[28px] px-4 pt-12 pb-5">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-red-200 text-xs font-medium tracking-wider uppercase">Pesantren Imam Syafi'i</p>
                    <h1 class="text-white text-lg font-bold font-display leading-tight">Selamat Datang 👋</h1>
                </div>
                <button class="relative p-2 rounded-full bg-white/10 backdrop-blur-sm hover:bg-white/20 transition-base" >
                    <flux:icon name='bell' class="text-white" />
                    <span class="absolute top-1 right-1 w-2 h-2 bg-yellow-400 rounded-full border border-red-800"></span>
                </button>
            </div>

            <div class="flex gap-4 items-center">
                <div class="relative shrink-0">
                    <img src="{{ asset('images/avatar.jpg') }}" alt="Logo"
                        class="w-16 h-16 rounded-2xl object-cover border-2 border-white/30">
                    <span
                        class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-400 rounded-full border-2 border-white flex items-center justify-center">
                        <flux:icon name="check" class="text-white" class="size-4" />
                        {{-- <x-icon name="check" :size="10" class="text-white" /> --}}
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <h2 class="text-white font-bold font-display text-base leading-tight truncate">
                        {{ data_get($identitas, 'nama', 'Undefined') }}</h2>
                    <p class="text-red-200 text-xs mt-0.5">NIS: {{ data_get($identitas, 'nisn', '000000000') }}</p>
                    <div class="flex gap-2 mt-1.5 flex-wrap">
                        <span
                            class="bg-white/15 text-white text-[10px] font-medium px-2 py-0.5 rounded-full">Kelas</span>
                        <span
                            class="bg-white/15 text-white text-[10px] font-medium px-2 py-0.5 rounded-full">Asrama</span>
                    </div>
                </div>
            </div>

            <div class="flex gap-2 mt-3">
                <div class="flex-1 bg-white/10 rounded-xl px-3 py-2">
                    <p class="text-red-200 text-[10px] uppercase tracking-wide">Semester</p>
                    <p class="text-white text-xs font-semibold mt-0.5">Semester</p>
                </div>
                <div class="bg-green-400/20 rounded-xl px-3 py-2 flex items-center gap-1.5">
                    <div class="w-2 h-2 rounded-full bg-green-400 shrink-0"></div>
                    <p class="text-green-300 text-xs font-semibold">Aktif</p>
                </div>
            </div>
        </div>

        <div class="mx-4 mt-4">
            <div class="wallet-gradient rounded-2xl p-4 relative overflow-hidden card-shadow-lg">
                <div class="absolute -top-8 -right-8 w-32 h-32 rounded-full bg-white/5"></div>
                <div class="absolute -bottom-6 -left-6 w-24 h-24 rounded-full bg-white/5"></div>
                <div class="absolute top-4 right-16 w-12 h-12 rounded-full bg-white/5"></div>
                <div class="absolute right-4 top-1/2 -translate-y-1/2 opacity-20">
                    {{-- <x-icon name="wallet" :size="80" class="text-white" /> --}}
                </div>

                <div class="relative">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-7 h-7 rounded-lg bg-white/20 flex items-center justify-center">
                            {{-- <x-icon name="wallet" :size="14" class="text-white" /> --}}
                            <flux:icon name='wallet' class="size-4 text-white" />
                        </div>
                        <p class="text-red-100 text-xs font-medium">Saldo Uang Saku</p>
                    </div>


                    <div x-data="{ revealed: false }" x-init="setTimeout(() => revealed = true, 300)"
                        x-bind:style="revealed ? 'opacity:1; transform:translateY(0)' : 'opacity:0; transform:translateY(8px)'"
                        class="transition-all duration-700">
                        <p class="text-white/60 text-xs mb-1">Saldo Tersedia</p>
                        <p class="text-white font-bold font-display text-3xl leading-none tracking-tight">
                            Rp {{ data_get($identitas, 'saldo', 0) }}
                        </p>
                        <p class="text-red-200 text-xs mt-1">Diperbarui hari ini ·
                            {{ data_get($identitas, 'waktu', '00:00') }} WIB</p>
                    </div>

                    <div class="flex gap-2 mt-4">
                        <a wire:navigate href="{{ route('student.dompet') }}"
                            class="flex-1 bg-white/20 hover:bg-white/30 text-white text-xs font-semibold py-2.5 rounded-xl flex items-center justify-center gap-1.5 transition-base touch-feedback">
                            <flux:icon name='arrows-right-left' class="size-4 text-white" />
                            Riwayat
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main menu --}}
        <div class="mx-4 mt-6">
            <div class="flex items-center justify-between mb-3">
                <h2 class="font-display font-bold text-gray-800 text-base">Menu Utama</h2>
                <button class="text-[#7F1D1D] text-xs font-semibold">Lihat Semua</button>
            </div>
            <div class="grid grid-cols-4 gap-3">
                @foreach ($menus as $item)
                    <a href="{{ route($item['routeName']) }}" wire:navigate
                        class="flex flex-col items-center gap-1.5 group touch-feedback">
                        <div
                            class="relative w-full aspect-square rounded-2xl {{ $item['grad'] }} flex items-center justify-center shadow-sm group-hover:scale-105 transition duration-500">
                            <flux:icon name="{{ $item['icon'] }}" class="text-white size-8" />
                            {{-- <x-badge :count="$item['badge']" /> --}}
                        </div>
                        <span
                            class="text-[10px] text-gray-600 font-medium text-center leading-tight px-0.5">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Tahfidz card --}}
        <div class="mx-4 mt-6">
            <div class="flex items-center justify-between mb-3">
                <h2 class="font-display font-bold text-gray-800 text-base">Laporan Tahfidz Terbaru</h2>
                <a wire:navigate href={{ route('student.tahfidz') }}
                    class="text-[#7F1D1D] text-xs font-semibold flex items-center gap-0.5">
                    Semua
                    {{-- <x-icon name="chevronRight" :size="12" /> --}}
                </a>
            </div>

            <livewire:student.login-area.tahfidz.hafalan-terakhir />

        </div>

    </div>



    {{-- ═══════════════════════ DESKTOP LAYOUT ═══════════════════════ --}}
    {{-- <div class="hidden lg:block p-6 ">

        Stats row
        <div class="grid grid-cols-4 gap-4 mb-6">
            @foreach ([['label' => 'Saldo Uang Saku', 'value' => 'Rp ' . data_get($identitas, 'saldo', '0'), 'trend' => 'Diperbarui tadi', 'icon' => 'wallet', 'color' => '#7F1D1D', 'bg' => '#FEF2F2'], ['label' => 'Kehadiran Bulan Ini', 'value' => '96%', 'trend' => '2 Alpha', 'icon' => 'finger-print', 'color' => '#1E40AF', 'bg' => '#EFF6FF'], ['label' => 'Ayat Disetorkan', 'value' => '248 Ayat', 'trend' => 'Bulan Agustus', 'icon' => 'book-open', 'color' => '#065F46', 'bg' => '#F0FDF4'], ['label' => 'Tagihan Aktif', 'value' => 'Rp 750.000', 'trend' => 'SPP Agustus', 'icon' => 'credit-card', 'color' => '#4C1D95', 'bg' => '#F5F3FF']] as $s)
                <div class="bg-white rounded-2xl p-4 shadow flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0"
                        style="background: {{ $s['bg'] }};">
                        <flux:icon name="{{ $s['icon'] }}" class="size-6" style="color: {{ $s['color'] }};" />
                        <x-icon :name="$s['icon']" :size="20" style="color: {{ $s['color'] }};" />
                    </div>
                    <div>
                        <p class="font-display font-bold text-gray-800 text-base leading-tight">{{ $s['value'] }}</p>
                        <p class="text-[10px] text-gray-500">{{ $s['label'] }}</p>
                        <p class="text-[10px] text-gray-400">{{ $s['trend'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-3 gap-5">
            Col 1
            <div class="space-y-5">
                <div class="bg-white rounded-2xl overflow-hidden shadow">
                    <div class="header-gradient px-4 py-5">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('images/avatar.jpg') }}"
                                alt="{{ data_get($identitas, 'nama', 'Undefined') }}"
                                class="w-14 h-14 rounded-xl object-cover border-2 border-white/30">
                            <div>
                                <h3 class="font-display font-bold text-white text-sm">
                                    {{ data_get($identitas, 'nama', 'Undefined') }}</h3>
                                <p class="text-red-200 text-[10px]">NIS:
                                    {{ data_get($identitas, 'nisn', '0000000000') }}
                                </p>
                                <span
                                    class="inline-block bg-white/20 text-white text-[9px] px-2 py-0.5 rounded-full mt-1">Kelas</span>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 space-y-2">
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-gray-400">Asrama</span>
                            <span class="font-medium text-gray-700">{{ $student['asrama'] }}</span>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-gray-400">Semester</span>
                            <span class="font-medium text-gray-700">{{ $student['semester'] }}</span>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-gray-400">Status</span>
                            <span
                                class="bg-green-100 text-green-700 font-semibold px-2 py-0.5 rounded-full text-[10px]">{{ data_get($identitas, 'status', 'Aktif') }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-4 shadow">
                    <h3 class="font-display font-bold text-gray-800 text-sm mb-3">Menu Utama</h3>
                    <div class="grid grid-cols-4 gap-2">
                        @foreach ($menus as $item)
                            <a href="{{ route($item['routeName']) }}" wire:navigate
                                class="flex flex-col items-center gap-1 group touch-feedback">
                                <div
                                    class="relative w-full aspect-square rounded-xl {{ $item['grad'] }} flex items-center justify-center shadow-sm group-hover:scale-105 transition-base">
                                    <flux:icon name="{{ $item['icon'] }}" class="text-white size-8" />
                                </div>
                                <span
                                    class="text-[8px] text-gray-500 font-medium text-center leading-tight">{{ $item['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            Col 2
            <div class="space-y-5">
                <div class="wallet-gradient rounded-2xl p-5 shadow-md relative overflow-hidden">
                    <div class="absolute -top-8 -right-8 w-28 h-28 rounded-full bg-white/5"></div>
                    <div class="absolute -bottom-6 -left-6 w-20 h-20 rounded-full bg-white/5"></div>
                    <div class="relative">
                        <p class="text-red-200 text-xs font-medium mb-2">Saldo Uang Saku</p>
                        <p class="text-white font-bold font-display text-3xl">Rp
                            {{ data_get($identitas, 'saldo', '0') }}</p>
                        <p class="text-red-200 text-xs mt-1 mb-4">Diperbarui: Hari ini,
                            {{ data_get($identitas, 'waktu') }} WIB</p>
                        <div class="flex gap-2">
                            <a wire:navigate href="{{ route('student.dompet') }}"
                                class="flex-1 bg-white/20 hover:bg-white/30 text-white text-xs font-semibold py-2 rounded-xl flex items-center justify-center gap-1.5 transition-base">
                                Riwayat
                                <flux:icon name='arrows-right-left' class="size-4 text-white" />
                            </a>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-4 card-shadow">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-display font-bold text-gray-800 text-sm">Tahfidz Terbaru</h3>
                        <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $tahfidz['type'] }}</span>
                    </div>
                    <div class="flex items-start justify-between mb-3">
                            <div>
                                <h4 class="font-bold text-gray-800 text-sm font-display">{{ $tahfidz['surah'] }}</h4>
                                <p class="text-gray-500 text-xs">Ayat {{ $tahfidz['ayahStart'] }}–{{ $tahfidz['ayahEnd'] }} · {{ $tahfidz['verses'] }} ayat</p>
                                <p class="text-gray-400 text-[10px] mt-1">{{ $tahfidz['musyrif'] }}</p>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold font-display text-[#7F1D1D]">{{ $tahfidz['score'] }}</div>
                                <x-star-rating :score="$tahfidz['score']" />
                            </div>
                        </div>
                        <div class="bg-amber-50 rounded-xl px-3 py-2 mb-3">
                            <p class="text-[10px] text-amber-800 leading-relaxed">{{ $tahfidz['notes'] }}</p>
                        </div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-gray-500">Target Hafalan</span>
                            <span class="font-bold text-[#7F1D1D]">{{ $tahfidz['overallPct'] }}%</span>
                        </div>
                    <x-progress-bar :pct="$tahfidz['overallPct']" color="#7F1D1D" />
                </div>
            </div>

            Col 3
            <div class="space-y-5">
                <div class="bg-white rounded-2xl p-4 card-shadow">
                    <h3 class="font-display font-bold text-gray-800 text-sm mb-3">Ringkasan Bulan Ini</h3>
                    <div class="space-y-3">
                        @foreach ($monthlySummary as $item)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full" style="background: {{ $item['color'] }};"></div>
                                        <span class="text-xs text-gray-600">{{ $item['label'] }}</span>
                                    </div>
                                    <span class="text-sm font-bold font-display" style="color: {{ $item['color'] }};">{{ $item['value'] }}</span>
                                </div>
                            @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-4 card-shadow">
                    <h3 class="font-display font-bold text-gray-800 text-sm mb-3">Aktivitas Terbaru</h3>
                    <div class="space-y-3">
                        @foreach (array_slice($activities, 0, 4) as $act)
                                <div class="flex items-start gap-2.5">
                                    <div class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0" style="background: {{ $act['bg'] }};">
                                        <x-icon :name="$act['icon']" :size="12" style="color: {{ $act['color'] }};" />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold text-gray-800">{{ $act['label'] }}</p>
                                        <p class="text-[10px] text-gray-500 truncate">{{ $act['detail'] }}</p>
                                        <p class="text-[10px] text-gray-400">{{ $act['time'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-4 card-shadow">
                    <h3 class="font-display font-bold text-gray-800 text-sm mb-3">Kontak Cepat</h3>
                    <div class="space-y-2">
                        @foreach ($quickContacts as $c)
                                <button class="w-full flex items-center gap-3 p-2.5 rounded-xl hover:bg-gray-50 transition-base text-left">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0" style="background: {{ $c['color'] }};">
                                        <x-icon name="contact" :size="14" class="text-white" />
                                    </div>
                                    <div>
                                        <p class="text-[10px] text-gray-400">{{ $c['label'] }}</p>
                                        <p class="text-xs font-semibold text-gray-700">{{ $c['name'] }}</p>
                                    </div>
                                    <x-icon name="chevronRight" :size="14" class="text-gray-300 ml-auto" />
                                </button>
                            @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- ======================PASSWORD WARNING MODAL====================== --}}
    <div x-data x-init="if (@js($isDefaultPassword)) { $nextTick(() => Flux.modal('password_warning').show()) }">

        <flux:modal name="password_warning" class="md:w-[28rem]">
            <div class="space-y-6">
                <!-- Header -->
                <div class="text-left">
                    <div class="flex items-center gap-2 text-amber-500 mb-1">
                        <flux:icon name="shield-exclamation" class="w-6 h-6" />
                        <flux:heading size="lg">Keamanan Akun</flux:heading>
                    </div>
                    <flux:subheading>
                        Anda masih menggunakan password default. Demi keamanan data kamu, segera ganti password.
                    </flux:subheading>
                </div>

                <flux:separator />

                <!-- Tips Password Aman -->
                <div
                    class="space-y-3 bg-amber-50 dark:bg-amber-950/30 p-4 rounded-xl border border-amber-200 dark:border-amber-800/50">
                    <flux:text class="font-semibold text-amber-900 dark:text-amber-200 flex items-center gap-1.5">
                        <flux:icon name="light-bulb" class="w-4 h-4 text-amber-600 dark:text-amber-400" />
                        Tips Membuat Password Aman:
                    </flux:text>

                    <ul class="text-xs text-amber-800 dark:text-amber-300  list-disc pl-5">
                        <li>Gunakan minimal **8–12 karakter** atau lebih.</li>
                        <li>Kombinasikan **huruf besar, huruf kecil, angka,** dan **simbol** (contoh: `@`, `#`, `$`).
                        </li>
                        <li>Hindari data pribadi yang mudah ditebak (seperti *NISN, tanggal lahir, atau nama*).</li>
                        <li>Jangan gunakan password yang sama dengan akun lain.</li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-3">
                    <flux:spacer />

                    <!-- Tombol jika ingin memberi opsi mengabaikan sementara (opsional) -->
                    <flux:modal.close>
                        <flux:button variant="ghost">Nanti Saja</flux:button>
                    </flux:modal.close>

                    <!-- Tombol Aksi Utama ke halaman ganti password -->
                    <flux:button href="{{ route('student.profile.password') }}" variant="primary"
                        icon-trailing="arrow-right">
                        Ubah Sekarang
                    </flux:button>
                </div>
            </div>
        </flux:modal>
    </div>

</div>
