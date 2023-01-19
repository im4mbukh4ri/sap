@extends('layouts.public')
@section('css')
	@parent
	<link rel="stylesheet" href="{{asset('/assets/css/public/sweetalert.css')}}">
@endsection
@section('content')
	<section id="chooseFlight2" class="main-table" style="padding-bottom: 0">
			<div class="container">
					<div class="row">
						<div class="col-md-12">
							<h3 class="blue-title-big">Detail Transaksi {{ $transaction->id }}</h3>
							<br>
							<div class="rangkuman-table">
								<h2>Penerbangan yang dipilih:</h2>
								<div class="row nopadding result-row">
									<div class="col-md-9 nopadding item-result" @if($transaction->trip_type_id!="R")style="height: 78px;"@endif>
										<div class="left-result">
											@if(count($transaction->bookings)==1)
												@if($transaction->trip_type_id=='R')
													@foreach($transaction->bookings as $key => $booking)
														@for($i=0;$i<=1;$i++)
                                                            <?php
($i == 0) ? $departReturnId = 'd' : $departReturnId = 'r';
$itineraries = $booking->itineraries()->where('depart_return_id', $departReturnId);
$flights = $itineraries->get();
$countFlight = count($flights);
if ($departReturnId == 'd') {
    $std = getAirport($booking->origin);
    $sta = getAirport($booking->destination);
} else {
    $std = getAirport($booking->destination);
    $sta = getAirport($booking->origin);
}
$etd = $itineraries->first()->etd;
$stop = $itineraries->first()->stop;
$eta = $itineraries->get()->first()->eta;
$dateEtd = date("Y-m-d", strtotime($etd));
$dateEta = date("Y-m-d", strtotime($eta));

?>
															<div class="row row-resultnya result-berangkat">
																<div class="col-sm-2 col-md-2 inline-row t1 text-center">
																	<img class="logoFlightFrom-top" width="auto" height="auto" src="{{asset('/assets/logo/'.getLogo($itineraries->first()->flight_number).'.png')}}" title="" alt="">
																</div>
																<div class="col-sm-4 col-md-4 inline-row">
																	<p><strong>Pergi:</strong>  {{$std->city}} ({{$std->id}})  ke  {{$sta->city}} ({{$sta->id}})<br>
																		{{myDay($dateEtd)}}, {{date('d',strtotime($dateEtd))}} {{myMonth($dateEtd)}}</p>
																	<small class="codeFrom-top">@foreach($flights as $flight) {{ $flight->flight_number }} @endforeach</small>
																</div>
																<div class="col-sm-2 col-md-2 inline-row text-center">
																	<h4 class="timeFrom-top">{{date("H:i",strtotime($etd))}}</h4>
																	<p class="cityFrom-top">{{$std->city}} ({{$std->id}})</p>
																</div>
																<div class="col-md-2 inline-row text-center">
																	<h4 class="timeFin">{{date("H:i",strtotime($eta))}}</h4>
																	<p class="cityFrom-top">{{$sta->city}} ({{$sta->id}})</p>
																</div>
																<div class="col-sm-2 col-md-2 inline-row">
																	<a class="show-notice">
																		@if($countFlight-1 == 0)
																			@if($stop == '0')
																				<p class="transit">Langsung</p>
																			@else
																				<p class="transit">{{$stop}} Stop</p>
																			@endif
																		@else
																			<p class="transit">{{$countFlight-1}} Transit</p>
																		@endif
																	</a>
																</div>
															</div>
														@endfor
													@endforeach
												@else
													@foreach ($transaction->bookings as $key => $booking)
                                                        <?php
($key == 0) ? $departReturnId = 'd' : $departReturnId = 'r';
$itineraries = $booking->itineraries()->where('depart_return_id', $departReturnId);
$flights = $itineraries->get();
$countFlight = count($flights);
$std = getAirport($booking->origin);
$sta = getAirport($booking->destination);
$etd = $itineraries->first()->etd;
$stop = $itineraries->first()->stop;
$eta = $itineraries->get()->first()->eta;
$dateEtd = date("Y-m-d", strtotime($etd));
$dateEta = date("Y-m-d", strtotime($eta));

