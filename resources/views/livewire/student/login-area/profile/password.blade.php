<div>
    <div class="px-4 pt-4 space-y-4">
        <div class="bg-white rounded-2xl p-4 shadow">
            <div class="flex gap-4 mb-2">
                <div class="h-10 rounded-xl shadow aspect-square shadow flex justify-center items-center bg-red-100">
                    <flux:icon name="key" class="size-4" />
                </div>
                <div>
                    <flux:heading size="lg">Update Password</flux:heading>
                    <flux:text class="text-xs">Update Password anda secara berkala untuk keamanan</flux:text>
                </div>
            </div>
            <flux:separator />
            <form action="" wire:submit.prevent="changePassword">
                <div class="mt-4 space-y-4">
                    <flux:input type="password" viewable label="Password Lama" wire:model="old_password"
                        name="old_password" />
                    <flux:input type="password" viewable label="Password Baru" wire:model="new_password"
                        name="new_password" />
                    <flux:input type="password" viewable label="Konfirmasi Password" wire:model="confirmation_password"
                        name="confirmation_password" />
                    <flux:button type="submit" class="w-full" variant="primary">Simpan</flux:button>
                </div>
            </form>
        </div>
        <div
            class="space-y-3 bg-amber-50 dark:bg-amber-950/30 p-4 rounded-xl border border-amber-200 dark:border-amber-800/50">
            <flux:text class="font-semibold text-amber-900 dark:text-amber-200 flex items-center gap-1.5">
                <flux:icon name="light-bulb" class="w-4 h-4 text-amber-600 dark:text-amber-400" />
                Tips Membuat Password Aman:
            </flux:text>

            <ul class="text-xs text-amber-800 dark:text-amber-300  list-disc pl-5">
                <li>Gunakan minimal 8–12 karakter atau lebih.</li>
                <li>Kombinasikan huruf besar, huruf kecil, angka, dan simbol (contoh: `@`, `#`, `$`).
                </li>
                <li>Hindari data pribadi yang mudah ditebak (seperti NISN, tanggal lahir, atau nama).</li>
                <li>Jangan gunakan password yang sama dengan akun lain.</li>
            </ul>
        </div>
    </div>
</div>
