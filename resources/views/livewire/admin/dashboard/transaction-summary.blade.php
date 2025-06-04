<div class="p-3">
    <flux:heading size="lg">Transaction Summary</flux:heading>
    <flux:separator/>
    <div class="relative overflow-x-auto mt-4">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-zinc-800 dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-3">
                        Tanggal
                    </th>
                    <th scope="col" class="py-3">
                        Jumlah
                    </th>
                    <th scope="col" class="py-3">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($summary as $date => $users)
                    <tr class="border-t border-gray-300 dark:border-zinc-500">
                        <th colspan="3" class="pt-2">
                            <flux:link
                                href="{{ route('report.daily',$date) }}"
                                color="blue"
                                class="text-blue-500 dark:text-blue-200"
                                >
                                {{ Carbon\Carbon::parse($date)->format('d/m/Y') }}
                            </flux:link>
                            {{-- <a href="{{ route('report.daily',$date) }}">{{ $date }}</a> --}}
                        </th>
                    </tr>
                    @foreach ($users as $user)
                        @if ($user['total']>0)
                            <tr>
                                <td class="ps-3">{{ $user['name'] }}</td>
                                <td class="py-1.5">{{ format_rupiah($user['total']) }}</td>
                                <td class="py-1.5">
                                    @if ($user['id'])

                                    <flux:button
                                        variant="ghost"
                                        size="sm"
                                        href="{{ route('report.by-date-user',['date'=>$date,'user_code'=>vinclaEncode($user['id'])]) }}">
                                        <flux:icon.document-check class="size-4"/>
                                    </flux:button>
                                    @endif
                                </td>
                            </tr >
                        @endif
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>


</div>