?>
														<div class="row row-resultnya result-berangkat">
															<div class="col-sm-2 col-md-2 inline-row t1 text-center">
																<img class="logoFlightFrom-top" width="auto" height="auto" src="{{asset('/assets/logo/'.getLogo($itineraries->first()->flight_number).'.png')}}" title="" alt="">
															</div>
															<div class="col-sm-4 col-md-4 inline-row">
																<p><strong>Pergi:</strong>  {{$std->city}} ({{$std->id}})  ke  {{$sta->city}} ({{$sta->id}})<br>
																	{{myDay($dateEtd)}}, {{date('d',strtotime($dateEtd))}} {{myMonth($dateEtd)}}</p>
																<small class="codeFrom-top">@foreach($flights as $flight) {{ $flight->flight_number }} @endforeach</small>
															</div>
															<div class="col-sm-2 col-md-2 inline-row text-center">
																<h4 class="timeFrom-top">{{date("H:i",strtotime($etd))}}</h4>
																<p class="cityFrom-top">{{$std->city}} ({{$std->id}})</p>
															</div>
															<div class="col-md-2 inline-row text-center">
																<h4 class="timeFin">{{date("H:i",strtotime($eta))}}</h4>
																<p class="cityFrom-top">{{$sta->city}} ({{$sta->id}})</p>
															</div>
															<div class="col-sm-2 col-md-2 inline-row">
																<a class="show-notice">
																	@if($countFlight-1 == 0)
																		@if($stop == '0')
																			<p class="transit">Langsung</p>
																		@else
																			<p class="transit">{{$stop}} Stop</p>
																		@endif
																	@else
																		<p class="transit">{{$countFlight-1}} Transit</p>
																	@endif
																</a>
															</div>
														</div>
													@endforeach
												@endif
											@else
												@foreach ($transaction->bookings as $key => $booking)
                                                    <?php
($key == 0) ? $departReturnId = 'd' : $departReturnId = 'r';
$itineraries = $booking->itineraries()->where('depart_return_id', $departReturnId);
$flights = $itineraries->get();
$countFlight = count($flights);
$std = getAirport($booking->origin);
$sta = getAirport($booking->destination);
$etd = $itineraries->first()->etd;
$stop = $itineraries->first()->stop;
$eta = $itineraries->get()->first()->eta;
$dateEtd = date("Y-m-d", strtotime($etd));
$dateEta = date("Y-m-d", strtotime($eta));

