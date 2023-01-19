<!DOCTYPE html>
<html>
<head>
    <title>e-Ticket</title>
</head>
<body>
    <div>
        <table border="0" width="100%">
            <tr>
                <td style="width: 20%;"><img src="{{ asset('/assets/logo/logotext-blue.png') }}" style="width: auto;height: 75px;"></td>
                <td style="width: 5%;"></td>
                <td><h2>e-Ticket</h2><p>This is not a boarding pass</p></td>
            </tr>
        </table>
    </div>
<hr>
    <div>
        <table border="0" width="100%">
            <tr>
                <td style="width: 20%"><span><strong>Booking Code</strong></span><br><span>Kode Booking</span><br><h2>{{ $transaction->pnr }}</h2></td>
                <td><span><strong>Booking Date</strong></span><br><span>Tanggal Booking</span><br><h4>{{ date('D, d M Y',strtotime($transaction->created_at)) }}</h4></td>
            </tr>
        </table>
    </div>
<hr>
    <h2>Reservation Details : </h2>
    <div>
        <table style="width: 100%; border-collapse: collapse;border: 1px solid black">
            <tr style="border: 1px solid black">
                <th style="border: 1px solid black;width: 33%;text-align: center;">Airlines</th>
                <th style="border: 1px solid black;width: 33%;text-align: center;">Depart</th>
                <th style="border: 1px solid black;text-align: center;">Arrive</th>
            </tr>
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
                                    <tr style="border: 1px solid black">
                                        <td style="border: 1px solid black;text-align: center;">
                                            @if($val==0)
                                                @if($i!=0)
                                                    <strong>Return</strong><br>
                                                @else
                                                    <strong>Departure</strong><br>
                                                @endif
                                            @endif
                                            <span>{{ acName(substr($airlineList->flight_number,0,2)) }} - </span>
                                            <span>{{$airlineList->flight_number}}</span><br>
                                            <h3 style="color: red;">{{ $airlineList->pnr }}</h3>
                                        </td>
                                        <td style="border: 1px solid black;text-align: center;">
                                            <?php $std=getAirport($airlineList->std); ?>
                                            <span>{{$std->city}} ({{$std->id}})</span><br>
                                            <span>{{$std->name}}</span><br>
                                            <span>{{date('D',strtotime($airlineList->etd))}}, {{date('d M',strtotime($airlineList->etd))}}</span>
                                            <span>{{date('H:i',strtotime($airlineList->etd))}}</span>
                                        </td>
                                        <td style="border: 1px solid black;text-align: center;">
                                            <?php $sta=getAirport($airlineList->sta); ?>
                                            <span>{{$sta->city}} ({{$sta->id}})</span><br>
                                            <span>{{$sta->name}}</span><br>
                                            <span>{{date('D',strtotime($airlineList->eta))}}, {{date('d M',strtotime($airlineList->eta))}}</span>
                                            <span>{{date('H:i',strtotime($airlineList->eta))}}</span>
                                        </td>
                                    </tr>
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
                                <tr style="border: 1px solid black">
                                    <td style="border: 1px solid black;text-align: center;">
                                        @if($val==0)
                                            @if($key!=0)
                                                <strong>Return</strong><br>
                                            @else
                                                <strong>Departure</strong><br>
                                            @endif
                                        @endif
                                        <span>{{ acName(substr($airlineList->flight_number,0,2)) }} - </span>
                                        <span>{{$airlineList->flight_number}}</span><br>
                                        <h3 style="color: red;">{{ $airlineList->pnr }}</h3>
                                    </td>
                                    <td style="border: 1px solid black;text-align: center;">
                                        <?php $std=getAirport($airlineList->std); ?>
                                        <span>{{$std->city}} ({{$std->id}})</span><br>
                                        <span>{{$std->name}}</span><br>
                                        <span>{{date('D',strtotime($airlineList->etd))}}, {{date('d M',strtotime($airlineList->etd))}}</span>
                                        <span>{{date('H:i',strtotime($airlineList->etd))}}</span>
                                    </td>
                                    <td style="border: 1px solid black;text-align: center;">
                                        <?php $sta=getAirport($airlineList->sta); ?>
                                        <span>{{$sta->city}} ({{$sta->id}})</span><br>
                                        <span>{{$sta->name}}</span><br>
                                        <span>{{date('D',strtotime($airlineList->eta))}}, {{date('d M',strtotime($airlineList->eta))}}</span>
                                        <span>{{date('H:i',strtotime($airlineList->eta))}}</span>
                                    </td>
                                </tr>
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
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black;text-align: center;">
                                    @if($val==0)
                                        @if($key!=0)
                                            <strong>Return</strong><br>
                                        @else
                                            <strong>Departure</strong><br>
                                        @endif
                                    @endif
                                    <span>{{ acName(substr($airlineList->flight_number,0,2)) }} - </span>
                                    <span>{{$airlineList->flight_number}}</span><br>
                                    <h3 style="color: red;">{{ $airlineList->pnr }}</h3>
                                </td>
                                <td style="border: 1px solid black;text-align: center;">
                                    <?php $std=getAirport($airlineList->std); ?>
                                    <span>{{$std->city}} ({{$std->id}})</span><br>
                                    <span>{{$std->name}}</span><br>
                                    <span>{{date('D',strtotime($airlineList->etd))}}, {{date('d M',strtotime($airlineList->etd))}}</span>
                                    <span>{{date('H:i',strtotime($airlineList->etd))}}</span>
                                </td>
                                <td style="border: 1px solid black;text-align: center;">
                                    <?php $sta=getAirport($airlineList->sta); ?>
                                    <span>{{$sta->city}} ({{$sta->id}})</span><br>
                                    <span>{{$sta->name}}</span><br>
                                    <span>{{date('D',strtotime($airlineList->eta))}}, {{date('d M',strtotime($airlineList->eta))}}</span>
                                    <span>{{date('H:i',strtotime($airlineList->eta))}}</span>
                                </td>
                            </tr>
                    @endforeach
                @endforeach
            @endif
        </table>
    </div>
