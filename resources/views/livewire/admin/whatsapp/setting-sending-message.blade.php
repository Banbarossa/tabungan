<div>



    <form action="" wire:submit.prevent="save">
        <div class="border rounded-lg border-neutral-300 p-6 mb-6">
            <div class="mb-6">
                <flux:input
                    wire:model="token_wa"
                    :label="__('Token Fontee')"
                    type="password"

                    :placeholder="__('Token Fontee')"
                    viewable
                />
            </div>

            <div>
                @if($deviceStatus && $deviceStatus->status)

                <flux:callout icon="check-badge" color="green" class="mb-6">
                    <flux:callout.heading>Whatsapp Terhubung</flux:callout.heading>
                    <flux:callout.text>
                        <ul>
                            <li>Device : {{ $deviceStatus->device }}</li>
                            <li>Status : {{ $deviceStatus->device_status }}</li>
                            <li>Expired : {{ $deviceStatus->expired }}</li>
                            <li>Messages : {{ $deviceStatus->messages }}</li>
                            <li>Package : {{ $deviceStatus->package }}</li>
                            <li>Quota : {{ $deviceStatus->quota }}</li>
                        </ul>
                    </flux:callout.text>
                </flux:callout>
                @else
                    <flux:callout icon="x-circle" color="red" class="mb-6">
                        <flux:callout.heading>Opps,</flux:callout.heading>
                        <flux:callout.text>
                            Whatsapp Tidak Terhubung silahkan cek fontee
                        </flux:callout.text>
                    </flux:callout>
                @endif
            </div>

            <div>

                <div class="grid lg:grid-cols-2 gap-4">
                    <div>
                        <flux:radio.group wire:model="send_when_setor" label="Kirim Pesan Ketika Setor" class="mb-3">
                            <flux:radio value="1" label="Ya"/>
                            <flux:radio value="0" label="Tidak"/>
                        </flux:radio.group>

                        <flux:textarea wire:model="template_setor"
                                       rows="25" label="Format Pesan"
                        />
                    </div>

                    <div>
                        <flux:radio.group wire:model="send_when_tarik" label="Kirim Pesan Ketika Penarikan"
                                          class="mb-3">
                            <flux:radio value="1" label="Ya"/>
                            <flux:radio value="0" label="Tidak"/>
                        </flux:radio.group>
                        <flux:textarea wire:model="template_tarik"
                                       rows="25" label="Format Pesan"
                        />
                    </div>
                </div>

            </div>
        </div>

        <div class="text-end">
            <flux:button type="submit" icon="check" variant="primary" class="ms-auto">Simpan</flux:button>

        </div>

    </form>


</div>
