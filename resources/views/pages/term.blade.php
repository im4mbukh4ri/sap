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
                        <h3 class="blue-title-big">Syarat dan Ketentuan</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="content-middle">
                        <div class="col-md-3">
                            <div class="sidebar">
                                <h3 class="orange-title"><span class="small-title">Kategori</span></h3>
                                <div class="side-menu">
                                    <ul role="tablist">
                                        <li><a href="#sk" aria-controls="aturanMain" role="tab" data-toggle="tab">SOP</a></li>
                                        <li><a href="#aturanMain" aria-controls="aturanMain" role="tab" data-toggle="tab">Uang Elektronik</a></li>
                                        <li><a href="#freeTrial" aria-controls="freeTrial" role="tab" data-toggle="tab">Free Trial</a></li>
                                        {{--<li><a href="#pulsa" aria-controls="pulsa" role="tab" data-toggle="tab">Pulsa</a></li>--}}
                                        {{--<li><a href="#ppob" aria-controls="ppob" role="tab" data-toggle="tab">PPOB</a></li>--}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="tab-content">
                                <div class="main-faq tab-pane active" id="sk">
                                    <h3 class="blue-title"><span class="small-title whiteFont">SOP</span></h3>
                                    <div role="tabpanel">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                              <div class="row">
                                                <div class="col-md-12">
                                                  <div class="table-responsive">
                                                    {!! $sk->content !!}
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="main-faq tab-pane" id="aturanMain">
                                    <h3 class="blue-title"><span class="small-title whiteFont">Uang Elektronik</span></h3>
                                    <div role="tabpanel">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                              <div class="row"  style="height:300px;">
                                                <div class="col-md-12">
                                                  <div class="table-responsive">
                                                      {!! $content->content !!}
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="main-faq tab-pane active" id="freeTrial">
                                    <h3 class="blue-title"><span class="small-title whiteFont">SOP</span></h3>
                                    <div role="tabpanel">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                              <div class="row">
                                                <div class="col-md-12">
                                                  <div class="table-responsive">
                                                    {!! $free->content !!}
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
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
