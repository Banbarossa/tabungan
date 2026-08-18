<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetaSetting extends Model
{
    /** @use HasFactory<\Database\Factories\MetaSettingFactory> */
    use HasFactory;

    protected $guarded = ['id'];
}
