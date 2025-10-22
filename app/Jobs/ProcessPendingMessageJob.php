<?php

namespace App\Jobs;

use App\Models\Message;
use App\Services\WhatsappService;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessPendingMessageJob implements ShouldQueue, ShouldBeUnique
{
    use Queueable;
    public $uniqueFor = 60;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $service = new WhatsappService();
        $koneksi = $service->cekKoneksi();
        if (!$koneksi || $koneksi->device_status !== 'connect') {
            \Log::warning('Device tidak connect. Kirim pesan ditunda.');
            return;
        }

        Message::whereNull('message_id')
            ->whereNotNull('target')
            ->where('sending_status','pending')
            ->orderBy('created_at')
            ->chunk(10, function ($messages) {
                foreach ($messages as $i => $msg) {
                    $msg->update([
                        'sending_status' => 'processing',
                    ]);
                    ProcessSingleMessageJob::dispatch($msg->id)
                        ->delay(now()->addSeconds($i * 30));
                }
            });



    }
}
