<div>
    <div id="push-banner"
        class=" hidden fixed bottom-20 left-4 right-4 max-w-sm bg-red-900 text-white p-4 rounded-xl shadow-2xl z-50 border border-rose-900/40">
        <p class="m-0 mb-3 text-sm text-rose-100 leading-relaxed">
            Aktifkan notifikasi agar Anda tidak ketinggalan info penting dari kami.
        </p>
        <div class="flex gap-2 justify-end">
            <button id="push-banner-enable" type="button"
                class="bg-rose-800 hover:bg-rose-700 active:bg-rose-900 text-white font-medium text-sm px-4 py-2 rounded-lg transition-colors cursor-pointer shadow-sm">
                Aktifkan
            </button>
            <button id="push-banner-dismiss" type="button"
                class="bg-transparent hover:bg-rose-900/50 text-rose-200 hover:text-white text-sm px-4 py-2 rounded-lg transition-colors cursor-pointer">
                Nanti saja
            </button>
        </div>
    </div>
    <script>
        const VAPID_PUBLIC_KEY = "{{ config('webpush.vapid.public_key') }}";
        const DISMISS_KEY = 'push_banner_dismissed_until';

        function urlBase64ToUint8Array(base64String) {
            const padding = '='.repeat((4 - base64String.length % 4) % 4);
            const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
            const rawData = window.atob(base64);
            return Uint8Array.from([...rawData].map(char => char.charCodeAt(0)));
        }

        function isDismissedForNow() {
            const until = localStorage.getItem(DISMISS_KEY);
            return until && Date.now() < parseInt(until, 10);
        }

        function dismissBannerFor(days) {
            const until = Date.now() + days * 24 * 60 * 60 * 1000;
            localStorage.setItem(DISMISS_KEY, until.toString());
        }

        async function maybeShowPushBanner() {
            if (!('serviceWorker' in navigator) || !('PushManager' in window)) return;
            if (Notification.permission !== 'default') return;
            if (isDismissedForNow()) return;

            const banner = document.getElementById('push-banner');
            if (banner) {
                banner.classList.remove('hidden');
                banner.classList.add('block');
            }
        }

        async function enablePushFromBanner() {
            const banner = document.getElementById('push-banner');
            try {
                const permission = await Notification.requestPermission();

                if (permission !== 'granted') {
                    dismissBannerFor(7);
                    hideBanner(banner);
                    return;
                }

                const registration = await navigator.serviceWorker.ready;
                const subscription = await registration.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey: urlBase64ToUint8Array(VAPID_PUBLIC_KEY),
                });

                await fetch('/push-subscriptions', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify(subscription),
                });

                hideBanner(banner);
            } catch (err) {
                console.error('Gagal aktifkan push notification:', err);
                hideBanner(banner);
            }
        }

        function hideBanner(element) {
            if (!element) return;
            element.classList.remove('block');
            element.classList.add('hidden');
        }

        document.getElementById('push-banner-enable')?.addEventListener('click', enablePushFromBanner);
        document.getElementById('push-banner-dismiss')?.addEventListener('click', function() {
            dismissBannerFor(3);
            hideBanner(document.getElementById('push-banner'));
        });

        document.addEventListener('DOMContentLoaded', maybeShowPushBanner);
    </script>
</div>
