<?php
$countFlight=count($airlines['Flights']);
$flightNumberRet=getFlightNumber($airlines['Flights']);
$etdRet=$airlines['Flights'][0]['ETD'];
$etaRet=$airlines['Flights'][0]['ETA'];
$result['ac']=$airlines['ac'];
?>
@if($countFlight>1)
    <?php $totalFare=0;?>
    @foreach($airlines['Fares'] as $fare )
        <?php $totalFare=$totalFare+$fare['TotalFare'];?>
    @endforeach
@else
    <?php $totalFare=$airlines['Fares'][0]['TotalFare'];?>
@endif
<div class="row-rincian row-rincian-pulang ret{{$result['ac'].$indexRet.$cabin}} ret"  data-price="{{$totalFare}}" data-time="{{strtotime($airlines['Flights'][0]['ETD'])}}">
    <span class="resultRet" style="display: none;">{{json_encode($result)}}</span>
    <span class="acRet" style="display:none;">{{$result['ac']}}</span>
    <span class="selectedIDret" style="display: none;">{{$indexRet}}</span>
    <div class="items">
        <div class="label-circle inline-bl">
            <div class="circle-select"><i class="glyphicon glyphicon-ok"></i></div>
        </div>
        <div class="label-rincian inline-bl">
            <div class="row-rin">
                <img class="logoFlight-from" style="height: 30px; width: 50px;" src="{{asset('/assets/logo/'.getAirlineDetail($result['ac'])['icon'])}}" alt="logo-{{getAirlineDetail($result['ac'])['name']}}">
                <span class="code-penerbangan codeFrom">{{$flightNumberRet}}</span>
            </div>
            <div class="row-rin">
                <div class="timeblock">
                    <h4 class="timeFrom">{{date('H:i',strtotime($airlines['Flights'][0]['ETD']))}}</h4>
                    <p class="cityFrom">{{$destination->city}} ({{$destination->id}})</p>
                </div>
                <div class="timeblock">
                    @if($countFlight>1)
                        <h4 class="timeFin">{{date('H:i',strtotime($airlines['Flights'][$countFlight-1]['ETA']))}}</h4>
                    @else
                        <h4 class="timeFin">{{date('H:i',strtotime($airlines['Flights'][0]['ETA']))}}</h4>
                    @endif
                    <p class="cityFin">{{$origin->city}} ({{$origin->id}})</p>
                </div>
                <div class="timeblock">
                    <?php
                    if($countFlight>1){
                        $etd=\Carbon\Carbon::createFromFormat('Y-m-d H:i', $airlines['Flights'][0]['ETD']);
                        $eta=\Carbon\Carbon::createFromFormat('Y-m-d H:i', $airlines['Flights'][$countFlight-1]['ETA']);
                    }else{
                        $etd=\Carbon\Carbon::createFromFormat('Y-m-d H:i', $airlines['Flights'][0]['ETD']);
                        $eta=\Carbon\Carbon::createFromFormat('Y-m-d H:i', $airlines['Flights'][0]['ETA']);
                    }
                    $h=$etd->diffInHours($eta, false);
                    $m=$etd->addHours($h)->diffInMinutes($eta, false);
                    $hShow= $h!="0"?$h.' jam':'';
                    $mShow= $m!="0"?$m.' mnt':'';
                    $showTime=$hShow.' '.$mShow;
                    ?>
                    <h4>{{$showTime}}</h4>
                    <p class="transit">{{$countFlight-1==0?'Langsung':$countFlight-1 .' Transit'}}</p>
                </div>
            </div>
            <div class="row-rin">
                <a href="javascript:void(0)" class="menutab">Detail Penerbangan</a>
            </div>
        </div>
        <div class="label-detail-harga inline-bl">
            <h3 class="harga-real">IDR <span class="totalFare">{{number_format($totalFare)}}</span> </h3>
            {{--<a class="btn btn-primary" href="{{route('airlines.all_schedule_class')}}" onclick="event.preventDefault();document.getElementById('{{$airlines['Fares'][0][0]['selectedIDRet']}}').submit();">PESAN SEKARANG</a>--}}
        </div>
    </div>
    <div class="items-detail">
        @foreach($airlines['Flights'] as $key => $value)
            <div class="items-flight-destination">
                <div class="row-detail">
                    <img width="80" src="{{asset('/assets/logo/'.getLogo($value['FlightNo']).'.png')}}"><br>
                    <span class="code-penerbangan">{{$value['FlightNo']}}</span>
                </div>
                <div class="row-detail">
                    <div class="timeline-flight">
                        <div class="flight-content">
                            <div class="FlightSegment Origin">
                                <div class="FlightDots">
                                    <div class="DotBorder">
                                        <div class="DotCircle"></div>
                                    </div>
                                </div>
                                <div class="FlightTime">
                                    <div class="FlightTimeHour">{{date("h:i",strtotime($value['ETD']))}}</div>
                                    <div class="FlightDateRet{{ $key }}">{{myDay($value['ETD'])}}, {{date('d',strtotime($value['ETD']))}} {{myMonth($value['ETD'])}}</div>
                                </div>
                                <div class="FlightRoute">
                                    <?php $std=getAirport($value['STD']); ?>
                                    <div class="FlightCity">{{$std->city}} ({{$std->id}})</div>
                                    <div class="FlightAirport">{{$std->name}}</div>
                                </div>
                            </div>
                            <div class="FlightSegment HiddenTransitSegment">
                                <div class="FlightDurationTime"><span class="icon"></span><p class="Duration"></p></div>
                                <div class="FlightDotsTransit">
                                    <div class="DotNone">
                                    </div>
                                </div>
                                <div class="HiddenTransit">
                                </div>
                            </div>
                            <div class="FlightSegment Destination">
                                <div class="FlightDots DotsNone">
                                    <div class="DotBorder">
                                        <div class="DotCircle">
                                        </div>
                                    </div>
                                </div>
                                <div class="FlightTime">
                                    <div class="FlightTimeHour">{{date("h:i",strtotime($value['ETA']))}}</div>
                                    <div class="FlightDate">{{myDay($value['ETA'])}}, {{date('d',strtotime($value['ETA']))}} {{myMonth($value['ETA'])}}</div>
                                </div>
                                <div class="FlightRoute">
                                    <?php $sta=getAirport($value['STA']); ?>
                                    <div class="FlightCity">{{$sta->city}} ({{$sta->id}})</div>
                                    <div class="FlightAirport">{{$sta->name}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if($key+1<$countFlight)
                <?php
                $etd=\Carbon\Carbon::createFromFormat('Y-m-d H:i', $airlines['Flights'][$key]['ETA']);
                $eta=\Carbon\Carbon::createFromFormat('Y-m-d H:i', $airlines['Flights'][$key+1]['ETD']);
                $h=$etd->diffInHours($eta, false);
                $m=$etd->addHours($h)->diffInMinutes($eta, false);
                $hShow= $h!="0"?$h.' jam':'';
                $mShow= $m!="0"?$m.' mnt':'';
                $showTime=$hShow.' '.$mShow;
                ?>
                <div class="row-detail">
                    <div class="block-info"><i class="glyphicon glyphicon-time"></i> Transit Selama {{$showTime}} di {{$sta->city}} ({{$sta->id}})</div>
                </div>
            @endif
        @endforeach
    </div>
</div>
<script>
@if($cabin=="economy")
  if(!defaultValueRet){
    function setDefaultValueRet(){
            defaultValueRet=true;
            var timeFrom = $(".ret{{$result['ac'].$indexRet.$cabin}}").find( ".timeFrom" ).text();
            var timeFin = $(".ret{{$result['ac'].$indexRet.$cabin}}").find( ".timeFin" ).text();
            var FlightDate = $(".ret{{$result['ac'].$indexRet.$cabin}}").find(".FlightDateRet0").text();
            var codeFrom = $(".ret{{$result['ac'].$indexRet.$cabin}}").find( ".codeFrom" ).text();
            var cityFrom = $(".ret{{$result['ac'].$indexRet.$cabin}}").find(".cityFrom").text();
            var cityFin=$(".ret{{$result['ac'].$indexRet.$cabin}}").find(".cityFin").text();
            var logoFlight = $(".ret{{$result['ac'].$indexRet.$cabin}}").find(".logoFlight-from").attr('src');
            var transit =$(".ret{{$result['ac'].$indexRet.$cabin}}").find(".transit").text();
            var acRet=$(".ret{{$result['ac'].$indexRet.$cabin}}").find(".acRet").text();
            var resultRet=$(".ret{{$result['ac'].$indexRet.$cabin}}").find(".resultRet").text();
            var selectedIDret=$(".ret{{$result['ac'].$indexRet.$cabin}}").find(".selectedIDret").text();
            var stringTotalFareRet=$(".ret{{$result['ac'].$indexRet.$cabin}}").find(".totalFare").text();
            var totalFareRet=parseFloat(stringTotalFareRet.replace(/,/g,''));
            var totalFareDep=parseFloat($("#totalFareDep").val());
            var totalFare=totalFareDep+totalFareRet;
            $("#totalFareRet").val(totalFareRet);
            $("#acRet").val(acRet);
            $("#selectedIDret").val(selectedIDret);
            $("#resultRet").val(resultRet);
            $( ".result-pulang .timeFrom-top" ).html( timeFrom );
            $( ".result-pulang .timeFin-top" ).html( timeFin );
            $( ".result-pulang .cityFrom-top" ).html( cityFrom );
            $( ".result-pulang .cityFin-top" ).html( cityFin );
            $( ".result-pulang .FlightDate" ).html( FlightDate );
            $( ".result-pulang .codeFrom-top" ).html( codeFrom );
            $( ".result-pulang .cityFin").html(cityFin);
            $( ".result-pulang .logoFlightFrom-top").attr("src", logoFlight);
            $( ".result-pulang .show-notice").html( transit );
            $( ".price-summary .totalFare").html(addCommas(totalFare));
        }
        setDefaultValueRet();
    }
    @else
    @if($indexRet==0)
    function setDefaultValueRetBus(){
            var timeFrom = $(".ret{{$result['ac'].$indexRet.$cabin}}").find( ".timeFrom" ).text();
            var timeFin = $(".ret{{$result['ac'].$indexRet.$cabin}}").find( ".timeFin" ).text();
            var FlightDate = $(".ret{{$result['ac'].$indexRet.$cabin}}").find(".FlightDateRet0").text();
            var codeFrom = $(".ret{{$result['ac'].$indexRet.$cabin}}").find( ".codeFrom" ).text();
            var cityFrom = $(".ret{{$result['ac'].$indexRet.$cabin}}").find(".cityFrom").text();
            var cityFin=$(".ret{{$result['ac'].$indexRet.$cabin}}").find(".cityFin").text();
            var logoFlight = $(".ret{{$result['ac'].$indexRet.$cabin}}").find(".logoFlight-from").attr('src');
            var transit =$(".ret{{$result['ac'].$indexRet.$cabin}}").find(".transit").text();
            var acRet=$(".ret{{$result['ac'].$indexRet.$cabin}}").find(".acRet").text();
            var resultRet=$(".ret{{$result['ac'].$indexRet.$cabin}}").find(".resultRet").text();
            var selectedIDret=$(".ret{{$result['ac'].$indexRet.$cabin}}").find(".selectedIDret").text();
            var stringTotalFareRet=$(".ret{{$result['ac'].$indexRet.$cabin}}").find(".totalFare").text();
            var totalFareRet=parseFloat(stringTotalFareRet.replace(/,/g,''));
            var totalFareDep=parseFloat($("#totalFareDep").val());
            var totalFare=totalFareDep+totalFareRet;
            $("#totalFareRet").val(totalFareRet);
            $("#acRet").val(acRet);
            $("#selectedIDret").val(selectedIDret);
            $("#resultRet").val(resultRet);
            $( ".result-pulang .timeFrom-top" ).html( timeFrom );
            $( ".result-pulang .timeFin-top" ).html( timeFin );
            $( ".result-pulang .cityFrom-top" ).html( cityFrom );
            $( ".result-pulang .cityFin-top" ).html( cityFin );
            $( ".result-pulang .FlightDate" ).html( FlightDate );
            $( ".result-pulang .codeFrom-top" ).html( codeFrom );
            $( ".result-pulang .cityFin").html(cityFin);
            $( ".result-pulang .logoFlightFrom-top").attr("src", logoFlight);
            $( ".result-pulang .show-notice").html( transit );
            $( ".price-summary .totalFare").html(addCommas(totalFare));
        }
    @endif
    @endif
    $(".ret{{$result['ac'].$indexRet.$cabin}}").click(function (e) {
        if (!$(this).is('.actived')) {
            $(".row-rincian-pulang").removeClass('actived');
            $(".row-rincian-pulang").removeClass('selected');
            $(".row-rincian-pulang").find('.items-detail:visible').slideUp("slow");
            $(this).addClass('actived');
            $(this).addClass('selected');
            $(this).find('.items-detail ').slideDown("slow");
            $(this).find('.items-detail ').addClass("actived");
            var timeFrom = $(this).find( ".timeFrom" ).text();
            var timeFin = $(this).find( ".timeFin" ).text();
            var FlightDate = $(this).find(".FlightDateRet0").text();
            var codeFrom = $(this).find( ".codeFrom" ).text();
            var cityFrom=$(this).find(".cityFrom").text();
            var cityFin=$(this).find(".cityFin").text();
            var logoFlight = $(this).find(".logoFlight-from").attr('src');
            var transit =$(this).find(".transit").text();
            var acRet=$(this).find(".acRet").text();
            var resultRet=$(this).find(".resultRet").text();
            var selectedIDret=$(this).find(".selectedIDret").text();
            var stringTotalFareRet=$(this).find(".totalFare").text();
            var totalFareRet=parseFloat(stringTotalFareRet.replace(/,/g,''));
            var totalFareDep=parseFloat($("#totalFareDep").val());
            var totalFare=totalFareDep+totalFareRet;
            $("#totalFareRet").val(totalFareRet);
            $("#acRet").val(acRet);
            $("#selectedIDret").val(selectedIDret);
            $("#resultRet").val(resultRet);
            $( ".result-pulang .timeFrom-top" ).html( timeFrom );
            $( ".result-pulang .timeFin-top" ).html( timeFin );
            $( ".result-pulang .FlightDate" ).html( FlightDate );
            $( ".result-pulang .codeFrom-top" ).html( codeFrom );
            $( ".result-pulang .cityFrom-top" ).html( cityFrom );
            $( ".result-pulang .cityFin-top" ).html( cityFin );
            $( ".result-pulang .logoFlightFrom-top").attr("src", logoFlight);
            $( ".result-pulang .show-notice").html( transit );
            $( ".price-summary .totalFare").html(addCommas(totalFare));
        } else {
            $(this).removeClass('actived');
            $(this).find('.items-detail').slideUp("slow");
        }
    });
</script>
