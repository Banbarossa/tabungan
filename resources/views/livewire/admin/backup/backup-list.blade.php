<div>

    <flux:button wire:click="runBackup" variant="primary" class="mb-2">
        Buat Backup
    </flux:button>
    <flux:separator class="mb-6"/>
    <div class="border  rounded-lg p-6 border-neutral-400">


    <ul class="space-y-4 divide-y">
        @forelse($files as $file)
            <li class="mb-2 flex justify-between py-1">
                <span>{{ basename($file) }}</span>
                <div>
                <flux:button icon="cloud-arrow-down" wire:click="download('{{ $file }}')" variant="primary" color="green" size="sm"></flux:button>
                <flux:button icon="trash" wire:click="delete('{{ $file }}')" variant="primary" color="red" size="sm"></flux:button>

                </div>

            </li>
        @empty
            <li>
                Tidak ada file backup
            </li>
        @endforelse
    </ul>
    </div>
</div>
