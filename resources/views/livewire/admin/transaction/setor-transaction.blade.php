<section>


    <x-slot:breadcrumbs>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('transaction') }}">Transaction</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Setor</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </x-slot:breadcrumbs>

    <div class="grid lg:grid-cols-3 gap-4">
        <div class="lg:order-2">
            <livewire:admin.transaction.notification-card :student="$student"/>

        </div>
        <div class=" lg:col-span-2">
            <div class="bg-zinc-100 rounded-lg p-4 border border-zinc-300 relative">
                <div class="flex gap-3 items-center">
                    <div class="w-10 h-10 bg-indigo-500/50 flex items-center justify-center rounded-lg">
                        <flux:icon.calculator></flux:icon.calculator>
                    </div>
                    <div>
                        <flux:text>Saldo Saat Ini</flux:text>
                        <flux:heading size="xl">{{ format_rupiah($student->saldo)}}</flux:heading>
                    </div>
                </div>
                <div class="absolute top-1/2 -translate-y-1/2 right-2">
                    <flux:modal.trigger name="setor">
                        <flux:button icon="plus"></flux:button>
                    </flux:modal.trigger>
                </div>
            </div>
            <div class="mt-4">
                <flux:heading size="lg">Riwayat Transaksi</flux:heading>

                <ul class="divide-y divide-gray-200 dark:divide-gray-700 mt-4">
                    @forelse ($transaksi as $item)
                        <x-list-item-advance :label="$item->type == 'setor' ? 'Setoran' :'Penarikan' ">
                            <x-slot:icon>
                                <div class="w-8 h-8 rounded-full bg-indigo-900 flex items-center justify-center">
                                    <flux:icon.chat-bubble-left class="size-4 text-white"/>

                                </div>
                            </x-slot:icon>
                            <x-slot:value>
                                <div class="inline-flex items-center text-base font-semibold {{ $item->type =='setor'? 'text-green-800 dark:text-green-200':'text-gray-600 dark:text-white' }}  ">
                                {{ $item->type =='setor'? '+' :'-' }} {{ format_rupiah($item->amount)}}
                            </div>
                            </x-slot:value>
                        </x-list-item-advance>
                    @empty

                    @endforelse

                </ul>
            </div>

        </div>
    </div>


    <flux:modal name="setor" class="md:w-96" variant="flyout">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Update Saldo</flux:heading>
                <flux:text class="mt-2">Input Saldo Tabungan Santri</flux:text>
            </div>
            <div class="bg-zinc-100 rounded-lg p-4 border border-zinc-300 relative">
                <div class="flex gap-3 items-center">
                    <div class="w-10 h-10 bg-green-500/80 flex items-center justify-center rounded-lg">
                        <flux:icon.user></flux:icon.user>
                    </div>
                    <div>
                        <flux:heading size="lg" class="uppercase">{{$student->name}}</flux:heading>
                    </div>
                </div>
            </div>
            <form action="" wire:submit='transaction'>
                <flux:input.group>
                    <flux:input.group.prefix>Rp</flux:input.group.prefix>
                    <flux:input x-mask:dynamic="$money($input, ',', '.')" wire:model="amount"  />
                </flux:input.group>
                <flux:error name="amount" />

                <div class="flex items-center justify-end mt-4">
                    <flux:button type="submit" variant="primary" class="w-full">
                        Tambah Saldo
                    </flux:button>
                </div>
            </form>



        </div>
    </flux:modal>

</section>
