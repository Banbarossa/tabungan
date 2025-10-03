<div>
    <div class="rounded-lg border mb-4 border-zinc-300 mt-5" x-data="{riwayat:true}">
        <button class="p-4 flex gap-4 flex-wrap  w-full item->center" x-on:click="riwayat = !riwayat">
            <flux:heading size="lg">
                Perubahan Data
            </flux:heading>
            <flux:spacer/>
            <flux:icon.arrow-right class="size-4" x-bind:class="{ 'rotate-90': riwayat }"></flux:icon.arrow-right>
        </button>
        <div x-cloak x-show="riwayat" x-transition>
            <flux:separator/>
            <div class="p-6">
                <livewire:admin.transaction.edit-transaksi :transaction="$transaction"/>
            </div>
        </div>
    </div>
</div>
