<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        <div>
            <div class="border-b border-zinc-300 mb-8 pb-1">
                @if (isset($title))
                <flux:heading size="xl" >{{$title}}</flux:heading>
                @endif

                @if (isset($breadcrumbs))
                    {{ $breadcrumbs }}
                @endif
            </div>
            {{ $slot }}
        </div>
    </flux:main>
</x-layouts.app.sidebar>
