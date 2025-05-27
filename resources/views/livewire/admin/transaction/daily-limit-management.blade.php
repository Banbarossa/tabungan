<div >


    {{-- The Master doesn't talk, he acts. --}}
    <div class="max-w-lg border dark:border-zinc-600 p-4 rounded-lg bg-zinc-50 dark:bg-zinc-800">

        <form action="" wire:submit.prevent='save'>
            <ul class="space-y-4 mt-6">
                <flux:field>
                    <flux:label class="mb-0">Minggu</flux:label>
                    <flux:input icon="banknotes" x-mask:dynamic="$money($input, ',', '.')" wire:model="minggu"/>
                    <flux:error name="minggu" />
                </flux:field>
                <flux:field>
                    <flux:label class="mb-0">Senin</flux:label>
                    <flux:input icon="banknotes" x-mask:dynamic="$money($input, ',', '.')" wire:model="senin"/>
                    <flux:error class="mt-0" name="senin" />
                </flux:field>
                <flux:field>
                    <flux:label class="mb-0">Selasa</flux:label>
                    <flux:input icon="banknotes" x-mask:dynamic="$money($input, ',', '.')" wire:model="selasa"/>
                    <flux:error class="mt-0" name="selasa" />
                </flux:field>
                <flux:field>
                    <flux:label class="mb-0">Rabu</flux:label>
                    <flux:input icon="banknotes" x-mask:dynamic="$money($input, ',', '.')" wire:model="rabu"/>
                    <flux:error class="mt-0" name="rabu" />
                </flux:field>
                <flux:field>
                    <flux:label class="mb-0">Kamis</flux:label>
                    <flux:input icon="banknotes" x-mask:dynamic="$money($input, ',', '.')" wire:model="kamis"/>
                    <flux:error class="mt-0" name="kamis" />
                </flux:field>
                <flux:field>
                    <flux:label class="mb-0">Jumat</flux:label>
                    <flux:input icon="banknotes" x-mask:dynamic="$money($input, ',', '.')" wire:model="jumat"/>
                    <flux:error class="mt-0" name="jumat" />
                </flux:field>
                <flux:field>
                    <flux:label class="mb-0">Sabtu</flux:label>
                    <flux:input icon="banknotes" x-mask:dynamic="$money($input, ',', '.')" wire:model="sabtu"/>
                    <flux:error class="mt-0" name="sabtu" />
                </flux:field>

            </ul>
             <div class="flex items-center justify-end mt-6">
                <flux:button type="submit" variant="primary" class="w-full">
                    Simpan
                </flux:button>
            </div>
        </form>

    </div>
</div>
