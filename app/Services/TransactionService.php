<?php

namespace App\Services;

use App\Models\Student;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class TransactionService
{
    /**
     * Create a new class instance.
     */
    public $student;

    public function __construct(Student $student)
    {
        $this->student=$student;
    }

    public function transaction($amount,$operator,$type){


        if($operator == '+'){
            $latest_saldo = $this->student->saldo + $amount;
        }else{
            $latest_saldo = $this->student->saldo - $amount;
        }

        DB::transaction(function () use($amount,$latest_saldo,$operator,$type) {

            Transaction::create([
                'student_id'=>$this->student->id,
                'amount'=>$amount,
                'latest_saldo'=>$latest_saldo,
                'type'=>$type,
                'handledby'=>Auth::user()->id,
            ]);

            Student::find($this->student->id)->update([
                'saldo'=>$latest_saldo,
            ]);

            DB::afterCommit(function () use ($latest_saldo) {
                if ($this->student->send_notification) {
                    if ($this->student->notification_target == 'whatsapp') {
                        $this->sendWa($latest_saldo);
                    } elseif ($this->student->notification_target === 'email') {

                    }else{

                    }
                }
            });

        });


    }

    public function sendWa($latest_saldo){
        $nama_siswa = $this->student->name;

        $saldo= format_rupiah($latest_saldo);

$message = "
Tabungan Jajan Siswa Sudah diperbaharui Admin *$nama_siswa*

Nama Santri : $nama_siswa
Saldo Saat Ini : $saldo

Jazaakumullahukhairan

_Pesan ini dikirim secara otomatis mohon tidak membalas_
";

        try {
            $url= config('absen.simaq_url');
            $token= config('absen.simaq_token');
            $response = Http::withHeaders([
                'Authorization' => $token
            ])->post($url/'send_whatsapp', [
                'target' => $this->student->notification_account,
                'musyrif_id' => Auth::user()->id,
                'message' => $message,
                'source' => 'tabungan',
            ]);

            if ($response->successful()) {
                return [
                    'status' => true,
                    'message' => 'Pesan berhasil dikirim.',
                    'response' => $response->json()
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Pengiriman gagal',
                    'http_code' => $response->status(),
                    'response' => $response->body()
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Terjadi error saat mengirim pesan.',
                'error' => $e->getMessage()
            ];
        }


    }
}
