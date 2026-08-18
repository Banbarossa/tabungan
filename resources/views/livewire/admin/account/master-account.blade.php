<section x-data="{
    shown: {
        @foreach ($headings as $head)
                '{{ $head }}': true, @endforeach
    }
}">

    <div class="bg-white rounded-lg border-2">

        <div class="py-8 px-4">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="w-full sm:max-w-xs lg:max-w-md">
                    <flux:input icon="magnifying-glass" wire:model.live.debounce.250ms="search"
                        placeholder="Search orders..." clearable />
                </div>
                @if ($boolStatus)
                    <div class="flex flex-wrap items-center gap-2 sm:flex-nowrap sm:justify-end">
                        <flux:button wire:click="importAbsen" icon="cloud-arrow-down" variant="subtle">
                            Import Absen
                        </flux:button>

                        <flux:button wire:click="updateKelasSiswa" icon="arrow-path" variant="subtle">
                            Update Kelas
                        </flux:button>

                        <flux:button wire:click="cetakKartu" icon="ticket" variant="primary" target="_blank">
                            Cetak Kartu
                        </flux:button>
                    </div>
                @endif

            </div>

        </div>
        <x-table.container class="border-none">
            <x-table.columns>
                <x-table.column class="!px-3">
                    <flux:checkbox wire:model.live="select_all" />
                </x-table.column>
                <x-table.column class="w-16">
                    Foto
                </x-table.column>
                <x-table.column>
                    Nama
                </x-table.column>
                @foreach ($headings as $head)
                    <x-table.column x-show="shown['{{ $head }}']"
                        class="px-2 whitespace-nowrap">{{ $head }}</x-table.column>
                @endforeach
                <x-table.column>
                    Limit
                </x-table.column>
                <x-table.column class="text-end">Aksi</x-table.column>

            </x-table.columns>
            <x-table.rows>
                @forelse($this->students as $student)
                    <x-table.row variant="hovered">
                        <x-table.cell class="!px-3 !py-2">
                            @if ($student['nisn'])
                                <div class="flex items-center">
                                    <flux:checkbox wire:model="ids.{{ $student['id'] }}" />
                                </div>
                            @endif
                        </x-table.cell>
                        <x-table.cell>
                            <a href="{{ route('account.photo', ['student' => $student['id']]) }}">
                                <div>
                                    <img src=" {{ $student['Photo'] }}" alt="user" class="w-10 h-10 object-cover">
                                </div>
                            </a>
                        </x-table.cell>
                        <x-table.cell>
                            <div class="test-sm uppercase font-semibold">
                                {{ $student['Nama'] }}
                            </div>
                            <div class="text-xs tex-gray-500">{{ $student['No Id'] }}</div>

                        </x-table.cell>
                        <x-table.cell>
                            <div class="test-sm ">
                                {{ $student['Kelas'] }}
                            </div>
                        </x-table.cell>
                        <x-table.cell>
                            @if ($student['Hp Ayah'])
                                <div class="flex items-center gap-2 text-xs">
                                    <span class="text-gray-700 dark:text-gray-300">{{ $student['Hp Ayah'] }}</span>
                                    <span
                                        class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        Ayah
                                    </span>
                                </div>
                            @endif
                            @if ($student['Hp Ibu'])
                                <div class="flex items-center gap-2 text-xs mt-1">
                                    <span class="text-gray-700 dark:text-gray-300">{{ $student['Hp Ibu'] }}</span>
                                    <span
                                        class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200">
                                        Ibu
                                    </span>
                                </div>
                            @endif
                        </x-table.cell>
                        <x-table.cell>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-medium  tracking-wider text-gray-400 dark:text-gray-500">
                                    Sisa Saldo
                                </span>
                                <span
                                    class="text-xs font-semibold {{ ($student['Saldo'] ?? 0) <= 0 ? 'text-red-600 dark:text-red-400' : 'text-emerald-600 dark:text-emerald-400' }}">
                                    {{ format_rupiah($student['Saldo']) }}
                                </span>
                            </div>
                        </x-table.cell>

                        <!-- Sel Limit Harian -->
                        <x-table.cell>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-medium tracking-wider text-gray-400 dark:text-gray-500">
                                    Limit Harian
                                </span>
                                @if (isset($student['Limit']) && $student['Limit'] > 0)
                                    <span class="text-xs font-medium text-amber-600 dark:text-amber-400">
                                        {{ $student['Limit'] }}
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center w-max px-1.5 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400">
                                        Tidak Ada Limit
                                    </span>
                                @endif
                            </div>
                        </x-table.cell>

                        <x-table.cell>
                            <flux:button.group>
                                <flux:button size="sm"
                                    href="{{ route('account.edit', vinclaEncode($student['id'])) }}">
                                    <flux:icon.pencil-square class="size-4 " />
                                </flux:button>
                                <flux:button size="sm" target="blank"
                                    href="{{ $student['nisn'] ? route('account.single-card', $student['id']) : '' }}">
                                    <flux:icon.ticket class="size-4" />
                                </flux:button>
                            </flux:button.group>
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

        <div class="py-6 px-6">
            {{ $this->students->links('livewire::simple-tailwind') }}
            <div class="text-xs text-gray-600 dark:text-gray-400">
                Menampilkan
                <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $this->students->firstItem() ?? 0 }}</span>
                sampai
                <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $this->students->lastItem() ?? 0 }}</span>
                dari
                <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $this->students->total() }}</span>
                data
                <span class="text-xs text-gray-400">(Halaman {{ $this->students->currentPage() }} dari
                    {{ $this->students->lastPage() }})</span>
            </div>
        </div>
    </div>

</section>
