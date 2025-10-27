<div class="mx-auto bg-zinc-200 dark:bg-zinc-800  rounded-lg border border-zinc-300 dark:border-zinc-600">
    <x-toast on='student_updated'></x-toast>
    <div class="flex flex-col h-full">
        <div class="flex-grow p-5" x-data="{ showPreview: false }">
            <div class="flex justify-between items-start">
                <header>
                    <div class="flex mb-2 gap-2">
                        <div class="relative">
                            <img class="rounded-full w-24 h-24 object-cover" src="{{ $student->avatar }}" alt="{{$student->name}}" @click="showPreview = true"  />
                            <flux:button :square="true" href="{{route('account.photo',['student'=>$student])}}" icon="pencil" size="sm" class="absolute right-2 bottom-0"/>
                        </div>

                        <div class="mt-1 pr-1">
                            <a class="inline-flex text-gray-800 dark:text-zinc-100 hover:text-gray-900 dark:hover:text-zinc-200" href="{{route('account.edit',vinclaEncode($student->id))}}">
                                <h2 class="text-xl leading-snug justify-center font-semibold">{{ $student->name }}</h2>

                            </a>
                            <div class="font-semibold">Kelas = {{$student->kelas}}</div>
                            <div class="text-sm text-gray-600">{{$student->no_id}}</div>
                        </div>
                    </div>
                </header>
                <template x-if="showPreview">
                    <div
                        class="fixed inset-0 bg-black/70 flex items-center justify-center z-50"
                        @click.self="showPreview = false"
                    >
                        <div class="relative">
                            <img
                                src="{{ $student->avatar }}"
                                alt="{{ $student->name }}"
                                class="max-w-[90vw] max-h-[90vh] rounded-lg shadow-lg"
                            />
                            <button
                                @click="showPreview = false"
                                class="absolute -top-2 -right-2 bg-white rounded-full p-1 text-black hover:bg-gray-200"
                                title="Tutup"
                            >
                                ✕
                            </button>
                        </div>
                    </div>
                </template>
            </div>
            <div class="mt-2">
                <flux:separator text="Notification" />
                <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700 mt-4">

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

                    <x-list-item-advance label="Hp Ibu">
                        <x-slot:icon>
                            <flux:icon.phone class="size-4"/>
                        </x-slot:icon>
                        <x-slot:value>
                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                {{ $student->notification_account }}
                            </div>
                        </x-slot:value>
                    </x-list-item-advance>
                        <x-list-item-advance label="Hp Ayah">
                        <x-slot:icon>
                            <flux:icon.phone class="size-4"/>
                        </x-slot:icon>
                        <x-slot:value>
                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                {{ $student->no_hp_ayah }}
                            </div>
                        </x-slot:value>
                    </x-list-item-advance>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
