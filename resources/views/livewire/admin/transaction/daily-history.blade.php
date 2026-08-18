<div class="mt-8">


    <div class="bg-white border-2 rounded-lg overflow-hidden">

        <div class="py-6 px-6">
            <div class="grid grid-cols-1 md:grid-cols-[1fr_auto_auto] gap-4">

                <flux:input type="text" placeholder="Type to search" wire:model.live.debounce.250ms="search">
                </flux:input>
                <flux:input type="date" wire:model.live.debounce.250ms="date"></flux:input>
                <flux:button wire:click="export" variant="primary">Unduh Excel</flux:button>
            </div>
        </div>
        <x-table.container class="border-none">
            <x-table.columns>
                <x-table.column class="w-16">No</x-table.column>
                @foreach ($headings as $head)
                    <x-table.column>{{ $head }}</x-table.column>
                @endforeach

            </x-table.columns>
            <x-table.rows>
                @forelse($this->transactions as $index => $registration)

                    <x-table.row variant="hovered">
                        <x-table.cell class="text-xs">{{ $index + 1 }}</x-table.cell>
                        @foreach ($headings as $head)
                            <x-table.cell
                                class="truncate text-wrap text-xs {{ $head === 'Nama' ? 'font-semibold uppercase' : '' }}
                            {{ $head === 'Metode' ? 'max-w-40 text-[10px]' : '' }}
                            ">
                                {{ $registration[$head] }}
                            </x-table.cell>
                        @endforeach
                    </x-table.row>
                @empty
                    <x-table.row>
                        <x-table.cell colspan="{{ count($headings) + 1 }}">
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
</div>
