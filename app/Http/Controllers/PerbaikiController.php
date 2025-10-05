<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PerbaikiController extends Controller
{
    public function tanggal(){
        $trans = Transaction::where('jenis_transaksi_id',null)->get();
        foreach($trans as $tran){
            $tran->update([
                'jenis_transaksi_id'=>1,
            ]);
        }

        return 'Success meperbaiki data';
    }
}
