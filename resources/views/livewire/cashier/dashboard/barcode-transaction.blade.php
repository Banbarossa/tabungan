<div
    class="mb-24"
>
    <x-toast on='transaction_updated'></x-toast>


    <div class="">
        <div class="w-full">
            <div class=" border rounded-lg p-4 border-neutral-200 dark:border-neutral-700">
                @if ($student)

                    <form action="" wire:submit="transaction">
                        <div class="flex flex-col h-full">
                            <div class="flex-grow p-5">
                                <div class="flex justify-between items-start">
                                    <header>
                                        <div class="flex mb-2">
                                            <a class="relative inline-flex items-start mr-5" href="#0">
                                                <div
                                                    class="absolute bottom-0 right-0 -mr-1 p-1 bg-white rounded-full shadow">
                                                    <flux:icon.pencil class="size-3"></flux:icon.pencil>
                                                </div>
                                                <img class="rounded-full"
                                                     src="{{ $student->photo ?? asset('images/avatar.jpg') }}"
                                                     width="64" height="64" alt="User 01"/>
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

                        <flux:separator text="Informasi"/>

                        <div class="grid grid-cols-2 gap-4 mb-4 mt-8">
                            <div>
                                <flux:text>Saldo</flux:text>
                                <flux:heading size="lg" class="mb-2">{{format_rupiah($student->saldo)}}</flux:heading>
                            </div>
                            <div>
                                <flux:text>Limit Harian</flux:text>
                                <flux:heading size="lg" class="mb-2">{{format_rupiah($dailyLimit)}}</flux:heading>
                            </div>
                        </div>
                        <flux:separator text="Penarikan"/>
                        <div class="mb-6">
                            <flux:input.group class="mt-8">
                                <flux:input.group.prefix>Rp</flux:input.group.prefix>
                                <flux:input
                                    x-mask:dynamic="$money($input, ',', '.')"
                                    wire:model="amount"
                                />
                            </flux:input.group>
                            <flux:error name="amount"/>

                        </div>
                        <div>
                            <flux:textarea name="description" wire:model="description" label="Keterangan" placeholder="Keterangan"></flux:textarea>
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <flux:button type="submit" variant="primary" class="w-full">
                                Tarik
                            </flux:button>
                        </div>
                    </form>
                @else
                    <div class="text-center">
                        <h1 class="text-xl font-bold mb-2">ID CARD SANTRI</h1>
                        {{-- <form action="" wire:submit="getData"> --}}

                        <flux:input placeholder="Kode Id Card" wire:model.live="search" autofocus/>
                        {{-- </form> --}}
                        {{--                        {{ $search }}--}}
                    </div>

                @endif
            </div>
        </div>
    </div>

</div>

