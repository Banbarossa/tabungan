<div class="hidden lg:flex lg:w-[46%] xl:w-[42%] flex-col relative overflow-hidden"
    style="background: linear-gradient(155deg, #7f1d1d 0%, #991b1b 45%, #5a0f0f 100%);">

    <div class="absolute inset-0 geo-pattern opacity-60"></div>
    <div class="arch-motif" style="top:-60px; left:60px;"></div>
    <div class="arch-motif" style="top:-60px; left:200px; opacity:0.6;"></div>
    <div class="arch-motif" style="bottom:80px; right:-40px; border-color: rgba(212,160,23,0.12);"></div>

    <div class="absolute top-0 left-0 right-0 h-1"
        style="background: linear-gradient(90deg, #d4a017, #f0c030, #d4a017);"></div>

    <div class="relative flex flex-col items-center justify-center flex-1 px-12 xl:px-16 text-white">
        <x-layouts.partials.logo class="w-16 mb-8 drop-shadow-xl"/>
        <h1 class="text-center mb-2 leading-tight"
            style="font-family: var(--font-display); font-size: clamp(1.5rem,2vw,2rem); font-weight:700;">
            Pesantren Imam Syafi'i
        </h1>
        <p class="text-center text-sm font-light tracking-widest uppercase opacity-80 mb-10"
            style="color:#fde68a; letter-spacing:0.12em;">
            Sistem Informasi Akademik
        </p>

        <div class="flex items-center gap-3 w-full max-w-xs mb-10">
            <div class="flex-1 h-px" style="background: rgba(212,160,23,0.35);"></div>
            <svg width="16" height="16" viewBox="0 0 16 16" fill="#d4a017">
                <path d="M8 1l1.75 3.5 3.87.56-2.8 2.73.66 3.85L8 9.85 4.52 11.64l.66-3.85L2.38 5.06l3.87-.56z" />
            </svg>
            <div class="flex-1 h-px" style="background: rgba(212,160,23,0.35);"></div>
        </div>

        <div class="flex flex-col gap-3 w-full max-w-xs">
            @foreach ([['icon' => '📚', 'label' => 'Informasi Tahfidz'], ['icon' => '📊', 'label' => 'Laporan perkembangan']] as $f)
                <div class="flex items-center gap-3 px-4 py-3 rounded-2xl"
                    style="background: rgba(255,255,255,0.08); backdrop-filter: blur(8px);">
                    <span class="text-lg">{{ $f['icon'] }}</span>
                    <span class="text-sm font-light opacity-90">{{ $f['label'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <p class="relative text-center text-xs opacity-40 pb-6" style="color:#fff;">
        © {{ now()->year }} Pesantren Imam Syafi'i
    </p>
</div>
