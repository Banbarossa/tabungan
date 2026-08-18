<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
    @PwaHead
</head>

<body class="min-h-screen  antialiased ">
    {{-- <div class="min-h-screen bg-[#f4f4f6] flex flex-col lg:flex-row"> --}}
    <div class="h-screen overflow-hidden bg-[#f4f4f6] flex flex-col lg:flex-row">

        <x-layouts.partials.branding />
        <div class=" h-screen overflow-y-auto flex-1">

            {{ $slot }}
        </div>
    </div>
    @fluxScripts
    @RegisterServiceWorkerScript
</body>

</html>
