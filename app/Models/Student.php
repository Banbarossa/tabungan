<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;

    protected $guarded=[];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }

    protected function noId(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $this->generateNoId($attributes)
        );
    }

    private function generateNoId(array $attributes): ?string
    {
        $nisn = $attributes['nisn'] ?? null;
        $nis = $attributes['nis'] ?? null;

        if ($nisn && $nis) {
            return $nisn . '-' . $nis;
        }

        if ($nisn) {
            return $nisn;
        }

        if ($nis) {
            return $nis;
        }

        return null;
    }

}
