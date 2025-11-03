<div>
    <x-table.table-header search="true">
        <div class="flex gap-4 flex-wrap">

            <flux:button.group>
                <flux:button icon='arrow-path' target="blank" wire:click="dataPesan">
                    <span >Perbaharui Data</span>
                </flux:button>
            </flux:button.group>
            <flux:spacer/>
        </div>
    </x-table.table-header>
    <x-table.container>
        <x-table.columns>
            <x-table.column class="w-16">
                No
            </x-table.column>
            @foreach($headings as $head)
                <x-table.column >{{$head}}</x-table.column>
            @endforeach
            <x-table.column>Aksi</x-table.column>

        </x-table.columns>
        <x-table.rows>
            @forelse($messages as $index=>$data)

                <x-table.row variant="hovered">
                    <x-table.cell>
                        {{$index+1}}
                    </x-table.cell>
                    @foreach($headings as $head)
                        <x-table.cell class="truncate text-wrap" >
                            {{$data[$head]}}
                        </x-table.cell>
                    @endforeach
                    <x-table.cell>
                        @if($data['sending_status'] != 'sent')
                            <flux:button wire:click="directSent({{$data['id_message']}})" variant="primary" size="sm">Kirim Sekarang</flux:button>
                        @endif
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
