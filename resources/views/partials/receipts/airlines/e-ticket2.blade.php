<!DOCTYPE html>
<html>
<head>
    <style>
        html,body,div,p,hr,table,tr,td{margin:0px;padding:0px;font-family:Arial;font-size:14px;}
        html{background-color:#777777;}
        .div_main{width:800px;margin:0px auto;background-color:#ffffff;}
    </style>
</head>
<body>
<div class="div_main">
    <div style="padding:25px;">
        <div style="width:100%;display:table;">
            <div style="width:35%;float:left;">
                <div style="border-right:2px solid #2699d0;">
                    <img src="{{ asset('/assets/logo/logotext-blue.png') }}" style="height:80px;">
                </div>
            </div>
            <div style="width:65%;float:right;">
                <div style="padding-left:15px;">
                    <p style="color:#2699d0;font-size:18px;line-height:1.25em;">
                        <b>e-Ticket</b>
                        <br>This is not a boarding pass
                    </p>
                </div>
            </div>
        </div>
        <br>
        <br>
        <br>
        <br>
        <hr style="margin-top:20px;border:none;border-top:2px solid #2699d0;">
        <div style="width:100%;margin-top:20px;display:table;">
            <div style="width:25%;float:left;">
                <div style="padding:10px;text-align:center;">
                    <p style="font-size:18px;"><b>Booking Date</b></p>
                    <p>Tanggal Booking</p>
                    <hr style="margin:10px auto;border:none;">
                    <p style="font-size:20px;">{{ date('D, d M Y',strtotime($transaction->created_at)) }}</p>
                </div>
            </div>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        @if(count($transaction->bookings)==1)
            @if($transaction->trip_type_id=='R')
                @foreach ($transaction->bookings as $key => $booking)
                    @for($i=0;$i<=1;$i++)
                        <?php
                        ($i==0)?$departReturnId='d':$departReturnId='r';
                        $airlines=$booking->itineraries()->where('depart_return_id',$departReturnId);
                        $airlinesLists = $airlines->get();
                        $countFlight=count($airlinesLists);
                        ?>
                        @foreach($airlinesLists as $val => $airlineList)
                            @if($val==0)
                                @if($i!=0)
                                    <div style="width:100%;margin-top:20px;display:table;">
                                        <div style="width:30%;background-color:#2699d0;float:left;">
                                            <p style="color:#ffffff;line-height:40px;text-align: center;"><b>Return Flight</b></p>
                                        </div>
                                        <div style="width:70%;float:right;">
                                            <div style="padding-left:10px;">
                                                <hr style="margin-top:19px;border:none;border-top:2px solid #2699d0;">
                                            </div>
                                        </div>
                                    </div>
                                        <br>
                                        <br>
                                        <br>
                                @else
                                    <div style="width:100%;margin-top:20px;display:table;">
                                        <div style="width:30%;background-color:#2699d0;float:left;line-height: 80px;">
                                            <p style="color:#ffffff;line-height:40px;text-align: center;"><b>Departure Flight</b></p>
                                        </div>
                                        <div style="width:70%;float:right;">
                                            <div style="padding-left:10px;">
                                                <hr style="margin-top:19px;border:none;border-top:2px solid #2699d0;">
                                            </div>
                                        </div>
                                    </div>
                                        <br>
                                        <br>
                                        <br>
                                @endif
                            @endif
                            <div style="width:100%;margin-top:10px;padding-left:25px;">
                                <div style="width:50%;">
                                    <div style="width:100%;display:table;">
                                        <div style="float:left;">
                                            <img src="{{asset('/assets/logo/'.getLogo($airlineList->flight_number).'.png')}}" style="height:25px;">
                                            <p style="margin-top:5px;font-size:12px;">{{ acName(substr($airlineList->flight_number,0,2)) }} - {{$airlineList->flight_number}}</p>
                                        </div>
                                        <div style="margin-left:25px;float:right;">
                                            <p>Booking Code :</p>
                                            <p style="font-size:28px;"><b>{{ $airlineList->pnr }}</b></p>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <br>
                                    <table style="margin-top:15px;">
                                        <tr>
                                            <td rowspan="2">
                                                <br><br><br>
                                                <div style="padding:10px 0px;position:relative;display:inline-block;">
                                                    <p style="display:inline-block;vertical-align:middle;"><b>O<br><br><br><br><br>O</b></p>
                                                    <div style="height:60px;margin-left:-11px;border-right:2px solid #000000;display:inline-block;vertical-align:middle;"></div>
                                                </div>
                                                <p style="display:inline-block;vertical-align:middle;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                                            </td>
                                            <td style="vertical-align:bottom;">
                                                <span style="font-size:24px;"><b>{{date('H:i',strtotime($airlineList->etd))}}</b></span><br>
                                                <span style="font-size:12px;">{{date('d M Y',strtotime($airlineList->etd))}}</span><br><br>
                                            </td>
                                            <td style="padding-left:20px;vertical-align:bottom;">
                                                <?php $std=getAirport($airlineList->std); ?>
                                                <span style="font-size:24px;">{{$std->city}} ({{$std->id}})</span><br>
                                                <span style="font-size:12px;">{{$std->name}}</span><br><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align:top;">
                                                <br>
                                                <span style="font-size:24px;"><b>{{date('H:i',strtotime($airlineList->eta))}}</b></span><br>
                                                <span style="font-size:12px;">{{date('d M Y',strtotime($airlineList->eta))}}</span>
                                            </td>
                                            <?php $sta=getAirport($airlineList->sta); ?>
                                            <td style="padding-left:20px;vertical-align:top;">
                                                <br>
                                                <span style="font-size:24px;">{{$sta->city}} ({{$sta->id}})</span><br>
                                                <span style="font-size:12px;">{{$sta->name}}</span>
                                            </td>
                                        </tr>
                                    </table>
                                    @if($val+1<$countFlight)
                                        <p style="margin-top:10px;padding:5px 10px;background-color:#2699d0;color:#ffffff;">Transit di {{$sta->city}} ({{$sta->id}})</p>
                                    @endif
                                </div>
                                </div>
                                    @endforeach
                                    @endfor
                                    @endforeach
                                    @else
                                        @foreach ($transaction->bookings as $key => $booking)
                                            <?php
                                            ($key==0)?$departReturnId='d':$departReturnId='r';
                                            $airlines=$booking->itineraries()->where('depart_return_id',$departReturnId);
                                            $airlinesLists = $airlines->get();
                                            $countFlight=count($airlinesLists);
                                            ?>
                                            @foreach($airlinesLists as $val => $airlineList)
                                                @if($val==0)
                                                    @if($key!=0)
                                                            <div style="width:100%;margin-top:20px;display:table;">
                                                                <div style="width:30%;background-color:#2699d0;float:left;">
                                                                    <p style="color:#ffffff;line-height:40px;text-align: center;"><b>Return Flight</b></p>
                                                                </div>
                                                                <div style="width:70%;float:right;">
                                                                    <div style="padding-left:10px;">
                                                                        <hr style="margin-top:19px;border:none;border-top:2px solid #2699d0;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <br>
                                                            <br>
                                                    @else
                                                            <div style="width:100%;margin-top:20px;display:table;">
                                                                <div style="width:30%;background-color:#2699d0;float:left;">
                                                                    <p style="color:#ffffff;line-height:40px;text-align: center;"><b>Departure Flight</b></p>
                                                                </div>
                                                                <div style="width:70%;float:right;">
                                                                    <div style="padding-left:10px;">
                                                                        <hr style="margin-top:19px;border:none;border-top:2px solid #2699d0;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <br>
                                                            <br>
                                                    @endif
                                                @endif
                                                <div style="width:100%;margin-top:10px;padding-left:25px;">
                                                    <div style="width:50%;">
                                                        <div style="width:100%;display:table;">
                                                            <div style="float:left;">
                                                                <img src="{{asset('/assets/logo/'.getLogo($airlineList->flight_number).'.png')}}" style="height:25px;">
                                                                <p style="margin-top:5px;font-size:12px;">{{ acName(substr($airlineList->flight_number,0,2)) }} - {{$airlineList->flight_number}}</p>
                                                            </div>
                                                            <div style="margin-left:25px;float:right;">
                                                                <p>Booking Code :</p>
                                                                <p style="font-size:28px;"><b>{{ $airlineList->pnr }}</b></p>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <br>
                                                        <br>
                                                        <table style="margin-top:15px;">
                                                            <tr>
                                                                <td rowspan="2">
                                                                    <br><br><br>
                                                                    <div style="padding:10px 0px;position:relative;display:inline-block;">
                                                                        <p style="display:inline-block;vertical-align:middle;"><b>O<br><br><br><br><br>O</b></p>
                                                                        <div style="height:60px;margin-left:-11px;border-right:2px solid #000000;display:inline-block;vertical-align:middle;"></div>
                                                                    </div>
                                                                    <p style="display:inline-block;vertical-align:middle;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                                                                </td>
                                                                <td style="vertical-align:bottom;">
                                                                    <span style="font-size:24px;"><b>{{date('H:i',strtotime($airlineList->etd))}}</b></span><br>
                                                                    <span style="font-size:12px;">{{date('d M Y',strtotime($airlineList->etd))}}</span><br><br>
                                                                </td>
                                                                <td style="padding-left:20px;vertical-align:bottom;">
                                                                    <?php $std=getAirport($airlineList->std); ?>
                                                                    <span style="font-size:24px;">{{$std->city}} ({{$std->id}})</span><br>
                                                                    <span style="font-size:12px;">{{$std->name}}</span><br><br>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="vertical-align:top;">
                                                                    <br>
                                                                    <span style="font-size:24px;"><b>{{date('H:i',strtotime($airlineList->eta))}}</b></span><br>
                                                                    <span style="font-size:12px;">{{date('d M Y',strtotime($airlineList->eta))}}</span>
                                                                </td>
                                                                <?php $sta=getAirport($airlineList->sta); ?>
                                                                <td style="padding-left:20px;vertical-align:top;">
                                                                    <br>
                                                                    <span style="font-size:24px;">{{$sta->city}} ({{$sta->id}})</span><br>
                                                                    <span style="font-size:12px;">{{$sta->name}}</span>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        @if($val+1<$countFlight)
                                                            <p style="margin-top:10px;padding:5px 10px;background-color:#2699d0;color:#ffffff;">Transit di {{$sta->city}} ({{$sta->id}})</p>
                                                        @endif
                                                    </div>
                                                    </div>
                                                        @endforeach
                                                        @endforeach
                                                        @endif
                                                        @else
                                                            @foreach ($transaction->bookings as $key => $booking)
                                                                <?php
                                                                ($key==0)?$departReturnId='d':$departReturnId='r';
                                                                $airlines=$booking->itineraries()->where('depart_return_id',$departReturnId);
                                                                $airlinesLists = $airlines->get();
                                                                $countFlight=count($airlinesLists);
                                                                ?>
                                                                @foreach($airlinesLists as $val => $airlineList)
                                                                    @if($val==0)
                                                                        @if($key!=0)
                                                                            <div style="width:30%;background-color:#2699d0;float:left;">
                                                                                <p style="color:#ffffff;line-height:40px;text-align: center;"><b>Return Flight</b></p>
                                                                            </div>
                                                                            <div style="width:70%;float:right;">
                                                                                <div style="padding-left:10px;">
                                                                                    <hr style="margin-top:19px;border:none;border-top:2px solid #2699d0;">
                                                                                </div>
                                                                            </div>
                                                                            <br>
                                                                            <br>
                                                                            <br>
                                                                        @else
                                                                            <div style="width:30%;background-color:#2699d0;float:left;">
                                                                                <p style="color:#ffffff;line-height:40px;text-align: center;"><b>Departure Flight</b></p>
                                                                            </div>
                                                                            <div style="width:70%;float:right;">
                                                                                <div style="padding-left:10px;">
                                                                                    <hr style="margin-top:19px;border:none;border-top:2px solid #2699d0;">
                                                                                </div>
                                                                            </div>
                                                                                <br>
                                                                                <br>
                                                                                <br>
                                                                        @endif
                                                                    @endif
                                                                    <div style="width:100%;margin-top:10px;padding-left:25px;">
                                                                        <div style="width:50%;">
                                                                            <div style="width:100%;display:table;">
                                                                                <div style="float:left;">
                                                                                    <img src="{{asset('/assets/logo/'.getLogo($airlineList->flight_number).'.png')}}" style="height:25px;">
                                                                                    <p style="margin-top:5px;font-size:12px;">{{ acName(substr($airlineList->flight_number,0,2)) }} - {{$airlineList->flight_number}}</p>
                                                                                </div>
                                                                                <div style="margin-left:25px;float:right;">
                                                                                    <p>Booking Code :</p>
                                                                                    <p style="font-size:28px;"><b>{{ $airlineList->pnr }}</b></p>
                                                                                </div>
                                                                            </div>
                                                                            <br>
                                                                            <br>
                                                                            <br>
                                                                            <table style="margin-top:15px;">
                                                                                <tr>
                                                                                    <td rowspan="2">
                                                                                        <br><br><br>
                                                                                        <div style="padding:10px 0px;position:relative;display:inline-block;">
                                                                                            <p style="display:inline-block;vertical-align:middle;"><b>O<br><br><br><br><br>O</b></p>
                                                                                            <div style="height:60px;margin-left:-11px;border-right:2px solid #000000;display:inline-block;vertical-align:middle;"></div>
                                                                                        </div>
                                                                                        <p style="display:inline-block;vertical-align:middle;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                                                                                    </td>
                                                                                    <td style="vertical-align:bottom;">
                                                                                        <span style="font-size:24px;"><b>{{date('H:i',strtotime($airlineList->etd))}}</b></span><br>
                                                                                        <span style="font-size:12px;">{{date('d M Y',strtotime($airlineList->etd))}}</span><br><br>
                                                                                    </td>
                                                                                    <td style="padding-left:20px;vertical-align:bottom;">
                                                                                        <?php $std=getAirport($airlineList->std); ?>
                                                                                        <span style="font-size:24px;">{{$std->city}} ({{$std->id}})</span><br>
                                                                                        <span style="font-size:12px;">{{$std->name}}</span><br><br>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="vertical-align:top;">
                                                                                        <br>
                                                                                        <span style="font-size:24px;"><b>{{date('H:i',strtotime($airlineList->eta))}}</b></span><br>
                                                                                        <span style="font-size:12px;">{{date('d M Y',strtotime($airlineList->eta))}}</span>
                                                                                    </td>
                                                                                    <?php $sta=getAirport($airlineList->sta); ?>
                                                                                    <td style="padding-left:20px;vertical-align:top;">
                                                                                        <br>
                                                                                        <span style="font-size:24px;">{{$sta->city}} ({{$sta->id}})</span><br>
                                                                                        <span style="font-size:12px;">{{$sta->name}}</span>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                            @if($val+1<$countFlight)
                                                                                <p style="margin-top:10px;padding:5px 10px;background-color:#2699d0;color:#ffffff;">Transit di {{$sta->city}} ({{$sta->id}})</p>
                                                                            @endif
                                                                        </div>
                                                                        </div>
                                                                            @endforeach
                                                                            @endforeach
                                                                            @endif
        <div style="width:100%;margin-top:20px;display:table;">
            <div style="width:30%;background-color:#2699d0;float:left;">
                <p style="color:#ffffff;line-height:40px;text-align: center;"><b>Passenger Details</b></p>
            </div>
            <div style="width:70%;float:right;">
                <div style="padding-left:10px;">
                    <hr style="margin-top:19px;border:none;border-top:2px solid #2699d0;">
                </div>
            </div>
        </div>
        <br>
        <br>
        <br>
        <table style="width:100%;margin-top:10px;border-collapse:collapse;">
            <tr>
                <td style="padding-left:25px;"><p style="line-height:35px;">No.</p></td>
                <td><p>Name</p></td>
                {{--<td><p>Ticket Number</p></td>--}}
                <td><p>Ticket Type</p></td>
                <!--<td><p style="text-align:center;">Baggage</p></td>-->
            </tr>
            @foreach($transaction->passengers as $key => $passenger)
                <tr>
                    <td style="padding-left:25px;"><p style="line-height:25px;">{{ $key+1 }}.</p></td>
                    <td><p>{{$passenger->title}}. <b>{{$passenger->first_name}} {{$passenger->last_name}}</b></p></td>
                    {{--<td><p><b>{{ $transaction->id }}</b></p></td>--}}
                    <td><p><b>{{ $passenger->type_passenger->type }}</b></p></td>
                    <!-- <td><p style="text-align:center;"><b>20kg</b></p></td> -->
                </tr>
            @endforeach
        </table>
        <div style="width:100%;margin-top:20px;display:table;">
            <div style="width:30%;background-color:#2699d0;float:left;">
                <p style="color:#ffffff;line-height:40px;text-align: center;"><b>Price</b></p>
            </div>
            <div style="width:70%;float:right;">
                <div style="padding-left:10px;">
                    <hr style="margin-top:19px;border:none;border-top:2px solid #2699d0;">
                </div>
            </div>
        </div><br><br><br>
        @if((int)$transaction->service_fee>0)
            <table border="0" width="100%">
                <tr>
                    <td style="text-align: right;width: 70%;">Ticket Price</td>
                    <td style="width: 30%;">&nbsp;&nbsp;&nbsp;&nbsp;IDR &nbsp; {{ number_format($transaction->total_fare) }}</td>
                </tr>
                <tr>
                    <td style="text-align: right;">Service Fee</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;IDR &nbsp; {{ number_format($transaction->service_fee) }}</td>
                </tr>
                <tr>
                    <td style="text-align: right;">Total Amount</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<b>IDR &nbsp; {{ number_format($transaction->total_fare+(int)$transaction->service_fee) }}</b></td>
                </tr>
            </table>
        @else
            <p style="padding-right:100px;font-size:32px;text-align:right;"><b>IDR&nbsp;&nbsp;&nbsp;{{ number_format($transaction->total_fare) }}</b></p>
        @endif
        <hr style="margin-top:15px;border:none;border-top:1px solid #2699d0;">
        <p style="margin-top:20px;font-size:12px;">
            This tickets can be printed and taken to show to the officer at the time of check-in. Include the identity of the passengers at check-in so that the officer can verify this ticket.
        </p>
        <p style="margin-top:10px;font-size:12px;">
            <i>Tiket ini dapat dicetak dan dibawa untuk ditunjukkan kepada petugas pada saat check-in. Sertakan identitas diri para penumpang pada saat check-in agar petugas dapat melakukan validasi tiket ini.</i>
        </p>
    </div>
    <div style="background-color:#2699d0;">
        <div style="padding:10px 25px;">
            <div style="width:100%;display:table;">
                <table style="margin-left:20px;float:left;">
                    <tr>
                        <td rowspan="2"><img src="{{ asset('images/logo/theme/email-icon.PNG') }}" style="height:32px;"></td>
                        <td><p style="padding-left:5px;color:#ffffff;font-size:12px;">Email :</p></td>
                    </tr>
                    <tr>
                        <td><p style="padding-left:5px;color:#ffffff;"><b>cs@mysmartinpays.net</b></p></td>
                    </tr>
                </table>
            </div>
        </div>
        <br>
        <br>
        <br>
    </div>
</div>
</body>
</html>
*/ ?>