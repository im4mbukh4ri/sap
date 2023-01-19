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
                        <br>This is not a ticket
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
        @foreach ($transaction->bookings as $key => $booking)
          <div style="width:100%;margin-top:20px;display:table;">
              <div style="width:30%;background-color:#2699d0;float:left;">
                @if($booking->depart_return_id=="d")
                  <p style="color:#ffffff;line-height:40px;text-align: center;"><b>Departure</b></p>
                @else
                  <p style="color:#ffffff;line-height:40px;text-align: center;"><b>Return</b></p>
                @endif

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
              <div style="width:100%;margin-top:10px;padding-left:25px;">
                  <div style="width:50%;">
                      <div style="width:100%;display:table;">
                          <div style="float:left;">
                              <img src="{{asset('/assets/logo/kai.png')}}" style="height:50px;">
                              <p style="margin-top:5px;font-size:12px;">{{ $booking->train_name }} - {{$booking->train_number}}<br />{{$booking->class}} ({{$booking->subclass}})</p>
                          </div>
                          <div style="margin-left:25px;float:right;">
                              <p>Booking Code :</p>
                              <p style="font-size:28px;"><b>{{ $booking->pnr }}</b></p>
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
                                  <span style="font-size:24px;"><b>{{date('H:i',strtotime($booking->etd))}}</b></span><br>
                                  <span style="font-size:12px;">{{date('d M Y',strtotime($booking->etd))}}</span><br><br>
                              </td>
                              <td style="padding-left:20px;vertical-align:bottom;">
                                  <span style="font-size:24px;">{{$booking->origin_station->city}}</span><br>
                                  <span style="font-size:12px;">{{$booking->origin_station->name}}</span><br><br>
                              </td>
                          </tr>
                          <tr>
                              <td style="vertical-align:top;">
                                  <br>
                                  <span style="font-size:24px;"><b>{{date('H:i',strtotime($booking->eta))}}</b></span><br>
                                  <span style="font-size:12px;">{{date('d M Y',strtotime($booking->eta))}}</span>
                              </td>
                              <td style="padding-left:20px;vertical-align:top;">
                                  <br>
                                  <span style="font-size:24px;">{{$booking->destination_station->city}}</span><br>
                                  <span style="font-size:12px;">{{$booking->destination_station->name}}</span>
                              </td>
                          </tr>
                      </table>
                  </div>
                  </div>
        @endforeach
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
                <td><p>Ticket Type</p></td>
                <td><p>Identity Number</p></td>
                <td><p>Phone</p></td>
                <td><p>Seat Departure</p></td>
                @if($transaction->trip_type_id=="R")
                  <td><p>Seat Return</p></td>
                @endif
            </tr>
            @foreach($transaction->passengers as $key => $passenger)
                <tr>
                    <td style="padding-left:25px;"><p style="line-height:25px;">{{ $key+1 }}.</p></td>
                    <td><p><b>{{$passenger->name}}</b></p></td>
                    <td><p><b>{{$passenger->type_passenger->type}}</b></p></td>
                    <td><p><b>{{$passenger->identity_number}}</b></p></td>
                    <td><p><b>{{$passenger->phone}}</b></p></td>
                    <?php
$departureSeat = $passenger->passanger_seats->first();
?>
                    @if($passenger->type=='adt')
                    <td><p><b>{{$departureSeat->seat->wagon_code}}-{{$departureSeat->seat->wagon_number}} {{$departureSeat->seat->seat}}</b></p></td>
                    @else
                    <td></td>
                    @endif
                    @if($transaction->trip_type_id=="R")
                      <?php
$returnSeat = $passenger->passanger_seats->last();
?>
                      @if($passenger->type=='adt')
                        <td><p><b>{{$returnSeat->seat->wagon_code}}-{{$returnSeat->seat->wagon_number}} {{$returnSeat->seat->seat}}</b></p></td>
                      @else
                        <td></td>
                      @endif
                    @endif
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
