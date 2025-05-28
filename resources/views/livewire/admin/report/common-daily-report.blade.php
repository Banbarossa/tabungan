<div>
    <x-toast on='data-updated'></x-toast>
    <x-slot:breadcrumbs>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('calendar') }}">Calendar</flux:breadcrumbs.item>
            <flux:breadcrumbs.item >Laporan</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </x-slot:breadcrumbs>

    <div class="flex items-center gap-4 my-4 justify-end">
        <flux:button icon="table-cells" variant="primary" wire:click="downloadExcel">Download Excel</flux:button>
    </div>

    <div class="w-full rounded-lg overflow-hidden border border-zinc-300 dark:border-zinc-600">
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class=" text-gray-700 uppercase bg-zinc-200 dark:bg-zinc-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-3 w-4 text-center">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Cashier
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Setor
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Tarik
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Saldo
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @forelse ($transactions as $item)
                        <tr class="bg-white border-b dark:bg-zinc-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-4 py-2  text-center">
                                {{ $no++ }}
                            </td>
                            <td scope="row" class="flex items-center px-6 py-2 text-gray-900 whitespace-nowrap dark:text-white">
                                <div class="ps-3">
                                    <div class="font-semibold">{{$item->student->name}}</div>
                                    <div class="font-normal text-gray-500 text-xs">{{ Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i')}}</div>
                                </div>
                            </td>
                            <td class="px-6 py-2">
                                {{ $item->handledbyUser ? ucWords($item->handledbyUser->name) :'' }}
                            </td>
                            <td class="px-6 py-2" >
                                @if ($item->type == 'setor')
                                {{ format_rupiah($item->amount) }}
                                @else
                                -
                                @endif
                            </td>
                            <td class="px-6 py-2" >
                                 @if ($item->type != 'setor')
                                {{ format_rupiah($item->amount) }}
                                @else
                                -
                                @endif
                            </td>
                            <td class="px-6 py-2" >
                                 {{ format_rupiah($item->latest_saldo)}}
                            </td>
                        </tr>

                    @empty

                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


</div>
