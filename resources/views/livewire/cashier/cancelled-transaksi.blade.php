<div class="space-y-6">
    <h1 class="text-2xl font-bold text-slate-800">Batal Transaksi</h1>
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

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-5 sm:p-6 space-y-4">
        <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Pembatalan Transaksi
        </h3>
        <div class="overflow-x-auto">
            <div class="divide-y divide-slate-100">
                @forelse($datas as $data)
                    <div
                        class="py-3 flex items-center justify-between hover:bg-slate-50/80 px-2 rounded-xl transition-colors">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 bg-amber-100 text-amber-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">
                                    {{ $data->student_name }}
                                </p>
                                <p class="text-xs text-slate-400">{{ $data->student_nisn }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-amber-600">
                                {{ $data->waktu_scan }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center">
                        <p class="text-xs text-slate-400">
                            Tidak ada data Pembatalan Transaksi
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