?>
													<div class="row row-resultnya result-berangkat">
														<div class="col-sm-2 col-md-2 inline-row t1 text-center">
															<img class="logoFlightFrom-top" width="auto" height="auto" src="{{asset('/assets/logo/'.getLogo($itineraries->first()->flight_number).'.png')}}" title="" alt="">
														</div>
														<div class="col-sm-4 col-md-4 inline-row">
															<p><strong>Pergi:</strong>  {{$std->city}} ({{$std->id}})  ke  {{$sta->city}} ({{$sta->id}})<br>
																{{myDay($dateEtd)}}, {{date('d',strtotime($dateEtd))}} {{myMonth($dateEtd)}}</p>
															<small class="codeFrom-top">@foreach($flights as $flight) {{ $flight->flight_number }} @endforeach</small>
														</div>
														<div class="col-sm-2 col-md-2 inline-row text-center">
															<h4 class="timeFrom-top">{{date("H:i",strtotime($etd))}}</h4>
															<p class="cityFrom-top">{{$std->city}} ({{$std->id}})</p>
														</div>
														<div class="col-md-2 inline-row text-center">
															<h4 class="timeFin">{{date("H:i",strtotime($eta))}}</h4>
															<p class="cityFrom-top">{{$sta->city}} ({{$sta->id}})</p>
														</div>
														<div class="col-sm-2 col-md-2 inline-row">
															<a class="show-notice">
																@if($countFlight-1 == 0)
																	@if($stop == '0')
																		<p class="transit">Langsung</p>
																	@else
																		<p class="transit">{{$stop}} Stop</p>
																	@endif
																@else
																	<p class="transit">{{$countFlight-1}} Transit</p>
																@endif
															</a>
														</div>
													</div>
												@endforeach
											@endif
											</div><!--end.row-->
										</div><!--end.left-result-->
										<div class="col-md-3 nopadding item-result" @if($transaction->trip_type_id=="R")style="height: 184px;"@else style="height: 78px;" @endif>
										<div class="right-result price-summary">
											<p>Total Biaya:</p>
											<h3 id="summary_pricetotal">IDR {{ number_format($transaction->total_fare) }}</h3>
											{{--@if($transaction->bookings->first()->status=='booking')--}}
												{{--<button class="btn btn-lg btn-danger">CANCEL BOOKING</button>--}}
											{{--@endif--}}
										</div>
									</div><!--end.col-md4-->
									</div><!--end.col-md8-->
								</div><!--end.result-row-->
							</div><!--end.rangkuman-->
						</div><!--end.col-->
					</div><!--end.row-->
	</section><!--end.maintable-->
	<section id="form-customer">
			<div class="container">
				<div class="row">
					<div class="col-md-8">
							<div class="left-section">
									<div class="summary-flight">
											<h3 class="orange-title">Data Pemesan</h3>
										<div class="table-responsive">
											<table class="table result-tab">
												<tr>
													<th>Nama Lengkap</th>
													<th>No Telp. / HP</th>
													<th>Email</th>
												</tr>
												<tr>
													<td>{{$transaction->buyer->name}}</td>
													<td>{{$transaction->buyer->phone}}</td>
													<td>{{$transaction->buyer->email}}</td>
												</tr>
											</table>
										</div>
									</div><!--end.summary-flights-->

									<div class="summary-flight">
											<h3 class="orange-title">Penumpang</h3>
										<div class="table-responsive">
											<table class="table result-tab">
												<tr>
													<th>Title</th>
													<th>Nama Depan</th>
													<th>Nama Belakang</th>
													<th>No. Telp</th>
												</tr>
												@foreach($transaction->passengers as $key => $passenger)
													<tr>
														<td>{{$passenger->title}}</td>
														<td>{{$passenger->first_name}}</td>
														<td>{{$passenger->last_name}}</td>
														<td>{{ ($passenger->phone)?$passenger->phone->number:''}}</td>
													</tr>
												@endforeach
											</table>
										</div>
									</div><!--end.summary-flights-->
							</div>
						  <div class="rows">

								  @if($transaction->bookings->first()->status=="failed")
									  <div class="alert-custom alert alert-red alert-dismissible" role="alert">
											<img class="icon-sign" src="{{asset('/assets/images/material/icon-02.png')}}">
											<p><strong>FAILED</strong></p>
									  </div>
								  @endif
								  @if($transaction->bookings->first()->status=="issued")
									<div class="alert-custom alert alert-green alert-dismissible" role="alert">
											<img class="icon-sign" src="{{asset('/assets/images/material/icon-03.png')}}">
											<p><strong>ISSUED</strong></p>
											<br /><br />
											<p><button class="btn btn-blue" id="btnEmail" onclick="showFormEmail()"><i class="fa fa-envelope"> Kirim email e-Ticket</i></button></p>
											<br />
											<div id="formEticket">
												<form method="POST" action="{{route('airlines.send_mail',$transaction->id)}}">
													{{csrf_field()}}
													<div class="form-group">
														<label for="exampleInputEmail1">Alamat Email</label>
		    										<input type="email" name="email" class="form-control" id="emailReceiver" placeholder="Email" required>
													</div>
													<div class="form-group">
														<label for="serviceFee">Service Fee</label>
		    										<input type="number" name="service_fee" class="form-control" id="serviceFee" placeholder="Service Fee ( Opsional )">
													</div>
													<button class="btn btn-orange js-submit-confirm" >Kirim</button>
												</form>
											</div>
									</div>
								  @endif
								  @if($transaction->bookings->first()->status=='waiting-issued')
									  <div class="alert-custom alert alert-orange alert-dismissible" role="alert">
										  <img class="icon-sign" src="{{asset('/assets/images/material/icon-04.png')}}">
										  <p><strong>ISSUED</strong></p>
									  </div>
								  @endif
								  @if($transaction->bookings->first()->status=='booking')
										  <div class="grey-box">
											  <div class="caution-box">
												  <div class="warning-text">
													  <span>Penting:</span>
													  <ul>
														  <li>Pastikan data pemesanan sudah benar. </li>
														  <li>Masukan username dan password login Anda lalu klik tombol issued untuk melakukan issued</li>
													   </ul>
													  <span>Time limit :</span>
													  <h3 style="margin: 0;">{{date("d M y H:i:s",strtotime($transaction->expired))}}</h3>
												  </div>
											  </div>
                                              <?php $pointMax = \App\PointMax::find(1)->point;?>
											  <form class="form-inline" action="{{ route('airlines.issued',$transaction) }}" method="POST">
												  {{ csrf_field() }}
                                                  @if($transaction->user->point > 0)
                                                      <div class="row">
                                                          <div class="alert alert-success" role="alert">Anda memiliki <strong>{{ $transaction->user->point }} Point Reward</strong></div>
                                                      </div>
                                                      <div class="form-group">
														  @if($transaction->user->point >= $pointMax)
															  <label for="point"><input type="checkbox" name="pr" value="3"> Gunakan {{ $pointMax }} Point Reward</label><span>&nbsp;&nbsp;</span>
														  @endif
                                                          {{--<div class="input-group">--}}
                                                              {{--<select name="pr" id="point">--}}
                                                                  {{--<option value="0" selected>0</option>--}}
                                                                  {{--@if($transaction->user->point < $pointMax)--}}
                                                                      {{--@for($i=1;$i<=$transaction->user->point;$i++)--}}
                                                                          {{--<option value="{{$i}}">{{$i}}</option>--}}
                                                                      {{--@endfor--}}
                                                                  {{--@else--}}
                                                                      {{--@for($i=1;$i<=$pointMax;$i++)--}}
                                                                          {{--<option value="{{$i}}">{{$i}}</option>--}}
                                                                      {{--@endfor--}}
                                                                  {{--@endif--}}

                                                              {{--</select>--}}
                                                              {{--<div class="input-group-addon">Point</div>--}}
                                                          {{--</div>--}}
                                                      </div>
                                                  @else
                                                      <input type="hidden" name="pr" value="0">
                                                  @endif
												  <input type="hidden" name="notrx" value="{{ $transaction->bookings->first()->transaction_number->transaction_number }}">
												  <div class="form-group">
													  <label class="sr-only" for="password">Password</label>
													  <input type="password" class="form-control" name="password" id="password" placeholder="Password" autocomplete="off">
												  </div>
												  <button type="submit" class="btn btn-primary">ISSUED</button>
											  </form>
										  </div>
								  @endif
								  @if($transaction->bookings->first()->status=='canceled')
									  <div class="alert-custom alert alert-red alert-dismissible" role="alert">
										  <img class="icon-sign" src="{{asset('/assets/images/material/icon-02.png')}}">
										  <p><strong>CANCELED</strong>.{{(isset($transaction->bookings->first()->failed_message->message)?' NOTE : '.$transaction->bookings->first()->failed_message->message:'')}}</p>
									  </div>
								  @endif
							</div>
					</div>
					<div class="col-md-4">
						<div class="right-section">
							<div class="right-info">
								@if(count($transaction->bookings)==1)
									@if($transaction->trip_type_id=='R')
										@foreach ($transaction->bookings as $key => $booking)
                                            @for($i=0;$i<=1;$i++)
                                                <?php
