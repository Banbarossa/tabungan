<div class="px-4 space-y-6">
    <div
        class="grad-tahfidz rounded-2xl p-4 text-white shadow-lg space-y-4 relative overflow-hidden">
        {{-- Background Pattern Subtle --}}
        <div class="absolute -right-6 -bottom-6 opacity-10 pointer-events-none">
            <x-icon name="book-open" class="w-40 h-40" />
        </div>

        <div class="relative z-10 flex justify-between items-start">
            <div>
                <span
                    class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-white/20 backdrop-blur-md text-white/90 mb-1">
                    Kelompok Tahfidz
                </span>
                <h2 class="text-lg font-bold tracking-wide">{{ data_get($header, 'nama', '-') }}</h2>
            </div>
            <div
                class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/20 shrink-0">
                <x-icon name="academic-cap" class="w-6 h-6 text-white" />
            </div>
        </div>

        {{-- Divider --}}
        <div class="border-t border-white/15"></div>

        {{-- Info Musyrif & Action Button --}}
        <div class="relative z-10 flex items-center justify-between gap-2">
            <div class="flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center font-bold text-sm shrink-0">
                    {{ substr(data_get($header, 'musyrif', 'M'), 0, 1) }}
                </div>
                <div>
                    <p class="text-[11px] text-green-200">Musyrif / Pembimbing</p>
                    <p class="text-sm font-semibold">{{ data_get($header, 'musyrif', '-') }}</p>
                </div>
            </div>

            @if (data_get($header, 'no_hp'))
                @php
                    // Formatting nomor untuk WhatsApp API (mengubah +62 / 0 menjadi 62)
                    $phone = preg_replace('/[^0-9]/', '', data_get($header, 'no_hp'));
                    if (str_starts_with($phone, '0')) {
                        $phone = '62' . substr($phone, 1);
                    }
                @endphp
                <a href="https://wa.me/{{ $phone }}" target="_blank"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 active:scale-95 text-white text-xs font-medium shadow transition-all">
                    <x-icon name="chat-bubble-left-right" class="w-4 h-4" />
                    <span>Hubungi</span>
                </a>
            @endif
        </div>
    </div>
    <div>
        <div class="flex items-center justify-between mb-3">
            <h2 class="font-display font-bold text-gray-800 text-base">Setoran Terakhir</h2>
            <a href="{{ route('student.tahfidz.histories') }}" wire:navigate class="text-[#7F1D1D] text-xs font-semibold">Lihat Semua</a>
        </div>
        <livewire:student.login-area.tahfidz.hafalan-terakhir />
    </div>

    <livewire:student.login-area.tahfidz.statistik-ujian />
    <div
        class="bg-white rounded-2xl p-3.5 border border-gray-100 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

        {{-- Header Periode Laporan --}}
        <div class="flex items-center gap-2.5 shrink-0">
            <div class="w-8 h-8 rounded-lg bg-green-50 text-green-700 flex items-center justify-center shrink-0">
                <x-icon name="adjustments-horizontal" class="w-4 h-4" />
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-medium leading-none">Periode Laporan</p>
                <p class="text-xs font-bold text-gray-800 mt-1">
                    {{ $pilihanBulan[(int) ($selectedMonth ?? date('n'))] ?? '-' }} {{ $selectedYear ?? date('Y') }}
                </p>
            </div>
        </div>

        {{-- Dropdown Filter Bulan & Tahun --}}
        <div class="flex items-center gap-2 w-full sm:w-auto">
            {{-- Dropdown Bulan --}}
            <select wire:model.live="selectedMonth"
                class="flex-1 sm:flex-initial text-xs font-medium text-gray-700 bg-gray-50 border border-gray-200 rounded-lg px-2.5 py-2 sm:py-1.5 focus:outline-none focus:ring-1 focus:ring-[#7F1D1D] transition-all truncate cursor-pointer">
                @foreach ($pilihanBulan as $num => $name)
                    <option value="{{ $num }}">{{ $name }}</option>
                @endforeach
            </select>

            {{-- Dropdown Tahun --}}
            <select wire:model.live="selectedYear"
                class="w-24 sm:w-auto text-xs font-medium text-gray-700 bg-gray-50 border border-gray-200 rounded-lg px-2.5 py-2 sm:py-1.5 focus:outline-none focus:ring-1 focus:ring-[#7F1D1D] transition-all cursor-pointer">
                @for ($y = date('Y'); $y >= date('Y') - 3; $y--)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endfor
            </select>
        </div>

    </div>

    <div class="bg-white  rounded-2xl p-4 shadow space-y-6">
        <div>
            <p class=" text-xs  text-neutral-600 dark:text-neutral-200">Perkembangan
                {{ data_get($data, 'currentMonth', Carbon\Carbon::now()->locale('id')->translatedFormat('M Y')) }}
            </p>
            <h3 class="font-semibold text-primary dark:text-secondary">Perkembangan Bulan Ini
            </h3>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-green-50   p-4 rounded-lg border border-border">
                <div class="text-lg font-bold text-primary dark:text-secondary">
                    {{ data_get($data, 'monthSummary.jumlah_ziyadah') }}</div>
                <div class="text-xs text-gray-500 ">x Setoran Baru</div>
            </div>
            <div class="bg-green-50   p-4 rounded-lg border border-border">
                <div class="text-lg font-bold text-primary dark:text-secondary">
                    {{ data_get($data, 'monthSummary.jumlah_murajaah') }}</div>
                <div class="text-xs text-gray-500 ">x Murajaah</div>
            </div>
            <div class="bg-green-50   p-4 rounded-lg border border-border">
                <div class="text-lg font-bold text-primary dark:text-secondary">
                    {{ data_get($data, 'monthSummary.jumlah_ayat') }}</div>
                <div class="text-xs text-gray-500 ">Ayat Baru</div>
            </div>
            <div class="bg-green-50   p-4 rounded-lg border border-border">
                <div class="text-lg font-bold text-primary dark:text-secondary">
                    <div class="text-sm flex items-start gap-0.5">
                        @for ($i = 1; $i <= 5; $i++)
                            <flux:icon.star variant="solid"
                                class="w-4 {{ $i <= data_get($data, 'monthSummary.avg_rating', 0) ? 'text-yellow-400' : 'text-neutral-300' }}" />
                        @endfor
                    </div>
                </div>
                <div class="text-xs text-gray-500">Rating Rata Rata</div>
            </div>
        </div>
        <div class="mt-8 h-72">
            <canvas id="grafikPerkembangan"></canvas>
            @script
                <script>
                    let grafikPerkembanganChart = null;

                    function updatePerkembanganChart(data) {
                        const canvas = document.getElementById('grafikPerkembangan');

                        if (!canvas) return;

                        if (grafikPerkembanganChart) {
                            grafikPerkembanganChart.destroy();
                            grafikPerkembanganChart = null;
                        }

                        grafikPerkembanganChart = renderPerkembanganChart(
                            'grafikPerkembangan',
                            data
                        );
                    }

                    $nextTick(() => {
                        updatePerkembanganChart(
                            @js(data_get($data, 'grafik'))
                        );
                    });

                    // Dengarkan event dari Livewire
                    $wire.on('grafik-updated', (event) => {
                        updatePerkembanganChart(event.grafik);
                    });
                </script>
            @endscript

        </div>
    </div>
    {{-- ============================="Kehadiran"============================= --}}
    <div class="space-y-4 ">


        @php
            $hadir = $kehadiran['hadir'] ?? 0;
            $izin = $kehadiran['izin'] ?? 0;
            $sakit = $kehadiran['sakit'] ?? 0;
            $alpa = $kehadiran['alpa'] ?? 0;
            $totalPertemuan = $kehadiran['total'] ?? 0;
            $persentase = (float) ($kehadiran['persentase_kehadiran'] ?? 0);

            if ($persentase >= 85) {
                $badgeTheme = 'bg-emerald-500/20 text-emerald-200';
                $barColor = 'bg-emerald-400';
                $statusNote = 'Kehadiran Sangat Baik';
            } elseif ($persentase >= 70) {
                $badgeTheme = 'bg-amber-500/20 text-amber-200';
                $barColor = 'bg-amber-400';
                $statusNote = 'Kehadiran Cukup';
            } else {
                $badgeTheme = 'bg-rose-500/20 text-rose-200';
                $barColor = 'bg-rose-400';
                $statusNote = 'Perlu Tingkatkan Kehadiran';
            }
        @endphp

        {{-- Hero Card: Utama & Visual Progress --}}
        <div
            class="grad-tahfidz rounded-2xl p-5 text-white shadow-lg relative overflow-hidden space-y-4">
            {{-- Background Pattern --}}
            <div class="absolute -right-8 -bottom-8 opacity-10 pointer-events-none">
                <x-icon name="chart-bar" class="w-48 h-48 text-white" />
            </div>

            <div class="relative z-10 flex items-start justify-between">
                <div>
                    <span
                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-semibold {{ $badgeTheme }} backdrop-blur-md">
                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                        {{ $statusNote }}
                    </span>
                    <p class="text-xs text-emerald-50 mt-2">Tingkat Kehadiran Bulan Ini</p>
                </div>

                <div class="text-right">
                    <span class="text-xs text-emerald-50 font-medium">Total Sesi</span>
                    <p class="text-base font-bold text-white">{{ $totalPertemuan }} <span
                            class="text-xs font-normal text-emerald-50">Kali</span></p>
                </div>
            </div>

            {{-- Display Angka Persentase Utama --}}
            <div class="relative z-10 flex items-baseline gap-2">
                <h1 class="text-4xl font-extrabold tracking-tight">{{ number_format($persentase, 0) }}%</h1>
                <span class="text-xs text-emerald-50">Persentase Kehadiran</span>
            </div>

            {{-- Progress Bar --}}
            <div class="relative z-10 space-y-1">
                <div class="w-full h-2 bg-white/20 rounded-full overflow-hidden backdrop-blur-sm">
                    <div class="h-full rounded-full transition-all duration-500 {{ $barColor }}"
                        style="width: {{ min(100, max(0, $persentase)) }}%"></div>
                </div>
            </div>
        </div>

        {{-- Grid 4 Detail Status Presensi --}}
        <div class="grid grid-cols-2 gap-2.5">

            {{-- HADIR --}}
            <div class="bg-white rounded-xl border border-gray-100 p-3.5 shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div
                        class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                        <x-icon name="check-circle" class="w-5 h-5" />
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-400 font-medium">Hadir</p>
                        <p class="text-base font-bold text-gray-800">{{ $hadir }}</p>
                    </div>
                </div>
                <span class="text-[10px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">
                    {{ $totalPertemuan > 0 ? round(($hadir / $totalPertemuan) * 100) : 0 }}%
                </span>
            </div>

            {{-- IZIN --}}
            <div class="bg-white rounded-xl border border-gray-100 p-3.5 shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                        <x-icon name="document-text" class="w-5 h-5" />
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-400 font-medium">Izin</p>
                        <p class="text-base font-bold text-gray-800">{{ $izin }}</p>
                    </div>
                </div>
                <span class="text-[10px] font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md">
                    {{ $totalPertemuan > 0 ? round(($izin / $totalPertemuan) * 100) : 0 }}%
                </span>
            </div>

            {{-- SAKIT --}}
            <div class="bg-white rounded-xl border border-gray-100 p-3.5 shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div
                        class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                        <x-icon name="heart" class="w-5 h-5" />
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-400 font-medium">Sakit</p>
                        <p class="text-base font-bold text-gray-800">{{ $sakit }}</p>
                    </div>
                </div>
                <span class="text-[10px] font-semibold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-md">
                    {{ $totalPertemuan > 0 ? round(($sakit / $totalPertemuan) * 100) : 0 }}%
                </span>
            </div>

            {{-- ALPA --}}
            <div class="bg-white rounded-xl border border-gray-100 p-3.5 shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                        <x-icon name="x-circle" class="w-5 h-5" />
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-400 font-medium">Alpa</p>
                        <p class="text-base font-bold text-gray-800">{{ $alpa }}</p>
                    </div>
                </div>
                <span class="text-[10px] font-semibold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-md">
                    {{ $totalPertemuan > 0 ? round(($alpa / $totalPertemuan) * 100) : 0 }}%
                </span>
            </div>

        </div>

    </div>
</div>
