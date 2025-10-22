<?php

namespace App\Services;

use App\Jobs\ProcessPendingMessageJob;
use App\Models\Message;
use App\Models\Settingwhatsapp;
use App\Models\Student;
use App\Models\Transaction;
use App\Traits\DailyReportDataTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use function PHPUnit\Framework\isEmpty;

class TransactionService
{

    use DailyReportDataTrait;

    /**
     * Create a new class instance.
     */
    public $student;

    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    public function transaction($amount, $operator, $type, $date, $description = null, $jenis_transaksi_id = 1)
    {

        $date = Carbon::parse($date)->toDateString();
        $jumlah = Transaction::whereDate('created_at', Carbon::now()->toDateString())
            ->withTrashed()
            ->count();
        if ($operator == '+') {
            $latest_saldo = $this->student->saldo + $amount;
        } else {
            $latest_saldo = $this->student->saldo - $amount;
        }
        $invoice_number = Carbon::now()->format('Ymd') . '-' . $jumlah + 1;

        DB::transaction(function () use ($amount, $latest_saldo, $operator, $type, $date, $description, $invoice_number, $jenis_transaksi_id) {

            Transaction::create([
                'invoice_number' => $invoice_number,
                'student_id' => $this->student->id,
                'amount' => $amount,
                'latest_saldo' => $latest_saldo,
                'type' => $type,
                'handledby' => Auth::user()->id,
                'date' => $date,
                'description' => $description ?? null,
                'jenis_transaksi_id' => $jenis_transaksi_id,
            ]);

            Student::find($this->student->id)->update([
                'saldo' => $latest_saldo,
            ]);

            DB::afterCommit(function () use ($latest_saldo, $operator, $amount, $date, $description) {
                if (cekSendMessage($operator)) {

                    $this->generateMessage($amount, $latest_saldo, $operator, $date, $description);

                }

            });

        });


    }

    public function generateMessage($amount, $latest_saldo, $operator, $date, $description)
    {
        $targets = [];
        $target1 = $this->student->notification_account ?? null;
        $target2 = $this->student->no_hp_ayah ?? null;

        if ($target1) {
            $targets[] = $target1;
        }
        if ($target2) {
            $targets[] = $target2;
        }

        if (empty($targets)) {
            return;
        }


        $tanggal = Carbon::parse($date)->format('d-m-Y');
        $nama_santri = $this->student->name;
        $kelas = $this->student->kelas;
        $jumlah = format_rupiah($amount);
        $saldo_akhir = format_rupiah($latest_saldo);
        $cashier = Auth::user()->name;
        $keterangan = $description ?? null;


        $set = Settingwhatsapp::latest()->first();
        if ($operator == '+') {
            $template = $set->template_setor;
        } elseif ($operator == '-') {
            $template = $set->template_tarik;
        }


        $message = renderTemplate($template, [
            'tanggal' => $tanggal,
            'nama_santri' => $nama_santri,
            'kelas' => $kelas,
            'jumlah' => $jumlah,
            'saldo_akhir' => $saldo_akhir,
            'cashier' => $cashier,
            'keterangan' => $keterangan,
        ]);


        try {
            foreach ($targets as $target) {
                Message::create([
                    'message_id' => null,
                    'source' => 'tabsis',
                    'device' => '',
                    'target' => $target,
                    'message' => $message,
                    'stateid' => '',
                    'status' => '',
                    'state' => '',
                    'user_id' => Auth::user()->id,
                    'student_id' => $this->student->id,
                    'sending_status' => 'pending',

                ]);
            }
            dispatch(new ProcessPendingMessageJob());

//            $service = new WhatsappService();
//            $koneksi = $service->cekKoneksi();
//
//            if ($koneksi && $koneksi->device_status == 'connect') {
//                $service->send(
//                    target: $this->student->notification_account,
//                    message: $message,
//                    delay: 0,
//                    user_id: Auth::user()->id,
//                    source: 'tabsis',
//
//
//                );
//            } else {
//                $url = config('absen.simaq_url');
//                $token = config('absen.simaq_token');
//                $response = Http::withHeaders([
//                    'Authorization' => $token
//                ])->post($url . 'send_whatsapp', [
//                    'target' => $this->student->notification_account,
//                    'musyrif_id' => Auth::user()->id,
//                    'message' => $message,
//                    'source' => 'tabungan',
//                ]);
//                if ($response->successful()) {
//                    return [
//                        'status' => true,
//                        'message' => 'Pesan berhasil dikirim.',
//                        'response' => $response->json()
//                    ];
//                } else {
//                    return [
//                        'status' => false,
//                        'message' => 'Pengiriman gagal',
//                        'http_code' => $response->status(),
//                        'response' => $response->body()
//                    ];
//                }
//
//            }

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return [
                'status' => false,
                'message' => 'Terjadi error saat mengirim pesan.',
                'error' => $e->getMessage()
            ];
        }


    }


}
