<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Questionnaire;
use App\Question;
use App\QuestionForm;

class QuestionnaireResult extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'user_id', 'questionnaire_id', 'question_id', 'question_form_id', 'note',
  ];

  public function user(){
    return $this->belongTo(User::class);
  }
  public function questionnaire(){
    return $this->belongTo(Questionnaire::class);
  }
  public function question(){
    return $this->belongTo(Question::class);
  }
  public function question_form(){
    return $this->belongTo(QuestionForm::class);
  }
}
