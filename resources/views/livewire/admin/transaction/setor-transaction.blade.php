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
            <div class="bg-zinc-100 dark:bg-zinc-800 rounded-lg p-4 border border-zinc-300 dark:border-zinc-600 relative">
                <div class="flex gap-3 items-center">
                    <div class="w-10 h-10 bg-indigo-500/50 flex items-center justify-center rounded-lg">
                        <flux:icon.calculator></flux:icon.calculator>
                    </div>
                    <div>
                        <flux:text>Saldo Saat Ini</flux:text>
                        <flux:heading size="xl">{{ format_rupiah($student->saldo)}}</flux:heading>
                    </div>
                </div>
                <div class="bg-white dark:bg-zinc-900 mt-2 p-2 rounded-lg shadow">
                    <flux:modal.trigger name="setor">
                        <flux:button icon="plus" variant="primary" size="sm">Setor</flux:button>
                    </flux:modal.trigger>
                    <flux:modal.trigger name="tarik">
                        <flux:button icon="minus" variant="danger" size="sm">Tarik</flux:button>
                    </flux:modal.trigger>
                </div>
            </div>
            <div class="mt-4">
                <flux:heading size="lg">Riwayat Transaksi</flux:heading>

                <div class="border dark:border-zinc-600 p-4 rounded-lg">
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700 mt-4">
                        @forelse ($transaksi as $item)
                            <li class="pb-3 sm:pb-4">
                                <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                    <div class="shrink-0">
                                        <div class="w-8 h-8 rounded-full {{  $item->type =='setor' ?'bg-green-400/70' :'bg-red-400/70' }} flex items-center justify-center" >
                                            @if ($item->type == 'setor')
                                            <flux:icon.banknotes class="size-4 text-zinc-50"></flux:icon.banknotes>
                                            @else
                                            <flux:icon.inbox-arrow-down class="size-4 text-zinc-50"></flux:icon.inbox-arrow-down>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        {{ $item->type =='setor' ?'Setoran':'Penarikan' }}
                                        </p>
                                        <p class="text-xs text-gray-500 truncate dark:text-gray-400">
                                            {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                    <div class="inline-flex items-center text-base font-semibold  {{  $item->type =='setor' ?'text-green-700 dark:text-green-200' :'text-gray-900 dark:text-white' }} ">
                                        {{ $item->type =='setor' ?'+':'-' }}{{ format_rupiah($item->amount) }}
                                    </div>
                                </div>
                            </li>
                        @empty

                        @endforelse

                    </ul>
                </div>
            </div>

        </div>
    </div>


    <flux:modal name="setor" class="md:w-96" variant="flyout">
        <div class="space-y-6">
            <div>
                <flux:heading size="xl">Update Saldo</flux:heading>
                <flux:text class="truncate">Penambahan Saldo Tabungan Santri</flux:text>
            </div>
            <img src="{{ asset('images/team.png') }}" alt="withdraw" class="h-36">
            <div class="bg-zinc-100 dark:bg-zinc-700 rounded-lg p-4 border border-zinc-300 relative">
                <div class="flex gap-3 items-center">
                    <div class="w-12 h-12 bg-green-300/80 flex items-center justify-center rounded-lg">
                        <flux:icon.briefcase></flux:icon.briefcase>
                    </div>
                    <div>
                        <flux:text  class="uppercase truncate">{{$student->name}}</flux:text>
                        <flux:heading size="xl" class="uppercase">{{format_rupiah($student->saldo)}}</flux:heading>
                    </div>
                </div>
            </div>
            <form action="" wire:submit='setor'>
                <flux:input.group>
                    <flux:input.group.prefix>Rp</flux:input.group.prefix>
                    <flux:input  x-mask:dynamic="$money($input, ',', '.')" wire:model="amount_setor"  />
                </flux:input.group>
                <flux:error name="amount_setor" />

                <div class="flex items-center justify-end mt-4">
                    <flux:button type="submit" variant="primary" class="w-full">
                        Tambah Saldo
                    </flux:button>
                </div>
            </form>



        </div>
    </flux:modal>
    <flux:modal name="tarik" class="md:w-96" variant="flyout">
        <div class="space-y-6">
            <div>
                <flux:heading size="xl">Penarikan</flux:heading>
                <flux:text >Penarikan Tabungan</flux:text>
            </div>
            <img src="{{ asset('images/withdraw.png') }}" alt="withdraw" class="h-36">
            <div class="bg-zinc-100 dark:bg-zinc-700 rounded-lg p-4 border border-zinc-300 relative">
                <div class="flex gap-3 items-center">
                    <div class="w-12 h-12 bg-red-300/80 flex items-center justify-center rounded-lg">
                        <flux:icon.ticket></flux:icon.ticket>
                    </div>
                    <div>
                        <flux:text class="uppercase truncate">{{$student->name}}</flux:text>
                        <flux:heading size="xl" class="uppercase">{{format_rupiah($student->saldo)}}</flux:heading>
                    </div>
                </div>
            </div>
            <form action="" wire:submit='tarik'>
                <flux:input.group>
                    <flux:input.group.prefix>Rp</flux:input.group.prefix>
                    <flux:input x-mask:dynamic="$money($input, ',', '.')" wire:model="amount_tarik"  />
                </flux:input.group>
                <flux:error name="amount_tarik" />

                <div class="flex items-center justify-end mt-4">
                    <flux:button type="submit" variant="primary" class="w-full">
                        Tarik
                    </flux:button>
                </div>
            </form>



        </div>
    </flux:modal>

</section>
