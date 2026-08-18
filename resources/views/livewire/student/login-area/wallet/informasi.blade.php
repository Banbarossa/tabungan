<div>
    <div class="px-4 pt-4 space-y-4">
        <div class="wallet-gradient rounded-2xl p-5 relative overflow-hidden shadow-lg">
            <div class="absolute -top-8 -right-8 w-32 h-32 rounded-full bg-white/5"></div>
            <div class="absolute -bottom-6 right-20 w-20 h-20 rounded-full bg-white/5"></div>
            <div class="relative">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-red-200 text-[10px] uppercase tracking-widest">Pesantren Al-Ikhlas</p>
                        <p class="text-white/60 text-[10px] mt-0.5">Akun Uang Saku Digital</p>
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                        <Icon path={ICONS.wallet} size={16} class="text-white" />
                    </div>
                </div>
                <p class="text-white font-display font-bold text-xl leading-none uppercase">{{ auth()->user()->name }}
                </p>
                <p class="text-red-200 text-xs mt-1">NISN: {{ auth()->user()->nisn }}</p>
                <div class="flex justify-between items-center mt-4 pt-4 border-t border-white/10">
                    <div>
                        <p class="text-red-200 text-[10px]">Kelas</p>
                        <p class="text-white text-xs font-semibold">-</p>
                    </div>
                    <div>
                        <p class="text-red-200 text-[10px]">Asrama</p>
                        <p class="text-white text-xs font-semibold">-</p>
                    </div>
                    <div>
                        <p class="text-red-200 text-[10px]">Status</p>
                        <p
                            class="{{ auth()->user()->status ? 'text-green-400' : 'text-yellow-400' }}  text-xs font-semibold">
                            {{ auth()->user()->status ? 'Aktif' : 'Tidak Aktif' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 shadow">
            <h3 class="font-display font-bold text-gray-800 text-sm mb-3">Informasi Akun</h3>
            <div class="space-y-3">
                @foreach ($accountInfo as $r)
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-400">{{ $r['label'] }}</span>
                        <div class="flex items-center gap-1.5">
                            <span class="text-xs font-semibold text-gray-700">{{ $r['value'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 shadow">
            <div class="flex justify-between">
                <h3 class="font-display font-bold text-gray-800 text-sm mb-3">Penggunaan Hari Ini</h3>
            </div>
            <div class="space-y-3">
                <div>
                    <div class="flex justify-between mb-1.5">
                        <span class="text-xs text-red-800">Batas Harian: <strong>Rp.
                                {{ $limits['limit_harian'] }}</strong></span>
                        <span class="text-xs font-semibold text-gray-800">Rp. {{ $limits['used'] }} /
                            Rp. {{ $limits['limit_harian'] }}</span>
                    </div>
                    <ProgressBar pct={pct} color={color} />
                    <p class="text-[10px] text-gray-400 mt-1"><strong>Sisa: {{ $limits['sisa'] }}</strong> - (
                        {{ $limits['persen'] }}% terpakai )
                    </p>
                </div>
            </div>
        </div>
        <div>
            <flux:modal.trigger name="edit-profile">
                <flux:button icon="pencil-square" class="w-full" variant="primary" color='red'>
                    Ubah Limit
                </flux:button>
            </flux:modal.trigger>
        </div>


    </div>
</div>
