@extends('layouts.public')
@section('css')
    @parent
    <link href="{{ captcha_layout_stylesheet_url() }}" type="text/css" rel="stylesheet">
@endsection
@section('content')
    <div id="voucher">
        <section class="section-pilih-seat">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="blue-title-big">Voucher Game</h3>
                        <div id="dataSearch" class="box-orange">
                            <div class="row-form">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="services">Voucher</label>
                                            <select  v-model="serviceId" v-on:change="addProduct(serviceId)" class="form-control col-md-12">
                                                <option v-bind:value="0">Pilih voucher</option>
                                                <option v-for="service in services" v-bind:value="service.id" v-if="service.id!==1">@{{ service.name }}</option>
                                            </select>
                                        </div>
                                    </div><!--end.col-md-4-->
                                    <div class="col-md-3" v-if="showSelectOne">
                                        <div class="form-group">
                                            <label for="products">@{{ labelOne }}</label>
                                            <select  v-model="productId" v-on:change="showform(productId)" class="form-control col-md-12">
                                                <option v-bind:value=0>Pilih @{{ labelOne }}</option>
                                                <option v-for="product in products" v-bind:value="product.id">@{{ product.name }}</option>
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
                               <div class="row-group">
                                   <label>Nama</label>
                                   <div class="detail-label">@{{resultInquery.nama}}</div>
                               </div>
                               <div class="row-group">
                                   <label>No. Pelanggan</label>
                                   <div class="detail-label">@{{number}}</div>
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
                         <div class="row" v-if="resultInquery.user_point > 0">
                             <div class="alert alert-success" role="alert">Anda memiliki @{{ resultInquery.user_point }}<strong> Point Reward</strong></div>
                         </div>
                         <div class="row" id="formValidation" >
                             <div class="form-inline">
                                 <span v-if="resultInquery.user_point >= resultInquery.max_point">
                                         <label for="point">Gunakan Point Reward : </label>
                                         <div class="input-group" >
                                             <select name="pr" id="point" v-model="pr">
                                                 <option>0</option>
                                                 <option>@{{ resultInquery.max_point }}</option>
                                             </select>
                                             <div class="input-group-addon">Point</div>
                                         </div>
                                 </span>
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
        var voucher = new Vue({
          el: '#voucher',
          data: {
            url:'{{route('rest.ppob_services')}}',
            urlSearch:'{{route('rest.number_saveds')}}',
            services : null,
            products:null,
            nominals:null,
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
            showSelectOne:!1,
            showSelectTwo:!1,
            btn:!1,
            showInputNumber:!1,
            showInquery:!1,
            showInquerySuccess:!1,
            showInqueryFailed:!1,
            loader:!1,
            term:!1,
            saveNumber:!1,
            errorTerm:!1,
            number:null,
            reff:'',
            attributes:{},
            errorPassword:!1,
            pr:0,
            listNumbers:[
                {
                    "number":"",
                    "name":""
                }
            ],
            resultInquery:[
                {
                    'error_msg':null
                }
            ],
            price:null,
            failed:!1,
            success:!1,
            result:null
          },
          filters:{
              addCommas:function(nStr){
                  nStr+='';x=nStr.split('.');
                  x1=x[0];x2=x.length>1?'.'+x[1]:'';
                  var rgx=/(\d+)(\d{3})/;
                  while(rgx.test(x1)){
                      x1=x1.replace(rgx,'$1'+','+'$2')
                  }
                  return x1+x2
              }
          },
          methods: {
            addVouchers:function(){
                console.log('Sukses');
                this.$http.get(this.url+'?service_id=18').then((response)=>{
                    this.services=response.data.detail.services
                },
                (response)=>{})
            },
            addProduct:function(serviceId){
                this.showInquery=!1;
                this.showInquerySuccess=!1;
                this.showInqueryFailed=!1;
                this.success=!1;
                this.failed=!1;
                this.password='';
                this.number=null;
                this.code="";
                this.reff='';
                this.products=null;
                this.nominals=null;
                this.errorPassword=!1;
                this.resultInquery=[
                    {
                        'error_msg':null
                    }
                ];
                this.attributes={};
                this.price=null;
                this.nominalCode=0;
                this.term=!1;this.errorTerm=!1;
                if(serviceId!=0){
                    if(serviceId==3){
                        this.showSelectOne=!1;
                        switch(serviceId){
                            case 3:this.labelThree="No. Pelanggan";
                            this.showSelectOne=!1;
                            this.showSelectTwo=!1;
                            this.showform(serviceId);
                            break}
                    }
                    else{
                        this.showInputNumber=!1;
                        this.showSelectOne=!0;
                        this.btn=!1;
                        if(serviceId==2){
                            this.showSelectOne=!1;
                            this.addNominal(serviceId)
                        }
                        else{
                            this.productId=0;
                            this.showform(0);
                            this.showSelectTwo=!1;
                            var endPoint=this.url+'?service_id='+serviceId;
                            this.labelOne='Nominal';
                            this.$http.get(endPoint).then((response)=>{
                                this.products=response.data.detail.services
                            },
                            (response)=>{})
                        }
                    }
                }
                else{
                    this.showSelectOne=!1;
                    this.showSelectTwo=!1;
                    this.showform(serviceId)
                }
                return serviceId
            },
            showform:function(value){
                this.showInquery=!1;
                this.showInquerySuccess=!1;
                this.showInqueryFailed=!1;
                var code=value;
                if(value==undefined){
                    code=this.nominalCode
                }
                if(code==0){
                    this.labelThree='';
                    this.showInputNumber=!1;
                    this.btn=!1
                }
                else{
                    this.labelThree='Masukan No.';
                    this.showInputNumber=!0;
                    this.btn=!0
                }
            },
            addNominal:function(productId){
                this.showInquery=!1;
                this.showInquerySuccess=!1;
                this.showInqueryFailed=!1;
                this.errorPassword=!1;
                if(productId==0||productId==30||this.serviceId==4||this.serviceId==7||this.serviceId==6||this.serviceId==8||this.serviceId==9||this.serviceId==348){
                    this.nominalCode=0;
                    this.showSelectTwo=!1;
                    this.showform(0);
                    if(productId==30||this.serviceId==7||this.serviceId==6||this.serviceId==8||this.serviceId==4||this.serviceId==9||this.serviceId==348){
                        this.nominalCode=productId;
                        this.showform(30)
                    }
                }
                else{
                    this.showform(0);
                    this.nominalCode=0;
                    this.labelTwo="Nominal";
                    this.showSelectTwo=!0;
                    var endPoint=this.url+'?service_id='+productId;
                    this.$http.get(endPoint).then((response)=>{
                        this.nominals=response.data.detail.services
                    },(response)=>{})
                }
            },
            searchNumber:function(){
                endSearchUrl=this.urlSearch+"?service="+this.serviceId;
                this.$http.get(endSearchUrl).then((response)=>{
                    this.listNumbers=response.data
                },
                (response)=>{})
            },
            inquery:function(){
                this.loader=!0;
                this.showInquery=!1;
                this.showInquerySuccess=!1;
                this.showInqueryFailed=!1;
                this.failed=!1;
                this.success=!1;
                this.term=!1;
                this.password='';
                this.errorPassword=!1;
                this.errorTerm=!1;
                var endPoint='{{route('voucher.inquery')}}';
                var attributes={
                    'serviceId':18,
                    'nominalCode':this.productId,
                    'number':this.number
                };
                if(this.number!=null){
                    this.$http.post(endPoint,attributes).then((response)=>{
                        this.loader=!1;
                        this.resultInquery=response.data;
                        if(response.data.error_code=='000'){
                            if(this.serviceId!=2){
                                this.reff=this.resultInquery.reff;
                                this.price=this.resultInquery.total
                            }
                            this.showInquery=!0;
                            this.showInquerySuccess=!0
                        }
                        else{
                            this.showInquery=!0
                        }
                    },
                    (response)=>{
                        this.showInquery=!0;
                        this.showInqueryFailed=!0;
                        this.loader=!1
                    })
                }
            },
            ppobTransaction:function(){
                this.errorPassword=!1;
                if(this.term===!0){
                    if(this.password.trim()!=''){
                        this.errorTerm=!1;
                        $('#transactionLoader').show();
                        $('#formValidation').hide();
                        this.attributes={
                            'password':this.password,
                            'number':this.number,
                            'code':this.serviceId,
                            'admin':parseInt(this.resultInquery.admin),
                            'commission':parseInt(this.resultInquery.commission),
                            'service_id':this.serviceId,
                            'price':this.price,
                            'pr':this.pr,
                            'save_number':this.saveNumber,
                            'name':this.resultInquery.nama
                        }
                        this.$http.post(window.url,this.attributes).then((response)=>{
                            this.failed=!1;
                            this.result=response.data;
                            this.password="";
                            $('#transactionLoader').hide();
                            if(this.result.status.code==200){
                                return this.success=!0
                            }
                            else{
                                return this.failed=!0
                            }
                        },
                        (response)=>{
                            $('#transactionLoader').hide();
                            this.failed=!0
                        })
                    }
                    else{
                        this.errorPassword=!0
                    }
                }
                else{
                    this.errorTerm=!0;
                    console.log("NOTERM")
                }
            }
          },
          mounted:function(){
            this.loader=true;
            this.addVouchers()
            this.addProduct(request.service_id);
            this.showform(request.product_id);
          }
        })
        function stateChange(newState) {
            setTimeout(function () {
                if (newState == -1) {
                  voucher.serviceId=request.service_id;
                  voucher.productId=request.product_id;
                  voucher.number=request.number;
                  voucher.inquery();
                }
            }, 1000);
        }
        stateChange(-1);
    </script>
@endsection
