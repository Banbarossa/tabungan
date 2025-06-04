<div class="relative min-h-72 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
    <div>
        <flux:heading size="lg" class="">Riwayat</flux:heading>
        <flux:separator/>
        <ul class=" space-y-2 divide-gray-200 dark:divide-gray-700 mt-2">
            @forelse ($history as $item)
            <li class="border-b  border-neutral-200 dark:border-neutral-700 pb-2">
                <div class="flex items-center space-x-4 rtl:space-x-reverse">
                    <div class="shrink-0">
                        <div class="w-8 h-8 rounded-full {{  $item->type =='setor' ?'bg-green-400/70' :'bg-red-400/70' }} flex items-center justify-center" >
                            <flux:icon.inbox-arrow-down class="size-4 text-zinc-50"></flux:icon.inbox-arrow-down>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                        {{ $item->student ? $item->student->name :'' }}
                        </p>
                        <p class="text-xs text-gray-500 truncate dark:text-gray-400">
                            {{ \Carbon\Carbon::parse($item->create_at)->format('d/m/Y H:i') }}
                        </p>
                    </div>
                    <div class="inline-flex items-center text-base font-semibold  {{  $item->type =='setor' ?'text-green-700 dark:text-green-200' :'text-gray-900 dark:text-white' }} ">
                        {{ $item->type =='setor' ?'+':'-' }}{{ format_rupiah($item->amount) }}
                    </div>
                </div>
            </li>
            @empty
            <li class="mt-2">
                <div class="flex items-center space-x-4 rtl:space-x-reverse">
                    <div class="shrink-0">
                        <div class="w-8 h-8 rounded-full bg-red-400/70 flex items-center justify-center" >
                            <flux:icon.information-circle class="size-4 text-red-50 dark:text-red-50"></flux:icon.information-circle>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0 text-gray-500 truncate dark:text-gray-400text-sm">
                        Belum Ada Riwayat Transaksi
                    </div>
                </div>
            </li>

            @endforelse
        </ul>
    </div>
</div>
