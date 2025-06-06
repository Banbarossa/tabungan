<div class="flex items-start max-md:flex-col">

    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
        <flux:heading size='lg' >{{ $heading ?? '' }}</flux:heading>
        {{-- <flux:subheading>{{ $subheading ?? '' }}</flux:subheading> --}}
        <div class="mt-4">
            <flux:separator  class="mt-4"/>
        </div>

        <div class="mt-5 w-full max-w-lg">
            {{ $slot }}
        </div>
    </div>
</div>
