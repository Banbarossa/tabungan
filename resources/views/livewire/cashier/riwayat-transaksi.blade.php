<div class="space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-5 sm:p-6 space-y-4">
        <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
            <flux:icon name="calendar"/>
            Pilih Tanggal
        </h3>
        <div class="flex items-center justify-between gap-6">

            <flux:button wire:click="previousDate()" variant="filled" icon="chevron-left" class="flex-none"/>
            <flux:input type='date' wire:model.live.debounce.250ms="tanggal"/>
            <flux:button wire:click="nextDate()"  variant="filled" icon="chevron-right" class="flex-none"/>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div class="rounded-lg border border-indigo-300 bg-indigo-50 p-3 flex flex-col items-center">
            <span class="text-lg tracking-wider text-indigo-600 font-semibold">{{ $amount }}</span>
            <span class="text-[10px] text-gray-500">Total Penarikan</span>

        </div>
        <div class="rounded-lg border border-indigo-300 bg-indigo-50 p-3 flex flex-col items-center">
            <span class="text-lg tracking-wider text-indigo-600 font-semibold">{{ $jumlah_transaksi }}</span>
            <span class="text-[10px] text-gray-500">Jumlah Transaksi</span>

        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-5 sm:p-6 space-y-4">
        <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Riwayat Traksaksi
        </h3>

        <div class="overflow-x-auto">
            <div class="divide-y divide-slate-100">
                @forelse($histories as $his)
                    <div
                        class="py-3 flex items-center justify-between hover:bg-slate-50/80 px-2 rounded-xl transition-colors">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 {{ $his->type == 'setor' ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }}">
                                @if ($his->type == 'setor')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800 uppercase text-wrap">
                                    {{ $his->student?->name }}
                                </p>
                                <p class="text-xs text-slate-400">{{ $his->created_at->format('d M Y H:i') }} •
                                    <span class="capitalize font-medium">{{ $his->type }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p
                                class="text-sm text-nowrap font-bold {{ $his->type == 'setor' ? 'text-emerald-600' : 'text-amber-600' }}">
                                {{ $his->type == 'setor' ? '+' : '-' }}Rp
                                {{ number_format($his->amount, 0, ',', '.') }}
                            </p>
                            <p class="text-[10px] text-slate-400">Inv: #{{ $his->invoice_number ?? $his->id }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center">
                        <p class="text-xs text-slate-400">
                            Belum ada riwayat transaksi
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
