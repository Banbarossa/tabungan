<div class="max-w-6xl mx-auto space-y-6">
    {{-- Header Section --}}
    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between border-b border-gray-200 pb-4">
        <div>
            <h1 class="text-xl font-bold text-gray-900">Detail & Verifikasi Topup</h1>
            <p class="text-xs text-gray-500">Nomor Referensi: <span
                    class="font-mono font-semibold text-gray-700">{{ $topupRequest->reference_number }}</span></p>
        </div>
        <div>
            @switch($topupRequest->status)
                @case('approved')
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                        ✓ Terverifikasi / Disetujui
                    </span>
                @break

                @case('rejected')
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-800">
                        ✕ Ditolak
                    </span>
                @break

                @default
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                        ⏳ Menunggu Verifikasi
                    </span>
            @endswitch
        </div>
    </div>

    {{-- Alert Notification --}}
    @if (session()->has('message'))
        <div class="p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        {{-- Kolom Kiri: Bukti Resi (Media) --}}
        <div class="lg:col-span-5 space-y-4">
            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Bukti Pembayaran / Resi</h3>
                @if ($topupRequest->image_resi)
                    <div class="relative group rounded-lg overflow-hidden border border-gray-200 bg-gray-50">
                        <img src="{{ asset($topupRequest->image_resi) }}" alt="Bukti Resi"
                            class="w-full h-auto max-h-[450px] object-contain mx-auto">
                        <div class="p-3 bg-gray-50 border-t border-gray-100 text-center">
                            <a href="{{ asset($topupRequest->image_resi) }}" target="_blank"
                                class="text-xs font-medium text-indigo-600 hover:text-indigo-800 inline-flex items-center gap-1">
                                <flux:icon.magnifying-glass class="w-3.5 h-3.5" /> Lihat Ukuran Penuh
                            </a>
                        </div>
                    </div>
                @else
                    <div
                        class="h-48 rounded-lg bg-gray-50 border-2 border-dashed border-gray-200 flex flex-col items-center justify-center text-gray-400 text-xs">
                        <flux:icon.information-circle class="w-8 h-8 mb-1 text-gray-300" />
                        Tidak ada berkas resi terlampir
                    </div>
                @endif
            </div>

            {{-- Info Siswa --}}
            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm space-y-2">
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Informasi Siswa</h3>
                <div class="text-sm">
                    <p class="font-bold text-gray-900">{{ $student_name }}</p>
                    <p class="text-xs text-gray-500">NISN: {{ $student_nisn ?? '-' }}</p>
                </div>
                @if ($topupRequest->keterangan)
                    <div class="pt-2 border-t border-gray-100 text-xs text-gray-600">
                        <span class="font-medium text-gray-700">Catatan Pengirim:</span>
                        <p class="italic text-gray-500 mt-0.5">"{{ $topupRequest->keterangan }}"</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Kolom Kanan: Form Koreksi Data & Verifikasi --}}
        <div class="lg:col-span-7 space-y-6">
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-5">
                <div>
                    <h3 class="text-base font-semibold text-gray-900">Koreksi & Konfirmasi Data</h3>
                    <p class="text-xs text-gray-500">Sesuaikan jumlah nominal dan tanggal jika terdapat kesalahan input
                        oleh user sebelum diverifikasi.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Input Nominal (Editable) --}}
                    <div>
                        <flux:input wire:model="jumlah" label="Nominal Topup (Rp)" prefix="Rp"
                            :disabled="$topupRequest->status !== 'pending'" mask:dynamic="$money($input)" />
                    </div>

                    {{-- Input Tanggal (Editable) --}}
                    <div>
                        <flux:input wire:model="tanggal" label="Tanggal Transaksi" type="datetime-local"
                            :disabled="$topupRequest->status !== 'pending'" />
                    </div>
                </div>
                <div>
                    <flux:select name="jenis_transaksi_id" wire:model="jenis_transaksi_id" label="Metode">
                        @foreach ($methods as $method)
                            <flux:select.option value="{{ $method->id }}">{{ $method->nama }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>

                {{-- Catatan Admin / Verifikator --}}
                <div>
                    <flux:textarea wire:model="catatan_admin" label="Catatan Verifikator"
                        placeholder="Tambahkan catatan jika menyetujui/menolak..." rows="3"
                        :disabled="$topupRequest->status !== 'pending'" />
                </div>

                {{-- Action Buttons --}}
                @if ($topupRequest->status === 'pending')
                    <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-end gap-3">
                        <flux:button wire:click="reject" variant="danger" class="w-full sm:w-auto"
                            wire:loading.attr="disabled">
                            Tolak Transaksi
                        </flux:button>

                        <flux:button wire:click="approve" variant="primary" class="w-full sm:w-auto"
                            wire:loading.attr="disabled">
                            Setujui & Verifikasi
                        </flux:button>
                    </div>
                @endif
            </div>

            {{-- Audit Trail (Info Verifikator jika sudah diproses) --}}
            @if ($topupRequest->status !== 'pending')
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 space-y-2">
                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Audit Verifikasi</h4>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <div>
                            <span class="text-gray-400 block">Diproses Oleh:</span>
                            <span class="font-medium text-gray-800">{{ $topupRequest->user?->name ?? 'Sistem' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block">Waktu Verifikasi:</span>
                            <span
                                class="font-medium text-gray-800">{{ $topupRequest->verification_at ? \Carbon\Carbon::parse($topupRequest->verification_at)->locale('id')->translatedFormat('d F Y H:i:s') : '-' }}</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
