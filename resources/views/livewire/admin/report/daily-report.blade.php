<div>
    <x-slot:breadcrumbs>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Laporan Harian</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </x-slot:breadcrumbs>
    <div class="rounded-lg border overflow-hidden">

        <div class="relative overflow-x-auto w-full">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <tbody>
                    @foreach($summary as $total)
                        <tr class="bg-gray-300 border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $total['user_name'] }} <br>
                            </th>
                            <th scope="row" class="text-end px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ format_rupiah($total['total_amount']) }}
                            </th>
                        </tr>
                        @foreach($total['transactions'] as $tr)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                <td class="px-6 py-2">{{$tr->student ? $tr->student->name :''}}</td>
                                <td class="text-end px-6 py-2">{{format_rupiah($tr->amount)}}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
