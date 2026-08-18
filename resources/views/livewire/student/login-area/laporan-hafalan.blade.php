<div>
    <section class="py-10 px-6 bg-muted/30 dark:bg-neutral-800">

        <div class=" mx-auto space-y-6">

            <div class="flex items-center justify-between ">
                <div>
                    <h2 class="text-2xl font-semibold text-primary dark:text-neutral-200 flex items-center gap-3">
                        <flux:icon.book-open class="size-7" />
                        Laporan Tahfidz
                    </h2>
                </div>
            </div>
            <div class="header-gradient rounded-b-[28px] px-4 pt-12 pb-5">
                <div class="flex gap-4 items-center">
                    <div class="relative shrink-0">
                        <img src="{{ asset('images/avatar.jpg') }}" alt="Logo"
                            class="w-16 h-16 rounded-2xl object-cover border-2 border-white/30">
                        <span
                            class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-400 rounded-full border-2 border-white flex items-center justify-center">
                            <flux:icon name="check" class="text-white" class="size-4" />
                            {{-- <x-icon name="check" :size="10" class="text-white" /> --}}
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h2 class="text-white font-bold font-display text-base leading-tight truncate">
                            {{ data_get($identitas, 'nama', 'Undefined') }}</h2>
                        <p class="text-red-200 text-xs mt-0.5">NIS:
                            {{ data_get($identitas, 'nisn', '000000000') }}</p>
                        <div class="flex gap-2 mt-1.5 flex-wrap">
                            <span
                                class="bg-white/15 text-white text-[10px] font-medium px-2 py-0.5 rounded-full">Kelas</span>
                            <span
                                class="bg-white/15 text-white text-[10px] font-medium px-2 py-0.5 rounded-full">Asrama</span>
                        </div>
                    </div>
                </div>
            </div>
            @if ($success_get_data)

                <div x-data="{ show: $wire.entangle('success_get_data') }">
                    <div x-show="show" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 -translate-y-2 scale-95" x-cloak class="space-y-6">





                        <x-card class="bg-white shadow">
                            <x-card-content class="p-6">
                                <div class="flex justify-between gap-4">
                                    <small class="text-xs dark:text-neutral-400">Setoran Terbaru</small>
                                    {{-- @if (isset($terakhir->rating)) --}}
                                    <div class="text-sm flex items-start gap-0.5">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <flux:icon.star variant="solid"
                                                class="w-4 {{ $i <= data_get($laporan, 'setoran_terakhir.rating', 0) ? 'text-yellow-400' : 'text-gray-300' }}" />
                                        @endfor
                                    </div>
                                    {{-- @endif --}}
                                </div>
                                <div>
                                    <h3 class="font-semibold text-primary dark:text-secondary">
                                        {{ data_get($laporan, 'setoran_terakhir.ayat', '-') }}
                                    </h3>
                                </div>
                                <div class="flex flex-wrap gap-3 text-neutral-600 dark:text-neutral-200">
                                    <div class="flex gap-1 items-center whitespace-nowrap">
                                        <flux:icon.calendar class="w-4" />
                                        <small>{{ data_get($laporan, 'setoran_terakhir.tanggal', '-') }}</small>
                                    </div>
                                    <div class="flex gap-1 items-center whitespace-nowrap">
                                        <flux:icon.bookmark class="w-4" />
                                        <small
                                            class="capitalize">{{ data_get($laporan, 'setoran_terakhir.type', '-') }}</small>
                                    </div>
                                    <div class="flex gap-1 items-center whitespace-nowrap">
                                        <flux:icon.user class="w-4" />
                                        <small>{{ data_get($laporan, 'setoran_terakhir.musyrif', '-') }}</small>
                                    </div>
                                </div>
                                <div class="text-xs text-primary dark:text-secondary/90 mb-2">
                                    {{ data_get($laporan, 'setoran_terakhir.waktu') }} </div>
                                <div class="text-xs text-neutral-600 dark:text-neutral-300 mb-1.5">Catatan Musyrif</div>
                                <div
                                    class="bg-white dark:bg-neutral-900 text-neutral-500 dark:text-neutral-300 p-4 border-2 border-dashed border-neutral-300 dark:border-neutral-600 rounded-lg">
                                    <p class="text-sm text-center">
                                        {{ blank(data_get($laporan, 'setoran_terakhir.catatan')) ? 'Tidak ada catatan pada setoran ini' : data_get($laporan, 'setoran_terakhir.catatan') }}
                                    </p>
                                </div>
                            </x-card-content>
                        </x-card>

                        {{-- Perkembangan Bulan --}}
                        <x-card class="bg-white shadow">
                            <x-card-content class="p-6">
                                <div>
                                    <p class=" text-xs  text-neutral-600 dark:text-neutral-200">Perkembangan
                                        {{ data_get($laporan, 'currentMonth', Carbon\Carbon::now()->locale('id')->translatedFormat('M Y')) }}
                                    </p>
                                    <h3 class="font-semibold text-primary dark:text-secondary">Perkembangan Bulan Ini
                                    </h3>
                                </div>

                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div
                                        class="bg-red-50   p-4 rounded-lg border border-border">
                                        <div class="text-lg font-bold text-primary dark:text-secondary">
                                            {{ data_get($laporan, 'monthSummary.jumlah_ziyadah') }}</div>
                                        <div class="text-xs">x Setoran Baru</div>
                                    </div>
                                    <div
                                        class="bg-red-50   p-4 rounded-lg border border-border">
                                        <div class="text-lg font-bold text-primary dark:text-secondary">
                                            {{ data_get($laporan, 'monthSummary.jumlah_murajaah') }}</div>
                                        <div class="text-xs">x Murajaah</div>
                                    </div>
                                    <div
                                        class="bg-red-50  text-neutral-500 p-4 rounded-lg border border-border">
                                        <div class="text-lg font-bold text-primary dark:text-secondary">
                                            {{ data_get($laporan, 'monthSummary.jumlah_ayat') }}</div>
                                        <div class="text-xs">Ayat Baru</div>
                                    </div>
                                    <div
                                        class="bg-red-50  text-neutral-500 p-4 rounded-lg border border-border">
                                        <div class="text-lg font-bold text-primary dark:text-secondary">
                                            <div class="text-sm flex items-start gap-0.5">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <flux:icon.star variant="solid"
                                                        class="w-4 {{ $i <= data_get($laporan, 'monthSummary.avg_rating', 0) ? 'text-yellow-400' : 'text-neutral-300' }}" />
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="text-xs">Rating Rata Rata</div>
                                    </div>
                                </div>
                                <div class="mt-8 h-72">
                                    @if ($success_get_data)
                                        <canvas id="grafikPerkembangan"></canvas>
                                        @script
                                            <script>
                                                $wire.on('laporan-updated', (event) => {
                                                    requestAnimationFrame(() => {
                                                        requestAnimationFrame(() => {
                                                            renderPerkembanganChart(
                                                                'grafikPerkembangan',
                                                                event.grafik
                                                            );
                                                        });
                                                    });
                                                });
                                            </script>
                                        @endscript

                                    @endif
                                </div>

                            </x-card-content>
                        </x-card>




                        {{-- Target Hafalan --}}
                        <x-card class="bg-white shadow">
                            <x-card-content class="p-6">
                                <div>
                                    <h3 class="font-semibold text-primary dark:text-secondary">Target Hafalan</h3>
                                </div>

                                <div
                                    class="bg-white dark:bg-neutral-600 text-neutral-500 p-4 border-2 border-dashed border-neutral-300 dark:border-neutral-700 rounded-lg flex flex-col items-center mb-4">
                                    <flux:icon.book-open-text class="dark:text-neutral-200" />
                                    @if (data_get($laporan, 'target_aktif'))
                                        <small class="text-xs dark:text-neutral-200">Target Hafalan</small>
                                        <h2 class="uppercase text-2xl font-semibold text-primary dark:text-secondary">
                                            {{ data_get($laporan, 'target_aktif.juz') }}</h4>
                                        @else
                                            <p class="text-sm">Target semester belum ditetapkan oleh pembimbing.</p>
                                    @endif
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-white text-neutral-500 p-4 rounded-lg shadow">
                                        <p class="text-xs">{{ data_get($laporan, 'persen') }} Persen dari juz dihafal
                                        </p>
                                    </div>
                                    <div class="bg-white text-neutral-500 p-4 rounded-lg shadow">
                                        <p class="text-xs">Halaman {{ data_get($laporan, 'capaian_halaman') }}</p>
                                    </div>
                                </div>
                            </x-card-content>
                        </x-card>



                        {{-- <x-card
                            class="border-2 dark:border-secondary/50 border-primary/20 bg-gradient-to-br from-primary/5 to-secondary/5">
                            <x-card-content class="p-6">
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <div class="flex items-center justify-between mb-4">
                                            <h3 class="font-semibold text-primary">Progress Hafalan</h3>
                                            <span class="text-sm text-foreground/60">Update: Tanggal</span>
                                        </div>
                                        <div class="space-y-4">
                                            <div>
                                                <div class="flex items-center justify-between mb-2">
                                                    <span class="text-sm text-foreground/70">Juz 1 dari 5 </span>
                                                    <span class="text-sm font-semibold text-primary">50%</span>
                                                </div>
                                                <div class="w-full rounded-full h-3 bg-primary/20 overflow-hidden">
                                                    <div class="h-full bg-primary" style="width: 50%"></div>
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-2 gap-4">
                                                <div class="bg-white rounded-lg p-4 border border-border">
                                                    <div class="text-3xl font-semibold text-primary mb-1">5</div>
                                                    <div class="text-sm text-foreground/60">Juz Selesai</div>
                                                </div>
                                                <div class="bg-white rounded-lg p-4 border border-border">
                                                    <div class="text-3xl font-semibold text-primary mb-1">6</div>
                                                    <div class="text-sm text-foreground/60">Surah Selesai</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-y-4">
                                        <h3 class="font-semibold text-primary">Statistik Penilaian</h3>
                                        <div class="bg-white rounded-lg p-4 border border-border">
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="text-foreground/70">Rata-rata Nilai</span>
                                                <span class="text-2xl font-semibold text-primary">60</span>
                                            </div>
                                            <div class="space-y-2 mt-4">

                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 text-sm font-medium text-foreground/70">Grade A
                                                    </div>
                                                    <div class="flex-1 h-2 bg-muted rounded-full overflow-hidden">
                                                        <div class="h-full ${item.color}" style="width: 30%">
                                                        </div>
                                                    </div>
                                                    <div class="w-8 text-sm text-foreground/60">30x</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </x-card-content>
                        </x-card> --}}

                        {{-- @if (!empty($riwayatSetoranTerakhir)) --}}
                        <x-card class="bg-white shadow">
                            <x-card-content class="p-6">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
                                    <h3 class="font-semibold text-primary dark:text-secondary flex items-center gap-2">
                                        <flux:icon.arrow-path-rounded-square />
                                        Riwayat Setoran Terkini
                                    </h3>
                                    <div class="flex gap-2">
                                        @foreach ($pilihan_periode as $key => $p)
                                            <flux:button size="sm"
                                                variant="{{ $key === $periode ? 'primary' : 'outline' }}"
                                                wire:click="changePeriode('{{ $key }}')">{{ $p }}
                                            </flux:button>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    @foreach (collect(data_get($laporan, 'riwayat', collect())) as $setoran)
                                        <div
                                            class="border border-border dark:border-neutral-500 bg-neutral-50 rounded-xl p-4 hover:shadow-md transition-all hover:border-primary/30 hover:dark:border-neutral-500 hover:dark:ring-1 hover:dark:ring-neutral-500 dark:bg-neutral-800">


                                            <div class="flex justify-between gap-4">
                                                <small
                                                    class="text-xs dark:text-neutral-200">{{ data_get($setoran, 'tanggal', '-') }}</small>
                                                {{-- @if (isset($terakhir->rating)) --}}
                                                <div class="text-sm flex items-start gap-0.5">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <flux:icon.star variant="solid"
                                                            class="w-4 {{ $i <= data_get($setoran, 'rating', 0) ? 'text-yellow-400' : 'text-gray-300' }}" />
                                                    @endfor
                                                </div>
                                                {{-- @endif --}}
                                            </div>
                                            <div>
                                                <h3 class="font-semibold text-primary dark:text-secondary">
                                                    {{ data_get($setoran, 'ayat', '-') }}
                                                </h3>
                                            </div>
                                            <div class="flex gap-3 text-neutral-500 dark:text-neutral-300 mb-4">
                                                <div class="flex gap-1 items-center">
                                                    <flux:icon.bookmark class="w-4" />
                                                    <small
                                                        class="capitalize">{{ data_get($setoran, 'type', '-') }}</small>
                                                </div>
                                                <div class="flex gap-1 items-center">
                                                    <flux:icon.user class="w-4" />
                                                    <small>{{ data_get($setoran, 'musyrif', '-') }}</small>
                                                </div>
                                            </div>
                                            <div class="text-xs text-neutral-500 dark:text-neutral-300 mb-1.5">Catatan
                                                Musyrif</div>
                                            <div
                                                class="bg-white dark:bg-neutral-900 text-neutral-500 dark:text-neutral-300 p-4 border-2 border-dashed border-neutral-300 dark:border-neutral-700 rounded-lg">
                                                <p class="text-sm text-center">
                                                    {{ blank(data_get($setoran, 'catatan'))
                                                        ? 'Tidak ada catatan khusus dalam setoran ini'
                                                        : data_get($setoran, 'catatan') }}
                                                </p>
                                            </div>


                                            {{-- <div class="flex items-start justify-between gap-4">
                                                <div class="flex items-start gap-4 flex-1">
                                                    <div
                                                        class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0">
                                                        <span
                                                            class="material-symbols-outlined text-primary text-xl">import_contacts</span>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-center gap-2 mb-2">
                                                            <h4 class="font-semibold text-primary">Juz 2</h4>
                                                            <span
                                                                class="px-3 py-1 rounded-full text-sm border ${getGradeColor(record.grade)}">
                                                                b
                                                            </span>
                                                        </div>
                                                        <div
                                                            class="grid sm:grid-cols-2 gap-2 text-sm text-foreground/60 mb-2">
                                                            <div class="flex items-center gap-2">
                                                                <flux:icon.calendar class="size-4" />
                                                                Tanggal
                                                            </div>
                                                            <div class="flex items-center gap-2">
                                                                <flux:icon.user-circle class="size-4" />
                                                                Musyrif
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="flex items-center gap-2 text-sm text-foreground/60 mb-2">
                                                            <flux:icon.list-bullet class="size-4" />
                                                            Ayat 1 - 5
                                                        </div>
                                                        <div class="bg-muted/50 rounded-lg p-3 mt-2">
                                                            <div class="flex items-start gap-2">
                                                                <flux:icon.chat-bubble-left-ellipsis class="size-4" />
                                                                <p class="text-sm text-foreground/80 flex-1">
                                                                    Catatan</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                    @endforeach
                                </div>

                                {{-- <div class="mt-6 text-center">
                                    <flux:button variant="ghost" icon:trailing="chevron-down">
                                        Muat Lebih Banyak
                                    </flux:button>
                                </div> --}}
                            </x-card-content>
                        </x-card>
                        {{-- @endif --}}

                        {{--    {/* Target & Goals */} --}}
                        {{-- <x-card class="border-2 border-primary/10">
                            <x-card-content class="p-6">
                                <h3 class="font-semibold text-primary mb-4 flex items-center gap-2">
                                    <flux:icon.flag />
                                    Target Hafalan
                                </h3>
                                <div class="grid md:grid-cols-3 gap-4">
                                    <div
                                        class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200">
                                        <div class="flex items-center gap-3 mb-3">
                                            <div
                                                class="w-10 h-10 rounded-lg bg-blue-600 text-white flex items-center justify-center">
                                                <flux:icon.calendar-days />
                                            </div>
                                            <div>
                                                <div class="text-sm text-blue-700">Target Bulan Ini</div>
                                                <div class="font-semibold text-blue-900">1 Juz</div>
                                            </div>
                                        </div>
                                        <div class="w-full rounded-full h-2 bg-blue-800/20 overflow-hidden">
                                            <div class="h-full bg-blue-800" style="width: 50%"></div>
                                        </div>
                                        <div class="text-xs text-blue-700 mt-2">75% tercapai</div>
                                    </div>

                                    <div
                                        class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200">
                                        <div class="flex items-center gap-3 mb-3">
                                            <div
                                                class="w-10 h-10 rounded-lg bg-green-600 text-white flex items-center justify-center">
                                                <span class="material-symbols-outlined">calendar_month</span>
                                            </div>
                                            <div>
                                                <div class="text-sm text-green-700">Target Semester</div>
                                                <div class="font-semibold text-green-900">5 Juz</div>
                                            </div>
                                        </div>
                                        <Progress value={60} class="h-2" />
                                        <div class="text-xs text-green-700 mt-2">3 Juz selesai</div>
                                    </div>

                                    <div
                                        class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 border border-purple-200">
                                        <div class="flex items-center gap-3 mb-3">
                                            <div
                                                class="w-10 h-10 rounded-lg bg-purple-600 text-white flex items-center justify-center">
                                                <span class="material-symbols-outlined">school</span>
                                            </div>
                                            <div>
                                                <div class="text-sm text-purple-700">Target Kelulusan</div>
                                                <div class="font-semibold text-purple-900">30 Juz</div>
                                            </div>
                                        </div>
                                        <Progress value={progressPercentage} class="h-2" />
                                        <div class="text-xs text-purple-700 mt-2">{stats.completedJuz} Juz selesai
                                        </div>
                                    </div>
                                </div>
                            </x-card-content>
                        </x-card> --}}
                    </div>
                </div>
            @endif


        </div>
    </section>
</div>
