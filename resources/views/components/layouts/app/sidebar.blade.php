<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-slate-100 dark:bg-zinc-800">
    <div>
        <x-layouts.partials.admin-sidebar />
    </div>
    <x-layouts.partials.admin-mobile-header />

    {{ $slot }}


    <x-settings.modal-setting />

    @stack('script')
    @fluxScripts
</body>

</html>
