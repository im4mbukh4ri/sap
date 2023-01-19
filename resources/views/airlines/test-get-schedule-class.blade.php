@extends('layouts.public')
@section('css')
    @parent
    <style>
        .modal-mask {
            position: fixed;
            z-index: 9998;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, .5);
            display: table;
            transition: opacity .3s ease;
        }

        .modal-wrapper {
            display: table-cell;
            vertical-align: middle;
        }

        .modal-container {
            width: 300px;
            margin: 0px auto;
            padding: 20px 30px;
            background-color: #fff;
            border-radius: 2px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
            transition: all .3s ease;
            font-family: Helvetica, Arial, sans-serif;
        }

        .modal-header h3 {
            margin-top: 0;
            color: #42b983;
        }

        .modal-body {
            margin: 20px 0;
        }

        .modal-default-button {
            float: right;
        }

        /*
         * The following styles are auto-applied to elements with
         * transition="modal" when their visibility is toggled
         * by Vue.js.
         *
         * You can easily play with the modal transition by editing
         * these styles.
         */

        .modal-enter {
            opacity: 0;
        }

        .modal-leave-active {
            opacity: 0;
        }

        .modal-enter .modal-container,
        .modal-leave-active .modal-container {
            -webkit-transform: scale(1.1);
            transform: scale(1.1);
        }
    </style>
@endsection
@section('content')
    <!-- STEP BOOKING -->
    <div id="step-booking">
        <div class="container">
            <ul class="breadcrumb-step">
                <li class="done">
                    <a href="javascript:void(0)">
                        1. Pilih Tiket
                    </a>
                </li>
                <li class="active">
                    <a href="javascript:void(0)">
                        2. Pilih Kelas
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        3. Isi Data
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        4. Konfirmasi Data
                    </a>
                </li>
            </ul>
        </div><!--end.container-->
    </div><!--end.stepbooking-->
    <!-- END STEP BOOKING -->

    <!-- BEGIN SELECT CLASS -->

    <div id="app">
        <div class="row"><div id="loadQZclass"></div></div>
        <div class="row"><div id="loadQGclass"></div></div>
        <div class="row"><div id="loadGAclass"></div></div>
        <div class="row"><div id="loadKDclass"></div></div>
        <div class="row"><div id="loadJTclass"></div></div>
        <div class="row"><div id="loadSJclass"></div></div>
        <div class="row"><div id="loadMVclass"></div></div>
        <div class="row"><div id="loadILclass"></div></div>
        @if(isset($airlines_code_ret))
            <div class="row"><div id="loadAll"></div></div>
            {!! Form::open(['route'=>'airlines.all_fares','method'=>'post','id'=>'getFare']) !!}
            {!! Form::hidden('acDep',$airlines_code,['id'=>'acDep']) !!}
            {!! Form::hidden('acRet',$airlines_code_ret,['id'=>'acRet']) !!}
            {!! Form::hidden('percentCommission',$percentCommission) !!}
            {!! Form::hidden('percentSmartCash',$percentSmartCash) !!}
            <div id="departure"></div>
            <div id="return"></div>
        @endif
        <div id="success">
        </div>
        <modal v-if="showModal">
        </modal>
    </div>
    <script type="text/x-template" id="modal-template">
        <transition name="modal">
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="modal-container">
                        <div class="modal-body text-center">
                            <slot name="body">
                                <p>Cek data terbaru,<br>Mohon tunggu.</p>
                                <img src="{{ asset('/assets/images/Preloader_2.gif') }}" class="img-responsive" alt="loading" style="display: block;margin-left: auto;margin-right: auto;">
                            </slot>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </script>
