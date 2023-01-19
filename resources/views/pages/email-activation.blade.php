@extends('layouts.login-2')

@section('content')
    <!-- BEGIN: SITE-WRAPPER -->
    <div class="coming-soon-wrapper full-screen">
        <div class="coming-soon full-screen">
            <div class="centered-box text-center" >
                <div class="row">
                    <div class="col-md-6">
                        <div class="logo" style="margin:auto;padding: 15%;">
                            <img src="{{asset('/assets/logo/logotext-white.png')}}" class="img-responsive" style="width:400px;height:auto;display:block;margin:auto;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="loading-animation">
                            <span><i class="fa fa-plane"></i></span>
                            <span><i class="fa fa-bed"></i></span>
                            <span><i class="fa fa-train"></i></span>
                            <span><i class="fa fa-suitcase"></i></span>
                        </div>
                    </div>
                </div>
                <div class="search-title">
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                </div>
            </div>
        </div>
    </div>
    <!-- END: SITE-WRAPPER -->
@endsection