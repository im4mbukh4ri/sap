@extends('layouts.public')
@section('css')
    @parent
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
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
                                                    {{ $val->title }} <span class="pull-right">Jumlah Responden : {{$val->count}} &nbsp;&nbsp;&nbsp;</span>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseDep{{$key}}" class="panel-collapse collapse <?=($key===0)?'in':''?>" role="tabpanel" aria-labelledby="headingDep{{$key}}">
                                            <div class="panel-body" style="background-color: white;">
                                                <div class="row">
                                                    <div class="col-md-12">

                                                        @foreach($questions as $kuy => $question)
                                                          {{$kuy+1}}. {{$question->question}} @if($question->required === 1) (required) @endif
                                                          <br>
                                                          @foreach($forms[$question->id] as $kiy => $form)
                                                            @if($question->type === 'radio')

                                                                <div id="formChart{{$kuy}}" style="height: 150px;" align="left"></div>



                                                            @break
                                                            @endif
                                                            @if($question->type === 'textarea' || $question->type === 'text' )
                                                            <a class="button" href="{{url('admin/questionnaire').'/'.$question->id.('/detail')}}">Lihat Jawaban</a>
                                                            <br>
                                                            @endif
                                                          @endforeach
                                                          <br>
                                                        @endforeach
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
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script>
      @foreach($questions as $kuy => $question)
        @if($question->type === 'radio')
          new Morris.Donut({
          element: 'formChart{{$kuy}}',
          data: [
            @foreach($forms[$question->id] as $kiy => $form)
              {label: '{{$form->text}}', value: '{{$form->count}}'},
            @endforeach
          ],
          colors: ["#00FF00","#FFD700","#FF0000"]
          });
        @endif
      @endforeach
    </script>
@endsection
