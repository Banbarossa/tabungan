<div>
    <div class="wallet-gradient px-4 pt-12 pb-0 relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full bg-white/5"></div>
        <div class="absolute top-10 right-20 w-20 h-20 rounded-full bg-white/5"></div>
        <div class="flex items-center justify-between mb-5 relative">
            <a href="{{ route('student.dashboard') }}" wire:navigate
                class="p-2 rounded-full bg-white/10 hover:bg-white/20 transition-base">
                <flux:icon name="chevron-left" class="size-4 text-white" />
            </a>
            <h1 class="font-display font-bold text-white text-base">Profile</h1>
            <button class="p-2 rounded-full bg-white/10 hover:bg-white/20 transition-base">
                <flux:icon name="arrow-down-tray" class="size-4 text-white" />
            </button>
        </div>

        <div class="text-center pb-5 relative">
            <p class="text-red-200 text-xs mb-1">Nama</p>
            <div class="flex items-center justify-center gap-3">
                <p class="font-display font-bold text-2xl text-white tracking-tight uppercase">
                    {{ auth()->user()->name }}
                </p>
            </div>

            <p class="text-red-200 text-[11px] mt-1">NISN:{{ auth()->user()->nisn }} </p>

            <div class="flex justify-center gap-3 mt-4">
                <img class="h-28 rounded-2xl shadow aspect-square" src="{{ asset(auth()->user()->avatar) }}"
                    alt="{{ auth()->user()->name }}" />

            </div>
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
