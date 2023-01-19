<!doctype html>
<html>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>BPJS</title>
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
		.header.div-col>h5{line-height:144%;text-align:right;}
		.header.div-col>h5>span{display:inline-table;}
		.header.div-col>h5>span:first-of-type{width:40mm;}
		.header.div-col>h5>span:last-of-type{width:24mm;}
		.header.div-col>h5:last-of-type>span:last-of-type{color:#0fa2c1;}

		.main.content{height:200mm;}
		.content.div-table{width:100%;padding-top:20mm;}
		.content.div-col{vertical-align:top;}
		.content.div-col:first-of-type{width:64%;}
		.content.div-col>h5{line-height:144%;}
		.content.div-col:first-of-type>h5:not(.content-price)>span{display:inline-table;}
		.content.div-col:first-of-type>h5:not(.content-price)>span:first-of-type{width:20mm;}
		.content.div-col:first-of-type>h5:not(.content-price)>span:last-of-type{width:40mm;}
		.content.div-col:last-of-type>h5>span{display:inline-table;}
		.content.div-col:last-of-type>h5>span:first-of-type{width:28mm;}
		.content.div-col:last-of-type>h5.content-price>span:last-of-type{width:28mm;text-align:right;}
		.content.div-col:last-of-type>h5.content-price>span:nth-of-type(3){width:8mm;}

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
		
		/*   firefox only   */
		@-moz-document url-prefix(){
		    .content.div-col:last-of-type>h5.content-price>span:last-of-type{width:27mm;}
		}
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
						<h5 class="f-700">Receipt PLN-Postpaid</h5>
						<h5>
							<span>Payment Date</span>
							<span>:</span>
							<span>{{ date('d-m-Y',strtotime($data->created_at)) }}</span>
						</h5>
						<h5>
							<span>Transaction ID</span>
							<span>:</span>
							<span class="f-500">{{$data->id}}</span>
						</h5>
					</div>
				</div>
			</div>
			<div class="main content">
				<div class="content div-table">
					<div class="content div-col">
						<h5>
							<span>ID Cust</span>
							<span>:</span>
							<span>{{$data->number}}</span>
						</h5>
						<h5>
							<span>Name</span>
							<span>:</span>
							<span>{{ $data->pln_pasca->customer_name }}</span>
            </h5>
            <h5>
							<span>Category</span>
							<span>:</span>
							<span>{{ $data->pln_pasca->golongan_daya }}</span>
						</h5>
						<h5>
							<span>Period</span>
							<span>:</span>
							<span>{{  $data->pln_pasca->period  }}</span>
						</h5>
						<h5>
							<span>Stand Meter</span>
							<span>:</span>
							<span>{{  $data->pln_pasca->stand_meter }}</span>
            </h5>
					</div>
					<div class="content div-col">
						<h5 class="content-price">
							<span>Bill</span>
							<span>:</span>
							<span>IDR</span>
							<span> {{ number_format($data->pln_pasca->nominal) }}</span>
            </h5>
						<h5 class="content-price">
							<span>Admin's Bank</span>
							<span>:</span>
							<span>IDR</span>
							<span>{{ number_format($data->pln_pasca->admin) }}</span>
            </h5>
            @if((int)$data->service_fee>0)
            <h5 class="content-price">
							<span>Service Fee</span>
							<span>:</span>
							<span>IDR</span>
							<span>{{ number_format($data->service_fee) }}</span>
            </h5>
            <h5 class="content-price">
							<span>Total</span>
							<span>:</span>
							<span>IDR</span>
							<span>{{ number_format($data->paxpaid+(int)$data->service_fee) }}</span>
            </h5>
            @else
						<h5 class="content-price">
							<span>Total</span>
							<span>:</span>
							<span>IDR</span>
							<span>{{ number_format($data->paxpaid) }}</span>
            </h5>
            @endif
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