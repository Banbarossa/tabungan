<div>

    <x-toast on="data-updated"></x-toast>



    <form action="" wire:submit.prevent="save">
        <div class="border rounded-lg border-neutral-300 p-6 mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-2">
                <div>
                    <flux:input
                        wire:model="token_wa"
                        :label="__('Token Fontee')"
                        type="password"

                        :placeholder="__('token_fonte')"
                        viewable
                    />
                </div>
                <div>
                    <ul>
                        @if ($deviceStatus)
                            <li>Device : {{ $deviceStatus->device }}</li>
                            <li>Status : {{ $deviceStatus->device_status }}</li>
                            <li>Expired : {{ $deviceStatus->expired }}</li>
                            <li>Messages : {{ $deviceStatus->messages }}</li>
                            <li>Package : {{ $deviceStatus->package }}</li>
                            <li>Quota : {{ $deviceStatus->quota }}</li>
                        @else
                            <li><span class="text-red-600">Whatsapp tidak terkoneksi dengan</span> <a href="https://fonnte.com" target="_blank" rel="noopener noreferrer"><strong>FONTEE</strong></a></li>
                        @endif
                    </ul>
                </div>
            </div>

        </div>

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
