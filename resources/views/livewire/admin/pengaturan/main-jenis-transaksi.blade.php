<div>
    <div class="mb-6">

        <flux:modal.trigger name="tambah-jenis">
            <flux:button>Tambah</flux:button>
        </flux:modal.trigger>

        <flux:modal name="tambah-jenis" class="md:w-96">
            <form wire:submit.prevent="save">
                <div class="space-y-6">
                    <div>
                        <flux:heading size="lg">Tambah Jenis Pembiayaan</flux:heading>
                        <flux:text class="mt-2">Masukkan nama untuk menambahkan baru</flux:text>
                    </div>

                    <flux:input type="text" label="Nama" name="nama" wire:model="nama" placeholder="Nama"/>
                    <flux:input type="number" label="Urutan Tampil" name="no_urut" wire:model="no_urut"
                                placeholder="Urutan Tampil"/>


                    <div class="flex">
                        <flux:spacer/>

                        <flux:button type="submit" variant="primary">Simpan</flux:button>
                    </div>
                </div>
            </form>
        </flux:modal>
    </div>

    <x-table.container>
        <x-table.columns>
            <x-table.column class="w-16">
                NO
            </x-table.column>
            @foreach($headings as $head)
                <x-table.column >{{$head}}</x-table.column>
            @endforeach

        </x-table.columns>
        <x-table.rows>
            @forelse($jenis as $index=>$je)

                <x-table.row variant="hovered">
                    <x-table.cell>
                        {{$index+1}}
                    </x-table.cell>
                    @foreach($headings as $head)
                        <x-table.cell class="truncate text-wrap" >
                            {{$je[$head]}}
                        </x-table.cell>
                    @endforeach
                </x-table.row>
            @empty
                <x-table.row>
                    <x-table.cell colspan="{{count($headings)+1}}">
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
