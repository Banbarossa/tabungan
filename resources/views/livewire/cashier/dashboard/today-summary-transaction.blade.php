<div class="relative aspect-video overflow-hidden rounded-xl bg-amber-100/80 border border-neutral-200 dark:border-neutral-700 flex items-center justify-center">
    <div class="flex flex-col items-center">
        <flux:text class="text-xs">Penarikan Hari Ini</flux:text>
        <flux:heading size="xl" class="mb-2">{{ format_rupiah($summary) }}</flux:heading>


        <flux:separator/>
        <flux:button icon="plus" href="{{ route('cashier.transaction') }}" variant="primary" class="mt-4">New Transaction</flux:button>

    </div>
</div>
