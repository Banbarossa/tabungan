<div class="max-w-7xl mx-auto space-y-6">

    <!-- Alert status akun dibekukan -->
    @if ($is_freeze_account)
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm flex items-center space-x-3">
            <svg class="w-6 h-6 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <div>
                <h4 class="font-bold text-red-800">Akun Dibekukan</h4>
                <p class="text-sm text-red-700">Siswa ini sedang tidak diperbolehkan melakukan transaksi.</p>
            </div>
        </div>
    @endif

    <!-- Card Profil & Info Saldo -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
        <div class="p-5 sm:p-6 bg-gradient-to-r from-slate-900 to-slate-800 text-white">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">

                <!-- 1. Foto Siswa (Besar & Jelas untuk Verifikasi Identitas) -->
                <div class="relative flex-shrink-0">
                    <div
                        class="w-full max-w-sm rounded-xl ring-4 ring-white/20 overflow-hidden bg-slate-700 shadow-md">
                        @if ($student->avatar)
                        <flux:modal.trigger name="student-photo-modal">
                            <img src="{{ $student->avatar }}" alt="{{ $student->name }}"
                                class="w-full h-full object-cover cursor-pointer transition-transform duration-200 group-hover:scale-105"
                                flux:modal.show="student-photo-modal">
                        </flux:modal.trigger>
                            <!-- Overlay Petunjuk Zoom (Muncul saat hover) -->
                        @else
                            <div
                                class="w-full h-full flex flex-col items-center justify-center text-slate-400 bg-slate-800">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span class="text-xs mt-1">No Photo</span>
                            </div>
                        @endif
                    </div>
                    <span
                        class="absolute -bottom-2 -right-2 px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $is_freeze_account ? 'bg-red-500 text-white' : 'bg-emerald-500 text-white' }}">
                        {{ $is_freeze_account ? 'Non-Aktif' : 'Verifikasi Ok' }}
                    </span>
                </div>

                <!-- Detail Siswa & Saldo -->
                <div class="flex-1 text-center sm:text-left space-y-3 w-full">
                    <div>
                        <span class="text-xs font-medium tracking-wider text-slate-400 uppercase">NIS / ID:
                            {{ $student->nis ?? '-' }}</span>
                        <h2 class="text-2xl font-bold text-white leading-tight">{{ $student->name }}</h2>
                        <p class="text-sm text-slate-300">Kelas: {{ $student->classroom->name ?? '-' }}</p>
                    </div>

                    <!-- Grid Info Saldo & Limit -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2 border-t border-slate-700/60">
                        <div class="bg-slate-800/80 rounded-lg p-3 border border-slate-700/50">
                            <span class="text-xs text-slate-400 block">Sisa Saldo</span>
                            <span class="text-xl font-extrabold text-emerald-400">
                                Rp {{ number_format($student->saldo ?? 0, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="bg-slate-800/80 rounded-lg p-3 border border-slate-700/50">
                            <span class="text-xs text-slate-400 block">Sisa Limit Penarikan Hari Ini</span>
                            <span class="text-xl font-bold text-amber-400">
                                Rp {{ number_format($maximum_allowed_transaction, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- 2. Form Penarikan & Preset Nominal -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-5 sm:p-6 space-y-5">
        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            Form Transaksi Penarikan
        </h3>

        <!-- Pilihan Nominal Cepat -->
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Pilih Nominal Sering Ditarik</label>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                @foreach ($optionAmount as $item)
                    <button type="button" wire:click="requestWithdrawal('{{ $item['value'] }}')"
                        @disabled($is_freeze_account || $student->saldo <= 0)
                        class="px-4 py-3 border-2 rounded-xl font-semibold text-sm transition-all text-center flex flex-col items-center justify-center
                        {{ $withdrawal_request == $item['value']
                            ? 'border-indigo-600 bg-indigo-50/50 text-indigo-700 shadow-sm'
                            : 'border-slate-200 hover:border-indigo-300 text-slate-700 hover:bg-slate-50' }}
                        disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-white disabled:hover:border-slate-200">
                        <span>{{ $item['label'] }}</span>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Input Manual Nominal & Keterangan -->
        <form wire:submit.prevent="store" class="space-y-4">
            <div>
                <flux:label for="withdrawal_request">Input Nominal Manual (Rp)</flux:label>

                <flux:input.group>
                    <flux:input.group.prefix>Rp</flux:input.group.prefix>
                    <flux:input id="withdrawal_request" x-mask:dynamic="$money($input, ',', '.')"
                        wire:model.blur="withdrawal_request" :disabled="$is_freeze_account || $student->saldo <= 0"
                        placeholder="0" />
                </flux:input.group>

                <flux:error name="withdrawal_request" />
            </div>

            <div>
                {{-- <label for="description" class="block text-sm font-medium text-slate-700 mb-1">
                    Keterangan (Opsional)
                </label> --}}
                {{-- <flux:label for="description">Keterangan (Opsional)</flux:label> --}}
                <flux:textarea id="description" name="description" wire:model="description"
                    label="Keterangan (Opsional)" placeholder="Keterangan"
                    :disabled="$is_freeze_account || $student->saldo <= 0"></flux:textarea>
                {{-- <input type="text" id="description" wire:model="description"
                    placeholder="Contoh: Titip uang jajan / beli perlengkapan" @disabled($is_freeze_account || $student->saldo <= 0)
                    class="block w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm text-slate-800 disabled:bg-slate-100 disabled:cursor-not-allowed"> --}}
            </div>

            <!-- Tombol Eksekusi Penarikan (Terkunci Jika Saldo == 0 atau Dibekukan) -->
            <div class="pt-2">
                @if ($is_freeze_account)
                    <flux:button class="w-full" variant="filled" disabled>Transaksi Dikunci (Akun Dibekukan)
                    </flux:button>
                @elseif ($student->saldo <= 0)
                    <flux:button class="w-full" variant="filled" disabled>Transaksi Dikunci (Saldo Nol)</flux:button>
                @else
                    <flux:button type="submit" class="w-full" variant="primary" wire:loading.attr="disabled">
                        <span wire:loading.remove>Proses Penarikan Tunai</span>
                        <span wire:loading>
                            Memproses...
                        </span>
                    </flux:button>
                @endif
            </div>
        </form>
    </div>

    <!-- Riwayat Transaksi Terakhir -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-5 sm:p-6 space-y-4">
        <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            5 Transaksi Terakhir Siswa
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
                                <p class="text-sm font-bold text-slate-800">
                                    {{ \Carbon\Carbon::parse($his->date ?? $his->created_at)->translatedFormat('d M Y') }}
                                </p>
                                <p class="text-xs text-slate-400">{{ $his->created_at->format('H:i') }} •
                                    <span class="capitalize font-medium">{{ $his->type }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p
                                class="text-sm font-bold {{ $his->type == 'setor' ? 'text-emerald-600' : 'text-amber-600' }}">
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
    @if ($student->avatar)
        <flux:modal name="student-photo-modal" class="max-w-md p-2">
            <div class="space-y-3">
                <div class="rounded-xl overflow-hidden bg-black/5">
                    <img src="{{ $student->avatar }}" alt="{{ $student->name }}"
                        class="w-full h-auto max-h-[80vh] object-contain mx-auto">
                </div>
                <div class="text-center">
                    <p class="font-bold text-slate-800 text-base">{{ $student->name }}</p>
                    <p class="text-xs text-slate-500">NIS: {{ $student->nis ?? '-' }}</p>
                </div>
            </div>
        </flux:modal>
    @endif

</div>
