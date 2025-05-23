<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:header container class="">

            <flux:navbar class="-mb-px ">
                <flux:navbar.item icon="ticket" :href="route('cashier.home')" :current="request()->routeIs('cashier.home')" wire:navigate>
                    <flux:heading size="lg">Tabungan</flux:heading>
                </flux:navbar.item>
            </flux:navbar>

            <flux:spacer />

            <flux:navbar class="me-1.5 space-x-0.5 rtl:space-x-reverse py-0!">
                <flux:tooltip :content="__('Transaction')" position="bottom">
                    <flux:navbar.item
                        class="h-10 max-lg:hidden [&>div>svg]:size-5"
                        icon="banknotes"
                        href="{{ route('cashier.transaction') }}"
                        target="_blank"
                        label="Transaction"
                    />
                </flux:tooltip>
            </flux:navbar>

            <!-- Desktop User Menu -->
            <flux:dropdown position="top" align="end">
                <flux:profile
                    class="cursor-pointer"
                    :initials="auth()->user()->initials()"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:modal.trigger name="edit-appearance">
                            <button type="button" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
                                <flux:icon.adjustments-horizontal class="hover:text-indigo-600"></flux:icon.adjustments-horizontal>
                                <span class="text-xs text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-500">Settings</span>
                            </button>
                        </flux:modal.trigger>
                        <flux:modal.trigger name="edit-profile">
                            <button type="button" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
                                <flux:icon.user class="hover:text-indigo-600"></flux:icon.user>
                                <span class="text-xs text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-500">Profile</span>
                            </button>
                        </flux:modal.trigger>
                        <flux:modal.trigger name="edit-password">
                            <button type="button" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
                                <flux:icon.key class="hover:text-indigo-600"></flux:icon.key>
                                <span class="text-xs text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-500">Password</span>
                            </button>
                        </flux:modal.trigger>
                    </flux:menu.radio.group>


                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>





        {{-- Bottom Menu--}}
            <livewire:layouts.bottom-navigation/>
        {{-- end Bottom Menu--}}




        <div class="max-w-7xl mx-auto">
            {{ $slot }}

        </div>

        @fluxScripts


        <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
        @stack('script')
    </body>
</html>
