<div>
    <x-toast on='data-updated'></x-toast>
    <x-slot:breadcrumbs>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Laporan Harian</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </x-slot:breadcrumbs>

    <div class="grid lg:grid-cols-3 gap-4">
        <div class="flex gap-4 ">
            <flux:icon.calendar-days class="size-12"/>
            <div>
                <flux:text>Tanggal Transaksi</flux:text>
                <flux:heading size="xl">{{\Carbon\Carbon::parse($date)->format('d/m/Y')}}</flux:heading>
            </div>
        </div>
        <div class="flex gap-4 ">
            <flux:icon.banknotes class="size-12"/>
            <div>
                <flux:text>Jumlah Transaksi</flux:text>
                <flux:heading size="xl">{{format_rupiah($sum)}}</flux:heading>
            </div>
        </div>
        <div class="flex gap-4 ">
            <flux:icon.user class="size-12"/>
            <div>
                <flux:text>Cashier</flux:text>
                <flux:heading size="xl">{{$user_name}}</flux:heading>
            </div>
        </div>
    </div>
    <flux:separator></flux:separator>

    <div class="flex items-center gap-4 my-4">

        <flux:button icon="check-badge" variant="primary" wire:click="verification">Verifikasi Semua</flux:button>
        <flux:dropdown>
            <flux:button icon:trailing="chevron-down" icon="cloud-arrow-down">Download</flux:button>

            <flux:menu>
                <flux:menu.item
                    icon="document-duplicate"
                    href="{{ route('report.cashier.pdf',['date'=>$date,'user_code'=>vinclaEncode($user_id)]) }}"
                    target="blank">
                    PDF
                </flux:menu.item>
                <flux:menu.item icon="table-cells" wire:click='downloadExcel'>Excel</flux:menu.item>
            </flux:menu>
        </flux:dropdown>
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
                            Jumlah
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Diverifikasi Oleh
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @forelse ($transactions as $item)
                        <tr class="bg-white border-b dark:bg-zinc-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-zinc-600">
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
                                {{ $item->handledbyUser ? $item->handledbyUser->name :'' }}
                            </td>
                            <td class="px-6 py-2" >
                                 {{ format_rupiah($item->amount) }}
                            </td>
                            <td class="px-6 py-2" >
                                 {{ $item->verifiedByUser ? $item->verifiedByUser->name :'Belum Verikasi' }}
                            </td>
                        </tr>

                    @empty

                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
