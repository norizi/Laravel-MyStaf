<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;
    protected $table = 'user_answers';
    protected $fillable = [
        'question_option_id','user_id',
        'question_id',
        'answer'
    ];

    public function questions(){
        return $this->belongsTo('App\Models\Question','question_id');
    }

    public function question_options(){
        return $this->belongsTo('App\Models\QuestionOption','question_option_id');
    }

    public function question_answer_correct()
    {
        $ts = QuestionOption::where([['question_id', $this->question_id], ['is_correct', 1]])->first();
        if($ts != null)
        {
            return $ts->question_option;
        }else{
            return null;
        }
        
    }

    public function users(){
        return $this->belongsTo('App\Models\User','user_id');
    }
}
