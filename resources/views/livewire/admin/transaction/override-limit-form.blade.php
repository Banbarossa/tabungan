<div>
    <form wire:submit.prevent="save">
        <div class="max-w-sm space-y-6">
            <flux:select name="user_id" wire:model="user_id" label="Pilih Petugas">
                <flux:select.option>Pilih Petugas</flux:select.option>
                @foreach($petugas as $p)
                    <flux:select.option value="{{$p->id}}">{{$p->name}}</flux:select.option>
                @endforeach
            </flux:select>

            <div >
                <flux:input.group>
                    <flux:input.group.prefix>Rp</flux:input.group.prefix>
                    <flux:input x-mask:dynamic="$money($input, ',', '.')" wire:model="limit"/>
                </flux:input.group>
                <flux:error name="limit"/>

            </div>

            <flux:button variant="primary" type="submit">Simpan</flux:button>
        </div>
    </form>
</div>
