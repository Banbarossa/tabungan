<div class="px-4 space-y-4">
    @forelse ($data as $d)
        @php
            // Ambil persentase dengan aman
            $persentase = data_get($d, 'progress.persentase', -1);
            $isDalamProses = data_get($d, 'status', false);

            // Menentukan status & skema warna badge
            if ($isDalamProses) {
                $statusText = 'Dalam Proses';
                $badgeBg = 'bg-amber-50 text-amber-700 border-amber-200';
                $dotBg = 'bg-amber-500';
                $barBg = 'bg-amber-500';
            } elseif ($persentase < 0) {
                $statusText = 'Belum Mulai';
                $badgeBg = 'bg-slate-100 text-slate-600 border-slate-200';
                $dotBg = 'bg-slate-400';
                $barBg = 'bg-slate-300';
            } elseif ($persentase < 100) {
                $statusText = 'Belum Selesai';
                $badgeBg = 'bg-blue-50 text-blue-700 border-blue-200';
                $dotBg = 'bg-blue-500';
                $barBg = 'bg-blue-500';
            } else {
                $statusText = 'Selesai';
                $badgeBg = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                $dotBg = 'bg-emerald-500';
                $barBg = 'bg-emerald-500';
            }

            $progressWidth = max(0, min(100, $persentase));
        @endphp

        <div
            class="rounded-xl bg-white border border-gray-100 shadow-sm hover:shadow-md transition-shadow p-4 space-y-3">
            <div class="flex items-start justify-between gap-3">
                <h3 class="font-semibold text-gray-900 text-sm md:text-base line-clamp-2">
                    {{ data_get($d, 'name', '-') }}
                </h3>

                <span
                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium border shrink-0 {{ $badgeBg }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $dotBg }}"></span>
                    {{ $statusText }}
                </span>
            </div>

            {{-- Progress Bar (Tampil jika persentase >= 0) --}}
            @if ($persentase >= 0)
                <div class="space-y-1.5 pt-1">
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-gray-500 font-medium">Progress</span>
                        <span class="text-gray-700 font-semibold">{{ $progressWidth }}%</span>
                    </div>
                    <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-300 {{ $barBg }}"
                            style="width: {{ $progressWidth }}%">
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @empty
        {{-- Tampilan Kosong (Empty State) --}}
        <div class="rounded-xl bg-white border border-dashed border-gray-300 p-8 text-center space-y-2">
            <div class="w-12 h-12 mx-auto rounded-full bg-gray-50 flex items-center justify-center text-gray-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
            </div>
            <p class="text-sm font-medium text-gray-900">Belum Ada Data</p>
            <p class="text-xs text-gray-500">Data tugas atau kegiatan akan muncul di sini.</p>
        </div>
    @endforelse
</div>
