@extends('layouts.public')
@section('css')
	@parent
@endsection
@section('content')
	<section id="chooseFlight2" class="main-table" style="padding-bottom: 0">
			<div class="container">
					<div class="row">
						<div class="col-md-12">
							<h3 class="blue-title-big">Detail Transaksi {{ $transaction->id }}</h3>
							<br>
							<div class="rangkuman-table">
								<h2>Kereta yang dipilih:</h2>
								<div class="row nopadding result-row">
									<div class="col-md-9 nopadding item-result" @if($transaction->trip_type_id!="R")style="height: 78px;"@endif>
										<div class="left-result">
                      @foreach ($transaction->bookings as $key => $booking)
                        <div class="row row-resultnya result-berangkat">
                          <div class="col-sm-2 col-md-2 inline-row t1 text-center">
                            <img class="logoFlightFrom-top" width="auto" height="auto" src="{{asset('/assets/logo/railink.png')}}" alt="logo-railink">
                          </div>
                          <div class="col-sm-4 col-md-4 inline-row">
                            <p>
                              @if($booking->depart_return_id=="d")<strong>Pergi:</strong>@else<strong>Pulang:</strong> @endif  {{$booking->origin_station->city}}  ke  {{$booking->destination_station->city}}<br>
                              {{myDay($booking->etd)}}, {{date('d',strtotime($booking->etd))}} {{myMonth($booking->etd)}}</p>
                            <small class="codeFrom-top">{{ $booking->train_name }} - {{$booking->train_number}}</small>
                          </div>
                          <div class="col-sm-2 col-md-2 inline-row text-center">
                            <h4 class="timeFrom-top">{{date("H:i",strtotime($booking->etd))}}</h4>
                            <p class="cityFrom-top">{{$booking->origin_station->city}}<br />{{$booking->origin_station->name}}</p>
                          </div>
                          <div class="col-md-2 inline-row text-center">
                            <h4 class="timeFin">{{date("H:i",strtotime($booking->eta))}}</h4>
                            <p class="cityFrom-top">{{$booking->destination_station->city}}<br />{{$booking->destination_station->name}}</p>
                          </div>
                          <div class="col-sm-2 col-md-2 inline-row">
                            <a class="show-notice">
                              {{ $booking->class }} ({{$booking->subclass}})
                            </a>
                          </div>
                        </div>
                      @endforeach
											</div><!--end.row-->
										</div><!--end.left-result-->
										<div class="col-md-3 nopadding item-result" @if($transaction->trip_type_id=="R")style="height: 150px;"@else style="height: 78px;" @endif>
										<div class="right-result price-summary">
											<p>Total Biaya:</p>
											<h3 id="summary_pricetotal">IDR {{ number_format($transaction->total_fare) }}</h3>
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
													<th>Nama Lengkap</th>
                          <th>Tipe</th>
                          <th>Nomer ID</th>
													<th>No. Telp</th>
													<th>Seat Departure</th>
													@if($transaction->trip_type_id=="R")
														<th>Seat Return</th>
													@endif
												</tr>
												@foreach($transaction->passengers as $key => $passenger)
													<tr>
														<td>{{$passenger->name}}</td>
														<td>{{$passenger->type_passenger->type}}</td>
														<td>{{$passenger->identity_number}}</td>
														<td>{{$passenger->phone}}</td>
														<?php
															$seat=$passenger->passanger_seats->first();
														 ?>
														<td>{{$seat->seat->wagon_code}}- {{$seat->seat->wagon_number}} {{$seat->seat->seat}}</td>
														@if($transaction->trip_type_id=="R")
															<?php
																$seat=$passenger->passanger_seats->last();
															 ?>
															<td>{{$seat->seat->wagon_code}}- {{$seat->seat->wagon_number}} {{$seat->seat->seat}}</td>
														@endif
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
									</div>
								  @endif
								  @if($transaction->bookings->first()->status=='canceled')
									  <div class="alert-custom alert alert-red alert-dismissible" role="alert">
										  <img class="icon-sign" src="{{asset('/assets/images/material/icon-02.png')}}">
										  <p><strong>CANCELED</strong></p>
									  </div>
								  @endif
							</div>
					</div>
					<div class="col-md-4">
						<div class="right-section">
							<div class="right-info">
                @foreach ($transaction->bookings as $key => $booking)
                  @if($booking->depart_return_id=="d")
                    <h3 class="orange-title" style="background-color: #0C5484">Pergi</h3>
                  @else
                    <h3 class="orange-title" style="background-color: #0C5484">Pulang</h3>
                  @endif

                  <div class="white-box small-flight" style="padding-top: 0">
                    <div class="items-flight-destination">
                      <div class="row-detail">
                        <h3 style="text-align: center; margin: 0;color: red;">{{ $booking->pnr }}</h3>
                        <?php
                        switch ($booking->status){
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
                        <img width="80" src="{{asset('/assets/logo/railink.png')}}" alt="logo-railink">
                        <br>
                        <span class="code-penerbangan">{{$booking->train_name}} - {{$booking->train_number}}</span>
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
                                <div class="FlightTimeHour">{{date('H:i',strtotime($booking->etd))}}</div>
                                <div class="FlightDate">{{date('D',strtotime($booking->etd))}}, {{date('d M',strtotime($booking->etd))}}</div>
                              </div>
                              <div class="FlightRoute">
                                <div class="FlightCity">{{$booking->origin_station->city}}</div>
                                <div class="FlightAirport">{{$booking->origin_station->name}}</div>
                              </div>
                            </div>
                            <div class="FlightSegment HiddenTransitSegment">
                              <?php
                              $etd=\Carbon\Carbon::createFromFormat('Y-m-d H:i', date('Y-m-d H:i',strtotime($booking->etd)));
                              $eta=\Carbon\Carbon::createFromFormat('Y-m-d H:i', date('Y-m-d H:i',strtotime($booking->eta)));
                              $h=$etd->diffInHours($eta, false);
                              $m=$etd->addHours($h)->diffInMinutes($eta, false);
                              $hShow= $h!="0"?$h.'j':'';
                              $mShow= $m!="0"?$m.'m':'';
                              $showTime=$hShow.' '.$mShow;
                              ?>
                              <div class="FlightDurationTime"><span class="icon"></span><p class="Duration">{{ $showTime }}</p></div>
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
                                <div class="FlightTimeHour">{{date('H:i',strtotime($booking->eta))}}</div>
                                <div class="FlightDate">{{date('D',strtotime($booking->eta))}}, {{date('d M',strtotime($booking->eta))}}</div>
                              </div>
                              <div class="FlightRoute">
                                <div class="FlightCity">{{$booking->destination_station->city}}</div>
                                <div class="FlightAirport">{{$booking->destination_station->name}}</div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
							</div><!--end.right-info-->

              <!-- -->
						</div><!--end.right-section-->
					</div>
				</div>
			</div>
	</section>
@endsection
@section('js')
	@parent
@endsection
