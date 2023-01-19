@extends('layouts.public')
@section('css')
    @parent
    <link rel="stylesheet" href="{{asset('/assets/css/public/sweetalert.css')}}">
    <style>
    .modal-charity {
        background-image: url("{{asset('/assets/logo/charity-1.png')}}");
        background-size: 100% 13%;
        background-repeat: no-repeat;
    }
    </style>
@endsection

@if(Session::has('alert-success'))
<div class="modal fade" id="myModali" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content modal-charity">
            <div class="modal-body">
            <br><br>
            <div align="center" align="middle">
            <img src="{{asset('/assets/logo/charity-2.png')}}" width="50%" height="50%">
            </div>

            <h4 align="center">{{ Session::get('alert-success') }}</h4>
            <h4 align="center">Terima Kasih Smartpreneur</h4>
            <h6 align="center">Atas Kebesaran Hati Anda Membantu Sesama</h6>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>
<script src="{{asset('/assets/js/public/sweetalert.min.js')}}"></script>
<script>
    swal({
        title: "Kuisioner",
        text: "Demi Meningkatkan Pelayanan, Kami meminta Anda untuk bersedia mengisi Kuisoner",
        // type: "success",
        showCancelButton: true,
        confirmButtonColor: '#0c5484',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Nanti',
        closeOnConfirm: true
    },
    function() {
        // Redirect the user
        window.location.href = "questionnaires";
    });
    $(document).ready(function () {
        $('#myModali').modal('show');
    });
</script>
@endif

