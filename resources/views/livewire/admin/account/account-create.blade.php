<div class="max-w-7xl mx-auto space-y-6">

    <!-- Container Utama: Grid Asimetris (Kiri: 2 Kolom, Kanan: 1 Kolom di Desktop) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        <!-- ================= KOLOM KIRI (LEBIH BESAR - IDENTITAS SANTRI) ================= -->
        <div
            class="lg:col-span-2 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm p-6">
            <form wire:submit="save" class="space-y-6">

                <!-- Section Header Utama -->
                <div class="flex items-center gap-3">
                    <div
                        class="p-2.5 bg-indigo-50 dark:bg-indigo-950/50 rounded-lg text-indigo-600 dark:text-indigo-400">
                        <flux:icon.user-circle class="w-6 h-6" />
                    </div>
                    <div>
                        <flux:heading size="lg">Identitas Utama Santri</flux:heading>
                        <flux:subheading>Lengkapi data personal dan informasi akademik santri.</flux:subheading>
                    </div>
                </div>

                <flux:separator />

                <!-- 1. Data Diri Santri -->
                <div class="space-y-4">
                    <flux:input wire:model="name" label="Nama Lengkap Santri" type="text"
                        placeholder="Contoh: Ahmad Dahlan" required autofocus />

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <flux:input wire:model="nisn" label="NISN" type="number" placeholder="10 digit NISN" />
                        <flux:input wire:model="nis" label="NIS" type="number" placeholder="Nomor Induk" />
                        <flux:select wire:model="kelas" label="Kelas" placeholder="Pilih Kelas">
                            @foreach ($daftar_kelas as $ke)
                                <flux:select.option value="{{ $ke }}">Kelas {{ $ke }}
                                </flux:select.option>
                            @endforeach
                        </flux:select>
                    </div>
                </div>

                <flux:separator variant="subtle" />

                <!-- 2. Data Orang Tua / Wali -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2 text-zinc-800 dark:text-zinc-200">
                        <flux:icon.users class="w-5 h-5 text-indigo-500" />
                        <flux:heading size="sm">Informasi Orang Tua / Wali</flux:heading>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Ayah -->
                        <div
                            class="p-4 bg-zinc-100 dark:bg-zinc-800/40 rounded-xl border border-zinc-100 dark:border-zinc-800 space-y-3">
                            <div
                                class="flex items-center gap-2 font-medium text-xs text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                                <flux:icon.user class="w-3.5 h-3.5" />
                                Kontak Ayah
                            </div>
                            <flux:input wire:model="nama_ayah" label="Nama Ayah" type="text"
                                placeholder="Nama Lengkap Ayah" />
                            <flux:input wire:model="no_hp_ayah" label="No. WA Ayah" type="text"
                                placeholder="0812xxxxxxx" />
                        </div>

                        <!-- Ibu -->
                        <div
                            class="p-4 bg-zinc-100 dark:bg-zinc-800/40 rounded-xl border border-zinc-100 dark:border-zinc-800 space-y-3">
                            <div
                                class="flex items-center gap-2 font-medium text-xs text-pink-600 dark:text-pink-400 uppercase tracking-wider">
                                <flux:icon.heart class="w-3.5 h-3.5" />
                                Kontak Ibu
                            </div>
                            <flux:input wire:model="nama_ibu" label="Nama Ibu" type="text"
                                placeholder="Nama Lengkap Ibu" />
                            <flux:input wire:model="notification_account" label="No. WA Ibu" type="text"
                                placeholder="0812xxxxxxx" />
                        </div>
                    </div>
                </div>

                <!-- Status Keaktifan (Jika Mode Edit) -->
                @if ($student)
                    <flux:separator variant="subtle" />
                    <div
                        class="p-4 bg-amber-50/60 dark:bg-amber-950/20 rounded-xl border border-amber-200/60 dark:border-amber-900/40">
                        <flux:radio.group wire:model="send_notification" label="Status Keaktifan Belajar">
                            <flux:radio value="1" label="Aktif (Santri masih aktif di pesantren)" />
                            <flux:radio value="0" label="Tidak Aktif (Lulus / Pindah / Nonaktif)" />
                        </flux:radio.group>
                    </div>
                @endif

                <!-- Submit Button Utama -->
                <div class="pt-2 flex justify-end">
                    <flux:button type="submit" variant="primary" class="w-full sm:w-auto px-8"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="save">
                            {{ $student ? 'Perbarui Identitas' : 'Simpan Data Santri' }}
                        </span>
                        <span wire:loading wire:target="save" class="inline-flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Menyimpan...
                        </span>
                    </flux:button>
                </div>

            </form>
        </div>


        <!-- ================= KOLOM KANAN (LEBIH KECIL - PENGATURAN & KEUANGAN) ================= -->
        <div class="lg:col-span-1 space-y-6">

            @if ($student)
                <!-- 1. Card Limit Penarikan Harian -->
                <div
                    class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm p-6 space-y-5">
                    <form wire:submit="changeLimit" class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div
                                class="p-2 bg-emerald-50 dark:bg-emerald-950/50 rounded-lg text-emerald-600 dark:text-emerald-400">
                                <flux:icon.banknotes class="w-5 h-5" />
                            </div>
                            <div>
                                <flux:heading size="md">Limit Harian</flux:heading>
                                <flux:subheading class="text-xs">Atur batasan penarikan per hari.</flux:subheading>
                            </div>
                        </div>

                        <flux:separator />

                        <flux:input label="Nominal Limit (Rp)" mask:dynamic="$money($input)" wire:model="input_limit"
                            placeholder="Contoh: 50.000" />

                        <flux:button type="submit" variant="filled" class="w-full" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="changeLimit">Update Limit</span>
                            <span wire:loading wire:target="changeLimit">Memproses...</span>
                        </flux:button>
                    </form>
                </div>

                <!-- 2. Card Keamanan / Password -->
                <div
                    class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm p-6 space-y-5">
                    <form wire:submit="changePassword" class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div
                                class="p-2 bg-amber-50 dark:bg-amber-950/50 rounded-lg text-amber-600 dark:text-amber-400">
                                <flux:icon.key class="w-5 h-5" />
                            </div>
                            <div>
                                <flux:heading size="md">Keamanan Akun</flux:heading>
                                <flux:subheading class="text-xs">Atur ulang password santri.</flux:subheading>
                            </div>
                        </div>

                        <flux:separator />

                        <div class="space-y-3">
                            <flux:input type="password" viewable label="Password Baru" wire:model="new_password"
                                placeholder="Minimal 8 karakter" />
                            <flux:input type="password" viewable label="Konfirmasi Password"
                                wire:model="confirmation_password" placeholder="Ulangi password" />
                        </div>

                        <flux:button type="submit" variant="filled" class="w-full" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="changePassword">Simpan Password</span>
                            <span wire:loading wire:target="changePassword">Memproses...</span>
                        </flux:button>
                    </form>
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
            @else
                <!-- Panduan Tambahan jika sedang Mode Tambah Santri Baru -->
                <div
                    class="bg-indigo-50/50 dark:bg-indigo-950/20 border border-indigo-100 dark:border-indigo-900/40 rounded-xl p-5 space-y-3">
                    <div class="flex items-center gap-2 text-indigo-700 dark:text-indigo-400 font-semibold text-sm">
                        <flux:icon.information-circle class="w-5 h-5" />
                        <span>Informasi Pendaftaran</span>
                    </div>
                    <p class="text-xs text-indigo-950/70 dark:text-indigo-300 leading-relaxed">
                        Setelah akun santri berhasil dibuat, Anda dapat mengatur **Limit Penarikan Harian** dan
                        **Password Akses** pada panel sebelah kanan ini.
                    </p>
                </div>
            @endif

        </div>

    </div>

    <!-- Notifikasi Toast -->
    <x-toast on="student_updated" />
</div>
