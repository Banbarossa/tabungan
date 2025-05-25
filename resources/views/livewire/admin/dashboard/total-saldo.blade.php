<?php

use Livewire\Volt\Component;
use App\Models\Student;

new class extends Component {
    public $saldo;
    public function mount(){
        $this->saldo= Student::sum('saldo');

    }
}; ?>

<div class="relative aspect-video overflow-hidden rounded-xl bg-gradient-to-r from-zinc-600 to-indigo-800 shadow-sm border border-neutral-200 dark:border-neutral-700">
    <img src="{{ asset('images/e-walet.png') }}" alt="e-walet" class="h-36 absolute right-0 bottom-0 z-0 opacity-30">
    <div class="p-6 z-50">
        <flux:icon.banknotes class="text-white size-10 mb-2" />
        <flux:text class="text-white">Total Saldo</flux:text>
        <flux:heading size="xl" class="text-white">{{format_rupiah($saldo)}}</flux:text>
    </div>
</div>
