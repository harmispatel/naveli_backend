<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubQuestion extends Model
{
    use HasFactory;

    public function question(){
        return $this->hasOne(Question::class, 'id', 'question_id');
    }

    public function option(){
        return $this->hasOne(Question_option::class, 'id', 'option_id');
    }

    public function sub_option(){
        return $this->hasOne(SubOption::class, 'id', 'sub_option_id');
    }

    public function sub_question(){
        return $this->hasOne(QuestionOrNotification::class, 'id', 'sub_question_id');
    }
}
