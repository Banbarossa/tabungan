<section
    x-data="{
            saldo:false,
            nama_ibu:false
    }">
    <x-slot:breadcrumbs>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('account.') }}">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('account.') }}">Account</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Account Create</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </x-slot:breadcrumbs>


    <div class="flex items-center mb-6 gap-4">
        <div>
            <flux:button variant="primary" icon="plus" wire:navigate :href="route('account.create')">Tambah Data</flux:button>
        </div>
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

    <div
        class="w-full rounded-lg overflow-hidden border border-zinc-300"
    >
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-zinc-200 dark:bg-zinc-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-all-search" class="sr-only">checkbox</label>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3" x-show='saldo'>
                            Saldo
                        </th>
                        <th scope="col" class="px-6 py-3" x-show='nama_ibu'>
                            Nama Ibu
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Position
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="w-4 p-4">
                                <div class="flex items-center">
                                    <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                </div>
                            </td>
                            <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                {{-- <img class="w-10 h-10 rounded-full" src="/docs/images/people/profile-picture-1.jpg" alt="Jese image"> --}}
                                <div class="ps-3">
                                    <div class="text-base font-semibold">{{$item->name}}</div>
                                    <div class="font-normal text-gray-500">{{$item->nisn}}</div>
                                </div>
                            </th>
                            <td class="px-6 py-4" x-show='saldo'>
                                {{ $item->saldo }}
                            </td>
                            <td class="px-6 py-4" x-show='nama_ibu'>
                                {{ $item->nama_ibu }}
                            </td>
                            <td class="px-6 py-4">
                                React Developer
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div> Online
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('account.edit',vinclaEncode($item->id)) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit user</a>
                            </td>
                        </tr>

                    @empty

                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="my-2 px-4">
            {{ $students->links() }}

        </div>
    </div>
</section>
