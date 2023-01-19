<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use JavaScript;
use App\Questionnaire;
use App\QuestionnaireResult;

class QuestionnaireController extends Controller {
	public function __construct() {
		$this->middleware(['auth', 'csrf']);
	}
	public function index() {
    $questionnaires = Questionnaire::where('status','=',1)->get()->sortByDesc('updated_at');
    foreach ($questionnaires as $key => $questionnaire) {
      $statusRes = QuestionnaireResult::where('questionnaire_id','=',$questionnaire->id)->where('user_id','=',Auth()->user()->id)->first();
      if($statusRes === null){
        $questionnaire->statusRes = 0;
      }
      else {
        $questionnaire->statusRes = 1;
      }
    }
		return view('pages.questionnaires', compact('questionnaires'));
	}
  public function form(Request $request) {
    echo $request->questionnaire_id;
  }
  public function submit(Request $request) {
    $user = Auth()->user();
    $key=1;
    $questions = Questionnaire::where('id','=',$request->questionnaire_id)->first()->questionnaire_questions()->get();
    foreach ($questions as $question) {
      if($question->type === 'radio'){

        $user->questionnaire_results()->create([
						'questionnaire_id' => $request->questionnaire_id,
						'question_id' => $question->id,
						'question_form_id' => $request->results[$question->id],
					]);
      }
      if($question->type === 'textarea'){
        $question_form = $question->question_forms()->first()->id;
        $user->questionnaire_results()->create([
						'questionnaire_id' => $request->questionnaire_id,
						'question_id' => $question->id,
						'question_form_id' => $question_form,
            'note' => $request->results[$question->id],
					]);
      }
			if($question->type === 'text'){
        $question_form = $question->question_forms()->first()->id;
        $user->questionnaire_results()->create([
						'questionnaire_id' => $request->questionnaire_id,
						'question_id' => $question->id,
						'question_form_id' => $question_form,
            'note' => $request->results[$question->id],
					]);
      }
    }
    flash()->overlay('Anda Berhasil Mengisi Kuisioner', 'INFO');
    return redirect()->back();
  }
}
