@extends('layouts.public')
@section('css')
    @parent
    <link rel="stylesheet" href="{{asset('/assets/css/admin/summernote.css')}}">
@endsection
@section('content')
<div id="step-booking-kereta">
    <section class="section-pilih-seat">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="blue-title-big">Content</h3>
                </div>
            </div>
            <div class="row">
                <div class="content-middle">
                    <div class="col-md-12">
                        <div class="main-faq faq-acc">
                            <div class="panel-group panel-custom" id="accordion" role="tablist" aria-multiselectable="true">
                                <?php $key=0;?>
                                @foreach($faqs as $faq)
                                    <h3 class="blue-title-big">{{$faq['category']}}</h3>
                                    @foreach($faq['contents'] as $val)
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingDep{{$key}}">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseDep{{$key}}" <?=($key===0)?"aria-expanded=\"true\" ":" class=\"collapsed\" aria-expanded=\"false\"";?> aria-controls="collapseDep{{$key}}">
                                                {{ $val->title }} </span>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseDep{{$key}}" class="panel-collapse collapse <?=($key===0)?'in':''?>" role="tabpanel" aria-labelledby="headingDep{{$key}}">
                                            <div class="panel-body" style="background-color: white;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        {!! $val->content !!}
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                        <div class="col-md-12">
                                                            <a class="btn btn-info" target="_blank" href="{{route('admin.sip_contents_edit',$val->id)}}">Edit Content</a>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $key++; ?>
                                    @endforeach
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