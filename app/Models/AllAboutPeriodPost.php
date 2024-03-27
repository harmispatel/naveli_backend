<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllAboutPeriodPost extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category(){
        return $this->hasOne(AllAboutPeriodCategory::class,'id','category_id');
    }

    public function media()
    {
        return $this->hasMany(AllAboutPeriodPostMedia::class, 'post_id');
    }
}
