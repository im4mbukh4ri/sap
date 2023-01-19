<!doctype html>
<html>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Train</title>
	<style>
		@font-face{font-family:Roboto;font-weight:100;src:url({{asset('/assets/fonts/Roboto-Thin.ttf')}})}
		@font-face{font-family:Roboto;font-weight:300;src:url({{asset('/assets/fonts/Roboto-Light.ttf')}})}
		@font-face{font-family:Roboto;font-weight:400;src:url({{asset('/assets/fonts/Roboto-Regular.ttf')}})}
		@font-face{font-family:Roboto;font-weight:500;src:url({{asset('/assets/fonts/Roboto-Medium.ttf')}})}
		@font-face{font-family:Roboto;font-weight:700;src:url({{asset('/assets/fonts/Roboto-Bold.ttf')}})}
		@font-face{font-family:Roboto;font-weight:900;src:url({{asset('/assets/fonts/Roboto-Black.ttf')}})}
		
		html,body,body *{margin:0px auto;padding:0px;box-sizing:border-box;line-height:100%;outline:none;}
		html,body{height:100%;background-color:#c0c0c0;}
		body{font-family:Roboto;font-size:11px;font-weight:400;}
		h1,h2,h3,h4,h5,h6,p{font-weight:400;}
		h1{font-size:4em;}
		h2{font-size:3em;}
		h3{font-size:2.4em;}
		h4{font-size:2em;}
		h5{font-size:1.6em;}
		h6{font-size:1.2em;}
		p{font-size:1em;}
		.page{width:210mm;min-height:297mm;margin:0mm auto;padding:10mm;background-color:#ffffff;}
		.main{width:100%;margin:0px auto;position:relative;overflow:hidden;}
		.div-table{display:table;}
		.div-col{display:table-cell;vertical-align:middle;}
		.f-100{font-weight:100;}
		.f-300{font-weight:300;}
		.f-400{font-weight:400;}
		.f-500{font-weight:500;}
		.f-700{font-weight:700;}
		.f-900{font-weight:900;}
		
		.main.header{height:25mm;}
		.header.div-table{width:100%;min-height:75px;}
		.header.div-col:last-of-type{width:38%;padding-right:2mm;border-right:4px solid #0fa2c1;}
		.header-img{height:18mm;}
		.header-logo-kai{height:18mm;float:right;}
		.header.div-col>h5{line-height:144%;text-align:right;}
		.header.div-col>h5>span{display:inline-table;}
		.header.div-col>h5>span:first-of-type{width:40mm;}
		.header.div-col>h5>span:last-of-type{width:24mm;}
		.header.div-col>h5:last-of-type>span:last-of-type{color:#0fa2c1;}

		.main.content{height:200mm;}
		.main.content>h4{margin-bottom:6mm;}
		.train.div-table{width:100%;}
		.train.div-col{vertical-align:top;}
		.train-vendor{width:30%;}
		.logo-vendor{height:8mm;margin-bottom:2mm;}
		.train-vendor>*{line-height:128%;}
		
		.train-date{width:50%;padding-top:1mm;}
		.train-date>p{height:5mm;}
		.train-date>p>span{color:#888888;}
		.train-time.div-table{width:100%;}
		.train-time.div-table:first-of-type{height:15mm;}
		.train-time.div-col{height:100%;position:relative;vertical-align:top;}
		.train-time.div-col:first-of-type{width:8mm;}
		.train-time.div-col:nth-of-type(2){width:8mm;text-align:center;}
		.train-time.div-col:nth-of-type(2)>span{width:4mm;height:4mm;position:relative;border-radius:50%;display:inline-block;z-index:1;}
		.span-depart{background-color:#0fa2c1;border:1px solid #e6e6e6;}
		.span-depart:after{width:1px;height:13mm;margin:auto;position:absolute;top:108%;left:0px;right:0px;background-color:#0fa2c1;content:'';display:inline-block;z-index:0;}
		.span-arrive{background-color:#ffffff;border:1px solid #0fa2c1;}
		.train-time.div-col>p{line-height:4mm;}
		.train-terminal{color:#888888;}

		.train-bookingid{width:20%;padding-top:1mm;text-align:right;}
		.train-qrcode{height:8mm;}
		.train-bookingid>p{margin-top:4mm;line-height:4mm;}
		.train-bookingid>h5{margin-top:6px;color:#0fa2c1;}

		.train-tnc.div-table{width:100%;margin:6mm auto;padding:3mm;border-top:1px solid #e6e6e6;border-bottom:1px solid #e6e6e6;}
		.train-tnc.div-col:first-of-type{width:38%;}
		.train-tnc.div-col:nth-of-type(2){width:36%;}
		.train-tnc.div-col:last-of-type{width:26%;}
		.train-tnc.div-col>*{display:inline-table;vertical-align:middle;}
		.train-tnc.div-col>img{height:8mm;margin-right:4mm;}
		.train-tnc.div-col>p{line-height:128%;}
		.tnc-qrcode>p{width:64%;}
		.tnc-idcard>p{width:52%;}
		.tnc-clock>p{width:62%;}

		.train-person.div-table{width:100%;}
		.train-person.div-col{vertical-align:top;}
		.person-no{width:8%;text-align:center;}
		.person-name{width:30%;}
		.person-type{width:14%;}
		.person-idcard{width:24%;}
		.person-seat{width:24%;}
		.train-person.div-col>p{min-height:12mm;line-height:144%;}
		.train-person.div-col>p>span{display:inline-table;}
		.train-person.div-col>p>span:first-of-type{width:36%;}
		.train-person.div-col>p>span:last-of-type{width:24%;}

		.main.footer{height:52mm;border-top:1px solid #e6e6e6;}
		.footer-top.div-table{width:100%;}
		.footer-top.div-col{width:50%;padding:3mm 0mm;}
		.footer-top.div-col:last-of-type{text-align:right;}
		.footer-top.div-col>div{display:inline-table;vertical-align:middle;}
		.footer-top.div-col>div>img{height:14mm;margin-right:4mm;}
		.footer-top.div-col p{line-height:176%;}
		.footer-bot.div-table{width:100%;background-color:#e6e6e6;}
		.footer-bot.div-col{height:30mm;position:relative;}
		.footer-bot.div-col:first-of-type{width:16%;}
		.footer-bot.div-col:nth-of-type(3){width:16%;}
		.footer-bot.div-col:last-of-type{width:20%;}
		.img-phone{height:90%;position:absolute;bottom:0px;left:0px;}
		.footer-text>*{line-height:160%;}
		.footer-text>h5{margin-bottom:4px;}
		.img-qrcode-blue{height:100%;}
		.footer-download>a{width:100%;display:block;}
		.footer-download>a:last-of-type{margin-top:2mm;}
		.footer-download>a>img{width:88%;margin-left:0px;display:block;}
		
		@page{margin:0;size:A4;}
		@media print{
			html,body{width:210mm;height:297mm;}
			.page{width:210mm;min-height:297mm;margin:0mm auto;padding:10mm;background-color:#ffffff;}
			/*.page{width:initial;min-height:initial;margin:0;background-color:initial;page-break-after:always;}*/
		}
	</style>
	<body>
		<div class="page">
			<div class="main header">
				<div class="header div-table">
					<div class="header div-col">
						<img class="header-img" src="{{asset('/images/eticket/img-header.png')}}">
						<img class="header-logo-kai" src="{{asset('/images/eticket/img-logo-kai.png')}}">
					</div>
					<div class="header div-col">
						<h5 class="f-700">E-ticket Train</h5>
						<h5>This is not a boarding pass</h5>
						<h5>
							<span>Transaction ID</span>
							<span>:</span>
							<span class="f-500">{{ $booking->train_transaction_id	 }}</span>
						</h5>
					</div>
				</div>
			</div>
			<div class="main content">
				<h4>Departure</h4>
				<div class="train div-table">
					<div class="train div-col train-vendor">
						<h6 class="f-700">{{ $booking->train_name }} {{$booking->train_number}}</h6>
						<h6>{{$booking->class}} ({{$booking->subclass}})</h6>
					</div>
					<div class="train div-col train-date">
						<p class="f-500">{{date('d M Y',strtotime($booking->etd))}}</span></p>
						<div class="train-time div-table">
							<div class="train-time div-col">
								<p class="f-500">{{date('H:i',strtotime($booking->etd))}}</p>
							</div>
							<div class="train-time div-col">
								<span class="span-depart"></span>
							</div>
							<div class="train-time div-col">
								<p class="train-city f-500">{{$booking->origin_station->name}}</p>
								<p class="train-terminal">{{$booking->origin_station->city}}</p>
							</div>
						</div>
						<div class="train-time div-table">
							<div class="train-time div-col">
								<p class="f-500">{{date('H:i',strtotime($booking->eta))}}</p>
							</div>
							<div class="train-time div-col">
								<span class="span-arrive"></span>
							</div>
							<div class="train-time div-col">
								<p class="train-city f-500">{{$booking->destination_station->name}}</p>
								<p class="train-terminal">{{$booking->destination_station->city}}</p>
							</div>
						</div>
					</div>
					<div class="train div-col train-bookingid">
						{{-- <img class="train-qrcode" src="images/img-qrcode-black.jpg"> --}}
						<p class="f-500">Booking ID</p>
						<h5 class="f-500">{{ $booking->pnr }}</h5>
					</div>
				</div>
				<div class="train-tnc div-table">
					<div class="train-tnc div-col tnc-qrcode">
						<img src="{{asset('/images/eticket/icon-qrcode.png')}}">
						<p>Use E-ticket to print boarding passes at the station,<br>7x24 hours before departure</p>
					</div>
					<div class="train-tnc div-col tnc-idcard">
						<img src="{{asset('/images/eticket/icon-idcard.png')}}">
						<p>For boarding passes,<br>bring official ID in use at the time of booking</p>
					</div>
					<div class="train-tnc div-col tnc-clock">
						<img src="{{asset('/images/eticket/icon-clock.png')}}">
						<p>Arrived at the station at least 60 minutes before departure</p>
					</div>
				</div>
				<div class="train-person div-table">
					<div class="train-person div-col person-no">
						<p class="f-500">No</p>
					</div>
					<div class="train-person div-col person-name">
						<p class="f-500">Passenger</p>
					</div>
					<div class="train-person div-col person-type">
						<p class="f-500">Type</p>
					</div>
					<div class="train-person div-col person-idcard">
						<p class="f-500">ID Card & Number</p>
					</div>
					<div class="train-person div-col person-seat">
						<p class="f-500">Seat Number</p>
					</div>
        </div>
        @foreach($transaction->passengers as $key => $passenger)
        <div class="train-person div-table">
					<div class="train-person div-col person-no">
						<p class="f-500">{{ $key+1 }}</p>
					</div>
					<div class="train-person div-col person-name">
						<p class="f-500">{{$passenger->name}}</p>
					</div>
					<div class="train-person div-col person-type">
						<p class="f-500">{{$passenger->type_passenger->type}}</p>
					</div>
					<div class="train-person div-col person-idcard">
						<p class="f-500">{{$passenger->identity_number}}</p>
					</div>
					<div class="train-person div-col person-seat">
						<p class="f-500">
                <?php
                $departureSeat = $passenger->passanger_seats->first();
                ?>
                @if($passenger->type=='adt')
                {{$departureSeat->seat->wagon_code}}-{{$departureSeat->seat->wagon_number}} {{$departureSeat->seat->seat}}
                @else
                -
                @endif
                @if($transaction->trip_type_id=="R")
                  <?php
                  $returnSeat = $passenger->passanger_seats->last();
                  ?>
                  @if($passenger->type=='adt')
                    {{$returnSeat->seat->wagon_code}}-{{$returnSeat->seat->wagon_number}} {{$returnSeat->seat->seat}}
                  @else
                    -
                  @endif
                @endif
            </p>
					</div>
				</div>
        @endforeach
			</div>
			<div class="main footer">
				<div class="footer-top div-table">
					<div class="footer-top div-col">
						<div>
							<img src="{{asset('/images/eticket/icon-support.png')}}">
						</div>
						<div>
							<p>Customer Service (ID)</p>
							<p>021-1500 107</p>
						</div>
					</div>
					<div class="footer-top div-col">
						<p>Email Customer Service</p>
						<p>cs@smartinpays.com</p>
					</div>
				</div>
				<div class="footer-bot div-table">
					<div class="footer-bot div-col">
						<img class="img-phone" src="{{asset('/images/eticket/img-phone.png')}}">
					</div>
					<div class="footer-bot div-col footer-text">
						<h5 class="f-700">No need to print!</h5>
						<p>Get special prices with Smart In Pays Application</p>
						<p>Order and get special promos for Smart In Pays application users</p>
						<p>Scan this QR to download Smart In Pays APP</p>
					</div>
					<div class="footer-bot div-col">
						<img class="img-qrcode-blue" src="{{asset('/images/eticket/img-qrcode-blue.png')}}">
					</div>
					<div class="footer-bot div-col footer-download">
						<a href="#"><img class="btn-playstore" src="{{asset('/images/eticket/btn-playstore.png')}}"></a>
						<a href="#"><img class="btn-appstore" src="{{asset('/images/eticket/btn-appstore.png')}}"></a>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>