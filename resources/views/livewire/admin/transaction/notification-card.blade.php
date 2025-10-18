<div class="mx-auto bg-zinc-200 dark:bg-zinc-800  rounded-lg border border-zinc-300 dark:border-zinc-600">
    <x-toast on='student_updated'></x-toast>
    <div class="flex flex-col h-full">
        <div class="flex-grow p-5">
            <div class="flex justify-between items-start">
                <header>
                    <div class="flex mb-2">
                        <a class="relative inline-flex items-start mr-5" href="{{route('account.edit',vinclaEncode($student->id))}}">
                            <div class="absolute bottom-0 right-0 -mr-1 p-1 bg-white rounded-full shadow">
                                <flux:icon.pencil class="size-3"></flux:icon.pencil>
                            </div>
                            <img class="rounded-full" src="{{ $student->photo ?? asset('images/avatar.jpg') }}"
                                width="64" height="64" alt="User 01" />
                        </a>
                        <div class="mt-1 pr-1">
                            <a class="inline-flex text-gray-800 dark:text-zinc-100 hover:text-gray-900 dark:hover:text-zinc-200" href="{{route('account.edit',vinclaEncode($student->id))}}">
                                <h2 class="text-xl leading-snug justify-center font-semibold">{{ $student->name }}</h2>

                            </a>
                            <div class="font-semibold">Kelas = {{$student->kelas}}</div>
                            <div class="text-sm text-gray-600">{{$student->no_id}}</div>
                        </div>
                    </div>
                </header>
            </div>
            <div class="mt-2">
                <flux:separator text="Notification" />
                <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700 mt-4">
{{--                    <x-list-item-advance label="Kirim Pesan Via">--}}
{{--                        <x-slot:icon>--}}
{{--                            <flux:icon.chat-bubble-left class="size-4"/>--}}
{{--                        </x-slot:icon>--}}
{{--                        <x-slot:value>--}}
{{--                            <div>--}}
{{--                                <label class="inline-flex items-center cursor-pointer">--}}
{{--                                    <input type="checkbox" wire:model.live="sendnotif" {{ $sendnotif ? 'checked' :'' }}  class="sr-only peer">--}}
{{--                                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-zinc-300 dark:peer-focus:ring-zinc-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-zinc-600 dark:peer-checked:bg-zinc-600"></div>--}}
{{--                                </label>--}}
{{--                            </div>--}}
{{--                        </x-slot:value>--}}
{{--                    </x-list-item-advance>--}}
                    <x-list-item-advance label="Nama Ibu">
                        <x-slot:icon>
                            <flux:icon.user-minus class="size-4"/>
                        </x-slot:icon>
                        <x-slot:value>
                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                {{ $student->nama_ibu }}
                            </div>
                        </x-slot:value>
                    </x-list-item-advance>
                    @if ($sendnotif)
                    <x-list-item-advance label="Kirim Pesan Via">
                        <x-slot:icon>
                            <flux:icon.arrow-path class="size-4"/>
                        </x-slot:icon>
                        <x-slot:value>
                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                {{ $student->notification_target }}
                            </div>
                        </x-slot:value>
                    </x-list-item-advance>
                    <x-list-item-advance label="">
                        <x-slot:icon>
                            <flux:icon.phone class="size-4"/>
                        </x-slot:icon>
                        <x-slot:value>
                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                {{ $student->notification_account }}
                            </div>
                        </x-slot:value>
                    </x-list-item-advance>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