($i == 0) ? $departReturnId = 'd' : $departReturnId = 'r';
$airlines = $booking->itineraries()->where('depart_return_id', $departReturnId);
$airlinesLists = $airlines->get();
$countFlight = count($airlinesLists);
?>
												@foreach($airlinesLists as $val => $airlineList)
													@if($val==0)
														@if($i!=0)
															<br>
															<h3 class="orange-title" style="background-color: #0C5484">Penerbangan Pulang</h3>
														@else
															<h3 class="orange-title" style="background-color: #0C5484">Penerbangan Pergi</h3>
														@endif
													@endif
													<div class="white-box small-flight" style="padding-top: 0">
														<div class="items-flight-destination">
															<div class="row-detail" >
																<h3 style="text-align: center; margin: 0;color: red;">{{ $airlineList->pnr }}</h3>
                                                                <?php
switch ($booking->status) {
case 'booking':
    echo '<h6 style=\'text-align: center;\'><span class=\'label label-primary\'>BOOKED</span></h6>';
    break;
case 'issued':
    echo '<h6 style=\'text-align: center;\'><span class="label label-success">ISSUED</span></h6>';
    break;
case 'waiting-issued':
    echo '<h6 style=\'text-align: center;\'><span class=\'label label-warning\'>PROSES ISSUED</span></h6>';
    break;
case 'canceled':
    echo '<h6 style=\'text-align: center;\'><span class=\'label label-danger\'>CANCELED</span></h6>';
    break;
case 'process':
    echo '<h6 style=\'text-align: center;\'><span class=\'label label-default\'>LOADING</span></h6>';
    break;
default:
    echo '<h6 style=\'text-align: center;\'><span class=\'label label-danger\'>ERROR</span></h6>';
    break;
}
?>
																<img width="80" src="{{asset('/assets/logo/'.getLogo($airlineList->flight_number).'.png')}}" alt="logo-{{$airlineList->flight_number}}">
																<br>
																<span class="code-penerbangan">{{$airlineList->flight_number}}</span>
															</div>
															<div class="row-detail">
																<div class="timeline-flight">
																	<div class="flight-content">
																		<div class="FlightSegment Origin">
																			<div class="FlightDots">
																				<div class="DotBorder">
																					<div class="DotCircle">
																					</div>
																				</div>
																			</div>
																			<div class="FlightTime">
																				<div class="FlightTimeHour">{{date('H:i',strtotime($airlineList->etd))}}</div>
																				<div class="FlightDate">{{date('D',strtotime($airlineList->etd))}}, {{date('d M',strtotime($airlineList->etd))}}</div>
																			</div>
																			<div class="FlightRoute">
                                                                                <?php $std = getAirport($airlineList->std);?>
																				<div class="FlightCity">{{$std->city}} ({{$std->id}})</div>
																				<div class="FlightAirport">{{$std->name}}</div>
																			</div>
																		</div>
																		<div class="FlightSegment HiddenTransitSegment">
                                                                            <?php
