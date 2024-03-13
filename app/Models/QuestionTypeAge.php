<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionTypeAge extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'question_type_ages';

    public function question(){
      return $this->belongsTo(Question::class, 'age_group_id', 'id');
    }
}
