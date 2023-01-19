<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"/>
	<title>Form SIP</title>
	<style>
	html,body,div,span,p,h1,h2,h3,h4,h5,h6,a,input,textarea,table,tr,td,button{margin:0px;padding:0px;font-family:'Trebuchet MS',Helvetica,sans-serif;line-height:100%;}
	html,body,input,textarea,table,tr,td,button{font-size:12px;}
	html{width:100%;background-color:#000000;}
	h1{font-size:5.2em;}h2{font-size:4em;}h3{font-size:3em;}h4{font-size:2.2em;}h5{font-size:1.6em;}h6{font-size:1.2em;}
	.body_content{width:800px;margin:0px auto;background-color:#fff;}
	.body_padding,.main_content{padding:10px;}
	.main_content{border:2px solid #000;}
	.logo_title_content{width:100%;display:table;}
	.logo_content,.title_content{display:table-cell;vertical-align:middle;}
	.title_content{text-align:right;}
	.url_content{margin:10px auto;padding:5px 0px;background-color:#2699d0;color:#fff;text-align:center;}
	.form_left_right_content,.form_fill{width:100%;display:table;}
	.form_left_right_content{margin-bottom:10px;}
	.form_left,.form_right,.text_left,.text_right{display:table-cell;}
	.form_left,.form_right{width:50%;}
	.form_right{background-color:#ccc;}
	.text_left{width:40%;padding-left:10px;}
	.text_right{padding-right:10px;}
	.form_fill p{line-height:40px;}
	.form_fill input{width:200px;line-height:24px;}
	.form_right .form_fill input{background:transparent;border:1px solid #fff;}
	.input_address{width:202px;resize:none;vertical-align:top;}
	.form_policy p{margin-top:10px;padding:5px 10px;background-color:#ccc;line-height:125%;}
	.form_confirmation{margin:10px auto;padding:5px 10px;border:1px solid #000;}
	.form_confirm_box{width:100%;display:table;}
	.form_confirm_box p:not(:last-of-type){margin-bottom:10px;vertical-align:middle;}
	.form_left_confirm,.form_right_confirm{display:table-cell;}
	.form_left_confirm{width:75%;padding-right:18px;}
	.form_right_confirm{vertical-align:bottom;}
	.form_left_confirm span{height:1.5em;background-color:#ccc;display:inline-block;vertical-align:middle;}
	.text_arrival,.text_departure{width:199px;}
	.payment_details,.booked_by{margin-top:5px;}
	.payment_details{width:172px;}
	.booked_by{width:100%;height:5em !important;}
	.sign_box{height:100%;height:120px;position:relative;border:1px solid #000;}
	.sign_box p{position:absolute;bottom:5px;left:5px;display:inline-block;}
	</style>
</head>
<body>
	<div class="body_content">
		<div class="body_padding">
			<div class="main_content">
				<div class="header_content">
					<div class="logo_title_content">
						<div class="logo_content">
							<img src="{{ asset('/assets/logo/logotext-blue.png') }}" alt="Logo SIP" style="vertical-align:middle; width: auto;height: 75px;"/>
						</div>
						<div class="title_content">
							<h3 style="margin-bottom:5px;">Booking <span style="color:#2699d0;">Voucher</span></h3>
							<p>Please present either an electronic or paper copy of your booking voucher upon check-in.</p>
						</div>
					</div>
					<div class="url_content">
						<p><strong>www.smartinpays.com</strong></p>
					</div>
				</div>
				<div class="form_content">
				<br><br>
					<div class="form_left_right_content">
						<div class="form_left">
							<div class="form_fill">
								<p class="text_left">Booking ID</p>
								<p class="text_right">: {{$transaction->voucher->voucher}}</p>
							</div>
							<div class="form_fill">
								<p class="text_left">Booking Reference No.</p>
								<p class="text_right">: {{$transaction->voucher->res}} </p>
							</div>
							<div class="form_fill">
								<p class="text_left">Guest</p>
								<p class="text_right">: {{$transaction->hotel_guest->name}}</p>
							</div>
							<div class="form_fill">
								<p class="text_left">Country</p>
								<p class="text_right">: {{$transaction->hotel->hotel_city->country}}</p>
							</div>
							<div class="form_fill">
								<p class="text_left">Property</p>
								<p class="text_right">: <input class="input_property" name="input_property" type="text" value="{{$transaction->hotel->name}}"/></p>
							</div>
							<div class="form_fill">
								<p class="text_left">Address</p>
								<p class="text_right">: <textarea class="input_address" name="input_address" rows="5">{{$transaction->hotel->address}}"</textarea></p>
							</div>
							<div class="form_fill">
								<p class="text_left">Property Contact</p>
								<p class="text_right">: <input class="input_contact" name="input_contact" type="text" value="{{$transaction->hotel->email}}"/></p>
							</div>
						</div>
						<br>
						<br>
						<div class="form_right">
							<div class="form_fill">
								<p class="text_left">Number of Rooms</p>
								<p class="text_right">: <input class="input_num_rooms" name="input_num_rooms" type="text" value=" &nbsp;{{$transaction->hotel_rooms()->count()}}"/></p>
							</div>
							<div class="form_fill">
								<p class="text_left">Number of Adults</p>
								<p class="text_right">: <input class="input_num_adults" name="input_num_adults" type="text" value=" &nbsp;{{$transaction->adt}}" /></p>
							</div>
							<div class="form_fill">
								<p class="text_left">Number of Children</p>
								<p class="text_right">: <input class="input_num_children" name="input_num_children" type="text" value=" &nbsp;{{$transaction->chd}}"/></p>
							</div>
							<div class="form_fill">
								<p class="text_left">Board</p>
								<p class="text_right">: <input class="input_breakfast" name="input_breakfast" type="text" value=" &nbsp;{{$transaction->hotel_rooms()->first()->room->board}}"/></p>
							</div>
							<div class="form_fill">
								<p class="text_left">Room Type</p>
								<p class="text_right">: <input class="input_room_type" name="input_room_type" type="text" value=" &nbsp;{{$transaction->hotel_rooms()->first()->room->name}}"/></p>
							</div>
							<div class="form_fill">
								<p class="text_left">For Full Promotion details and condition see confirmation email</p>
							</div>
						</div>
					</div>
					<div class="form_policy">
						<p>Cancellation Policy : This booking is Non-Refundable and cannot be amended or modified.
						Failure to arrive at your hotel will be treated as a No-Show and no refund will be given (Hotel Policy).</p>
						<p>Benefit Included :</p>
					</div>
					<div class="form_confirmation">
						<div class="form_confirm_box">
							<div class="form_left_confirm">
								<p><strong>Arrival : </strong><span class="text_arrival">{{date('d-M-y',strtotime($transaction->checkin))}}</span>&nbsp;&nbsp;&nbsp;
									<strong>Departure : </strong><span class="text_departure">{{date('d-M-y',strtotime($transaction->checkout))}}</span></p>
								<p><strong>Payment Details : </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Total : </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/>
									<span class="payment_details">IDR {{number_format($transaction->total_fare + $transaction->service_fee)}}</span>&nbsp;<span class="payment_details">IDR {{number_format($transaction->total_fare+$transaction->service_fee)}}</span>
               					 </p>
								<p><strong>Booked And Payable By : </strong><br/>
									<span class="booked_by"></span></p>
							</div>
							<div class="form_right_confirm">
								<div class="sign_box">
								</div>
							</div>
						</div>
					</div>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<style>
					.form_notice{}
					.form_remarks{margin-bottom:10px;padding:0px 10px;}
					.form_remarks p{line-height:125%;}
					.form_notes{padding:5px 10px;border:1px solid #000;}
					.form_notes_list{width:100%;display:table;}
					.form_notes_list p{font-size:10px;line-height:120%;}
					.notes_left_list,.notes_right_list{display:table-cell;}
					.notes_left_list{width:15px;}
					</style>
					<div class="form_notice">
						<div class="form_remarks">
							<p><strong>Remarks :<br/>All special request are subject to availability upon arrival</strong><br/>&nbsp;</p>
							<p style="text-align:right;"><strong>Call our Customer Service Center 24/7 :</strong><br/>1500 107<br/>
								(Long distance charge may apply)</p>
						</div>
						<div class="form_notes">
							<p style="margin-bottom:5px;"><strong>Notes :</strong></p>
							<div class="form_notes_list">
								<p class="notes_left_list">&#9679;</p>
								<p class="notes_right_list"><span style="color:#f00;">IMPORTANT : </span>At check-in, you must present the credit card used to
									make this booking and a valid photo ID with the same name. Failure to do so may result in the property requesting additional
									payment or your reservation not being honored. If you have submitted additional documentation for a third party booking or
									paid via a different payment method, please disregard the note above.</p>
							</div>
							<div class="form_notes_list">
								<p class="notes_left_list">&#9679;</p>
								<p class="notes_right_list">All rooms are guaranteed on the day of arrival. In the case of a no-show, your room(s) will be
									released and you will be subject to the terms and conditions of the cancellation/no-show Policy specified at the time you
									made the booking as well as noted in the confirmation Email.</p>
							</div>
							<div class="form_notes_list">
								<p class="notes_left_list">&#9679;</p>
								<p class="notes_right_list">The total price for this booking does not include mini-bar items, telephone usage, laundry service,
									etc. The property will bill you directly.</p>
							</div>
							<div class="form_notes_list">
								<p class="notes_left_list">&#9679;</p>
								<p class="notes_right_list">In cases where Breakfast is included with the room rate, please note that certain properties may
									charge extra for children travelling with their parents. If applicable, the property will bill you directly. Upon arrival, if
									you have any questions, please verify with the property.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
