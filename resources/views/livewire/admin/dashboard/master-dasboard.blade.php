<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="grid auto-rows-min gap-4 md:grid-cols-4">

        <livewire:admin.dashboard.today-limit/>
        <livewire:admin.dashboard.total-saldo/>
        <livewire:admin.dashboard.total-withdraw-today/>

        <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>
    <div class="grid lg:grid-cols-3 gap-4">
        <div>
            <div class="relative  flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <livewire:admin.dashboard.latest-transaction/>
            </div>
        </div>
        <div class="lg:col-span-2">
            <div class=" relative  flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <livewire:admin.dashboard.transaction-summary/>
            </div>
        </div>
    </div>
</div>
