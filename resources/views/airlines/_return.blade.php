<?php
$countFlight=count($airlines['Flights']);
$flightNumberRet=getFlightNumber($airlines['Flights']);
$etdRet=$airlines['Flights'][0]['ETD'];
$etaRet=$airlines['Flights'][0]['ETA'];
?>
@if($countFlight>1)
    <?php
    $totalFare=0;
    $totalNTA=0;
    ?>
    @foreach($airlines['Fares'] as $fare )
        <?php
        $totalFare=$totalFare+$fare[0]['TotalFare'];
        $totalNTA=$totalNTA+$fare[0]['NTA'];
        ?>
    @endforeach
@else
    <?php
    $totalFare=0;
    $totalNTA=0;
    $totalFare=$airlines['Fares'][0][0]['TotalFare'];
    $totalNTA=$airlines['Fares'][0][0]['NTA'];
    ?>
@endif
<div class="row-rincian row-rincian-pulang ret{{$result['ac'].$indexRet}} ret" data-price="{{$totalFare}}" data-time="{{strtotime($airlines['Flights'][0]['ETD'])}}">
    <span class="resultRet" style="display: none;">{{json_encode($result)}}</span>
    <span class="acRet" style="display:none;">{{$result['ac']}}</span>
    @if($result['ac']=='GA')
        <span class="selectedIDret" style="display: none;">{{getSelectedIdRet($airlines['Fares'])}}</span>
    @else
        <span class="selectedIDret" style="display: none;">{{$indexRet}}</span>
    @endif
    <div class="items">
        <div class="label-circle inline-bl">
            <div class="circle-select"><i class="glyphicon glyphicon-ok"></i></div>
        </div>
        <div class="label-rincian inline-bl">
            <div class="row-rin">
                <img class="logoFlight-from" width="80" src="{{asset('/assets/logo/'.getLogo($airlines['Flights'][0]['FlightNo']).'.png')}}" alt="logo-{{$airline[$result['ac']]['name']}}">
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
                    if ($countFlight>1) {
                        $etd=\Carbon\Carbon::createFromFormat('Y-m-d H:i', $airlines['Flights'][0]['ETD']);
                        $eta=\Carbon\Carbon::createFromFormat('Y-m-d H:i', $airlines['Flights'][$countFlight-1]['ETA']);
                    } else {
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
                    @if($countFlight-1 == 0)
                      @if($airlines['Flights'][0]['Transit'] == '0')
                        <p class="transit">Langsung</p>
                      @else
                        <p class="transit">{{$airlines['Flights'][0]['Transit']}} Stop</p>
                      @endif
                    @else
                      <p class="transit">{{$countFlight-1}} Transit</p>
                    @endif
                </div>
            </div>
            <div class="row-rin">
                <a href="javascript:void(0)" class="menutab">Detail Penerbangan</a>
            </div>
        </div>
        <div class="label-detail-harga inline-bl">
        @if($totalNTA>0)
            <?php
            $totalNRA = $totalFare-$totalNTA;
            $komisi90=(int)($totalNRA*$percentCommission)/100;
            $komisiMember=(int)($komisi90*$percentSmartCash)/100;
            $estimatePrice = $totalFare-$komisiMember;
            ?>
            <h5 style="text-decoration: line-through;color: red;">IDR {{ number_format($totalFare) }}</h5>
            <h3 class="harga-real">IDR <span class="totalFare"> {{number_format($estimatePrice)}}</span> </h3>
        @else
            <h3 class="harga-real">IDR <span class="totalFare"> {{number_format($totalFare)}}</span> </h3>
        @endif
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
                            <?php
                            $etd=\Carbon\Carbon::createFromFormat('Y-m-d H:i', $value['ETD']);
                            $eta=\Carbon\Carbon::createFromFormat('Y-m-d H:i', $value['ETA']);
                            $h=$etd->diffInHours($eta, false);
                            $m=$etd->addHours($h)->diffInMinutes($eta, false);
                            $hShow= $h!="0"?$h.'j':'';
                            $mShow= $m!="0"?$m.'m':'';
                            $showTime=$hShow.' '.$mShow;
                            ?>
                            <div class="FlightSegment HiddenTransitSegment">
                                <div class="FlightDurationTime"><span class="icon"></span><p class="Duration"> {{$showTime}} <br />{{$value['Transit']}} Stop</p></div>
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
    function setDefaultValueRet(){
        if(!defaultValueRet){
            defaultValueRet=true;
            var timeFrom = $(".ret{{$result['ac'].$indexRet}}").find( ".timeFrom" ).text();
            var timeFin = $(".ret{{$result['ac'].$indexRet}}").find( ".timeFin" ).text();
            var FlightDate = $(".ret{{$result['ac'].$indexRet}}").find(".FlightDateRet0").text();
            var codeFrom = $(".ret{{$result['ac'].$indexRet}}").find( ".codeFrom" ).text();
            var cityFrom = $(".ret{{$result['ac'].$indexRet}}").find(".cityFrom").text();
            var cityFin=$(".ret{{$result['ac'].$indexRet}}").find(".cityFin").text();
            var logoFlight = $(".ret{{$result['ac'].$indexRet}}").find(".logoFlight-from").attr('src');
            var transit =$(".ret{{$result['ac'].$indexRet}}").find(".transit").text();
            var acRet=$(".ret{{$result['ac'].$indexRet}}").find(".acRet").text();
            var resultRet=$(".ret{{$result['ac'].$indexRet}}").find(".resultRet").text();
            var selectedIDret=$(".ret{{$result['ac'].$indexRet}}").find(".selectedIDret").text();
            var stringTotalFareRet=$(".ret{{$result['ac'].$indexRet}}").find(".totalFare").text();
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
    }
    setDefaultValueRet();
    $(".ret{{$result['ac'].$indexRet}}").click(function (e) {
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
<?php
        /*
<div class="flight-list-v2 ret" data-price="{{$totalFare}}" data-time="{{strtotime($airlines['Flights'][0]['ETD'])}}">
    <div class="flight-list-main">
        <div class="col-md-2 col-sm-2 text-center airline">
            <img id="img{{$airlines['Flights'][0]['FlightNo']}}" src="{{asset('/assets/logo/'.getLogo($flightNumberRet).'.png')}}" alt="logo-{{$airline[$result['ac']]['name']}}" class="img-responsive" style="display: block;margin-left: auto;margin-right: auto">
            <h6>{{$flightNumberRet}}</h6>
        </div>
        <div class="col-md-3 col-sm-3 departure">
            <h3><i class="fa fa-plane"></i> {{$airlines['Flights'][0]['STD']}} {{date('H:i',strtotime($airlines['Flights'][0]['ETD']))}}</h3>
            <h5 class="bold">{{substr(myDay($airlines['Flights'][0]['ETD']),0,3)}}, {{date('d',strtotime($airlines['Flights'][0]['ETD']))}} {{substr(myMonth($airlines['Flights'][0]['ETD']),0,3)}}</h5>
            <h5>{{$destination->city}} - {{$destination->name}}</h5>
        </div>
        <div class="col-md-4 col-sm-4 stop-duration">
            <div class="flight-direction">
            </div>
            <div class="stop">
            </div>
            <div class="stop-box">
                <?php $stop=$countFlight-1==0?'Langsung':$countFlight-1 .' Transit';?>
                <span style="font-size: 10px;">{{$stop}}</span>
            </div>
            <div class="duration text-center">
                <input type="hidden" id="result{{$airlines['Flights'][0]['FlightNo']}}" value="{{json_encode($result)}}">
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
                $hShow= $h!="0"?$h.'j':'';
                $mShow= $m!="0"?$m.'m':'';
                $showTime=$hShow.' '.$mShow;

                ?>
                <span><i class="fa fa-clock-o"></i> {{$showTime}}</span>
            </div>
        </div>
        <div class="col-md-3 col-sm-3 destination">
            @if($countFlight>1)
                <h3><i class="fa fa-plane fa-rotate-90"></i> {{$airlines['Flights'][$countFlight-1]['STA']}} {{date('H:i',strtotime($airlines['Flights'][$countFlight-1]['ETA']))}}</h3>
                <h5 class="bold">{{substr(myDay($airlines['Flights'][0]['ETD']),0,3)}}, {{date('d',strtotime($airlines['Flights'][0]['ETD']))}} {{substr(myMonth($airlines['Flights'][0]['ETD']),0,3)}}</h5>
            @else
                <h3><i class="fa fa-plane fa-rotate-90"></i> {{$airlines['Flights'][0]['STA']}} {{date('H:i',strtotime($airlines['Flights'][0]['ETA']))}}</h3>
                <h5 class="bold">{{substr(myDay($airlines['Flights'][0]['ETD']),0,3)}}, {{date('d',strtotime($airlines['Flights'][0]['ETD']))}} {{substr(myMonth($airlines['Flights'][0]['ETD']),0,3)}}</h5>
            @endif
            <h5>{{$origin->city}} - {{$origin->name}}</h5>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="flight-list-footer">
        <div class="col-md-4 col-sm-6 col-xs-12 clear-padding">
        </div>
        <div class="col-md-8 col-sm-6 col-xs-12 clear-padding">
            <div class="pull-right">
                <span style="font-size:1.2em;"><strong>IDR {{number_format($totalFare)}}</strong></span>
                @if($result['ac']=='GA')
                    <a href="javascript:void(0) " onclick="getReturn(document.getElementById('img{{$airlines['Flights'][0]['FlightNo']}}').src,document.getElementById('result{{$airlines['Flights'][0]['FlightNo']}}').value,'{{getSelectedIdRet($airlines['Fares'])}}','{{$flightNumberRet}}','{{getAC($airlines['Flights'][0]['FlightNo'])}}','{{$etdRet}}','{{$etaRet}}','{{$totalFare}}','{{$showTime}}','{{$stop}}','{{$destination->city.' - '.$destination->name}}','{{$origin->city.' - '.$origin->name}}')">PILIH PULANG</a>
                @else
                    <a href="javascript:void(0) " onclick="getReturn(document.getElementById('img{{$airlines['Flights'][0]['FlightNo']}}').src,document.getElementById('result{{$airlines['Flights'][0]['FlightNo']}}').value,'{{$indexRet}}','{{$flightNumberRet}}','{{getAC($airlines['Flights'][0]['FlightNo'])}}','{{$etdRet}}','{{$etaRet}}','{{$totalFare}}','{{$showTime}}','{{$stop}}','{{$destination->city.' - '.$destination->name}}','{{$origin->city.' - '.$origin->name}}')">PILIH PULANG</a>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
        */ ?>
