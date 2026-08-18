<div class="px-4 space-y-4">
    <div class="flex gap-2 ">
        @foreach ($pilihan_periode as $key => $p)
            <button wire:click="changePeriode('{{ $key }}')"
                class="shrink-0 px-3 py-1.5 rounded-full text-xs font-semibold capitalize transition-base {{ $key === $periode ? 'bg-[#7F1D1D] text-white' : 'bg-white text-gray-500 shadow' }}">
                {{ $p }}
            </button>
        @endforeach
    </div>

    <div class="space-y-3">
        @forelse ($data as $setoran)
            <div
                class="border border-border dark:border-neutral-500 bg-white rounded-xl p-4 hover:shadow-md transition-all hover:border-primary/30 hover:dark:border-neutral-500 hover:dark:ring-1 hover:dark:ring-neutral-500 dark:bg-neutral-800">


                <div class="flex justify-between gap-4">
                    <small class="text-xs dark:text-neutral-200">{{ data_get($setoran, 'tanggal', '-') }}</small>
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
                        <small class="capitalize">{{ data_get($setoran, 'type', '-') }}</small>
                    </div>
                    <div class="flex gap-1 items-center">
                        <flux:icon.user class="w-4" />
                        <small>{{ data_get($setoran, 'musyrif', '-') }}</small>
                    </div>
                </div>
                <div class="text-xs text-neutral-500 dark:text-neutral-300 mb-1.5">Catatan
                    Musyrif</div>
                <div
                    class="bg-neutral-50 dark:bg-neutral-900 text-neutral-500 dark:text-neutral-300 p-2 border border-dashed border-neutral-300 dark:border-neutral-700 rounded-lg">
                    <p class="text-xs text-center">
                        {{ blank(data_get($setoran, 'catatan'))
                            ? 'Tidak ada catatan khusus dalam setoran ini'
                            : data_get($setoran, 'catatan') }}
                    </p>
                </div>


            </div>
        @empty
            <div
                class="border border-border dark:border-neutral-500 bg-orange-50 rounded-xl p-4 hover:shadow-md transition-all hover:border-primary/30 hover:dark:border-neutral-500 hover:dark:ring-1 hover:dark:ring-neutral-500 dark:bg-neutral-800">
                <flux:icon name='information-circle' class="size-4 text-yellow-700" />
                <p class="text-xs text-yellow-700">Tidak ada data ditemukan</p>
            </div>
        @endforelse
    </div>

    {{-- <div class="mt-6 text-center">
                                    <flux:button variant="ghost" icon:trailing="chevron-down">
                                        Muat Lebih Banyak
                                    </flux:button>
                                </div> --}}
</div>
