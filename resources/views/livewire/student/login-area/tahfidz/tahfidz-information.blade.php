<div class="px-4 space-y-4">

    {{-- Card Header: Informasi Kelas & Musyrif --}}
    <div class="bg-gradient-to-br from-[#7F1D1D] to-[#991B1B] rounded-2xl p-4 text-white shadow-lg space-y-4 relative overflow-hidden">
        {{-- Background Pattern Subtle --}}
        <div class="absolute -right-6 -bottom-6 opacity-10 pointer-events-none">
            <x-icon name="book-open" class="w-40 h-40" />
        </div>

        <div class="relative z-10 flex justify-between items-start">
            <div>
                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-white/20 backdrop-blur-md text-white/90 mb-1">
                    Kelompok Tahfidz
                </span>
                <h2 class="text-lg font-bold tracking-wide">{{ data_get($data, 'nama', '-') }}</h2>
            </div>
            <div class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/20 shrink-0">
                <x-icon name="academic-cap" class="w-6 h-6 text-white" />
            </div>
        </div>

        {{-- Divider --}}
        <div class="border-t border-white/15"></div>

        {{-- Info Musyrif & Action Button --}}
        <div class="relative z-10 flex items-center justify-between gap-2">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center font-bold text-sm shrink-0">
                    {{ substr(data_get($data, 'musyrif', 'M'), 0, 1) }}
                </div>
                <div>
                    <p class="text-[11px] text-red-200">Musyrif / Pembimbing</p>
                    <p class="text-sm font-semibold">{{ data_get($data, 'musyrif', '-') }}</p>
                </div>
            </div>

            @if (data_get($data, 'no_hp'))
                @php
                    // Formatting nomor untuk WhatsApp API (mengubah +62 / 0 menjadi 62)
                    $phone = preg_replace('/[^0-9]/', '', data_get($data, 'no_hp'));
                    if (str_starts_with($phone, '0')) {
                        $phone = '62' . substr($phone, 1);
                    }
                @endphp
                <a href="https://wa.me/{{ $phone }}" target="_blank"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-500 hover:bg-emerald-600 active:scale-95 text-white text-xs font-medium shadow transition-all">
                    <x-icon name="chat-bubble-left-right" class="w-4 h-4" />
                    <span>Hubungi</span>
                </a>
            @endif
        </div>
    </div>

    {{-- Section Roster / Jadwal --}}
    <div class="space-y-4">
        <div class="flex items-center justify-between px-1">
            <h3 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                <x-icon name="calendar" class="w-4 h-4 text-[#7F1D1D]" />
                Jadwal Roster Halaqah
            </h3>
            <span class="text-xs text-gray-500 font-medium">
                {{ count(data_get($data, 'roster', [])) }} Sesi
            </span>
        </div>

        {{-- Grid / List Roster --}}
        <div class="grid gap-2.5">
            @forelse (data_get($data, 'roster', []) as $item)
                @php
                    // Parsing Waktu (Format dari HH:MM:SS ke HH:MM)
                    $times = explode('-', $item['waktu'] ?? '');
                    $startTime = isset($times[0]) ? substr($times[0], 0, 5) : '-';
                    $endTime = isset($times[1]) ? substr($times[1], 0, 5) : '-';

                    // Deteksi Sesi Pagi vs Malam/Sore berdasarkan jam awal
                    $hour = (int) substr($startTime, 0, 2);
                    $isMorning = $hour >= 3 && $hour < 12;
                @endphp

                <div class="rounded-xl bg-white border border-gray-100 p-3.5 shadow-sm flex items-center justify-between hover:border-gray-200 transition-all">

                    {{-- Badge Hari & Sesi --}}
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex flex-col items-center justify-center shrink-0 {{ $isMorning ? 'bg-amber-50 text-amber-600' : 'bg-indigo-50 text-indigo-600' }}">
                            <x-icon :name="$isMorning ? 'sun' : 'moon'" class="w-5 h-5" />
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <p class="font-bold text-gray-900 text-sm">{{ $item['hari'] }}</p>
                            </div>
                            <p class="text-xs text-gray-400 mt-0.5">
                                {{ $isMorning ? 'Sesi Pagi / Subuh' : 'Sesi Petang / Malam' }}
                            </p>
                        </div>
                    </div>

                    {{-- Jam / Waktu --}}
                    <div class="text-right">
                        <div class="inline-flex items-center gap-1 font-semibold text-xs text-gray-800 bg-gray-50 px-2.5 py-1 rounded-lg border border-gray-100">
                            <x-icon name="clock" class="w-3.5 h-3.5 text-gray-400" />
                            <span>{{ $startTime }} - {{ $endTime }}</span>
                        </div>
                    </div>

                </div>
            @empty
                <div class="p-6 text-center bg-white rounded-xl border border-dashed border-gray-200 text-gray-400 text-xs">
                    Belum ada jadwal roster.
                </div>
            @endforelse
        </div>
    </div>

</div>
