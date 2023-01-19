@extends('layouts.public')
@section('css')
    @parent

@endsection
@section('content')
<!-- STEP BOOKING -->
<?php
$result = json_decode($request['result'], true);
$std = getStation($result['org']);
$sta = getStation($result['des']);
$indexTrain = $request['indexTrain'];
$indexFare = $request['indexFare'];
$etd = date('H:i', strtotime($result['schedule']['departure'][$indexTrain]['ETD']));
$eta = date('H:i', strtotime($result['schedule']['departure'][$indexTrain]['ETA']));
if ($result['trip'] == "R") {
	$indexTrainRet = $request['indexTrainRet'];
	$indexFareRet = $request['indexFareRet'];
	$etdRet = date('H:i', strtotime($result['schedule']['return'][$indexTrainRet]['ETD']));
	$etaRet = date('H:i', strtotime($result['schedule']['return'][$indexTrainRet]['ETA']));
}
?>
    <div id="step-booking">
        <div class="container">
            <ul class="breadcrumb-step">
                <li class="done">
                    <a href="javascript:void(0)">
                        1. Pilih Tiket
                    </a>
                </li>
                <li class="active">
                    <a href="javascript:void(0)">
                        2. Isi Data
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        3. Pilih Kursi
                    </a>
                </li>
            </ul>
        </div><!--end.container-->
    </div><!--end.stepbooking-->
    <section id="chooseFlight2" class="main-table">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="rangkuman-table">
                        <h2>Kereta yang dipilih:</h2>
                        <div class="row nopadding result-row">
                            <div class="col-md-9 nopadding item-result" @if($result['trip']!="R")style="height: 80px;"@endif>
                                <div class="left-result">
                                    <div class="row row-resultnya result-berangkat">
                                        <div class="col-sm-2 col-md-2 inline-row t1">
                                            <img class="logoFlightFrom-top" width="auto" height="50px" src="{{asset('/assets/logo/kai.png')}}" alt="logo-kai">
                                        </div>
                                        <div class="col-sm-4 col-md-4 inline-row">
                                            <p><strong>Pergi:</strong>{{$std->city}}  ke  {{$sta->city}}<br>
                                                {{myDay($result['tgl_dep'])}}, {{date('d',strtotime($result['tgl_dep']))}} {{myMonth($result['tgl_dep'])}}</p>
                                            <small class="codeFrom-top">{{$result['schedule']['departure'][$indexTrain]['TrainName']}} - {{$result['schedule']['departure'][$indexTrain]['TrainNo']}}</small>
                                        </div>
                                        <div class="col-sm-2 col-md-2 inline-row text-center">
                                            <h4 class="timeFrom-top">{{$etd}}</h4>
                                            <p class="cityFrom-top">{{$std->city}}</p>
                                        </div>
                                        <div class="col-sm-2 col-md-2 inline-row text-center">
                                            <h4 class="timeFin">{{$eta}}</h4>
                                            <p class="cityFrom-top">{{$sta->city}}</p>
                                        </div>
                                        <div class="col-sm-2 col-md-2 inline-row">
                                            <a class="show-notice">
                                                {{$result['schedule']['departure'][$indexTrain]['Fares'][$indexFare]['Class']}} ({{$result['schedule']['departure'][$indexTrain]['Fares'][$indexFare]['SubClass']}})
                                            </a>
                                        </div>

                                    </div><!--end.row-->
                                    @if($result['trip']=="R")
                                        <div class="row row-resultnya result-pulang">
                                            <div class="col-sm-2 col-md-2 inline-row t1">
                                                <img class="logoFlightFrom-top" width="auto" height="50px" src="{{asset('/assets/logo/kai.png')}}" alt="logo-kai">
                                            </div>
                                            <div class="col-sm-4 col-md-4 inline-row">
                                                <p><strong>Pulang:</strong>{{$sta->city}} ke {{$std->city}} <br>
                                                    {{myDay($result['tgl_ret'])}}, {{date('d',strtotime($result['tgl_ret']))}} {{myMonth($result['tgl_ret'])}}</p>
                                                <small class="codeFrom-top">{{$result['schedule']['return'][$indexTrainRet]['TrainName']}} - {{$result['schedule']['return'][$indexTrainRet]['TrainNo']}}</small>
                                            </div>
                                            <div class="col-sm-2 col-md-2 inline-row text-center">
                                               <h4 class="timeFrom-top">{{$etdRet}}</h4>
                                              <p class="cityFrom-top">{{$sta->city}}</p>
                                            </div>
                                            <div class="col-sm-2 col-md-2 inline-row text-center">
                                             <h4 class="timeFin">{{$etaRet}}</h4>
                                              <p class="cityFrom-top">{{$std->city}}</p>
                                            </div>
                                            <div class="col-md-1 inline-row t2">
                                                <a class="show-notice">
                                                    {{$result['schedule']['return'][$indexTrainRet]['Fares'][$indexFareRet]['Class']}} ({{$result['schedule']['return'][$indexTrainRet]['Fares'][$indexFareRet]['SubClass']}})
                                                </a>
                                            </div>

                                        </div><!--end.row-->
                                    @endif
                                </div><!--end.left-result-->
                            </div><!--end.col-md8-->
                            <div class="col-md-3 nopadding item-result"  @if($result['trip']=="R")style="height: 171px;" @else style="height: 80px;" @endif>

                                <div class="right-result price-summary">
                                  <p>Total Biaya:</p>
                                  @if($result['trip']=="O")
                                    <h3 id="summary_pricetotal">IDR {{number_format($result['schedule']['departure'][$indexTrain]['Fares'][$indexFare]['TotalFare'])}}</h3>
                                  @else
                                    <h3 id="summary_pricetotal">IDR {{number_format((int)$result['schedule']['departure'][$indexTrain]['Fares'][$indexFare]['TotalFare']+(int)$result['schedule']['return'][$indexTrainRet]['Fares'][$indexFareRet]['TotalFare'])}}</h3>
                                  @endif
                                </div>
                            </div><!--end.col-md4-->
                        </div><!--end.result-row-->
                    </div><!--end.rangkuman-->
                </div><!--end.col-->
            </div><!--end.row-->
        </div><!--end.container-->
    </section>
    <section id="form-customer">
      <div class="container">
        <div class="row">
          <div class="col-md-8">
            {!! Form::open(['route'=>'trains.set_seat','method'=>'post','id'=>'bookingForm']) !!}
            {!! Form::hidden('org',$result['org']) !!}
            {!! Form::hidden('des',$result['des']) !!}
            {!! Form::hidden('adt',$result['adt']) !!}
            {!! Form::hidden('chd',$result['chd']) !!}
            {!! Form::hidden('inf',$result['inf']) !!}
            {!! Form::hidden('trip',$result['trip']) !!}
            {!! Form::hidden('tgl_dep',$result['tgl_dep']) !!}
            {!! Form::hidden('selectedIDdep',$result['schedule']['departure'][$indexTrain]['Fares'][$indexFare]['selectedIDdep']) !!}
            {!! Form::hidden('indexTrain',$indexTrain) !!}
            {!! Form::hidden('indexFare',$indexFare) !!}
            {!! Form::hidden('result',$request['result']) !!}
            @if($result['trip']=="R")
              {!! Form::hidden('tgl_ret',$result['tgl_ret']) !!}
              {!! Form::hidden('selectedIDret',$request['selectedIDret']) !!}
              {!! Form::hidden('indexTrainRet',$indexTrainRet) !!}
              {!! Form::hidden('indexFareRet',$indexFareRet) !!}
            @endif
            <div class="alert-custom alert alert-red alert-dismissible" role="alert">
                <p><strong>Peringatan !</strong> Pastikan data penumpang yang anda masukkan adalah valid sesuai dengan KTP/Paspor. Jika anda melakukan proses ISSUED dengan data penumpang yang tidak valid / data asal, maka transaksi tersebut akan kami issued, saldo anda akan kami potong. ID anda akan kami suspend (nonaktifkan) dalam kurun waktu tertentu. Terimakasih.</p>
            </div>
            <div class="alert-custom alert alert-red alert-dismissible" role="alert" style="color:white;">
              <span>Penting:</span>
              <ol>
                  <li>Data penumpang harus sesuai KTP / SIM / Passport.</li>
                  <li>No. HP setiap penumpang dewasa tidak boleh sama.</li>
                  <li>Kesalahan dalam penulisan data menjadi tanggung jawab anda.</li>
              </ol>
            </div>
            <div class="left-section">
                <h3 class="blue-title">Data Pemesan:</h3>
                <div class="grey-box">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="buyName">Nama Lengkap <span class="redFont">*</span></label>
                                <input type="text" class="form-control" id="buyName" name="buyName" autocomplete="on" required>
                            </div><!--end.form-grup-->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="buyPhone">No. Telp / HP <span class="redFont">*</span></label>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <input type="text" name="buyPhone" class="form-control" id="buyPhone" autocomplete="on" required>
                                    </div>
                                </div><!--end.row-->
                                <p class="help-block"><i>Contoh: No. Handphone 08123456789</i></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="buyEmail">Alamat Email<span class="redFont">*</span></label>
                                <input type="email" class="form-control" id="buyEmail" name="buyEmail" autocomplete="on" placeholder="Email">
                                <p class="help-block"><i>Contoh: email@example.com</i></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            @for($i=1; $i<=(int)$result['adt'];$i++)
              <div class="left-section">
                  <h3 class="blue-title">Data Penumpang Dewasa {{$i}} :</h3>
                  <div class="grey-box">
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="buyPhone">Nama Lengkap<span class="redFont">*</span></label>
                                  <div class="row">
                                      <div class="col-xs-12">
                                          <input type="text" name="adtName[]" class="form-control" id="name" required>
                                      </div>
                                  </div><!--end.row-->
                                  <p class="help-block"><i><sup>*</sup>Sesuai KTP,SIM,Pasport</i></p>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="buyEmail"> >= 17 tahun nomor ID (KTP,SIM,Pasport)<span class="redFont">*</span></label>
                                  <input type="text" class="form-control" id="noId" name="adtId[]">
                                  <p class="help-block"><i> < 17 tahun jika tidak memiliki ID diisi tanggal lahir format hhbbtttt</i></p>
                              </div>
                          </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="buyPhone">No. Telp / HP <span class="redFont">*</span></label>
                              <div class="row">
                                  <div class="col-xs-12">
                                      <input type="text" name="adtPhone[]" class="form-control" id="adtPhone" required>
                                  </div>
                              </div><!--end.row-->
                              <p class="help-block"><i>Contoh: No. Handphone 08123456789</i></p>
                          </div>
                        </div>
                      </div>
                  </div>
              </div>
            @endfor
            @if((int)$result['inf']>0)
              <hr />
              @for($i=1; $i<=(int)$result['inf'];$i++)
                <div class="left-section">
                    <h3 class="blue-title">Data Penumpang Bayi {{$i}} :</h3>
                    <div class="grey-box">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="buyPhone">Nama Lengkap<span class="redFont">*</span></label>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <input type="text" name="infName[]" class="form-control" id="infName" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              @endfor
            @endif
            <hr>
            <div class="left-section">
              <div class="rows text-right" style="padding: 0;">
                  <div class="col-md-4 col-md-offset-8">
                          <input type="submit" class="btn btn-cari" value="PILIH KURSI">
                  </div>
              </div>
            </div>
            {!! Form::close() !!}
          </div>
          <div class="col-md-4">
            <div class="right-section">
              <div class="right-info">
                <h3 class="orange-title" style="background-color: #0C5484">Pergi <br> <span class="small-title">{{myDay($result['tgl_dep'])}}, {{date("d M y",strtotime($result['tgl_dep']))}}</span></h3>
                <div class="white-box small-flight">
                    <div class="items-flight-destination">
                        <div class="row-detail">
                            <img width="80" src="{{asset('/assets/logo/kai.png')}}" alt="logo-kai"><br>
                            <span class="code-penerbangan">{{$result['schedule']['departure'][$indexTrain]['TrainName']}} - {{$result['schedule']['departure'][$indexTrain]['TrainNo']}}</span>
                        </div><!--end.row-detail-->
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
                                            <div class="FlightTimeHour">{{date('H:i',strtotime($result['schedule']['departure'][$indexTrain]['ETD']))}}</div>
                                            <div class="FlightDate">{{date('D',strtotime($result['schedule']['departure'][$indexTrain]['ETD']))}}, {{date('d M',strtotime($result['schedule']['departure'][$indexTrain]['ETD']))}}</div>
                                        </div>
                                        <div class="FlightRoute">
                                            <div class="FlightCity">{{$std->city}}</div>
                                            <div class="FlightAirport">{{$std->name}}</div>
                                        </div>
                                    </div><!--end.FlightSegment Origin-->
                                    <div class="FlightSegment HiddenTransitSegment">
                                        <?php
