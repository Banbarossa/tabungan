<div
    class="flex-1 flex flex-col items-center justify-center px-5 py-8 sm:py-12 min-h-screen lg:min-h-0 relative overflow-hidden">

    {{-- Background decoration --}}
    <div
        class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/3
               w-72 h-72 rounded-full pointer-events-none lg:hidden"
        style="background: radial-gradient(circle, rgba(127,29,29,0.06) 0%, transparent 70%);">
    </div>

    <div class="w-full max-w-[420px] relative z-10">

        {{-- Header --}}
        <div class="flex flex-col items-center mb-8">

            <x-layouts.partials.logo class="mb-4 w-10" />

            <h1
                class="text-center leading-snug mb-1"
                style="font-family: var(--font-display); font-size:1.35rem;
                       font-weight:700; color:#7f1d1d;">
                Pesantren Imam Syafi'i
            </h1>

            <p
                class="text-center text-xs font-light tracking-wider opacity-60"
                style="color:#7f1d1d;">
                Sistem Informasi dan Monitoring
            </p>

        </div>


        {{-- Install Card --}}
        <div
            class="rounded-3xl bg-white/90 dark:bg-white p-6 sm:p-7"
            style="
                box-shadow:
                    0 10px 40px rgba(127,29,29,0.08),
                    0 2px 8px rgba(0,0,0,0.04);
                border: 1px solid rgba(127,29,29,0.08);
            ">

            {{-- Icon --}}
            <div class="flex justify-center mb-5">
                <div
                    class="w-16 h-16 rounded-2xl flex items-center justify-center"
                    style="
                        background: linear-gradient(
                            135deg,
                            rgba(185,28,28,0.12),
                            rgba(127,29,29,0.06)
                        );
                    ">

                    <svg
                        class="w-8 h-8"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="#7f1d1d"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round">

                        <path d="M12 3v12" />
                        <path d="m7 10 5 5 5-5" />
                        <path d="M5 21h14" />

                    </svg>

                </div>
            </div>


            {{-- Title --}}
            <div class="text-center">

                <h2
                    class="text-xl font-bold text-gray-900"
                    style="font-family: var(--font-display);">
                    Pasang Aplikasi
                </h2>

                <p class="mt-2 text-sm leading-relaxed text-gray-500">
                    Pasang aplikasi Sistem Informasi Akademik
                    di perangkat Anda untuk akses yang lebih cepat
                    dan nyaman.
                </p>

            </div>


            {{-- Install Button --}}
            <div class="mt-6">

                <button
                    id="installPwa"
                    type="button"
                    class="w-full rounded-2xl font-semibold text-white
                           flex items-center justify-center gap-2.5
                           transition-all duration-200
                           active:scale-[0.98]
                           focus:outline-none"
                    style="
                        height:54px;
                        font-size:1rem;
                        letter-spacing:0.02em;
                        background:
                            linear-gradient(
                                135deg,
                                #b91c1c 0%,
                                #7f1d1d 60%,
                                #5a0f0f 100%
                            );
                        box-shadow:
                            0 4px 16px rgba(127,29,29,0.30);
                    ">

                    <svg
                        class="w-5 h-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round">

                        <path d="M12 3v12" />
                        <path d="m7 10 5 5 5-5" />
                        <path d="M5 21h14" />

                    </svg>

                    <span id="installText">
                        Install Aplikasi
                    </span>

                </button>

            </div>


            {{-- Already installed --}}
            <div
                id="installedMessage"
                class="hidden mt-5 text-center">

                <div
                    class="inline-flex items-center gap-2 text-sm font-medium"
                    style="color:#166534;">

                    <svg
                        class="w-5 h-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round">

                        <path d="m5 12 4 4L19 6" />

                    </svg>

                    Aplikasi sudah terpasang

                </div>

            </div>


            {{-- iOS / Manual instruction --}}
            <div
                id="manualInstall"
                class="hidden mt-5 rounded-2xl p-4"
                style="background:#fafafa;">

                <p class="text-xs leading-relaxed text-gray-500 text-center">

                    Untuk memasang aplikasi, buka menu
                    <strong class="text-gray-700">Bagikan</strong>
                    pada browser kemudian pilih
                    <strong class="text-gray-700">
                        Tambahkan ke Layar Utama
                    </strong>.

                </p>

            </div>


            {{-- Back to login --}}
            <div class="mt-6 text-center">

                <a
                    href="{{ route('login') }}"
                    class="text-sm font-medium transition-opacity hover:opacity-70"
                    style="color:#7f1d1d;">

                    Kembali ke Login

                </a>

            </div>

        </div>

    </div>


    {{-- Footer --}}
    <p
        class="absolute mt-3 bottom-4 left-0 right-0
               text-center text-xs opacity-40"
        style="color:#6b7280;">

        © {{ now()->year }} Pesantren Imam Syafi'i · v1.0.0

    </p>

</div>


<script>
    document.addEventListener('DOMContentLoaded', () => {

        let deferredPrompt = null;

        const installButton = document.getElementById('installPwa');
        const installText = document.getElementById('installText');
        const manualInstall = document.getElementById('manualInstall');
        const installedMessage = document.getElementById('installedMessage');

        /*
         * Cek apakah aplikasi sudah berjalan sebagai PWA
         */
        const isStandalone =
            window.matchMedia('(display-mode: standalone)').matches ||
            window.navigator.standalone === true;

        if (isStandalone) {
            installButton.classList.add('hidden');
            installedMessage.classList.remove('hidden');
            return;
        }


        /*
         * Android / Chrome
         */
        window.addEventListener('beforeinstallprompt', (event) => {

            event.preventDefault();

            deferredPrompt = event;

            installButton.classList.remove('hidden');
            manualInstall.classList.add('hidden');

        });


        /*
         * Klik Install
         */
        installButton.addEventListener('click', async () => {

            if (!deferredPrompt) {

                manualInstall.classList.remove('hidden');

                return;
            }

            deferredPrompt.prompt();

            const { outcome } = await deferredPrompt.userChoice;

            console.log('PWA install:', outcome);

            deferredPrompt = null;

        });


        /*
         * Setelah berhasil terinstall
         */
        window.addEventListener('appinstalled', () => {

            deferredPrompt = null;

            installButton.classList.add('hidden');

            installedMessage.classList.remove('hidden');

        });


        /*
         * iPhone / iPad
         */
        const isIOS =
            /iphone|ipad|ipod/i.test(window.navigator.userAgent);

        if (isIOS) {

            installButton.classList.remove('hidden');

            installButton.addEventListener('click', () => {
                manualInstall.classList.remove('hidden');
            });

        }

    });
</script>
