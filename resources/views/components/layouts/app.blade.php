<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        <div>
            <div class="border-b border-zinc-300 mb-8 pb-1">
                @if (isset($title))
                    <flux:heading size="xl">{{$title}}</flux:heading>
                @endif

                <flux:breadcrumbs>
                    <flux:breadcrumbs.item href="{{ route('dashboard') }}">Home</flux:breadcrumbs.item>
                    @foreach ($breads ?? [] as $b)
                        <flux:breadcrumbs.item href="{{$b['url']}}">{{$b['title']}}</flux:breadcrumbs.item>
                    @endforeach
                </flux:breadcrumbs>

            </div>
            {{ $slot }}
        </div>
    </flux:main>
</x-layouts.app.sidebar>
