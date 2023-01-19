<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->
<head>
    <meta name="_token" id="token" value="{{csrf_token()}}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIP</title>
    <meta name="description" content="">
    <link rel="shortcut icon" href="https://www.smartinpays.com/favicon.png" type="image/x-icon"/>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--Style-->
    <link rel="stylesheet" href="{{asset('/assets/css/public/sweetalert.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/css/public/reset.css')}}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css">
    <link rel="stylesheet" href="{{asset('/assets/css/public/jquery-ui.css')}}"/>
    <link rel="stylesheet" href="{{asset('/assets/css/public/select2.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('/assets/css/public/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/css/public/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/public/media1024.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/public/media768.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/public/media480.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/public/media320.css')}}"/>
    <link rel="stylesheet" href="{{asset('/assets/css/public/jquery.bxslider.css')}}">
    <!--link rel="stylesheet" href="css/style-temp.css"-->
    <!--js-->
        <script src="{{asset('/assets/js/public/jquery-1.9.1.min.js')}}"></script>
        <script>window.jQuery || document.write('<script src="{{asset('/assets/js/public/jquery-1.9.1.min.js')}}"><\/script>')</script>
        <script src="{{asset('/assets/js/public/modernizr-2.6.2.min.js')}}"></script>
        <script src="{{asset('/assets/js/public/SmoothScroll.js')}}"></script>
        <script src="{{asset('/assets/js/public/jquery-ui.min.js')}}"></script>
        <script src="{{asset('/assets/js/public/select2.full.min.js')}}"></script>
        <script src="{{asset('/assets/js/public/bootstrap.min.js')}}"></script>
        <script src="{{asset('/assets/js/public/jquery.bxslider.js')}}"></script>
        <script src="{{asset('/assets/js/public/js_lib.js')}}"></script>
        <script src="{{asset('/assets/js/public/js_run.js')}}"></script>
</head>
<body>
@include('flash::message')

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
                                                      <form method="post" action="{{route('api.questionnaire')}}">
                                                        {{csrf_field()}}
                                                        <input type="hidden" name="questionnaire_id" value="{{$val->id}}">
                                                        <input type="hidden" name="access_token" value="{{$access_token}}">
                                                        <input type="hidden" name="user_id" value="{{$user_id}}">
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
</body>
    <script src="{{asset('/assets/js/public/sweetalert.min.js')}}"></script>
    <script src="{{asset('/assets/js/vue.js')}}"></script>
    <script src="{{asset('/assets/js/vue-resource.min.js')}}"></script>
    <script src="{{asset('/assets/js/public/my-js.js')}}"></script>
    <script>$('#flash-overlay-modal').modal();</script>
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
</html>
