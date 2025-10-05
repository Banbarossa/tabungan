<div class="flex gap-6">
    <div class="border rounded-lg border-neutral-500 p-4 max-w-[18rem]">
        <form wire:submit="filterData">
                <div class="space-y-6">
                    <flux:input type="date" label="Tanggal Mulai" wire:model="start_date" name="start_date"/>
                    <flux:input type="date" label="Tanggal Akhir" wire:model="end_date" name="end_date"/>
                    <flux:select wire:model="user_id" name="user_id" label="Petugas" >
                        <flux:select.option value="" label="Pilih Petugas"/>
                        @foreach($users as $user)
                        <flux:select.option value="{{$user->id}}" label="{{$user->name}}"/>
                        @endforeach
                    </flux:select>

                    <flux:checkbox.group wire:model="metode" label="Metode Pembayaran">
                        @foreach($jenis as $j)
                            <flux:checkbox label="{{$j->nama}}" value="{{$j->id}}"/>
                        @endforeach
                    </flux:checkbox.group>
                    <flux:button type="submit" class="w-full" variant="primary">Tampilkan</flux:button>
                </div>

        </form>
    </div>

    <div class="flex-1 rounded-lg overflow-hidden border border-neutral-500">
        <iframe
            src="{{ route('laporan.filter.pdf', [
                'start_date' => $start_date,
                'end_date'   => $end_date,
                'user_id'    => $user_id,
                'metode'     => implode(',', $metode),
            ]) }}"
            width="100%" height="600px"></iframe>
    </div>
</div>
