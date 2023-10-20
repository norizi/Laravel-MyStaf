<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'question',
        'question_type_id'
    ];

    public function question_options(){
        return $this->hasMany('App\Models\QuestionOption','question_id')->orderBy('question_option');;
    }
    /*
    public function user_answers(){
        return $this->belongsTo('App\Models\UserAnswer','question_id');
    }
    */

    public function question_types(){
        return $this->hasMany('App\Models\QuestionType','question_type_id');
    }

}
