@extends('layouts.public')
@section('css')
    @parent

@endsection
@section('content')
<!-- STEP BOOKING -->
    <div id="step-booking">
        <div class="container">
            <ul class="breadcrumb-step">
                <li class="active">
                    <a href="javascript:void(0)">
                        1. Pilih Tiket
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        2. Isi Data
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        3. Pilih Kursi
                    </a>
                </li>
            </ul>
        </div><!--end.container-->
    </div><!--end.stepbooking-->

    <!-- END STEP BOOKING -->

    <div id="train">
        <div class="row"><div id="load"></div></div>
        {{--<div class="row"><div id="loadQG"></div></div>--}}
        {{--<div class="row"><div id="loadGA"></div></div>--}}
        {{--<div class="row"><div id="loadKD"></div></div>--}}
        {{--<div class="row"><div id="loadJT"></div></div>--}}
        {{--<div class="row"><div id="loadSJ"></div></div>--}}
        {{--<div class="row"><div id="loadMV"></div></div>--}}
        {{--<div class="row"><div id="loadIL"></div></div>--}}


        @if($trip=="R")
            {!! Form::open(['route'=>'trains.booking_form','method'=>'post','id'=>'getClass']) !!}
            {!! csrf_field() !!}
            {!! Form::hidden('selectedIDdep','',['id'=>'selectedIDdep']) !!}
            {!! Form::hidden('selectedIDret','',['id'=>'selectedIDret']) !!}
            {!! Form::hidden('result','',['id'=>'resultDep']) !!}
            {!! Form::hidden('totalFareDep',0,['id'=>'totalFareDep']) !!}
            {!! Form::hidden('totalFareRet',0,['id'=>'totalFareRet']) !!}
            {!! Form::hidden('indexTrain','',['id'=>'indexTrainDep']) !!}
            {!! Form::hidden('indexFare','',['id'=>'indexFareDep']) !!}
            {!! Form::hidden('indexTrainRet','',['id'=>'indexTrainRet']) !!}
            {!! Form::hidden('indexFareRet','',['id'=>'indexFareRet']) !!}
            {!! Form::close() !!}
            <!-- SELECTED AIRLINES -->
                <div id="testerHeight" style="height: 225px; display: none"></div>
                <section id="chooseFlight" class="main-table">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="rangkuman-table">
                                    <h2>Kereta yang dipilih:</h2>
                                    <div class="row nopadding result-row">
                                        <div class="col-md-9 nopadding item-result">
                                            <div class="left-result">
                                                <div class="row row-resultnya result-berangkat">
                                                    <div class="col-sm-2 col-md-2 inline-row t1">
                                                        <img class="logoFlightFrom-top" width="auto" height="30px" src="#" title="Citilink" alt="QG-153 DPS HLP 07:25">
                                                    </div>
                                                    <div class="col-sm-4 col-md-4 inline-row">
                                                        <p><strong>Pergi:</strong>  <span class="cityFrom-top">Jakarta (CGK)</span>  ke  <span class="cityFin-top">Denpasar (DPS)</span><br>
                                                            <span class="FlightDate">Kamis, 20 Okt 2016</span></p>
                                                        <small class="codeFrom-top">Lion JT-18</small>
                                                    </div>
                                                    <div class="col-sm-2 col-md-2 inline-row text-center">
                                                        <h4 class="timeFrom-top">14:45</h4>
                                                        <p class="cityFrom-top">Jakarta (CGK)</p>
                                                    </div>
                                                    <div class="col-sm-2 col-md-2 inline-row text-center">
                                                        <h4 class="timeFin-top">17:35</h4>
                                                        <p class="cityFin-top">Denpasar (DPS)</p>
                                                    </div>
                                                    <div class="col-sm-2 col-md-2 inline-row"><!--div ini dirubah tambah class-->

                                                    </div>

                                                </div><!--end.row-->
                                                <div class="row row-resultnya result-pulang">
                                                    <div class="col-sm-2 col-md-2 inline-row t1">
                                                        <img class="logoFlightFrom-top" width="auto" height="30px" src="#" title="Citilink" alt="QG-153 DPS HLP 07:25">
                                                    </div>
                                                    <div class="col-sm-4 col-md-4 inline-row">
                                                        <p><strong>Pulang:</strong>  <span class="cityFrom-top">Jakarta (CGK)</span>  ke  <span class="cityFin-top">Denpasar (DPS)</span><br>
                                                            <span class="FlightDate">Kamis, 20 Okt 2016</span></p>
                                                        <small class="codeFrom-top">Lion JT-18</small>
                                                    </div>
                                                    <div class="col-sm-2 col-md-2 inline-row text-center">
                                                        <h4 class="timeFrom-top">14:45</h4>
                                                        <p class="cityFrom-top">Jakarta (CGK)</p>
                                                    </div>
                                                    <div class="col-sm-2 col-md-2 inline-row text-center">
                                                        <h4 class="timeFin-top">17:35</h4>
                                                        <p class="cityFin-top">Denpasar (DPS)</p>
                                                    </div>
                                                    <div class="col-sm-2 col-md-2 inline-row">
                                                        <a class="show-notice">

                                                        </a>
                                                    </div>

                                                </div><!--end.row-->

                                            </div><!--end.left-result-->
                                        </div><!--end.col-md8-->
                                        <div class="col-md-3 nopadding item-result" style="height: 171px;">
                                            <div class="right-result price-summary">
                                                <p>Total Biaya:</p>
                                                <h3 id="summary_pricetotal">IDR <span class="totalFare">1.165.700</span></h3>
                                                <a href="{{route('airlines.get_schedule_class')}}" onclick="event.preventDefault();document.getElementById('getClass').submit();" id="summary_orderlink" class="blue-bt" >PESAN</a>
                                            </div>
                                        </div><!--end.col-md4-->
                                    </div>

                                    {{--<table id="flyFlight" class="table result-tab" style="display:none;">--}}
                                        {{--<tbody>--}}
                                        {{--<tr class="result-berangkat">--}}
                                            {{--<td class="t1"><img class="logoFlightFrom-top" width="52" height="45" src="https://traveloka.s3.amazonaws.com/imageResource/2015/12/17/1450349174390-23151020ad74cd0811255b320fcea754.png" title="Citilink" alt="QG-153 DPS HLP 07:25"></td>--}}
                                            {{--<td class="t2">--}}
                                                {{--<a class="show-notice">--}}
                                                    {{--<div class="notice hidden" data-left="-99" data-check="rangkuman-fixed">CGK - DPS (14:45 - 17:35)</div>--}}
                                                    {{--<p class="transit">1x transit</p>--}}
                                                {{--</a>--}}
                                            {{--</td>--}}
                                            {{--<td class="t3">--}}
                                                {{--<p><strong>Pergi:</strong>  Jakarta (CGK)  ke  Denpasar (DPS)<br>--}}
                                                    {{--Kam, 20 Okt 2016</p>--}}
                                                {{--<small class="codeFrom-top">Lion JT-18</small>--}}
                                            {{--</td>--}}
                                            {{--<td class="t4 text-center">--}}
                                                {{--<h4 class="timeFrom-top">14:45</h4>--}}
                                                {{--<p class="cityFrom-top">Jakarta (CGK)</p>--}}
                                            {{--</td>--}}
                                            {{--<td class="t5 text-center">--}}
                                                {{--<h4 class="timeFin-top">17:35</h4>--}}
                                                {{--<p class="cityFin-top">Denpasar (DPS)</p>--}}
                                            {{--</td>--}}
                                            {{--<td>--}}
                                                {{--<p><i class="fa fa-plane" aria-hidden="true"></i> Pajak Bandara<br><i class="fa fa-briefcase" aria-hidden="true"></i> 20 Kg<br></p>--}}
                                            {{--</td>--}}
                                            {{--<td class="t6">--}}
                                                {{--<p><i class="fa fa-plane" aria-hidden="true"></i> Pajak Bandara<br><i class="fa fa-briefcase" aria-hidden="true"></i> 20 Kg<br></p>--}}
                                            {{--</td>--}}
                                            {{--<td rowspan="2" class="price-summary">--}}
                                                {{--<p>Total Biaya:</p>--}}
                                                {{--<h3 id="summary_pricetotal">IDR 1.165.700 <span class="pax"> /pax</span></h3>--}}
                                                {{--<a href="{{route('airlines.get_schedule_class')}}" onclick="event.preventDefault();document.getElementById('getClass').submit();" class="blue-bt" >PESAN SEKARANG</a>--}}
                                            {{--</td>--}}
                                        {{--</tr>--}}
                                        {{--<tr class="result-pulang">--}}
                                            {{--<td class="t1"><img class="logoFlightFrom-top" width="52" height="45" src="https://traveloka.s3.amazonaws.com/imageResource/2015/12/17/1450349791362-98a47a65885f8cf389b32113f69da413.png" title="Air Asia" alt="XT-7517 DPS CGK 23:00"></td>--}}
                                            {{--<td class="t2">--}}
                                                {{--<a class="show-notice">--}}
                                                    {{--<div class="notice hidden" data-left="-99" data-check="rangkuman-fixed">CGK - DPS (14:45 - 17:35)</div>--}}
                                                    {{--1x transit--}}
                                                {{--</a>--}}
                                            {{--</td>--}}
                                            {{--<td class="t3">--}}
                                                {{--<p><strong>Pergi:</strong>  Jakarta (CGK)  ke  Denpasar (DPS)<br>--}}
                                                    {{--Kam, 20 Okt 2016</p>--}}
                                                {{--<small class="codeFrom-top">Lion JT-18</small>--}}
                                            {{--</td>--}}
                                            {{--<td class="t4 text-center">--}}
                                                {{--<h4 class="timeFrom-top">14:45</h4>--}}
                                                {{--<p class="cityFrom-top">Jakarta (CGK)</p>--}}
                                            {{--</td>--}}
                                            {{--<td class="t5 text-center">--}}
                                                {{--<h4 class="timeFin-top">17:35</h4>--}}
                                                {{--<p class="city-fin">Denpasar (DPS)</p>--}}
                                            {{--</td>--}}
                                            {{--<td>--}}
                                                {{--<p><i class="fa fa-plane" aria-hidden="true"></i> Pajak Bandara<br><i class="fa fa-briefcase" aria-hidden="true"></i> 20 Kg<br></p>--}}
                                            {{--</td>--}}
                                            {{--<td class="t6">--}}
                                                {{--<p><i class="fa fa-plane" aria-hidden="true"></i> Pajak Bandara<br><i class="fa fa-briefcase" aria-hidden="true"></i> 20 Kg<br></p>--}}
                                            {{--</td>--}}
                                        {{--</tr>--}}

                                        {{--</tbody>--}}
                                    {{--</table>--}}
                                </div>
                            </div><!--end.col-->
                        </div><!--end.row-->
                    </div><!--end.container-->
                </section><!--end.maintable-->
                <script>
                  $('#chooseFlight').hide();
                </script>
            <!-- END SELECTED AIRLINES -->


            <!-- START LIST AIRLINES -->
            @include('layouts.search-train')
            <section class="list-tiket">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div id="departure">
                                <div class="row">
                                    <div class="sort-area col-md-12">
                                        <div class="col-md-4 col-sm-4 col-xs-5 sort">
                                            <select class="selectpicker">
                                                <option>PERGI</option>
                                            </select>
                                        </div>
                                        <div class="col-md-8 col-sm-8 col-xs-7 sort">
                                            <select class="selectpicker mySelect1" id="sortAirlines">
                                                <option>Urut jadwal berdasarkan : </option>
                                                <option value="asc|data-price|#departure|dep"> Harga ( Rendah - Tinggi )</option>
                                                <option value="desc|data-price|#departure|dep"> Harga ( Tinggi - Rendah )</option>
                                                <option value="asc|data-time|#departure|dep"> Waktu Berangkat ( Pagi - Sore )</option>
                                                <option value="desc|data-time|#departure|dep"> Waktu Berangkat ( Sore - Pagi )</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="return">
                                <div class="row">
                                    <div class="sort-area col-md-12">
                                        <div class="col-md-4 col-sm-4 col-xs-5 sort">
                                            <select class="selectpicker">
                                                <option>PULANG</option>
                                            </select>
                                        </div>
                                        <div class="col-md-8 col-sm-8 col-xs-7 sort">
                                            <select class="selectpicker mySelect2" id="sortAirlinesRet">
                                                <option>Urut jadwal berdasarkan : </option>
                                                <option value="asc|data-price|#return|ret"> Harga ( Rendah - Tinggi )</option>
                                                <option value="desc|data-price|#return|ret"> Harga ( Tinggi - Rendah )</option>
                                                <option value="asc|data-time|#return|ret"> Waktu Berangkat ( Pagi - Sore )</option>
                                                <option value="desc|data-time|#return|ret"> Waktu Berangkat ( Sore - Pagi )</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- END LIST AIRLINES -->
        @else

            @include('layouts.search-train')
            <div class="row">
            <div class="sort-area col-md-12">
            <div class="col-md-4 col-sm-6 col-xs-8 col-md-offset-8 col-sm-offset-6 col-xs-offset-4 sort">
            <select class="selectpicker mySelect1" id="sortAirlines">
            <option>Urut jadwal berdasarkan : </option>
            <option value="asc|data-price|#success|dep"> Harga ( Rendah - Tinggi )</option>
            <option value="desc|data-price|#success|dep"> Harga ( Tinggi - Rendah )</option>
            <option value="asc|data-time|#success|dep"> Waktu Berangkat ( Pagi - Sore )</option>
            <option value="desc|data-time|#success|dep"> Waktu Berangkat ( Sore - Pagi )</option>
            </select>
            </div>
            </div>
            </div>
        @endif
        <!-- LIST TICKET -->
        <section class="list-tiket">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div id="success"></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END LIST TICKET -->
    </div>



