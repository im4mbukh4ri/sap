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
                <li class="">
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

    <div id="app">
        <div class="row"><div id="load"></div></div>
        {{--<div class="row"><div id="loadQG"></div></div>--}}
        {{--<div class="row"><div id="loadGA"></div></div>--}}
        {{--<div class="row"><div id="loadKD"></div></div>--}}
        {{--<div class="row"><div id="loadJT"></div></div>--}}
        {{--<div class="row"><div id="loadSJ"></div></div>--}}
        {{--<div class="row"><div id="loadMV"></div></div>--}}
        {{--<div class="row"><div id="loadIL"></div></div>--}}


        @if($flight=="R")
            {!! Form::open(['route'=>'airlines.vue_2','method'=>'post','id'=>'getClass']) !!}
            {!! Form::hidden('selectedIDdep0','',['id'=>'selectedIDdep']) !!}
            {!! Form::hidden('selectedIDret0','',['id'=>'selectedIDret']) !!}
            {!! Form::hidden('acDep','',['id'=>'acDep']) !!}
            {!! Form::hidden('acRet','',['id'=>'acRet']) !!}
            {!! Form::hidden('resultDep','',['id'=>'resultDep']) !!}
            {!! Form::hidden('resultRet','',['id'=>'resultRet']) !!}
            {!! Form::hidden('totalFareDep',0,['id'=>'totalFareDep']) !!}
            {!! Form::hidden('totalFareRet',0,['id'=>'totalFareRet']) !!}
            {!! Form::hidden('percentCommission',$percentCommission) !!}
            {!! Form::hidden('percentSmartCash',$percentSmartCash) !!}
            @if($international)
              {!! Form::hidden('international',1) !!}
              {!! Form::hidden('cabin','',['id'=>'cabin'])!!}
            @endif
            {!! Form::close() !!}
            <!-- SELECTED AIRLINES -->
                <div id="testerHeight" style="height: 225px; display: none"></div>
                <section id="chooseFlight" class="main-table">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="rangkuman-table">
                                    <h2>Penerbangan yang dipilih:</h2>
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
                                                        <a class="show-notice">
                                                            Langsung
                                                        </a>
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
                                                            Langsung
                                                        </a>
                                                    </div>

                                                </div><!--end.row-->

                                            </div><!--end.left-result-->
                                        </div><!--end.col-md8-->
                                        <div class="col-md-3 nopadding item-result" style="height: 184px;">
                                            <div class="right-result price-summary">
                                                <p>Total Biaya:</p>
                                                <h3 id="summary_pricetotal">IDR <span class="totalFare">1.165.700</span></h3>
                                                <a href="{{route('airlines.get_schedule_class')}}" onclick="event.preventDefault();document.getElementById('getClass').submit();" id="summary_orderlink" class="blue-bt" >PESAN</a>
                                            </div>
                                        </div><!--end.col-md4-->
                                    </div>
                                </div>
                            </div><!--end.col-->
                        </div><!--end.row-->
                    </div><!--end.container-->
                </section><!--end.maintable-->

            <!-- END SELECTED AIRLINES -->


            <!-- START LIST AIRLINES -->
            @include('layouts.search')
            <section class="list-tiket">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            @if($international)
                                {{-- <button onclick="showReturnEconomy()" id="btnReturnEco" class="btn btn-primary" style="border-radius: 0px;">Ekonomi</button> --}}
                                {{-- <button onclick="showReturnBusiness()" id="btnReturnBus" class="btn btn-danger" style="border-radius: 0px;">Bisnis</button> --}}
                                <br><br>
                            @endif
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
                          @if($international)
                            <br /><br />
                          @endif
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
            @include('layouts.search')
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
                        @if($international&&$flight=='O')
                        {{-- <button onclick="showEconomy()" id="btnEco" class="btn btn-primary" style="border-radius: 0px;">Ekonomi</button> --}}
                        {{-- <button onclick="showBusiness()" id="btnBus" class="btn btn-danger" style="border-radius: 0px;">Bisnis</button> --}}
                        <br><br>
                        @endif
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
            var oldDepartureDate=window.request.departure_date;
            if(window.request.flight=='R'){
                var oldReturnDate=window.request.return_date;
            }
        </script>
    @endif
    <script src="{{asset('/assets/js/ret2dsf98wfwkjs.js')}}"></script>
    <script src="{{asset('/assets/js/sdvdf7yhfi32nc.js')}}"></script>
    <script>
        var businessClass;
        $('#chooseFlight').hide();


        $(document).ready(function () {
            $('#load').html("<div class='col-md-12'><img src='{{asset('/assets/images/Preloader_2.gif')}}' style='height: auto;width:auto;margin:auto;display:block;' class='img-responsive'></div>");
            // close KD
            var airline=['QZ','QG','GA','JT','SJ','MV','IL'];

            window.request.international=false;
            var requestByAirlines=window.request;
            if(window.international==false){
                for(var k=0;k<7;k++){
                    requestByAirlines['airlines_code']=airline[k];
                    airlines.getSchedule(window.url,requestByAirlines,"#load");
                }
            }else{
                window.request.cabin="economy";
                requestByAirlines['airlines_code']=airline[5];
                window.request.international=true;
                airlines.getSchedule(window.url,requestByAirlines,"#load");
                // for(var a=1;a<3;a++){
                //     if(a===1){
                //         window.request.cabin="economy";
                //     }else{
                //         window.request.cabin="business";
                //     }
                //     requestByAirlines['airlines_code']=airline[5];
                //     window.request.international=true;
                //     airlines.getSchedule(window.url,requestByAirlines,"#load");
                // }
            }
            if ($('input[name="flight"]').length > 0) {
                var selected = $('input[name="flight"]:checked').val();
                if (selected === 'undefined' || selected !== 'R') {
                    $('#js-flight').hide();
                }
                $('input[name="flight"]').change(function () {
                    var selected = $('input[name="flight"]:checked').val();
                    if (selected === 'R') {
                        $('#js-flight').show();
                    } else {
                        $('#js-flight').hide();
                    }
                })
            }
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
            window.setTimeout(function () {
                $("#load").hide();
            },60000);
        });

        function showEconomy() {
            $("#btnEco").prop('disabled', true);
            $("#btnBus").prop('disabled', false);
            $("#business").hide();
            $("#economy").show();
        }
        function showBusiness() {
            $("#btnBus").prop('disabled', true);
            $("#btnEco").prop('disabled', false);
            $("#economy").hide();
            $("#business").show();
        }
        function showReturnEconomy(){
          $("#btnReturnEco").prop('disabled', true);
          $("#btnReturnBus").prop('disabled', false);
          $("#depbusiness").hide();
          $("#depeconomy").show();
          $("#retbusiness").hide();
          $("#reteconomy").show();
          setDefaultValueDep();
          setDefaultValueRet();
        }
        function showReturnBusiness(){
          $("#btnReturnEco").prop('disabled', false);
          $("#btnReturnBus").prop('disabled', true);
          $("#depbusiness").show();
          $("#depeconomy").hide();
          $("#retbusiness").show();
          $("#reteconomy").hide();
          setDefaultValueDepBus()
          setDefaultValueRetBus();
        }
        function showDepEconomy(){
            $("#btnEcoDep").prop('disabled', true);
            $("#btnBusDep").prop('disabled', false);
            $("#depbusiness").hide();
            $("#depeconomy").show();
        }
        function showDepBusiness(){
            $("#btnEcoDep").prop('disabled', false);
            $("#btnBusDep").prop('disabled', true);
            $("#depbusiness").show();
            $("#depeconomy").hide();
        }
        function showRetEconomy(){
            $("#btnEcoRet").prop('disabled', true);
            $("#btnBusRet").prop('disabled', false);
            $("#retbusiness").hide();
            $("#reteconomy").show();
        }
        function showRetBusiness(){
            $("#btnEcoRet").prop('disabled', false);
            $("#btnBusRet").prop('disabled', true);
            $("#retbusiness").show();
            $("#reteconomy").hide();
        }
        var defaultValueDep=false;
        var defaultValueRet=false;
    </script>
@endsection
