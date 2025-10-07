<div>
     <x-slot:breadcrumbs>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{$previousUrl}}">User</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Detail</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </x-slot:breadcrumbs>

    <div class="grid md:grid-cols-2 gap-4 mb-4">
        <div class="p-4 border rounded-lg">
            <livewire:settings.profile :code="vinclaEncode($user->id)"/>
        </div>
        <div class="p-4 border rounded-lg">
            <livewire:settings.password :code="vinclaEncode($user->id)"/>
        </div>
    </div>
    <flux:callout icon="cube"  inline color="indigo">
        <flux:callout.heading>Akun ini sebagai <strong>{{strtoupper($user->role)}}</strong></flux:callout.heading>
        <x-slot name="actions">
            <flux:button wire:click="ubahRole">{{$user->role =='admin'?'Cashier':'Admin'}}</flux:button>
            <flux:button variant="ghost">Ubah sebagai-></flux:button>
        </x-slot>
    </flux:callout>
</div>

