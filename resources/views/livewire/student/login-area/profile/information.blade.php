<div class="px-4">
    <div class="bg-white rounded-2xl p-4 shadow">
        <h3 class="font-display font-bold text-gray-800 text-sm mb-3">Informasi Akun</h3>
        <div class="space-y-3">
            @foreach ($accountInfo as $r)
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-400">{{ $r['label'] }}</span>
                    <div class="flex items-center gap-1.5">
                        <span class="text-xs font-semibold text-gray-700">{{ $r['value'] }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
