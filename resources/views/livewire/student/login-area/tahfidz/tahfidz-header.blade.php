<div>
    <div class="wallet-gradient px-4 pt-12 pb-0 relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full bg-white/5"></div>
        <div class="absolute top-10 right-20 w-20 h-20 rounded-full bg-white/5"></div>
        <div class="flex items-center justify-between mb-5 relative">
            <a href="{{ route('student.dashboard') }}" wire:navigate
                class="p-2 rounded-full bg-white/10 hover:bg-white/20 transition-base">
                <flux:icon name="chevron-left" class="size-4 text-white" />
            </a>
            <h1 class="font-display font-bold text-white text-base">Tahfiz</h1>
            <button class="p-2 rounded-full bg-white/10 hover:bg-white/20 transition-base">
                <flux:icon name="arrow-down-tray" class="size-4 text-white" />
            </button>
        </div>

        <div class="text-center pb-5 relative">
            <p class="text-red-200 text-xs mb-1">Target Saat ini</p>
            <div class="flex items-center justify-center gap-3">
                <p class="font-display font-bold text-4xl text-white tracking-tight">
                    {{ data_get($target, 'juz'), '-' }}
                </p>
            </div>
            <div class="flex items-center justify-center gap-3">
                <p class="font-display  text-white tracking-tight text-sm"> Capaian:
                    {{ data_get($target, 'progress.persentase', '0') }} %
                </p>
            </div>
            <div class="flex gap-2 mt-1.5 flex-wrap justify-center">
                <span class="bg-white/15 text-white text-[10px] font-medium px-2 py-0.5 rounded-full">{{data_get($halaqah,'musyrif','-')}}</span>
                <span class="bg-white/15 text-white text-[10px] font-medium px-2 py-0.5 rounded-full">{{data_get($halaqah,'no_hp','-')}}</span>
            </div>

            {{-- <p class="text-red-200 text-[11px] mt-1">NIS:{{ data_get($data, 'nisn') }} · <strong
                    class="uppercase">{{ data_get($data, 'nama') }}</strong> </p> --}}

            <div class="flex justify-center gap-3 mt-4">
                {{-- @foreach ($quickActions as $a)
                    <a href="{{ route($a['routeName']) }}" wire:navigate
                        class="flex flex-col items-center gap-1 touch-feedback">
                        <div
                            class="w-11 h-11 rounded-2xl bg-white/15 hover:bg-white/25 flex items-center justify-center transition-base">
                            <flux:icon name="{{ $a['icon'] }}" class="text-white size-4" />
                        </div>
                        <span class="text-[10px] text-red-100">{{ $a['label'] }}</span>
                    </a>
                @endforeach --}}

            </div>
        </div>

        <div class="grid grid-cols-3 bg-white/10 rounded-t-2xl">

            {{-- @foreach (data_get($data, 'stats', []) as $key => $s)
                <div class="px-3 py-3 text-center {{ $key < 2 ? 'border-r border-white/10' : '' }}">
                    <p class="font-display font-bold text-white text-sm">{{ $s['value'] }}</p>
                    <p class="text-red-200 text-[9px] mt-0.5 leading-tight">{{ $s['label'] }}</p>
                </div>
            @endforeach --}}
        </div>
    </div>

    <div class="bg-white border-b border-gray-100 sticky top-0 z-10">
        <div class="flex divide-x">

            @foreach ($tabs as $t)
                <a wire:navigate href="{{ route($t['routeName']) }}"
                    class="flex-1 py-3 text-xs font-semibold transition-base relative text-center block {{ Request::routeIs($t['routeName']) ? 'text-[#7F1D1D]' : 'text-gray-400' }}}">
                    {{ $t['label'] }}

                    @if (Request::routeIs($t['routeName']))
                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-8 h-0.5 bg-[#7F1D1D] rounded-full">
                        </div>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</div>
