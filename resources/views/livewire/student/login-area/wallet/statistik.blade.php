    <div class="px-4 pt-4 space-y-4">
        <div class="bg-white rounded-2xl p-4 shadow">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-display font-bold text-gray-800 text-sm">Pengeluaran 6 Bulan</h3>
                <span class="text-[10px] text-gray-400">{{ $rata_rata['label'] }}</span>
            </div>
            <div>
                <canvas id="statistikDompet"></canvas>
                @script
                    <script>
                        requestAnimationFrame(() => {
                            statistikDompet(
                                'statistikDompet',
                                @js($grafik)
                            );
                        });
                    </script>
                @endscript

            </div>
            <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-50">
                <div>
                    <p class="text-[10px] text-gray-400">Total 6 Bulan</p>
                    <p class="font-display font-bold text-gray-800 text-sm">{{ $rata_rata['total'] }}</p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] text-gray-400">Rata-rata/Bulan</p>
                    <p class="font-display font-bold text-gray-800 text-sm">{{ $rata_rata['avg'] }}</p>
                </div>
            </div>
        </div>



    </div>