$etd = \Carbon\Carbon::createFromFormat('Y-m-d H:i', date('Y-m-d H:i', strtotime($airlineList->etd)));
$eta = \Carbon\Carbon::createFromFormat('Y-m-d H:i', date('Y-m-d H:i', strtotime($airlineList->eta)));
$h = $etd->diffInHours($eta, false);
$m = $etd->addHours($h)->diffInMinutes($eta, false);
$hShow = $h != "0" ? $h . 'j' : '';
$mShow = $m != "0" ? $m . 'm' : '';
$showTime = $hShow . ' ' . $mShow;
?>
																			<div class="FlightDurationTime"><span class="icon"></span><p class="Duration">{{ $showTime }} <br /> {{$airlineList->stop}} Stop</p></div>
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
																				<div class="FlightTimeHour">{{date('H:i',strtotime($airlineList->eta))}}</div>
																				<div class="FlightDate">{{date('D',strtotime($airlineList->eta))}}, {{date('d M',strtotime($airlineList->eta))}}</div>
																			</div>
																			<div class="FlightRoute">
                                                                                <?php $sta = getAirport($airlineList->sta);?>
																				<div class="FlightCity">{{$sta->city}} ({{$sta->id}})</div>
																				<div class="FlightAirport">{{$sta->name}}</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													@if($val+1<$countFlight)
                                                        <?php
$etd = \Carbon\Carbon::createFromFormat('Y-m-d H:i', date('Y-m-d H:i', strtotime($airlinesLists[$val]->eta)));
$eta = \Carbon\Carbon::createFromFormat('Y-m-d H:i', date('Y-m-d H:i', strtotime($airlinesLists[$val + 1]->etd)));
$h = $etd->diffInHours($eta, false);
$m = $etd->addHours($h)->diffInMinutes($eta, false);
$hShow = $h != "0" ? $h . ' jam' : '';
$mShow = $m != "0" ? $m . ' mnt' : '';
$showTime = $hShow . ' ' . $mShow;
?>
														<h3 class="orange-title"><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="small-title">Transit selama {{ $showTime }} di  {{$sta->city}} ({{$sta->id}})</span></h3>
													@endif
												@endforeach
											@endfor
										@endforeach
									@else
										@foreach ($transaction->bookings as $key => $booking)
                                            <?php
