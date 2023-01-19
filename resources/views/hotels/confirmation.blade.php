@extends('layouts.public')
@section('css')
    @parent

@endsection
@section('content')
<!-- STEP BOOKING -->
    <div id="step-booking">
        <div class="container">
            <ul class="breadcrumb-step">
                <li class="done">
                    <a href="javascript:void(0)">
                        1. Pilih Hotel
                    </a>
                </li>
                <li class="done">
                    <a href="javascript:void(0)">
                        2. Pilih Kamar & Isi Data
                    </a>
                </li>
                <li class="active">
                    <a href="javascript:void(0)">
                        3. Konfirmasi
                    </a>
                </li>
            </ul>
        </div><!--end.container-->
    </div><!--end.stepbooking-->
    <section class="hotel-dipilih">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
             <h3 class="orange-title"><span class="small-title">Hotel yang dipilih:</span></h3>
             <div class="choose-hotel">
               <div class="row">
                 <div class="col-md-3 col-sm-4">
                   <div class="wide-thumb">
                     <img src="{{asset('/assets/images/content/img-thumb-total.jpg')}}">
                   </div>
                 </div>
                 <div class="col-md-6 col-sm-8">
                   <div class="detail-choose">
                     <div class="top-choose-detail">
                       <h2>{{$hotel['details']['data']['name']}}</h2>
                     </div>
                     <div class="bottom-choose-detail text-center">
                       <div class="row">
                         <div class="col-md-5 col-sm-5">
                           <p>Check-in<br>{{myDay($hotel['checkin'])}}, {{date('d',strtotime($hotel['checkin']))}} {{myMonth($hotel['checkin'])}}</p>
                         </div>
                          <div class="col-md-5 col-sm-5">
                            <p>Check-out<br>{{myDay($hotel['checkout'])}}, {{date('d',strtotime($hotel['checkout']))}} {{myMonth($hotel['checkout'])}}</p>
                          </div>
                       </div>
                     </div>
                   </div>
                 </div>
                 <div class="col-md-3 col-sm-12">
                   <div class="all-total">
                     <div class="group-amount">
                        <label class="label-amount">Room :</label>
                        <label class="label-number">IDR {{number_format($price)}}</label>
                      </div>
                   </div>
                   <div class="group-amount">
                      <label class="label-amount">&nbsp;</label>
                      <label class="label-number">&nbsp;</label>
                  </div>
                  <div class="group-amount">
                      <label class="label-amount">&nbsp;</label>
                      <label class="label-number">&nbsp;</label>
                  </div>
                  <div class="group-amount">
                      <div class="line-tambah"></div>
                  </div>
                  <div class="group-amount">
                      <label class="label-amount">Total Biaya :</label>
                      <label class="label-number"><strong>IDR {{number_format($price)}}</strong></label>
                  </div>
                 </div>
               </div>
             </div>
             {{-- <div class="total-orange">
               <div class="group-amount">
                <label class="label-amount">Total :</label>
                <label class="label-number"><strong>IDR {{number_format($price)}}</strong></label>
              </div>
             </div> --}}
          </div>
        </div>
      </div>
    </section>
    <section class="form-list-hotel">
      <div class="container">
        <div class="col-md-8">
          <hr />
          <div class="left-section">
            <div class="summary-flight">
              <h3 class="orange-title">Data Tamu Inap</h3>
              <div class="table-responsive">
                <table class="table result-tab">
                  <tr>
                      <th>Title</th>
                      <th>Nama Lengkap</th>
                      <th>No. Telp</th>
                  </tr>
                  <tr>
                      <td>{{$request['title']}}</td>
                      <td>{{$request['name']}}</td>
                      <td>{{$request['phoneNumber']}}</td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          <div class="row" id="resultHotel">
            <div class="grey-box">
              <div class="caution-box">
                  <div class="warning-text">
                      <span>Penting:</span>
                      <ol>
                          <li>Data penginap harus sesuai KTP atau Passport.</li>
                          <li>Kesalahan dalam penulisan data menjadi tanggung jawab anda.</li>
                          <li>Pengisian nama data yang menginap harus lebih dari satu huruf.</li>
                          <li>Pastikan kontak pemesan dan kontak penginap dapat dihubungi,</li>
                      </ol>
                  </div>
              </div>
              <div class="checkbox">
                  <label>
                      <input type="checkbox" v-model="term" v-bind:true="true" v-bind:false="false"> Saya Memastikan bahwa data yang saya masukan adalah benar dan saya bertanggung jawab atas data yang telah saya masukan. Saya telah membaca dan menyetujui <a href="{{ route('sip.term') }}" target="_blank">Syarat dan Ketentuan SIP</a>.<br> <span class="label label-danger" v-show="errorTerm">Anda belum menyetujui syarat dan ketentuan SIP.</span>
                  </label>
              </div>
              <div class="captcha col-md-4 col-md-offset-8" id="formIssued">
                <div class="form-group">
                  <input type="password" class="form-control " v-model="password" name="password" placeholder="Password">
                </div>
                @if($user->point>=3)
                  <div class="row">
                      <div class="alert alert-success" role="alert">Anda memiliki <strong>{{ $user->point }} Point Reward</strong></div>
                  </div>
                  @if($user->point>=3)
                    <div class="form-inline">
                        <div class="form-group">
                            <label for="point">Gunakan Point Reward : </label>
                            <div class="input-group">
                                <select name="pr" id="point" v-model="pr">
                                    <option>0</option>
                                    <option>3</option>
                                </select>
                                <div class="input-group-addon">Point</div>
                            </div>
                        </div>
                    </div>
                  @endif
                  <br>
                @endif
                @if($user->deposit >= $price)
                  <button v-on:click="hotelsTransaction" class="btn btn-orange full-width pull-right" id="btnIssued">ISSUED</button>
                @else
                  <button class="btn btn-orange full-width pull-right" disabled="disabled">ISSUED</button>
                  <br />
                  <span style="color:red;">Saldo Anda tidak cukup</span>
                @endif
              </div>
              <div id="transactionLoader">
                  <div class="row">
                      <div class="col-md-2 col-md-offset-5"><img src='{{asset('/assets/images/Preloader_2.gif')}}' style='height: auto;width:auto;' class='img-responsive'></div>
                  </div>
              </div>
              <div v-if="failed">
                <div class="rows">
                    <div class="alert-custom alert alert-red alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <img class="icon-sign" src="{{asset('/assets/images/material/icon-02.png')}}">
                        <p><strong>Opps!</strong>@{{ errorMsg }}</p>
                    </div><!--end.alert-->
                </div>
              </div>
              <div v-if="success" >
                  <div class="rows">
                      <div class="alert-custom alert alert-green alert-dismissible" role="alert">
                          <img class="icon-sign" src="{{asset('/assets/images/material/icon-03.png')}}" style="vertical-align: top;">
                          <p><strong>Issued Berhasil!</strong><br>Silahkan klik data transaksi di bawah ini. <br><a href="{{route('hotels.reports')}}" class="btn btn-cari">DATA TRANSAKSI</a></p>
                      </div><!--end.alert-->
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
      Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
      Vue.http.options.emulateJSON = true;
      $('#transactionLoader').hide();
      var resultHotel= new Vue({
        el: '#resultHotel',
        data : {
          term: false,
          errorTerm: false,
          password: '',
          failed:false,
          errorMsg:'',
          pr:0,
          success: false,
        },
        methods: {
          hotelsTransaction: function() {
            if(this.term===true){
              this.failed=false;
              this.errorTerm=false;
              $('#formIssued').hide();
              $('#transactionLoader').show();
              window.request['password']=this.password;
              window.request['pr']=this.pr;
              window.request['checkin']='{{$hotel['checkin']}}';
              window.request['checkout']='{{$hotel['checkout']}}';
              window.request['room']='{{$hotel['room']}}';
              window.request['adt']='{{$hotel['adt']}}';
              window.request['chd']='{{$hotel['chd']}}';
              window.request['des']='{{$hotel['des']}}';
              window.request['selectedID']='{{$hotel['selectedID']}}';
              this.$http.post(window.url,window.request).then((response)=>{
                console.log(response.body);
                if(response.body.status.code==200){
                  $('#transactionLoader').hide();
                  this.success=true;
                }else if(response.body.status.code==401){
                  $('#transactionLoader').hide();
                  this.errorMsg=response.body.status.message;
                  this.failed=true;
                  $('#formIssued').show();
                }else{
                  $('#transactionLoader').hide();
                  this.errorMsg=response.body.status.message;
                  this.failed=true;
                }
              },(response)=>{
                  $('#transactionLoader').hide();
                  this.errorMsg='Terjadi error dari serever';
                  this.failed=true;
              })
            }else{
              this.errorTerm=true;
            }
            console.log('Transaction di click');
          }
        }
      });
    </script>
@endsection
