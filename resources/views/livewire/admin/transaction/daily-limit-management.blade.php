<div class="space-y-6">

    <div class="bg-white border-2 rounded-lg p-6">
        <form wire:submit.prevent='limitBySave' class="space-y-4">
            <flux:radio.group wire:model.live="limitBySelected" label="Pilih Limit Jajan Berdasarkan"
                class="grid grid-cols-1 sm:grid-cols-3 w-full gap-4">
                @foreach ($limitByOptions as $opt)
                    <label for="{{ $opt['value'] }}"
                        class='rounded-lg  {{ $limitBySelected === $opt['value'] ? 'border-gray-300 bg-slate-100 ring-2 ring-gray-200 scale-105' : 'bg-slate-50' }} hover:bg-slate-100 border p-4 transition duration-300'>
                        <flux:radio value="{{ $opt['value'] }}" label="{{ $opt['label'] }}"
                            description="{{ $opt['description'] }}" />
                    </label>
                @endforeach
            </flux:radio.group>
            <div>
                <flux:button type="submit" variant="primary">Simpan</flux:button>
            </div>
        </form>
    </div>

    <div class="grid cols-1 md:grid-cols-2 gap-6">

        {{-- The Master doesn't talk, he acts. --}}
        <div
            class="max-w-lg border-2 dark:border-zinc-600 p-4 rounded-lg {{ $limitBySelected === '' }} bg-white dark:bg-zinc-800 self-start">
            <div class="flex gap-4 items-center mb-3">
                <div class="w-10 aspect-square flex justify-center items-center rounded-lg bg-rose-100 shadow">
                    <flux:icon name="calendar" class="text-rose-700 size-4"></flux:icon>
                </div>
                <div>
                    <h2 class="font-semibold text-gray-700 tracking-wider">Limit Harian</h2>
                    <p class="text-xs text-gray-500">Pengaturan batas limit harian jajan santri berdasarkan hari</p>
                </div>

            </div>
            <flux:separator />

            <form action="" wire:submit.prevent='save'>
                <fieldset class="space-y-4 mt-6" {{ $limitBySelected != 'hari' ? 'disabled' : '' }}>
                    <flux:field>
                        <flux:label class="mb-0">Minggu</flux:label>
                        <flux:input icon="banknotes" x-mask:dynamic="$money($input, ',', '.')" wire:model="minggu" />
                        <flux:error name="minggu" />
                    </flux:field>
                    <flux:field>
                        <flux:label class="mb-0">Senin</flux:label>
                        <flux:input icon="banknotes" x-mask:dynamic="$money($input, ',', '.')" wire:model="senin" />
                        <flux:error class="mt-0" name="senin" />
                    </flux:field>
                    <flux:field>
                        <flux:label class="mb-0">Selasa</flux:label>
                        <flux:input icon="banknotes" x-mask:dynamic="$money($input, ',', '.')" wire:model="selasa" />
                        <flux:error class="mt-0" name="selasa" />
                    </flux:field>
                    <flux:field>
                        <flux:label class="mb-0">Rabu</flux:label>
                        <flux:input icon="banknotes" x-mask:dynamic="$money($input, ',', '.')" wire:model="rabu" />
                        <flux:error class="mt-0" name="rabu" />
                    </flux:field>
                    <flux:field>
                        <flux:label class="mb-0">Kamis</flux:label>
                        <flux:input icon="banknotes" x-mask:dynamic="$money($input, ',', '.')" wire:model="kamis" />
                        <flux:error class="mt-0" name="kamis" />
                    </flux:field>
                    <flux:field>
                        <flux:label class="mb-0">Jumat</flux:label>
                        <flux:input icon="banknotes" x-mask:dynamic="$money($input, ',', '.')" wire:model="jumat" />
                        <flux:error class="mt-0" name="jumat" />
                    </flux:field>
                    <flux:field>
                        <flux:label class="mb-0">Sabtu</flux:label>
                        <flux:input icon="banknotes" x-mask:dynamic="$money($input, ',', '.')" wire:model="sabtu" />
                        <flux:error class="mt-0" name="sabtu" />
                    </flux:field>

                    <div class="flex items-center justify-end mt-6">
                        <flux:button type="submit" variant="primary" class="w-full">
                            Simpan
                        </flux:button>
                    </div>
                </fieldset>
            </form>

        </div>
        <div class="max-w-lg border-2 dark:border-zinc-600 p-4 rounded-lg bg-white dark:bg-zinc-800 self-start">
            <div class="flex gap-4 items-center mb-3">
                <div class="w-10 aspect-square flex justify-center items-center rounded-lg bg-teal-100 shadow">
                    <flux:icon name="calendar" class="text-teal-700 size-4"></flux:icon>
                </div>
                <div>
                    <h2 class="font-semibold text-gray-700 tracking-wider">Petugas Berdasarkan Petugas</h2>
                    <p class="text-xs text-gray-500">Pengaturan batas limit harian jajan santri berdasarkan Petugas</p>
                </div>

            </div>
            <flux:separator />
            <form wire:submit.prevent="saveDataLimitPetugas" class="space-y-4">
                <div>
                    <fieldset {{ $limitBySelected != 'petugas' ? 'disabled' : '' }}
                        class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($users_list as $user)
                            <div class="flex items-center justify-between py-3 gap-4"
                                wire:key="petugas-{{ $user['id'] }}">
                                <!-- Info Petugas -->
                                <div class="flex items-center gap-3">
                                    <div class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800">
                                        <flux:icon.user class="size-5 text-slate-600 dark:text-slate-400" />
                                    </div>
                                    <div>
                                        <p
                                            class="font-medium text-slate-800 dark:text-slate-200 text-sm truncate uppecase">
                                            {{ $user['name'] }}</p>
                                        <span class="text-xs text-slate-500">{{ $user['email'] }}</span>
                                    </div>
                                </div>

                                <!-- Input Limit -->
                                <div class="w-48">
                                    <flux:input wire:model="limit_petugas_input.{{ $user['id'] }}"
                                        placeholder="Masukkan limit" mask:dynamic="$money($input)" />
                                    @error('limit_petugas_input.' . $user['id'])
                                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                        @endforeach
                        <div class="flex items-center justify-end mt-6">
                            <flux:button type="submit" variant="primary" class="w-full">
                                Simpan
                            </flux:button>
                        </div>
                    </fieldset>
                </div>
            </form>

        </div>
    </div>


</div>
