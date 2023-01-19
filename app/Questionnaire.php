<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'title', 'status',
  ];

  public function questionnaire_questions(){
    return $this->hasMany('App\Question');
  }
  public function questionnaire_results(){
    return $this->hasMany('App\QuestionnaireResult');
  }
}
