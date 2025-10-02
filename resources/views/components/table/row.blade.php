@props(['variant'=>'default'])

@php
    $baseClass = "border-b border-gray-200 dark:border-gray-700";
    $variants = [
        'default'  => "bg-white dark:bg-zinc-800",
        'stripped' => "odd:bg-white odd:dark:bg-zinc-800 even:bg-gray-50 even:dark:bg-zinc-700",
        'hovered'  => "bg-white dark:bg-zinc-800 hover:bg-gray-50 dark:hover:bg-zinc-600",
    ];

    $classes = $baseClass . ' ' . ($variants[$variant] ?? $variants['default']);
@endphp

<tr {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</tr>

