@extends('layouts.public')
@section('css')
    @parent
@endsection
@section('content')
<div id="step-booking-kereta">
    <section class="section-pilih-seat">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="blue-title-big"> Hasil Kuisioner</h3>
                </div>
            </div>
            <div class="row">
                <div class="content-middle">
                    <div class="col-md-12">
                        <div class="main-faq faq-acc">
                            <div class="panel-group panel-custom" id="accordion" role="tablist" aria-multiselectable="true">
                                <?php $key=0;?>

                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingDep{{$key}}">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseDep{{$key+1}}" <?=($key===0)?"aria-expanded=\"true\" ":" class=\"collapsed\" aria-expanded=\"false\"";?> aria-controls="collapseDep{{$key}}">
                                                    {{ $questionnaire->title }} <span class="pull-right">Jumlah Responden : {{$questionnaire->count}} &nbsp;&nbsp;&nbsp;</span>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseDep{{$key}}" class="panel-collapse collapse <?=($key===0)?'in':''?>" role="tabpanel" aria-labelledby="headingDep{{$key}}">
                                            <div class="panel-body" style="background-color: white;">
                                                <div class="row">
                                                    <div class="col-md-12">


                                                          1. {{$question->question}} @if($question->required === 1) (required) @endif
                                                          <br>
                                                          @foreach($form_results as $kiy => $form)

                                                            <input type="radio" name="results[{{$form->question_id}}]" value="{{$form->id}}" disabled @if($question->required === 1) required @endif> {{$form->note}} <br>


                                                          @endforeach
                                                          <br>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $key++; ?>

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
@endsection
