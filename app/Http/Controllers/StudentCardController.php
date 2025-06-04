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
    public function singleCard($code = null){

        $dns1d = new DNS1D();
        $dns2d = new DNS2D();
        $dns1d->setStorPath(storage_path('framework/barcodes/'));
        $dns2d->setStorPath(storage_path('framework/barcodes/'));

        if($code){
            $id=vinclaDecode($code);
                $siswas = Student::where('id',$id)->get()->map(function($siswa)use ($dns1d, $dns2d)  {
                $code=vinclaEncode($siswa->id);
                // $siswa->qr =base64_encode(QrCode::format('png')->size(100)->generate($code));

                $siswa->qr = 'data:image/png;base64,' . $dns2d->getBarcodePNG($code, 'QRCODE');

                $siswa->barcode = 'data:image/png;base64,' . $dns1d->getBarcodePNG($code, 'C128',0.8,30,[255,255,255]);

                return $siswa;
            });
        }else{
            $siswas = Student::whereStatus(true)->orderBy('name')->get()->map(function($siswa) use ($dns1d, $dns2d) {
                $code=vinclaEncode($siswa->id);
                $siswa->qr = 'data:image/png;base64,' . $dns2d->getBarcodePNG($code, 'QRCODE');
                $siswa->barcode = 'data:image/png;base64,' . $dns1d->getBarcodePNG($code, 'C128',0.8,30,[255,255,255]);
                // $siswa->qr =base64_encode(QrCode::format('png')->size(100)->generate($code));
                return $siswa;
            });
        }



        $pdf = Pdf::loadView('pdf.card-id', compact('siswas'))
                ->setPaper('A4', 'portrait');

        return $pdf->stream('kartu-siswa.pdf');
    }
}
