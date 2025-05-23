<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StudentCardController extends Controller
{
    public function singleCard($code = null){

        if($code){
            $id=vinclaDecode($code);
                $siswas = Student::where('id',$id)->get()->map(function($siswa){
                $code=vinclaEncode($siswa->id);
                $siswa->qr =base64_encode(QrCode::format('png')->size(100)->generate($code));
                return $siswa;
            });
        }else{
            $siswas = Student::whereStatus(true)->orderBy('name')->get()->map(function($siswa){
                $code=vinclaEncode($siswa->id);
                $siswa->qr =base64_encode(QrCode::format('png')->size(100)->generate($code));
                return $siswa;
            });
        }



        $pdf = Pdf::loadView('pdf.card-id', compact('siswas'))
                ->setPaper('A4', 'portrait');

        return $pdf->stream('kartu-siswa.pdf');
    }
}
