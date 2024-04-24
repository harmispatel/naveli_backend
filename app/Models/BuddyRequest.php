<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuddyRequest extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function sender(){
        return $this->hasOne(User::class,'id','sender_id');
    }
}
