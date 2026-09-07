<div class="max-w-7xl mx-auto space-y-6">

    <h1 class="text-2xl font-bold text-slate-800">Cek Saldo Siswa</h1>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- KIRI: Scanner & Input Manual (5 Col) -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm space-y-5">
                <div class="flex items-center justify-between">
                    <h2 class="font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg>
                        Kamera Scanner
                    </h2>
                    <span id="status-kamera"
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5 animate-pulse"
                            id='status-indicator'></span>
                        <span id="status-text">Kamera Aktif</span>
                    </span>
                </div>

                <!-- Container QR Reader -->
                <div class="relative rounded-xl overflow-hidden  border-2 border-dashed border-slate-300 p-2 "
                    id="container">
                    <div id="qr-reader" class="w-full rounded-lg overflow-hidden border-0"></div>
                </div>
                @if ($student)
                    <flux:button wire:click="clear()" class="w-full" variant="primary">Ulangi Kamera</flux:button>
                @endif

                <!-- Fallback / Input Manual NISN -->
                <form action="" wire:submit.prevent="nisnManual" autocomplete="off">
                    <div class="pt-3 border-t border-slate-100 space-y-3">
                        <flux:label for="nisn">Atau Input NISN / NIS Manual</flux:label>
                        <div class="flex gap-2">
                            <flux:input wire:model="nisn" id="nisn" placeholder="Ketik NISN lalu tekan enter..."
                                wire:keydown.enter="nisnManual" clearable />
                            <flux:button type="submit" variant="primary">
                                Cari
                            </flux:button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- KANAN: Tabel Riwayat Transaksi Hari Ini (7 Col) -->
        <div class="lg:col-span-7">
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="font-bold text-slate-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Data santri
                        </h2>
                        <p class="text-xs text-slate-500">Pengecekan saldo santri</p>
                    </div>
                </div>
                @if ($student)
                    <div class="space-y-4">
                        <div
                            class="flex flex-col sm:flex-row items-center sm:items-start gap-4 p-4 rounded-xl bg-slate-50 border border-slate-200/60">
                            <!-- Foto Santri -->
                            <div
                                class="w-full max-w-sm rounded-xl overflow-hidden bg-slate-200 flex-shrink-0 shadow-sm border border-white">
                                @if ($student->avatar)
                                    <img src="{{ $student->avatar }}" alt="{{ $student->name }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div
                                        class="w-full h-full flex flex-col items-center justify-center text-slate-400 bg-slate-100">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Detail Profil -->
                            <div class="flex-1 text-center sm:text-left space-y-1">
                                <span class="text-[11px] font-medium tracking-wider text-slate-400 uppercase">NISN:
                                    {{ $student->nisn ?? '-' }}</span>
                                <h3 class="text-xl font-bold text-slate-800 leading-snug">{{ $student->name }}</h3>
                                <p class="text-xs text-slate-500">Kelas / Asrama: <span
                                        class="font-semibold text-slate-700">{{ $student->kelas ?? '-' }}</span>
                                </p>
                            </div>
                        </div>

                        <!-- Card Total Saldo -->
                        <div
                            class="p-4 rounded-xl bg-gradient-to-br from-red-800 to-red-900 text-white shadow-md flex items-center justify-between">
                            <div>
                                <span class="text-xs text-red-200 block font-medium">Sisa Saldo Tabungan</span>
                                <span class="text-2xl sm:text-3xl font-black tracking-tight">
                                    Rp {{ number_format($student->saldo ?? 0, 0, ',', '.') }}
                                </span>
                            </div>
                            @if ($student->saldo > 900)
                                <div class="p-2.5 bg-white/10 rounded-lg backdrop-blur-sm">
                                    <flux:button wire:click="processStudentToken" variant="primary">Tarik Tunai
                                    </flux:button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- 2. RIWAYAT 10 TRANSAKSI TERAKHIR -->
                    <div class="space-y-3 pt-2">
                        <div class="flex items-center justify-between">
                            <h4 class="text-sm font-bold text-slate-800 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                10 Transaksi Terakhir
                            </h4>
                            <span class="text-[11px] text-slate-400">Mutasi Rekening</span>
                        </div>

                        <div class="space-y-2.5">
                            @forelse ($student->transactions()->latest()->take(10)->get() as $history)
                                <div
                                    class="p-3 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200/60 rounded-xl transition-all duration-150 flex items-center justify-between gap-3">

                                    <!-- Sisi Kiri: Icon Tipe Transaksi & Info -->
                                    <div class="flex items-center gap-3 min-w-0">
                                        <!-- Icon Indikator (Setor / Tarik) -->
                                        <div
                                            class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0 {{ $history->type === 'setor' ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }}">
                                            @if ($history->type === 'setor')
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                                </svg>
                                            @endif
                                        </div>

                                        <!-- Detail Tipe & Keterangan -->
                                        <div class="min-w-0 flex-1">
                                            <div class="flex items-center gap-1.5">
                                                <span class="text-xs font-bold text-slate-800">
                                                    {{ $history->type === 'setor' ? 'Setor Tabungan' : 'Penarikan Tunai' }}
                                                </span>
                                            </div>

                                            <p class="text-[11px] text-slate-500 truncate">
                                                {{ $history->description ?: 'Tanpa keterangan' }}
                                            </p>

                                            <span class="text-[10px] text-slate-400 block mt-0.5">
                                                {{ \Carbon\Carbon::parse($history->created_at)->translatedFormat('d M Y, H:i') }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Sisi Kanan: Nominal Transaksi -->
                                    <div class="text-right flex-shrink-0">
                                        <span
                                            class="text-xs font-black {{ $history->type === 'setor' ? 'text-emerald-600' : 'text-slate-800' }}">
                                            {{ $history->type === 'setor' ? '+' : '-' }} Rp
                                            {{ number_format($history->amount, 0, ',', '.') }}
                                        </span>
                                        <span
                                            class="block text-[10px] font-semibold uppercase {{ $history->type === 'setor' ? 'text-emerald-500' : 'text-amber-500' }}">
                                            {{ strtoupper($history->type) }}
                                        </span>
                                    </div>

                                </div>
                            @empty
                                <div
                                    class="p-6 text-center bg-slate-50 border border-dashed border-slate-200 rounded-xl space-y-1">
                                    <svg class="w-8 h-8 text-slate-300 mx-auto" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-xs text-slate-400 italic">Belum ada riwayat transaksi untuk santri
                                        ini.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @else
                    <div class="py-12 px-4 text-center space-y-4">
                        <div
                            class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mx-auto shadow-sm">
                            <svg class="w-8 h-8 animate-pulse" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                            </svg>
                        </div>
                        <div class="max-w-xs mx-auto space-y-1">
                            <h3 class="font-bold text-slate-700 text-base">Silakan Scan QR Kartu Santri</h3>
                            <p class="text-xs text-slate-400">Arahkan QR Code kartu ke kamera scanner di sebelah kiri
                                untuk melihat saldo dan riwayat transaksi.</p>
                        </div>
                    </div>
                @endif

            </div>
        </div>

    </div>

    <!-- Script HTML5 QR Code -->
    @script
        <script>
            let qrScanner = null;
            let scannerInitializing = false;



            async function initScanner() {
                const qrElement = document.getElementById('qr-reader');

                if (!qrElement) return;

                // Jangan inisialisasi kalau sedang proses init
                if (scannerInitializing) return;

                // Kalau scanner sudah aktif, jangan buat lagi
                if (qrScanner) {
                    return
                };

                if (!window.Html5QrcodeScanner) return;

                scannerInitializing = true;

                try {
                    qrScanner = new Html5QrcodeScanner("qr-reader", {
                        fps: 10,
                        qrbox: {
                            width: 220,
                            height: 220
                        },
                        rememberLastUsedCamera: true,
                        showTorchButtonIfSupported: true
                    });

                    qrScanner.render(
                        async success => {
                                if (!qrScanner) return;

                                const scanner = qrScanner;
                                qrScanner = null;

                                try {
                                    await scanner.clear();
                                } catch (e) {
                                    console.error('Gagal clear scanner:', e);
                                }

                                $wire.processQr(success);
                            },
                            error => {
                                // Abaikan error scanning biasa
                            }
                    );

                } catch (e) {
                    console.error('Gagal initialize QR scanner:', e);
                    qrScanner = null;
                } finally {
                    scannerInitializing = false;
                }
            }

            document.addEventListener('livewire:initialized', () => {
                initScanner();
            });

            document.addEventListener('livewire:navigated', () => {
                setTimeout(() => {
                    initScanner();
                }, 300);
            });
            $wire.on('start_camera', (event) => {
                console.log(event)
                setTimeout(() => {
                    initScanner();
                }, 100);
            })
        </script>
    @endscript
</div>
