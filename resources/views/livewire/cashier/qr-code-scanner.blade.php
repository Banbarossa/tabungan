<div class="max-w-7xl mx-auto space-y-6">

    <!-- Header Section -->
    <div
        class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Scanner Kartu Siswa</h1>
            <p class="text-sm text-slate-500">Arahkan QR Code kartu siswa ke kamera untuk melakukan transaksi penarikan
            </p>
        </div>
    </div>

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
                    {{-- <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span>
                        Kamera Aktif
                    </span> --}}
                </div>

                <!-- Container QR Reader -->
                <div class="relative rounded-xl overflow-hidden  border-2 border-dashed border-slate-300 p-2">
                    <div id="qr-reader" class="w-full rounded-lg overflow-hidden border-0"></div>
                </div>

                <!-- Fallback / Input Manual NISN -->
                <form action="" wire:submit.prevent="nisnManual" autocomplete="off">
                    <div class="pt-3 border-t border-slate-100 space-y-3">
                        <flux:label for="nisn">Scan barcode/Input NISN</flux:label>
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
                            Riwayat Transaksi Hari Ini
                        </h2>
                        <p class="text-xs text-slate-500">Memuat 15 transaksi terakhir yang Anda proses hari ini</p>
                    </div>
                    <span
                        class="text-xs font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full text-nowrap flex-none">
                        {{ $histories->count() }} Transaksi
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-600">
                        <thead class="text-xs uppercase bg-slate-50 text-slate-500 border-b border-slate-200">
                            <tr>
                                <th class="px-4 py-3">Waktu</th>
                                <th class="px-4 py-3">Siswa</th>
                                <th class="px-4 py-3 text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($histories as $history)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-4 py-3 text-xs text-slate-500 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($history->created_at)->format('H:i:s') }}
                                    </td>
                                    <td class="px-4 py-3 font-semibold text-slate-800">
                                        {{ $history->student->name ?? 'Siswa N/A' }}
                                        <span class="block text-[10px] font-normal text-slate-400">NISN:
                                            {{ $history->student->nisn ?? '-' }}</span>
                                    </td>
                                    <td
                                        class="px-4 py-3 text-right font-bold whitespace-nowrap {{ $history->type === 'setor' ? 'text-emerald-600' : 'text-slate-800' }}">
                                        {{ $history->type === 'setor' ? '+' : '-' }} Rp
                                        {{ number_format($history->amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-slate-400 italic">
                                        Belum ada transaksi yang diproses hari ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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
