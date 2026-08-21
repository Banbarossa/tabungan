<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="grid auto-rows-min gap-4 md:grid-cols-4">

        <livewire:admin.dashboard.today-limit />
        <livewire:admin.dashboard.total-saldo />
        <livewire:admin.dashboard.total-withdraw-today />
        <div
            class="aspect-video overflow-hidden rounded-xl grad-tahfidz shadow-sm border border-neutral-200 dark:border-neutral-700">

            <div class="p-6">
                <flux:icon.cloud-arrow-up class="text-white size-10 mb-2 z-50" />
                <flux:text class="text-white">
                    Topup Belum Verifikasi
                </flux:text>
                <flux:heading size="xl" class="text-white">{{ $pending_topup }}</flux:text>
            </div>
        </div>

    </div>
    <div class="grid lg:grid-cols-3 gap-4">
        <div>
            <div class="relative  flex-1 overflow-hidden rounded-lg bg-white border-2 border-neutral-200 dark:border-neutral-700">
                <livewire:admin.dashboard.latest-transaction />
            </div>
        </div>
        <div class="lg:col-span-2">
            <div class=" relative  flex-1 overflow-hidden bg-white rounded-xl border-2 border-neutral-200 dark:border-neutral-700 p-6">
                <livewire:admin.dashboard.transaction-summary />
            </div>
        </div>
    </div>
</div>
