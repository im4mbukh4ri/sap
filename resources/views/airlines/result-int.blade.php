@extends('layouts.public')
@section('css')
    @parent
    <link href="{{ captcha_layout_stylesheet_url() }}" type="text/css" rel="stylesheet">
@endsection
@section('content')
    <!-- STEP BOOKING -->
    <div id="step-booking">
        <div class="container">
            <ul class="breadcrumb-step">
                <li class="done">
                    <a href="javascript:void(0)">
                        1. Pilih Tiket
                    </a>
                </li>
                <li class="done">
                    <a href="javascript:void(0)">
                        2. Pilih Kelas
                    </a>
                </li>
                <li class="done">
                    <a href="javascript:void(0)">
                        3. Isi Data
                    </a>
                </li>
                <li class="active">
                    <a href="javascript:void(0)">
                        4. Konfirmasi Data
                    </a>
                </li>
            </ul>
        </div><!--end.container-->
    </div><!--end.stepbooking-->

    <!-- END STEP BOOKING -->
    <?php
    $airlines=$result['schedule']['departure'][$index]['Flights'];
    $countFlight=count($airlines);
    $flightNumberDep=getFlightNumber($airlines);
    $std=getAirport($airlines[0]['STD']);
    $etd=date('H:i',strtotime($airlines[0]['ETD']));
    if($countFlight>1){
        $sta=getAirport($airlines[$countFlight-1]['STA']);
        $eta = date('H:i',strtotime($airlines[$countFlight-1]['ETA']));
    }else{
        $sta=getAirport($airlines[0]['STA']);
        $eta=date('H:i',strtotime($airlines[0]['ETA']));
    }
    ?>
    <section id="chooseFlight2" class="main-table">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="rangkuman-table">
                        <h2>Penerbangan yang dipilih:</h2>
                        <div class="row nopadding result-row">
                            <div class="col-md-9 nopadding item-result" @if($result['flight']!="R")style="height: 78px;"@endif>
                                <div class="left-result">
                                    <div class="row row-resultnya result-berangkat">
                                        <div class="col-sm-2 col-md-2 inline-row t1">
                                            <img class="logoFlightFrom-top" width="auto" height="auto" src="{{asset('/assets/logo/'.getLogo($airlines[0]['FlightNo']).'.png')}}" title="" alt="">
                                        </div>
                                        <div class="col-sm-4 col-md-4 inline-row">
                                            <p><strong>Pergi:</strong>  {{$std->city}} ({{$std->id}})  ke  {{$sta->city}} ({{$sta->id}})<br>
                                                {{myDay($result['tgl_dep'])}}, {{date('d',strtotime($result['tgl_dep']))}} {{myMonth($result['tgl_dep'])}}</p>
                                            <small class="codeFrom-top">{{$flightNumberDep}}</small>
                                        </div>
                                        <div class="col-sm-2 col-md-2 inline-row text-center">
                                            <h4 class="timeFrom-top">{{$etd}}</h4>
                                            <p class="cityFrom-top">{{$std->city}} ({{$std->id}})</p>
                                        </div>
                                        <div class="col-sm-2 col-md-2 inline-row text-center">
                                            <h4 class="timeFin">{{$eta}}</h4>
                                            <p class="cityFrom-top">{{$sta->city}} ({{$sta->id}})</p>
                                        </div>
                                        <div class="col-sm-2 col-md-2 inline-row">
                                            <a class="show-notice">
                                                {{$countFlight-1==0?'Langsung':$countFlight-1 .' Transit'}}
                                            </a>
                                        </div>

                                    </div><!--end.row-->
                                    @if($result['flight']=="R")
                                        <?php
                                        $airlinesRet=$result['schedule']['return'][$indexRet]['Flights'];
                                        $countFlightRet=count($airlinesRet);
                                        $flightNumberRet=getFlightNumber($airlinesRet);
                                        $std=getAirport($airlinesRet[0]['STD']);
                                        $etd=date('H:i',strtotime($airlinesRet[0]['ETD']));
                                        if($countFlightRet>1){
                                            $sta=getAirport($airlinesRet[$countFlight-1]['STA']);
                                            $eta = date('H:i',strtotime($airlinesRet[$countFlight-1]['ETA']));
                                        }else{
                                            $sta=getAirport($airlinesRet[0]['STA']);
                                            $eta=date('H:i',strtotime($airlinesRet[0]['ETA']));
                                        }
                                        ?>
                                        <div class="row row-resultnya result-pulang">
                                            <div class="col-sm-2 col-md-2 inline-row t1">
                                                <img class="logoFlightFrom-top" width="auto" height="auto" src="{{asset('/assets/logo/'.getLogo($airlinesRet[0]['FlightNo']).'.png')}}" title="" alt="">
                                            </div>
                                            <div class="col-sm-4 col-md-4 inline-row">
                                                <p><strong>Pulang:</strong>  {{$std->city}} ({{$std->id}})  ke  {{$sta->city}} ({{$sta->id}})<br>
                                                    {{myDay($result['tgl_ret'])}}, {{date('d',strtotime($result['tgl_ret']))}} {{myMonth($result['tgl_ret'])}}</p>
                                                <small class="codeFrom-top">{{$flightNumberRet}}</small>
                                            </div>
                                            <div class="col-sm-2 col-md-2 inline-row text-center">
                                                <h4 class="timeFrom-top">{{$etd}}</h4>
                                                <p class="cityFrom-top">{{$std->city}} ({{$std->id}})</p>
                                            </div>
                                            <div class="col-sm-2 col-md-2 inline-row text-center">
                                                <h4 class="timeFin">{{$eta}}</h4>
                                                <p class="cityFrom-top">{{$sta->city}} ({{$sta->id}})</p>
                                            </div>
                                            <div class="col-sm-2 col-md-2 inline-row">
                                                <a class="show-notice">
                                                    {{$countFlightRet-1==0?'Langsung':$countFlightRet-1 .' Transit'}}
                                                </a>
                                            </div>

                                        </div><!--end.row-->
                                    @endif

                                </div><!--end.left-result-->
                            </div><!--end.col-md8-->
                            <div class="col-md-3 nopadding item-result" @if($result['flight']=="R")style="height: 183px;"@else style="height: 78px;" @endif>
                                <div class="right-result price-summary">
                                    <p>Total Biaya:</p>
                                    <h3 id="summary_pricetotal">IDR {{number_format($request['totalFare'])}}</h3>
                                </div>
                            </div><!--end.col-md4-->
                        </div><!--end.result-row-->
                    </div><!--end.rangkuman-->
                </div><!--end.col-->
            </div><!--end.row-->
        </div><!--end.container-->
    </section><!--end.maintable-->
    <section id="form-customer">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="alert-custom alert alert-red alert-dismissible" role="alert">
                        <p><strong>Peringatan !</strong> Pastikan data penumpang yang anda masukkan adalah valid sesuai dengan KTP/Paspor. Jika anda melakukan proses BOOKING dengan data penumpang yang tidak valid / data asal, maka transaksi tersebut akan kami issued, saldo anda akan kami potong. ID anda akan kami suspend (nonaktifkan) dalam kurun waktu tertentu. Terimakasih.</p>
                    </div>
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
                                        <td>{{$request['buyName']}}</td>
                                        <td>{{$request['buyPhone']}}</td>
                                        <td>{{$request['buyEmail']}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div><!--end.summary-flights-->

                        <div class="summary-flight">
                            <h3 class="orange-title">Penumpang Dewasa</h3>
                            <div class="table-responsive">
                                <table class="table result-tab">
                                    <tr>
                                        <th>Title</th>
                                        <th>Nama Depan</th>
                                        <th>Nama Belakang</th>
                                        <th>No. Telp</th>
                                        @if(isset($request['number']))
                                            <th>No. Passport</th>
                                        @endif
                                    </tr>
                                    @foreach($request['adtTitle'] as $key => $adt)
                                        <tr>
                                            <td>{{$adt}}</td>
                                            <td>{{$request['adtFirstName'][$key]}}</td>
                                            <td>{{$request['adtLastName'][$key]}}</td>
                                            <td>{{$request['adtPhone'][$key]}}</td>
                                            @if(isset($request['number']))
                                                <td>{{ $request['number'][$key] }}</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        @if(isset($request['chdTitle']))
                            <div class="summary-flight">
                                <h3 class="orange-title">Penumpang Anak</h3>
                                <div class="table-responsive">
                                    <table class="table result-tab">
                                        <tr>
                                            <th>Title</th>
                                            <th>Nama Depan</th>
                                            <th>Nama Belakang</th>
                                            <th>Tgl. Lahir</th>
                                        </tr>
                                        @foreach($request['chdTitle'] as $key => $adt)
                                            <tr>
                                                <td>{{$adt}}</td>
                                                <td>{{$request['chdFirstName'][$key]}}</td>
                                                <td>{{$request['chdLastName'][$key]}}</td>
                                                <td>{{$request['chdDate'][$key]}}-{{$request['chdMonth'][$key]}}-{{$request['chdYear'][$key]}}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        @endif
                        @if(isset($request['infTitle']))
                            <div class="summary-flight">
                                <h3 class="orange-title">Penumpang Bayi</h3>
                                <div class="table-responsive">
                                    <table class="table result-tab">
                                        <tr>
                                            <th>Title</th>
                                            <th>Nama Depan</th>
                                            <th>Nama Belakang</th>
                                            <th>Tgl. Lahir</th>
                                        </tr>
                                        @foreach($request['infTitle'] as $key => $adt)
                                            <tr>
                                                <td>{{$adt}}</td>
                                                <td>{{$request['infFirstName'][$key]}}</td>
                                                <td>{{$request['infLastName'][$key]}}</td>
                                                <td>{{$request['infDate'][$key]}}-{{$request['infMonth'][$key]}}-{{$request['infYear'][$key]}}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="rows">
                        <div class="grey-box"  id="resultTransaction">
                            <div class="caution-box">
                                <div class="warning-text">
                                    <span>Penting:</span>
                                    <ol>
                                        <li>Data penumpang harus sesuai KTP (Domestik) atau Passport (International).</li>
                                        <li>Kesalahan dalam penulisan data menjadi tanggung jawab anda.</li>
                                        <li>Pengisian nama penumpang harus lebih dari satu huruf.</li>
                                        <li>Pastikan kontak pemesan dan kontak penumpang dapat dihubungi. Jika ada perubahan jadwal dari pihak maskapai, maka akan diinformasikan melalui kontak tersebut.</li>
                                    </ol>

                                </div>
                            </div><!--end.caution-box-->
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" v-model="term" v-bind:true="true" v-bind:false="false"> Saya Memastikan bahwa data yang saya masukan adalah benar dan saya bertanggung jawab atas data yang telah saya masukan. Saya telah membaca dan menyetujui <a href="{{ route('sip.term') }}" target="_blank">Syarat dan Ketentuan SIP</a>.<br> <span class="label label-danger" v-show="errorTerm">Anda belum menyetujui syarat dan ketentuan SIP.</span>

                                </label>
                            </div>
                            <div class="captcha col-md-4 col-md-offset-8">
                                {{--<img src="http://mfebriansyah.com/tiketcom/images/material/captcha.jpg" class="captcha-box">--}}

                                <div class="form-group">

                                    {{-- <div class="BDC_CaptchaDiv" id="ExampleCaptcha_CaptchaDiv" style="width:230px; height:50px;"><!--
 --><div class="BDC_CaptchaImageDiv" id="ExampleCaptcha_CaptchaImageDiv" style="width:200px !important; height:50px !important;"><!--
   --><div class="BDC_CaptchaImageDiv" style="width:200px; height:40px;"><img class="BDC_CaptchaImage" id="ExampleCaptcha_CaptchaImage" src="{{url('/')}}/captcha-handler?get=image&amp;c=examplecaptcha&amp;t=d8c3f2302807e2d38d79910fba11f236" alt="Retype the CAPTCHA code from the image" /></div><!--
   --><!--
 --></div><!--
 --><div class="BDC_CaptchaIconsDiv" id="ExampleCaptcha_CaptchaIconsDiv" style="width: 24px !important;"><!--
   --><a class="BDC_ReloadLink" id="ExampleCaptcha_ReloadLink" href="#" onclick="ExampleCaptcha.ReloadImage(); this.blur(); return false;" title="Change the CAPTCHA code"><img class="BDC_ReloadIcon" id="ExampleCaptcha_ReloadIcon" src="{{url('/')}}/captcha-handler?get=bdc-reload-icon.gif" alt="Change the CAPTCHA code" /></a><!--
   --><a rel="nofollow" class="BDC_SoundLink" id="ExampleCaptcha_SoundLink" href="//sip.dev/captcha-handler?get=sound&amp;c=examplecaptcha&amp;t=d8c3f2302807e2d38d79910fba11f236" onclick="ExampleCaptcha.PlaySound(); this.blur(); return false;" title="Speak the CAPTCHA code" target="_blank"><img class="BDC_SoundIcon" id="ExampleCaptcha_SoundIcon" src="{{url('/')}}/captcha-handler?get=bdc-sound-icon.gif" alt="Speak the CAPTCHA code" /></a><!--
   --><div class="BDC_Placeholder" id="ExampleCaptcha_AudioPlaceholder">&nbsp;</div><!--
 --></div> --}}

                                        {{-- <input type="hidden" name="BDC_UserSpecifiedCaptchaId" id="BDC_UserSpecifiedCaptchaId" value="ExampleCaptcha" />
                                        <input type="hidden" name="BDC_VCID_ExampleCaptcha" id="BDC_VCID_ExampleCaptcha" value="d8c3f2302807e2d38d79910fba11f236" />
                                        <input type="hidden" name="BDC_BackWorkaround_ExampleCaptcha" id="BDC_BackWorkaround_ExampleCaptcha" value="0" /> --}}
                                        <input type="text" class="form-control " v-model="CaptchaCode" id="CaptchaCode" name="CaptchaCode" placeholder="Password">
                                        &nbsp;
                                            @if($request['user_point'] > 0)
                                                <div class="row">
                                                    <div class="alert alert-success" role="alert">Anda memiliki <strong>{{ $request['user_point'] }} Point Reward</strong></div>
                                                </div>
                                                @if($request['user_point']>=$request['max_point'])
                                                    <div class="form-inline">
                                                        <div class="form-group">
                                                            <label for="point">Gunakan Point Reward : </label>
                                                            <div class="input-group">
                                                                <select name="pr" id="point" v-model="pr">
                                                                    <option>0</option>
                                                                    <option>{{$request['max_point']}}</option>
                                                                    {{--@if($request['user_point'] < $request['max_point'])--}}
                                                                    {{--@for($i=1;$i<=$request['user_point'];$i++)--}}
                                                                    {{--<option>{{$i}}</option>--}}
                                                                    {{--@endfor--}}
                                                                    {{--@else--}}
                                                                    {{--@for($i=1;$i<=$request['max_point'];$i++)--}}
                                                                    {{--<option>{{$i}}</option>--}}
                                                                    {{--@endfor--}}
                                                                    {{--@endif--}}

                                                                </select>
                                                                <div class="input-group-addon">Point</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <br>
                                            @endif
                                            <button v-on:click="airlinesTransaction" class="btn btn-orange full-width pull-right" id="btnBookIssued">ISSUED</button>
                                    {{-- </div> --}}
                                </div><!--end.form-grup-->
                            </div><!--end.captcha-->
                            <div class="rows">
                                <div id="transactionLoader">
                                    <div class="row">
                                        <div class="col-md-2 col-md-offset-5"><img src='{{asset('/assets/images/Preloader_2.gif')}}' style='height: auto;width:auto;' class='img-responsive'></div>
                                    </div>
                                </div>

                                <div v-if="failed" >
                                    <div class="rows">
                                        <div class="alert-custom alert alert-red alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <img class="icon-sign" src="{{asset('/assets/images/material/icon-02.png')}}">
                                            <p><strong>Opps!</strong> Terjadi kesalahan</p>
                                        </div><!--end.alert-->
                                    </div>
                                </div>

                                <div v-if="wrongCaptcha">
                                    <div class="alert-custom alert alert-red alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <img class="icon-sign" src="{{asset('/assets/images/material/icon-02.png')}}">
                                        <p><strong>Opps!</strong> @{{ result.status.message }}</p>
                                    </div><!--end.alert-->
                                </div>
                                    <div v-if="success" >
                                        <div class="rows">
                                            <div class="alert-custom alert alert-green alert-dismissible" role="alert">
                                                <img class="icon-sign" src="{{asset('/assets/images/material/icon-03.png')}}" style="vertical-align: top;">
                                                <p><strong>Issued Berhasil!</strong><br>Silahkan klik data transaksi di bawah ini. <br><a href="{{route('airlines.reports')}}" class="btn btn-cari">DATA TRANSAKSI</a></p>
                                            </div><!--end.alert-->
                                        </div>
                                    </div>
                            </div>
                        </div><!--end.grey-box-->
                    </div><!--end.rows-->
                </div>
                <div class="col-md-4">
                    <div class="right-section">
                        <div class="right-info">
                            <h3 class="orange-title" style="background-color: #0C5484">Penerbangan Pergi <br> <span class="small-title">{{myDay($result['tgl_dep'])}}, {{date("d M y",strtotime($result['tgl_dep']))}}</span></h3>
                            <?php $airlines=$result['schedule']['departure'][$index]['Flights']; ?>
                            @foreach($airlines as $key => $airlineList)
                                <div class="white-box small-flight">
                                    <div class="items-flight-destination">
                                        <div class="row-detail">
                                            <img width="80" src="{{asset('/assets/logo/'.getLogo($airlineList['FlightNo']).'.png')}}" title="Citilink" alt="logo"><br>
                                            <span class="code-penerbangan">{{$airlineList['FlightNo']}}</span>
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
                                                            <div class="FlightTimeHour">{{date('H:i',strtotime($airlineList['ETD']))}}</div>
                                                            <div class="FlightDate">{{date('D',strtotime($airlineList['ETD']))}}, {{date('d M',strtotime($airlineList['ETD']))}}</div>
                                                        </div>
                                                        <div class="FlightRoute">
                                                            <?php $std=getAirport($airlineList['STD']); ?>
                                                            <div class="FlightCity">{{$std->city}} ({{$std->id}})</div>
                                                            <div class="FlightAirport">{{$std->name}}</div>
                                                        </div>
                                                    </div><!--end.FlightSegment Origin-->
                                                    <div class="FlightSegment HiddenTransitSegment">
                                                        <div class="FlightDurationTime"><span class="icon"></span><p class="Duration"></p></div>
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
                                                            <div class="FlightTimeHour">{{date('H:i',strtotime($airlineList['ETA']))}}</div>
                                                            <div class="FlightDate">{{date('D',strtotime($airlineList['ETA']))}}, {{date('d M',strtotime($airlineList['ETA']))}}</div>
                                                        </div>
                                                        <div class="FlightRoute">
                                                            <?php $sta=getAirport($airlineList['STA']); ?>
                                                            <div class="FlightCity">{{$sta->city}} ({{$sta->id}})</div>
                                                            <div class="FlightAirport">{{$sta->name}}</div>
                                                        </div>
                                                    </div><!--end.FlightSegment Destination-->
                                                </div><!--end.flight-content-->
                                            </div><!--end.timeline-floght-->
                                        </div><!--end.row-detail-->
                                    </div><!--end.flight-destination-->
                                </div><!--end.white-box-->
                                @if($key+1<count($airlines))
                                    <?php
                                    $etd=\Carbon\Carbon::createFromFormat('Y-m-d H:i', $airlines[$key]['ETA']);
                                    $eta=\Carbon\Carbon::createFromFormat('Y-m-d H:i', $airlines[$key+1]['ETD']);
                                    $h=$etd->diffInHours($eta, false);
                                    $m=$etd->addHours($h)->diffInMinutes($eta, false);
                                    $hShow= $h!="0"?$h.' jam':'';
                                    $mShow= $m!="0"?$m.' mnt':'';
                                    $showTime=$hShow.' '.$mShow;
                                    ?>
                                    <h3 class="orange-title"><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="small-title">Transit selama {{ $showTime }} di  {{$sta->city}} ({{$sta->id}})</span></h3>
                                @endif
                            @endforeach
                        </div><!--end.right-info-->
                        @if($result['flight']=="R")
                            <br>
                            <div class="right-info">
                                <h3 class="orange-title" style="background-color: #0C5484">Penerbangan Pulang <br> <span class="small-title">{{myDay($result['tgl_ret'])}}, {{date("d M y",strtotime($result['tgl_ret']))}}</span></h3>
                                <?php $airlines=$result['schedule']['return'][$indexRet]['Flights']; ?>
                                @foreach($airlines as $key => $airlineList)
                                    <div class="white-box small-flight">
                                        <div class="items-flight-destination">
                                            <div class="row-detail">
                                                <img width="80" src="{{asset('/assets/logo/'.getLogo($airlineList['FlightNo']).'.png')}}" title="Citilink" alt="logo"><br>
                                                <span class="code-penerbangan">{{$airlineList['FlightNo']}}</span>
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
                                                                <div class="FlightTimeHour">{{date('H:i',strtotime($airlineList['ETD']))}}</div>
                                                                <div class="FlightDate">{{date('D',strtotime($airlineList['ETD']))}}, {{date('d M',strtotime($airlineList['ETD']))}}</div>
                                                            </div>
                                                            <div class="FlightRoute">
                                                                <?php $std=getAirport($airlineList['STD']); ?>
                                                                <div class="FlightCity">{{$std->city}} ({{$std->id}})</div>
                                                                <div class="FlightAirport">{{$std->name}}</div>
                                                            </div>
                                                        </div><!--end.FlightSegment Origin-->
                                                        <div class="FlightSegment HiddenTransitSegment">
                                                            <div class="FlightDurationTime"><span class="icon"></span><p class="Duration"> </p></div>
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
                                                                <div class="FlightTimeHour">{{date('H:i',strtotime($airlineList['ETA']))}}</div>
                                                                <div class="FlightDate">{{date('D',strtotime($airlineList['ETA']))}}, {{date('d M',strtotime($airlineList['ETA']))}}</div>
                                                            </div>
                                                            <div class="FlightRoute">
                                                                <?php $sta=getAirport($airlineList['STA']); ?>
                                                                <div class="FlightCity">{{$sta->city}} ({{$sta->id}})</div>
                                                                <div class="FlightAirport">{{$sta->name}}</div>
                                                            </div>
                                                        </div><!--end.FlightSegment Destination-->
                                                    </div><!--end.flight-content-->
                                                </div><!--end.timeline-floght-->
                                            </div><!--end.row-detail-->
                                        </div><!--end.flight-destination-->
                                    </div><!--end.white-box-->
                                    @if($key+1<count($airlines))
                                        <?php
                                        $etd=\Carbon\Carbon::createFromFormat('Y-m-d H:i', $airlines[$key]['ETA']);
                                        $eta=\Carbon\Carbon::createFromFormat('Y-m-d H:i', $airlines[$key+1]['ETD']);
                                        $h=$etd->diffInHours($eta, false);
                                        $m=$etd->addHours($h)->diffInMinutes($eta, false);
                                        $hShow= $h!="0"?$h.' jam':'';
                                        $mShow= $m!="0"?$m.' mnt':'';
                                        $showTime=$hShow.' '.$mShow;
                                        ?>
                                        <h3 class="orange-title"><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="small-title">Transit selama {{ $showTime }} di  {{$sta->city}} ({{$sta->id}})</span></h3>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div><!--end.right-section-->
                </div><!--end.col-->
            </div>
        </div>
    </section>
@endsection
@section('js')
    @parent
    <script>
        $('#transactionLoader').hide();

        Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
        Vue.http.options.emulateJSON = true;

        var resultTransaction= new Vue({
            el:'#resultTransaction',
            data:{
                result:null,
                success:false,
                failed:false,
                wrongCaptcha:false,
                CaptchaCode:'',
                term:false,
                errorTerm:false,
                pr:0

            },filters:{
                upperCase:function(v){
                    var str = v;
                    return str.toUpperCase();
                }
            },
            methods:{
                //airlinesTransaction:function(url,body,loader){
                airlinesTransaction:function(){
                    if(this.term===true){
                        this.errorTerm=false;
                        this.wrongCaptcha=false;
                        // ExampleCaptcha.ReloadImage();
                        $('#transactionLoader').show();
                        $("#btnBookIssued").hide();
                        $("#CaptchaCode").hide();
                        // $("#ExampleCaptcha_CaptchaDiv").hide();
                        window.request['CaptchaCode']=this.CaptchaCode;
                        // window.request['BDC_UserSpecifiedCaptchaId']=$("#BDC_UserSpecifiedCaptchaId").val();
                        // window.request['BDC_VCID_ExampleCaptcha']=$("#BDC_VCID_ExampleCaptcha").val();
                        // window.request['BDC_BackWorkaround_ExampleCaptcha']=$("#BDC_BackWorkaround_ExampleCaptcha").val();
                        window.request['pr']=this.pr;
                        this.$http.post(window.url,window.request).then((response)=>{
                            //success callback
                            this.result=response.data;
                        if(this.result.status.code==200){
                            //$(loader).hide();
                            this.success=true;
                            $('#transactionLoader').hide();
                            //$('#deposit').html(this.addCommas(this.result.response.deposit.response.detail.deposit - this.result.response.deposit.response.detail.debit))
                        }else if(this.result.status.code==400){
                            //$(loader).hide();
                            this.wrongCaptcha=true;
                            $('#transactionLoader').hide();
                            $("#btnBookIssued").show();
                            $("#CaptchaCode").show();
                            // $("#ExampleCaptcha_CaptchaDiv").show();
                        }else{
                            $('#transactionLoader').hide();
                            this.failed=true;
                        }
                    },(response)=>{
                            //error callback
                            console.log("ERROR BRO !");
                            $('#transactionLoader').hide();
                            this.failed=true;

                        });
                    }else{
                        this.errorTerm=true;
                    }
                    console.log(window.request);
                },
                addCommas:function(nStr){
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
            },
            mounted:function () {
                // this.airlinesTransaction(window.url,window.request,"#transactionLoader");
            }

        });

    </script>
@endsection
