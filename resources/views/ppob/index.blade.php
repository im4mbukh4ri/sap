@extends('layouts.public')
@section('css')
    @parent
    <link href="{{ captcha_layout_stylesheet_url() }}" type="text/css" rel="stylesheet">
@endsection
@section('content')
    <div id="ppob">
        <section class="section-pilih-seat">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="blue-title-big">PPOB</h3>
                        <div id="dataSearch" class="box-orange">
                            <div class="row-form">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="services">Layanan</label>
                                            <select  v-model="serviceId" v-on:change="addProduct(serviceId)" class="form-control col-md-12">
                                                <option v-bind:value="0">Pilih layanan</option>
                                                <option v-for="service in services" v-bind:value="service.id" v-if="service.id!==1">@{{ service.name }}</option>
                                            </select>
                                        </div>
                                    </div><!--end.col-md-4-->
                                    <div class="col-md-3" v-if="showSelectOne">
                                        <div class="form-group">
                                            <label for="products">@{{ labelOne }}</label>
                                            <select  v-model="productId" v-on:change="addNominal(productId)" class="form-control col-md-12">
                                                <option v-bind:value=0>Pilih @{{ labelOne }}</option>
                                                <option v-for="product in products" v-bind:value="product.id">@{{ product.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3" v-if="showSelectTwo">
                                        <div class="form-group">
                                            <label for="products">@{{ labelTwo }}</label>
                                            <select  v-model="nominalCode" v-on:change="showform(nominalCode)" class="form-control col-md-12">
                                                <option v-bind:value="0">Pilih @{{ labelTwo }}</option>
                                                <option v-for="nominal in nominals" v-bind:value="nominal.id">@{{ nominal.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2" v-if="showInputNumber">
                                        <div class="form-group">
                                            <label for="number">@{{ labelThree }}</label>
                                            <input list="numberSaveds" type="text" v-model="number" name="number" @keydown="searchNumber" @mouseover="searchNumber" class="form-control" autocomplete="off">
                                            <datalist id="numberSaveds">
                                              <option v-for="listNumber in listNumbers" :value="listNumber.number"> @{{listNumber.name}} </option>
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <br>
                                        <button v-show="btn" type="button" v-on:click="inquery" class="btn btn-cari">
                                            Cek Harga
                                        </button>
                                    </div><!--end.col-md-4-->
                                </div><!--end.row-->
                            </div><!--end.row-form-->
                        </div><!--end.box-range-->
                    </div><!--end.col-md-12-->
                </div><!--end.row-->
            </div><!--end.container-->
        </section>

        <div class="row" v-show="loader">
          <div class="col-md-2 col-md-offset-5"><img src='{{asset('/assets/images/Preloader_2.gif')}}' style='height: auto;width:auto;' class='img-responsive'></div>
        </div>
        <section id="info-harga" v-show="showInquery">
       <div class="container">
           <div class="row">
               <div class="col-md-8">
                   <div class="left-section" v-if="showInquerySuccess">
                     <h3 class="orange-title">Informasi Harga</h3>
                     <div class="grey-box">
                         <label>Detail Produk:</label>
                         <div class="white-box">
                             <div class="detail-produk">
                                 <div  v-if="serviceId==2">
                                     <div class="row-group">
                                         <label>Nama</label>
                                         <div class="detail-label">@{{resultInquery.nama}}</div>
                                     </div>
                                     <div class="row-group">
                                         <label>No. Pelanggan</label>
                                         <div class="detail-label">@{{number}}</div>
                                     </div>
                                     <div class="row-group">
                                         <label>Golongan</label>
                                         <div class="detail-label">@{{resultInquery.tarif}}</div>
                                     </div>
                                     <div class="row-group">
                                         <label>Nominal</label>
                                         <div class="detail-label">IDR @{{ parseInt(nominals[(nominalCode==19)?0:(nominalCode==20)?1:(nominalCode==21)?2:(nominalCode==22)?3:(nominalCode==23)?4:(nominalCode==24)?5:6].code.substring(3)+'000') | addCommas}}</div>
                                     </div>
                                     <div class="row-group">
                                         <label>Admin</label>
                                         <div class="detail-label">IDR @{{ resultInquery.admin | addCommas }}</div>
                                     </div>
                                     <div class="row-group">
                                         <label>Harga</label>
                                         <div class="detail-label">IDR @{{ parseInt(nominals[(nominalCode==19)?0:(nominalCode==20)?1:(nominalCode==21)?2:(nominalCode==22)?3:(nominalCode==23)?4:(nominalCode==24)?5:6].code.substring(3)+'000')+parseInt(resultInquery.admin) | addCommas }}</div>
                                     </div>
                                     <div class="row-group">
                                         <label>Komisi</label>
                                         <div class="detail-label">IDR @{{ resultInquery.commission | addCommas }}</div>
                                     </div>
                                     <div class="row-group">
                                         <label>Smart Price</label>
                                         <div class="detail-label">IDR @{{ parseInt(nominals[(nominalCode==19)?0:(nominalCode==20)?1:(nominalCode==21)?2:(nominalCode==22)?3:(nominalCode==23)?4:(nominalCode==24)?5:6].code.substring(3)+'000')+parseInt(resultInquery.admin)-parseInt(resultInquery.commission) | addCommas }}</div>
                                     </div>
                                 </div>
                                 <div v-else>
                                     <div v-if="serviceId!=7">
                                         <div class="row-group">
                                             <label>Nama</label>
                                             <div class="detail-label">@{{resultInquery.nama}}</div>
                                         </div>
                                         <div class="row-group">
                                             <label>No. Pelanggan</label>
                                             <div class="detail-label">@{{number}}</div>
                                         </div>
                                         <div class="row-group" v-if="serviceId==8">
                                             <label>Nama Perusahaan</label>
                                             <div class="detail-label">@{{ resultInquery.pdam_name }}</div>
                                         </div>
                                         <div class="row-group" v-if="serviceId!=9&&serviceId!=348">
                                             <label>Periode</label>
                                             <div class="detail-label">@{{ resultInquery.periode }}</div>
                                         </div>
                                         <div class="row-group" v-if="serviceId==348">
                                             <label>Jumlah Tagihan</label>
                                             <div class="detail-label">IDR @{{ resultInquery.total | addCommas }}</div>
                                         </div>
                                         <div class="row-group" v-else>
                                           <label>Jumlah Tagihan</label>
                                           <div class="detail-label">IDR @{{ resultInquery.nominal | addCommas }}</div>
                                         </div>
                                         <div class="row-group">
                                             <label>Admin</label>
                                             <div class="detail-label">IDR @{{ resultInquery.admin | addCommas }}</div>
                                         </div>
                                         <div class="row-group" v-if="serviceId!=348">
                                             <label>Harga</label>
                                             <div class="detail-label">IDR @{{resultInquery.total | addCommas }}</div>
                                         </div>
                                         <div class="row-group">
                                             <label>Komisi</label>
                                             <div class="detail-label">IDR @{{ resultInquery.commission | addCommas }}</div>
                                         </div>
                                         <div class="row-group" v-if="serviceId!=348">
                                             <label>Smart Price</label>
                                             <div class="detail-label">IDR @{{ parseInt(resultInquery.total)-parseInt(resultInquery.commission) | addCommas }}</div>
                                         </div>
                                     </div>
                                     <div v-else>
                                         <div class="row-group">
                                             <label>Nama</label>
                                             <div class="detail-label">@{{resultInquery.nama}}</div>
                                         </div>
                                         <div class="row-group">
                                             <label>No. Pelanggan</label>
                                             <div class="detail-label">@{{number}}</div>
                                         </div>
                                         <div class="row-group">
                                             <label>No. Polisi</label>
                                             <div class="detail-label">@{{ resultInquery.no_polisi }}</div>
                                         </div>
                                         <div class="row-group">
                                             <label>Cicilan ke-</label>
                                             <div class="detail-label">@{{ resultInquery.tenor }}</div>
                                         </div>
                                         <div class="row-group">
                                             <label>Jatuh tempo</label>
                                             <div class="detail-label">@{{ resultInquery.tempo }}</div>
                                         </div>
                                         <div class="row-group">
                                             <label>Jumlah Tagihan</label>
                                             <div class="detail-label">IDR @{{ resultInquery.nominal | addCommas }}</div>
                                         </div>
                                         <div class="row-group">
                                             <label>Admin</label>
                                             <div class="detail-label">IDR @{{ resultInquery.admin | addCommas }}</div>
                                         </div>
                                         <div class="row-group">
                                             <label>Harga</label>
                                             <div class="detail-label">IDR @{{resultInquery.total | addCommas }}</div>
                                         </div>
                                         <div class="row-group">
                                             <label>Komisi</label>
                                             <div class="detail-label">IDR @{{ resultInquery.commission | addCommas }}</div>
                                         </div>
                                         <div class="row-group">
                                             <label>Smart Price</label>
                                             <div class="detail-label">IDR @{{ parseInt(resultInquery.total)-parseInt(resultInquery.commission) | addCommas }}</div>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row-group">
                                     <label>Status</label>
                                     <div class="detail-label"><span class="tersedia">Tersedia</span></div>
                                 </div>
                             </div>
                         </div>
                         <div class="checkbox">
                           <label>
                               <input type="checkbox"  v-model="term" v-bind:true="true" v-bind:false="false"> Saya Memastikan bahwa data yang saya masukan adalah benar dan saya bertanggung jawab atas data yang telah saya masukan. Saya telah membaca dan menyetujui Syarat dan Ketentuan SIP
                           </label>
                             <br> <span class="label label-danger" v-show="errorTerm">Anda belum menyetujui syarat dan ketentuan SIP.</span>
                         </div>
                         <div class="checkbox" v-if="serviceId!=348">
                           <label>
                               <input type="checkbox"  v-model="saveNumber" v-bind:true="true" v-bind:false="false"> Simpan nomor
                               <br />
                               <span v-show="saveNumber" style="color:"><sup>*</sup>Maksimal 10 nomor / Layanan</span>
                           </label>
                         </div>
                         <div class="row" v-if="resultInquery.user_point > 0">
                             <div class="alert alert-success" role="alert">Anda memiliki @{{ resultInquery.user_point }}<strong> Point Reward</strong></div>
                         </div>
                         <div class="row" id="formValidation" >
                             <div class="form-inline">
                                 <span v-if="resultInquery.user_point >= resultInquery.max_point">
                                     {{--<div class="form-group" v-if="resultInquery.user_point < resultInquery.max_point">--}}
                                         <label for="point">Gunakan Point Reward : </label>
                                         <div class="input-group" >
                                             <select name="pr" id="point" v-model="pr">
                                                 <option>0</option>
                                                 <option>@{{ resultInquery.max_point }}</option>
                                             </select>
                                             <div class="input-group-addon">Point</div>
                                         </div>
                                     {{--</div>--}}
                                     {{--<div class="form-group" v-else>--}}
                                         {{--<label for="point">Gunakan Point Reward : </label>--}}
                                         {{--<div class="input-group">--}}
                                             {{--<select name="pr" id="point" v-model="pr">--}}
                                                 {{--<option>0</option>--}}
                                                 {{--<option v-for="n in resultInquery.max_point">@{{ n }}</option>--}}
                                             {{--</select>--}}
                                             {{--<div class="input-group-addon">Point</div>--}}
                                         {{--</div>--}}
                                     {{--</div>--}}
                                 </span>
                                 <div class="form-group" v-if="serviceId==348">
                                     <div class="col-sm-12">
                                         <label for="point">Masukan nominal yang ingin dibayarkan : </label>
                                         <input type="number" class="form-control" name="nominal" v-model="nominal" id="nominal" placeholder="Masukan nominal" autocomplete="off">
                                     </div>
                                 </div><br />
                                 <div class="form-group">
                                     <div class="col-sm-12">
                                         <input type="password" class="form-control" name="password" v-model="password" id="password" placeholder="Password" autocomplete="off">
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <div class="col-sm-12">
                                         <button  v-on:click="ppobTransaction" class="btn btn-orange full-width" id="btnBuy">BELI</button>
                                     </div>
                                 </div>
                             </div>
                             <br>
                         </div>
                         <div v-if="errorPassword" >
                             <div class="rows">
                                 <div class="alert-custom alert alert-red alert-dismissible" role="alert"><img class="icon-sign" src="{{asset('/assets/images/material/icon-02.png')}}">
                                     <p><strong>Opps!</strong> Password tidak boleh kosong.</p>
                                 </div><!--end.alert-->
                             </div>
                         </div>
                         <div id="transactionLoader">
                             <div class="row">
                                 <div class="col-md-2 col-md-offset-5"><img src='{{asset('/assets/images/Preloader_2.gif')}}' style='height: auto;width:auto;' class='img-responsive'></div>
                             </div>
                         </div>
                         <div v-if="failed" >
                             <div class="rows">
                                 <div class="alert-custom alert alert-red alert-dismissible" role="alert"><img class="icon-sign" src="{{asset('/assets/images/material/icon-02.png')}}">
                                     <p><strong>Opps!</strong> Terjadi kesalahan</p>
                                     <ul>
                                         <li v-for="val in result.status.message" style="color: #F0F0F0;">@{{ val }}</li>
                                     </ul>
                                     <br>
                                     <div v-if="result.status.message[0]=='Password tidak sesuai'">
                                         <div class="form-group">
                                             <label class="sr-only" for="password">Password</label>
                                             <input type="password" class="form-control" name="password" v-model="password" id="password" placeholder="Password" autocomplete="off">
                                         </div>
                                         <button  v-on:click="ppobTransaction" class="btn btn-default" id="btnBuy">BELI</button>
                                     </div>
                                 </div><!--end.alert-->
                             </div>
                         </div>
                         <div v-if="success" >
                             <div class="rows">
                                 <div class="alert-custom alert alert-green alert-dismissible" role="alert">
                                     <img class="icon-sign" src="{{asset('/assets/images/material/icon-03.png')}}"  style="vertical-align: top;">
                                     <p><strong>Pembelian Berhasil!</strong><br>Silahkan klik data transaksi di bawah ini. <br><a href="{{route('ppob.reports')}}" class="btn btn-cari">DATA TRANSAKSI</a></p>
                                 </div><!--end.alert-->
                             </div>
                             <div class="rows" v-if="serviceId==2">
                                 <h3 class="orange-title">Informasi Transaksi</h3>
                                 <div class="grey-box">
                                     <div class="white-box">
                                         <div class="row-group">
                                             <label>Nama</label>
                                             <div class="detail-label">@{{result.details.detail_transaction.customer_name}}</div>
                                         </div>
                                         <div class="row-group">
                                             <label>Golongan / Daya</label>
                                             <div class="detail-label">@{{result.details.detail_transaction.golongan_daya}}</div>
                                         </div>
                                         <div class="row-group">
                                             <label>Nominal</label>
                                             <div class="detail-label">IDR @{{result.details.detail_transaction.nominal | addCommas }}</div>
                                         </div>
                                         <div class="row-group">
                                             <label>Admin</label>
                                             <div class="detail-label">IDR @{{result.details.detail_transaction.admin | addCommas }}</div>
                                         </div>
                                         <div class="row-group">
                                             <label>Rp Token</label>
                                             <div class="detail-label">IDR @{{result.details.detail_transaction.rp_token | addCommas }}</div>
                                         </div>
                                         <div class="row-group">
                                             <label>PPn</label>
                                             <div class="detail-label">IDR @{{result.details.detail_transaction.ppn | addCommas }}</div>
                                         </div>
                                         <div class="row-group">
                                             <label>PPj</label>
                                             <div class="detail-label">IDR @{{result.details.detail_transaction.ppj | addCommas }}</div>
                                         </div>
                                         <div class="row-group">
                                             <label>Materai</label>
                                             <div class="detail-label">IDR @{{result.details.detail_transaction.materai | addCommas }}</div>
                                         </div>
                                         <div class="row-group">
                                             <label>TOKEN</label>
                                             <div class="detail-label"><strong style="color: red;">@{{ result.details.detail_transaction.token }}</strong></div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div><!--end.grey-box-->
                   </div><!--end.left-section-->
                   <div class="left-section" v-else>
                       <div class="alert-custom alert alert-red alert-dismissible" role="alert" v-if="showInqueryFailed">
                           <img class="icon-sign" src="{{asset('/assets/images/material/icon-02.png')}}">
                           <p><strong>Opps!</strong> Terjadi Kesalahan ! Error:500</p>
                       </div><!--end.alert-->
                       <div class="alert-custom alert alert-red alert-dismissible" role="alert" v-else>
                           <img class="icon-sign" src="{{asset('/assets/images/material/icon-02.png')}}">
                           <p><strong>Opps!</strong> @{{ resultInquery.error_msg }}</p>
                       </div>
                   </div>
               </div><!--end.col-->
               <div class="col-md-4">
                   <div class="right-section" v-if="showInquerySuccess">
                       <div class="right-info">
                           <h3 class="orange-title">Ketentuan Umum</h3>
                           <div class="white-box">
                               <div class="row-ketentuan">Pastikan ID pelanggan yang Anda masukan telah benar sebelum melanjutkan proses pembelian</div><!--end.row-ketentuan-->
                               <div class="row-ketentuan">Jika Anda salah memasukan ID pelanggan dan proses pembelian telah sukses maka transaksi tersebut tidak bisa dibatalkan / refund</div><!--end.row-ketentuan-->
                               <div class="row-ketentuan">Ketika proses pembelian gagal secara otomatis saldo yang terpotong akan di refund.</div><!--end.row-ketentuan-->
                           </div><!--end.white-box-->
                       </div>
                   </div><!--end.right-section-->
               </div><!--end.col-->
           </div><!--end.row-->
       </div><!--end.container-->
   </section>
    </div>
@endsection
@section('js')
    @parent

    <script src="{{url('/')}}/captcha-handler?get=bdc-script-include.js" type="text/javascript"></script>
    <script>
        $('#transactionLoader').hide();
        Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
        Vue.http.options.emulateJSON = true;
        Vue.component('component-captcha',{
            template:'#captcha'
        });
        var ppob = new Vue({
            el:"#ppob",
            data:{
                url:'{{route('rest.ppob_services')}}',
                urlSearch:'{{route('rest.number_saveds')}}',
                username:'',
                password:'',
                services:null,
                products:null,
                nominals:null,
                serviceId:0,
                productId:0,
                nominalCode:0,
                labelOne:'',
                labelTwo:'',
                labelThree:'',
                showSelectOne:false,
                showSelectTwo:false,
                btn:false,
                showInputNumber:false,
                showInquery:false,
                showInquerySuccess:false,
                showInqueryFailed:false,
                loader:false,
                term:false,
                saveNumber:false,
                errorTerm:false,
                number:null,
                reff:'',
                attributes:{},
                errorPassword:false,
                pr:0,
                nominal,
                listNumbers:[
                  {"number":"","name":""},
                ],
                resultInquery:[
                    {'error_msg':null}
                ],
                price:null,
                failed:false,
                success:false,
                result:null
            },
            filters:{
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
            methods:{
                  searchNumber:function(){
                  endSearchUrl=this.urlSearch+"?service="+this.serviceId;
                  this.$http.get(endSearchUrl)
                    .then((response)=>{
                      console.log(response.data);
                      this.listNumbers=response.data;
                    },(response)=>{
                      console.log("FAILED search number");
                    });
                },
                addServices:function () {
                    this.$http.get(this.url).then((response)=>{
                        this.services=response.data.detail.services;
                    },(response)=>{
                        console.log("FAILED")
                    });
                },
                addProduct:function(serviceId){
                    console.log(serviceId);
                    this.showInquery=false;
                    this.showInquery=false;
                    this.showInquerySuccess=false;
                    this.showInqueryFailed=false;
                    this.success=false;
                    this.failed=false;
                    this.password='';
                    this.number=null;
                    this.code="";
                    this.reff='';
                    this.products=null;
                    this.nominals=null;
                    this.errorPassword=false;
                    this.resultInquery=[
                        {'error_msg':null}
                    ];
                    this.attributes={};
                    this.price=null;
                    this.nominalCode=0;
                    this.term=false;
                    this.errorTerm=false;
                    if(serviceId!=0){
                        if(serviceId==3){
                            this.showSelectOne=false;
                            switch (serviceId){
                                case 3 :
                                    this.labelThree="No. Pelanggan";
                                    this.showSelectOne=false;
                                    this.showSelectTwo=false;
                                    this.showform(serviceId);
                                    break;
                            }
                        }else{
                            this.showInputNumber=false;
                            this.showSelectOne=true;
                            this.btn=false;
                            if(serviceId==2){
                                this.showSelectOne=false;
                                this.addNominal(serviceId);
                            }else{
                                this.productId=0;
                                this.showform(0);
                                this.showSelectTwo=false;
                                var endPoint = this.url+'?service_id='+serviceId;
                                this.labelOne='Produk';
                                this.$http.get(endPoint).then((response)=>{
                                    this.products=response.data.detail.services;
                                },(response)=>{
                                    console.log("FAILED")
                                });
                            }
                        }
                    }else{
                        this.showSelectOne=false;
                        this.showSelectTwo=false;
                        this.showform(serviceId);
                    }
                    return serviceId;
                },
                addNominal:function(productId){
                    this.showInquery=false;
                    this.showInquerySuccess=false;
                    this.showInqueryFailed=false;
                    this.errorPassword=false;
                    if(productId==0||productId==30||this.serviceId==4||this.serviceId==7||this.serviceId==6||this.serviceId==8||this.serviceId==9){
                        this.nominalCode=0;
                        this.showSelectTwo=false;
                        this.showform(0);
                        if(productId==30||this.serviceId==7||this.serviceId==6||this.serviceId==8||this.serviceId==4||this.serviceId==9){
                            this.nominalCode=productId;
                            this.showform(30);
                        }
                    }else{
                        this.showform(0);
                        this.nominalCode=0;
                        this.labelTwo="Nominal";
                        this.showSelectTwo=true;
                        var endPoint = this.url+'?service_id='+productId;
                        this.$http.get(endPoint).then((response)=>{
                            this.nominals=response.data.detail.services;
                          },(response)=>{
                            console.log("FAILED");
                        });
                    }
                },
                showform:function(value){
                    this.showInquery=false;
                    this.showInquerySuccess=false;
                    this.showInqueryFailed=false;
                    var code = value;
                    if(value==undefined){
                        code = this.nominalCode;
                    }
                    if(code==0){
                        this.labelThree='';
                        this.showInputNumber=false;
                        this.btn=false;
                    }else{
                        this.labelThree='Masukan No.';
                        this.showInputNumber=true;
                        this.btn=true;
                    }
                },
                inquery:function(){
                    this.loader=true;
                    this.showInquery=false;
                    this.showInquerySuccess=false;
                    this.showInqueryFailed=false;
                    this.failed=false;
                    this.success=false;
                    this.term=false;
                    this.password='';
                    this.errorPassword=false;
                    this.errorTerm=false;
                  var endPoint='{{route('ppob.inquery')}}';
                  var attributes={'serviceId':this.serviceId,'nominalCode':this.nominalCode,'number':this.number};
                  if(this.number!=null){
                    this.$http.post(endPoint,attributes).then((response)=>{
                        this.loader=false;
                        this.resultInquery=response.data;
                        if(response.data.error_code=='000'){
                            if(this.serviceId!=2){
                                this.reff=this.resultInquery.reff;
                                this.price=this.resultInquery.total;
                            }
                            this.showInquery=true;
                            this.showInquerySuccess=true;
                        }else {
                            this.showInquery=true;
                        }
                      },(response)=>{
                          this.showInquery=true;
                          this.showInqueryFailed=true;
                        this.loader=false;
                    });
                  }else{
                    console.log("Number = null");
                  }
                },
                ppobTransaction:function (){
                    this.errorPassword=false;
                    if(this.term===true){
                        if(this.password.trim()!=''){
                            this.errorTerm=false;
                            $('#transactionLoader').show();
                            $('#formValidation').hide();
//                        console.log(this.serviceId);
//                        console.log(this.number);
//                        console.log(this.code);
//                        console.log(this.resultInquery.admin);
//                        console.log(this.resultInquery.commission);
//                        console.log(this.price);
//                        console.log(this.password);
//                        console.log(this.nominalCode);
                            if(this.serviceId=='2'){
                                this.attributes={'password':this.password,'number':this.number,'code':this.nominalCode,'admin':parseInt(this.resultInquery.admin),'commission':parseInt(this.resultInquery.commission),'service_id':this.serviceId,'pr':this.pr,'save_number':this.saveNumber,'name':this.resultInquery.nama};
                            }else if(this.serviceId=='3'){
                                this.attributes={'password':this.password,'number':this.number,'code':this.serviceId,'admin':parseInt(this.resultInquery.admin),'commission':parseInt(this.resultInquery.commission),'service_id':this.serviceId,'price':this.price,'pr':this.pr,'save_number':this.saveNumber,'name':this.resultInquery.nama};
                            }else if(this.serviceId=='4'){
                                this.attributes={'password':this.password,'number':this.number,'code':this.nominalCode,'admin':parseInt(this.resultInquery.admin),'commission':parseInt(this.resultInquery.commission),'service_id':this.serviceId,'reff':this.reff,'price':this.price,'pr':this.pr,'save_number':this.saveNumber,'name':this.resultInquery.nama};
                            }else if(this.serviceId=='5'){
                                this.attributes={'password':this.password,'number':this.number,'code':this.nominalCode,'admin':parseInt(this.resultInquery.admin),'commission':parseInt(this.resultInquery.commission),'service_id':this.serviceId,'reff':this.reff,'price':this.price,'pr':this.pr,'save_number':this.saveNumber,'name':this.resultInquery.nama};
                            }else if(this.serviceId=='6'){
                                this.attributes={'password':this.password,'number':this.number,'code':this.nominalCode,'admin':parseInt(this.resultInquery.admin),'commission':parseInt(this.resultInquery.commission),'service_id':this.serviceId,'reff':this.reff,'price':this.price,'pr':this.pr,'save_number':this.saveNumber,'name':this.resultInquery.nama};
                            }else if(this.serviceId=='7'){
                                this.attributes={'password':this.password,'number':this.number,'code':this.nominalCode,'admin':parseInt(this.resultInquery.admin),'commission':parseInt(this.resultInquery.commission),'service_id':this.serviceId,'reff':this.reff,'price':this.price,'pr':this.pr,'save_number':this.saveNumber,'name':this.resultInquery.nama};
                            }else if(this.serviceId=='8'){
                                this.attributes={'password':this.password,'number':this.number,'code':this.nominalCode,'admin':parseInt(this.resultInquery.admin),'commission':parseInt(this.resultInquery.commission),'service_id':this.serviceId,'reff':this.reff,'price':this.price,'pr':this.pr,'save_number':this.saveNumber,'name':this.resultInquery.nama};
                            }else if(this.serviceId=='9'){
                                this.attributes={'password':this.password,'number':this.number,'code':this.nominalCode,'admin':parseInt(this.resultInquery.admin),'service_id':this.serviceId,'reff':this.reff,'price':this.price,'save_number':this.saveNumber,'name':this.resultInquery.nama};
                            }else if(this.serviceId=='18'){
                              this.attributes={'password':this.password,'number':this.number,'code':this.nominalCode,'admin':parseInt(this.resultInquery.admin),'commission':parseInt(this.resultInquery.commission),'service_id':this.serviceId,'price':this.price,'pr':this.pr,'save_number':this.saveNumber,'name':this.resultInquery.nama};
                            }else if(this.serviceId=='348'){
                              this.attributes={'password':this.password,'number':this.number,'code':this.nominalCode,'admin':parseInt(this.resultInquery.admin),'commission':parseInt(this.resultInquery.commission),'service_id':this.serviceId,'price':this.price,'pr':this.pr,'save_number':this.saveNumber,'name':this.resultInquery.nama,'nominal':this.nominal};
                            }
                            console.log(this.attributes);
                            this.$http.post(window.url,this.attributes).then((response)=>{
                                this.failed=false;
                            console.log("Berhasil");
                            console.log(response.data);
                            this.result=response.data;
                            this.password="";
//                        console.log(this.result.status.code);
                            $('#transactionLoader').hide();
                            if(this.result.status.code==200){
                                return this.success=true;
                            }else{
                                console.log(this.result.status.message);
                                return this.failed=true;
                            }
                        },(response)=>{
                                console.log("GAGAL BRO");
                                console.log(response.data);
                                $('#transactionLoader').hide();
                                this.failed=true;
                            });
                        }else{
                            this.errorPassword=true;
                        }
                    }else{
                        this.errorTerm=true;
                        console.log("NOTERM");
                    }
                }
            },
            mounted:function () {
                this.loader=true;
                this.addServices();
                this.addProduct(request.service_id);
                switch (request.service_id){
                    case '1':
                        this.addNominal(request.product_id);
                        this.showform(request.nominal_code);
                        break;
                    case '2':
                        this.showform(request.nominal_code);
                        break;
                    case '3':
                        this.showform(request.service_id);
                        break;
                    case '4':
                        this.addProduct(request.service_id);
                        this.showform(request.service_id);
                        break;
                    case '5':
                        this.addProduct(request.service_id);
                        this.showform(request.service_id);
                        break;
                    case '6':
                        this.addProduct(request.service_id);
                        this.showform(request.service_id);
                        break;
                    case '7':
                        this.addProduct(request.service_id);
                        this.showform(request.service_id);
                        break;
                    case '8':
                        this.addProduct(request.service_id);
                        this.showform(request.service_id);
                        break;
                    case '9':
                        this.addProduct(request.service_id);
                        this.showform(request.service_id);
                        break;
                    case '348':
                        this.addProduct(request.service_id);
                        this.showform(request.service_id);
                        break;
                }

//                console.log(request.service_id);
            }});
        function stateChange(newState) {
            setTimeout(function () {
                if (newState == -1) {
                    switch (request.service_id){
                        case '1':
                            ppob.serviceId=request.service_id;
                            ppob.productId=request.product_id;
                            ppob.nominalCode=request.nominal_code;
                            ppob.number=request.number;
                            break;
                        case '2':
                            ppob.serviceId=request.service_id;
                            ppob.nominalCode=request.nominal_code;
                            ppob.number=request.number;
                            break;
                        case '3':
                            ppob.serviceId=request.service_id;
                            ppob.number=request.number;
                            break;
                        case '4':
                            ppob.serviceId=request.service_id;
                            ppob.productId=request.product_id;
                            ppob.nominalCode=request.product_id;
                            ppob.number=request.number;
                            break;
                        case '5':
                            ppob.serviceId=request.service_id;
                            ppob.productId=request.product_id;
                            ppob.nominalCode=request.product_id;
                            ppob.number=request.number;
                            break;
                        case '6':
                            ppob.serviceId=request.service_id;
                            ppob.productId=request.product_id;
                            ppob.nominalCode=request.product_id;
                            ppob.number=request.number;
                            break;
                        case '7':
                            ppob.serviceId=request.service_id;
                            ppob.productId=request.product_id;
                            ppob.nominalCode=request.product_id;
                            ppob.number=request.number;
                            break;
                        case '8':
                            ppob.serviceId=request.service_id;
                            ppob.productId=request.product_id;
                            ppob.nominalCode=request.product_id;
                            ppob.number=request.number;
                            break;
                        case '9':
                            ppob.serviceId=request.service_id;
                            ppob.productId=request.product_id;
                            ppob.nominalCode=request.product_id;
                            ppob.number=request.number;
                            break;
                        case '18':
                            ppob.serviceId=request.service_id;
                            ppob.productId=request.product_id;
                            ppob.nominalCode=request.nominal_code;
                            ppob.number=request.number;
                            break;
                        case '348':
                            ppob.serviceId=request.service_id;
                            ppob.productId=request.product_id;
                            ppob.nominalCode=request.product_id;
                            ppob.number=request.number;
                            break;
                    }
                    ppob.inquery();
                }
            }, 1000);
        }
        stateChange(-1);
    </script>
@endsection