@section('content')
    <section id="home-form" style="background: url({{ asset('/assets/images/content/bg-home.jpg') }});">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="box-home">
                        <div class="head-tab">
                            <div class="left tabs-home">
                                <ul id="menu-tabs-desktop" class="tabs-home-menu">
                                    <li>
                                        <a class="tabs-home-a{{($services=='airlines'||$services==null?' active':'')}}" href="#boxPesawat">
                                            <img class="t-icon" src="{{asset('/assets/images/material/icon-tab1.png')}}"><br>
                                            <span>Airlines</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="tabs-home-a{{($services=='train'?' active':'')}}" href="#boxKereta">
                                            <img class="t-icon" src="{{asset('/assets/images/material/icon-tab2.png')}}"><br>
                                            <span>Kereta Api</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="tabs-home-a{{($services=='railink'?' active':'')}}" href="#boxRailink">
                                            <img class="t-icon" src="{{asset('/assets/images/material/icon-tab2.png')}}"><br>
                                            <span>Railink</span>
                                        </a>
                                    </li>
                                    {{--<li>--}}
                                        {{--<a class="tabs-home-a" href="#boxBus">--}}
                                            {{--<img class="t-icon" src="images/material/icon-tab3.png"><br>--}}
                                            {{--<span>Bus</span>--}}
                                        {{--</a>--}}
                                    {{--</li>--}}
                                    <li>
                                        <a class="tabs-home-a {{($services=='hotel'?' active':'')}}" href="#boxHotel">
                                            <img class="t-icon" src="{{asset('/assets/images/material/icon-tab4.png')}}"><br>
                                            <span>Hotel</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="tabs-home-a{{($services=='pulsa'?' active':'')}}" href="#boxPulsa">
                                            <img class="t-icon" src="{{asset('/assets/images/material/mobile.png')}}"><br>
                                            <span>PULSA</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="tabs-home-a{{($services=='ppob'?' active':'')}}" href="#boxPpob">
                                            <img class="t-icon" src="{{asset('/assets/images/material/ppob1.png')}}"><br>
                                            <span>PPOB</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="tabs-home-a{{($services=='voucher'?' active':'')}}" href="#boxVoucher">
                                            <img class="t-icon" src="{{asset('/assets/images/material/mobile.png')}}"><br>
                                            <span>Voucher</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tabs-menu-mobile relative">
                                    <div class="title-tabs">Airlines</div>
                                    <a href="#" class="page-tab prev-tab disabled"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
                                    <a href="#" class="page-tab next-tab"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                                </div>
                            </div><!--.left-->
                            <div class="right saldo-tabs">
                                <div class="saldo-head">
                                    <span>Saldo Anda</span>
                                    <span class="saldo">IDR {{ number_format($user->deposit) }}</span>
                                </div>
                                <a href="{{ route('deposits.tickets') }}" class="tabs-plus">
                                    <img class="t-icon" src="{{ asset('/assets/images/material/icon-tab-plus.png') }}"><br>
                                    <span>Deposit</span>
                                </a>
                            </div><!--.right-->
                        </div><!--end.head-tab-->
                        <div class="content-tabs-home">
                            <div id="boxPesawat" class="box-orange box-content-tabs-home {{($services=='airlines'||$services==null?'':'hide')}}">
                                <form action="{{route('airlines.vue')}}" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="airlines_code" value="ALL">
                                    <div class="rows">
                                        <label class="radio-inline">
                                            <input type="radio" name="flight" id="flight" value="O" checked> Sekali Jalan
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="flight" id="flight" value="R"> Pulang Pergi
                                        </label>
                                    </div>
                                    <div class="search-row row">
                                        <div class="col-md-4">
                                            <div class="form-group group-addon-select">
                                                <label for="origin" >Dari</label>
                                                <div class="input-group custom-input">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                                                    <select id="origin" name="origin" class="selectSearch1 full-width" required>
                                                        <option value="">Pilih kota asal</option>
                                                        @foreach($airports as $airport)
                                                            <option value="{{$airport['id']}}">{{$airport['name']}} ({{$airport['id']}}) - {{$airport['city']}}, {{$airport['country']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group group-addon-select">
                                                <label for="destination">Ke</label>
                                                <div class="input-group custom-input">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                                                    <select id="destination" name="destination"  class="selectSearch2 full-width" required>
                                                        <option value="">Pilih kota tujuan</option>
                                                        @foreach($airports as $airport)
                                                            <option value="{{$airport['id']}}">{{$airport['name']}} ({{$airport['id']}}) - {{$airport['city']}}, {{$airport['country']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div><!--end.col4-->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="departure_date">Pergi</label>
                                                <div class="input-group custom-input">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                    <input readonly type="text" id="departure_date" name="departure_date" class="form-control datepicker" required>

                                                </div>
                                            </div>
                                            <div class="form-group" id="js-flight">
                                                <label for="return_date">Pulang</label>
                                                <div class="input-group custom-input">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                    <input readonly type="text" id="return_date" name="return_date" class="form-control datepicker">

                                                </div>
                                            </div>
                                        </div><!--end.col4-->
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group group-addon-select">
                                                        <label for="adt">Dewasa</label>
                                                        <div class="input-group custom-input">
                                                            <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                                            <select id="adt" name="adt" class="form-control">
                                                                <option value="1" selected>1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                                <option value="6">6</option>
                                                                <option value="7">7</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group group-addon-select">
                                                        <label for="chd">Anak</label>
                                                        <div class="input-group custom-input">
                                                            <span class="input-group-addon"><i class="fa fa-male" aria-hidden="true"></i></span>
                                                            <select id="chd" name="chd" class="form-control">
                                                                <option value="0" selected>0</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                                <option value="6">6</option>
                                                                <option value="7">7</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group group-addon-select">
                                                        <label for="inf">Bayi</label>
                                                        <div class="input-group custom-input">
                                                            <span class="input-group-addon"><i class="fa fa-child" aria-hidden="true"></i></span>
                                                            <select id="inf" name="inf" class="form-control">
                                                                <option value="0" selected>0</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                                <option value="6">6</option>
                                                                <option value="7">7</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!--end.row-->
                                            <br>
                                            <button type="submit" class="btn btn-cari">
                                                <span class="glyphicon glyphicon-search"></span> Cari Tiket
                                            </button>
                                        </div><!--end.col4-->
                                    </div><!--end.search-row-->
                                </form>
                            </div>
                            <div id="boxKereta" class="box-orange box-content-tabs-home {{($services=='train'?'':'hide')}}">
                                <form action="{{route('trains.result_schedule')}}" method="post">
                                    {{ csrf_field() }}
                                    <div class="rows">
                                        <label class="radio-inline">
                                            <input type="radio" name="trip" id="trip" value="O" checked> Sekali Jalan
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="trip" id="trip" value="R"> Pulang Pergi
                                        </label>
                                    </div>
                                    <div class="search-row row">
                                        <div class="col-md-4">
                                            <div class="form-group group-addon-select">
                                                <label for="origin" >Dari</label>
                                                <div class="input-group custom-input">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                                                    <select id="origin" name="origin" class="selectSearch1 full-width" required>
                                                        <option value="">Pilih kota asal</option>
                                                        @foreach($stations as $station)
                                                            <option value="{{$station['code']}}">{{$station['city']}} - {{$station['name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group group-addon-select">
                                                <label for="destination">Ke</label>
                                                <div class="input-group custom-input">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                                                    <select id="destination" name="destination"  class="selectSearch2 full-width" required>
                                                        <option value="">Pilih kota tujuan</option>
                                                        @foreach($stations as $station)
                                                            <option value="{{$station['code']}}">{{$station['city']}} - {{$station['name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div><!--end.col4-->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="departure_date">Pergi</label>
                                                <div class="input-group custom-input">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                    <input readonly type="text" id="train_departure_date" name="departure_date" class="form-control datepicker" required>

                                                </div>
                                            </div>
                                            <div class="form-group js-trip" id="js-trip">
                                                <label for="return_date">Pulang</label>
                                                <div class="input-group custom-input">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                    <input readonly type="text" id="train_return_date" name="return_date" class="form-control datepicker">
                                                </div>
                                            </div>
                                        </div><!--end.col4-->
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group group-addon-select">
                                                        <label for="adt">Dewasa ( > 3thn)</label>
                                                        <div class="input-group custom-input">
                                                            <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                                            <select id="adt" name="adt" class="form-control">
                                                                <option value="1" selected>1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group group-addon-select">
                                                        <label for="chd">Bayi ( < 3thn)</label>
                                                        <div class="input-group custom-input">
                                                            <span class="input-group-addon"><i class="fa fa-child" aria-hidden="true"></i></span>
                                                            <select id="inf" name="inf" class="form-control">
                                                                <option value="0" selected>0</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="chd" value="0" />
                                            </div><!--end.row-->
                                            <br>
                                            <button type="submit" class="btn btn-cari">
                                                <span class="glyphicon glyphicon-search"></span> Cari Tiket
                                            </button>
                                        </div><!--end.col4-->
                                    </div><!--end.search-row-->
                                </form>
                            </div>
                            <div id="boxRailink" class="box-orange box-content-tabs-home {{($services=='railink'?'':'hide')}}">
                                <form action="{{route('railinks.result_schedule')}}" method="post">
                                    {{ csrf_field() }}
                                    <div class="rows">
                                        <label class="radio-inline">
                                            <input type="radio" name="trip_railink" value="O" checked> Sekali Jalan
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="trip_railink" value="R"> Pulang Pergi
                                        </label>
                                    </div>
                                    <div class="search-row row">
                                        <div class="col-md-4">
                                            <div class="form-group group-addon-select">
                                                <label for="origin" >Dari</label>
                                                <div class="input-group custom-input">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                                                    <select id="origin" name="origin" class="selectSearch1 full-width" required>
                                                        <option value="">Pilih kota asal</option>
                                                        @foreach($railink_stations as $station)
                                                            <option value="{{$station['code']}}">{{$station['city']}} - {{$station['name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group group-addon-select">
                                                <label for="destination">Ke</label>
                                                <div class="input-group custom-input">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                                                    <select id="destination" name="destination"  class="selectSearch2 full-width" required>
                                                        <option value="">Pilih kota tujuan</option>
                                                        @foreach($railink_stations as $station)
                                                            <option value="{{$station['code']}}">{{$station['city']}} - {{$station['name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div><!--end.col4-->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="departure_date">Pergi</label>
                                                <div class="input-group custom-input">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                    <input readonly type="text" id="railink_departure_date" name="departure_date" class="form-control datepicker" required>

                                                </div>
                                            </div>
                                            <div class="form-group" id="js-railink">
                                                <label for="return_date">Pulang</label>
                                                <div class="input-group custom-input">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                    <input readonly type="text" id="railink_return_date" name="return_date" class="form-control datepicker">
                                                </div>
                                            </div>
                                        </div><!--end.col4-->
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group group-addon-select">
                                                        <label for="adt">Dewasa</label>
                                                        <div class="input-group custom-input">
                                                            <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                                            <select id="adt" name="adt" class="form-control">
                                                                <option value="1" selected>1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group group-addon-select">
                                                        <label for="chd">Anak</label>
                                                        <div class="input-group custom-input">
                                                            <span class="input-group-addon"><i class="fa fa-male" aria-hidden="true"></i></span>
                                                            <select id="chd" name="chd" class="form-control">
                                                                <option value="0" selected>0</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="inf" value="0" />
                                            </div><!--end.row-->
                                            <br>
                                            <button type="submit" class="btn btn-cari">
                                                <span class="glyphicon glyphicon-search"></span> Cari Tiket
                                            </button>
                                        </div><!--end.col4-->
                                    </div><!--end.search-row-->
                                </form>
                            </div>
                            <div id="boxHotel" class="box-orange box-content-tabs-home {{($services=='hotel'?'':'hide')}}">
                                <form action="{{route('hotels.search')}}" method="post">
                                    {{ csrf_field() }}
                                    <div class="rows">
                                        @if($user->username === 'member_silver' || $user->username === 'PROUSER')
                                        <label class="radio-inline">
                                            <input type="radio" name="hotel_type" value="domestik" checked> Domestik
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="hotel_type" value="international"> Internasional
                                        </label>
                                        @else
                                            <input type="hidden" name="hotel_type" value="domestik">
                                        @endif
                                    </div>
                                    <div class="search-row row">
                                        <div class="col-md-4">
                                            <div class="form-group group-addon-select" id="domesticDes">
                                                <label for="origin" >Kota Tujuan</label>
                                                <div class="input-group custom-input">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                                                    <select id="domesticDes" name="domesticDes" class="selectHotel full-width">
                                                        <option value="">Pilih kota tujuan</option>
                                                        @foreach($hotel as $value)
                                                            <option value="{{$value['code']}}">{{$value['city']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            @if($user->username === 'member_silver' || $user->username === 'PROUSER')
                                            <div class="form-group group-addon-select" id="intDes">
                                                <label for="destination">Kota Tujuan</label>
                                                <div class="input-group custom-input">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                                                    <select id="intDes" name="intDes"  class="selectHotel full-width">
                                                        <option value="">Pilih kota tujuan</option>
                                                        @foreach($hotel_int as $value)
                                                            <option value="{{$value['code']}}">{{$value['city']}} - {{$value['country']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="form-group group-addon-select">
                                                <label for="adt">Tipe Bed</label>
                                                <div class="input-group custom-input">
                                                    <span class="input-group-addon"><i class="fa fa-bed" aria-hidden="true"></i></span>
                                                    <select id="room" name="roomtype" class="form-control">
                                                        <<option value="" selected="">(Opsional)</option>
                                                        <option value="twin">Twin</option>
                                                        <option value="double">Double</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div><!--end.col4-->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="departure_date">Check-in</label>
                                                <div class="input-group custom-input">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                    <input readonly type="text" id="checkin_date" name="checkin_date" class="form-control datepicker" required>

                                                </div>
                                            </div>
                                            <div class="form-group" id="js-railink">
                                                <label for="return_date">Check-out</label>
                                                <div class="input-group custom-input">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                    <input readonly type="text" id="checkout_date" name="checkout_date" class="form-control datepicker">
                                                </div>
                                            </div>
                                        </div><!--end.col4-->
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group group-addon-select">
                                                        <label for="adt">Kamar</label>
                                                        <div class="input-group custom-input">
                                                            <span class="input-group-addon"><i class="fa fa-book" aria-hidden="true"></i></span>
                                                            <select id="room" name="room" class="form-control">
                                                                <option value="1" selected>1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group group-addon-select">
                                                        <label for="adt">Dewasa</label>
                                                        <div class="input-group custom-input">
                                                            <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                                            <select id="adt" name="adt" class="form-control">
                                                                <option value="1" selected>1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="2">5</option>
                                                                <option value="3">6</option>
                                                                <option value="4">7</option>
                                                                <option value="2">8</option>
                                                                <option value="3">9</option>
                                                                <option value="4">10</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="chd" id="chd" value="0">
                                                {{-- <div class="col-md-4">
                                                    <div class="form-group group-addon-select">
                                                        <label for="chd">Anak</label>
                                                        <div class="input-group custom-input">
                                                            <span class="input-group-addon"><i class="fa fa-male" aria-hidden="true"></i></span>
                                                            <select id="chd" name="chd" class="form-control">
                                                                <option value="0" selected>0</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div> --}}
                                                <input type="hidden" name="inf" value="0" />
                                            </div><!--end.row-->
                                            <br>
                                            <button type="submit" class="btn btn-cari">
                                                <span class="glyphicon glyphicon-search"></span> Cari Hotel
                                            </button>
                                        </div><!--end.col4-->
                                    </div><!--end.search-row-->
                                </form>
                            </div>
                            <div id="boxPulsa" class="box-orange box-content-tabs-home {{($services=='pulsa'?'':'hide')}}">
                                <form action="{{ route('pulsa.index') }}" method="GET">
                                    <div id="pulsa">
                                        <div class="row-form">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="phoneNumber">No. Handphone</label>
                                                        <input type="text" class="form-control" name="phoneNumber" v-model="phoneNumber" id="phoneNumber">
                                                    </div>
                                                </div>
                                                <div class="col-md-4" v-if="nominalInput">
                                                    <div class="form-group">
                                                        <label for="code">Nominal</label>
                                                        <select class="form-control" id="code" name="code">
                                                            <option v-for="nominal in nominals" v-bind:value="nominal.id">@{{ nominal.name }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>&nbsp;</label>
                                                        <button class="btn btn-cari" v-if="btnInquery"><i class="fa fa-money"></i> Cek Harga</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div id="boxPpob" class="box-orange box-content-tabs-home {{($services=='ppob'?'':'hide')}}">
                                <form action="{{ route('ppob.index') }}" method="GET">
                                    {{csrf_field()}}
                                <div id="ppob" >
                                    <div class="row-form">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="services">Layanan</label>
                                                    <select  v-model="serviceId" v-on:change="addProduct(serviceId)" name="service_id" class="form-control col-md-12">
                                                        <option v-bind:value="0">Pilih layanan</option>
                                                        <option v-for="service in services" v-bind:value="service.id" v-if="service.id!==1">@{{ service.name }}</option>
                                                    </select>
                                                </div>
                                            </div><!--end.col-md-4-->
                                            <div class="col-md-3" v-if="showSelectOne">
                                                <div class="form-group">
                                                    <label for="products">@{{ labelOne }}</label>
                                                    <select  v-model="productId" v-on:change="addNominal(productId)" name="product_id" class="form-control col-md-12">
                                                        <option v-bind:value=0>Pilih @{{ labelOne }}</option>
                                                        <option v-for="product in products" v-bind:value="product.id">@{{ product.name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3" v-if="showSelectTwo">
                                                <div class="form-group">
                                                    <label for="products">@{{ labelTwo }}</label>
                                                    <select  v-model="nominalCode" v-on:change="showform(nominalCode)" name="nominal_code" class="form-control col-md-12">
                                                        <option v-bind:value="0">Pilih @{{ labelTwo }}</option>
                                                        <option v-for="nominal in nominals" v-bind:value="nominal.id">@{{ nominal.name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2" v-if="showInputNumber">
                                                <div class="form-group">
                                                    <label for="number">@{{ labelThree }}</label>
                                                    <input list="numberSaveds" type="text" v-model="number" name="number" @keydown="searchNumber" @mouseover="searchNumber" class="form-control" autocomplete="off">
                                                    <datalist id="numberSaveds">
                                                        <option v-for="listNumber in listNumbers" :value="listNumber.number"> @{{listNumber.name}} </option>
                                                    </datalist>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <br>
                                                <button v-show="btn" type="submit"  class="btn btn-cari">
                                                    Cek Harga</span>
                                                </button>
                                            </div><!--end.col-md-4-->
                                        </div><!--end.row-->
                                    </div><!--end.row-form-->
                                </div><!--end.box-range-->
                                </form>
                            </div><!--end.box-orange-->
                            <div id="boxVoucher" class="box-orange box-content-tabs-home {{($services=='voucher'?'':'hide')}}">
                                <form action="{{ route('voucher.index') }}" method="GET">
                                    {{csrf_field()}}
                                <div id="voucher" >
                                    <div class="row-form">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="services">Voucher Game</label>
                                                    <select  v-model="serviceId" v-on:change="addProduct(serviceId)" name="service_id" class="form-control col-md-12">
                                                        <option v-bind:value="0">Pilih voucher</option>
                                                        <option v-for="service in services" v-bind:value="service.id">@{{ service.name }}</option>
                                                    </select>
                                                </div>
                                            </div><!--end.col-md-4-->
                                            <div class="col-md-3" v-if="showSelectOne">
                                                <div class="form-group">
                                                    <label for="products">@{{ labelOne }}</label>
                                                    <select  v-model="productId" v-on:change="showform(productId)" name="product_id" class="form-control col-md-12">
                                                        <option v-bind:value=0>Pilih @{{ labelOne }}</option>
                                                        <option v-for="product in products" v-bind:value="product.id">@{{ product.name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3" v-if="showSelectTwo">
                                                <div class="form-group">
                                                    <label for="products">@{{ labelTwo }}</label>
                                                    <select  v-model="nominalCode" v-on:change="showform(nominalCode)" name="nominal_code" class="form-control col-md-12">
                                                        <option v-bind:value="0">Pilih @{{ labelTwo }}</option>
                                                        <option v-for="nominal in nominals" v-bind:value="nominal.id">@{{ nominal.name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2" v-if="showInputNumber">
                                                <div class="form-group">
                                                    <label for="number">@{{ labelThree }}</label>
                                                    <input list="numberSaveds" type="text" v-model="number" name="number" @keydown="searchNumber" @mouseover="searchNumber" class="form-control" autocomplete="off">
                                                    <datalist id="numberSaveds">
                                                        <option v-for="listNumber in listNumbers" :value="listNumber.number"> @{{listNumber.name}} </option>
                                                    </datalist>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <br>
                                                <button v-show="btn" type="submit"  class="btn btn-cari">
                                                    Cek Harga</span>
                                                </button>
                                            </div><!--end.col-md-4-->
                                        </div><!--end.row-->
                                    </div><!--end.row-form-->
                                </div><!--end.box-range-->
                                </form>
                            </div><!--end.box-orange-->
                        </div><!--end.content-tabs-home-->
                        <div class="box-home-bottom">
                            <h3>BEBERAPA MITRA KAMI</h3>
                            <div class="list-mitra">
                                <div class="row" id="mitraMaskapai">
                                    <div class="item-mitra"><img src="{{ asset('/images/mitra/airlines/airasia.png') }}"></div>
                                    <div class="item-mitra"><img src="{{ asset('/images/mitra/airlines/citilink.png') }}"></div>
                                    <div class="item-mitra"><img src="{{ asset('/images/mitra/airlines/garuda.png') }}"></div>
                                    <!-- <div class="item-mitra"><img src="{{ asset('/images/mitra/airlines/kalstar.png') }}"></div> -->
                                    <div class="item-mitra"><img src="{{ asset('/images/mitra/airlines/lion_air.png') }}"></div>
                                    <div class="item-mitra"><img src="{{ asset('/images/mitra/airlines/sriwijaya.png') }}"></div>
                                    <div class="item-mitra"><img src="{{ asset('/images/mitra/airlines/transnusa.png') }}"></div>
                                    <div class="item-mitra"><img src="{{ asset('/images/mitra/airlines/trigana_air.png') }}"></div>
                                </div>
                                <div class="row" id="mitraKai">
                                    <div class="item-mitra"><img src="{{asset('/assets/logo/kai.png')}}"></div>
                                </div>
                                <div class="row" id="mitraRailink">
                                    <div class="item-mitra"><img src="{{asset('/assets/logo/railink.png')}}"></div>
                                </div>
                                <div class="row" id="mitraHotel">
                                    {{-- <div class="item-mitra"><img src="{{asset('/assets/logo/railink.png')}}"></div> --}}
                                </div>
                                <div class="row" id="mitraPulsa">
                                    <div class="item-mitra"><img src="{{ asset('/images/mitra/ppob/axis.png') }}"></div>
                                    <div class="item-mitra"><img src="{{ asset('/images/mitra/ppob/bolt.png') }}"></div>
                                    <div class="item-mitra"><img src="{{ asset('/images/mitra/ppob/indosat.png') }}"></div>
                                    <div class="item-mitra"><img src="{{ asset('/images/mitra/ppob/smartfren.png') }}"></div>
                                    <div class="item-mitra"><img src="{{ asset('/images/mitra/ppob/telkomsel.png') }}"></div>
                                    <div class="item-mitra"><img src="{{ asset('/images/mitra/ppob/xl.png') }}"></div>
                                </div>
                                <div class="row" id="mitraPpob">
                                    <div class="item-mitra"><img src="{{ asset('/images/mitra/ppob/indovision.png') }}"></div>
                                    <div class="item-mitra"><img src="{{ asset('/images/mitra/ppob/mcf.png') }}"></div>
                                    <div class="item-mitra"><img src="{{ asset('/images/mitra/ppob/palyja.png') }}"></div>
                                    <div class="item-mitra"><img src="{{ asset('/images/mitra/ppob/pln.png') }}"></div>
                                    <div class="item-mitra"><img src="{{ asset('/images/mitra/ppob/transvision.png') }}"></div>
                                </div>
                                <script>
                                    @if($services=='airlines'||$services==null)
                                    $('#mitraMaskapai').show();
                                    $('#mitraKai').hide();
                                    $('#mitraRailink').hide();
                                    $('#mitraHotel').hide();
                                    $('#mitraPulsa').hide();
                                    $('#mitraPpob').hide();
                                    @endif
                                    @if($services=='train')
                                    $('#mitraMaskapai').hide();
                                    $('#mitraKai').show();
                                    $('#mitraRailink').hide();
                                    $('#mitraHotel').hide();
                                    $('#mitraPulsa').hide();
                                    $('#mitraPpob').hide();
                                    @endif
                                    @if($services=='railink')
                                    $('#mitraMaskapai').hide();
                                    $('#mitraKai').hide();
                                    $('#mitraRailink').show();
                                    $('#mitraHotel').hide();
                                    $('#mitraPulsa').hide();
                                    $('#mitraPpob').hide();
                                    @endif
                                    @if($services=='hotel')
                                    $('#mitraMaskapai').hide();
                                    $('#mitraKai').hide();
                                    $('#mitraRailink').hide();
                                    $('#mitraHotel').show();
                                    $('#mitraPulsa').hide();
                                    $('#mitraPpob').hide();
                                    @endif
                                    @if($services=='pulsa')
                                    $('#mitraMaskapai').hide();
                                    $('#mitraKai').hide();
                                    $('#mitraRailink').hide();
                                    $('#mitraHotel').hide();
                                    $('#mitraPulsa').show();
                                    $('#mitraPpob').hide();
                                    @endif
                                    @if($services=='ppob')
                                    $('#mitraMaskapai').hide();
                                    $('#mitraKai').hide();
                                    $('#mitraRailink').hide();
                                    $('#mitraHotel').hide();
                                    $('#mitraPulsa').hide();
                                    $('#mitraPpob').show();
                                    @endif
                                </script>
                            </div>
                            <div><!--end.box-home-bottom-->
                            </div><!--end.box-home-->
                        </div><!--end.col-md-12-->
                    </div><!--end.row-->
                </div><!--end.container-->
            </div>
        </div>
    </section>
    <section id="home-why">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3>MENGAPA <strong>SIP</strong> MERUPAKAN PILIHAN PINTAR ANDA?</h3>
                    <div class="list-why">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="items-why">
                                    <div class="images"><img src="{{ asset('/assets/images/material/icon-why1.png') }}"></div>
                                    <div class="caption-why">
                                        <h4>EFISIEN</h4>
                                        <p>Solusi kemudahan dan efisiensi bagi siapapun dalam melakukan transaksi Digital Payment.</p>
                                    </div><!--end.caption-why-->
                                </div><!--end.items-why-->
                            </div><!--end.col-md-3-->
                            <div class="col-md-4">
                                <div class="items-why">
                                    <div class="images"><img src="{{ asset('/assets/images/material/icon-why3.png') }}"></div>
                                    <div class="caption-why">
                                        <h4>HARGA MURAH</h4>
                                        <p>Memberikan penawaran menarik sehingga anda selalu mendapatkan harga terbaik.</p>
                                    </div><!--end.caption-why-->
                                </div><!--end.items-why-->
                            </div><!--end.col-md-3-->
                            <div class="col-md-4">
                                <div class="items-why">
                                    <div class="images"><img src="{{ asset('/assets/images/material/icon-why2.png') }}"></div>
                                    <div class="caption-why">
                                        <h4>MUDAH DIGUNAKAN</h4>
                                        <p>Memberikan kenyamanan dan kemudahan dalam bertransaksi yang bisa dinikmati dan digunakan oleh semua orang.</p>
                                    </div><!--end.caption-why-->
                                </div><!--end.items-why-->
                            </div><!--end.col-md-3-->
                        </div><!--end.row-->
                    </div><!--end.list-why-->
                </div><!--end.col-md-12-->
            </div><!--end.row-->
        </div><!--end.container-->
    </section>
    <section id="home-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <div class="list-home-footer">
                        <h4 class="list-f-title">SMART IN PAYS</h4>
                        <ul class="list-f-menu">
                            <li><a href="#">About Us</a></li>
                        </ul>
                    </div><!--end.list-home-footer-->
                </div><!--end.col-md-2-->
                <div class="col-md-2">
                    <div class="list-home-footer">
                        <h4 class="list-f-title">BE A MEMBER OF SIP</h4>
                        <ul class="list-f-menu">
                            <li><a href="#">About Member SIP</a></li>
                            <li><a href="#">How to join?</a></li>
                        </ul>
                    </div><!--end.list-home-footer-->
                </div><!--end.col-md-2-->
                <div class="col-md-2">
                    <div class="list-home-footer">
                        <h4 class="list-f-title">HELP</h4>
                        <ul class="list-f-menu">
                            <li><a href="{{ route('sip.faq') }}">FAQ</a></li>
                            <li><a href="#">How to Order</a></li>
                            <li><a href="#">Contact Us</a></li>
                            <li><a href="{{ route('sip.term') }}">Term & Conditions</a></li>
                        </ul>
                    </div><!--end.list-home-footer-->
                </div><!--end.col-md-2-->
                <div class="col-md-3">
                    <div class="list-home-footer">
                        <h4 class="list-f-title">DOWNLOAD THE APP</h4>
                        <p>Download <strong>GRATIS!</strong> SIP Sekarang Juga Makin mudah anda akan bertransaksi.</p>
                        <div class="downloadApps">
                            <a href=""><img src="{{ asset('/assets/images/material/google-play.png') }}"></a>
                            <a href=""><img src="{{ asset('/assets/images/material/appstore.png') }}"></a>
                        </div>
                    </div><!--end.list-home-footer-->
                </div><!--end.col-md-3-->
                <div class="col-md-3">
                    {{--<div class="list-home-footer">--}}
                        {{--<h4 class="list-f-title">SUBSCRIBE</h4>--}}
                        {{--<p>Please subscribe to get PROMO notification from us.</p>--}}
                        {{--<div class="foot-subs">--}}
                            {{--<form>--}}
                                {{--<input type="text"><input type="submit" class="submit-blue" value="Submit">--}}
                            {{--</form>--}}
                        {{--</div>--}}
                    {{--</div><!--end.list-home-footer-->--}}
                </div><!--end.col-md-3-->
            </div><!--end.row-->
        </div><!--end.container-->
    </section>
@endsection
@section('js')
    @parent

    <script>

        Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
        Vue.http.options.emulateJSON = true;
        Vue.component('component-captcha',{
            template:'#captcha'
        });
        var pulsa=new Vue({el:"#pulsa",data:{url:'{{url('/rest/ppob/services?service_id=')}}',phoneNumber:"",bolt:null,indosat:null,telkomsel:null,xl:null,axis:null,three:null,smartfren:null,nominals:null,btnInquery:!1},computed:{nominals:function(){if(this.bolt == null){this.$http.get(this.url+'17').then((response)=>{this.bolt =response.data.detail.services;},(response)=>{});}if(this.indosat == null){this.$http.get(this.url+'13').then((response)=>{this.indosat =response.data.detail.services;},(response)=>{});}if(this.telkomsel == null){this.$http.get(this.url+'16').then((response)=>{this.telkomsel =response.data.detail.services;},(response)=>{});}if(this.xl == null){this.$http.get(this.url+'10').then((response)=>{this.xl =response.data.detail.services;},(response)=>{});}if(this.axis == null){this.$http.get(this.url+'14').then((response)=>{this.axis =response.data.detail.services;},(response)=>{});}if(this.three == null){this.$http.get(this.url+'15').then((response)=>{this.three =response.data.detail.services;},(response)=>{});}if(this.smartfren == null){this.$http.get(this.url+'11').then((response)=>{this.smartfren =response.data.detail.services;},(response)=>{});}if(!(this.phoneNumber.length>=4))return this.nominal=[{value:"",name:"Masukan Nomor HP dulu"}];switch(this.phoneNumber.substring(0,4)){case"0811":return this.nominals=this.telkomsel;case"0812":return this.nominals=this.telkomsel;case"0813":return this.nominals=this.telkomsel;case"0821":return this.nominals=this.telkomsel;case"0822":return this.nominals=this.telkomsel;case"0823":return this.nominals=this.telkomsel;case"0851":return this.nominals=this.telkomsel;case"0852":return this.nominals=this.telkomsel;case"0853":return this.nominals=this.telkomsel;case"0814":return this.nominals=this.indosat;case"0815":return this.nominals=this.indosat;case"0816":return this.nominals=this.indosat;case"0855":return this.nominals=this.indosat;case"0856":return this.nominals=this.indosat;case"0857":return this.nominals=this.indosat;case"0858":return this.nominals=this.indosat;case"0817":return this.nominals=this.xl;case"0818":return this.nominals=this.xl;case"0819":return this.nominals=this.xl;case"0877":return this.nominals=this.xl;case"0878":return this.nominals=this.xl;case"0895":return this.nominals=this.three;case"0896":return this.nominals=this.three;case"0897":return this.nominals=this.three;case"0898":return this.nominals=this.three;case"0899":return this.nominals=this.three;case"0831":return this.nominals=this.axis;case"0832":return this.nominals=this.axis;case"0833":return this.nominals=this.axis;case"0859":return this.nominals=this.xl;case"0838":return this.nominals=this.axis;case"0881":return this.nominals=this.smartfren;case"0882":return this.nominals=this.smartfren;case"0883":return this.nominals=this.smartfren;case"0884":return this.nominals=this.smartfren;case"0885":return this.nominals=this.smartfren;case"0886":return this.nominals=this.smartfren;case"0887":return this.nominals=this.smartfren;case"0888":return this.nominals=this.smartfren;case"0889":return this.nominals=this.smartfren;case '9980':return this.nominals=this.bolt;case '9981':return this.nominals=this.bolt;case '9982':return this.nominals=this.bolt;case '9983':return this.nominals=this.bolt;case '9984':return this.nominals=this.bolt;case '9985':return this.nominals=this.bolt;case '9986':return this.nominals=this.bolt;case '9987':return this.nominals=this.bolt;case '9989':return this.nominals=this.bolt;case '9988':return this.nominals=this.bolt;case '9990':return this.nominals=this.bolt;case '9991':return this.nominals=this.bolt;case '9992':return this.nominals=this.bolt;case '9993':return this.nominals=this.bolt;case '9994':return this.nominals=this.bolt;case '9995':return this.nominals=this.bolt;case '9996':return this.nominals=this.bolt;case '9997':return this.nominals=this.bolt;case '9998':return this.nominals=this.bolt;case '9999':return this.nominals=this.bolt;;default:return this.nominals=[{value:"",name:"Nomer tidak terdaftar"}]}},btnInquery:function(){if(this.phoneNumber.length>=10)return!0},nominalInput:function(){return this.phoneNumber.length>=4}}});
    </script>
    <script>
        var ppob=new Vue({
            el:"#ppob",
            data:{
                url:'{{route('rest.ppob_services')}}',
                urlSearch:'{{route('rest.number_saveds')}}',
                username:'',
                password:'',
                services:null,
                products:null,
                nominals:null,
                serviceId:0,
                productId:0,
                nominalCode:0,
                labelOne:'',
                labelTwo:'',
                labelThree:'',
                showSelectOne:!1,
                showSelectTwo:!1,
                btn:!1,
                showInputNumber:!1,
                showInquery:!1,
                showInquerySuccess:!1,
                showInqueryFailed:!1,
                loader:!1,
                term:!1,
                saveNumber:!1,
                errorTerm:!1,
                number:null,
                reff:'',
                attributes:{},
                errorPassword:!1,
                pr:0,
                listNumbers:[
                    {
                        "number":"",
                        "name":""
                    }
                ],
                resultInquery:[
                    {
                        'error_msg':null
                    }
                ],
                price:null,
                failed:!1,
                success:!1,
                result:null
            },
            filters:{
                addCommas:function(nStr){
                    nStr+='';x=nStr.split('.');
                    x1=x[0];x2=x.length>1?'.'+x[1]:'';
                    var rgx=/(\d+)(\d{3})/;
                    while(rgx.test(x1)){
                        x1=x1.replace(rgx,'$1'+','+'$2')
                    }
                    return x1+x2
                }
            },
            methods:{
                searchNumber:function(){
                    endSearchUrl=this.urlSearch+"?service="+this.serviceId;
                    this.$http.get(endSearchUrl).then((response)=>{
                        this.listNumbers=response.data
                    },
                    (response)=>{})
                },
                addServices:function(){
                    this.$http.get(this.url).then((response)=>{
                        this.services=response.data.detail.services
                    },
                    (response)=>{})
                },
                addProduct:function(serviceId){
                    this.showInquery=!1;
                    this.showInquery=!1;
                    this.showInquerySuccess=!1;
                    this.showInqueryFailed=!1;
                    this.success=!1;
                    this.failed=!1;
                    this.password='';
                    this.number=null;
                    this.code="";
                    this.reff='';
                    this.products=null;
                    this.nominals=null;
                    this.errorPassword=!1;
                    this.resultInquery=[
                        {
                            'error_msg':null
                        }
                    ];
                    this.attributes={};
                    this.price=null;
                    this.nominalCode=0;
                    this.term=!1;this.errorTerm=!1;
                    if(serviceId!=0){
                        if(serviceId==3){
                            this.showSelectOne=!1;
                            switch(serviceId){
                                case 3:this.labelThree="No. Pelanggan";
                                this.showSelectOne=!1;
                                this.showSelectTwo=!1;
                                this.showform(serviceId);
                                break;
                                case 18:this.labelThree="No. Handphone";
                                this.showSelectOne=!1;
                                this.showSelectTwo=!1;
                                this.showform(serviceId);
                                break;
                              }
                        }
                        else{
                            this.showInputNumber=!1;
                            this.showSelectOne=!0;
                            this.btn=!1;
                            if(serviceId==2){
                                this.showSelectOne=!1;
                                this.addNominal(serviceId)
                            }
                            else{
                                this.productId=0;
                                this.showform(0);
                                this.showSelectTwo=!1;
                                var endPoint=this.url+'?service_id='+serviceId;
                                this.labelOne='Produk';
                                this.$http.get(endPoint).then((response)=>{
                                    this.products=response.data.detail.services
                                },
                                (response)=>{})
                            }
                        }
                    }
                    else{
                        this.showSelectOne=!1;
                        this.showSelectTwo=!1;
                        this.showform(serviceId)
                    }
                    return serviceId
                },
                addNominal:function(productId){
                    this.showInquery=!1;
                    this.showInquerySuccess=!1;
                    this.showInqueryFailed=!1;
                    this.errorPassword=!1;
                    if(productId==0||productId==30||this.serviceId==4||this.serviceId==7||this.serviceId==6||this.serviceId==8||this.serviceId==9||this.serviceId==348){
                        this.nominalCode=0;
                        this.showSelectTwo=!1;
                        this.showform(0);
                        if(productId==30||this.serviceId==7||this.serviceId==6||this.serviceId==8||this.serviceId==4||this.serviceId==9||this.serviceId==348){
                            this.nominalCode=productId;
                            this.showform(30)
                        }
                    }
                    else{
                        this.showform(0);
                        this.nominalCode=0;
                        this.labelTwo="Nominal";
                        this.showSelectTwo=!0;
                        var endPoint=this.url+'?service_id='+productId;
                        this.$http.get(endPoint).then((response)=>{
                            this.nominals=response.data.detail.services
                        },(response)=>{})
                    }
                },
                showform:function(value){
                    this.showInquery=!1;
                    this.showInquerySuccess=!1;
                    this.showInqueryFailed=!1;
                    var code=value;
                    if(value==undefined){
                        code=this.nominalCode
                    }
                    if(code==0){
                        this.labelThree='';
                        this.showInputNumber=!1;
                        this.btn=!1
                    }
                    else{
                        this.labelThree='Masukan No.';
                        this.showInputNumber=!0;
                        this.btn=!0
                    }
                },
                inquery:function(){
                    this.loader=!0;
                    this.showInquery=!1;
                    this.showInquerySuccess=!1;
                    this.showInqueryFailed=!1;
                    this.failed=!1;
                    this.success=!1;
                    this.term=!1;
                    this.password='';
                    this.errorPassword=!1;
                    this.errorTerm=!1;
                    var endPoint='{{route('ppob.inquery')}}';
                    var attributes={
                        'serviceId':this.serviceId,
                        'nominalCode':this.nominalCode,
                        'number':this.number
                    };
                    if(this.number!=null){
                        this.$http.post(endPoint,attributes).then((response)=>{
                            this.loader=!1;
                            this.resultInquery=response.data;
                            if(response.data.error_code=='000'){
                                if(this.serviceId!=2){
                                    this.reff=this.resultInquery.reff;
                                    this.price=this.resultInquery.total
                                }
                                this.showInquery=!0;
                                this.showInquerySuccess=!0
                            }
                            else{
                                this.showInquery=!0
                            }
                        },
                        (response)=>{
                            this.showInquery=!0;
                            this.showInqueryFailed=!0;
                            this.loader=!1
                        })
                    }
                },
                ppobTransaction:function(){
                    this.errorPassword=!1;
                    if(this.term===!0){
                        if(this.password.trim()!=''){
                            this.errorTerm=!1;
                            $('#transactionLoader').show();
                            $('#formValidation').hide();
                            if(this.serviceId=='2'){
                                this.attributes={
                                    'password':this.password,
                                    'number':this.number,
                                    'code':this.nominalCode,
                                    'admin':parseInt(this.resultInquery.admin),
                                    'commission':parseInt(this.resultInquery.commission),
                                    'service_id':this.serviceId,
                                    'pr':this.pr,
                                    'save_number':this.saveNumber,
                                    'name':this.resultInquery.nama
                                }
                            }
                            else if(this.serviceId=='3'){
                                this.attributes={
                                    'password':this.password,
                                    'number':this.number,
                                    'code':this.serviceId,
                                    'admin':parseInt(this.resultInquery.admin),
                                    'commission':parseInt(this.resultInquery.commission),
                                    'service_id':this.serviceId,
                                    'price':this.price,
                                    'pr':this.pr,
                                    'save_number':this.saveNumber,
                                    'name':this.resultInquery.nama
                                }
                            }
                            else if(this.serviceId=='4'){
                                this.attributes={
                                    'password':this.password,
                                    'number':this.number,
                                    'code':this.nominalCode,
                                    'admin':parseInt(this.resultInquery.admin),
                                    'commission':parseInt(this.resultInquery.commission),
                                    'service_id':this.serviceId,
                                    'reff':this.reff,
                                    'price':this.price,
                                    'pr':this.pr,
                                    'save_number':this.saveNumber,
                                    'name':this.resultInquery.nama
                                }
                            }
                            else if(this.serviceId=='5'){
                                this.attributes={
                                    'password':this.password,
                                    'number':this.number,
                                    'code':this.nominalCode,
                                    'admin':parseInt(this.resultInquery.admin),
                                    'commission':parseInt(this.resultInquery.commission),
                                    'service_id':this.serviceId,
                                    'reff':this.reff,
                                    'price':this.price,
                                    'pr':this.pr,
                                    'save_number':this.saveNumber,
                                    'name':this.resultInquery.nama
                                }
                            }
                            else if(this.serviceId=='6'){
                                this.attributes={
                                    'password':this.password,
                                    'number':this.number,
                                    'code':this.nominalCode,
                                    'admin':parseInt(this.resultInquery.admin),
                                    'commission':parseInt(this.resultInquery.commission),
                                    'service_id':this.serviceId,
                                    'reff':this.reff,
                                    'price':this.price,
                                    'pr':this.pr,
                                    'save_number':this.saveNumber,
                                    'name':this.resultInquery.nama
                                }
                            }
                            else if(this.serviceId=='7'){
                                this.attributes={
                                    'password':this.password,
                                    'number':this.number,
                                    'code':this.nominalCode,
                                    'admin':parseInt(this.resultInquery.admin),
                                    'commission':parseInt(this.resultInquery.commission),
                                    'service_id':this.serviceId,
                                    'reff':this.reff,
                                    'price':this.price,
                                    'pr':this.pr,
                                    'save_number':this.saveNumber,
                                    'name':this.resultInquery.nama
                                }
                            }
                            else if(this.serviceId=='8'){
                                this.attributes={
                                    'password':this.password,
                                    'number':this.number,
                                    'code':this.nominalCode,
                                    'admin':parseInt(this.resultInquery.admin),
                                    'commission':parseInt(this.resultInquery.commission),
                                    'service_id':this.serviceId,
                                    'reff':this.reff,
                                    'price':this.price,
                                    'pr':this.pr,
                                    'save_number':this.saveNumber,
                                    'name':this.resultInquery.nama
                                }
                            }
                            else if(this.serviceId=='9'){
                                this.attributes={
                                    'password':this.password,
                                    'number':this.number,
                                    'code':this.nominalCode,
                                    'admin':parseInt(this.resultInquery.admin),
                                    'service_id':this.serviceId,
                                    'reff':this.reff,
                                    'price':this.price,
                                    'save_number':this.saveNumber,
                                    'name':this.resultInquery.nama
                                }
                            }
                            this.$http.post(window.url,this.attributes).then((response)=>{
                                this.failed=!1;
                                this.result=response.data;
                                this.password="";
                                $('#transactionLoader').hide();
                                if(this.result.status.code==200){
                                    return this.success=!0
                                }
                                else{
                                    return this.failed=!0
                                }
                            },
                            (response)=>{
                                $('#transactionLoader').hide();
                                this.failed=!0
                            })
                        }
                        else{
                            this.errorPassword=!0
                        }
                    }
                    else{
                        this.errorTerm=!0;
                        console.log("NOTERM")
                    }
                }
            },
            mounted:function(){
                this.addServices()
            }
        })
    </script>
    <script>
      var voucher = new Vue({
        el: '#voucher',
        data: {
          url:'{{route('rest.ppob_services')}}',
          urlSearch:'{{route('rest.number_saveds')}}',
          services : null,
          products:null,
          nominals:null,
          username:'',
          password:'',
          services:null,
          products:null,
          nominals:null,
          serviceId:0,
          productId:0,
          nominalCode:0,
          labelOne:'',
          labelTwo:'',
          labelThree:'',
          showSelectOne:!1,
          showSelectTwo:!1,
          btn:!1,
          showInputNumber:!1,
          showInquery:!1,
          showInquerySuccess:!1,
          showInqueryFailed:!1,
          loader:!1,
          term:!1,
          saveNumber:!1,
          errorTerm:!1,
          number:null,
          reff:'',
          attributes:{},
          errorPassword:!1,
          pr:0,
          listNumbers:[
              {
                  "number":"",
                  "name":""
              }
          ],
          resultInquery:[
              {
                  'error_msg':null
              }
          ],
          price:null,
          failed:!1,
          success:!1,
          result:null
        },
        methods: {
          addVouchers:function(){
              console.log('Sukses');
              this.$http.get(this.url+'?service_id=18').then((response)=>{
                  this.services=response.data.detail.services
              },
              (response)=>{})
          },
          addProduct:function(serviceId){
              this.showInquery=!1;
              this.showInquerySuccess=!1;
              this.showInqueryFailed=!1;
              this.success=!1;
              this.failed=!1;
              this.password='';
              this.number=null;
              this.code="";
              this.reff='';
              this.products=null;
              this.nominals=null;
              this.errorPassword=!1;
              this.resultInquery=[
                  {
                      'error_msg':null
                  }
              ];
              this.attributes={};
              this.price=null;
              this.nominalCode=0;
              this.term=!1;this.errorTerm=!1;
              if(serviceId!=0){
                  if(serviceId==3){
                      this.showSelectOne=!1;
                      switch(serviceId){
                          case 3:this.labelThree="No. Pelanggan";
                          this.showSelectOne=!1;
                          this.showSelectTwo=!1;
                          this.showform(serviceId);
                          break}
                  }
                  else{
                      this.showInputNumber=!1;
                      this.showSelectOne=!0;
                      this.btn=!1;
                      if(serviceId==2){
                          this.showSelectOne=!1;
                          this.addNominal(serviceId)
                      }
                      else{
                          this.productId=0;
                          this.showform(0);
                          this.showSelectTwo=!1;
                          var endPoint=this.url+'?service_id='+serviceId;
                          this.labelOne='Nominal';
                          this.$http.get(endPoint).then((response)=>{
                              this.products=response.data.detail.services
                          },
                          (response)=>{})
                      }
                  }
              }
              else{
                  this.showSelectOne=!1;
                  this.showSelectTwo=!1;
                  this.showform(serviceId)
              }
              return serviceId
          },
          showform:function(value){
              this.showInquery=!1;
              this.showInquerySuccess=!1;
              this.showInqueryFailed=!1;
              var code=value;
              if(value==undefined){
                  code=this.nominalCode
              }
              if(code==0){
                  this.labelThree='';
                  this.showInputNumber=!1;
                  this.btn=!1
              }
              else{
                  this.labelThree='Masukan No.';
                  this.showInputNumber=!0;
                  this.btn=!0
              }
          },
          addNominal:function(productId){
              this.showInquery=!1;
              this.showInquerySuccess=!1;
              this.showInqueryFailed=!1;
              this.errorPassword=!1;
              if(productId==0||productId==30||this.serviceId==4||this.serviceId==7||this.serviceId==6||this.serviceId==8||this.serviceId==9||this.serviceId==348){
                  this.nominalCode=0;
                  this.showSelectTwo=!1;
                  this.showform(0);
                  if(productId==30||this.serviceId==7||this.serviceId==6||this.serviceId==8||this.serviceId==4||this.serviceId==9||this.serviceId==348){
                      this.nominalCode=productId;
                      this.showform(30)
                  }
              }
              else{
                  this.showform(0);
                  this.nominalCode=0;
                  this.labelTwo="Nominal";
                  this.showSelectTwo=!0;
                  var endPoint=this.url+'?service_id='+productId;
                  this.$http.get(endPoint).then((response)=>{
                      this.nominals=response.data.detail.services
                  },(response)=>{})
              }
          },
          searchNumber:function(){
              endSearchUrl=this.urlSearch+"?service="+this.serviceId;
              this.$http.get(endSearchUrl).then((response)=>{
                  this.listNumbers=response.data
              },
              (response)=>{})
          },
        },
        mounted:function(){
          this.addVouchers()
        }
      })
    </script>
@endsection