<hr>
    <h2>Passenger Details : </h2>
    <div>
        <table style="width: 100%; border-collapse: collapse;border: 1px solid black">
            <tr style="border: 1px solid black">
                <th style="border: 1px solid black;width: 10%;text-align: center;">No</th>
                <th style="border: 1px solid black;width: 60%;text-align: center;">Name</th>
                <th style="border: 1px solid black;width: 30%;text-align: center;">Ticket Type</th>
            </tr>
            @foreach($transaction->passengers as $key => $passenger)
                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black;text-align: center;">{{ $key+1 }}</td>
                    <td style="border: 1px solid black;">{{$passenger->first_name}} {{$passenger->last_name}}</td>
                    <td style="border: 1px solid black;">{{ $passenger->type_passenger->type }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</body>
</html>
     <?php /*
<html>
	<style>
	html,body,div,p,hr,table,tr,td{margin:0px;padding:0px;font-family:Arial;font-size:14px;}
	html{background-color:#777777;}
	.div_main{width:800px;margin:0px auto;background-color:#ffffff;}
	</style>
	<body>
		<div class="div_main">
			<div style="padding:25px;">
				<div style="width:100%;display:table;">
					<div style="width:35%;float:left;">
						<div style="border-right:2px solid #2699d0;">
							<img src="{{ asset('/assets/logo/logotext-blue.png') }}" style="width: auto;height: 80px;">
						</div>
					</div>
					<div style="width:65%;float:left;">
						<div style="padding-left:15px;">
							<p style="color:#2699d0;font-size:18px;line-height:1.25em;">
								<b>e-Ticket</b>
								<br>This is not a boarding pass
							</p>
						</div>
					</div>
				</div>
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
            </div>
            <div style="width:100%;margin-top:20px;display:table;">
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
                                                <div style="width:30%;background-color:#2699d0;float:left;">
                                                    <p style="padding-left:25px;color:#ffffff;line-height:40px;"><b>Return Flight</b></p>
                                                </div>
                                                <div style="width:70%;float:right;">
                                                    <div style="padding-left:10px;">
                                                        <hr style="margin-top:19px;border:none;border-top:2px solid #2699d0;">
                                                    </div>
                                                </div>
                                        @else
                                                <div style="width:30%;background-color:#2699d0;float:left;">
                                                    <p style="padding-left:25px;color:#ffffff;line-height:40px;"><b>Departure Flight</b></p>
                                                </div>
                                                <div style="width:70%;float:right;">
                                                    <div style="padding-left:10px;">
                                                        <hr style="margin-top:19px;border:none;border-top:2px solid #2699d0;">
                                                    </div>
                                                </div>
                                        @endif
                                    @endif
                                    <div style="width:100%;margin-top:10px;padding-left:25px;">
                                        <div style="width:50%;">
                                            <div style="width:100%;display:table;">
                                                <div style="float:left;">
                                                    <img src="{{asset('/assets/logo/'.getLogo($airlineList->flight_number).'.png')}}" style="height:25px;">
                                                    <p style="margin-top:5px;font-size:12px;">{{ acName(substr($airlineList->flight_number,0,2)) }} - {{$airlineList->flight_number}}</p>
                                                </div>
                                                <div style="margin-left:25px;float:left;">
                                                    <p>Booking Code :</p>
                                                    <p style="font-size:28px;"><b>{{ $airlineList->pnr }}</b></p>
                                                </div>
                                            </div>
                                            <table style="margin-top:15px;">
                                                <tr>
                                                    <td rowspan="2">
                                                        <!-- <p style="display:inline-block;vertical-align:middle;">1j 50m</p> -->
                                                        <div style="padding:10px 0px;position:relative;display:inline-block;">
                                                            <p style="display:inline-block;vertical-align:middle;"><b>&#9711;<br><br><br><br><br>&#9711;</b></p>
                                                            <div style="height:60px;margin-left:-13px;border-right:2px solid #000000;display:inline-block;vertical-align:middle;"></div>
                                                        </div>
                                                    </td>
                                                    <td style="vertical-align:top;">
                                                        <p style="font-size:24px;"><b>{{date('H:i',strtotime($airlineList->etd))}}</b></p>
                                                        <p style="font-size:12px;">{{date('d M Y',strtotime($airlineList->etd))}}</p>
                                                    </td>
                                                    <td style="padding-left:20px;vertical-align:top;">
                                                        <?php $std=getAirport($airlineList->std); ?>
                                                        <p style="font-size:24px;">{{$std->city}} ({{$std->id}})</p>
                                                        <p style="font-size:12px;">{{$std->name}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:bottom;">
                                                        <p style="font-size:24px;"><b>{{date('H:i',strtotime($airlineList->eta))}}</b></p>
                                                        <p style="font-size:12px;">{{date('d M Y',strtotime($airlineList->eta))}}</p>
                                                    </td>
                                                    <?php $sta=getAirport($airlineList->sta); ?>
                                                    <td style="padding-left:20px;vertical-align:bottom;">
                                                        <p style="font-size:24px;">{{$sta->city}} ({{$sta->id}})</p>
                                                        <p style="font-size:12px;">{{$sta->name}}</p>
                                                    </td>
                                                </tr>
                                            </table>
                                            @if($val+1<$countFlight)
                                                <p style="margin-top:10px;padding:5px 10px;background-color:#2699d0;color:#ffffff;">Transit di {{$sta->city}} ({{$sta->id}})</p>
                                            @endif
                                        </div>
                                        <div>
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
                                                                    <div style="width:30%;background-color:#2699d0;float:left;">
                                                                        <p style="padding-left:25px;color:#ffffff;line-height:40px;"><b>Return Flight</b></p>
                                                                    </div>
                                                                    <div style="width:70%;float:right;">
                                                                        <div style="padding-left:10px;">
                                                                            <hr style="margin-top:19px;border:none;border-top:2px solid #2699d0;">
                                                                        </div>
                                                                    </div>
                                                            @else
                                                                    <div style="width:30%;background-color:#2699d0;float:left;">
                                                                        <p style="padding-left:25px;color:#ffffff;line-height:40px;"><b>Departure Flight</b></p>
                                                                    </div>
                                                                    <div style="width:70%;float:right;">
                                                                        <div style="padding-left:10px;">
                                                                            <hr style="margin-top:19px;border:none;border-top:2px solid #2699d0;">
                                                                        </div>
                                                                    </div>
                                                            @endif
                                                        @endif
                                                        <div style="width:100%;margin-top:10px;padding-left:25px;">
                                                            <div style="width:50%;">
                                                                <div style="width:100%;display:table;">
                                                                    <div style="float:left;">
                                                                        <img src="{{asset('/assets/logo/'.getLogo($airlineList->flight_number).'.png')}}" style="height:25px;">
                                                                        <p style="margin-top:5px;font-size:12px;">{{ acName(substr($airlineList->flight_number,0,2)) }} - {{$airlineList->flight_number}}</p>
                                                                    </div>
                                                                    <div style="margin-left:25px;float:left;">
                                                                        <p>Booking Code :</p>
                                                                        <p style="font-size:28px;"><b>{{ $airlineList->pnr }}</b></p>
                                                                    </div>
                                                                </div>
                                                                <table style="margin-top:15px;">
                                                                    <tr>
                                                                        <td rowspan="2">
                                                                            <!-- <p style="display:inline-block;vertical-align:middle;">1j 50m</p> -->
                                                                            <div style="padding:10px 0px;position:relative;display:inline-block;">
                                                                                <p style="display:inline-block;vertical-align:middle;"><b>&#9711;<br><br><br><br><br>&#9711;</b></p>
                                                                                <div style="height:60px;margin-left:-13px;border-right:2px solid #000000;display:inline-block;vertical-align:middle;"></div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="vertical-align:top;">
                                                                            <p style="font-size:24px;"><b>{{date('H:i',strtotime($airlineList->etd))}}</b></p>
                                                                            <p style="font-size:12px;">{{date('d M Y',strtotime($airlineList->etd))}}</p>
                                                                        </td>
                                                                        <td style="padding-left:20px;vertical-align:top;">
                                                                            <?php $std=getAirport($airlineList->std); ?>
                                                                            <p style="font-size:24px;">{{$std->city}} ({{$std->id}})</p>
                                                                            <p style="font-size:12px;">{{$std->name}}</p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="vertical-align:bottom;">
                                                                            <p style="font-size:24px;"><b>{{date('H:i',strtotime($airlineList->eta))}}</b></p>
                                                                            <p style="font-size:12px;">{{date('d M Y',strtotime($airlineList->eta))}}</p>
                                                                        </td>
                                                                        <?php $sta=getAirport($airlineList->sta); ?>
                                                                        <td style="padding-left:20px;vertical-align:bottom;">
                                                                            <p style="font-size:24px;">{{$sta->city}} ({{$sta->id}})</p>
                                                                            <p style="font-size:12px;">{{$sta->name}}</p>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                                @if($val+1<$countFlight)
                                                                    <p style="margin-top:10px;padding:5px 10px;background-color:#2699d0;color:#ffffff;">Transit di {{$sta->city}} ({{$sta->id}})</p>
                                                                @endif
                                                            </div>
                                                            <div>
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
                                                                                            <p style="padding-left:25px;color:#ffffff;line-height:40px;"><b>Return Flight</b></p>
                                                                                        </div>
                                                                                        <div style="width:70%;float:right;">
                                                                                            <div style="padding-left:10px;">
                                                                                                <hr style="margin-top:19px;border:none;border-top:2px solid #2699d0;">
                                                                                            </div>
                                                                                        </div>
                                                                                @else
                                                                                        <div style="width:30%;background-color:#2699d0;float:left;">
                                                                                            <p style="padding-left:25px;color:#ffffff;line-height:40px;"><b>Departure Flight</b></p>
                                                                                        </div>
                                                                                        <div style="width:70%;float:right;">
                                                                                            <div style="padding-left:10px;">
                                                                                                <hr style="margin-top:19px;border:none;border-top:2px solid #2699d0;">
                                                                                            </div>
                                                                                        </div>
                                                                                @endif
                                                                            @endif
                                                                            <div style="width:100%;margin-top:10px;padding-left:25px;">
                                                                                <div style="width:50%;">
                                                                                    <div style="width:100%;display:table;">
                                                                                        <div style="float:left;">
                                                                                            <img src="{{asset('/assets/logo/'.getLogo($airlineList->flight_number).'.png')}}" style="height:25px;">
                                                                                            <p style="margin-top:5px;font-size:12px;">{{ acName(substr($airlineList->flight_number,0,2)) }} - {{$airlineList->flight_number}}</p>
                                                                                        </div>
                                                                                        <div style="margin-left:25px;float:left;">
                                                                                            <p>Booking Code :</p>
                                                                                            <p style="font-size:28px;"><b>{{ $airlineList->pnr }}</b></p>
                                                                                        </div>
                                                                                    </div>
                                                                                    <table style="margin-top:15px;">
                                                                                        <tr>
                                                                                            <td rowspan="2">
                                                                                                <!-- <p style="display:inline-block;vertical-align:middle;">1j 50m</p> -->
                                                                                                <div style="padding:10px 0px;position:relative;display:inline-block;">
                                                                                                    <p style="display:inline-block;vertical-align:middle;"><b>&#9711;<br><br><br><br><br>&#9711;</b></p>
                                                                                                    <div style="height:60px;margin-left:-13px;border-right:2px solid #000000;display:inline-block;vertical-align:middle;"></div>
                                                                                                </div>
                                                                                            </td>
                                                                                            <td style="vertical-align:top;">
                                                                                                <p style="font-size:24px;"><b>{{date('H:i',strtotime($airlineList->etd))}}</b></p>
                                                                                                <p style="font-size:12px;">{{date('d M Y',strtotime($airlineList->etd))}}</p>
                                                                                            </td>
                                                                                            <td style="padding-left:20px;vertical-align:top;">
                                                                                                <?php $std=getAirport($airlineList->std); ?>
                                                                                                <p style="font-size:24px;">{{$std->city}} ({{$std->id}})</p>
                                                                                                <p style="font-size:12px;">{{$std->name}}</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td style="vertical-align:bottom;">
                                                                                                <p style="font-size:24px;"><b>{{date('H:i',strtotime($airlineList->eta))}}</b></p>
                                                                                                <p style="font-size:12px;">{{date('d M Y',strtotime($airlineList->eta))}}</p>
                                                                                            </td>
                                                                                            <?php $sta=getAirport($airlineList->sta); ?>
                                                                                            <td style="padding-left:20px;vertical-align:bottom;">
                                                                                                <p style="font-size:24px;">{{$sta->city}} ({{$sta->id}})</p>
                                                                                                <p style="font-size:12px;">{{$sta->name}}</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                    @if($val+1<$countFlight)
                                                                                        <p style="margin-top:10px;padding:5px 10px;background-color:#2699d0;color:#ffffff;">Transit di {{$sta->city}} ({{$sta->id}})</p>
                                                                                    @endif
                                                                                </div>
                                                                                <div>
                                                                                    @endforeach
                                                                                    @endforeach
                                                                                    @endif
            </div>
                <div style="width:100%;margin-top:20px;display:table;">
                    <div style="width:30%;background-color:#2699d0;float:left;">
                        <p style="padding-left:25px;color:#ffffff;line-height:40px;"><b>Passenger Details</b></p>
                    </div>
                    <div style="width:70%;float:right;">
                        <div style="padding-left:10px;">
                            <hr style="margin-top:19px;border:none;border-top:2px solid #2699d0;">
                        </div>
                    </div>
                </div>
				<table style="width:100%;margin-top:10px;border-collapse:collapse;">
					<tr>
						<td style="padding-left:25px;"><p style="line-height:35px;">No.</p></td>
						<td><p>Name</p></td>
						<td><p>Ticket Number</p></td>
						<td><p>Ticket Type</p></td>
						<!-- <td><p style="text-align:center;">Baggage</p></td> -->
					</tr>
                    @foreach($transaction->passengers as $key => $passenger)
                        <tr>
                            <td style="padding-left:25px;"><p style="line-height:25px;">{{ $key+1 }}.</p></td>
                            <td><p>{{$passenger->title}}. <b>{{$passenger->first_name}} {{$passenger->last_name}}</b></p></td>
                            <td><p><b>$transaction->id</b></p></td>
                            <td><p><b>{{ $passenger->type_passenger->type }}</b></p></td>
                            <!-- <td><p style="text-align:center;"><b>20kg</b></p></td> -->
                        </tr>
                    @endforeach
				</table>
				<div style="width:100%;margin-top:20px;display:table;">
					<div style="width:30%;background-color:#2699d0;float:left;">
						<p style="padding-left:25px;color:#ffffff;line-height:40px;"><b>Price</b></p>
					</div>
					<div style="width:70%;float:right;">
						<div style="padding-left:10px;">
							<hr style="margin-top:19px;border:none;border-top:2px solid #2699d0;">
						</div>
					</div>
				</div>
				<p style="padding-right:100px;font-size:32px;text-align:right;"><b>IDR&nbsp;&nbsp;&nbsp;{{ number_format($transaction->paxpaid) }}</b></p>
				<hr style="margin-top:15px;border:none;border-top:1px solid #2699d0;">
				<p style="margin-top:20px;font-size:12px;">
					This tickets can be printed and taken to show to the officer at the time of check-in. Include the identity of the passengers at check-in so that the officer can verify this ticket.
				</p>
				<p style="margin-top:10px;font-size:12px;">
					<i>Tiket ini dapat dicetak dan dibawa untuk ditunjukkan kepada petugas pada saat check-in. Sertakan identitas diri para penumpang pada saat check-in agar petugas dapat melakukan validasi tiket ini.</i>
				</p>
			<div style="background-color:#2699d0;">
				<div style="padding:10px 25px;">
					<div style="width:100%;display:table;">
						<table style="float:left;">
							<tr>
								<td rowspan="2"><img src="images/img_icon_phone.png" style="height:32px;"></td>
								<td><p style="padding-left:5px;color:#ffffff;font-size:12px;">Hubungi kami di :</p></td>
							</tr>
							<tr>
								<td><p style="padding-left:5px;color:#ffffff;"><b>0822 999 8790</b></p></td>
							</tr>
						</table>
						<table style="margin-left:20px;float:left;">
							<tr>
								<td rowspan="2"><img src="images/img_icon_mail.png" style="height:24px;"></td>
								<td><p style="padding-left:5px;color:#ffffff;font-size:12px;">Email :</p></td>
							</tr>
							<tr>
								<td><p style="padding-left:5px;color:#ffffff;"><b>cs@mysmartinpays.net</b></p></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
        </div>
	</body>
</html>
        */ ?>