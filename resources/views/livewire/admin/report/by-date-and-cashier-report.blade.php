<div>


    <x-slot:breadcrumbs>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Laporan Harian</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </x-slot:breadcrumbs>


    <flux:heading size="xl">{{format_rupiah($sum)}}</flux:heading>



    <div class="w-full rounded-lg overflow-hidden border border-zinc-300">
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
                        <th scope="col" class="px-6 py-3">
                            Cashier
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Jumlah
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="w-4 p-4">
                                <div class="flex items-center">
                                    <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                </div>
                            </td>
                            <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                <div class="ps-3">
                                    <div class="text-base font-semibold">{{$item->student->name}}</div>
                                    <div class="font-normal text-gray-500">{{ Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i')}}</div>
                                </div>
                            </th>
                            <td class="px-6 py-4">
                                {{ $item->handledbyUser ? $item->handledbyUser->name :'' }}
                            </td>
                            <td class="px-6 py-4" >
                                 {{ format_rupiah($item->amount) }}
                            </td>
                        </tr>

                    @empty

                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
