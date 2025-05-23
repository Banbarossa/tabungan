<div>
    <div class="lg:hidden fixed bottom-0 left-0 z-50 w-full h-16 bg-white border-t border-gray-200 dark:bg-gray-700 dark:border-gray-600">
            <div class="grid h-full max-w-lg grid-cols-5 mx-auto font-medium py-2">
                <div>
                    <a href="{{ route('cashier.home') }}" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
                        <flux:icon.home class="hover:text-indigo-600 mb-1"></flux:icon.home>
                        <span class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-500">Home</span>
                    </a>
                </div>
                <flux:modal.trigger name="edit-appearance">
                    <button type="button" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
                        <flux:icon.adjustments-horizontal class="hover:text-indigo-600 mb-1"></flux:icon.adjustments-horizontal>
                        <span class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-500">Settings</span>
                    </button>
                </flux:modal.trigger>
                <div>
                    <a href="{{ route('cashier.transaction') }}" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
                        <flux:icon.banknotes class="hover:text-indigo-600 mb-1 size-10 text-indigo-600" variant="solid"></flux:icon.banknotes>
                    </a>
                </div>
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

        <x-settings.modal-setting/>
    </div>
</div>
