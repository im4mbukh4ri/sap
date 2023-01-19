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
                        <h3 class="blue-title-big">FAQ</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="content-middle">
                        <div class="col-md-3">
                            <div class="sidebar">
                                <h3 class="orange-title"><span class="small-title">Kategori Pertanyaan</span></h3>
                                <div class="side-menu">
                                    <ul role="tablist">
                                        <li><a href="#deposit" aria-controls="deposit" role="tab" data-toggle="tab">Deposit</a></li>
                                        <li><a href="#login" aria-controls="login" role="tab" data-toggle="tab">Login</a></li>
                                        {{--<li><a href="#teknis" aria-controls="teknis" role="tab" data-toggle="tab">Teknis</a></li>--}}
                                        <li><a href="#airlines" aria-controls="airlines" role="tab" data-toggle="tab">Airlines</a></li>
                                        <li><a href="#trains" aria-controls="airlines" role="tab" data-toggle="tab">Kereta Api</a></li>
                                        <li><a href="#ppob" aria-controls="ppob" role="tab" data-toggle="tab">PPOB</a></li>
                                        <li><a href="#free_trial" aria-controls="free_trial" role="tab" data-toggle="tab">Free Trial</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="main-faq">
                                <div class="tab-content">
                                    <div class="faq-acc tab-pane active" id="deposit">
                                        <h3 class="blue-title"><span class="small-title whiteFont">FAQ - Deposit</span></h3>
                                        <div class="panel-group panel-custom" id="accordion" role="tablist" aria-multiselectable="true">
                                            @foreach($faq['deposit'] as $key => $val)
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingDep{{$key}}">
                                                        <h4 class="panel-title">
                                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseDep{{$key}}" <?=($key===0)?"aria-expanded=\"true\" ":" class=\"collapsed\" aria-expanded=\"false\"";?> aria-controls="collapseDep{{$key}}">
                                                                {{ $val->title }}
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapseDep{{$key}}" class="panel-collapse collapse <?=($key===0)?'in':''?>" role="tabpanel" aria-labelledby="headingDep{{$key}}">
                                                        <div class="panel-body">
                                                            {!! $val->content !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="faq-acc tab-pane" id="login">
                                        <h3 class="blue-title"><span class="small-title whiteFont">FAQ - Login</span></h3>
                                        <div class="panel-group panel-custom" id="accordionLog" role="tablist" aria-multiselectable="true">
                                            @foreach($faq['login'] as $key => $val)
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingLog{{$key}}">
                                                        <h4 class="panel-title">
                                                            <a role="button" data-toggle="collapse" data-parent="#accordionLog" href="#collapseLog{{$key}}" <?=($key===0)?"aria-expanded=\"true\" ":" class=\"collapsed\" aria-expanded=\"false\"";?> aria-controls="collapseLog{{$key}}">
                                                                {{ $val->title }}
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapseLog{{$key}}" class="panel-collapse collapse <?=($key===0)?'in':''?>" role="tabpanel" aria-labelledby="headingLog{{$key}}">
                                                        <div class="panel-body">
                                                            {!! $val->content !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="faq-acc tab-pane" id="airlines">
                                        <h3 class="blue-title"><span class="small-title whiteFont">FAQ - Airlines</span></h3>
                                        <div class="panel-group panel-custom" id="accordionAir" role="tablist" aria-multiselectable="true">
                                            @foreach($faq['airlines'] as $key => $val)
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingAir{{$key}}">
                                                        <h4 class="panel-title">
                                                            <a role="button" data-toggle="collapse" data-parent="#accordionAir" href="#collapseAir{{$key}}" <?=($key===0)?"aria-expanded=\"true\" ":" class=\"collapsed\" aria-expanded=\"false\"";?> aria-controls="collapseAir{{$key}}">
                                                                {{ $val->title }}
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapseAir{{$key}}" class="panel-collapse collapse <?=($key===0)?'in':''?>" role="tabpanel" aria-labelledby="headingAir{{$key}}">
                                                        <div class="panel-body">
                                                            {!! $val->content !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="faq-acc tab-pane" id="trains">
                                        <h3 class="blue-title"><span class="small-title whiteFont">FAQ - Kereta Api</span></h3>
                                        <div class="panel-group panel-custom" id="accordionAir" role="tablist" aria-multiselectable="true">
                                            @foreach($faq['trains'] as $key => $val)
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingTrain{{$key}}">
                                                        <h4 class="panel-title">
                                                            <a role="button" data-toggle="collapse" data-parent="#accordionTrain" href="#collapseTrain{{$key}}" <?=($key===0)?"aria-expanded=\"true\" ":" class=\"collapsed\" aria-expanded=\"false\"";?> aria-controls="collapseTrain{{$key}}">
                                                                {{ $val->title }}
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapseTrain{{$key}}" class="panel-collapse collapse <?=($key===0)?'in':''?>" role="tabpanel" aria-labelledby="headingAir{{$key}}">
                                                        <div class="panel-body" style="width:100%">
                                                            {!! $val->content !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="faq-acc tab-pane" id="ppob">
                                        <h3 class="blue-title"><span class="small-title whiteFont">FAQ - PPOB</span></h3>
                                        <div class="panel-group panel-custom" id="accordionPpob" role="tablist" aria-multiselectable="true">
                                            @foreach($faq['ppob'] as $key => $val)
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingPpob{{$key}}">
                                                        <h4 class="panel-title">
                                                            <a role="button" data-toggle="collapse" data-parent="#accordionPpob" href="#collapsePpob{{$key}}" <?=($key===0)?"aria-expanded=\"true\" ":" class=\"collapsed\" aria-expanded=\"false\"";?> aria-controls="collapsePpob{{$key}}">
                                                                {{ $val->title }}
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapsePpob{{$key}}" class="panel-collapse collapse <?=($key===0)?'in':''?>" role="tabpanel" aria-labelledby="headingPpob{{$key}}">
                                                        <div class="panel-body">
                                                            {!! $val->content !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="faq-acc tab-pane" id="free_trial">
                                        <h3 class="blue-title"><span class="small-title whiteFont">FAQ - Free Trial</span></h3>
                                        <div class="panel-group panel-custom" id="accordionLog" role="tablist" aria-multiselectable="true">
                                            @foreach($faq['free_trial'] as $key => $val)
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingFree{{$key}}">
                                                        <h4 class="panel-title">
                                                            <a role="button" data-toggle="collapse" data-parent="#accordionLog" href="#collapseFree{{$key}}" <?=($key===0)?"aria-expanded=\"true\" ":" class=\"collapsed\" aria-expanded=\"false\"";?> aria-controls="collapseLog{{$key}}">
                                                                {{ $val->title }}
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapseFree{{$key}}" class="panel-collapse collapse <?=($key===0)?'in':''?>" role="tabpanel" aria-labelledby="headingFree{{$key}}">
                                                        <div class="panel-body">
                                                            {!! $val->content !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
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
