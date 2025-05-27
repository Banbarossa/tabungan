<?php

namespace App\Services;

use App\Models\Settingwhatsapp;
use App\Models\Student;
use App\Models\Transaction;
use App\Traits\DailyReportDataTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class TransactionService
{

    use DailyReportDataTrait;
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

            DB::afterCommit(function () use ($latest_saldo,$operator,$amount) {
                if(cekSendMessage($operator)){
                    $this->sendWa($amount,$latest_saldo,$operator);

                }

            });

        });


    }

    public function sendWa($amount,$latest_saldo,$operator){
        if(is_null($this->student->notification_account)){
            return;
        }

        $tanggal = Carbon::now()->format('d-m-Y');
        $nama_santri = $this->student->name;
        $kelas = $this->student->kelas;
        $jumlah = format_rupiah($amount);
        $saldo_akhir= format_rupiah($latest_saldo);
        $cashier= Auth::user()->name;


        $set =Settingwhatsapp::latest()->first();
        if($operator == '+'){
            $template =$set->template_setor;
        }elseif($operator == '-'){
            $template =$set->template_tarik;
        }


        $message = renderTemplate($template, [
            'tanggal' => $tanggal,
            'nama_santri' => $nama_santri,
            'kelas' => $kelas,
            'jumlah' => $jumlah,
            'saldo_akhir' => $saldo_akhir,
            'cashier' => $cashier,
        ]);



        try {
            $url= config('absen.simaq_url');
            $token= config('absen.simaq_token');
            $response = Http::withHeaders([
                'Authorization' => $token
            ])->post($url.'send_whatsapp', [
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
