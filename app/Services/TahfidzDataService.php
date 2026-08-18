<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TahfidzDataService
{
    public function getData(string $endpoint, $filter = null)
    {
        $simaquri = config('absen.simaq_url');
        $token = config('absen.simaq_token');
        $uri = $simaquri . $endpoint;

        try {
            $response = Http::withHeader('Authorization', $token)->timeout(16)
                ->acceptJson()
                ->get($uri, $filter);


            if (!$response->successful()) {
                return [
                    'success' => false,
                    'message' => "Data gagal diperoleh dari server,cobalah beberapa saat lagi",
                ];
            }
            $json = $response->json();
            if (!data_get($json, 'success')) {
                return [
                    'success' => false,
                    'message' => "Data Tidak ditemukan diserver",
                ];
            }
            $data = data_get($json, 'data');
            return [
                'success' => true,
                'message' => 'Data berhasil ditemukan',
                'data' => $data
            ];
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return [
                'success' => false,
                'message' => "Terjadi kesalahan",
            ];
        }
    }
}
