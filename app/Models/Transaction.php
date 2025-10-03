<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $guarded=[];

    public function student(){
        return $this->belongsTo(Student::class);
    }

    public function handledbyUser()
    {
        return $this->belongsTo(User::class,'handledby');
    }

    public function verifiedByUser()
    {
        return $this->belongsTo(User::class,'verifiedBy');
    }
    public function metode(){
        return $this->belongsTo(JenisTransaksi::class,'jenis_transaksi_id','id');
    }
}
