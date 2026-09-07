<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

class OneTimeToken extends Model
{
    use Prunable;
    protected $guarded = ['id'];

    public function prunability(){
        return static::where('is_used',true)->orWhere('expired_at','<',now()->subDays(5));
    }

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'is_used' => 'boolean',
            'is_success_transaction' => 'boolean',
        ];
    }
    public function student(){
        return $this->belongsTo(Student::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