$etd = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $result['schedule']['departure'][$indexTrain]['ETD']);
$eta = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $result['schedule']['departure'][$indexTrain]['ETA']);
$h = $etd->diffInHours($eta, false);
$m = $etd->addHours($h)->diffInMinutes($eta, false);
$hShow = $h != "0" ? $h . 'j' : '';
$mShow = $m != "0" ? $m . 'm' : '';
$showTime = $hShow . ' ' . $mShow;
?>
                                        <div class="FlightDurationTime"><span class="icon"></span><p class="Duration"> {{$showTime}}</p></div>
                                        <div class="FlightDotsTransit">
                                            <div class="DotNone">
                                            </div>
                                        </div>
                                        <div class="HiddenTransit">
                                        </div>
                                    </div><!--end.FlightSegment HiddenTransitSegment-->
                                    <div class="FlightSegment Destination">
                                        <div class="FlightDots DotsNone">
                                            <div class="DotBorder">
                                                <div class="DotCircle">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="FlightTime">
                                            <div class="FlightTimeHour">{{date('H:i',strtotime($result['schedule']['departure'][$indexTrain]['ETA']))}}</div>
                                            <div class="FlightDate">{{date('D',strtotime($result['schedule']['departure'][$indexTrain]['ETA']))}}, {{date('d M',strtotime($result['schedule']['departure'][$indexTrain]['ETA']))}}</div>
                                        </div>
                                        <div class="FlightRoute">
                                            <div class="FlightCity">{{$sta->city}}</div>
                                            <div class="FlightAirport">{{$sta->name}}</div>
                                        </div>
                                    </div><!--end.FlightSegment Destination-->
                                </div><!--end.flight-content-->
                            </div><!--end.timeline-floght-->
                        </div><!--end.row-detail-->
                    </div><!--end.flight-destination-->
                </div>
                @if($result['trip']=="R")
                  <h3 class="orange-title" style="background-color: #0C5484">Pulang <br> <span class="small-title">{{myDay($result['tgl_ret'])}}, {{date("d M y",strtotime($result['tgl_ret']))}}</span></h3>
                  <div class="white-box small-flight">
                      <div class="items-flight-destination">
                          <div class="row-detail">
                              <img width="80" src="{{asset('/assets/logo/kai.png')}}" alt="logo-kai"><br>
                              <span class="code-penerbangan">{{$result['schedule']['return'][$indexTrainRet]['TrainName']}} - {{$result['schedule']['return'][$indexTrainRet]['TrainNo']}}</span>
                          </div><!--end.row-detail-->
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
                                              <div class="FlightTimeHour">{{date('H:i',strtotime($result['schedule']['return'][$indexTrainRet]['ETD']))}}</div>
                                              <div class="FlightDate">{{date('D',strtotime($result['schedule']['return'][$indexTrainRet]['ETD']))}}, {{date('d M',strtotime($result['schedule']['return'][$indexTrainRet]['ETD']))}}</div>
                                          </div>
                                          <div class="FlightRoute">
                                            <div class="FlightCity">{{$sta->city}}</div>
                                            <div class="FlightAirport">{{$sta->name}}</div>
                                          </div>
                                      </div><!--end.FlightSegment Origin-->
                                      <div class="FlightSegment HiddenTransitSegment">
                                          <?php
