<div>
    <div class="lg:hidden fixed bottom-0 left-0 z-50 w-full h-16 bg-white border-t border-gray-200 dark:bg-gray-700 dark:border-gray-600">
            <div class="grid h-full max-w-lg grid-cols-4 mx-auto font-medium py-2">
                <button type="button" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
                    <svg class="w-5 h-5 mb-2 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                    </svg>
                    <span class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500">Home</span>
                </button>

                <flux:modal.trigger name="edit-appearance">
                    <button type="button" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
                        <flux:icon.adjustments-horizontal class="hover:text-indigo-600 mb-1"></flux:icon.adjustments-horizontal>
                        <span class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-500">Settings</span>
                    </button>
                </flux:modal.trigger>
                <flux:modal.trigger name="edit-profile">
                    <button type="button" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
                        <flux:icon.user class="hover:text-indigo-600 mb-1"></flux:icon.user>
                        <span class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-500">Profile</span>
                    </button>
                </flux:modal.trigger>
                <flux:modal.trigger name="edit-password">
                    <button type="button" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
                        <flux:icon.key class="hover:text-indigo-600 mb-1"></flux:icon.key>
                        <span class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-500">Password</span>
                    </button>
                </flux:modal.trigger>
            </div>
        </div>

        <flux:modal name="edit-profile" variant="flyout" class="md:w-96">
            <div class="space-y-6">
                <livewire:settings.profile/>
            </div>
        </flux:modal>
        <flux:modal name="edit-appearance" variant="flyout" class="md:w-96">
            <div class="space-y-6">
                <livewire:settings.appearance/>
            </div>
        </flux:modal>
        <flux:modal name="edit-password" variant="flyout" class="md:w-96">
            <div class="space-y-6">
                <livewire:settings.password/>
            </div>
        </flux:modal>
    </div>
</div>
