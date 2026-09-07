<div class="space-y-6 pb-8 ">
    <h1 class="text-2xl font-bold text-slate-800">Laporan Transaksi</h1>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-5 sm:p-6 space-y-4">
        <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
            <flux:icon name="calendar"></flux:icon>
            Pilih Tanggal
        </h3>
        <div class="grid grid-cols-2 gap-2 max-w-sm">
            @php
                $blnLabel = [
                    1 => 'Januari',
                    2 => 'Februari',
                    3 => 'Maret',
                    4 => 'April',
                    5 => 'Mei',
                    6 => 'Juni',
                    7 => 'Juli',
                    8 => 'Agustus',
                    9 => 'September',
                    10 => 'Oktober',
                    11 => 'November',
                    12 => 'Desember',
                ];
            @endphp

            <flux:select label="Bulan" wire:model.live.debounce.250ms="bulan">
                @foreach ($pilihanBulan as $bln)
                    <flux:select.option class="text-xs" value="{{ $bln }}">{{ $blnLabel[$bln] }}
                    </flux:select.option>
                @endforeach
            </flux:select>
            <flux:select label="Tahun" wire:model.live.debounce.250ms="tahun">
                @foreach ($pilihanTahun as $thn)
                    <flux:select.option class="text-xs" value="{{ $thn }}">{{ $thn }}
                    </flux:select.option>
                @endforeach
            </flux:select>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div class="rounded-2xl border-2 border-indigo-300 bg-indigo-50 p-3 flex flex-col items-center">
            <span class="text-lg tracking-wider text-indigo-600 font-semibold">{{ $rekapTotalTransaksi }}</span>
            <span class="text-[10px] text-gray-500">Total Penarikan Bulan ini</span>
        </div>
        <div class="rounded-2xl border-2 border-indigo-300 bg-indigo-50 p-3 flex flex-col items-center">
            <span class="text-lg tracking-wider text-indigo-600 font-semibold">{{ $rekapJumlahTransaksi }}</span>
            <span class="text-[10px] text-gray-500">Jumlah Transaksi Bulan Ini</span>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-5 sm:p-6 space-y-4 mb-20">
        <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Riwayat Traksaksi
        </h3>

        <div class="overflow-x-auto">
            <div class="divide-y divide-slate-100">
                @forelse($summaries as $index=>$sum)
                    <div
                        class="py-3 flex items-center justify-between hover:bg-slate-50/80 px-2 rounded-xl transition-colors">
                        <div class="flex items-center space-x-3">
                            <!-- PERBAIKAN DI SINI -->
                            <div
                                class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 bg-emerald-100 text-emerald-600">
                                {{ $index + 1 }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800 uppercase text-wrap">
                                    {{ $sum['tanggal_label'] }}
                                </p>
                                <p class="text-xs text-slate-400">{{ $sum['jumlah_transaksi'] }} •
                                    <span class="capitalize font-medium">Transaksi</span>
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-nowrap font-bold text-emerald-600">
                                {{ $sum['total_transaksi_label'] }}
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
