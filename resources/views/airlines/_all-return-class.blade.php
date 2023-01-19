@if($result['ac']=="GA")
    <?php $airlinesRet=$result['schedule']['departure'][$indexRet]['Flights']; ?>
    <?php $faresRet=$result['schedule']['departure'][$indexRet]['Fares']; ?>
@else
    <?php $airlinesRet=$result['schedule']['return'][$indexRet]['Flights']; ?>
    <?php $faresRet=$result['schedule']['return'][$indexRet]['Fares']; ?>
@endif
<section id="chooseClass" class="main-table">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="seat-table">
                    <div class="title-flight">
                        <p>Penerbangan Pulang:</p>
                        <?php
                        $org=getAirport($result['des']);
                        $des=getAirport($result['org']);
                        ?>
                        <p><strong>{{$org->city}}, {{$org->name}} ({{$org->id}}) - {{$des->city}}, {{$des->name}} ({{$des->id}}) / {{$result['adt']}} Dewasa {{$result['chd']!='0'?', '.$result['chd'].' Anak ':''}} {{$result['inf']!='0'?', '.$result['inf'].' Bayi ':''}}</strong>.</p>
                    </div>
                    @if(count($faresRet)==1)
                        @foreach($airlinesRet as $key => $airlineList)
                            <div class="row nopadding">
                                <div class="blue-list">
                                    <div class="col-md-4 inline-blue nopadding">
                                        <img class="maskapai img-responsive" src="{{asset('/assets/logo/'.getLogo($airlineList['FlightNo']).'.png')}}" style="height: auto;width: 125px;">
                                        <span class="code-penerbangan"><strong>{{$airlineList['FlightNo']}} ({{$airlineList['STD']}} - {{$airlineList['STA']}})</strong></span>
                                    </div>
                                    <div class="col-md-2 inline-blue nopadding">
                                        <p><i class="fa fa-plane" aria-hidden="true"></i> <strong>Berangkat</strong><br>{{date('D',strtotime($airlineList['ETD']))}}, {{date('d M',strtotime($airlineList['ETD']))}} {{date('H:i',strtotime($airlineList['ETD']))}}<br></p>
                                    </div>
                                    <div class="col-md-2 inline-blue nopadding">
                                        <p><i class="fa fa-plane fa-rotate-90" aria-hidden="true"></i> <strong>Tiba</strong><br>{{date('D',strtotime($airlineList['ETA']))}}, {{date('d M',strtotime($airlineList['ETA']))}} {{date('H:i',strtotime($airlineList['ETA']))}}<br></p>
                                    </div>
                                    <?php
                                    $etd=\Carbon\Carbon::createFromFormat('Y-m-d H:i', $airlineList['ETD']);
                                    $eta=\Carbon\Carbon::createFromFormat('Y-m-d H:i', $airlineList['ETA']);
                                    $h=$etd->diffInHours($eta, false);
                                    $m=$etd->addHours($h)->diffInMinutes($eta, false);
                                    $hShow= $h!="0"?$h.' jam':'';
                                    $mShow= $m!="0"?$m.' mnt':'';
                                    $showTime=$hShow.' '.$mShow;
                                    ?>
                                    <div class="col-md-2 inline-blue nopadding">
                                        <p><i class="fa fa-clock-o" aria-hidden="true"></i><strong> Durasi</strong><br>{{$showTime}}<br></p>
                                    </div>
                                    <div class="col-md-2 inline-blue nopadding">
                                        <p><i class="fa fa-clock-o" aria-hidden="true"></i><strong> Stop</strong><br>{{$airlineList['Transit']}} Stop<br></p>
                                    </div>
                                </div>
                            </div><!--end.row-->
                            <table class="blue-table" style="display: none;">
                                <tr>
                                    <td>
                                        <img class="maskapai img-responsive" src="{{asset('/assets/logo/'.getLogo($airlineList['FlightNo']).'.png')}}" style="height: auto;width: 125px;">
                                        <span class="code-penerbangan"><strong>{{$airlineList['FlightNo']}} ({{$airlineList['STD']}} - {{$airlineList['STA']}})</strong></span>
                                    </td>
                                    <td>
                                        <p><i class="fa fa-plane" aria-hidden="true"></i> <strong>Berangkat</strong><br>{{date('D',strtotime($airlineList['ETD']))}}, {{date('d M',strtotime($airlineList['ETD']))}} {{date('H:i',strtotime($airlineList['ETD']))}}<br></p>
                                    </td>
                                    <td>
                                        <p><i class="fa fa-plane fa-rotate-90" aria-hidden="true"></i> <strong>Tiba</strong><br>{{date('D',strtotime($airlineList['ETA']))}}, {{date('d M',strtotime($airlineList['ETA']))}} {{date('H:i',strtotime($airlineList['ETA']))}}<br></p>
                                    </td>
                                    <td>
                                        <p><i class="fa fa-clock-o" aria-hidden="true"></i><strong>Durasi</strong><br>{{$showTime}}<br></p>
                                    </td>
                                </tr>
                            </table>
                            @if(count($airlinesRet)-1==$key)
                                <div class="list-seat">
                                    <?php
                                    $classes=array();
                                    $fclass=array();
                                    $bclass=array();
                                    $eclass=array();
                                    $pclass=array();
                                    ?>
                                    @foreach($faresRet[0] as $fareX)
                                        <?php

                                        $subclass=getAirlinesClass($airlineList['FlightNo'], substr($fareX['SubClass'], 0, 1));
                                        switch ($subclass) {
                                            case 'Promo':
                                                array_push($pclass, $fareX);
                                                break;
                                            case 'Economy':
                                                array_push($eclass, $fareX);
                                                break;
                                            case 'Business':
                                                array_push($bclass, $fareX);
                                                break;
                                            case 'First':
                                                array_push($fclass, $fareX);
                                                break;
                                            default:
                                                array_push($eclass, $fareX);
                                                break;
                                        }
                                        ?>
                                    @endforeach
                                    <?php
                                    if (array_key_exists(0, $pclass)) {
                                        array_push($classes, $pclass[0]);
                                    }
                                    if (array_key_exists(0, $eclass)) {
                                        array_push($classes, $eclass[0]);
                                    }
                                    if (array_key_exists(0, $bclass)) {
                                        array_push($classes, $bclass[0]);
                                    }
                                    if (array_key_exists(0, $fclass)) {
                                        array_push($classes, $fclass[0]);
                                    }
                                    ?>
                                    @foreach($classes as $index=>$fare)
                                        <div class="item-seat">
                                            <div class="left">
                                                @if($result['ac']=="GA")
                                                    <input type="radio" name="selectedIDret{{$key}}" value="{{$fare['selectedIDdep']}}"{{$index==0?'checked':''}}>
                                                @else
                                                    <input type="radio" name="selectedIDret{{$key}}" value="{{$fare['selectedIDret']}}"{{$index==0?'checked':''}}>
                                                @endif
                                                    <span class="bangku-info">{{ getAirlinesClass($airlineList['FlightNo'],$fare['SubClass']) }} Class</span>
                                                {{--<span class="bangku-info">Subclass : {{$fare['SubClass']}} (<i>{{$fare['SeatAvb']}} bangku tersisa</i>)</span>--}}
                                            </div>
                                            <div class="right">
                                            @if((int)$fare['NTA']>0)
                                                <?php
                                                $totalNRA = $fare['TotalFare']-$fare['NTA'];
                                                $komisi90=(int)($totalNRA*$percentCommission)/100;
                                                $komisiMember=(int)($komisi90*$percentSmartCash)/100;
                                                $estimatePrice = (int)$fare['TotalFare']-$komisiMember;
                                                ?>
                                                <span class="price">IDR {{number_format($estimatePrice)}} <sup style="text-decoration: line-through;color: red;">IDR {{number_format($fare['TotalFare'])}}</sup></span>
                                            @else
                                                <span class="price">IDR {{number_format($fare['TotalFare'])}}</span>
                                            @endif
                                            </div>
                                        </div><!--end.item-seat-->
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                            <div class="rows text-right">
                                <div class="col-md-4 col-md-offset-8 col-xs-12">
                                    <a href="{{route('airlines.get_fare')}}"  onclick="event.preventDefault();document.getElementById('getFare').submit();airlines.mySubmit();" class="btn btn-cari">Selanjutnya</a>
                                </div>
                            </div>
                    @else
                        @foreach($airlinesRet as $key => $airlineList)
                            <div class="row nopadding">
                                <div class="blue-list">
                                    <div class="col-md-6 inline-blue nopadding">
                                        <img class="maskapai img-responsive" src="{{asset('/assets/logo/'.getLogo($airlineList['FlightNo']).'.png')}}" style="height: auto;width: 125px;">
                                        <span class="code-penerbangan"><strong>{{$airlineList['FlightNo']}} ({{$airlineList['STD']}} - {{$airlineList['STA']}})</strong></span>
                                    </div>
                                    <div class="col-md-2 inline-blue nopadding">
                                        <p><i class="fa fa-plane" aria-hidden="true"></i> <strong>Berangkat</strong><br>{{date('D',strtotime($airlineList['ETD']))}}, {{date('d M',strtotime($airlineList['ETD']))}} {{date('H:i',strtotime($airlineList['ETD']))}}<br></p>
                                    </div>
                                    <div class="col-md-2 inline-blue nopadding">
                                        <p><i class="fa fa-plane fa-rotate-90" aria-hidden="true"></i> <strong>Tiba</strong><br>{{date('D',strtotime($airlineList['ETA']))}}, {{date('d M',strtotime($airlineList['ETA']))}} {{date('H:i',strtotime($airlineList['ETA']))}}<br></p>
                                    </div>
                                    <?php
                                    $etd=\Carbon\Carbon::createFromFormat('Y-m-d H:i', $airlineList['ETD']);
                                    $eta=\Carbon\Carbon::createFromFormat('Y-m-d H:i', $airlineList['ETA']);
                                    $h=$etd->diffInHours($eta, false);
                                    $m=$etd->addHours($h)->diffInMinutes($eta, false);
                                    $hShow= $h!="0"?$h.' jam':'';
                                    $mShow= $m!="0"?$m.' mnt':'';
                                    $showTime=$hShow.' '.$mShow;
                                    ?>
                                    <div class="col-md-2 inline-blue nopadding">
                                        <p><i class="fa fa-clock-o" aria-hidden="true"></i><strong> Durasi</strong><br>{{$showTime}}<br>{{$airlineList['Transit']}} Stop</p>
                                    </div>
                                </div>
                            </div><!--end.row-->
                            <table class="blue-table" style="display: none;">
                                <tr>
                                    <td>
                                        <img class="maskapai img-responsive" src="{{asset('/assets/logo/'.getLogo($airlineList['FlightNo']).'.png')}}" style="height: auto;width: 125px;">
                                        <span class="code-penerbangan"><strong>{{$airlineList['FlightNo']}} ({{$airlineList['STD']}} - {{$airlineList['STA']}})</strong></span>
                                    </td>
                                    <td>
                                        <p><i class="fa fa-plane" aria-hidden="true"></i> <strong>Berangkat</strong><br>{{date('D',strtotime($airlineList['ETD']))}}, {{date('d M',strtotime($airlineList['ETD']))}} {{date('H:i',strtotime($airlineList['ETD']))}}<br></p>
                                    </td>
                                    <td>
                                        <p><i class="fa fa-plane" aria-hidden="true"></i> <strong>Tiba</strong><br>{{date('D',strtotime($airlineList['ETA']))}}, {{date('d M',strtotime($airlineList['ETA']))}} {{date('H:i',strtotime($airlineList['ETA']))}}<br></p>
                                    </td>
                                    <td>
                                        <p><i class="fa fa-clock-o" aria-hidden="true"></i><strong>Durasi</strong><br>{{$showTime}}<br></p>
                                    </td>
                                </tr>
                            </table>
                            <div class="list-seat">
                                <?php
                                $classes=array();
                                $fclass=array();
                                $bclass=array();
                                $eclass=array();
                                $pclass=array();
                                ?>
                                @foreach($faresRet[$key] as $fareX)
                                    <?php

                                    $subclass=getAirlinesClass($airlineList['FlightNo'], substr($fareX['SubClass'], 0, 1));
                                    switch ($subclass) {
                                        case 'Promo':
                                            array_push($pclass, $fareX);
                                            break;
                                        case 'Economy':
                                            array_push($eclass, $fareX);
                                            break;
                                        case 'Business':
                                            array_push($bclass, $fareX);
                                            break;
                                        case 'First':
                                            array_push($fclass, $fareX);
                                            break;
                                        default:
                                            array_push($eclass, $fareX);
                                            break;
                                    }
                                    ?>
                                @endforeach
                                <?php
                                if (array_key_exists(0, $pclass)) {
                                    array_push($classes, $pclass[0]);
                                }
                                if (array_key_exists(0, $eclass)) {
                                    array_push($classes, $eclass[0]);
                                }
                                if (array_key_exists(0, $bclass)) {
                                    array_push($classes, $bclass[0]);
                                }
                                if (array_key_exists(0, $fclass)) {
                                    array_push($classes, $fclass[0]);
                                }
                                ?>
                                @foreach($classes as $index=>$fare)
                                    <div class="item-seat">
                                        <div class="left">
                                            @if($result['ac']=="GA")
                                                <input type="radio" name="selectedIDret{{$key}}" value="{{$fare['selectedIDdep']}}"{{$index==0?'checked':''}}>
                                            @else
                                                <input type="radio" name="selectedIDret{{$key}}" value="{{$fare['selectedIDret']}}"{{$index==0?'checked':''}}>
                                            @endif
                                                <span class="bangku-info">{{ getAirlinesClass($airlineList['FlightNo'],$fare['SubClass']) }} Class</span>
                                            {{--<span class="bangku-info">Subclass : {{$fare['SubClass']}} (<i>{{$fare['SeatAvb']}} bangku tersisa</i>)</span>--}}
                                        </div>
                                        <div class="right">
                                            <span class="price">IDR {{number_format($fare['TotalFare'])}}</span>
                                        </div>
                                    </div><!--end.item-seat-->
                                @endforeach
                            </div>
                        @endforeach
                            <div class="rows text-right">
                                <div class="col-md-4 col-md-offset-8 col-xs-12">
                                    <a href="{{route('airlines.get_fare')}}" onclick="event.preventDefault();document.getElementById('getFare').submit();airlines.mySubmit();" class="btn btn-cari">Selanjutnya</a>
                                </div>
                            </div>
                    @endif
                </div><!--.seat-table-->
            </div><!--end.col-12-->
        </div><!--end.row-->
    </div><!--end.container-->