$etd = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $result['schedule']['return'][$indexTrainRet]['ETD']);
$eta = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $result['schedule']['return'][$indexTrainRet]['ETA']);
$h = $etd->diffInHours($eta, false);
$m = $etd->addHours($h)->diffInMinutes($eta, false);
$hShow = $h != "0" ? $h . 'j' : '';
$mShow = $m != "0" ? $m . 'm' : '';
$showTime = $hShow . ' ' . $mShow;
?>
                                          <div class="FlightDurationTime"><span class="icon"></span><p class="Duration"> {{$showTime}}</p></div>
                                          <div class="FlightDotsTransit">
                                              <div class="DotNone">
                                              </div>
                                          </div>
                                          <div class="HiddenTransit">
                                          </div>
                                      </div><!--end.FlightSegment HiddenTransitSegment-->
                                      <div class="FlightSegment Destination">
                                          <div class="FlightDots DotsNone">
                                              <div class="DotBorder">
                                                  <div class="DotCircle">
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="FlightTime">
                                              <div class="FlightTimeHour">{{date('H:i',strtotime($result['schedule']['return'][$indexTrainRet]['ETA']))}}</div>
                                              <div class="FlightDate">{{date('D',strtotime($result['schedule']['return'][$indexTrainRet]['ETA']))}}, {{date('d M',strtotime($result['schedule']['return'][$indexTrainRet]['ETA']))}}</div>
                                          </div>
                                          <div class="FlightRoute">
                                            <div class="FlightCity">{{$std->city}}</div>
                                            <div class="FlightAirport">{{$std->name}}</div>
                                          </div>
                                      </div><!--end.FlightSegment Destination-->
                                  </div><!--end.flight-content-->
                              </div><!--end.timeline-floght-->
                          </div><!--end.row-detail-->
                      </div><!--end.flight-destination-->
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection

@section('js')
    @parent
@endsection
