<?php
$countFlight=count($airlines['Flights']);
$flightNumberDep=getFlightNumber($airlines['Flights']);
$etdDep=$airlines['Flights'][0]['ETD'];
$etaDep=$airlines['Flights'][0]['ETA'];
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

<div class="row-rincian row-rincian-berangkat dep{{$result['ac'].$indexDep.$cabin}} dep"  data-price="{{$totalFare}}" data-time="{{strtotime($airlines['Flights'][0]['ETD'])}}">
    <span class="resultDep" style="display: none;">{{json_encode($result)}}</span>
    <span class="cabinDep" style="display: none;">{{$cabin}}</span>
    <span class="acDep" style="display:none;">{{$result['ac']}}</span>
    <span class="selectedIDdep" style="display: none;">{{$indexDep}}</span>

    <div class="items">
        <div class="label-circle inline-bl">
            <div class="circle-select"><i class="glyphicon glyphicon-ok"></i></div>
        </div>
        <div class="label-rincian inline-bl">
            <div class="row-rin">
                <img class="logoFlight-from" style="height: 30px; width: 50px;" src="{{asset('/assets/logo/'.getAirlineDetail($result['ac'])['icon'])}}" alt="logo-{{getAirlineDetail($result['ac'])['name']}}">
                <span class="code-penerbangan codeFrom">{{$flightNumberDep}}</span>
            </div>
            <div class="row-rin">
                <div class="timeblock">
                    <h4 class="timeFrom">{{date('H:i',strtotime($airlines['Flights'][0]['ETD']))}}</h4>
                    <p class="cityFrom text-center" >{{$origin->city}} ({{$origin->id}})</p>
                </div>
                <div class="timeblock">
                    @if($countFlight>1)
                        <h4 class="timeFin">{{date('H:i',strtotime($airlines['Flights'][$countFlight-1]['ETA']))}}</h4>
                    @else
                        <h4 class="timeFin">{{date('H:i',strtotime($airlines['Flights'][0]['ETA']))}}</h4>
                    @endif
                    <p class="cityFin text-center">{{$destination->city}} ({{$destination->id}})</p>
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
            {{--<a class="btn btn-primary" href="{{route('airlines.all_schedule_class')}}" onclick="event.preventDefault();document.getElementById('{{$airlines['Fares'][0][0]['selectedIDdep']}}').submit();">PESAN SEKARANG</a>--}}
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
                                    <div class="FlightTimeHour">{{date("h:i",strtotime($value['ETD']))}} LT</div>
                                    <div class="FlightDateDep{{ $key }}">{{myDay($value['ETD'])}}, {{date('d',strtotime($value['ETD']))}} {{myMonth($value['ETD'])}}</div>
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
                                    <div class="FlightTimeHour">{{date("h:i",strtotime($value['ETA']))}} LT</div>
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
    if(!defaultValueDep){
    function setDefaultValueDep(){
            defaultValueDep=true;
            var timeFrom = $(".dep{{$result['ac'].$indexDep.$cabin}}").find( ".timeFrom" ).text();
            var timeFin = $(".dep{{$result['ac'].$indexDep.$cabin}}").find( ".timeFin" ).text();
            var FlightDate = $(".dep{{$result['ac'].$indexDep.$cabin}}").find(".FlightDateDep0").text();
            var codeFrom = $(".dep{{$result['ac'].$indexDep.$cabin}}").find( ".codeFrom" ).text();
            var cityFrom = $(".dep{{$result['ac'].$indexDep.$cabin}}").find(".cityFrom").text();
            var cityFin=$(".dep{{$result['ac'].$indexDep.$cabin}}").find(".cityFin").text();
            var logoFlight = $(".dep{{$result['ac'].$indexDep.$cabin}}").find(".logoFlight-from").attr('src');
            var transit =$(".dep{{$result['ac'].$indexDep.$cabin}}").find(".transit").text();
            var resultDep=$(".dep{{$result['ac'].$indexDep.$cabin}}").find(".resultDep").text();
            var cabin=$(".dep{{$result['ac'].$indexDep.$cabin}}").find(".cabinDep").text();
            var acDep=$(".dep{{$result['ac'].$indexDep.$cabin}}").find(".acDep").text();
            var selectedIDdep=$(".dep{{$result['ac'].$indexDep.$cabin}}").find(".selectedIDdep").text();
            var stringTotalFareDep=$(".dep{{$result['ac'].$indexDep.$cabin}}").find(".totalFare").text();
            var totalFareDep=parseFloat(stringTotalFareDep.replace(/,/g,''));
            var totalFareRet=parseFloat($("#totalFareRet").val());
            var totalFare=totalFareDep+totalFareRet;
            $("#totalFareDep").val(totalFareDep);
            $("#acDep").val(acDep);
            $("#selectedIDdep").val(selectedIDdep);
            $("#resultDep").val(resultDep);
            $("#cabin").val(cabin);
            $( ".result-berangkat .timeFrom-top" ).html( timeFrom );
            $( ".result-berangkat .cityFrom-top" ).html( cityFrom );
            $( ".result-berangkat .cityFin-top" ).html( cityFin );
            $( ".result-berangkat .timeFin-top" ).html( timeFin );
            $( ".result-berangkat .FlightDate" ).html( FlightDate );
            $( ".result-berangkat .codeFrom-top" ).html( codeFrom );
            $( ".result-berangkat .logoFlightFrom-top").attr("src", logoFlight);
            $( ".result-berangkat .show-notice").html( transit );
            $( ".price-summary .totalFare").html(addCommas(totalFare));
            $("#chooseFlight").show();
        }
        setDefaultValueDep();
    }
    @else
    @if($indexDep==0)
    function setDefaultValueDepBus(){
            var timeFrom = $(".dep{{$result['ac'].$indexDep.$cabin}}").find( ".timeFrom" ).text();
            var timeFin = $(".dep{{$result['ac'].$indexDep.$cabin}}").find( ".timeFin" ).text();
            var FlightDate = $(".dep{{$result['ac'].$indexDep.$cabin}}").find(".FlightDateDep0").text();
            var codeFrom = $(".dep{{$result['ac'].$indexDep.$cabin}}").find( ".codeFrom" ).text();
            var cityFrom = $(".dep{{$result['ac'].$indexDep.$cabin}}").find(".cityFrom").text();
            var cityFin=$(".dep{{$result['ac'].$indexDep.$cabin}}").find(".cityFin").text();
            var logoFlight = $(".dep{{$result['ac'].$indexDep.$cabin}}").find(".logoFlight-from").attr('src');
            var transit =$(".dep{{$result['ac'].$indexDep.$cabin}}").find(".transit").text();
            var resultDep=$(".dep{{$result['ac'].$indexDep.$cabin}}").find(".resultDep").text();
            var cabin=$(".dep{{$result['ac'].$indexDep.$cabin}}").find(".cabinDep").text();
            var acDep=$(".dep{{$result['ac'].$indexDep.$cabin}}").find(".acDep").text();
            var selectedIDdep=$(".dep{{$result['ac'].$indexDep.$cabin}}").find(".selectedIDdep").text();
            var stringTotalFareDep=$(".dep{{$result['ac'].$indexDep.$cabin}}").find(".totalFare").text();
            var totalFareDep=parseFloat(stringTotalFareDep.replace(/,/g,''));
            var totalFareRet=parseFloat($("#totalFareRet").val());
            var totalFare=totalFareDep+totalFareRet;
            $("#totalFareDep").val(totalFareDep);
            $("#acDep").val(acDep);
            $("#selectedIDdep").val(selectedIDdep);
            $("#resultDep").val(resultDep);
            $("#cabin").val(cabin);
            $( ".result-berangkat .timeFrom-top" ).html( timeFrom );
            $( ".result-berangkat .cityFrom-top" ).html( cityFrom );
            $( ".result-berangkat .cityFin-top" ).html( cityFin );
            $( ".result-berangkat .timeFin-top" ).html( timeFin );
            $( ".result-berangkat .FlightDate" ).html( FlightDate );
            $( ".result-berangkat .codeFrom-top" ).html( codeFrom );
            $( ".result-berangkat .logoFlightFrom-top").attr("src", logoFlight);
            $( ".result-berangkat .show-notice").html( transit );
            $( ".price-summary .totalFare").html(addCommas(totalFare));
            $("#chooseFlight").show();
        }
    @endif
    @endif
    $(".dep{{$result['ac'].$indexDep.$cabin}}").click(function (e) {
        if (!$(this).is('.actived')) {
            $(".row-rincian-berangkat").removeClass('actived');
            $(".row-rincian-berangkat").removeClass('selected');
            $(".row-rincian-berangkat").find('.items-detail:visible').slideUp("slow");
            $(this).addClass('actived');
            $(this).addClass('selected');
            $(this).find('.items-detail ').slideDown("slow");
            $(this).find('.items-detail ').addClass("actived");
            var timeFrom = $(this).find( ".timeFrom" ).text();
            var timeFin = $(this).find( ".timeFin" ).text();
            var FlightDate = $(this).find(".FlightDateDep0").text();
            var codeFrom = $(this).find( ".codeFrom" ).text();
            var cityFrom=$(this).find(".cityFrom").text();
            var cityFin=$(this).find(".cityFin").text();
            var logoFlight = $(this).find(".logoFlight-from").attr('src');
            var transit =$(this).find(".transit").text();
            var resultDep=$(this).find(".resultDep").text();
            var cabin=$(".dep{{$result['ac'].$indexDep.$cabin}}").find(".cabinDep").text();
            var acDep=$(this).find(".acDep").text();
            var selectedIDdep=$(this).find(".selectedIDdep").text();
            var stringTotalFareDep=$(this).find(".totalFare").text();
            var totalFareDep=parseFloat(stringTotalFareDep.replace(/,/g,''));
            var totalFareRet=parseFloat($("#totalFareRet").val());
            var totalFare=totalFareDep+totalFareRet;
            $("#totalFareDep").val(totalFareDep);
            $("#acDep").val(acDep);
            $("#selectedIDdep").val(selectedIDdep);
            $("#resultDep").val(resultDep);
            $("#cabin").val(cabin);
            $( ".result-berangkat .timeFrom-top" ).html( timeFrom );
            $( ".result-berangkat .timeFin-top" ).html( timeFin );
            $( ".result-berangkat .FlightDate" ).html( FlightDate );
            $( ".result-berangkat .codeFrom-top" ).html( codeFrom );
            $( ".result-berangkat .cityFrom-top" ).html( cityFrom );
            $( ".result-berangkat .cityFin-top" ).html( cityFin );
            $( ".result-berangkat .logoFlightFrom-top").attr("src", logoFlight);
            $( ".result-berangkat .show-notice").html( transit );
            $( ".price-summary .totalFare").html(addCommas(totalFare));
        } else {
            $(this).removeClass('actived');
            $(this).find('.items-detail').slideUp("slow");
        }
    });

</script>
