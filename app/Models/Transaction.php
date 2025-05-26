<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory;

    protected $guarded=[];

    public function student(){
        return $this->belongsTo(Student::class);
    }

    public function handledbyUser()
    {
        return $this->belongsTo(User::class,'handledby');
    }
}
