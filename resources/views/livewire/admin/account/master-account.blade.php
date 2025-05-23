<section
    x-data="{
            saldo:false,
            nama_ibu:true,
            send_notification:true,
            notification_target:true,
            notification_account:true,
    }">
    <x-slot:breadcrumbs>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('account.') }}">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Account</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </x-slot:breadcrumbs>


    <div class="flex items-center mb-6 gap-4">
        <div class="fixed bottom-12 right-2 z-50 lg:static lg:bottom-auto lg:right-auto lg:z-auto">
            <flux:button variant="primary" icon="plus" wire:navigate :href="route('account.create')">
                <span class="hidden lg:inline">Tambah Data</span>
            </flux:button>
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
                        <flux:checkbox label="Kirim Notif" x-model='send_notification'/>
                        <flux:checkbox label="Kirim Via" x-model='notification_target'/>
                        <flux:checkbox label="No Contact" x-model='notification_account'/>
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
                        <th scope="col" class="px-6 py-3" x-show="nama_ibu">
                            Nama Ibu
                        </th>
                        <th scope="col" class="px-6 py-3" x-show="nama_ibu">
                            Kirim Notif
                        </th>
                        <th scope="col" class="px-6 py-3" x-show="notification_target">
                            Pesan Via
                        </th>
                        <th scope="col" class="px-6 py-3" x-show="notification_account">
                            Pesan Via
                        </th>
                        <th scope="col" class="px-6 py-3" x-show="saldo">
                            Saldo
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
                                <div class="ps-3">
                                    <div class="text-base font-semibold">{{$item->name}}</div>
                                    <div class="font-normal text-gray-500">{{$item->no_id}}</div>
                                </div>
                            </th>
                            <td class="px-6 py-4" x-show="nama_ibu">
                                {{ $item->nama_ibu }}
                            </td>
                            <td class="px-6 py-4" x-show="nama_ibu">
                                 <flux:switch  :checked="$item->send_notification ? true :false" disabled/>
                            </td>
                            <td class="px-6 py-4" x-show="notification_target">
                                 {{ ucWords($item->notification_target) }}
                            </td>
                            <td class="px-6 py-4" x-show="notification_account">
                                 {{ ucWords($item->notification_account) }}
                            </td>
                            <td class="px-6 py-4 font-semibold" x-show="saldo" >
                                {{ format_rupiah($item->saldo) }}
                            </td>
                            <td class="px-6 py-4">
                                <flux:button icon='pencil-square' variant="ghost" href="{{ route('account.edit',vinclaEncode($item->id)) }}"></flux:button>
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