($key == 0) ? $departReturnId = 'd' : $departReturnId = 'r';
$airlines = $booking->itineraries()->where('depart_return_id', $departReturnId);
$airlinesLists = $airlines->get();
$countFlight = count($airlinesLists);
?>
											@foreach($airlinesLists as $val => $airlineList)
												@if($val==0)
													@if($key!=0)
														<br>
														<h3 class="orange-title" style="background-color: #0C5484">Penerbangan Pulang</h3>
													@else
														<h3 class="orange-title" style="background-color: #0C5484">Penerbangan Pergi</h3>
													@endif
												@endif
												<div class="white-box small-flight" style="padding-top: 0">
													<div class="items-flight-destination">
														<div class="row-detail" >
															<h3 style="text-align: center; margin: 0;color: red;">{{ $airlineList->pnr }}</h3>
                                                            <?php
switch ($booking->status) {
case 'booking':
    echo '<h6 style=\'text-align: center;\'><span class=\'label label-primary\'>BOOKED</span></h6>';
    break;
case 'issued':
    echo '<h6 style=\'text-align: center;\'><span class="label label-success">ISSUED</span></h6>';
    break;
case 'waiting-issued':
    echo '<h6 style=\'text-align: center;\'><span class=\'label label-warning\'>PROSES ISSUED</span></h6>';
    break;
case 'canceled':
    echo '<h6 style=\'text-align: center;\'><span class=\'label label-danger\'>CANCELED</span></h6>';
    break;
case 'process':
    echo '<h6 style=\'text-align: center;\'><span class=\'label label-default\'>LOADING</span></h6>';
    break;
default:
    echo '<h6 style=\'text-align: center;\'><span class=\'label label-danger\'>ERROR</span></h6>';
    break;
}
?>
															<img width="80" src="{{asset('/assets/logo/'.getLogo($airlineList->flight_number).'.png')}}" alt="logo-{{$airlineList->flight_number}}">
															<br>
															<span class="code-penerbangan">{{$airlineList->flight_number}}</span>
														</div>
														<div class="row-detail">
															<div class="timeline-flight">
																<div class="flight-content">
																	<div class="FlightSegment Origin">
																		<div class="FlightDots">
																			<div class="DotBorder">
																				<div class="DotCircle">
																				</div>
																			</div>
																		</div>
																		<div class="FlightTime">
																			<div class="FlightTimeHour">{{date('H:i',strtotime($airlineList->etd))}}</div>
																			<div class="FlightDate">{{date('D',strtotime($airlineList->etd))}}, {{date('d M',strtotime($airlineList->etd))}}</div>
																		</div>
																		<div class="FlightRoute">
                                                                            <?php $std = getAirport($airlineList->std);?>
																			<div class="FlightCity">{{$std->city}} ({{$std->id}})</div>
																			<div class="FlightAirport">{{$std->name}}</div>
																		</div>
																	</div>
																	<div class="FlightSegment HiddenTransitSegment">
                                                                        <?php
$etd = \Carbon\Carbon::createFromFormat('Y-m-d H:i', date('Y-m-d H:i', strtotime($airlineList->etd)));
$eta = \Carbon\Carbon::createFromFormat('Y-m-d H:i', date('Y-m-d H:i', strtotime($airlineList->eta)));
$h = $etd->diffInHours($eta, false);
$m = $etd->addHours($h)->diffInMinutes($eta, false);
$hShow = $h != "0" ? $h . 'j' : '';
$mShow = $m != "0" ? $m . 'm' : '';
$showTime = $hShow . ' ' . $mShow;
?>
																		<div class="FlightDurationTime"><span class="icon"></span><p class="Duration">{{ $showTime }} <br />{{$airlineList->stop}} Stop</p></div>
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
																			<div class="FlightTimeHour">{{date('H:i',strtotime($airlineList->eta))}}</div>
																			<div class="FlightDate">{{date('D',strtotime($airlineList->eta))}}, {{date('d M',strtotime($airlineList->eta))}}</div>
																		</div>
																		<div class="FlightRoute">
                                                                            <?php $sta = getAirport($airlineList->sta);?>
																			<div class="FlightCity">{{$sta->city}} ({{$sta->id}})</div>
																			<div class="FlightAirport">{{$sta->name}}</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												@if($val+1<$countFlight)
                                                    <?php
