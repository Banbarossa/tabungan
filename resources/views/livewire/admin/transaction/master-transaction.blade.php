<section x-data="{
    saldo: true,
    nama_ibu: false
}">






    <div class="rounded-lg border-2 overflow-hidden bg-white ">
        <div class="max-w-sm py-6 px-6">
            <flux:input icon="magnifying-glass" placeholder="Search..." wire:model.live='search' />
        </div>
        <div>
            <x-table.container class="border-none">
                <x-table.columns>
                    <x-table.column class="w-16">
                        Foto
                    </x-table.column>
                    <x-table.column>
                        Nama
                    </x-table.column>

                    <x-table.column>
                        Saldo
                    </x-table.column>
                    <x-table.column>
                        Limit Harian
                    </x-table.column>

                    <x-table.column class="text-end">Aksi</x-table.column>
                </x-table.columns>
                <x-table.rows>
                    @forelse($this->students as $student)
                        <x-table.row variant="hovered">
                            <x-table.cell>
                                <a href="{{ route('account.photo', ['student' => $student->id]) }}">
                                    <div>
                                        <img src=" {{ $student->photo}}" alt="{{ $student->name }}"
                                            class="w-10 h-10 object-cover">
                                    </div>
                                </a>
                            </x-table.cell>
                            <x-table.cell>
                                <div class="test-sm uppercase font-semibold">
                                    {{ $student->name }}
                                </div>
                                <div class="text-xs tex-gray-500">{{ $student->nisn }}</div>

                            </x-table.cell>
                            <x-table.cell>
                                <div class="flex flex-col">
                                    <span
                                        class="text-[10px] font-medium  tracking-wider text-gray-400 dark:text-gray-500">
                                        Sisa Saldo
                                    </span>
                                    <span
                                        class="text-xs font-semibold {{ ($student->saldo ?? 0) <= 0 ? 'text-red-600 dark:text-red-400' : 'text-emerald-600 dark:text-emerald-400' }}">
                                        {{ format_rupiah($student->saldo) }}
                                    </span>
                                </div>
                            </x-table.cell>

                            <!-- Sel Limit Harian -->
                            <x-table.cell>
                                <div class="flex flex-col">
                                    <span
                                        class="text-[10px] font-medium tracking-wider text-gray-400 dark:text-gray-500">
                                        Limit Harian
                                    </span>
                                    @if (isset($student->limit) && $student->limit > 0)
                                        <span class="text-xs font-semibold text-amber-600 dark:text-amber-400">
                                            {{ format_rupiah($student->limit) }}
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center w-max px-1.5 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400">
                                            Tidak Ada Limit
                                        </span>
                                    @endif
                                </div>
                            </x-table.cell>
                            <x-table.cell class="text-end">
                                <div>
                                    <flux:button  icon:trailing="chevron-right" href="{{ route('transaction.setor',vinclaEncode($student->id)) }}" variant="primary"></flux:button>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="{{ count($headings) + 2 }}">
                                <div class="flex items-center gap-2">
                                    <flux:icon.information-circle></flux:icon.information-circle>
                                    <span>
                                        Tidak ada data yang ditemukan
                                    </span>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-table.rows>
            </x-table.container>
        </div>
        {{-- <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700">
            @foreach ($this->students as $item)
            <li class="pb-3 sm:pb-4">
                <div class="flex items-center space-x-4 rtl:space-x-reverse">
                    <div class="shrink-0">
                        <img class="w-8 h-8 rounded-full" src="{{ $item->photo ? $item->photo :asset('images/avatar.jpg') }}" alt="Neil image">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                            {{ $item->name }}
                        </p>
                        <p class="text-xs text-gray-500 truncate dark:text-gray-400">
                            {{ $item->no_id }}
                        </p>
                    </div>
                    <div class="inline-flex items-center text-base font-semibold  text-gray-900 dark:text-white">
                        {{ format_rupiah($item->saldo) }}
                    </div>
                </div>
                <div class="flex justify-end">
                    <flux:button  size="xs" icon="eye" href="{{ route('transaction.setor',vinclaEncode($item->id)) }}">Detail</flux:button>
                </div>
            </li>
            @endforeach
        </ul> --}}
        <div class="my-2 px-4">
            {{ $this->students->links() }}
        </div>
    </div>


</section>
