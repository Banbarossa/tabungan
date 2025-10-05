<?php

namespace App\Services;

use App\Models\Message;
use App\Models\Settingwhatsapp;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class WhatsappService
{

    public $token;
    public function __construct()
    {
        $setting_wa = Settingwhatsapp::latest()->first();
        if ($setting_wa && $setting_wa->token_wa) {
            $this->token = $setting_wa?->token_wa ?? null;
        }

    }

    public function send($target, $message, $delay = 0, $user_id, $source = 'tabsis', )
    {
        try {
            $koneksi = $this->cekKoneksi();

            if (!$koneksi || $koneksi->device_status !== 'connect') {
                return [
                    'success' => false,
                    'message' => 'Perangkat tidak terhubung.',
                    'data' => null,
                ];
            }

            $client = new Client();

            $response = $client->post("https://api.fonnte.com/send", [
                'headers' => [
                    'Authorization' => $this->token,
                ],
                'form_params' => [
                    'target' => $target,
                    'message' => $message,
                    'delay' => $delay,
                ],
            ]);


            $statusCode = $response->getStatusCode();
            $response = $response->getBody()->getContents();

            $res = json_decode($response);


            if($statusCode == 200){

                foreach ($res->id as $k => $value) {
                    $target = $res->target[$k];
                    $status = $res->process;

                    Message::create([
                        'source' => $source,
                        'message_id' => $value,
                        'target' => $target,
                        'message' => $message,
                        'status' => $status,
                        'user_id' => $user_id,
                    ]);

                }
                return [
                    'success' => true,
                    'message' => 'Pesan berhasil dikirim.',
                    'data' => $res,
                ];
            }


        } catch (\Throwable $th) {
            Log::info('Whatsapp Gagal dikirim dengan alasan :' . $th);
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $th->getMessage(),
                'data' => null,
            ];
        }

    }
    public function cekKoneksi()
    {
        if (!$this->token) {
            return null;
        }

        try {
            $client = new Client();
            $response = $client->post('https://api.fonnte.com/device', [
                'headers' => [
                    'Authorization' => $this->token,
                ],
            ]);

            return json_decode($response->getBody()->getContents());

        } catch (\Throwable $th) {
            Log::error('Gagal mengecek koneksi WhatsApp: ' . $th->getMessage());
            return null;
        }

    }

}
