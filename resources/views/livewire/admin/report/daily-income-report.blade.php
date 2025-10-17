<div>
    <x-toast on='data-updated'></x-toast>
    <x-slot:breadcrumbs>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Laporan Harian</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </x-slot:breadcrumbs>

    <div class="mb-4 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div class="flex gap-4 ">
            <flux:icon.calendar-days class="size-12"/>
            <div>
                <flux:text>Tanggal Transaksi</flux:text>
                <flux:heading size="xl">{{\Carbon\Carbon::parse($date)->format('d/m/Y')}}</flux:heading>
            </div>
        </div>
        <div class="flex items-center gap-4">

            <flux:button icon="table-cells" wire:click='downloadExcel'>Unduh Excel</flux:button>
        </div>
    </div>




    <div class="rounded-lg border border-gray-200 dark:border-zinc-600 overflow-hidden">

        <div class="relative overflow-x-auto w-full">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-300">
                <tbody>
                    @foreach($summary as $total)
                        <tr class="bg-gray-300  dark:bg-zinc-900 ">
                            <th scope="row" colspan="2" class="border border-gray-200 dark:border-zinc-600 px-6 py-2 uppercase font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $total['user_name'] }}
                            </th>
                            <th scope="row"  class="border border-gray-200 dark:border-zinc-600 uppercase px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Waktu Transaksi
                            </th>
                            <th scope="row"  class="border border-gray-200 dark:border-zinc-600 uppercase px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Metode
                            </th>
                            <th scope="row" class="border border-gray-200 dark:border-zinc-600 text-end px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ format_rupiah($total['total_amount']) }}
                            </th>
                            <th scope="row" class="border border-gray-200 dark:border-zinc-600 text-end px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Keterangan
                            </th>
                            {{-- <th scope="row" class="border border-gray-200 dark:border-zinc-600 text-end px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Diverifikasi Oleh
                            </th> --}}
                        </tr>
                        @foreach($total['transactions'] as $index=>$tr)
                            <tr class="bg-white dark:bg-zinc-800 dark:border-gray-700 ">
                                <td class="border border-gray-200 dark:border-zinc-600 px-4 py-2 w-6 text-center">{{$index +1}}</td>
                                <td class="border border-gray-200 dark:border-zinc-600 px-6 py-2">{{$tr->student ? $tr->student->name :''}}</td>
                                <td class="border border-gray-200 dark:border-zinc-600 px-6 py-2 w-auto">{{$tr->date}}</td>
                                <td class="border border-gray-200 dark:border-zinc-600 px-6 py-2 w-auto">{{$tr->metode?->nama}}</td>
                                <td class="border border-gray-200 dark:border-zinc-600 text-end px-6 py-2">{{format_rupiah($tr->amount)}}</td>
                                <td class="border border-gray-200 dark:border-zinc-600 px-6 py-2">{{$tr->description}}</td>
                                {{-- <td class="border border-gray-200 dark:border-zinc-600 text-end px-6 py-2">{{$tr->verifiedByUser ? $tr->verifiedByUser->name :'Belum Verikasi'}}</td> --}}
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
