<section
    x-data="{
            shown: {
            @foreach($headings as $head)
                '{{ $head }}': true,
            @endforeach
        }
    }">

    <x-table.table-header search="true">
        <div class="flex gap-4 flex-wrap">
            <div>
                <flux:button wire:click="importAbsen">Import Data Absen</flux:button>
            </div>
            <flux:button.group>
                <flux:dropdown>
                    <flux:button icon:trailing="eye"><span class="hidden md:inline">Tampil</span></flux:button>

                    <flux:menu>
                        <flux:menu.item>
                            <flux:checkbox.group label="Shown Table">
                                @foreach($headings as $head)
                                    <flux:checkbox
                                        label="{{ $head }}"
                                        x-model="shown['{{ $head }}']"
                                    />
                                @endforeach
                            </flux:checkbox.group>
                        </flux:menu.item>


                    </flux:menu>
                </flux:dropdown>
                <flux:button icon='ticket' target="blank" wire:click="cetakKartu">
                    <span class="hidden md:inline">Kartu</span>
                </flux:button>
            </flux:button.group>
            <flux:spacer/>
        </div>
    </x-table.table-header>
    <x-table.container>
        <x-table.columns>
            <x-table.column class="w-16">
                <flux:checkbox wire:model.live="select_all"/>
            </x-table.column>
            @foreach($headings as $head)
                <x-table.column x-show="shown['{{$head}}']">{{$head}}</x-table.column>
            @endforeach
            <x-table.column>Aksi</x-table.column>

        </x-table.columns>
        <x-table.rows>
            @forelse($students as $student)

                <x-table.row variant="hovered">
                    <x-table.cell>
                        @if($student['nisn'])
                        <div class="flex items-center">
                            <flux:checkbox wire:model="ids.{{$student['id']}}"/>
                        </div>
                        @endif
                    </x-table.cell>
                    @foreach($headings as $head)
                        <x-table.cell class="truncate text-wrap" x-show="shown['{{ $head }}']">
                            {{$student[$head]}}
                        </x-table.cell>
                    @endforeach
                    <x-table.cell>
                        <flux:button.group>
                            <flux:button size="sm" href="{{ route('account.edit',vinclaEncode($student['id'])) }}">
                                <flux:icon.pencil-square class="size-4 "/>
                            </flux:button>
                            <flux:button size="sm" target="blank"
                                         href="{{  $student['nisn'] ? route('account.single-card', $student['id']) : '' }}"
                            >
                                <flux:icon.ticket class="size-4"/>
                            </flux:button>
                        </flux:button.group>
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

</section>
