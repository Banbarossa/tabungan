@props([
    'on',
])


<div
    x-data="{ shown: false, timeout: null }"
    x-init="@this.on('{{ $on }}', () => { clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 1500); })"
    x-show.transition.out.opacity.duration.1500ms="shown"
    x-transition:leave.opacity.duration.1500ms
    style="display: none; pointer-events: none"
    class="fixed inset-0"
>
    <div
        {{ $attributes->merge(['class' => 'flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800 absolute top-20 ms-auto relative z-50  border bg-gray-100']) }}
        x-on:click.outside="shown = false"
      >
        <div class="rounded-lg bg-green-400/70 flex items-center justify-center w-8 h-8">
            <flux:icon.check-circle />
        </div>
        <div class="ms-3 text-sm font-normal">{{ $slot->isEmpty() ? __('Saved.') : $slot }}</div>
        <div class="absolute top-2 right-2">
            <flux:button variant="subtle" x-on:click="shown = false" icon="x-mark" size="sm" ></flux:button>
        </div>

    </div>
</div>

