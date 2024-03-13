<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentUpload extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = "content_uploads";
}
