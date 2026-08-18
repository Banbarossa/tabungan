<div>
    @php
        $type = strtolower(data_get($data, 'type', 'ziyadah'));
        $rating = (int) data_get($data, 'rating', 0);
        $catatan = data_get($data, 'catatan');

        // Theme warna berdasarkan tipe setoran
        $isZiyadah = $type === 'ziyadah';
        $typeBadgeBg = $isZiyadah
            ? 'bg-emerald-50 text-emerald-700 border-emerald-200'
            : 'bg-blue-50 text-blue-700 border-blue-200';
        $typeDotBg = $isZiyadah ? 'bg-emerald-500' : 'bg-blue-500';
    @endphp

    <div
        class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm hover:shadow-md transition-all space-y-3.5 max-w-2xl mx-auto">

        {{-- Header: Tanggal, Waktu & Badge Tipe --}}
        <div class="flex items-start justify-between gap-2">
            <div class="space-y-0.5">
                <span
                    class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-semibold border capitalize {{ $typeBadgeBg }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $typeDotBg }}"></span>
                    {{ $type }}
                </span>
                <h4 class="text-xs text-gray-400 font-medium pt-1">
                    {{ data_get($data, 'tanggal', '-') }}
                    <span class="text-gray-300">•</span>
                    <span>{{ data_get($data, 'waktu', '-') }}</span>
                </h4>
            </div>

            <div class="flex items-center gap-0.5 bg-amber-50 px-2 py-1 rounded-lg border border-amber-100 shrink-0">
                @for ($i = 1; $i <= 5; $i++)
                    <x-icon name="star"
                        class="w-3.5 h-3.5 {{ $i <= $rating ? 'text-amber-400 fill-amber-400' : 'text-gray-200' }}" />
                @endfor
                <span class="text-xs font-bold text-amber-700 ml-1">{{ $rating }}</span>
            </div>
        </div>

        {{-- Content Utama: Ayat / Surat --}}
        <div class="p-3 bg-gray-50/80 rounded-xl border border-gray-100/80 flex items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-red-50 text-[#7F1D1D] flex items-center justify-center shrink-0">
                    <x-icon name="book-open" class="w-5 h-5" />
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-medium">Ayat / Setoran Hafalan</p>
                    <p class="text-sm font-bold text-gray-900 leading-tight">
                        {{ data_get($data, 'ayat', '-') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Footer: Musyrif & Catatan (Jika Ada) --}}
        <div class="pt-1 flex items-center justify-between text-xs border-t border-gray-50">
            {{-- Musyrif / Penguji --}}
            <div class="flex items-center gap-1.5 text-gray-500">
                <x-icon name="user-circle" class="w-4 h-4 text-gray-400 shrink-0" />
                <span class="text-gray-400">Musyrif:</span>
                <span class="font-semibold text-gray-700 truncate max-w-[150px] sm:max-w-none">
                    {{ data_get($data, 'musyrif', '-') }}
                </span>
            </div>

            @if ($catatan)
                <div
                    class="flex items-center gap-1 text-amber-600 bg-amber-50 px-2 py-0.5 rounded text-[11px] font-medium">
                    <x-icon name="chat-bubble-bottom-center-text" class="w-3.5 h-3.5" />
                    <span>Ada Catatan</span>
                </div>
            @else
                <span class="text-[11px] text-gray-400 italic">Tanpa catatan</span>
            @endif
        </div>

        @if ($catatan)
            <div class="p-2.5 bg-amber-50/50 rounded-lg border border-amber-100 text-xs text-amber-900 leading-relaxed">
                <span class="font-semibold">Catatan Musyrif:</span> {{ $catatan }}
            </div>
        @endif

    </div>
</div>
