<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;

    protected $guarded =[];

    public function forumCategory(){
        return $this->hasOne(ForumCategory::class,'id','forum_category_id');
    }
    public function forumSubCategory(){
        return $this->hasOne(ForumCategory::class,'id','forum_subcategory_id');
    }
}
