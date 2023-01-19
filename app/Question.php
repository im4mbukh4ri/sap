<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Questionnaire;

class Question extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'questionnaire_id', 'question', 'type', 'required',
  ];

  public function questionnaire(){
    return $this->belongTo(Questionnaire::class);
  }

  public function question_forms(){
    return $this->hasMany('App\QuestionForm');
  }
  public function form_results(){
    return $this->hasMany('App\QuestionnaireResult');
  }
}
