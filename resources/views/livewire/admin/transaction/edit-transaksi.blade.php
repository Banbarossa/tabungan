<div>


    <form wire:submit.prevent="save">
        <div class="space-y-6 max-w-md">
            <flux:input type="date" name="date" wire:model="date" label="Tanggal"></flux:input>
            <flux:select name="jenis_transaksi_id" wire:model="jenis_transaksi_id" label="Metode" placeholder="Pilih Metode">
                @foreach($jenis as $je)
                <flux:select.option value="{{$je->id}}">{{$je->nama}}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:textarea rows="3" name="description" wire:model="description" label="Description"></flux:textarea>
            <flux:textarea rows="3" name="updated_reason" wire:model="updated_reason" label="Alasan Perubahan"></flux:textarea>
            <flux:button type="submit" variant="primary" >Simpan Perubahan?</flux:button>
        </div>


    </form>
</div>
