<div class="px-4 lg:px-0 space-y-4">
    <div class=" pt-4 space-y-4">
        <div class="bg-white rounded-2xl p-4 shadow flex items-center justify-between">
            <div>
                <p class="font-display font-bold text-gray-800 text-sm">Langkah Pengiriman Saldo</p>
                <p class="text-xs text-gray-400 mt-0.5">Akan di proses oleh admin</p>
            </div>
            <div>
                <!-- Trigger Button -->
                <flux:modal.trigger name="modal-topup">
                    <button type="button"
                        class="wallet-gradient active:scale-95 transition-all duration-150 text-white text-sm font-semibold px-4 py-2.5 rounded-xl flex items-center justify-center gap-2 shadow-sm hover:opacity-95 w-full sm:w-auto">
                        <flux:icon name="plus" class="size-4 stroke-[2.5]" />
                        <span>Top Up</span>
                    </button>
                </flux:modal.trigger>

                <!-- Modal Form -->
                <flux:modal name="modal-topup" class="w-full max-w-md p-4 sm:p-6">
                    <form wire:submit.prevent="uploadResi" class="space-y-5">

                        <!-- Header Modal -->
                        <div class="space-y-1 text-left">
                            <div class="flex items-center gap-2.5 text-primary-600 dark:text-primary-400 mb-1">
                                <div class="p-2 bg-primary-50 dark:bg-primary-950/50 rounded-lg">
                                    <flux:icon name="arrow-up-tray" class="size-5" />
                                </div>
                                <flux:heading size="xl" class="font-bold text-gray-900 dark:text-white">
                                    Upload Bukti Transfer
                                </flux:heading>
                            </div>
                            <flux:subheading
                                class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                                Unggah resi pembayaran Saldo Jajan Anda. Admin akan melakukan verifikasi secepatnya.
                            </flux:subheading>
                        </div>

                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">

                                <flux:input label="Jumlah Topup" wire:model="jumlah_topup" mask:dynamic="$money($input)"
                                    name="jumlah_topup" class="text-xs sm:text-sm" />

                                <flux:input label="Tanggal Topup" wire:model="tanggal_topup" name="tanggal_topup"
                                    type="date" class="text-xs sm:text-sm" />
                            </div>

                            <!-- Upload File Field -->
                            <div>
                                <flux:input label="Bukti Resi" wire:model="resi_upload" name="resi_upload"
                                    type="file" accept="image/jpeg,image/png,image/jpg" class="text-xs sm:text-sm" />
                                <p class="mt-1.5 text-[11px] text-gray-400 dark:text-gray-500 flex items-center gap-1">
                                    <flux:icon name="information-circle" class="size-3.5 shrink-0" />
                                    Format JPG, JPEG, PNG (Maksimal 2 MB)
                                </p>
                            </div>

                            <div>
                                <flux:textarea name="keterangan_resi" wire:model="keterangan_resi" rows="3"
                                    label="Catatan Tambahan (Opsional)"
                                    placeholder="Contoh: Transfer via BCA a.n. Fulan"
                                    class="text-xs sm:text-sm resize-none" />
                            </div>
                        </div>

                        <div class="pt-2 flex flex-col-reverse sm:flex-row items-center justify-end gap-2.5">
                            <flux:modal.close>
                                <flux:button type='button' variant="ghost"
                                    class="w-full sm:w-auto text-gray-500 hover:text-gray-700">
                                    Batal
                                </flux:button>
                            </flux:modal.close>

                            <flux:button type="submit" variant="primary" class="w-full sm:w-auto px-6">
                                Kirim Resi
                            </flux:button>
                        </div>

                    </form>
                </flux:modal>
            </div>
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
                    <img src="{{ data_get($bank, 'logo', '') }}"
                        class="w-8 h-8 rounded-lg flex items-center justify-center object-center object-cover" />
                    {{-- <span class="text-white font-bold text-[9px]">{{ data_get($bank,'bank','') }}</span> --}}
                    <div>
                        <p class="text-xs font-semibold text-gray-800">{{ data_get($bank, 'bank', '-') }} :
                            {{ data_get($bank, 'nama', '-') }}</p>
                        <p class="text-[11px] text-gray-500">{{ data_get($bank, 'rek', '-') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white dark:bg-gray-900 rounded-2xl p-4 sm:p-5 shadow-sm border border-gray-100 dark:border-gray-800">
        <!-- Header Komponen -->
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-bold text-gray-900 dark:text-white text-base">Riwayat Top Up</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Daftar pengajuan saldo jajan Anda</p>
            </div>
            <span
                class="text-xs font-semibold px-2.5 py-1 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300">
                {{ count($this->dataTopupRequests) }} Transaksi
            </span>
        </div>

        <!-- List Riwayat -->
        <div class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse ($this->dataTopupRequests as $resi)
                <div
                    class="py-3.5 first:pt-0 last:pb-0 flex items-center justify-between gap-3 transition-colors hover:bg-gray-50/50 dark:hover:bg-gray-800/30 rounded-xl px-1">

                    <!-- Icon Status & Info Utama -->
                    <div class="flex items-center gap-3 min-w-0">
                        <!-- Dynamic Icon Based on Status -->
                        <div
                            class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0
                        {{ $resi->status === 'approved' ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400' : '' }}
                        {{ $resi->status === 'pending' ? 'bg-amber-50 text-amber-600 dark:bg-amber-950/50 dark:text-amber-400' : '' }}
                        {{ $resi->status === 'rejected' ? 'bg-rose-50 text-rose-600 dark:bg-rose-950/50 dark:text-rose-400' : '' }}">

                            @if ($resi->status === 'approved')
                                <flux:icon name="check-circle" class="size-5" />
                            @elseif ($resi->status === 'pending')
                                <flux:icon name="clock" class="size-5" />
                            @else
                                <flux:icon name="x-circle" class="size-5" />
                            @endif
                        </div>

                        <div class="min-w-0">
                            <!-- Nominal Topup -->
                            <p class="text-sm font-bold text-gray-900 dark:text-white truncate">
                                {{ $resi->jumlah}}
                            </p>

                            <!-- Reference Code & Tanggal -->
                            <div class="flex items-center gap-2 mt-0.5 text-[11px] text-gray-500 dark:text-gray-400">
                                <span class="font-mono font-medium text-gray-600 dark:text-gray-300">
                                    {{ $resi->reference_number ?? 'TP-REQUEST' }}
                                </span>
                                <span>•</span>
                                <span>{{ $resi->tanggal }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Badge Status & Action Lihat Resi -->
                    <div class="flex flex-col items-end gap-1.5 shrink-0">
                        @if ($resi->status === 'approved')
                            <span
                                class="inline-flex items-center gap-1 text-[10px] font-semibold px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                                <span class="size-1.5 rounded-full bg-emerald-500"></span>
                                Berhasil
                            </span>
                        @elseif ($resi->status === 'pending')
                            <span
                                class="inline-flex items-center gap-1 text-[10px] font-semibold px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300">
                                <span class="size-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                Diproses
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-1 text-[10px] font-semibold px-2.5 py-0.5 rounded-full bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300">
                                <span class="size-1.5 rounded-full bg-rose-500"></span>
                                Ditolak
                            </span>
                        @endif

                        <!-- Tombol Cek Bukti Resi (Bisa dibuka di Tab Baru) -->
                        @if ($resi->file_path)
                            <a href="{{ Storage::url($resi->file_path) }}" target="_blank"
                                class="text-[11px] font-medium text-primary-600 hover:text-primary-700 dark:text-primary-400 hover:underline flex items-center gap-0.5">
                                Lihat Resi
                                <flux:icon name="arrow-top-right-on-square" class="size-3" />
                            </a>
                        @endif
                    </div>

                </div>
            @empty
                <!-- Empty State jika Belum Ada Riwayat -->
                <div class="text-center py-8">
                    <div
                        class="w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-400 mx-auto flex items-center justify-center mb-2">
                        <flux:icon name="document-text" class="size-6" />
                    </div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Belum Ada Riwayat Top Up</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Semua riwayat pengajuan Anda akan muncul
                        di sini.</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-2xl p-4 shadow">
        <h3 class="font-display font-bold text-gray-800 text-sm mb-3">Riwayat Saldo Jajan</h3>
        <p class="text-xs text-gray-500 dark:text-gray-400">Catatan penambahan saldo yang telah diverifikasi</p>
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
