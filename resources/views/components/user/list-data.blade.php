@props(['users'=>[]])

<div class="space-y-4 mt-8">
    @forelse ($users as $item)

        <div class="md:max-w-lg bg-white border border-gray-200 rounded-lg shadow-sm  hover:bg-gray-100 dark:border-zinc-600 dark:bg-zinc-800 dark:hover:bg-zinc-700 p-4">

            <div class="flex flex-col items-center md:flex-row ">
                <img class="object-cover w-8 h-8 rounded-t-lg rounded-full" src="{{ asset('images/admin-avatar.png') }}" alt="">
                <div class="flex flex-col items-center md:items-start justify-between p-4 leading-normal">
                    <flux:heading size="xl">
                        {{$item->name}}
                    </flux:heading>
                    <flux:text>{{$item->email}}</flux:text>

                </div>
            </div>
            @if ($item->id != Auth::user()->id)
            <div>
                <flux:button  size='xs' href="{{ route('user.detail',vinclaEncode($item->id)) }}">Detail</flux:button>
                <flux:button variant='danger' size='xs' wire:click='nonactive({{ $item->id }})'>Non Aktifkan</flux:button>
            </div>
            @endif
        </div>

    @empty

    @endforelse

</div>
