<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\OauthAccessToken;
use App\OauthClient;
use App\OauthClientSecret;
use App\User;
use App\Questionnaire;
use App\QuestionnaireResult;
use JavaScript;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ApiQuestionnareController extends Controller
{
    //
    private $confirmSuccess = 'success';
    private $confirmFailed = 'failed';
    private $codeSuccess = 200;
    private $codeFailed = 400;
    private $statusMessage;
    public function __construct(Request $request)
    {
        $this->middleware('oauth');
//        if ($request->hasHeader('authorization')) {
//            $token = explode(' ', $request->header('authorization'));
//            $newTime = time() + 259200;
//            $accessToken = OauthAccessToken::find($token[1]);
//            $accessToken->expire_time = $newTime;
//            $accessToken->save();
//        }
//        if ($request->has('access_token')) {
//            $newTime = time() + 259200;
//            $accessToken = OauthAccessToken::find($request->access_token);
//            $accessToken->expire_time = $newTime;
//            $accessToken->save();
//        }
    }
    public function index(Request $request)
    {
      $validator = Validator::make($request->all(), [
          'client_id' => 'required',
      ]);
      if ($validator->fails()) {
          return Response::json([
              'status' => [
                  'code' => 400,
                  'confirm' => 'failed',
                  'message' => $validator->errors(),
              ],
          ]);
      }
      $client = OauthClientSecret::where('client_id', $request->client_id)->first();
      if (!$client) {
          $this->setStatusMessage(['Anda tidak terdaftar', 'client_id tidak ditemukan']);
          return Response::json([
              'status' => [
                  'code' => $this->getCodeFailed(),
                  'confirm' => $this->getConfirmFailed(),
                  'message' => $this->getStatusMessage(),
              ],
          ]);
      }
      $user_id = $client->user->id;
      $access_token;
      if ($request->hasHeader('authorization')) {
          $token = explode(' ', $request->header('authorization'));
          $access_token = $token[1];
      }
      if ($request->has('access_token')) {
          $access_token = $request->access_token;
      }

      $questionnaires = Questionnaire::where('status','=',1)->get()->sortByDesc('updated_at');
      foreach ($questionnaires as $key => $questionnaire) {
        $statusRes = QuestionnaireResult::where('questionnaire_id','=',$questionnaire->id)->where('user_id','=',$user_id)->first();
        if($statusRes === null){
          $questionnaire->statusRes = 0;
        }
        else {
          $questionnaire->statusRes = 1;
        }
      }
      return view('api.v1.questionnaires.index', compact('questionnaires','user_id','access_token'));
    }
    public function create(Request $request) {
      // dd($request);
      $user = User::find($request->user_id);
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
    private function getCodeSuccess()
    {
        return $this->codeSuccess;
    }
    private function getCodeFailed()
    {
        return $this->codeFailed;
    }
    private function getConfirmSuccess()
    {
        return $this->confirmSuccess;
    }
    private function getConfirmFailed()
    {
        return $this->confirmFailed;
    }
    private function setStatusMessage($message)
    {
        (is_array($message) ? $this->statusMessage = $message : $this->statusMessage = array($message));
    }
    private function getStatusMessage()
    {
        return $this->statusMessage;
    }
}
