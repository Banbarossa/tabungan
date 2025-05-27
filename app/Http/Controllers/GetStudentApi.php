<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Support\Facades\Http;

class GetStudentApi extends Controller
{
    public function getDataAbsen(){
        $url = config('absen.url');
        $token = config('absen.token');
        $simaq_url = config('absen.simaq_url').'santri';
        $simaq_token = config('absen.simaq_token');

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


        }

        $simaqresource = Http::withHeader('Authorization',$simaq_token)
            ->get($simaq_url);

        if($simaqresource->status()==200){
            $data = $simaqresource->json();

            foreach($data as $hp){
                $student = Student::where('absen_id',$hp->absen_student_id)->first();
                if($student){
                    $student->update(['notification_account',$hp->no_hp]);
                }
            }

        }

        return 'Success menarik data';



    }
}
