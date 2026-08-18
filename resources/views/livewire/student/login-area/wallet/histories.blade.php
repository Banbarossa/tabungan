<div>
    <div>
        <div class="px-4 pb-3 flex gap-2 overflow-x-auto scrollbar-hide">
            @foreach ($filterOptions as $opt)
                <button wire:click="changeFilter('{{ $opt['value'] }}')"
                    class="shrink-0 px-3 py-1.5 rounded-full text-xs font-semibold capitalize transition-base {{ $filter === $opt['value'] ? 'bg-[#7F1D1D] text-white' : 'bg-white text-gray-500 shadow' }}">
                    {{ $opt['label'] }}
                </button>
            @endforeach
        </div>



        <div class="px-4 ">
            <div class="space-y-4">
                @foreach ($this->dataRiwayat as $riwayat)
                    <div class="bg-white rounded-2xl overflow-hidden shadow">
                        <button
                            class="w-full flex items-center gap-3 px-4 py-3.5 hover:bg-gray-50 transition-base text-left ">
                            <div
                                class="w-10 h-10 rounded-2xl flex items-center justify-center shrink-0 {{ $riwayat->type === 'setor' ? 'bg-green-100' : 'bg-yellow-100' }}">

                                <flux:icon name="{{ $riwayat->type === 'setor' ? 'plus' : 'shopping-cart' }}"
                                    class="size-4  {{ $riwayat->type === 'setor' ? 'text-green-700' : 'text-orange-500' }}" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-800">{{ $riwayat->tanggal }}</p>
                                <p class="text-[11px] text-gray-400">
                                    {{ $riwayat->petugas }}
                                </p>
                            </div>
                            <div class="text-right shrink-0">
                                <p
                                    class="text-sm font-bold font-display {{ $riwayat->type === 'setor' ? 'text-green-600' : 'text-gray-800' }}">
                                    {{ $riwayat->type === 'setor' ? '+' : '-' }}
                                    Rp. {{ $riwayat->jumlah }}
                                </p>
                                <span
                                    class="text-[10px] px-1.5 py-0.5 rounded-full font-medium{{ $riwayat->type === 'setor' ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-400' }}">
                                    {{ $riwayat->type === 'setor' ? 'Masuk' : 'Keluar' }}
                                </span>
                            </div>
                        </button>
                    </div>
                @endforeach
                <div class="py-4">
                    {{ $this->dataRiwayat()->links('pagination::simple-tailwind') }}
                </div>
            </div>
        </div>

    </div>
</div>
