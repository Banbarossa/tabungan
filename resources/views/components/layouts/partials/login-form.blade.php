<div class="bg-white rounded-3xl px-6 py-8 sm:px-8"
    style="box-shadow: 0 4px 32px rgba(0,0,0,0.08), 0 1px 4px rgba(0,0,0,0.04);">

    <div class="mb-7">
        <h2 class="font-semibold mb-1.5" style="font-size:1.35rem; color:#1a1a1a; font-family: var(--font-display);">
            Selamat Datang
        </h2>
        <p class="text-sm leading-relaxed" style="color:#6b7280;">
            Silakan masuk untuk mengakses informasi akademik.
        </p>
    </div>

    {{ $slot }}

</div>

{{-- Lupa password --}}
<div class="mt-5 rounded-3xl px-6 py-5 bg-white" style="box-shadow: 0 2px 12px rgba(0,0,0,0.05);">
    <div class="flex items-start gap-3">
        <span class="mt-0.5 shrink-0">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                <circle cx="10" cy="10" r="9" fill="#fef3c7" />
                <path
                    d="M10 5.5C8.343 5.5 7 6.672 7 8.125c0 .345.274.625.611.625.338 0 .611-.28.611-.625C8.222 7.29 9.01 6.75 10 6.75s1.778.54 1.778 1.375c0 .621-.474 1.134-1.167 1.375-.555.19-.944.72-.944 1.313V11.5c0 .345.274.625.611.625.338 0 .611-.28.611-.625v-.526c0-.15.092-.285.226-.332C12.197 10.277 13 9.31 13 8.125 13 6.672 11.657 5.5 10 5.5zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z"
                    fill="#d97706" />
            </svg>
        </span>
        <div class="flex-1">
            <p class="text-sm font-semibold mb-0.5" style="color:#92400e;">Lupa password?</p>
            <p class="text-xs leading-relaxed" style="color:#78350f;">
                Silakan hubungi admin pesantren untuk mendapatkan bantuan reset password.
            </p>
            <a href="https://wa.me/6281234567890" target="_blank" rel="noopener noreferrer"
                class="inline-flex items-center gap-1.5 mt-3 px-4 py-2 rounded-xl text-xs font-semibold transition-smooth focus-ring"
                style="background:#25D366; color:#fff; box-shadow: 0 2px 8px rgba(37,211,102,0.3); text-decoration:none;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                    <path
                        d="M12 0C5.373 0 0 5.373 0 12c0 2.134.558 4.134 1.532 5.876L.057 23.882a.5.5 0 00.613.613l6.006-1.475A11.95 11.95 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.99 0-3.84-.59-5.39-1.598l-.386-.24-4.003.983.983-4.003-.24-.386A9.956 9.956 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z" />
                </svg>
                Hubungi Admin
            </a>
        </div>
    </div>
</div>
