<div>
     <x-slot:breadcrumbs>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{$previousUrl}}">User</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Detail</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </x-slot:breadcrumbs>

    <div class="grid md:grid-cols-2 gap-4">
        <div class="p-4 border rounded-lg">
            <livewire:settings.profile :code="vinclaEncode($user->id)"/>
        </div>
        <div class="p-4 border rounded-lg">
            <livewire:settings.password :code="vinclaEncode($user->id)"/>
        </div>
    </div>
</div>