@endsection

@section('js')
    @parent

    @if(old()!=null)
        <script>
            var oldTrainDepartureDate=window.request.departure_date;
            if(window.request.trip=='R'){
                var oldTrainReturnDate=window.request.return_date;
            }
        </script>
    @endif
    <script src="{{asset('/assets/js/ret2dsf98wfwkjs.js')}}"></script>
    <script src="{{asset('/assets/js/tkjsvionwqrain.js')}}"></script>
    <script>
    var defaultValueDep=false;
    var defaultValueRet=false;
    var kolomsort="";
    function sorterAsc(a, b) {
        return (Number(a.getAttribute(kolomsort)) < Number(b.getAttribute(kolomsort))) ? -1 : (Number(a.getAttribute(kolomsort)) >  Number(b.getAttribute(kolomsort))) ? 1 : 0;
    }
    function sorterDesc(a, b) {
        return (Number(a.getAttribute(kolomsort)) > Number(b.getAttribute(kolomsort))) ? -1 : (Number(a.getAttribute(kolomsort)) <  Number(b.getAttribute(kolomsort))) ? 1 : 0;
    }
    function sortAsc(kolom,id,selectClass){
        kolomsort=kolom;
        var sortedDivs = $("."+selectClass).toArray().sort(sorterAsc);
        $.each(sortedDivs, function (index,value) {
            $(id).append(value);
        });
    }
    function sortDesc(kolom,id,selectClass){
        kolomsort=kolom;
        var sortedDivs = $("."+selectClass).toArray().sort(sorterDesc);
        $.each(sortedDivs, function (index,value) {
            $(id).append(value);
        });
    }
    $(".mySelect1").change(function () {
        var str= $("#sortAirlines").val();
        //sortUsingNestedText($('#success'), $(".flight-list-v2"), $(this).data("sortKey"));

        var res=str.split("|");
        if(res[0]=='asc'){
            sortAsc(res[1],res[2],res[3]);
        }else{
            sortDesc(res[1],res[2],res[3]);
        }
    });
    $(".mySelect2").change(function () {
        var str= $("#sortAirlinesRet").val();
        //sortUsingNestedText($('#success'), $(".flight-list-v2"), $(this).data("sortKey"));

        var res=str.split("|");
        if(res[0]=='asc'){
            sortAsc(res[1],res[2],res[3]);
        }else{
            sortDesc(res[1],res[2],res[3]);
        }
    });
        $(document).ready(function () {
            $('#load').html("<div class='col-md-12'><img src='{{asset('/assets/images/Preloader_2.gif')}}' style='height: auto;width:auto;margin:auto;display:block;' class='img-responsive'></div>");
            trains.getSchedule(window.url,window.request,"#load");
            if ($('input[name="trip"]').length > 0) {
                var selected = $('input[name="trip"]:checked').val();
                if (selected === 'undefined' || selected !== 'R') {
                    $('#js-trip').hide();
                }
                $('input[name="trip"]').change(function () {
                    var selected = $('input[name="trip"]:checked').val();
                    if (selected === 'R') {
                        $('#js-trip').show();
                    } else {
                        $('#js-trip').hide();
                    }
                })
            }
          }
        );
    </script>
@endsection
