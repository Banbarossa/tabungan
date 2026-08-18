<div
    class="flex-1 flex flex-col items-center justify-center px-5 py-8 sm:py-12 min-h-screen lg:min-h-0 relative overflow-hidden">

    <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/3 w-72 h-72 rounded-full pointer-events-none lg:hidden"
        style="background: radial-gradient(circle, rgba(127,29,29,0.06) 0%, transparent 70%);"></div>

    <div class="w-full max-w-[420px] fade-up mb-4">


        {{-- Form login (disembunyikan Alpine kalau sukses) --}}
        <div>
            <div class="flex flex-col items-center mb-8 lg:hidden">
                <x-layouts.partials.logo class="mb-4 w-10" />
                <h1 class="text-center leading-snug mb-1"
                    style="font-family: var(--font-display); font-size:1.35rem; font-weight:700; color:#7f1d1d;">
                    Pesantren Imam Syafi'i
                </h1>
                <p class="text-center text-xs font-light tracking-wider opacity-60" style="color:#7f1d1d;">
                    Sistem Informasi Akademik
                </p>
            </div>

            <x-layouts.partials.login-form>
                <div>
                    <div class="flex flex-col gap-6">
                        <x-auth-session-status class="text-center" :status="session('status')" />

                        <form wire:submit="login" class="space-y-4">
                            <flux:input wire:model="nisn" :label="__('NISN')" type="NISN" required autofocus
                                autocomplete="NISN" placeholder="NISN SISWA" />


                            <div class="relative">
                                <flux:input wire:model="password" :label="__('Password')" type="password" required
                                    autocomplete="current-password" :placeholder="__('Password')" viewable />


                            </div>
                            <div>
                                <flux:checkbox wire:model="remember" :label="__('Remember me')" />
                            </div>


                            <button type="submit"
                                class="w-full rounded-2xl font-semibold text-white flex items-center justify-center gap-2.5 transition-smooth focus-ring disabled:opacity-70 disabled:cursor-not-allowed"
                                style="height:54px; font-size:1rem; letter-spacing:0.02em;
                       background: linear-gradient(135deg, #b91c1c 0%, #7f1d1d 60%, #5a0f0f 100%);
                       box-shadow: 0 4px 16px rgba(127,29,29,0.35);">

                                <span>Masuk</span>
                            </button>

                        </form>

                    </div>
                </div>
            </x-layouts.partials.login-form>

        </div>
    </div>

    <p class="absolute mt-3 bottom-4 left-0 right-0 text-center text-xs opacity-40" style="color:#6b7280;">
        © {{ now()->year }} Pesantren Imam Syafi'i · v1.0.0
    </p>
</div>
