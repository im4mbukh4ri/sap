@extends('layouts.public')
@section('css')
    @parent
    <link rel="stylesheet" href="{{asset('/assets/css/public/sweetalert.css')}}">
@endsection
@section('content')
<div id="step-booking-kereta">
    <section class="section-pilih-seat">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="blue-title-big">Kuisioner</h3>
                </div>
            </div>
            <div class="row">
                <div class="content-middle">
                    <div class="col-md-12">
                        <div class="main-faq faq-acc">
                            <div class="panel-group panel-custom" id="accordion" role="tablist" aria-multiselectable="true">
                                <?php $key=0;?>
                                @foreach($questionnaires as $val)
                                    @if ($val->statusRes === 1)
                                        @continue
                                    @endif
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingDep{{$key}}">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseDep{{$key}}" <?=($key===0)?"aria-expanded=\"true\" ":" class=\"collapsed\" aria-expanded=\"false\"";?> aria-controls="collapseDep{{$key}}">
                                                    {{ $val->title }} <span class="pull-right">{{ date('d M Y H:i',strtotime($val->updated_at)) }} &nbsp;&nbsp;&nbsp;</span>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseDep{{$key}}" class="panel-collapse collapse <?=($key===0)?'in':''?>" role="tabpanel" aria-labelledby="headingDep{{$key}}">
                                            <div class="panel-body" style="background-color: white;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                      <form method="post" action="{{route('questionnaires.submit')}}">
                                                        {{csrf_field()}}
                                                        <input type="hidden" name="questionnaire_id" value="{{$val->id}}">
                                                        <?php $questions = $val->questionnaire_questions()->get() ?>
                                                        @foreach($questions as $kuy => $question)
                                                          {{$kuy+1}}. {{$question->question}} @if($question->required === 1) (required) @endif
                                                          <br>
                                                          <?php $forms = $question->question_forms()->get() ?>
                                                          @foreach($forms as $kiy => $form)
                                                            @if($question->type === 'radio')
                                                            <input type="radio" name="results[{{$form->question_id}}]" value="{{$form->id}}" @if($question->required === 1) required @endif> {{$form->text}}
                                                            <br>
                                                            @endif
                                                            @if($question->type === 'textarea')
                                                            <textarea name="results[{{$form->question_id}}]" cols="50" rows="5" @if($question->required === 1) required @endif></textarea>
                                                            <br>
                                                            @endif
                                                            @if($question->type == 'text')
                                                            <input type="text" name="results[{{$form->question_id}}]" size="50" @if($question->required === 1) required @endif>
                                                            <br>
                                                            @endif
                                                          @endforeach
                                                          <br>
                                                        @endforeach
                                                        {{ Form::submit('Submit', array('class' => 'btn js-submit-confirm')) }}
                                                      </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $key++; ?>
                                @endforeach
                                @if($key ===0)
                                  <h4 class="panel-title pull-center">
                                        Terima Kasih Telah Mengisi Kuisioner
                                  </h4>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('js')
    @parent
    <script src="{{asset('/assets/js/public/sweetalert.min.js')}}"></script>
    <script src="{{asset('/assets/js/public/sweetalert.min.js')}}"></script>
    <script>
        $(document).ready(function(){
             $(document.body).on('click', '.js-submit-confirm-notactif', function (event) {
                event.preventDefault();
                var $form = $(this).closest('form');
                var $el = $(this);
                var text = $el.data('confirm-message') ? $el.data('confirm-message') : 'Apakah Anda yakin dengan jawaban kuisioner?';
                swal({
                        title: 'Kuisioner',
                        text: text,
                        showCancelButton: true,
                        confirmButtonColor: '#0c5484',
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Batal',
                        closeOnConfirm: true
                    },
                    function () {
                        $form.submit()
                    })
            });
        });
    </script>
@endsection
