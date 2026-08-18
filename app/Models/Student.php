<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use NotificationChannels\WebPush\HasPushSubscriptions;

class Student extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory,Notifiable, HasPushSubscriptions;

    protected $guarded=[];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getAvatarAttribute()
    {
        if ($this->photo && Storage::disk('public')->exists($this->photo)) {
            return asset('storage/' . $this->photo);
        }

        return asset('images/avatar.jpg');
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

    public function messages(){
        return $this->hasMany(Message::class);
    }

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

}
