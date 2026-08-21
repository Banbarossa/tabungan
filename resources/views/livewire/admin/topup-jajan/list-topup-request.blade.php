<div>
    <div class="bg-white rounded-lg border-2 ">
        <div class="py-8 px-4">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="w-full sm:max-w-xs lg:max-w-md">
                    <flux:input icon="magnifying-glass" wire:model.live.debounce.250ms="search"
                        placeholder="Search orders..." clearable />
                </div>
                <div>
                    <form action="" wire:submit.prevent='changeStatus'>
                        <div class="flex gap-2">
                            @php
                                $stats = [
                                    ['label' => 'Pending', 'value' => 'pending'],
                                    ['label' => 'Approved', 'value' => 'approved'],
                                    ['label' => 'Rejected', 'value' => 'rejected'],
                                ];
                            @endphp
                            <flux:select wire:model='status' name='status' placeholder='Pilih Status'>
                                @foreach ($stats as $stat)
                                    <flux:select.option value="{{ $stat['value'] }}">{{ $stat['label'] }}
                                    </flux:select.option>
                                @endforeach
                            </flux:select>
                            <flux:button type="submit">Filter</flux:button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <x-table.container class="border-none">
            <x-table.columns>
                <x-table.column>Siswa</x-table.column>
                <x-table.column>Jumlah Topup</x-table.column>
                <x-table.column>Bukti Resi</x-table.column>
                <x-table.column>Status & Waktu</x-table.column>
                <x-table.column class="text-right">Aksi</x-table.column>
            </x-table.columns>

            <x-table.rows>
                @forelse($this->dataRiwayat as $riwayat)
                    <x-table.row variant="hovered" class="align-middle">
                        {{-- Detail Siswa --}}
                        <x-table.cell>
                            <div class="font-semibold text-gray-900 uppercase">{{ $riwayat['student_name'] }}</div>
                            <div class="text-xs text-gray-500">NISN: {{ $riwayat['student_nisn'] ?? '-' }}</div>
                            <div class="text-[10px] text-gray-400 font-mono mt-0.5">Ref: {{ $riwayat['ref_number'] }}
                            </div>
                        </x-table.cell>

                        {{-- Jumlah / Nominal --}}
                        <x-table.cell>
                            <div class="font-medium text-emerald-600">
                                Rp {{ number_format($riwayat['jumlah'], 0, ',', '.') }}
                            </div>
                            <div class="text-xs text-gray-400">{{ $riwayat['tanggal'] }}</div>
                        </x-table.cell>

                        {{-- Preview Resi --}}
                        <x-table.cell>
                            @if ($riwayat['resi'])
                                <a href="{{ asset($riwayat['resi']) }}" target="_blank" class="inline-block group">
                                    <img src="{{ asset($riwayat['resi']) }}" alt="Resi"
                                        class="w-10 h-10 rounded-lg object-cover border border-gray-200 group-hover:opacity-80 transition">
                                </a>
                            @else
                                <span class="text-xs text-gray-400 italic">Tidak ada resi</span>
                            @endif
                        </x-table.cell>

                        {{-- Status Badge & Info Verifikasi --}}
                        <x-table.cell>
                            <div class="mb-1">
                                @switch($riwayat['status'])
                                    @case('approved')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                            Disetujui
                                        </span>
                                    @break

                                    @case('rejected')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800">
                                            Ditolak
                                        </span>
                                    @break

                                    @default
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                            Menunggu
                                        </span>
                                @endswitch
                            </div>
                            <div class="text-[11px] text-gray-500">
                                {{ $riwayat['waktu_verifikasi'] }}
                            </div>
                            @if ($riwayat['verifikator'])
                                <div class="text-[10px] text-gray-400">Oleh: {{ $riwayat['verifikator'] }}</div>
                            @endif
                        </x-table.cell>

                        {{-- Tombol Aksi Verifikasi --}}
                        <x-table.cell class="text-right">

                            <flux:button href="{{ route('verification-topup-jajan', $riwayat['encript_id']) }}" size="sm"
                                variant="subtle">
                                Detail / Verifikasi
                            </flux:button>
                        </x-table.cell>
                    </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="5" class="text-center py-8">
                                <div class="flex flex-col items-center justify-center gap-2 text-gray-500">
                                    <flux:icon.information-circle class="w-8 h-8 text-gray-400" />
                                    <span class="text-sm">Tidak ada data permintaan topup yang ditemukan</span>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-table.rows>
            </x-table.container>

            {{-- Pagination Footer --}}
            @if ($this->dataRiwayat->hasPages())
                <div class="p-4 border-t border-gray-100">
                    {{ $this->dataRiwayat->links() }}
                </div>
            @endif
        </div>
    </div>
