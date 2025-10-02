<div class="mt-8">


    <x-table.table-header search="true">
        <div class="flex gap-4 flex-wrap">
            <div>
                <flux:input type="date" wire:model.live.debounce.250ms="date"></flux:input>
            </div>
            <flux:button wire:click="export">Unduh Excel</flux:button>
            <flux:spacer/>
        </div>
    </x-table.table-header>
    <x-table.container>
        <x-table.columns>
            <x-table.column class="w-16">No</x-table.column>
            @foreach($headings as $head)
                <x-table.column>{{$head}}</x-table.column>
            @endforeach
            <x-table.column>Aksi</x-table.column>

        </x-table.columns>
        <x-table.rows>
            @forelse($transactions as $index => $registration)

                <x-table.row variant="hovered">
                    <x-table.cell>{{$index + 1}}</x-table.cell>
                    @foreach($headings as $head)
                        <x-table.cell class="truncate text-wrap">
                            {{$registration[$head]}}
                        </x-table.cell>
                    @endforeach
                    <x-table.cell>
                        <flux:button size="sm" icon="eye" href=""/>
                    </x-table.cell>
                </x-table.row>
            @empty
                <x-table.row>
                    <x-table.cell colspan="{{count($headings)+2}}">
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
