<?php

use Livewire\Volt\Component;
use App\Models\Transaction;

new class extends Component {
    public $trans;
    public function mount(){
        $this->trans= Transaction::whereDate('created_at',now())->where('type','!=','setor')->sum('amount');

    }
}; ?>

<div class="relative aspect-video overflow-hidden rounded-xl bg-gradient-to-r from-zinc-600 to-orange-800 shadow-sm border border-neutral-200 dark:border-neutral-700">
    <img src="{{ asset('images/atm.png') }}" alt="atm" class="max-h-32 absolute right-0 bottom-0 z-0 opacity-30">
    <div class="p-6 z-50">
        <flux:icon.banknotes class="text-white size-10 mb-2" />
        <flux:text class="text-white">Total Penarikan Hari ini</flux:text>
        <flux:heading size="xl" class="text-white">{{format_rupiah($trans)}}</flux:text>
    </div>
</div>
