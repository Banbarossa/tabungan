<div>
    @if (!$student)
    <div class="text-center">
        <h1 class="text-xl font-bold mb-2">Scan QR untuk Cari Siswa</h1>

        <div id="qr-reader" class="mx-auto rounded-lg border-2" style="width: 300px;"></div>

        <input  wire:model="qrResult" id="qrResult">
    </div>
    @endif

    <div class="mt-4">
        @if($student)
            <div class="p-4 bg-green-100 rounded">
                <p><strong>Nama:</strong> {{ $student->name }}</p>
                <p><strong>NIS:</strong> {{ $student->nis }}</p>
                <p><strong>NISN:</strong> {{ $student->nisn }}</p>

                <flux:input.group>
                    <flux:input.group.prefix>Rp</flux:input.group.prefix>
                    <flux:input x-mask:dynamic="$money($input, ',', '.')" wire:model="tambahan"  />
                </flux:input.group>

            </div>
        @endif
    </div>
    @script
    <script>
        document.addEventListener('livewire:initialized', () => {
            if (window.Html5QrcodeScanner) {
                const scanner = new Html5QrcodeScanner(
                    "qr-reader", { fps: 10, qrbox: 250 });

                scanner.render(success => {
                    $wire.$call('getData',success)
                    scanner.clear(); // Optional: berhenti setelah scan
                }, error => {
                    console.log(error)
                });
            }
        });
    </script>
    @script
</div>

