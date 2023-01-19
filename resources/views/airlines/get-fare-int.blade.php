@extends('layouts.public')
@section('css')
    @parent
@endsection
@section('content')
    <?php

    $airlines=$getSchedule['schedule']['departure'][$index]['Flights'];
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
                <li class="active">
                    <a href="javascript:void(0)">
                        3. Isi Data
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        4. Konfirmasi Data
                    </a>
                </li>
            </ul>
        </div><!--end.container-->
    </div><!--end.stepbooking-->

    <!-- END STEP BOOKING -->

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
                                        $airlinesRet=$getSchedule['schedule']['return'][$indexRet]['Flights'];
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
                                            <div class="col-md-1 inline-row t2">
                                                <a class="show-notice">
                                                    {{$countFlightRet-1==0?'Langsung':$countFlightRet-1 .' Transit'}}
                                                </a>
                                            </div>

                                        </div><!--end.row-->
                                    @endif

                                </div><!--end.left-result-->
                            </div><!--end.col-md8-->
                            <div class="col-md-3 nopadding item-result"  @if($result['flight']=="R")style="height: 183px;" @else style="height: 78px;" @endif>
                                <div class="right-result price-summary">
                                    <p>Total Biaya:</p>
                                    <h3 id="summary_pricetotal">IDR {{number_format($result['totalAmount'])}}</h3>
                                </div>
                            </div><!--end.col-md4-->
                        </div><!--end.result-row-->
                    </div><!--end.rangkuman-->
                </div><!--end.col-->
            </div><!--end.row-->
        </div><!--end.container-->
    </section><!--end.maintable-->
    <!-- DATA PASSENGER -->

    <section id="form-customer">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    {!! Form::open(['route'=>'airlines.result','method'=>'post','id'=>'finishForm']) !!}
                    {!! Form::hidden('acDep',$getSchedule['schedule']['departure'][$index]['ac']) !!}
                    {!! Form::hidden('org',$result['org']) !!}
                    {!! Form::hidden('des',$result['des']) !!}
                    {!! Form::hidden('tgl_dep',$result['tgl_dep']) !!}
                    {!! Form::hidden('selectedIDdep',$result['trxId']) !!}
                    {!! Form::hidden('trxId',$result['trxId']) !!}
                    {!! Form::hidden('flight',$result['flight']) !!}
                    {!! Form::hidden('adt',$result['adt']) !!}
                    {!! Form::hidden('chd',$result['chd']) !!}
                    {!! Form::hidden('inf',$result['inf']) !!}
                    {!! Form::hidden('bookStat',"bookingIssued") !!}
                    {!! Form::hidden('totalFare',$result['totalAmount']) !!}
                    {!! Form::hidden('result',json_encode($getSchedule)) !!}
                    {!! Form::hidden('international',1) !!}
                    {!! Form::hidden('cabin',$result['cabin']) !!}
                    {!! Form::hidden('index',$index) !!}
                    @if($result['flight']=="R")
                        {!! Form::hidden('indexRet',$indexRet) !!}
                        {!! Form::hidden('acRet',$getSchedule['schedule']['departure'][$indexRet]['ac'])!!}
                        {!! Form::hidden('tgl_ret',$result['tgl_ret']) !!}
                        {!! Form::hidden('selectedIDret',$result['trxId']) !!}
                    @endif
                    <div class="alert-custom alert alert-red alert-dismissible" role="alert">
                        <p><strong>Peringatan !</strong> Pastikan data penumpang yang anda masukkan adalah valid sesuai dengan KTP/Paspor. Jika anda melakukan proses BOOKING dengan data penumpang yang tidak valid / data asal, maka transaksi tersebut akan kami issued, saldo anda akan kami potong. ID anda akan kami suspend (nonaktifkan) dalam kurun waktu tertentu. Terimakasih.</p>
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
                                    <div class="col-md-2 col-xs-12">
                                        <div class="form-group">
                                            <label>Gelar <span class="redFont">*</span> </label>
                                            <select name="adtTitle[]" class="form-control" required>
                                                <option value="" selected>Pilih</option>
                                                <option value="MR">MR</option>
                                                <option value="MRS">MRS</option>
                                                <option value="MS">MS</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-xs-12">
                                        <div class="form-group">
                                            <label for="adtFirstName">Nama Depan <span class="redFont">*</span></label>
                                            <input type="text" name="adtFirstName[]" required id="adtFirstName" class="form-control">
                                        </div><!--end.form-grup-->
                                    </div>
                                    <div class="col-md-5 col-xs-12">
                                        <div class="form-group">
                                            <label for="adtLastName">Nama Belakang <span class="redFont">*</span></label>
                                            <input type="text" name="adtLastName[]" id="adtLastName" required class="form-control">
                                        </div><!--end.form-grup-->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="adtPhone">No Telp / HP<span class="redFont">*</span></label>
                                            <input type="text" name="adtPhone[]" id="adtPhone" required class="form-control">
                                        </div>
                                    </div>
                                </div>

                                @if($result['flight']=="O")<hr>
                                        <h3>Data Passpor</h3>
                                        <div class="row">
                                            <div class="col-md-3 col-xs-12">
                                                <label for="chdDate">Tanggal Lahir</label>
                                                <select class="form-control" name="adtDate[]" id="adtDate" required>
                                                    @foreach(dateList() as $key=>$value)
                                                        <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 col-xs-12">
                                                <label for="chdMonth">&nbsp;</label>
                                                <select class="form-control" name="adtMonth[]" id="adtMonth" required>
                                                    @foreach(monthList() as $key => $value)
                                                        <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-5 col-xs-12">
                                                <label for="chdYear">&nbsp;</label>
                                                <select class="form-control" name="adtYear[]" id="adtYear" required>
                                                    @foreach(yearListAdt() as $key => $value)
                                                        <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-xs-12">
                                                <div class="form-group">
                                                    <label for="number">No. Passpor / KTP<span class="redFont">*</span></label>
                                                    <input type="text" name="number[]" id="number" required class="form-control">
                                                </div>
                                            </div>
                                            <?php $countries=\App\Country::all(); ?>
                                            <div class="col-md-4 col-xs-12">
                                                <label for="nationality">Warga Negara</label>
                                                <select class="form-control" name="nationality[]" id="nationality" required>
                                                    @foreach($countries as $key => $value)
                                                        <option value="{{$value->id}}" <?=($value->id=='ID')?'selected':''?>>{{$value->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-5 col-xs-12">
                                                <label for="chdYear">Negara Issued Passport</label>
                                                <select class="form-control" name="issuedCountry[]" id="issuedCountry" required>
                                                    @foreach($countries as $key => $value)
                                                        <option value="{{$value->id}}" <?=($value->id=='ID')?'selected':''?>>{{$value->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-xs-12">
                                                <label for="chdDate">Masa Berlaku</label>
                                                <select class="form-control" name="passportDate[]" id="passportDate" required>
                                                    @foreach(dateList() as $key=>$value)
                                                        <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 col-xs-12">
                                                <label for="chdMonth">&nbsp;</label>
                                                <select class="form-control" name="passportMonth[]" id="passportMonth" required>
                                                    @foreach(monthList() as $key => $value)
                                                        <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-5 col-xs-12">
                                                <label for="chdYear">&nbsp;</label>
                                                <select class="form-control" name="passportYear[]" id="passportYear" required>
                                                    @foreach(yearListPassport() as $key => $value)
                                                        <option value="{{$key}}" {{($key=='2021')?'selected':''}}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                @else

                                        <hr>
                                        <h3>Data Passpor</h3>
                                        <div class="row">
                                            <div class="col-md-3 col-xs-12">
                                                <label for="chdDate">Tanggal Lahir</label>
                                                <select class="form-control" name="adtDate[]" id="adtDate" required>
                                                    @foreach(dateList() as $key=>$value)
                                                        <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 col-xs-12">
                                                <label for="chdMonth">&nbsp;</label>
                                                <select class="form-control" name="adtMonth[]" id="adtMonth" required>
                                                    @foreach(monthList() as $key => $value)
                                                        <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-5 col-xs-12">
                                                <label for="chdYear">&nbsp;</label>
                                                <select class="form-control" name="adtYear[]" id="adtYear" required>
                                                    @foreach(yearListAdt() as $key => $value)
                                                        <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-xs-12">
                                                <div class="form-group">
                                                    <label for="number">No. Passpor / KTP<span class="redFont">*</span></label>
                                                    <input type="text" name="number[]" id="number" required class="form-control">
                                                </div>
                                            </div>
                                            <?php $countries=\App\Country::all(); ?>
                                            <div class="col-md-4 col-xs-12">
                                                <label for="nationality">Warga Negara</label>
                                                <select class="form-control" name="nationality[]" id="nationality" required>
                                                    @foreach($countries as $key => $value)
                                                        <option value="{{$value->id}}" <?=($value->id=='ID')?'selected':''?>>{{$value->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-5 col-xs-12">
                                                <label for="chdYear">Negara Issued Passport</label>
                                                <select class="form-control" name="issuedCountry[]" id="issuedCountry" required>
                                                    @foreach($countries as $key => $value)
                                                        <option value="{{$value->id}}" <?=($value->id=='ID')?'selected':''?>>{{$value->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-xs-12">
                                                <label for="chdDate">Masa Berlaku</label>
                                                <select class="form-control" name="passportDate[]" id="passportDate" required>
                                                    @foreach(dateList() as $key=>$value)
                                                        <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 col-xs-12">
                                                <label for="chdMonth">&nbsp;</label>
                                                <select class="form-control" name="passportMonth[]" id="passportMonth" required>
                                                    @foreach(monthList() as $key => $value)
                                                        <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-5 col-xs-12">
                                                <label for="chdYear">&nbsp;</label>
                                                <select class="form-control" name="passportYear[]" id="passportYear" required>
                                                    @foreach(yearListPassport() as $key => $value)
                                                        <option value="{{$key}}" {{($key=='2021')?'selected':''}}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                @endif
                            </div>
                        </div>
                    @endfor
                    @if((int)$result['chd']>0)
                        <hr>
                        @for($i=1; $i<=(int)$result['chd'];$i++)
                            <div class="left-section">
                                <h3 class="blue-title">Data Penumpang Anak {{$i}} :</h3>
                                <div class="grey-box">
                                    <div class="row">
                                        <div class="col-md-2 col-xs-12">
                                            <div class="form-group">
                                                <label>Gelar <span class="redFont">*</span> </label>
                                                <select name="chdTitle[]" class="form-control" required>
                                                    <option value="" selected>Pilih</option>
                                                    <option value="MR">MSTR</option>
                                                    <option value="MS">MISS</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-5 col-xs-12">
                                            <div class="form-group">
                                                <label for="adtFirstName">Nama Depan <span class="redFont">*</span></label>
                                                <input type="text" name="chdFirstName[]" required id="chdFirstName" class="form-control">
                                            </div><!--end.form-grup-->
                                        </div>
                                        <div class="col-md-5 col-xs-12">
                                            <div class="form-group">
                                                <label for="adtLastName">Nama Belakang <span class="redFont">*</span></label>
                                                <input type="text" name="chdLastName[]" id="chdLastName" required class="form-control">
                                            </div><!--end.form-grup-->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-xs-12">
                                            <label for="chdDate">Tanggal Lahir</label>
                                            <select class="form-control" name="chdDate[]" id="chdDate" required>
                                                @foreach(dateList() as $key=>$value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            <label for="chdMonth">&nbsp;</label>
                                            <select class="form-control" name="chdMonth[]" id="chdMonth" required>
                                                @foreach(monthListChd() as $key => $value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5 col-xs-12">
                                            <label for="chdYear">&nbsp;</label>
                                            <select class="form-control" name="chdYear[]" id="chdYear" required>
                                                @foreach(yearListChd() as $key => $value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @if($result['flight']=="O")
                                            <hr>
                                            <h3>Data Passpor</h3>
                                            <p>Jika anak belum memiliki paspor, dapat menggunakan data paspor orang tua ( penumpang dewasa ).</p>
                                            <div class="row">
                                                <div class="col-md-3 col-xs-12">
                                                    <label for="chdDate">Tanggal Lahir</label>
                                                    <select class="form-control" name="chdPassDate[]" id="chdDate" required>
                                                        @foreach(dateList() as $key=>$value)
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 col-xs-12">
                                                    <label for="chdMonth">&nbsp;</label>
                                                    <select class="form-control" name="chdPassMonth[]" id="chdMonth" required>
                                                        @foreach(monthListChd() as $key => $value)
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-5 col-xs-12">
                                                    <label for="chdYear">&nbsp;</label>
                                                    <select class="form-control" name="chdPassYear[]" id="chdYear" required>
                                                        @foreach(yearListChd() as $key => $value)
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="number">No. Passpor / KTP<span class="redFont">*</span></label>
                                                        <input type="text" name="chdNumber[]" id="chdNumber" required class="form-control">
                                                    </div>
                                                </div>
                                                <?php $countries=\App\Country::all(); ?>
                                                <div class="col-md-4 col-xs-12">
                                                    <label for="nationality">Warga Negara</label>
                                                    <select class="form-control" name="chdNationality[]" id="chdNationality" required>
                                                        @foreach($countries as $key => $value)
                                                            <option value="{{$value->id}}" <?=($value->id=='ID')?'selected':''?>>{{$value->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-5 col-xs-12">
                                                    <label for="chdYear">Negara Issued Passport</label>
                                                    <select class="form-control" name="chdIssuedCountry[]" id="chdIssuedCountry" required>
                                                        @foreach($countries as $key => $value)
                                                            <option value="{{$value->id}}" <?=($value->id=='ID')?'selected':''?>>{{$value->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 col-xs-12">
                                                    <label for="chdDate">Masa Berlaku</label>
                                                    <select class="form-control" name="chdPassportDate[]" id="chdPassportDate" required>
                                                        @foreach(dateList() as $key=>$value)
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 col-xs-12">
                                                    <label for="chdMonth">&nbsp;</label>
                                                    <select class="form-control" name="chdPassportMonth[]" id="chdPassportMonth" required>
                                                        @foreach(monthList() as $key => $value)
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-5 col-xs-12">
                                                    <label for="chdYear">&nbsp;</label>
                                                    <select class="form-control" name="chdPassportYear[]" id="chdPassportYear" required>
                                                        @foreach(yearListPassport() as $key => $value)
                                                            <option value="{{$key}}" {{($key=='2021')?'selected':''}}>{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                    @else
                                            <hr>
                                            <h3>Data Passpor</h3>
                                            <p>Jika anak belum memiliki paspor, dapat menggunakan data paspor orang tua ( penumpang dewasa ).</p>
                                            <div class="row">
                                                <div class="col-md-3 col-xs-12">
                                                    <label for="chdDate">Tanggal Lahir</label>
                                                    <select class="form-control" name="chdPassDate[]" id="chdDate" required>
                                                        @foreach(dateList() as $key=>$value)
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 col-xs-12">
                                                    <label for="chdMonth">&nbsp;</label>
                                                    <select class="form-control" name="chdPassMonth[]" id="chdMonth" required>
                                                        @foreach(monthListChd() as $key => $value)
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-5 col-xs-12">
                                                    <label for="chdYear">&nbsp;</label>
                                                    <select class="form-control" name="chdPassYear[]" id="chdYear" required>
                                                        @foreach(yearListChd() as $key => $value)
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="number">No. Passpor / KTP<span class="redFont">*</span></label>
                                                        <input type="text" name="chdNumber[]" id="chdNumber" required class="form-control">
                                                    </div>
                                                </div>
                                                <?php $countries=\App\Country::all(); ?>
                                                <div class="col-md-4 col-xs-12">
                                                    <label for="nationality">Warga Negara</label>
                                                    <select class="form-control" name="chdNationality[]" id="chdNationality" required>
                                                        @foreach($countries as $key => $value)
                                                            <option value="{{$value->id}}" <?=($value->id=='ID')?'selected':''?>>{{$value->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-5 col-xs-12">
                                                    <label for="chdYear">Negara Issued Passport</label>
                                                    <select class="form-control" name="chdIssuedCountry[]" id="chdIssuedCountry" required>
                                                        @foreach($countries as $key => $value)
                                                            <option value="{{$value->id}}" <?=($value->id=='ID')?'selected':''?>>{{$value->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 col-xs-12">
                                                    <label for="chdDate">Masa Berlaku</label>
                                                    <select class="form-control" name="chdPassportDate[]" id="chdPassportDate" required>
                                                        @foreach(dateList() as $key=>$value)
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 col-xs-12">
                                                    <label for="chdMonth">&nbsp;</label>
                                                    <select class="form-control" name="chdPassportMonth[]" id="chdPassportMonth" required>
                                                        @foreach(monthList() as $key => $value)
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-5 col-xs-12">
                                                    <label for="chdYear">&nbsp;</label>
                                                    <select class="form-control" name="chdPassportYear[]" id="chdPassportYear" required>
                                                        @foreach(yearListPassport() as $key => $value)
                                                            <option value="{{$key}}" {{($key=='2021')?'selected':''}}>{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                    @endif
                                </div>
                            </div>
                        @endfor
                    @endif
                    @if((int)$result['inf']>0)
                        <hr>
                        @for($i=1; $i<=(int)$result['inf'];$i++)
                            <div class="left-section">
                                <h3 class="blue-title">Data Penumpang Bayi {{$i}} :</h3>
                                <div class="grey-box">
                                    <div class="row">
                                        <div class="col-md-2 col-xs-12">
                                            <div class="form-group">
                                                <label>Gelar <span class="redFont">*</span> </label>
                                                <select name="infTitle[]" class="form-control" required>
                                                    <option value="" selected>Pilih</option>
                                                    <option value="MR">MSTR</option>
                                                    <option value="MS">MISS</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-5 col-xs-12">
                                            <div class="form-group">
                                                <label for="adtFirstName">Nama Depan <span class="redFont">*</span></label>
                                                <input type="text" name="infFirstName[]" required id="chdFirstName" class="form-control">
                                            </div><!--end.form-grup-->
                                        </div>
                                        <div class="col-md-5 col-xs-12">
                                            <div class="form-group">
                                                <label for="adtLastName">Nama Belakang <span class="redFont">*</span></label>
                                                <input type="text" name="infLastName[]" id="chdLastName" required class="form-control">
                                            </div><!--end.form-grup-->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-xs-12">
                                            <label for="infDate">Tanggal Lahir</label>
                                            <select class="form-control" name="infDate[]" id="infDate" required>
                                                @foreach(dateList() as $key=>$value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            <label for="infMonth">&nbsp;</label>
                                            <select class="form-control" name="infMonth[]" id="infMonth" required>
                                                @foreach(monthListInf() as $key => $value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5 col-xs-12">
                                            <label for="infYear">&nbsp;</label>
                                            <select class="form-control" name="infYear[]" id="infYear" required>
                                                @foreach(yearListInf() as $key => $value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @if($result['flight']=="O")
                                            <hr>
                                            <h3>Data Passpor</h3>
                                            <p>Jika bayi belum memiliki paspor, dapat menggunakan data paspor orang tua ( penumpang dewasa ).</p>
                                            <div class="row">
                                                <div class="col-md-3 col-xs-12">
                                                    <label for="chdDate">Tanggal Lahir</label>
                                                    <select class="form-control" name="infPassDate[]" id="infDate" required>
                                                        @foreach(dateList() as $key=>$value)
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 col-xs-12">
                                                    <label for="chdMonth">&nbsp;</label>
                                                    <select class="form-control" name="infPassMonth[]" id="infMonth" required>
                                                        @foreach(monthListInf() as $key => $value)
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-5 col-xs-12">
                                                    <label for="chdYear">&nbsp;</label>
                                                    <select class="form-control" name="infPassYear[]" id="infYear" required>
                                                        @foreach(yearListInf() as $key => $value)
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="number">No. Passpor / KTP<span class="redFont">*</span></label>
                                                        <input type="text" name="infNumber[]" id="infNumber" required class="form-control">
                                                    </div>
                                                </div>
                                                <?php $countries=\App\Country::all(); ?>
                                                <div class="col-md-4 col-xs-12">
                                                    <label for="nationality">Warga Negara</label>
                                                    <select class="form-control" name="infNationality[]" id="infNationality" required>
                                                        @foreach($countries as $key => $value)
                                                            <option value="{{$value->id}}" <?=($value->id=='ID')?'selected':''?>>{{$value->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-5 col-xs-12">
                                                    <label for="chdYear">Negara Issued Passport</label>
                                                    <select class="form-control" name="infIssuedCountry[]" id="infIssuedCountry" required>
                                                        @foreach($countries as $key => $value)
                                                            <option value="{{$value->id}}" <?=($value->id=='ID')?'selected':''?>>{{$value->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 col-xs-12">
                                                    <label for="chdDate">Masa Berlaku</label>
                                                    <select class="form-control" name="infPassportDate[]" id="infPassportDate" required>
                                                        @foreach(dateList() as $key=>$value)
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 col-xs-12">
                                                    <label for="chdMonth">&nbsp;</label>
                                                    <select class="form-control" name="infPassportMonth[]" id="infPassportMonth" required>
                                                        @foreach(monthList() as $key => $value)
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-5 col-xs-12">
                                                    <label for="chdYear">&nbsp;</label>
                                                    <select class="form-control" name="infPassportYear[]" id="infPassportYear" required>
                                                        @foreach(yearListPassport() as $key => $value)
                                                            <option value="{{$key}}" {{($key=='2021')?'selected':''}}>{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                    @else
                                            <hr>
                                            <h3>Data Passpor</h3>
                                            <p>Jika bayi belum memiliki paspor, dapat menggunakan data paspor orang tua ( penumpang dewasa ).</p>
                                            <div class="row">
                                                <div class="col-md-3 col-xs-12">
                                                    <label for="chdDate">Tanggal Lahir</label>
                                                    <select class="form-control" name="infPassDate[]" id="infDate" required>
                                                        @foreach(dateList() as $key=>$value)
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 col-xs-12">
                                                    <label for="chdMonth">&nbsp;</label>
                                                    <select class="form-control" name="infPassMonth[]" id="infMonth" required>
                                                        @foreach(monthListInf() as $key => $value)
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-5 col-xs-12">
                                                    <label for="chdYear">&nbsp;</label>
                                                    <select class="form-control" name="infPassYear[]" id="infYear" required>
                                                        @foreach(yearListInf() as $key => $value)
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="number">No. Passpor / KTP<span class="redFont">*</span></label>
                                                        <input type="text" name="infNumber[]" id="infNumber" required class="form-control">
                                                    </div>
                                                </div>
                                                <?php $countries=\App\Country::all(); ?>
                                                <div class="col-md-4 col-xs-12">
                                                    <label for="nationality">Warga Negara</label>
                                                    <select class="form-control" name="infNationality[]" id="infNationality" required>
                                                        @foreach($countries as $key => $value)
                                                            <option value="{{$value->id}}" <?=($value->id=='ID')?'selected':''?>>{{$value->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-5 col-xs-12">
                                                    <label for="chdYear">Negara Issued Passport</label>
                                                    <select class="form-control" name="infIssuedCountry[]" id="infIssuedCountry" required>
                                                        @foreach($countries as $key => $value)
                                                            <option value="{{$value->id}}" <?=($value->id=='ID')?'selected':''?>>{{$value->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 col-xs-12">
                                                    <label for="chdDate">Masa Berlaku</label>
                                                    <select class="form-control" name="infPassportDate[]" id="infPassportDate" required>
                                                        @foreach(dateList() as $key=>$value)
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 col-xs-12">
                                                    <label for="chdMonth">&nbsp;</label>
                                                    <select class="form-control" name="infPassportMonth[]" id="infPassportMonth" required>
                                                        @foreach(monthList() as $key => $value)
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-5 col-xs-12">
                                                    <label for="chdYear">&nbsp;</label>
                                                    <select class="form-control" name="infPassportYear[]" id="infPassportYear" required>
                                                        @foreach(yearListPassport() as $key => $value)
                                                            <option value="{{$key}}" {{($key=='2021')?'selected':''}}>{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @endif
                                </div>
                            </div>
                        @endfor
                    @endif
                    <hr>
                    <div class="left-section">
                        <div class="rows text-right" style="padding: 0;">
                            <div class="col-md-4 col-md-offset-8">
                                    <?php $user = \Auth::user(); ?>
                                    <input type="submit" class="btn btn-cari" value="SELANJUTNYA" {{$user->deposit >= floatval($result['totalAmount'])?'':'disabled' }}>
                                    <div class="row">
                                        {!! $user->deposit >= floatval($result['totalAmount'])?'':'<p class="bg-danger">Saldo Anda tidak cukup.</p>' !!}
                                    </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div><!--end.left-section-->
                </div><!--end.col-->
                <div class="col-md-4">
                    <div class="right-section">
                        <div class="right-info">
                            <h3 class="orange-title" style="background-color: #0C5484">Penerbangan Pergi <br> <span class="small-title">{{myDay($result['tgl_dep'])}}, {{date("d M y",strtotime($result['tgl_dep']))}}</span></h3>
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
                                    <h3 class="orange-title"><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="small-title">Transit selama {{$showTime}} di  {{$sta->city}} ({{$sta->id}})</span></h3>
                                @endif
                            @endforeach
                        </div><!--end.right-info-->
                        @if($result['flight']=="R")
                            <br>
                            <div class="right-info">
                                <h3 class="orange-title" style="background-color: #0C5484">Penerbangan Pulang <br> <span class="small-title">{{myDay($result['tgl_ret'])}}, {{date("d M y",strtotime($result['tgl_ret']))}}</span></h3>
                                <?php $airlines=$getSchedule['schedule']['return'][$indexRet]['Flights']; ?>
                                @foreach($airlines as $key => $airlineList)
                                    <div class="white-box small-flight">
                                        <div class="items-flight-destination">
                                            <div class="row-detail">
                                                <img width="80" src="{{asset('/assets/logo/'.getLogo($airlineList['FlightNo']).'.png')}}" ><br>
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
            </div><!--end.row-->
        </div><!--end.container-->
    </section>
    <!-- END DATA PASSENGER -->
@endsection

@section('js')
    @parent

@endsection
