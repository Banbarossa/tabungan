<div>
{{--    $table->foreignId('student_id')->constrained()->cascadeOnDelete();--}}
{{--    $table->bigInteger('amount');--}}
{{--    $table->bigInteger('latest_saldo');--}}
{{--    $table->enum('type',['setor','tarik','jajan']);--}}
{{--    $table->foreignId('handledby')->nullable()->constrained('users')->onDelete('set null');--}}
{{--    $table->foreignId('verifiedBy')->nullable()->constrained('users')->onDelete('set null');--}}

    <form wire:submit.prevent="save">
        <div class="space-y-4">
            <flux:input type="date" wire:model="date"></flux:input>
            <flux:input type="date" wire:model="amount"></flux:input>
        </div>
    </form>
</div>
