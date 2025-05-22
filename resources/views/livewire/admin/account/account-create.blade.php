<div class="max-w-2xl">
    <x-slot:breadcrumbs>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('account.') }}">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('account.') }}">Account</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Account Create</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </x-slot:breadcrumbs>

    {{ $vincla }}

    <div class="relative h-full flex-1" >
        <form action="" wire:submit='save'>
            <flux:separator text="Identitas Nasabah" />
            <flux:input
                wire:model="name"
                :label="__('Name')"
                type="text"
                required
                autofocus
                class="mb-4"
                autocomplete="name"
                :placeholder="__('Full name')"
            />
            <flux:input
                wire:model="nama_ibu"
                :label="__('Nama Ibu')"
                type="text"
                class="mb-4"
                :placeholder="__('Nama Ibu')"
            />
            <div class="grid grid-cols-2 gap-2">
                <flux:input
                    wire:model="nisn"
                    :label="__('NISN')"
                    type="number"
                    class="mb-4"
                    :placeholder="__('NISN')"
                />
                <flux:input
                    wire:model="nis"
                    :label="__('NIS')"
                    type="number"
                    class="mb-4"
                    :placeholder="__('NIS')"
                />
            </div>

            <div class="mt-5">
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
            </div>

            <flux:input
                wire:model="notification_account"
                :label="__('Akun Notifikasi')"
                type="text"
                class="mb-4"
                :placeholder="__('Akun Notifikasi')"
            />



            <div class="flex items-center justify-end mt-4">
                <flux:button type="submit" variant="primary" class="w-full">
                    Create account
                </flux:button>
            </div>
        </form>
    </div>
    <x-toast on='student_updated'></x-toast>
</div>
