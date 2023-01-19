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
                    <h3 class="blue-title-big">Berita</h3>
                </div>
            </div>
            <div class="row">
                <div class="content-middle">
                    <div class="col-md-12">
                        <div class="main-faq faq-acc">
                            <div class="panel-group panel-custom" id="accordion" role="tablist" aria-multiselectable="true">
                                <?php $key=0;?>
                                @foreach($announcements as $val)
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingDep{{$key}}">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseDep{{$key}}" <?=($key===0)?"aria-expanded=\"true\" ":" class=\"collapsed\" aria-expanded=\"false\"";?> aria-controls="collapseDep{{$key}}">
                                                    {{ $val->title }} <span class="pull-right">{{ date('d M Y H:i',strtotime($val->created_at)) }} &nbsp;&nbsp;&nbsp;</span>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseDep{{$key}}" class="panel-collapse collapse <?=($key===0)?'in':''?>" role="tabpanel" aria-labelledby="headingDep{{$key}}">
                                            <div class="panel-body" style="background-color: white;">
                                                @if($val->picture)
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <img src="{{ $val->picture->url }}" class="img-responsive" alt="{{$val->picture->file_name}}" style="display: block;margin: auto;">
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        {!! $val->content !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $key++; ?>
                                @endforeach
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