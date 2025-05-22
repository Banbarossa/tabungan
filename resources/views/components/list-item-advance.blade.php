@props(['label'])
<li class="py-1 ">
    <div class="flex items-center space-x-4 rtl:space-x-reverse">
        @if (isset($icon))
        <div class="shrink-0">
            {{ $icon }}
        </div>
        @endif


        <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
            {{ $label }}
            </p>
        </div>
        @if (isset($value))
            {{ $value }}
        @endif
    </div>
</li>
