<div class="mb-24">
    <x-toast on='transaction_updated'></x-toast>
    @if (!$student)
    <div class="text-center">
        <h1 class="text-xl font-bold mb-2">Scan QR untuk Cari Siswa</h1>

        <div id="qr-reader" class="mx-auto rounded-lg border-2 overflow-hidden" style="width: 300px;"></div>

        <input  wire:model="qrResult" id="qrResult">
    </div>
    @endif

    @if ($student)
    <div class="lg:flex gap-3">
        <div class="lg:order-2 max-w-lg w-full mb-4">
            <livewire:cashier.studend-detail-card :student="$student"/>
        </div>
        <div class="w-full max-w-lg">
            <div class=" border rounded-lg p-4">
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <flux:text>Saldo</flux:text>
                        <flux:heading size="lg" class="mb-2">{{format_rupiah($student->saldo)}}</flux:heading>
                    </div>
                    <div>
                        <flux:text>Limit Harian</flux:text>
                        <flux:heading size="lg" class="mb-2">{{format_rupiah($dailyLimit)}}</flux:heading>
                    </div>
                </div>
                <flux:separator text="Penarikan" />
                <form action="" wire:submit='transaction' class="mt-8">
                <flux:input.group>
                    <flux:input.group.prefix>Rp</flux:input.group.prefix>
                    <flux:input x-mask:dynamic="$money($input, ',', '.')" wire:model="amount"  />
                </flux:input.group>
                <flux:error name="amount" />

                <div class="flex items-center justify-end mt-8">
                    <flux:button type="submit" variant="primary" class="w-full">
                        Tarik
                    </flux:button>
                </div>
            </form>
            </div>
        </div>
    </div>
    @if (!empty($history))
    <div>
        <flux:heading size="lg" class="mt-6">Riwayat</flux:heading>
        <div class="rounded-lg p-4 border max-w-lg">
            <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($history as $item)
                <li class="pb-3 sm:pb-4">
                    <div class="flex items-center space-x-4 rtl:space-x-reverse">
                        <div class="shrink-0">
                            <div class="w-8 h-8 rounded-full {{  $item->type =='setor' ?'bg-green-400/70' :'bg-red-400/70' }} flex items-center justify-center" >
                                <flux:icon.inbox-arrow-down class="size-4 text-zinc-50"></flux:icon.inbox-arrow-down>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                            {{ $item->type =='setor' ?'Setoran':'Penarikan' }}
                            </p>
                            <p class="text-xs text-gray-500 truncate dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($item->create_at)->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <div class="inline-flex items-center text-base font-semibold  {{  $item->type =='setor' ?'text-green-700 dark:text-green-200' :'text-gray-900 dark:text-white' }} ">
                            {{ $item->type =='setor' ?'+':'-' }}{{ format_rupiah($item->amount) }}
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>

    </div>

    @endif

    @endif
    @script
    <script>

        let qrScanner;

            function startQrScanner() {
                if (!window.Html5QrcodeScanner) return;

                // Hapus scanner sebelumnya jika ada
                if (qrScanner) {
                    qrScanner.clear().catch(e => console.warn(e));
                    qrScanner = null;
                }

                qrScanner = new Html5QrcodeScanner("qr-reader", { fps: 10, qrbox: 250 });
                qrScanner.render(success => {
                    $wire.getData(success);
                    qrScanner.clear(); // stop scanning setelah satu scan
                }, error => {
                    console.log(error);
                });
            }

            document.addEventListener('livewire:initialized', () => {
                startQrScanner();
            });

            // Dengarkan event Livewire untuk memulai ulang scanner
            Livewire.on('transaction_updated', () => {
                startQrScanner();
            });

        // document.addEventListener('livewire:initialized', () => {
        //     if (window.Html5QrcodeScanner) {
        //         const scanner = new Html5QrcodeScanner(
        //             "qr-reader", { fps: 10, qrbox: 250 });

        //         scanner.render(success => {
        //             $wire.$call('getData',success)
        //             scanner.clear(); // Optional: berhenti setelah scan
        //         }, error => {
        //             console.log(error)
        //         });
        //     }
        // });

        // Livewire.on('transaction_updated', () => {
        //     startQrScanner();
        // });
    </script>
    @endscript
</div>

