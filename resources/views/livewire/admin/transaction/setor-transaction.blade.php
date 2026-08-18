<section>


    <div class="grid lg:grid-cols-3 gap-4">
        <div class="lg:order-2">
            <livewire:admin.transaction.notification-card :student="$student" />

        </div>
        <div
            class="lg:col-span-2  dark:bg-zinc-800 rounded-lg bg-white p-4 border-2 border-zinc-300 dark:border-zinc-600 flex flex-col">
            <div class="flex flex-col justify-between items-center h-full gap-4">
                <div class="p-3 bg-teal-50 dark:bg-zinc-800 flex items-center justify-center rounded-xl shadow-sm">
                    <flux:icon.calculator class="size-20 text-teal-700" />
                </div>

                <div class="text-center my-auto">
                    <flux:text class="text-xs uppercase tracking-wider font-medium text-gray-500 dark:text-gray-400">
                        Saldo Saat Ini
                    </flux:text>
                    <h1 class="text-3xl md:text-5xl font-bold font-mono text-gray-900 dark:text-gray-100 mt-1">
                        {{ format_rupiah($student->saldo) }}
                    </h1>
                </div>

                <div class=" w-full flex items-center justify-center gap-2">
                    <flux:modal.trigger name="setor">
                        <flux:button icon="plus" variant="primary" class="flex-1">Setor</flux:button>
                    </flux:modal.trigger>
                    <flux:modal.trigger name="tarik">
                        <flux:button icon="minus" variant="danger" class="flex-1">Tarik</flux:button>
                    </flux:modal.trigger>
                </div>
            </div>
        </div>
    </div>

    <div class="rounded-lg border-2 mb-4 bg-white border-zinc-300 mt-5 overflow-hidden" x-data="{ riwayat: true }">
        <button class="p-4 flex gap-4 flex-wrap  w-full item->center" x-on:click="riwayat = !riwayat">
            <flux:heading size="lg">
                RIWAYAT TRANSAKSI
            </flux:heading>
            <flux:spacer />
            <flux:icon.arrow-right class="size-4" x-bind:class="{ 'rotate-90': riwayat }"></flux:icon.arrow-right>
        </button>
        <div x-cloak x-show="riwayat" x-transition>
            <flux:separator />
            <div>
                <div class="p-4">

                    {{-- <div class="border rounded-lg border-neutral-500/20 p-3 mb-3 bg-neutral-700/5">
                        <flux:fieldset>
                            <flux:legend>Pilih Bulan</flux:legend>
                            <flux:description>Silahkan bulan untuk filter</flux:description>
                            <div class="flex gap-4 *:gap-x-2">
                                @foreach ($monthNames as $m => $label)
                                    <flux:checkbox wire:model.live="filterMonths" value="{{ $m }}"
                                        label="{{ $label }}" />
                                @endforeach
                            </div>
                        </flux:fieldset>

                        <div class="flex gap-2 mt-3 flex-wrap">
                            <div class="flex items-center gap-4">
                                <flux:label for="filterYear">Tahun</flux:label>
                                <flux:select wire:model.live="filterYear" name="filterYear" size="sm">
                                    @foreach ($this->availableYears() as $y)
                                        <flux:select.option value="{{ $y }}" label="{{ $y }}" />
                                    @endforeach
                                </flux:select>
                            </div>
                            <div class="flex-1"></div>
                            <flux:button type="button" wire:click="resetRiwayatFilter" variant="ghost">Reset</flux:button>
                            <flux:button type="button" wire:click="downloadExcel" variant="primary" color="green"
                                wire:loading.attr="disabled">
                                Unduh Excel
                            </flux:button>
                            <flux:button type="button" wire:click="downloadPdf" variant="primary"
                                wire:loading.attr="disabled">
                                Unduh PDF
                            </flux:button>
                        </div>

                        @php($overall = $this->overallTotals())
                        <div class="grid md:grid-cols-3 gap-2 mt-3">
                            <div
                                class="rounded-md border border-zinc-300 dark:border-zinc-700 bg-white/60 dark:bg-zinc-900/30 p-3">
                                <div class="text-[11px] uppercase tracking-wide text-zinc-600 dark:text-zinc-300">
                                    Total Setoran (Semua Data)
                                </div>
                                <div class="font-mono font-semibold text-zinc-900 dark:text-zinc-50">
                                    {{ $overall['formatted']['setor'] ?? format_rupiah(0) }}
                                </div>
                            </div>
                            <div
                                class="rounded-md border border-zinc-300 dark:border-zinc-700 bg-white/60 dark:bg-zinc-900/30 p-3">
                                <div class="text-[11px] uppercase tracking-wide text-zinc-600 dark:text-zinc-300">
                                    Total Penarikan (Semua Data)
                                </div>
                                <div class="font-mono font-semibold text-zinc-900 dark:text-zinc-50">
                                    {{ $overall['formatted']['tarik'] ?? format_rupiah(0) }}
                                </div>
                            </div>
                            <div
                                class="rounded-md border border-zinc-300 dark:border-zinc-700 bg-white/60 dark:bg-zinc-900/30 p-3">
                                <div class="text-[11px] uppercase tracking-wide text-zinc-600 dark:text-zinc-300">
                                    Selisih (Setoran - Penarikan)
                                </div>
                                <div class="font-mono font-semibold text-zinc-900 dark:text-zinc-50">
                                    {{ $overall['formatted']['selisih'] ?? format_rupiah(0) }}
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div
                        class="p-4 md:p-5 mb-4 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50 backdrop-blur-sm space-y-5">

                        <!-- Filter Section -->
                        <flux:fieldset class="space-y-2">
                            <div>
                                <flux:legend class="text-base font-medium">Pilih Bulan</flux:legend>
                                <flux:description class="text-xs">Pilih satu atau beberapa bulan untuk memfilter data
                                </flux:description>
                            </div>

                            <!-- Grid/Flex Checkboxes (Responsive) -->
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2 pt-1">
                                @foreach ($monthNames as $m => $label)
                                    <label
                                        class="flex items-center gap-2 p-2 rounded-lg border border-zinc-200/60 dark:border-zinc-800/60 bg-white dark:bg-zinc-900 hover:bg-zinc-100 dark:hover:bg-zinc-800/50 transition-colors cursor-pointer text-sm">
                                        <flux:checkbox wire:model.live="filterMonths" value="{{ $m }}" />
                                        <span class="text-zinc-700 dark:text-zinc-300">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </flux:fieldset>

                        <hr class="border-zinc-200/80 dark:border-zinc-800/80 my-2" />

                        <!-- Action Bar & Year Filter -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <!-- Year Select -->
                            <div class="flex items-center gap-3">
                                <flux:label for="filterYear" class="whitespace-nowrap font-medium">Tahun</flux:label>
                                <flux:select wire:model.live="filterYear" name="filterYear" class="w-48">
                                    @foreach ($this->availableYears() as $y)
                                        <flux:select.option value="{{ $y }}" label="{{ $y }}" />
                                    @endforeach
                                </flux:select>
                            </div>

                            <!-- Action Buttons (Responsive Group) -->
                            <div class="flex flex-wrap items-center gap-2 sm:justify-end">
                                <flux:button type="button" wire:click="resetRiwayatFilter" variant="ghost">
                                    Reset
                                </flux:button>

                                <div class="h-4 w-px bg-zinc-200 dark:bg-zinc-700 hidden sm:block"></div>

                                <flux:button type="button" wire:click="downloadExcel" wire:loading.attr="disabled"
                                    icon="document-arrow-down">
                                    Unduh Excel
                                </flux:button>

                                <flux:button type="button" wire:click="downloadPdf" variant="primary"
                                    wire:loading.attr="disabled" icon="arrow-down-tray">
                                    Unduh PDF
                                </flux:button>
                            </div>
                        </div>

                        <!-- Summary Cards -->
                        @php($overall = $this->overallTotals())
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 pt-2">
                            <!-- Setoran -->
                            <div
                                class="p-4 rounded-lg border border-emerald-500/20 bg-emerald-50/50 dark:bg-emerald-950/10">
                                <div
                                    class="text-[11px] font-medium uppercase tracking-wider text-emerald-700 dark:text-emerald-400">
                                    Total Setoran (Semua Data)
                                </div>
                                <div class="mt-1 text-lg font-bold font-mono text-emerald-900 dark:text-emerald-300">
                                    {{ $overall['formatted']['setor'] ?? format_rupiah(0) }}
                                </div>
                            </div>

                            <!-- Penarikan -->
                            <div class="p-4 rounded-lg border border-rose-500/20 bg-rose-50/50 dark:bg-rose-950/10">
                                <div
                                    class="text-[11px] font-medium uppercase tracking-wider text-rose-700 dark:text-rose-400">
                                    Total Penarikan (Semua Data)
                                </div>
                                <div class="mt-1 text-lg font-bold font-mono text-rose-900 dark:text-rose-300">
                                    {{ $overall['formatted']['tarik'] ?? format_rupiah(0) }}
                                </div>
                            </div>

                            <!-- Selisih -->
                            <div
                                class="p-4 rounded-lg border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 sm:col-span-2 lg:col-span-1">
                                <div
                                    class="text-[11px] font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                    Selisih (Setoran - Penarikan)
                                </div>
                                <div class="mt-1 text-lg font-bold font-mono text-zinc-900 dark:text-zinc-100">
                                    {{ $overall['formatted']['selisih'] ?? format_rupiah(0) }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <x-table.container class="border-none">
                    <x-table.columns>
                        <x-table.column class="w-10">
                            No
                        </x-table.column>
                        @foreach ($headings as $head)
                            <x-table.column>{{ $head }}</x-table.column>
                        @endforeach
                        <x-table.column class="w-24">Aksi</x-table.column>

                    </x-table.columns>
                    <x-table.rows>
                        @forelse($this->histories() as $index=>$t)
                            <x-table.row variant="stripped">
                                <x-table.cell>
                                    {{ $index + 1 }}
                                </x-table.cell>
                                <x-table.cell class="truncate text-wrap">
                                    <div class="whitespace-nowrap font-semibold ">{{ $t['Tanggal'] }}</div>
                                    <div>
                                        <span
                                            class="py-1 px-4 whitespace-nowrap truncate rounded-full text-[10px] text-orange-800 bg-orange-50 border border-orange-100">{{ $t['Metode'] }}</span>
                                    </div>
                                </x-table.cell>
                                <x-table.cell class="truncate text-wrap">
                                    <div class="text-sm">{{ $t['Cashier'] }}</div>
                                </x-table.cell>
                                <x-table.cell class="whitespace-nowrap">
                                    <div class="text-sm font-bold text-green-700">
                                        {{ $t['Setoran'] ? '+ ' . $t['Setoran'] : '' }}</div>
                                </x-table.cell>
                                <x-table.cell class="whitespace-nowrap">
                                    <div class="text-sm font-bold text-orange-600">
                                        {{ $t['Penarikan'] ? '- ' . $t['Penarikan'] : '' }}</div>
                                </x-table.cell>
                                <x-table.cell class="whitespace-nowrap">
                                    <div class="text-sm font-bold ">{{ $t['Saldo'] }}</div>
                                </x-table.cell>
                                <x-table.cell class="truncate text-wrap max-w-[200px]">
                                    <div class="text-xs text-wrap line-clamp-2">{{ $t['Keterangan'] }}</div>
                                </x-table.cell>

                                {{-- @endforeach --}}
                                <x-table.cell>
                                    <flux:button.group>
                                        <flux:button size="sm" icon="eye"
                                            href="{{ route('transaction.detail', ['code' => $code, 'transaction' => $t['id']]) }}">
                                        </flux:button>
                                        {{--                                        <flux:button size="sm" icon="trash" variant="danger" wire:click="confirmDelete({{$t['id']}})"></flux:button> --}}
                                    </flux:button.group>
                                </x-table.cell>
                            </x-table.row>
                        @empty
                            <x-table.row>
                                <x-table.cell colspan="{{ count($headings) + 2 }}">
                                    <div class="flex items-center gap-2">
                                        <flux:icon.information-circle></flux:icon.information-circle>
                                        <span>
                                            Tidak ada data yang ditemukan
                                        </span>
                                    </div>
                                </x-table.cell>
                            </x-table.row>
                        @endforelse
                    </x-table.rows>
                </x-table.container>
            </div>
        </div>
    </div>


    <flux:modal name="setor" class="md:w-96" variant="flyout">
        <div class="space-y-6">
            <div>
                <flux:heading size="xl">Update Saldo</flux:heading>
                <flux:text class="truncate">Penambahan Saldo Tabungan Santri</flux:text>
            </div>
            <img src="{{ asset('images/team.png') }}" alt="withdraw" class="h-36">
            <div class="bg-zinc-100 dark:bg-zinc-700 rounded-lg p-4 border border-zinc-300 relative">
                <div class="flex gap-3 items-center">
                    <div class="w-12 h-12 bg-green-300/80 flex items-center justify-center rounded-lg">
                        <flux:icon.briefcase></flux:icon.briefcase>
                    </div>
                    <div>
                        <flux:text class="uppercase truncate">{{ $student->name }}</flux:text>
                        <flux:heading size="xl" class="uppercase">{{ format_rupiah($student->saldo) }}
                        </flux:heading>
                    </div>
                </div>
            </div>
            <form action="" wire:submit='setor'>
                <flux:input type="date" label="Tanggal" name="tanggal" wire:model="tanggal" class="mb-4">
                </flux:input>
                <div class="mb-4">
                    <flux:input.group>
                        <flux:input.group.prefix>Rp</flux:input.group.prefix>
                        <flux:input x-mask:dynamic="$money($input, ',', '.')" wire:model="amount_setor" />
                    </flux:input.group>
                    <flux:error name="amount_setor" />

                </div>
                <div class="mb-4">
                    <flux:select name="jenis_transaksi_id" wire:model="jenis_transaksi_id" label="Metode">
                        @foreach ($methods as $method)
                            <flux:select.option value="{{ $method->id }}">{{ $method->nama }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>

                <flux:textarea name="description" label="Keterangan" wire:model="description" rows="3" />

                <div class="flex items-center justify-end mt-4">
                    <flux:button type="submit" variant="primary" class="w-full">
                        Tambah Saldo
                    </flux:button>
                </div>
            </form>


        </div>
    </flux:modal>
    <flux:modal name="tarik" class="md:w-96" variant="flyout">
        <div class="space-y-6">
            <div>
                <flux:heading size="xl">Penarikan</flux:heading>
                <flux:text>Penarikan Tabungan</flux:text>
            </div>
            <img src="{{ asset('images/withdraw.png') }}" alt="withdraw" class="h-36">
            <div class="bg-zinc-100 dark:bg-zinc-700 rounded-lg p-4 border border-zinc-300 relative">
                <div class="flex gap-3 items-center">
                    <div class="w-12 h-12 bg-red-300/80 flex items-center justify-center rounded-lg">
                        <flux:icon.ticket></flux:icon.ticket>
                    </div>
                    <div>
                        <flux:text class="uppercase truncate">{{ $student->name }}</flux:text>
                        <flux:heading size="xl" class="uppercase">{{ format_rupiah($student->saldo) }}
                        </flux:heading>
                    </div>
                </div>
            </div>
            <form action="" wire:submit='tarik'>
                <flux:input type="date" label="Tanggal" name="tanggal" wire:model="tanggal" class="mb-4">
                </flux:input>
                <div class="mb-4">
                    <flux:select name="jenis_transaksi_id" wire:model="jenis_transaksi_id" label="Metode">
                        @foreach ($methods as $method)
                            <flux:select.option value="{{ $method->id }}">{{ $method->nama }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
                <div class="mb-4">

                    <flux:input.group>
                        <flux:input.group.prefix>Rp</flux:input.group.prefix>
                        <flux:input x-mask:dynamic="$money($input, ',', '.')" wire:model="amount_tarik" />
                    </flux:input.group>
                    <flux:error name="amount_tarik" />
                </div>
                <flux:textarea name="description" label="Keterangan" wire:model="description" rows="3" />

                <div class="flex items-center justify-end mt-4">
                    <flux:button type="submit" variant="primary" class="w-full">
                        Tarik
                    </flux:button>
                </div>
            </form>


        </div>
    </flux:modal>

</section>
