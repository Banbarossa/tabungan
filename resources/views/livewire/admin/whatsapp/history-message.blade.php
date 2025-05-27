<div>
    <x-slot:breadcrumbs>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Riwayat Pesan</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </x-slot:breadcrumbs>

    <ul class="space-y-4 max-w-md">
        @forelse ($messages as $item)
            <li>
                <div class="flex items-start gap-2.5">
                    <div class="w-8 h-8 rounded-full">
                        <flux:icon.chat-bubble-left-ellipsis class="text-green-700 size-8"/>
                    </div>
                    <div class="flex flex-col w-full leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark:bg-gray-700">
                        <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                            <div class="items-center space-x-2 rtl:space-x-reverse" >
                                <span class="text-sm font-normal text-gray-500 dark:text-gray-800">{{ \Carbon\carbon::parse($item['created_at'])->toTimeString() }}</span>
                            </div>
                            <div  class="text-sm font-normal text-gray-500 dark:text-gray-800">{{ $item['target'] }}</div>
                        </div>
                        <flux:separator text="Message"/>
                        <pre class="text-sm font-normal py-2.5 text-gray-500 dark:text-white leading-none text-wrap mt-2">{!! nl2br(e($item['message'])) !!}</pre>
                        <div class="text-sm font-normal text-teal-500 dark:text-gray-400 text-end">{{ $item['state'] }}</div>
                    </div>
                </div>

            </li>
        @empty
            <li class="p-4 text-xs text-gray-400">
                Belum ada riwayat pesan
            </li>
        @endforelse
    </ul>
</div>
