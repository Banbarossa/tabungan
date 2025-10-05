<div>
    <form action="" wire:submit="kirimPesan">
        <div class="space-y-6">
            <flux:input type="text" name="phone_number" wire:model="phone_number"/>
            <flux:textarea rows="3" name="message" wire:model="message"/>
            <flux:button type="submit">Simpan</flux:button>
        </div>
    </form>
</div>