</section><!--end.maintable-->


<?php
/*
@if($result['ac']=="GA")
    <?php $airlinesRet=$result['schedule']['departure'][$indexRet]['Flights']; ?>
    <?php $faresRet=$result['schedule']['departure'][$indexRet]['Fares']; ?>
@else
    <?php $airlinesRet=$result['schedule']['return'][$indexRet]['Flights']; ?>
    <?php $faresRet=$result['schedule']['return'][$indexRet]['Fares']; ?>
@endif
@if(count($faresRet)==1)
    <div class="flight-list-v2">
        <div class="flight-list-footer">
            <div class="col-md-6 col-sm-6 col-xs-12 clear-padding">
                <span><strong><i class="fa fa-plane fa-rotate-270"></i> PULANG</strong></span>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 clear-padding">

            </div>
        </div>
        @foreach($airlinesRet as $key => $airlineList)
            <div class="flight-list-main">
                <div class="row">
                    <div class="col-md-2 col-sm-2 text-center airline">
                        <img src="{{asset('/assets/logo/'.getLogo($airlineList['FlightNo']).'.png')}}" alt="logo-{{$airline[$result['ac']]['name']}}" class="img-responsive" style="display: block;margin-left: auto;margin-right: auto; ">
                        <h6>{{$airline[$result['ac']]['name']}} - {{$airlineList['FlightNo']}}</h6>
                    </div>
                    <div class="col-md-3 col-sm-3 departure">
                        <h3><i class="fa fa-plane"></i> {{$airlineList['STD']}} {{date('H:i',strtotime($airlineList['ETD']))}}</h3>
                        <h5 class="bold">{{date('D',strtotime($airlineList['ETD']))}}, {{date('d M',strtotime($airlineList['ETD']))}}</h5>
                        <h5>{{$origin->city}} - {{$origin->name}}</h5>
                    </div>
                    <div class="col-md-4 col-sm-4 stop-duration">
                        <div class="flight-direction">
                        </div>
                        <div class="stop">
                        </div>
                        <div class="duration text-center">
                            <?php
                            $etd=\Carbon\Carbon::createFromFormat('Y-m-d H:i', $airlineList['ETD']);
                            $eta=\Carbon\Carbon::createFromFormat('Y-m-d H:i', $airlineList['ETA']);
                            $h=$etd->diffInHours($eta, false);
                            $m=$etd->addHours($h)->diffInMinutes($eta, false);

                            ?>
                            <span><i class="fa fa-clock-o"></i> {{$h}}h {{$m}}m</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 destination">
                        <h3><i class="fa fa-plane fa-rotate-90"></i> {{$airlineList['STA']}} {{date('H:i',strtotime($airlineList['ETA']))}}</h3>
                        <h5 class="bold">{{date('D',strtotime($airlineList['ETA']))}}, {{date('d M',strtotime($airlineList['ETA']))}}</h5>
                        <h5>{{$destination->city}} - {{$destination->name}}</h5>
                    </div>
                </div>
                <div class="row">
                    @if(count($airlinesRet)-1==$key)
                        @foreach($faresRet[0] as $index=>$fare)
                            <div class="col-md-2 col-sm-3">
                                <div class="thumbnail text-center">
                                    Subclass : {{$fare['SubClass']}} ({{$fare['SeatAvb']}})<br>
                                    @if($result['ac']=="GA")
                                        <input type="radio" name="selectedIDret{{$key}}" class="form-control" value="{{$fare['selectedIDdep']}}"{{$index==0?'checked':''}}><br>
                                    @else
                                        <input type="radio" name="selectedIDret{{$key}}" class="form-control" value="{{$fare['selectedIDret']}}"{{$index==0?'checked':''}}><br>
                                    @endif
                                    <strong>IDR {{number_format($fare['TotalFare'])}}</strong>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        @endforeach
        <div class="clearfix"></div>
        <div class="flight-list-footer">
            <div class="col-md-6 col-sm-6 col-xs-12 clear-padding">

            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 clear-padding">
                <div class="pull-right">

                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="flight-list-v2">
        <div class="flight-list-footer">
            <div class="col-md-6 col-sm-6 col-xs-12 clear-padding">

            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 clear-padding">
                <div class="pull-right">
                    <a href="{{route('airlines.get_fare')}}" onclick="event.preventDefault();document.getElementById('getFare').submit();">SELANJUTNYA</a>
                </div>
            </div>
        </div>
    </div>
    <hr>

@else
    @foreach($airlinesRet as $key => $airlineList)
        <div class="flight-list-v2">
            <div class="flight-list-footer">
                <div class="col-md-6 col-sm-6 col-xs-12 clear-padding">
                    <span><strong><i class="fa fa-plane fa-rotate-270"></i> PULANG</strong></span>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 clear-padding">

                </div>
            </div>
            <div class="flight-list-main">
                <div class="row">
                    <div class="col-md-2 col-sm-2 text-center airline">
                        <img src="{{asset('/assets/logo/'.getLogo($airlineList['FlightNo']).'.png')}}" alt="logo-{{$airline[$result['ac']]['name']}}" class="img-responsive" style="display: block;margin-left: auto;margin-right: auto">
                        <h6>{{$airline[$result['ac']]['name']}} - {{$airlineList['FlightNo']}}</h6>
                    </div>
                    <div class="col-md-3 col-sm-3 departure">
                        <h3><i class="fa fa-plane"></i> {{$airlineList['STD']}} {{date('H:i',strtotime($airlineList['ETD']))}}</h3>
                        <h5 class="bold">{{date('D',strtotime($airlineList['ETD']))}}, {{date('d M',strtotime($airlineList['ETD']))}}</h5>
                        <h5>{{$origin->city}} - {{$origin->name}}</h5>
                    </div>
                    <div class="col-md-4 col-sm-4 stop-duration">
                        <div class="flight-direction">
                        </div>
                        <div class="stop">
                        </div>
                        <div class="duration text-center">
                            <?php
                            $etd=\Carbon\Carbon::createFromFormat('Y-m-d H:i', $airlineList['ETD']);
                            $eta=\Carbon\Carbon::createFromFormat('Y-m-d H:i', $airlineList['ETA']);
                            $h=$etd->diffInHours($eta, false);
                            $m=$etd->addHours($h)->diffInMinutes($eta, false);

                            ?>
                            <span><i class="fa fa-clock-o"></i> {{$h}}h {{$m}}m</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 destination">
                        <h3><i class="fa fa-plane fa-rotate-90"></i> {{$airlineList['STA']}} {{date('H:i',strtotime($airlineList['ETA']))}}</h3>
                        <h5 class="bold">{{date('D',strtotime($airlineList['ETA']))}}, {{date('d M',strtotime($airlineList['ETA']))}}</h5>
                        <h5>{{$destination->city}} - {{$destination->name}}</h5>
                    </div>
                </div>
                <div class="row">
                    @foreach($faresRet[$key] as $index=>$fare)
                        <div class="col-md-2 col-sm-3">
                            <div class="thumbnail text-center">
                                Subclass : {{$fare['SubClass']}} ({{$fare['SeatAvb']}})<br>
                                @if($result['ac']=="GA")
                                    <input type="radio" name="selectedIDret{{$key}}" class="form-control" value="{{$fare['selectedIDdep']}}"{{$index==0?'checked':''}}><br>
                                @else
                                    <input type="radio" name="selectedIDret{{$key}}" class="form-control" value="{{$fare['selectedIDret']}}"{{$index==0?'checked':''}}><br>
                                @endif
                                <strong>IDR {{number_format($fare['TotalFare'])}}</strong>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="flight-list-footer">
                <div class="col-md-6 col-sm-6 col-xs-12 clear-padding">

                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 clear-padding">

                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    @endforeach
    <div class="flight-list-v2">
        <div class="flight-list-footer">
            <div class="col-md-6 col-sm-6 col-xs-12 clear-padding">

            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 clear-padding">
                <div class="pull-right">
                    <a href="{{route('airlines.get_fare')}}" onclick="event.preventDefault();document.getElementById('getFare').submit();">SELANJUTNYA</a>
                </div>
            </div>
        </div>
    </div>
    <hr>
@endif
*/ ?>
