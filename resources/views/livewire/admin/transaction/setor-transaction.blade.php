<section>



    <div class="grid lg:grid-cols-3 gap-4">
        <div class="lg:order-2">
            <livewire:admin.transaction.notification-card :student="$student"/>

        </div>
        <div
            class="lg:col-span-2 bg-zinc-200 dark:bg-zinc-800 rounded-lg p-4 border border-zinc-300 dark:border-zinc-600 flex flex-col">
            <div class="flex gap-3  h-full items-center flex-col">
                <div class="p-1 bg-white flex items-center justify-center rounded-lg">
                    <flux:icon.calculator class="size-10 text-indigo-500"></flux:icon.calculator>
                </div>

                <div class="text-center">
                    <flux:text>Saldo Saat Ini</flux:text>
                    <h1 class="text-2xl md:text-5xl font-bold font-mono">{{ format_rupiah($student->saldo)}}</h1>
                </div>
            </div>
            <div class="bg-white dark:bg-zinc-900 mt-2 p-2 rounded-lg shadow">
                <flux:modal.trigger name="setor">
                    <flux:button icon="plus" variant="primary">Setor</flux:button>
                </flux:modal.trigger>
                <flux:modal.trigger name="tarik">
                    <flux:button icon="minus" variant="danger">Tarik</flux:button>
                </flux:modal.trigger>
            </div>
        </div>
    </div>

    <div class="rounded-lg border mb-4 border-zinc-300 mt-5" x-data="{riwayat:true}">
        <button class="p-4 flex gap-4 flex-wrap  w-full item->center" x-on:click="riwayat = !riwayat">
            <flux:heading size="lg">
                RIWAYAT TRANSAKSI
            </flux:heading>
            <flux:spacer/>
            <flux:icon.arrow-right class="size-4" x-bind:class="{ 'rotate-90': riwayat }"></flux:icon.arrow-right>
        </button>
        <div x-cloak x-show="riwayat" x-transition>
            <flux:separator/>
            <div class="p-2">
                <x-table.container>
                    <x-table.columns>
                        <x-table.column class="w-10">
                            No
                        </x-table.column>
                        @foreach($headings as $head)
                            <x-table.column>{{$head}}</x-table.column>
                        @endforeach
                        <x-table.column class="w-24">Aksi</x-table.column>

                    </x-table.columns>
                    <x-table.rows>
                        @forelse($transaksi as $index=>$t)

                            <x-table.row variant="hovered">
                                <x-table.cell>
                                    {{$index+1}}
                                </x-table.cell>
                                @foreach($headings as $head)
                                    <x-table.cell class="truncate text-wrap">
                                        {{$t[$head]}}
                                    </x-table.cell>
                                @endforeach
                                <x-table.cell>
                                    <flux:button.group>
                                        <flux:button size="sm" icon="eye" href="{{route('transaction.detail',['code'=>$code,'transaction'=>$t['id']])}}"></flux:button>
{{--                                        <flux:button size="sm" icon="trash" variant="danger" wire:click="confirmDelete({{$t['id']}})"></flux:button>--}}
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
            </div>
        </div>
    </div>





    <flux:modal name="setor" class="md:w-96" variant="flyout">
        <div class="space-y-6">
            <div>
                <flux:heading size="xl">Update Saldo</flux:heading>
                <flux:text class="truncate">Penambahan Saldo Tabungan Santri</flux:text>
            </div>
            <img src="{{ asset('images/team.png') }}" alt="withdraw" class="h-36">
            <div class="bg-zinc-100 dark:bg-zinc-700 rounded-lg p-4 border border-zinc-300 relative">
                <div class="flex gap-3 items-center">
                    <div class="w-12 h-12 bg-green-300/80 flex items-center justify-center rounded-lg">
                        <flux:icon.briefcase></flux:icon.briefcase>
                    </div>
                    <div>
                        <flux:text class="uppercase truncate">{{$student->name}}</flux:text>
                        <flux:heading size="xl" class="uppercase">{{format_rupiah($student->saldo)}}</flux:heading>
                    </div>
                </div>
            </div>
            <form action="" wire:submit='setor'>
                <flux:input type="date" label="Tanggal" name="tanggal" wire:model="tanggal" class="mb-4"></flux:input>
                <div class="mb-4">
                    <flux:input.group>
                        <flux:input.group.prefix>Rp</flux:input.group.prefix>
                        <flux:input x-mask:dynamic="$money($input, ',', '.')" wire:model="amount_setor"/>
                    </flux:input.group>
                    <flux:error name="amount_setor"/>

                </div>
                <div class="mb-4">
                    <flux:select name="jenis_transaksi_id" wire:model="jenis_transaksi_id" label="Metode">
                        @foreach($methods as $method)
                        <flux:select.option value="{{$method->id}}">{{$method->nama}}</flux:select.option>

                        @endforeach
                    </flux:select>
                </div>

                <flux:textarea name="description" label="Keterangan" wire:model="description" rows="3"/>

                <div class="flex items-center justify-end mt-4">
                    <flux:button type="submit" variant="primary" class="w-full">
                        Tambah Saldo
                    </flux:button>
                </div>
            </form>


        </div>
    </flux:modal>
    <flux:modal name="tarik" class="md:w-96" variant="flyout">
        <div class="space-y-6">
            <div>
                <flux:heading size="xl">Penarikan</flux:heading>
                <flux:text>Penarikan Tabungan</flux:text>
            </div>
            <img src="{{ asset('images/withdraw.png') }}" alt="withdraw" class="h-36">
            <div class="bg-zinc-100 dark:bg-zinc-700 rounded-lg p-4 border border-zinc-300 relative">
                <div class="flex gap-3 items-center">
                    <div class="w-12 h-12 bg-red-300/80 flex items-center justify-center rounded-lg">
                        <flux:icon.ticket></flux:icon.ticket>
                    </div>
                    <div>
                        <flux:text class="uppercase truncate">{{$student->name}}</flux:text>
                        <flux:heading size="xl" class="uppercase">{{format_rupiah($student->saldo)}}</flux:heading>
                    </div>
                </div>
            </div>
            <form action="" wire:submit='tarik'>
                <flux:input type="date" label="Tanggal" name="tanggal" wire:model="tanggal" class="mb-4"></flux:input>
                <div class="mb-4">

                    <flux:input.group>
                        <flux:input.group.prefix>Rp</flux:input.group.prefix>
                        <flux:input x-mask:dynamic="$money($input, ',', '.')" wire:model="amount_tarik"/>
                    </flux:input.group>
                    <flux:error name="amount_tarik"/>
                </div>
                <flux:textarea name="description" label="Keterangan" wire:model="description" rows="3"/>

                <div class="flex items-center justify-end mt-4">
                    <flux:button type="submit" variant="primary" class="w-full">
                        Tarik
                    </flux:button>
                </div>
            </form>


        </div>
    </flux:modal>

</section>
