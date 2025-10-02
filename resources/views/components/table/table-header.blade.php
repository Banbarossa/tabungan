@props(['search'=>true])
<div class="mb-4 flex items-center flex-wrap gap-4">
    @if($search)
        <div class="w-full sm:max-w-sm sm:order-2">
            <flux:input type="text" placeholder="Type to search" wire:model.live.debounce.250ms="search"></flux:input>
        </div>
    @endif
    <div class="flex-1">
        {{$slot}}
    </div>


</div>
