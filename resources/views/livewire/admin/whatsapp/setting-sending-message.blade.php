<div>

    <x-toast on="data-updated"></x-toast>
    <x-slot:breadcrumbs>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Setting Pesan</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </x-slot:breadcrumbs>


    <form action="" wire:submit.prevent="save">

        <div>
            <div class="text-end">
                <flux:button type="submit" icon="check" variant="primary" class="ms-auto">Simpan</flux:button>

            </div>
            <div class="grid lg:grid-cols-2 gap-4">
                <div>
                    <flux:radio.group wire:model="send_when_setor" label="Kirim Pesan Ketika Setor" class="mb-3">
                        <flux:radio value="1" label="Ya"/>
                        <flux:radio value="0" label="Tidak" />
                    </flux:radio.group>

                    <flux:textarea wire:model="template_setor"
                        rows="25"
                    />
                </div>

                <div>
                    <flux:radio.group wire:model="send_when_tarik" label="Kirim Pesan Ketika Penarikan" class="mb-3">
                        <flux:radio value="1" label="Ya"/>
                        <flux:radio value="0" label="Tidak" />
                    </flux:radio.group>
                    <flux:textarea wire:model="template_tarik"
                        rows="25"
                    />
                </div>
            </div>

        </div>

    </form>
</div>
