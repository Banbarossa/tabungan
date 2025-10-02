<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PerbaikiController extends Controller
{
    public function tanggal(){
        $tanggal = Transaction::whereNull('date')->get();
        foreach($tanggal as $t){
            $t->date =Carbon::parse($t->created_at)->toDateString();
            $t->save();
        }

    }
}
