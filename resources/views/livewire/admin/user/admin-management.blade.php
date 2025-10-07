<div>


    <div class="mb-4">
    @include('livewire.admin.user.heading')

    </div>

    <x-table.table-header search="true">
        <div class="flex gap-4 flex-wrap">
            <flux:button.group>

                            <flux:button
                                href="{{ route('user.index',['role'=>'admin']) }}"
                                >
                                <span class="{{ $role=='admin' ? 'font-bold':'font-extralight text-gray-500' }}">Admin</span>
                            </flux:button>
                            <flux:button
                                href="{{ route('user.index',['role'=>'cashier']) }}"
                                >
                                 <span class="{{ $role=='cashier'  ? 'font-bold':'font-extralight text-gray-500' }}">Cashier</span>
                            </flux:button>

                        </flux:button.group>
            <flux:spacer/>
        </div>
    </x-table.table-header>
    <x-table.container>
        <x-table.columns>
            <x-table.column class="w-16">No</x-table.column>
            @foreach($headings as $head)
                <x-table.column>{{$head}}</x-table.column>
            @endforeach
            <x-table.column>

            </x-table.column>
            <x-table.column>Aksi</x-table.column>

        </x-table.columns>
        <x-table.rows>
            @forelse($users as $index => $user)

                <x-table.row variant="hovered">
                    <x-table.cell>{{$index + 1}}</x-table.cell>
                    @foreach($headings as $head)
                        <x-table.cell class="truncate text-wrap">
                            {{$user[$head]}}
                        </x-table.cell>
                    @endforeach
                    <x-table.cell>
                        @if($user['status'])
                        <flux:badge color="green" wire:click="ubahStatus({{$user['id']}})" class="cursor-pointer">Aktif</flux:badge>
                        @else
                        <flux:badge color="red" wire:click="ubahStatus({{$user['id']}})" class="cursor-pointer">Tidak Aktif</flux:badge>
                        @endif
                    </x-table.cell>
                    <x-table.cell>
                        <flux:button size="sm" icon="eye" href="{{ route('user.detail',['role'=>$role,'code'=>vinclaEncode($user['id'])]) }}"/>
                    </x-table.cell>
                </x-table.row>
            @empty
                <x-table.row>
                    <x-table.cell colspan="{{count($headings)+3}}">
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

{{--     <x-user.list-data :users="$users"/>--}}



</div>
