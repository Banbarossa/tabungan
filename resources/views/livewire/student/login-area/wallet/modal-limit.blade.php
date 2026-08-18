<div>



    <flux:modal name="edit-profile" class="md:w-96">

        <div class="space-y-6" x-data="{ otherOption: false }">

            <div class="flex items-center justify-start gap-4">
                <div class="w-10  aspect-square  rounded-lg shadow bg-red-100 flex items-center justify-center">
                    <flux:icon name="credit-card" class="size-4 text-red-700" />
                </div>

                <div>
                    <h1 class="text-red-800 font-bold">Ubah Limit</h1>
                    <flux:text>Ubah limit penggunaan jajan harian</flux:text>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2.5">
                @foreach ($pilihan_limits as $opt)
                    <button type="button" wire:click="changeButtonLimit('{{ $opt['value'] }}')"
                        x-on:click="otherOption = false"
                        class="relative px-3 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 border flex items-center justify-between
                        {{ $input_limit == $opt['value']
                            ? 'bg-red-800 text-white border-red-800 shadow-md shadow-red-800/20 ring-2 ring-red-800/20'
                            : 'bg-white  text-zinc-700  border-zinc-200  hover:border-red-300  hover:bg-red-50/50 ' }}">
                        <span>{{ $opt['label'] }}</span>
                        @if ($input_limit == $opt['value'] )
                            <flux:icon name="check" class="size-3.5 text-white" />
                        @endif
                    </button>
                @endforeach

                <!-- Button Jumlah Lainnya -->
                <button type="button" x-on:click="otherOption = !otherOption"
                    class="px-3 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 border flex items-center justify-center gap-1.5 bg-zinc-50 dark:bg-zinc-800/50 text-zinc-600 dark:text-zinc-400 border-dashed border-zinc-300 dark:border-zinc-700 hover:border-red-400 hover:text-red-700 dark:hover:text-red-400">
                    <flux:icon name="pencil-square" class="size-3.5" />
                    <span>Nominal Lain</span>
                </button>
            </div>
            <div x-show="otherOption" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
                class="pt-2 border-t border-zinc-100 dark:border-zinc-800">

                <form wire:submit.prevent="changeDailyLimit" class="space-y-6">
                    <flux:input label="Limit Harian" mask:dynamic="$money($input)" wire:model="input_limit"
                        placeholder="Limit Harian" />


                    <div class="flex">
                        <flux:spacer />

                        <flux:button type="submit" variant="primary">Save changes</flux:button>
                    </div>
                </form>
            </div>
        </div>

    </flux:modal>
</div>
