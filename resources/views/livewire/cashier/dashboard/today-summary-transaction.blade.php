
<div class="relative aspect-video overflow-hidden rounded-xl bg-gradient-to-r from-zinc-600 to-orange-800 shadow-sm border border-neutral-200 dark:border-neutral-700">
    <img src="{{ asset('images/atm.png') }}" alt="atm" class="max-h-32 absolute right-0 bottom-0 z-0 opacity-30">
    <div class="p-6 z-50">
        <flux:text class="text-xs text-gray-50">Penarikan Hari Ini</flux:text>
        <flux:heading size="xl" class="mb-2 text-gray-50">{{ format_rupiah($summary) }}</flux:heading>

        <flux:separator/>
        <flux:button icon="plus" href="{{ route('cashier.transaction') }}" variant="primary" class="mt-4 lg:hidden">New Transaction</flux:button>
    </div>
</div>
