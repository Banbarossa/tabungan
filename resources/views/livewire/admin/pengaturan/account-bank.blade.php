<div>
    <div class="border-2 rounded-lg bg-white p-6 space-y-6">
        <div>
            <div class="flex items-start gap-4 mb-4">
                <!-- Icon Container -->
                <div
                    class="rounded-xl flex justify-center items-center p-3 shadow-sm bg-green-100 dark:bg-green-950/50 shrink-0">
                    <flux:icon.credit-card class="size-6 text-green-700 dark:text-green-400" />
                </div>

                <!-- Text Container -->
                <div>
                    <h2 class="text-lg sm:text-xl font-semibold tracking-wide" level="2">Pengaturan Akun Bank</h2>
                    <flux:text size="sm" class="mt-1 text-slate-500">
                        Atur rekening bank tujuan pembayaran atau penerimaan dana jajan.
                    </flux:text>
                </div>
            </div>
            <flux:separator />
        </div>
        <form action="" wire:submit.prevent="save" class="">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach ($keys as $k)
                    <flux:input type="text" wire:model="inputs.{{ $k['key'] }}" label="{{ $k['label'] }}" />
                @endforeach
            </div>
            <flux:button variant="primary" type="submit" class="w-full mt-8 mb-8">Simpan</flux:button>
        </form>
    </div>
</div>
