<?php $user=\Auth::user();?>
@extends('layouts.front')
@section('content')
    <div class="site-wrapper" style="height:auto;min-height: 600px;">>
        <div class="row" style="height: 100%;">
            <div class="container">
                <div class="row">
                    <button class="search-button btn btn-sm transition-effect pull-right" onclick="showSearch()">UBAH PENCARIAN</button>
                </div>
                <div class="row"id="searchFlight">
                    @include('layouts.search-flight')
                </div>
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
                <div id="app">
                    <div class="row"><div id="loadQZ"></div></div>
                    <div class="row"><div id="loadQG"></div></div>
                    <div class="row"><div id="loadGA"></div></div>
                    <div class="row"><div id="loadKD"></div></div>
                    <div class="row"><div id="loadJT"></div></div>
                    <div class="row"><div id="loadSJ"></div></div>
                    <div class="row"><div id="loadMV"></div></div>
                    <div class="row"><div id="loadIL"></div></div>
                    <div id="success">
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>\
@endsection
@section('js')
    @parent
    <script src="{{asset('/assets/js/ret987uiskdfba.js')}}"></script>
    <script src="{{asset('/assets/js/sdvdf7yhfi32nc.js')}}"></script>
        <script>
        $('#searchFlight').hide();
        $('#load{{$airlines_code}}').html("<div class='col-md-4 col-md-offset-4'><div class='col-md-6'><img src='{{asset('/assets/images/airlines/Airline-'.$airlines_code.'.png')}}' style='height:auto;width:auto;display: block;margin-left: auto;margin-right: auto' class='img-responsive'></div><div class='col-md-6'><img src='{{asset('/assets/images/Preloader_2.gif')}}' style='height: auto;width:auto;margin-top:-8%;' class='img-responsive'></div></div>");
        airlines.getSchedule(window.url,window.request,"#load{{$airlines_code}}");

        var kolomsort="";
        function sorterAsc(a, b) {
            return (Number(a.getAttribute(kolomsort)) < Number(b.getAttribute(kolomsort))) ? -1 : (Number(a.getAttribute(kolomsort)) >  Number(b.getAttribute(kolomsort))) ? 1 : 0;
        };
        function sorterDesc(a, b) {
            return (Number(a.getAttribute(kolomsort)) > Number(b.getAttribute(kolomsort))) ? -1 : (Number(a.getAttribute(kolomsort)) <  Number(b.getAttribute(kolomsort))) ? 1 : 0;
        };


        function sortAsc(kolom,id,selectClass){
            kolomsort=kolom;
            var sortedDivs = $("."+selectClass).toArray().sort(sorterAsc);
            console.log(sortedDivs);
            $.each(sortedDivs, function (index,value) {
                $(id).append(value);
            });
        }
        function sortDesc(kolom,id,selectClass){
            kolomsort=kolom;
            var sortedDivs = $("."+selectClass).toArray().sort(sorterDesc);
            console.log(sortedDivs);
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
            console.log(res[0]);
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
            console.log(res[0]);
        });
        function showSearch() {
            $('#searchFlight').fadeIn("slow");
        }
        $(document).ready(function () {

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
            $('.select2').select2()
        });
        </script>
@endsection