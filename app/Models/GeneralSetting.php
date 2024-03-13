<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class generalSetting extends Model
{
    use HasFactory;

    
    protected $guarded = [];

    protected $table = "general_settings";
}