$etd = \Carbon\Carbon::createFromFormat('Y-m-d H:i', date('Y-m-d H:i', strtotime($airlinesLists[$val]->eta)));
$eta = \Carbon\Carbon::createFromFormat('Y-m-d H:i', date('Y-m-d H:i', strtotime($airlinesLists[$val + 1]->etd)));
$h = $etd->diffInHours($eta, false);
$m = $etd->addHours($h)->diffInMinutes($eta, false);
$hShow = $h != "0" ? $h . ' jam' : '';
$mShow = $m != "0" ? $m . ' mnt' : '';
$showTime = $hShow . ' ' . $mShow;
?>
													<h3 class="orange-title"><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="small-title">Transit selama {{ $showTime }} di  {{$sta->city}} ({{$sta->id}})</span></h3>
												@endif
											@endforeach
										@endforeach
									@endif
								@else
									@foreach ($transaction->bookings as $key => $booking)
                                        <?php
($key == 0) ? $departReturnId = 'd' : $departReturnId = 'r';
$airlines = $booking->itineraries()->where('depart_return_id', $departReturnId);
$airlinesLists = $airlines->get();
$countFlight = count($airlinesLists);
?>
										@foreach($airlinesLists as $val => $airlineList)
											@if($val==0)
												@if($key!=0)
													<br>
													<h3 class="orange-title" style="background-color: #0C5484">Penerbangan Pulang</h3>
												@else
													<h3 class="orange-title" style="background-color: #0C5484">Penerbangan Pergi</h3>
												@endif
											@endif
											<div class="white-box small-flight" style="padding-top: 0">
												<div class="items-flight-destination">
													<div class="row-detail" >
														<h3 style="text-align: center; margin: 0;color: red;">{{ $airlineList->pnr }}</h3>
                                                        <?php
switch ($booking->status) {
case 'booking':
    echo '<h6 style=\'text-align: center;\'><span class=\'label label-primary\'>BOOKED</span></h6>';
    break;
case 'issued':
    echo '<h6 style=\'text-align: center;\'><span class="label label-success">ISSUED</span></h6>';
    break;
case 'waiting-issued':
    echo '<h6 style=\'text-align: center;\'><span class=\'label label-warning\'>PROSES ISSUED</span></h6>';
    break;
case 'canceled':
    echo '<h6 style=\'text-align: center;\'><span class=\'label label-danger\'>CANCELED</span></h6>';
    break;
case 'process':
    echo '<h6 style=\'text-align: center;\'><span class=\'label label-default\'>LOADING</span></h6>';
    break;
default:
    echo '<h6 style=\'text-align: center;\'><span class=\'label label-danger\'>ERROR</span></h6>';
    break;
}
?>
														<img width="80" src="{{asset('/assets/logo/'.getLogo($airlineList->flight_number).'.png')}}" alt="logo-{{$airlineList->flight_number}}">
														<br>
														<span class="code-penerbangan">{{$airlineList->flight_number}}</span>
													</div>
													<div class="row-detail">
														<div class="timeline-flight">
															<div class="flight-content">
																<div class="FlightSegment Origin">
																	<div class="FlightDots">
																		<div class="DotBorder">
																			<div class="DotCircle">
																			</div>
																		</div>
																	</div>
																	<div class="FlightTime">
																		<div class="FlightTimeHour">{{date('H:i',strtotime($airlineList->etd))}}</div>
																		<div class="FlightDate">{{date('D',strtotime($airlineList->etd))}}, {{date('d M',strtotime($airlineList->etd))}}</div>
																	</div>
																	<div class="FlightRoute">
                                                                        <?php $std = getAirport($airlineList->std);?>
																		<div class="FlightCity">{{$std->city}} ({{$std->id}})</div>
																		<div class="FlightAirport">{{$std->name}}</div>
																	</div>
																</div>
																<div class="FlightSegment HiddenTransitSegment">
                                                                    <?php
