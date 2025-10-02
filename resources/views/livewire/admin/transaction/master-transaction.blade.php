<section
    x-data="{
            saldo:true,
            nama_ibu:false
    }">



    <div class="flex items-center mb-6 gap-4">
        <div>
            <flux:input  icon="magnifying-glass" placeholder="Search..." wire:model.live='search'/>
        </div>

        <flux:dropdown>
            <flux:button icon:trailing="eye"></flux:button>

            <flux:menu>
                <flux:menu.item>
                    <flux:checkbox.group  label="Shown Table">
                        <flux:checkbox label="Saldo" x-model='saldo'/>
                        <flux:checkbox label="Nama Ibu" x-model='nama_ibu'/>
                    </flux:checkbox.group>
                </flux:menu.item>


            </flux:menu>
        </flux:dropdown>


    </div>


    <div class="rounded-lg p-4 border max-w-lg">
        <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700">
            @foreach ($students as $item)
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
        </ul>
        <div class="my-2 px-4">
            {{ $students->links() }}
        </div>
    </div>


</section>