@endsection
@section('js')
    @parent
    <script src="{{asset('/assets/js/sdvdf7yhfi32nc.js')}}"></script>
    @if(isset($airlines_code_ret))
        <script>
            $('#loadAll').html("<div class='col-md-4 col-md-offset-4'><div class='col-md-12'><img src='{{asset('/assets/images/Preloader_2.gif')}}' style='display: block;margin-left: auto;margin-right: auto;' class='img-responsive'></div></div>");
            airlines.getSchedule(window.url,window.request,"#loadAll")
        </script>
    @else
        <script>
            $('#loadAll').html("<div class='col-md-4 col-md-offset-4'><div class='col-md-12'><img src='{{asset('/assets/images/Preloader_2.gif')}}' style='display: block;margin-left: auto;margin-right: auto;' class='img-responsive'></div></div>");
            airlines.getSchedule(window.url,window.request,"#loadAll")
        </script>
    @endif
@endsection
<?php
/*
@extends('layouts.front')
@section('content')
    <div class="site-wrapper" style="height:auto;min-height: 600px;">
            <div id="app" style="height:auto;min-height: 600px;">

            <div class="row"><div id="loadQZ"></div></div>
            <div class="row"><div id="loadQG"></div></div>
            <div class="row"><div id="loadGA"></div></div>
            <div class="row"><div id="loadKD"></div></div>
            <div class="row"><div id="loadJT"></div></div>
            <div class="row"><div id="loadSJ"></div></div>
            <div class="row"><div id="loadMV"></div></div>
            <div class="row"><div id="loadIL"></div></div>
            @if(isset($airlines_code_ret))
                <div class="row page-title">
                    <div class="container clear-padding text-center flight-title">
                        <h3 style="color:black;">Pilih Kelas</h3>
                        <h4 style="color:black;"><i class="fa fa-plane"></i>{{$origin->city}} ({{$result['org']}})<i class="fa fa-long-arrow-right"></i>{{$destination->city}} ({{$result['des']}})</h4>
                        <span style="color:black;"><strong>PERGI</strong> :  <i class="fa fa-calendar"></i> {{date("d M y",strtotime($result['tgl_dep']))}}  <i class="fa fa-male"></i>Penumpang - {{$result['adt']}} Dewasa, {{$result['chd']}} Anak, {{$result['inf']}} Bayi</span>
                        <br></rn><span style="color:black;"><strong>PULANG</strong> : <i class="fa fa-calendar"></i> {{date("d M y",strtotime($result['tgl_ret']))}}  <i class="fa fa-male"></i>Penumpang - {{$result['adt']}} Dewasa, {{$result['chd']}} Anak, {{$result['inf']}} Bayi</span>
                    </div>
                </div>
                <div class="row"><div id="loadAll"></div></div>
                {!! Form::open(['route'=>'airlines.all_fares','method'=>'post','id'=>'getFare']) !!}
                {!! Form::hidden('acDep',$airlines_code,['id'=>'acDep']) !!}
                {!! Form::hidden('acRet',$airlines_code_ret,['id'=>'acRet']) !!}
                <div id="departure"></div>
                <div id="return"></div>
            @endif
            <div id="success">
            </div>
        </div>
    </div>\
@endsection
@section('js')
    @parent
    <script src="{{asset('/assets/js/ret987uiskdfba.js')}}"></script>
    <script src="{{asset('/assets/js/sdvdf7yhfi32nc.js')}}"></script>
    @if(isset($airlines_code_ret))
        <script>
            $('#loadAll').html("<div class='col-md-4 col-md-offset-4'><div class='col-md-12'><img src='{{asset('/assets/images/Preloader_2.gif')}}' style='height: auto;width:auto;' class='img-responsive'></div></div>");
            airlines.getSchedule(window.url,window.request,"#loadAll")
        </script>
    @else
        <script>
            $('#load{{$airlines_code}}').html("<div class='col-md-4 col-md-offset-4'><div class='col-md-6'><img src='{{asset('/assets/images/airlines/Airline-'.$airlines_code.'.png')}}' style='height:auto;width:auto;display: block;margin-left: auto;margin-right: auto' class='img-responsive'></div><div class='col-md-6'><img src='{{asset('/assets/images/Preloader_2.gif')}}' style='height: auto;width:auto;margin-top:-8%;' class='img-responsive'></div></div>");
            airlines.getSchedule(window.url,window.request,"#load{{$airlines_code}}")
        </script>
    @endif
@endsection
*/?>