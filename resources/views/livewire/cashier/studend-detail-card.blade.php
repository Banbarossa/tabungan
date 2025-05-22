<div class="mx-auto bg-zinc-100 dark:bg-zinc-800 rounded-lg border border-gray-200 dark:border-gray-600 dark:text-zinc-100">

    <div class="flex flex-col h-full">
        <div class="flex-grow p-5">
            <div class="flex justify-between items-start">
                <header>
                    <div class="flex mb-2">
                        <a class="relative inline-flex items-start mr-5" href="#0">
                            <div class="absolute bottom-0 right-0 -mr-1 p-1 bg-white rounded-full shadow">
                                <flux:icon.pencil class="size-3"></flux:icon.pencil>
                            </div>
                            <img class="rounded-full" src="{{ $student->photo ?? asset('images/avatar.jpg') }}"
                                width="64" height="64" alt="User 01" />
                        </a>
                        <div class="mt-1 pr-1">
                            <a class="inline-flex " href="#0">
                                <h2 class="text-xl leading-snug justify-center font-semibold">{{ $student->name }}</h2>
                            </a>
                            <flux:text>{{$student->nisn}}</flux:text>
                        </div>
                    </div>
                </header>
            </div>
            <div class="mt-2">

                <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700 mt-4">
                </ul>
            </div>
        </div>
    </div>
</div>
