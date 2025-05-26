<?php

use Livewire\Volt\Component;
use App\Models\Transaction;


new class extends Component {

    public $transactions;
    public function mount(){
        $this->transactions = Transaction::latest()->limit(10)->get();

    }
}; ?>

<div class="p-3">
    <flux:heading size="lg">Riwayat Transaksi</flux:heading>
    <flux:separator/>

    <div class=" rounded-lg">
        <ul class="divide-y divide-gray-200 dark:divide-gray-700 mt-4">
            @forelse ($transactions as $item)
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

