<div class="space-y-6">
    <div class="border rounded-lg border-neutral-500/20 p-4 ">
        <form wire:submit="filterData">
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <flux:input type="date" label="Tanggal Mulai" wire:model="start_date" name="start_date"/>
                    <flux:input type="date" label="Tanggal Akhir" wire:model="end_date" name="end_date"/>
                    <flux:select wire:model="user_id" name="user_id" label="Petugas">
                        <flux:select.option value="" label="Pilih Petugas"/>
                        @foreach($users as $user)
                            <flux:select.option value="{{$user->id}}" label="{{$user->name}}"/>
                        @endforeach
                    </flux:select>
                </div>
                <flux:separator/>
                <flux:checkbox.group wire:model="metode" label="Metode Pembayaran" class="flex items-start gap-6">
                    @foreach($jenis as $j)
                        <flux:checkbox label="{{$j->nama}}" value="{{$j->id}}"/>
                    @endforeach
                </flux:checkbox.group>
                <flux:button type="submit" class="w-full" variant="primary">Tampilkan</flux:button>
            </div>

        </form>
    </div>

    <div class="text-end">
{{--        <flux:icon.document-chart-bar/>--}}
        <flux:button
            icon="document-chart-bar"
            variant="primary"
            color="green"
            :href="route('laporan.filter.pdf', [
                    'start_date' => $start_date,
                    'end_date'   => $end_date,
                    'user_id'    => $user_id,
                    'metode'     => implode(',', $metode)
                    ])"
        >
            Unduh Laporan
        </flux:button>
    </div>
    <x-table.container class="rounded-lg">
        <x-table.columns>
            <x-table.column class="w-16">
                No
            </x-table.column>
            @foreach($this->headings as $head)
                <x-table.column>{{$head}}</x-table.column>
            @endforeach


        </x-table.columns>
        <x-table.rows>
            @forelse($this->dataLaporan['data'] as $index=>$data)

                <x-table.row variant="hovered">
                    <x-table.cell class="text-sm">
                        {{$index+1}}
                    </x-table.cell>
                    @foreach($this->headings as $head)
                        <x-table.cell class="truncate text-wrap text-sm py-1 px-4">
                            {{$data[$head]}}
                        </x-table.cell>
                    @endforeach
                </x-table.row>

            @empty
                <x-table.row>
                    <x-table.cell colspan="{{count($this->headings)+1}}">
                        <div class="flex items-center gap-2">
                            <flux:icon.information-circle></flux:icon.information-circle>
                            <span>
                                    Tidak ada data yang ditemukan
                                </span>
                        </div>
                    </x-table.cell>
                </x-table.row>
            @endforelse
                <x-table.row>
                    <x-table.cell colspan="5"/>
                    <x-table.cell colspan="2">SubTotal</x-table.cell>
                    <x-table.cell>{{format_rupiah($this->dataLaporan['totalDebet'])}}</x-table.cell>
                    <x-table.cell>{{format_rupiah($this->dataLaporan['totalKredit'])}}</x-table.cell>
                </x-table.row><x-table.row>
                    <x-table.cell colspan="5"/>
                    <x-table.cell colspan="3">Setoran - Penarikan</x-table.cell>
                    <x-table.cell>{{format_rupiah($this->dataLaporan['selisih'])}}</x-table.cell>
                </x-table.row>
        </x-table.rows>
    </x-table.container>

{{--            <iframe--}}
{{--                src="{{ route('laporan.filter.pdf', [--}}
{{--                    'start_date' => $start_date,--}}
{{--                    'end_date'   => $end_date,--}}
{{--                    'user_id'    => $user_id,--}}
{{--                    'metode'     => implode(',', $metode),--}}
{{--                ]) }}"--}}
{{--                width="100%" height="600px">--}}
{{--            </iframe>--}}
</div>
