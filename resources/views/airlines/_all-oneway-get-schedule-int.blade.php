<?php
$index=0;
$i=0;
?>
<div id="{{$result['cabin']}}">
@foreach($result['schedule']['departure'] as $key => $airlines)
    <?php $countFlight=count($airlines['Flights']);
    $flightNumberDep=getFlightNumber($airlines['Flights'])?>
        {!! Form::open(['route'=>'airlines.vue_2','method'=>'post','id'=>$airlines['Fares'][0]['selectedIDdep']]) !!}
        {!! Form::hidden('index',$index) !!}
        {!! Form::hidden('international',1) !!}
        {!! Form::hidden('acDep',getAC($result['schedule']['departure'][0]['Flights'][0]['FlightNo']),['id'=>'acDep']) !!}
        {!! Form::hidden('business','',['class'=>'business_class']) !!}
        {!! Form::hidden('result',json_encode($result)) !!}
        {!! Form::hidden('airline',json_encode($airline)) !!}
        {!! Form::close() !!}
        <?php
        $totalFare=0;
        $totalFare=$airlines['Fares'][0]['TotalFare'];
        $result['ac']=$airlines['ac'];
        ?>


    <!-- START -->
    <div class="row-rincian row-rincian-berangkat {{$result['ac'].$i.$result['cabin']}} dep"  data-price="{{$totalFare}}" data-time="{{strtotime($airlines['Flights'][0]['ETD'])}}">
        <div class="items">
            <div class="label-circle inline-bl">
                <div class="circle-select"><i class="glyphicon glyphicon-ok"></i></div>
            </div>
            <div class="label-rincian inline-bl">
                <div class="row-rin">
                    <img class="logoFlight-from" style="height: 30px;width: auto;" src="{{asset('/assets/logo/'.getAirlineDetail($result['ac'])['icon'])}}" alt="logo-{{getAirlineDetail($result['ac'])['name']}}">
                    <span class="code-penerbangan codeFrom">{{$flightNumberDep}}</span>
                </div>
                <div class="row-rin">
                    <div class="timeblock">
                        <h4 class="timeFrom">{{date('H:i',strtotime($airlines['Flights'][0]['ETD']))}} LT</h4>
                        <p class="cityFrom">{{$origin->city}} ({{$origin->id}})</p>
                    </div>
                    <div class="timeblock">
                        @if($countFlight>1)
                            <h4 class="timeFin">{{date('H:i',strtotime($airlines['Flights'][$countFlight-1]['ETA']))}} LT</h4>
                        @else
                            <h4 class="timeFin">{{date('H:i',strtotime($airlines['Flights'][0]['ETA']))}} LT</h4>
                        @endif
                        <p class="cityFin">{{$destination->city}} ({{$destination->id}})</p>
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
                        <p>{{$countFlight-1==0?'Langsung':$countFlight-1 .' Transit'}}</p>
                    </div>
                </div>
                <div class="row-rin">
                    <a href="javascript:void(0)" class="menutab">Detail Penerbangan</a>
                </div>
            </div>
            <div class="label-detail-harga inline-bl">
                <h3 class="harga-real">IDR {{number_format($totalFare)}} </h3>
            </div>
            <div class="action-rincian inline-bl">
                <a class="block-btn block-blue" href="{{route('airlines.all_schedule_class')}}" onclick="event.preventDefault();document.getElementById('{{$airlines['Fares'][0]['selectedIDdep']}}').submit();">PESAN SEKARANG</a>
            </div>
        </div>
        <div class="items-detail">
            @foreach($airlines['Flights'] as $key => $value)
                <div class="items-flight-destination">
                    <div class="row-detail">
                        <img class="logoFlight-from" style="height: 30px;width: auto;" src="{{asset('/assets/logo/'.getLogo($value['FlightNo']).'.png')}}"><br>
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
                                        <div class="FlightDate">{{myDay($value['ETD'])}}, {{date('d',strtotime($value['ETD']))}} {{myMonth($value['ETD'])}}</div>
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
    <!-- END -->

    <script>
        $(".{{$result['ac'].$i.$result['cabin']}}").click(function (e) {
            if (!$(this).is('.actived')) {
                $(".row-rincian-berangkat").removeClass('actived');
                $(".row-rincian-berangkat").removeClass('selected');
                $(".row-rincian-berangkat").find('.items-detail:visible').slideUp("slow");
                $(this).addClass('actived');
                $(this).addClass('selected');
                $(this).find('.items-detail ').slideDown("slow");
                $(this).find('.items-detail ').addClass("actived");
            } else {
                $(this).removeClass('actived');
                $(this).find('.items-detail').slideUp("slow");
            }
        });
    </script>
    <?php
    $index++;
    $i++;
    ?>

@endforeach
</div>
<script>
    $("#btnEco").prop('disabled', true);
    $("#economy").show();
    $("#business").hide();
</script>
