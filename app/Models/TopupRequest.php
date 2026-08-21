<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TopupRequest extends Model
{
    protected $guarded = ['id'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'veriverification_by');
    }

    public function getImageResiAttribute()
    {
        return $this->file_path
            ? Storage::url($this->file_path)
            : null;
    }
}
