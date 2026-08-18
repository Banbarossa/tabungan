<div class="px-4 lg:px-0">
    <div class=" pt-4 space-y-4">
        <div class="bg-white rounded-2xl p-4 shadow flex items-center justify-between">
            <div>
                <p class="font-display font-bold text-gray-800 text-sm">Langkah Pengiriman Saldo</p>
                <p class="text-xs text-gray-400 mt-0.5">Akan di proses oleh admin</p>
            </div>
            <button
                class="wallet-gradient text-white text-sm font-semibold px-4 py-2.5 rounded-xl flex items-center gap-1.5 transition-base hover:opacity-90">
                <flux:icon name="plus" class="size-4" />Top Up
            </button>
        </div>

        <div class="bg-white rounded-2xl p-4 shadow">
            <h3 class="font-display font-bold text-gray-800 text-sm mb-3">Cara Top Up</h3>
            <div class="space-y-3">
                @foreach ($steps as $item)
                    <div class="flex gap-3 items-start">
                        <div
                            class="w-7 h-7 rounded-full bg-[#7F1D1D] text-white font-bold text-xs flex items-center justify-center shrink-0 mt-0.5">
                            {{ $item['step'] }}</div>
                        <div>
                            <p class="text-xs font-semibold text-gray-800">{{ $item['title'] }}</p>
                            <p class="text-[11px] text-gray-400 mt-0.5">{{ $item['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 shadow">
            <h3 class="font-display font-bold text-gray-800 text-sm mb-3">Rekening Pesantren</h3>
            <div class="space-y-2.5">
                <div class="flex items-center gap-2.5">
                    <img src="{{ data_get($bank,'logo','') }}" class="w-8 h-8 rounded-lg flex items-center justify-center object-center object-cover"/>
                        {{-- <span class="text-white font-bold text-[9px]">{{ data_get($bank,'bank','') }}</span> --}}
                    <div>
                        <p class="text-xs font-semibold text-gray-800">{{ data_get($bank,'bank','-') }} : {{ data_get($bank,'nama','-') }}</p>
                        <p class="text-[11px] text-gray-500">{{ data_get($bank,'rek','-') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-4 shadow bg-amber-50 rounded-xl px-3 py-2 flex items-start gap-2">
            <flux:icon name="information-circle" class="size-4 text-amber-600 shrink-0 mt-0.5" />
            <p class="text-[10px] text-amber-700 leading-relaxed">Selalu sertakan NIS santri
                <strong>{{ auth()->user()->nisn }}</strong> pada berita transfer agar saldo dapat diidentifikasi.
            </p>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-4 shadow">
        <h3 class="font-display font-bold text-gray-800 text-sm mb-3">Riwayat Top Up</h3>
        <div class="space-y-0">
            @foreach ($this->riwayat as $i => $tu)
                <div
                    class="flex items-start gap-3 py-3 {{ $i < $this->riwayat->count() - 1 ? 'border-b border-gray-50' : '' }}">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 bg-green-100">
                        <flux:icon name="check" class='size-4 text-green-600' />
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-bold font-display text-green-600">+Rp. {{ $tu->jumlah }}</p>
                            <span
                                class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-green-100 text-green-700">
                                Berhasil
                            </span>
                        </div>
                        <p class="text-[11px] text-gray-500 mt-0.5">oleh: {{ $tu->petugas }}</p>
                        <p class="text-[10px] text-gray-400">{{ $tu->tanggal }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
