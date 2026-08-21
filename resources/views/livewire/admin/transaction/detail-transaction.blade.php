<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between border-b border-gray-200 pb-4">
        <div>
            <h1 class="text-xl font-bold text-gray-900">Detail & Verifikasi Topup</h1>
            <p class="text-xs text-gray-500">Nomor Invoice: <span
                    class="font-mono font-semibold text-gray-700">{{ data_get($data_transaksi, 'no_invoice', '') }}</span>
            </p>
        </div>
        <div>
            @switch($data_transaksi['no_invoice'])
                @case('setor')
                    <span
                        class="inline-flex gap-2 items-center px-3 py-1 rounded-full text-sm shadow font-semibold bg-emerald-100 text-emerald-800">
                        <flux:icon.cloud-arrow-up class="w-4 h-4 text-emerald-700" />
                        <span>Setoran</span>
                    </span>
                @break

                @default
                    <span
                        class="inline-flex gap-2 items-center px-3 py-1 rounded-full text-sm shadow font-semibold bg-rose-100 text-rose-800">
                        <flux:icon.shopping-cart class="w-4 h-4 text-rose-800" />
                        <span>Penarikan</span>
                    </span>
            @endswitch
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-7 space-y-7">
            <div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
                <div class="flex items-center gap-4 mb-2">
                    <div class="p-3 bg-zinc-200 rounded-lg text-zinc-700">
                        <flux:icon.user class="size-6" />
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold">{{ $data_siswa['nama'] }}</h2>
                        <p class="text-xs text-gray-500">Siswa Terdaftar</p>
                    </div>
                </div>

                <flux:separator class="my-2" />

                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-zinc-500 block text-xs font-medium uppercase tracking-wider">NISN</span>
                        <span class="font-semibold text-zinc-800">{{ $data_siswa['nisn'] ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-zinc-500 block text-xs font-medium uppercase tracking-wider">Kelas</span>
                        <span class="font-semibold text-zinc-800">{{ $data_siswa['kelas'] ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Card 2: Detail Transaksi -->
            <div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <flux:description class="text-xs uppercase tracking-wider">No. Invoice</flux:description>
                        <h2 class="text-xl font-semibold" class="font-mono text-gray-600">
                            #{{ $data_transaksi['no_invoice'] }}
                        </h2>
                    </div>
                    <div>
                        <flux:button wire:click="unduhPdf" icon="document-arrow-down">Unduh Faktur</flux:button>
                    </div>
                </div>

                <!-- Highlight Nominal -->
                <div
                    class="{{ $data_transaksi['type'] === 'setor' ? 'bg-green-100/80' : 'bg-red-100/70' }} border border-zinc-100 rounded-xl p-4 mb-6">
                    <span
                        class="text-xs text-zinc-500 font-medium block mb-1">{{ $data_transaksi['type'] === 'setor' ? 'Jumlah Setoran' : 'Jumlah Penarikan' }}</span>
                    <span
                        class="text-2xl font-bold {{ $data_transaksi['type'] === 'setor' ? 'text-green-700' : 'text-red-700' }}  font-mono">
                        {{ $data_transaksi['jumlah'] }}
                    </span>
                </div>

                <!-- List Rincian Transaksi -->
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between items-center py-2 border-b border-zinc-100">
                        <span class="text-zinc-500 text-xs">Tanggal Transaksi</span>
                        <span class="font-medium text-zinc-800">{{ $data_transaksi['tanggal'] }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-zinc-100">
                        <span class="text-zinc-500 text-xs">Metode Pembayaran</span>
                        <flux:badge variant="subtle" size="sm">{{ $data_transaksi['metode'] ?? 'N/A' }}
                        </flux:badge>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-zinc-100">
                        <span class="text-zinc-500 text-xs">Petugas Pencatat</span>
                        <span class="font-medium text-zinc-800">{{ $data_transaksi['petugas'] ?? '-' }}</span>
                    </div>
                    <div class="pt-2">
                        <span class="text-zinc-500 block mb-1 text-xs">Keterangan / Catatan</span>
                        <p class="text-zinc-700 bg-zinc-50 p-3 rounded-lg text-xs leading-relaxed italic">
                            {{ $data_transaksi['description'] ?: 'Tidak ada catatan tambahan.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:col-span-5 space-y-4">
            <div class="rounded-xl border bg-white border-zinc-200 shadow-sm overflow-hidden" x-data="{ riwayat: true }">
                <button class="p-4 flex gap-4 items-center w-full hover:bg-zinc-50 transition"
                    x-on:click="riwayat = !riwayat">
                    <flux:heading size="lg">Perubahan Data</flux:heading>
                    <flux:spacer />
                    <flux:icon.arrow-right class="size-4 text-zinc-500 transition-transform duration-200"
                        x-bind:class="{ 'rotate-90': riwayat }"></flux:icon.arrow-right>
                </button>
                <div x-cloak x-show="riwayat" x-transition>
                    <flux:separator />
                    <div class="p-6">
                        <livewire:admin.transaction.edit-transaksi :transaction="$transaction" />
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
