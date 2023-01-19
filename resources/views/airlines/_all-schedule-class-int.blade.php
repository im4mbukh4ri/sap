<?php $airlines=$result['schedule']['departure'][$index]['Flights']; ?>
<?php $fares=$result['schedule']['departure'][$index]['Fares']; ?>
<section id="chooseClass" class="main-table">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="seat-table">
                    <div class="title-flight">
                        <p>Penerbangan Pergi:</p>
                        <?php
                        $org=getAirport($result['org']);
                        $des=getAirport($result['des']);
                        ?>
                        <p><strong>{{$org->city}}, {{$org->name}} ({{$org->id}}) - {{$des->city}}, {{$des->name}} ({{$des->id}}) / {{$result['adt']}} Dewasa {{$result['chd']!='0'?', '.$result['chd'].' Anak ':''}} {{$result['inf']!='0'?', '.$result['inf'].' Bayi ':''}}</strong>.</p>
                    </div>
                    @if(count($fares)==1)
                        {!! Form::open(['route'=>'airlines.all_fares','method'=>'post','id'=>'getFare']) !!}
                        {!! Form::hidden('acDep',$result['schedule']['departure'][$index]['ac'],['id'=>'acDep']) !!}
                        {!! Form::hidden('international',1) !!}
                        {!! Form::hidden('result',json_encode($result)) !!}
                        {!! Form::hidden('airline',json_encode($airline)) !!}
                        {!! Form::hidden('cabin',$result['cabin']) !!}
                        {!! Form::hidden('index',$index) !!}

                        @foreach($airlines as $key => $airlineList)
                            <div class="row nopadding">
                                <div class="blue-list">
                                    <div class="col-md-6 inline-blue nopadding">
                                        <img class="maskapai" src="{{asset('/assets/logo/'.getLogo($airlineList['FlightNo']).'.png')}}" style="height: 30px;width: auto;">
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
                                </div>
                            </div><!--end.row-->
                            <table class="blue-table" style="display: none;">
                                <tr>
                                    <td>
                                        <img class="maskapai" src="{{asset('/assets/logo/'.getLogo($airlineList['FlightNo']).'.png')}}" style="height: 30px;width: auto;">
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
                            @if(count($airlines)-1==$key)
                                <div class="list-seat">
                                        <div class="item-seat">
                                            <div class="left">
                                                <input type="radio" name="selectedIDdep0" value="{{$fares[0]['selectedIDdep']}}" checked>
                                                <span class="bangku-info">{{ $result['cabin'] }} class</span>
                                                {{--<span class="bangku-info">Subclass : {{$fare['SubClass']}} (<i>{{$fare['SeatAvb']}} bangku tersisa</i>)</span>--}}
                                            </div>
                                            <div class="right">
                                                <span class="price">IDR {{number_format($fares[0]['TotalFare'])}}</span>
                                            </div>
                                        </div>
                                </div>
                            @endif
                        @endforeach
                        <div class="rows text-right">
                            <div class="col-md-4 col-md-offset-8 col-xs-12">
                                <a href="{{route('airlines.all_fares')}}" onclick="event.preventDefault();document.getElementById('getFare').submit();airlines.mySubmit();" class="btn btn-cari">Selanjutnya</a>
                            </div>
                        </div>
                    @else
                        {!! Form::open(['route'=>'airlines.all_fares','method'=>'post','id'=>'getFare']) !!}
                        {!! Form::hidden('acDep',getAC($result['schedule']['departure'][0]['Flights'][0]['FlightNo']),['id'=>'acDep']) !!}
                        {!! Form::hidden('result',json_encode($result)) !!}
                        {!! Form::hidden('airline',json_encode($airline)) !!}

                        @foreach($airlines as $key => $airlineList)
                            <div class="row nopadding">
                                <div class="blue-list">
                                    <div class="col-md-6 inline-blue nopadding">
                                        <img class="maskapai" src="{{asset('/assets/logo/'.getLogo($airlineList['FlightNo']).'.png')}}" style="height: 30px;width: auto;">
                                        <span class="code-penerbangan"><strong>{{$airlineList['FlightNo']}} ({{$airlineList['STD']}} - {{$airlineList['STA']}})</strong></span>
                                    </div>
                                    <div class="col-md-2 inline-blue nopadding">
                                        <p><i class="fa fa-plane" aria-hidden="true"></i> <strong>Berangkat</strong><br>{{date('D',strtotime($airlineList['ETD']))}}, {{date('d M',strtotime($airlineList['ETD']))}} {{date('H:i',strtotime($airlineList['ETD']))}}<br></p>
                                    </div>
                                    <div class="col-md-2 inline-blue nopadding">
                                        <p><i class="fa fa-plane" aria-hidden="true"></i> <strong>Tiba</strong><br>{{date('D',strtotime($airlineList['ETA']))}}, {{date('d M',strtotime($airlineList['ETA']))}} {{date('H:i',strtotime($airlineList['ETA']))}}<br></p>
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
                                </div>
                            </div><!--end.row-->
                            <table class="blue-table" style="display: none;">
                                <tr>
                                    <td>
                                        <img class="maskapai" src="{{asset('/assets/logo/'.getLogo($airlineList['FlightNo']).'.png')}}" style="height: 30px;width: auto;">
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
                                    <div class="item-seat">
                                        <div class="left">
                                            <input type="radio" name="selectedIDdep{{$key}}" value="{{$fares[0]['selectedIDdep']}}" checked>
                                            <span class="bangku-info">{{ $result['cabin']}} class</span>
                                            {{--<span class="bangku-info">Subclass : {{$fare['SubClass']}} (<i>{{$fare['SeatAvb']}} bangku tersisa</i>)</span>--}}
                                        </div>
                                        <div class="right">
                                            <span class="price">IDR {{number_format($fares[0]['TotalFare'])}}</span>
                                        </div>
                                    </div><!--end.item-seat-->
                            </div>
                        @endforeach
                        <div class="rows text-right">
                            <div class="col-md-4 col-md-offset-8 col-xs-12">
                                <a href="{{route('airlines.all_fares')}}" onclick="event.preventDefault();document.getElementById('getFare').submit();airlines.mySubmit();" class="btn btn-cari">Selanjutnya</a>
                            </div>
                        </div>
                    @endif
                </div><!--.seat-table-->
            </div><!--end.col-12-->
        </div><!--end.row-->
    </div><!--end.container-->
</section><!--end.maintable-->