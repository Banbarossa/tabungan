<div class=" lg:pb-8 text-slate-800">
    <!-- Header / Top Bar -->


    <!-- Main Content Container -->
    <div class="">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">

            <!-- Kolom Kiri / Utama: Tombol Aksi & Statistik Hari Ini (Desktop: 5 cols, Mobile: 12 cols) -->
            <div class="lg:col-span-5 space-y-5">

                <!-- Quick Action Buttons -->
                <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200/80">
                    <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Layanan Kasir</h2>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="/cek-saldo"
                            class="group flex flex-col items-center justify-center p-4 bg-emerald-50 hover:bg-emerald-500 border border-emerald-200 hover:border-emerald-500 rounded-2xl transition-all duration-200 text-emerald-700 hover:text-white shadow-sm hover:shadow-md active:scale-95">
                            <div
                                class="w-12 h-12 rounded-xl bg-emerald-100 group-hover:bg-emerald-400/30 flex items-center justify-center mb-2 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z">
                                    </path>
                                </svg>
                            </div>
                            <span class="font-bold text-sm">Cek Saldo</span>
                            <span class="text-[11px] opacity-75 group-hover:opacity-90 font-normal">Cek Saldo Santri</span>
                        </a>

                        <a href="/mobile-scan"
                            class="group flex flex-col items-center justify-center p-4 bg-amber-50 hover:bg-amber-500 border border-amber-200 hover:border-amber-500 rounded-2xl transition-all duration-200 text-amber-700 hover:text-white shadow-sm hover:shadow-md active:scale-95">
                            <div
                                class="w-12 h-12 rounded-xl bg-amber-100 group-hover:bg-amber-400/30 flex items-center justify-center mb-2 transition-colors">
                                <flux:icon name=device-phone-mobile class="w-6 h-6" />
                            </div>
                            <span class="font-bold text-sm">Tarik Tunai</span>
                            <span class="text-[11px] opacity-75 group-hover:opacity-90 font-normal text-center">Penarikan Lewat
                                Mobile</span>
                        </a>
                    </div>
                </div>

                <!-- Ringkasan Hari Ini -->
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/80 space-y-4">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Ringkasan Hari Ini</h2>
                        <span class="text-xs font-semibold text-slate-500">{{ $totalCountToday }} Transaksi</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-3">
                        @foreach ($todaySummaries as $summary)

                        <a href="{{ $summary['url'] }}" wire:navigate
                            class="flex items-center justify-between p-3.5 bg-slate-50 rounded-xl border border-slate-100">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 rounded-lg bg-emerald-100 text-emerald-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500 font-medium">{{$summary['label']}}</p>
                                    <p class="text-lg font-bold text-slate-800">
                                        {{ $summary['value'] }}
                                    </p>
                                </div>
                            </div>
                            <flux:icon name="chevron-right" class="w-4 h-4"></flux:icon>
                        </a>
                        @endforeach

                    </div>
                </div>

            </div>

            <!-- Kolom Kanan: Grafik Tren & Riwayat Transaksi (Desktop: 7 cols, Mobile: 12 cols) -->
            <div class="lg:col-span-7 space-y-5">

                <!-- Chart Grafik Transaksi -->
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/80 space-y-3">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tren Transaksi (8 Hari)
                        </h2>
                        <span class="text-xs text-slate-400">Total Nominal</span>
                    </div>
                    <div class="h-48 md:h-56 relative" x-data="{
                        initChart() {
                            const ctx = $refs.canvas.getContext('2d');
                            new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: {{ json_encode($grafikData['labels']) }},
                                    datasets: [{
                                        label: 'Omset Hari Ini',
                                        data: {{ json_encode($grafikData['values']) }},
                                        borderColor: '#6366f1',
                                        backgroundColor: 'rgba(99, 102, 241, 0.08)',
                                        fill: true,
                                        tension: 0.3,
                                        borderWidth: 2,
                                        pointRadius: 3,
                                        pointBackgroundColor: '#4f46e5'
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: { legend: { display: false } },
                                    scales: {
                                        x: { grid: { display: false }, ticks: { font: { size: 10 } } },
                                        y: {
                                            grid: { color: '#f1f5f9' },
                                            ticks: {
                                                font: { size: 10 },
                                                callback: (val) => 'Rp' + (val / 1000) + 'k'
                                            }
                                        }
                                    }
                                }
                            });
                        }
                    }" x-init="initChart()">
                        <canvas x-ref="canvas"></canvas>
                    </div>
                </div>

                <!-- Transaksi Terakhir -->
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/80 space-y-3">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Transaksi Terakhir</h2>
                        <a href="/riwayat"
                            class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">Lihat
                            Semua →</a>
                    </div>

                    <div class="divide-y divide-slate-100">
                        @forelse($recentTransactions as $trx)
                            <div
                                class="py-3 flex items-center justify-between hover:bg-slate-50/80 px-2 rounded-xl transition-colors">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 {{ $trx->type == 'jajan' ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }}">
                                        @if ($trx->type == 'jajan')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                                </path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800">
                                            {{ $trx->student->name ?? 'Siswa' }}</p>
                                        <p class="text-xs text-slate-400">{{ $trx->created_at->format('H:i') }} •
                                            <span class="capitalize font-medium">{{ $trx->type }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p
                                        class="text-sm font-bold {{ $trx->type == 'jajan' ? 'text-emerald-600' : 'text-amber-600' }}">
                                        -Rp{{ number_format($trx->amount, 0, ',', '.') }}
                                    </p>
                                    <p class="text-[10px] text-slate-400">Inv: #{{ $trx->invoice_number ?? $trx->id }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="py-8 text-center">
                                <p class="text-xs text-slate-400">Belum ada transaksi yang dilayani hari ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bottom Navigation Bar (Khusus Layar Mobile) -->

</div>

<!-- Chart.js Dependency -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
