<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function options(){
        return $this->hasMany(Question_option::class);
    }

    public function age_group(){
        return $this->hasOne(QuestionTypeAge::class,'id','age_group_id');
    }

}
