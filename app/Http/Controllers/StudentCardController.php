<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StudentCardController extends Controller
{
    public function singleCard($id = null){

        $dns1d = new DNS1D();
        $dns2d = new DNS2D();
        $dns1d->setStorPath(storage_path('framework/barcodes/'));
        $dns2d->setStorPath(storage_path('framework/barcodes/'));


        if($id){
            $siswas = Student::where('id',$id)->get()->map(function($siswa)use ($dns1d, $dns2d)  {

            $siswa->qr = 'data:image/png;base64,' . $dns2d->getBarcodePNG($siswa->nisn, 'QRCODE');

            $siswa->barcode = 'data:image/png;base64,' . $dns1d->getBarcodePNG($siswa->nisn, 'C39',1,50,[0,0,0]);



            return $siswa;


            });
        }else{
            $siswas = Student::whereStatus(true)->orderBy('name')->get()->map(function($siswa) use ($dns1d, $dns2d) {
                $nisn=$siswa->nisn;
                $siswa->qr = 'data:image/png;base64,' . $dns2d->getBarcodePNG($nisn, 'QRCODE');
                $siswa->barcode = 'data:image/png;base64,' . $dns1d->getBarcodePNG($nisn, 'C128',1,50,[0,0,0]);
                return $siswa;
            });
        }


        $pdf = Pdf::loadView('pdf.card-id', compact('siswas'))
                ->setPaper('A4', 'portrait');

        return $pdf->stream('kartu-siswa.pdf');
    }
}
