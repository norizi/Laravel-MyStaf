<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    use HasFactory;
    protected $table = 'question_options';
    protected $fillable = [
        'question_option',
        'question_id',
        'is_correct'
    ];

    public function questions(){
        return $this->belongsTo('App\Models\Questions','id');
    }

    public function user_answers(){
        return $this->belongsTo('App\Models\UserAnswer','id');
    }

}
