<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class GetStudentApi extends Controller
{
    public function getDataAbsen(){
        $url = config('absen.url');
        $token = config('absen.token');

        $response = Http::withHeader('Authorization',$token)
            ->get($url);

        if($response->status() == 200){
            $data= $response->json('data');
            foreach($data as $item){
                Student::firstOrCreate([
                    'absen_id'=>$item['id'],
                ],[
                    'account_number'=>'',
                    'name'=>$item['name'],
                    'nisn'=>$item['nisn'],
                    'nis'=>$item['nis'],
                    'kelas'=>$item['nama_rombel'],
                    'nama_ibu'=>'',
                    'status'=>$item['status'],
                    'send_notification'=>true,
                    'notification_target'=>'whatsapp',
                    'notification_account'=>$item['no_hp'],

                ]);

            }

            return "Success";

        }


    }
}
