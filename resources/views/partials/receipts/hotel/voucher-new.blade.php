<!doctype html>
<html>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Hotel</title>
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
		.header.div-col:last-of-type{width:38%;padding-right:2mm;}
		.header-img{height:18mm;}
		.header.div-col>*{line-height:144%;text-align:right;}
		.header.div-col>h3{font-size:2.8em;}
		.header.div-col>*>span{color:#0fa2c1;}

		.main.content{height:132mm;}
		.main.content>hr{margin:24px auto;border:none;border-top:1px solid #e6e6e6;}
		.content.div-table{width:100%;}
		.content.div-col{vertical-align:top;}
		.content.div-col:first-of-type{width:40%;}
		.content.div-col:last-of-type{width:60%;}

		.main.footer{height:120mm;border-top:1px solid #e6e6e6;}
		.footer-top.div-table{width:100%;border-bottom:1px solid #e6e6e6;}
		.footer-top.div-col{width:50%;padding:3mm 0mm;}
		.footer-top.div-col:last-of-type{text-align:right;}
		.footer-top.div-col>div{display:inline-table;vertical-align:middle;}
		.footer-top.div-col>div>img{height:14mm;margin-right:4mm;}
		.footer-top.div-col p{line-height:176%;}
		.footer-mid>div:last-of-type{margin-bottom:16px;}
		.footer-mid>div>*{line-height:200%;}
		.footer-mid>div>h5{margin-top:8px;}
		.footer-mid>div>p{width:100%;display:table;}
		.footer-mid>div>p>span{display:table-cell;line-height:200%;}
		.footer-mid>div>p>span:first-of-type{width:2%;}
		.footer-mid>div>p>span:last-of-type{width:98%;}
		.footer-mid>div>p>span>span{width:4px;height:4px;margin-bottom:2px;background-color:#000000;border-radius:50%;display:inline-block;}
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
					</div>
					<div class="header div-col">
						<h3 class="f-700">Voucher <span>Hotel</span></h3>
						<h5>Transaction ID : <span class="f-500">{{$transaction->id}}</span></h5>
					</div>
				</div>
			</div>
			<div class="main content">
				<div class="content div-table">
					<div class="content div-col">
						<div class="booking-code">
							<h5 class="f-500">Booking Code</h5>
              <h3 class="f-700">{{$transaction->voucher->res}}</h3>
							<h5>Booked and paid by<br>Smart In Pays</h5>
						</div>
					</div>
					<div class="content div-col">
						<div class="hotel-detail">
							<h5 class="f-700">{{$transaction->hotel->name}}</h5>
							<p>
								{{$transaction->hotel->address}}
							</p>
							<div class="check-in-out div-table">
								<div class="check-in-out div-col">
									<p>Check-in</p>
									<p class="f-700">{{date('d-M-y',strtotime($transaction->checkin))}}</p>
									<p class="f-500">14 : 00</p>
								</div>
								<div class="check-in-out div-col">
									<p>Check-out</p>
									<p class="f-700">{{date('d-M-y',strtotime($transaction->checkout))}}</p>
									<p class="f-500">12 : 00</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<hr>
				<style>
					.booking-code>h3{margin:20px 0px;color:#0fa2c1;font-size:2.8em;}
					.booking-code>h5{line-height:144%;}

					.hotel-detail>h5{margin-bottom:12px;}
					.hotel-detail>p{line-height:200%;}
					.check-in-out.div-table{width:60%;margin-top:12px;margin-left:0px;}
					.check-in-out.div-col{width:50%;padding:4px 8px;border-left:4px solid #0fa2c1;}
					.check-in-out.div-col>p{line-height:144%;}
					.check-in-out.div-col>p:last-of-type{color:#0fa2c1;}

					.hotel-map{width:90%;height:60mm;border:none;}

					.booking-desc>h5{margin-bottom:12px;}
					.booking-desc>hr{margin:8px auto;border:none;border-top:1px solid #e6e6e6;}
					.booking-detail.div-table{width:100%;}
					.booking-detail.div-col{width:50%;vertical-align:top;}
					.booking-detail.div-col>p{line-height:200%;}
				</style>
				<div class="content div-table">
					<div class="content div-col">
            {{-- <img src="https://{{$transaction->hotel->url_image}}" width="100%" style="padding: 10px;"/> --}}
					</div>
					<div class="content div-col">
						<div class="booking-desc">
							<h5 class="f-700">Booking Detail</h5>
							<div class="booking-detail div-table">
								<div class="booking-detail div-col">
									<p>Guest</p>
								</div>
								<div class="booking-detail div-col">
									<p>{{$transaction->hotel_guest->name}}</p>
								</div>
							</div>
							<hr>
							<div class="booking-detail div-table">
								<div class="booking-detail div-col">
									<p>Total Guest<br>Room Type<br>Total Room<br>Include Breakfast ?<br>Special Request</p>
								</div>
								<div class="booking-detail div-col">
                <p>{{(int)$transaction->adt + (int)$transaction->inf}} Guest
                  <br>{{$transaction->hotel_rooms()->first()->name}}
                  <br>{{$transaction->hotel_rooms()->count()}} Room
                  <br>{{$transaction->hotel_rooms()->first()->board}}
                  @if($transaction->guest_note)
                  <br>{{$transaction->guest_note->note}}
                  @endif
                </p>
								</div>
							</div>
						</div>
					</div>
				</div>
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
				<div class="footer-mid">
					<div class="footer-policy">
						<h5>Hotel Cancellation Policy</h5>
						<p>
							<span><span></span></span>
							<span>This order cannot be refunded</span>
						</p>
						<p>
							<span><span></span></span>
							<span>The time displayed is according to the local time. The stay date and room type cannot be changed.</span>
						</p>
					</div>
					<div class="footer-note">
						<h5>Important Note</h5>
						<p>
							<span><span></span></span>
							<span>At check-in, goverment issued identification and a credit card or cash deposit might be required to cover unexpected cost.<br>Fulfillment special request depends on availability upon check-in and may incur additional cost.</span>
						</p>
						<p>
							<span><span></span></span>
							<span>Additional costs such as parking, deposit, telephone, room service are handled directly between guest and the hotel.<br>additional guest in room also may incur additional cost and it varies depending on hotel policy.</span>
						</p>
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