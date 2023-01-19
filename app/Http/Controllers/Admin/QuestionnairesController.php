<?php

namespace App\Http\Controllers\Admin;

use App\Questionnaire;
use App\Question;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use JavaScript;
use Log;

class QuestionnairesController extends Controller {
	public function __construct() {
		$this->middleware(['auth', 'csrf']);
	}

	public function index() {
		$questionnaires = Questionnaire::all();
		return view('admin.questionnaires.index', compact('questionnaires'));
	}

  public function status(Request $request) {
		// dd();
		$data = Questionnaire::find($request->id);
		$data->status = $request->status;

		if($request->status == 1){
			$data->status = $request->status;
			flash()->overlay('Questionnaire Berhasil Dibuka.', 'INFO');
		} else {
			$data->status = $request->status;
			flash()->overlay('Questionnaire Berhasil Ditutup.', 'INFO');
		}
		$data->update();
		return redirect(route('admin.questionnaires_index'));
	}

  public function result($id) {
    $questionnaire = Questionnaire::where('id', '=', $id)->first();
    if($questionnaire === null){
      flash()->overlay('Questionnaire Tidak Ditemukan!', 'WARNING');
      return redirect(route('admin.questionnaires_index'));
    }
    $questions = $questionnaire->questionnaire_questions()->get();
    // dd($questionnaire);
    $data = $questionnaire->questionnaire_results()->groupBy('user_id')->get();
    // dd(count($data));
    // $question_forms[] = null;
    $questionnaire->count = count($data);
    // dd($questionnaire);
    $question_forms;
    // dd($questions);
    $lavas;
   // See note below for Laravel

    // $reasons = $lava->DataTable();




    foreach($questions as $key => $question){
      // dd($question);
      // $lavas[$question->id] = new Lavacharts;
      // $reasons[$question->id] = $lavas[$question->id]->DataTable();
      // $reasons[$question->id]->addStringColumn('Reasons')
      //                        ->addNumberColumn('Percent');
      $question_forms[$question->id] = $question->question_forms()->get();
      foreach ($question_forms[$question->id] as $kooy => $question_form) {
        // dd($question_forms);
        $question_form->count = count($question_form->form_results()->get());
        // $reasons[$question->id]->addRow([$question_form->text, $question_form->count]);
      }
      // $lavas[$question->id]->DonutChart('IMDB', $reasons[$question->id], [
          // 'title' => $question->title
      // ]);
      // dd($question_forms[$question->id]);
    }
    // dd($question_forms);
    // dd($questions);
    // dd($lavas);
    $val = $questionnaire;
    $forms = $question_forms;
		// dd($val);
    return view('admin.questionnaires.result', compact('val', 'questions', 'forms'));
  }

  public function detail($id) {
    $question = Question::where('id', '=', $id)->first();
    if($question === null){
      flash()->overlay('Question Tidak Ditemukan!', 'WARNING');
      return redirect(route('admin.questionnaires_index'));
    }
    if($question->type === 'radio'){
      flash()->overlay('Question Tidak Ditemukan!', 'WARNING');
      return redirect(route('admin.questionnaires_index'));
    }
    $questionnaire = Questionnaire::where('id', '=', $question->questionnaire_id)->first();
    // dd($questionnaire);
    $data = $questionnaire->questionnaire_results()->groupBy('user_id')->get();
    // dd(count($data));
    // $question_forms[] = null;
    $questionnaire->count = count($data);
    // dd($questionnaire);
    // $question_forms;
    // dd($questions);

      // dd($question);
    // $question_form = $question->question_forms()->get();
    $form_results = $question->form_results()->get();

      // dd($question_forms[$question->id]);
    // dd($question_form);
    // dd($questions);
    // $val;
    // $forms = $question_forms;

    return view('admin.questionnaires.detail', compact('questionnaire', 'question', 'form_results'));
  }
}
