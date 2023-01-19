@extends('layouts.public')
@section('css')
    @parent
    <link href="{{ captcha_layout_stylesheet_url() }}" type="text/css" rel="stylesheet">
@endsection
@section('content')
  <?php
    $result=json_decode($request['result'], true);
    $std=\App\RailinkStation::find($request['org']);
    $sta=\App\RailinkStation::find($request['des']);
    $indexTrain=$request['indexTrain'];
    $indexFare=$request['indexFare'];
    $etd=date('H:i', strtotime($result['schedule']['departure'][$indexTrain]['ETD']));
    $eta=date('H:i', strtotime($result['schedule']['departure'][$indexTrain]['ETA']));
    if ($request['trip']=="R") {
        $indexTrainRet=$request['indexTrainRet'];
        $indexFareRet=$request['indexFareRet'];
        $etdRet=date('H:i', strtotime($result['schedule']['return'][$indexTrainRet]['ETD']));
        $etaRet=date('H:i', strtotime($result['schedule']['return'][$indexTrainRet]['ETA']));
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
              <li class="done">
                  <a href="javascript:void(0)">
                      2. Isi Data
                  </a>
              </li>
              <li class="active">
                  <a href="javascript:void(0)">
                      3. Pilih Kursi
                  </a>
              </li>
              <li>
                  <a href="javascript:void(0)">
                      4. Selesai
                  </a>
              </li>
          </ul>
        </div><!--end.container-->
    </div>
    <section id="form-customer">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="alert-custom alert alert-red alert-dismissible" role="alert">
                        <p><strong>Peringatan !</strong> Pastikan data penumpang yang anda masukkan adalah valid sesuai dengan KTP/Paspor. Jika anda melakukan proses ISSUED dengan data penumpang yang tidak valid / data asal, maka transaksi tersebut akan kami issued, saldo anda akan kami potong. ID anda akan kami suspend (nonaktifkan) dalam kurun waktu tertentu. Terimakasih.</p>
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
                                        <th>Nama Lengkap</th>
                                        <th>No. ID (KTP/SIM/Passport)</th>
                                        <th>No. HP</th>
                                    </tr>
                                    @foreach($request['adtName'] as $key => $adt)
                                        <tr>
                                            <td>{{$request['adtName'][$key]}}</td>
                                            <td>{{$request['adtId'][$key]}}</td>
                                            <td>{{$request['adtPhone'][$key]}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        @if(isset($request['chdName']))
                            <div class="summary-flight">
                                <h3 class="orange-title">Penumpang Anak</h3>
                                <div class="table-responsive">
                                    <table class="table result-tab">
                                        <tr>
                                            <th>Nama Lengkap</th>
                                        </tr>
                                        @foreach($request['chdName'] as $key => $adt)
                                            <tr>
                                                <td>{{$request['chdName'][$key]}}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="rows">
                        <div class="grey-box"  id="resultTransaction">
                          <div class="box-pilih-seat">
                            <div class="box-seat">
                              <div class="row">
                                <div class="col-md-12">
                                  <table>
                                    <tr>
                                      <td><div class="seatCharts-seat seatCharts-cell available"></div></td><td>=</td><td style="width:20%">Tersedia</td>
                                      <td><div class="seatCharts-seat seatCharts-cell unavailable"></div></td><td>=</td><td>Tidak Tersedia</td>
                                    </tr>
                                  </table>
                                  <h4>Pergi</h4>
                                  <div class="panel-group panel-custom" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">
                                      @foreach ($seats['seat']['departure']['seat_map'] as $key => $seat)
                                        <div class="panel-heading" role="tab" id="headingDep{{$key}}">
                                          <h4 class="panel-title">
                                                  <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseDep{{$key}}" aria-expanded="true"  aria-controls="collapseDep{{$key}}">
                                                      {{$seat['kode_wagon']}} - {{$seat['no_wagon']}}
                                                  </a>
                                            </h4>
                                        </div>
                                        <div id="collapseDep{{$key}}" class="panel-collapse collapse <?=($key===0)?"in":""?>" role="tabpanel" aria-labelledby="headingDep{{$key}}">
                                          <div class="panel-body">
                                            <div class="row">
                                              <div class="col-md-12">
                                                <div class="table-responsive">
                                                  <table border="0">
                                                    <?php
                                                    if ((int)$seat['jml_col']===4) {
                                                        $alfabet=[
                                                        0=>"",
                                                        1=>"A",
                                                        2=>"B",
                                                        3=>"",
                                                        4=>"C",
                                                        5=>"D"
                                                      ];
                                                    } else {
                                                        $alfabet=[
                                                        0=>"",
                                                        1=>"A",
                                                        2=>"B",
                                                        3=>"C",
                                                        4=>"",
                                                        5=>"D",
                                                        6=>"E"
                                                      ];
                                                    }
                                                    ?>
                                                    @for($h=0;$h<=(int)$seat['jml_col']+1;$h++)
                                                      <tr>
                                                        @for($i=0;$i<=(int)$seat['jml_row'];$i++)
                                                          @if($h===0)
                                                            <td style="text-align:center">{{($i>0)?$i:""}}</td>
                                                          @else
                                                            @if($i===0)
                                                              <td>{{$alfabet[$h]}}</td>
                                                            @elseif((int)$seat['jml_col']===4&&$h===3)
                                                              <td><div style="height:20px;"></div></td>
                                                            @elseif((int)$seat['jml_col']===5&&$h===4)
                                                              <td><div style="height:20px;"></div></td>
                                                            @else
                                                              <td>
                                                                <?php
                                                                $box="<div style=\"height:20px;\"></div>";
                                                                  foreach ($seat['avl'] as $val => $value) {
                                                                      if ($value[0]==$i&&$value[1]==$alfabet[$h]) {
                                                                          if ((int)$value[3]==0) {
                                                                              $box="<div class=\"departure seatCharts-seat seatCharts-cell available\">".$seat['kode_wagon']."-".$seat['no_wagon']."-".$i.$alfabet[$h]."</div>";
                                                                              break;
                                                                          } else {
                                                                              $box="<div class=\"seatCharts-seat seatCharts-cell unavailable\"></div>";
                                                                              break;
                                                                          }
                                                                      }
                                                                  }
                                                                 ?>
                                                                 {!! $box !!}
                                                              </td>
                                                            @endif
                                                          @endif
                                                        @endfor
                                                      </tr>
                                                    @endfor
                                                  </table>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      @endforeach
                                    </div>
                                  </div>
                                  @if($request['trip']=="R")
                                    <h4>Pulang</h4>
                                    <div class="panel-group panel-custom" id="accordionR" role="tablist" aria-multiselectable="true">
                                      <div class="panel panel-default">
                                        @foreach ($seats['seat']['return']['seat_map'] as $key => $seat)
                                          <div class="panel-heading" role="tab" id="headingRet{{$key}}">
                                            <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordionR" href="#collapseRet{{$key}}" aria-expanded="true"  aria-controls="collapseDep{{$key}}">
                                                        {{$seat['kode_wagon']}} - {{$seat['no_wagon']}}
                                                    </a>
                                              </h4>
                                          </div>
                                          <div id="collapseRet{{$key}}" class="panel-collapse collapse <?=($key===0)?"in":""?>" role="tabpanel" aria-labelledby="headingDep{{$key}}">
                                            <div class="panel-body">
                                              <div class="row">
                                                <div class="col-md-12">
                                                  <div class="table-responsive">
                                                    <table border="0">
                                                      <?php
                                                      if ((int)$seat['jml_col']===4) {
                                                          $alfabet=[
                                                          0=>"",
                                                          1=>"A",
                                                          2=>"B",
                                                          3=>"",
                                                          4=>"C",
                                                          5=>"D"
                                                        ];
                                                      } else {
                                                          $alfabet=[
                                                          0=>"",
                                                          1=>"A",
                                                          2=>"B",
                                                          3=>"C",
                                                          4=>"",
                                                          5=>"D",
                                                          6=>"E"
                                                        ];
                                                      }
                                                      ?>
                                                      @for($h=0;$h<=(int)$seat['jml_col']+1;$h++)
                                                        <tr>
                                                          @for($i=0;$i<=(int)$seat['jml_row'];$i++)
                                                            @if($h===0)
                                                              <td style="text-align:center">{{($i>0)?$i:""}}</td>
                                                            @else
                                                              @if($i===0)
                                                                <td>{{$alfabet[$h]}}</td>
                                                              @elseif((int)$seat['jml_col']===4&&$h===3)
                                                                <td><div style="height:20px;"></div></td>
                                                              @elseif((int)$seat['jml_col']===5&&$h===4)
                                                                <td><div style="height:20px;"></div></td>
                                                              @else
                                                                <td>
                                                                  <?php
                                                                  $box="<div style=\"height:20px;\"></div>";
                                                                    foreach ($seat['avl'] as $val => $value) {
                                                                        if ($value[0]==$i&&$value[1]==$alfabet[$h]) {
                                                                            if ((int)$value[3]==0) {
                                                                                $box="<div class=\"return seatCharts-seat seatCharts-cell available\">".$seat['kode_wagon']."-".$seat['no_wagon']."-".$i.$alfabet[$h]."</div>";
                                                                                break;
                                                                            } else {
                                                                                $box="<div class=\"seatCharts-seat seatCharts-cell unavailable\"></div>";
                                                                                break;
                                                                            }
                                                                        }
                                                                    }
                                                                   ?>
                                                                   {!! $box !!}
                                                                </td>
                                                              @endif
                                                            @endif
                                                          @endfor
                                                        </tr>
                                                      @endfor
                                                    </table>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        @endforeach
                                      </div>
                                    </div>
                                  @endif
                                </div>
                                <!-- SAMPAI SINI -->
                              </div>
                            </div>
                          </div>
                            <div class="caution-box">
                                <div class="warning-text">
                                    <span>Penting:</span>
                                    <ol>
                                        <li>Data penumpang harus sesuai KTP / SIM / Passport.</li>
                                        <li>No. HP setiap penumpang dewasa tidak boleh sama.</li>
                                        <li>Kesalahan dalam penulisan data menjadi tanggung jawab anda.</li>
                                    </ol>
                                </div>
                            </div><!--end.caution-box-->
                            <div id="resultTransaction">
                              <div class="checkbox">
                                  <label>
                                      <input type="checkbox" v-model="term" v-bind:true="true" v-bind:false="false"> Saya Memastikan bahwa data yang saya masukan adalah benar dan saya bertanggung jawab atas data yang telah saya masukan. Saya telah membaca dan menyetujui <a href="{{ route('sip.term') }}" target="_blank">Syarat dan Ketentuan SIP</a>.<br>
                                      <span class="label label-danger" v-show="errorTerm">Anda belum menyetujui syarat dan ketentuan SIP.</span>
                                  </label>
                              </div>
                              <span class="label label-danger" v-show="seatNotSet">Anda belum memilih kursi sesuai dengan jumlah penumpang.</span>
                              <span class="label label-danger" v-if="failed">@{{failedMessage}}</span>
                              <div class="row" v-show="btnBookIssued">
                                <div class="form-inline">
                                @if($user->point>0&&$user->point>=3)
                                <div class="row">
                                    <div class="alert alert-success" role="alert">Anda memiliki <strong>{{ $user->point }} Point Reward</strong></div>
                                </div>
                                <label for="point">Gunakan Point Reward : </label>
                                <div class="input-group" >
                                    <select name="pr" id="point" v-model="pr">
                                        <option>0</option>
                                        <option>3</option>
                                    </select>
                                    <div class="input-group-addon">Point</div>
                                </div>
                                @endif
                                  <div class="form-group">
                                      <div class="col-sm-12">
                                          <input type="password" v-model="password" id="password" class="form-control"/>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <div class="col-sm-12">
                                          <button @click="trainTransaction" class="btn btn-cari">ISSUED</button>
                                      </div>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div v-show="transactionLoader">
                                    <div class="row">
                                        <div class="col-md-2 col-md-offset-5"><img src='{{asset('/assets/images/Preloader_2.gif')}}' style='height: auto;width:auto;' class='img-responsive'></div>
                                    </div>
                                </div>
                                <div v-if="success" >
                                    <div class="rows">
                                        <div class="alert-custom alert alert-green alert-dismissible" role="alert">
                                            <img class="icon-sign" src="{{asset('/assets/images/material/icon-03.png')}}" style="vertical-align: top;">
                                            <p><strong>Issued Berhasil!</strong><br>Silahkan klik data transaksi di bawah ini. <br><a href="{{route('railinks.reports')}}" class="btn btn-cari">DATA TRANSAKSI</a></p>
                                        </div><!--end.alert-->
                                    </div>
                                </div>
                              </div>
                            </div>
                        </div><!--end.grey-box-->
                    </div><!--end.rows-->
                </div>
                <div class="col-md-4">
                    <div class="right-section">
                        <div class="right-info">
                          <h3 class="orange-title">Detail Pemesanan</h3>
                    <div class="white-box no-padding-box">
                        <div class="detail-side-row rows">
                            <div class="text-center detail-top">
                                <div class="logo-kereta"><img src="{{asset('/assets/logo/railink.png')}}"></div>
                                <h3>{{$std->city}} - {{$sta->city}}</h3>
                                <span class="time-kereta"><strong class="bigFont">{{$etd}} - {{$eta}}</strong><br><span class="greyFont small"></span></span>
                            </div><!--end.detail-top-->
                            <div class="detail-bottom">
                                <dl class="dl-horizontal">
                                  <dt class="feature">Penumpang</dt><dd class="value">{{(int)$request['adt']+(int)$request['chd']+(int)$request['inf']}} orang</dd>
                                  <dt class="feature">Biaya Admin</dt><dd class="value">-</dd>
                                  {{-- <dt class="feature">Tarif/Kursi</dt><dd class="value"></dd> --}}
                                </dl>
                            </div>
                        </div><!--end.detail-side-rows-->
                        <div class="total-side-rows">
                            <div class="row-orange">
                                <dl class="dl-horizontal">
                                  @if($result['trip']=="O")
                                    <dt class="feature">TOTAL</dt><dd class="value">IDR {{number_format($result['schedule']['departure'][$indexTrain]['Fares'][$indexFare]['TotalFare'])}}</dd>
                                  @else
                                    <dt class="feature">TOTAL</dt><dd class="value">IDR {{number_format((int)$result['schedule']['departure'][$indexTrain]['Fares'][$indexFare]['TotalFare']+(int)$result['schedule']['return'][$indexTrainRet]['Fares'][$indexFareRet]['TotalFare'])}}</dd>
                                  @endif
                                </dl>
                            </div>
                        </div>
                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    @parent
    <script>
    $(document).ready(function(){
      var pass = {{(int)$request['adt']+(int)$request['chd']+(int)$request['inf']}};
      var adt = {{(int)$request['adt']}};
      var selectedSeat=[];
      var selectedSeatRet=[];
      $(".departure").click(function (e) {
          var selectedClass=$(this).attr('class');
          var res = selectedClass.split(" ");
          if(typeof res[4]==="undefined"){
            if(selectedSeat.length<pass){
              $(this).toggleClass('selected');
              selectedSeat.push($(this).text());
              console.log(selectedSeat);
              selectedSeat.forEach(function(item,index){
                if(index+1<=adt){
                  console.log("adt seat = "+item);
                  $("#adtSeat"+index).val(item);
                  window.request.adtSeat[index]=item;
                }else{
                  console.log("chd seat = "+item);
                  $("#chdSeat"+(index-adt)).val(item);
                  window.request.chdSeat[index-adt]=item;
                }
              });
            }
          }else if(res[4]==="selected"){
            var index = selectedSeat.indexOf($(this).text());
            if(index>-1){
              selectedSeat.splice(index,1)
              $(this).toggleClass('selected');
            }
          }
      	});
        $(".return").click(function (e) {
            var selectedClassRet=$(this).attr('class');
            var res = selectedClassRet.split(" ");
            if(typeof res[4]==="undefined"){
              if(selectedSeatRet.length<pass){
                $(this).toggleClass('selected');
                selectedSeatRet.push($(this).text());
                console.log("Return");
                console.log(selectedSeatRet);
                selectedSeatRet.forEach(function(item,index){
                  if(index+1<=adt){
                    console.log("adt return seat = "+item);
                    $("#adtSeatRet"+index).val(item);
                    window.request.adtSeatRet[index]=item;
                  }else{
                    console.log("chd return seat = "+item);
                    $("#chdSeatRet"+(index-adt)).val(item);
                    window.request.chdSeatRet[index-adt]=item;
                  }
                });
              }
            }else if(res[4]==="selected"){
              var index = selectedSeatRet.indexOf($(this).text());
              if(index>-1){
                selectedSeatRet.splice(index,1)
                $(this).toggleClass('selected');
              }
            }
        	});
    });
    function issued(){
      $("#fieldPassword").val($("#password").val());
      document.getElementById('bookingIssued').submit();
    }
    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
    Vue.http.options.emulateJSON = true;
    var resultTransaction= new Vue({
      el:"#resultTransaction",
      data:{
          result:null,
          success:false,
          failed:false,
          failedMessage:"",
          term:false,
          errorTerm:false,
          pr:0,
          transactionLoader:false,
          seatNotSet:false,
          btnBookIssued:true,
          password:""

      },
      methods:{
        trainTransaction:function(){
          this.seatNotSet=false;
          this.failed=false;
          if(this.term===true){
            this.errorTerm=false;
            console.log("adtSeat length = "+window.request.adtSeat.length);
            console.log("window request adt = "+parseInt(window.request.adt));
            console.log("window request chd = "+parseInt(window.request.chd));
            if(window.request.adtSeat.length!=parseInt(window.request.adt)){
              this.seatNotSet=true;
              return
            }
            if(parseInt(window.request.chd)!=0){
              if(window.request.chdSeat.length!=parseInt(window.request.chd)){
                this.seatNotSet=true;
                return
              }
            }
            if(window.request.trip=="R"){
              if(window.request.adtSeatRet.length!=parseInt(window.request.adt)){
                this.seatNotSet=true;
                return
              }
              if(parseInt(window.request.chd)!=0){
                if(window.request.chdSeatRet.length!=parseInt(window.request.chd)){
                  this.seatNotSet=true;
                  return
                }
              }
            }
            this.transactionLoader=true;
            this.btnBookIssued=false;
            window.request.password=this.password;
            window.request.pr=this.pr;
            this.$http.post(window.url,window.request).then(
              (response)=>{
                this.transactionLoader=false;
                if(response.data.status.code==401){
                  this.btnBookIssued=true;
                  this.failed=true;
                  this.failedMessage=response.data.status.message;
                }else if(response.data.status.code==400){
                  this.btnBookIssued=true;
                  this.failed=true;
                  this.failedMessage=response.data.status.message;
                }else{
                  this.success=true;
                }
              },(response)=>{
                console.log("Gagal");
              }
            );
          }else{
            return this.errorTerm=true;
          }
        }
      }
    });
    </script>
@endsection
