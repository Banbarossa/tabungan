<?php

use Livewire\Volt\Component;
use App\Models\Savinglimit;


new class extends Component {

    public $limit;
    public function mount(){
        $model= Savinglimit::where('day_name',today_name())->first();
        if($model){
            $this->limit =$model->limit_amount;

        }
    }
}; ?>


<div class="relative aspect-video overflow-hidden rounded-xl bg-gradient-to-r from-zinc-600 to-green-800 shadow-sm border border-neutral-200 dark:border-neutral-700">
    <img src="{{ asset('images/creadit-card.png') }}" alt="creadit-card" class="h-36 absolute right-0 bottom-0 z-0 opacity-30">
    <div class="p-6">
        <flux:icon.banknotes class="text-white size-10 mb-2 z-50" />
        <flux:text class="text-white">Limit Penarikan Hari ini</flux:text>
        <flux:heading size="xl" class="text-white">{{format_rupiah($limit)}}</flux:text>
    </div>
</div>