$etd = \Carbon\Carbon::createFromFormat('Y-m-d H:i', date('Y-m-d H:i', strtotime($airlineList->etd)));
$eta = \Carbon\Carbon::createFromFormat('Y-m-d H:i', date('Y-m-d H:i', strtotime($airlineList->eta)));
$h = $etd->diffInHours($eta, false);
$m = $etd->addHours($h)->diffInMinutes($eta, false);
$hShow = $h != "0" ? $h . 'j' : '';
$mShow = $m != "0" ? $m . 'm' : '';
$showTime = $hShow . ' ' . $mShow;
?>
																	<div class="FlightDurationTime"><span class="icon"></span><p class="Duration">{{ $showTime }} <br /> {{$airlineList->stop}} Stop</p></div>
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
																		<div class="FlightTimeHour">{{date('H:i',strtotime($airlineList->eta))}}</div>
																		<div class="FlightDate">{{date('D',strtotime($airlineList->eta))}}, {{date('d M',strtotime($airlineList->eta))}}</div>
																	</div>
																	<div class="FlightRoute">
                                                                        <?php $sta = getAirport($airlineList->sta);?>
																		<div class="FlightCity">{{$sta->city}} ({{$sta->id}})</div>
																		<div class="FlightAirport">{{$sta->name}}</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											@if($val+1<$countFlight)
                                                <?php
$etd = \Carbon\Carbon::createFromFormat('Y-m-d H:i', date('Y-m-d H:i', strtotime($airlinesLists[$val]->eta)));
$eta = \Carbon\Carbon::createFromFormat('Y-m-d H:i', date('Y-m-d H:i', strtotime($airlinesLists[$val + 1]->etd)));
$h = $etd->diffInHours($eta, false);
$m = $etd->addHours($h)->diffInMinutes($eta, false);
$hShow = $h != "0" ? $h . ' jam' : '';
$mShow = $m != "0" ? $m . ' mnt' : '';
$showTime = $hShow . ' ' . $mShow;
?>
												<h3 class="orange-title"><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="small-title">Transit selama {{ $showTime }} di  {{$sta->city}} ({{$sta->id}})</span></h3>
											@endif
										@endforeach
									@endforeach
								@endif
							</div><!--end.right-info-->
						</div><!--end.right-section-->
					</div>
				</div>
			</div>
	</section>
@endsection
@section('js')
	@parent
	<script src="{{asset('/assets/js/public/sweetalert.min.js')}}"></script>
	<script>

		$(document).ready(function(){
			$("#formEticket").hide();
			$(document.body).on('click', '.js-submit-confirm', function (event) {
					event.preventDefault();
					var $form = $(this).closest('form');
					var $el = $(this);
					var email = $("#emailReceiver").val();
					var fee = $("#serviceFee").val();
					if(fee==""||fee=="0"){
						fee="Tidak ada service fee"
					}else{
						fee="Service Fee Rp"+addCommas(fee);
					}
					var text = $el.data('confirm-message') ? $el.data('confirm-message') : 'Silahkan isi service fee (Opsional) !';
					swal({
							title: "Apakah email dan service fee sudah benar?",
							text: "Email : "+email+" & "+fee,
							type: "warning",
							showCancelButton: true,
							confirmButtonColor: "#0c5484",
							confirmButtonText: "Kirim!",
							closeOnConfirm: false,
							cancelButtonText: 'Batal'
					},
					function () {
							$form.submit();

							swal("Kirim Email","Email telah dikirim.", "success");

					})
			});
		});
		function showFormEmail(){
			$("#formEticket").slideDown();
		}
		function addCommas(nStr)
		{
		    nStr += '';
		    x = nStr.split('.');
		    x1 = x[0];
		    x2 = x.length > 1 ? '.' + x[1] : '';
		    var rgx = /(\d+)(\d{3})/;
		    while (rgx.test(x1)) {
		        x1 = x1.replace(rgx, '$1' + ',' + '$2');
		    }
		    return x1 + x2;
		}
	</script>
@endsection
