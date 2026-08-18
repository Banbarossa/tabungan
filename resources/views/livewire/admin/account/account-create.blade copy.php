<div>

    <div class=" p-6 bg-white rounded-lg border-2 shadow">

        <div class="relative h-full flex-1">
            <form action="" wire:submit='save'>
                <flux:separator text="Identitas Nasabah" />
                <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus class="mb-4"
                    autocomplete="name" :placeholder="__('Full name')" />
                <div class="grid grid-cols-2 gap-2">
                    <flux:input wire:model="nama_ayah" :label="__('Nama Ayah')" type="text" class="mb-4"
                        :placeholder="__('Nama Ayah')" />
                    <flux:input wire:model="nama_ibu" :label="__('Nama Ibu')" type="text" class="mb-4"
                        :placeholder="__('Nama Ibu')" />
                </div>


                <div class="grid grid-cols-2 gap-2">
                    <flux:input wire:model="nisn" :label="__('NISN')" type="number" class="mb-4"
                        :placeholder="__('NISN')" />
                    <flux:input wire:model="nis" :label="__('NIS')" type="number" class="mb-4"
                        :placeholder="__('NIS')" />
                </div>

                {{-- <div class="my-5">
                    <flux:separator text="Daily Limit" />
                </div>

                <flux:input.group >
                    <flux:input.group.prefix>Rp</flux:input.group.prefix>
                    <flux:input x-mask:dynamic="$money($input, ',', '.')" wire:model="daily_limit"  />
                </flux:input.group>
                <flux:error name="daily_limit" /> --}}

                {{-- <div class="my-5">
                    <flux:separator text="Notification" />
                </div>

                <div class="my-4">
                    <flux:radio.group wire:model="send_notification" label="Apakah Transaksi akan dikirim notifikasi" >
                        <flux:radio value="1" label="Kirim" />
                        <flux:radio value="0" label="Tidak Kirim" />
                    </flux:radio.group>
                </div>

                <div class="mb-4">
                    <flux:radio.group wire:model="notification_target" label="Notifikasi Dikirim Via" >
                        <flux:radio value="whatsapp" label="Whatsaap" />
                        <flux:radio value="email" label="email" />
                    </flux:radio.group>
                </div> --}}
                <flux:input wire:model="no_hp_ayah" :label="__('No Hp Ayah')" type="text" class="mb-4"
                    :placeholder="__('No HP Ayah')" />

                <flux:input wire:model="notification_account" :label="__('No Ibu')" type="text" class="mb-4"
                    :placeholder="__('No Ibu')" />
                <flux:select wire:model="kelas" :label="__('Kelas')" class="mb-4"
                    :placeholder="__('Pilih Kelas')">
                    @foreach ($daftar_kelas as $ke)
                        <flux:select.option value="{{ $ke }}">Kelas {{ $ke }}</flux:select.option>
                    @endforeach
                </flux:select>
                @if ($student)
                    <div class="my-5">
                        <flux:separator text="Status Keaktifan" />
                    </div>

                    <div class="my-4">
                        <flux:radio.group wire:model="send_notification" label="Apakah Santri Ini masih Aktif Balajar">
                            <flux:radio value="1" label="Aktif" />
                            <flux:radio value="0" label="Tidak Aktif" />
                        </flux:radio.group>
                    </div>
                @endif



                <div class="flex items-center justify-end mt-6">
                    <flux:button type="submit" variant="primary" class="w-full">
                        {{ $student ? 'Update Account' : 'Create Account' }}
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
    @if ($student)
        <div>
            <div>
                <div class=" p-6 bg-white rounded-lg border-2 shadow">

                    <div class="relative h-full">
                        <form action="changeLimit" wire:submit='save'>
                            <flux:separator text="Atur Limit Penarikan Harian" />
                            <flux:input label="Limit Harian" mask:dynamic="$money($input)" wire:model="input_limit"
                                placeholder="Limit Harian" />
                            <flux:button class="w-full" type="submit" variant="primary" class="w-full">
                                Update Limit
                            </flux:button>
                    </div>
                    </form>
                </div>
            </div>
            <div>
                <div class=" p-6 bg-white rounded-lg border-2 shadow">

                    <div class="relative h-full">
                        <form action="" wire:submit.prevent="changePassword">
                            <div class="mt-4 space-y-4">

                                <flux:input type="password" viewable label="Password Baru" wire:model="new_password"
                                    name="new_password" />
                                <flux:input type="password" viewable label="Konfirmasi Password"
                                    wire:model="confirmation_password" name="confirmation_password" />
                                <flux:button type="submit" class="w-full" variant="primary">Simpan</flux:button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <x-toast on='student_updated'></x-toast>
</div>
