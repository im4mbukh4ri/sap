<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Question;

class QuestionForm extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'question_id', 'text', 'required',
  ];

  public function question(){
    return $this->belongTo(Question::class);
  }

  public function form_results(){
    return $this->hasMany('App\QuestionnaireResult');
  }
}
