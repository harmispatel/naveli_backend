<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumComment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function users(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function forum(){
        return $this->hasOne(Forum::class,'id','forum_id');
    }
}
