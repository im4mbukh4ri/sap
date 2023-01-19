@extends('layouts.public')
@section('css')
    @parent
@endsection
@section('content')
    <div id="pulsa">
        <section class="section-pilih-seat">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="blue-title-big">PULSA</h3>
                        <div id="dataSearch" class="box-orange">
                            <div class="row-form">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="phoneNumber">No. Handphone</label>
                                            <input type="text" name="phoneNumber" v-model="phoneNumber" id="phoneNumber">
                                        </div>
                                    </div>
                                    <div class="col-md-4" v-if="nominalInput">
                                        <div class="form-group">
                                            <label>Nominal</label>
                                            <select v-model="code" name="code" id="code" class="form-control">
                                                <option v-for="nominal in nominals"  v-bind:value="nominal.value">@{{ nominal.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button class="btn btn-cari" v-if="btnInquery" v-on:click="inquery" ><i class="fa fa-money"></i> Cek Harga</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                                            <img :src="logo" class="img-responsive" style="height: 75px;width: auto;display: block;margin: auto;">
                                        </div>
                                        <div class="row-group">
                                            <label>Produk</label>
                                            <div class="detail-label">@{{resultInquery.details.name}}</div>
                                        </div>
                                        <div class="row-group">
                                            <label>No. Handphone</label>
                                            <div class="detail-label">@{{phoneNumber}}</div>
                                        </div>
                                        <div class="row-group">
                                            <label>Market Price</label>
                                            <div class="detail-label">IDR @{{ parseInt(resultInquery.details.price) | addCommas }}</div>
                                        </div>
                                        <div class="row-group">
                                            <label>Smart Price</label>
                                            <div class="detail-label">IDR @{{ parseInt(resultInquery.details.price)-parseInt(resultInquery.details.commission) | addCommas }}</div>
                                        </div>
                                        <div class="row-group">
                                            <label>Status</label>
                                            <div class="detail-label"><span class="tersedia">Tersedia</span></div>
                                        </div>
                                        <div class="row-group">
                                            <label></label>
                                            <div class="help-block" style="color: red;"><strong>NB: Harga pulsa sewaktu-waktu dapat berubah mengikuti kebijakan harga dari masing-masing provider, akan tetapi SIP selalu berkomitmen memberikan harga yang terbaik.</strong></div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <br>
{{--                                <div class="checkbox">--}}
{{--                                    <label>--}}
{{--                                        <input type="checkbox"  v-model="term" v-bind:true="true" v-bind:false="false"> Saya Memastikan bahwa data yang saya masukan adalah benar dan saya bertanggung jawab atas data yang telah saya masukan<br>Saya telah membaca dan menyetujui Syarat dan Ketentuan SIP--}}
{{--                                    </label>--}}
{{--                                    <br> <span class="label label-danger" v-show="errorTerm">Anda belum menyetujui syarat dan ketentuan SIP.</span>--}}
{{--                                </div>--}}
                                <div class="row" id="formValidation" >
                                    <div class="form-inline">
{{--                                        <div class="form-group">--}}
{{--                                            <div class="col-sm-12">--}}
{{--                                                <input type="password" class="form-control" name="password" v-model="password" id="password" placeholder="Password" autocomplete="off">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                        <div class="form-group">
                                            <div class="col-sm-12">
{{--                                                <button  v-on:click="pulsaTransaction" class="btn btn-orange full-width" id="btnBuy">BELI</button>--}}
                                                <button disabled class="btn btn-orange full-width" id="btnBuy">MAINTENANCE</button>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                </div>
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
                                            <p><strong>Opps!</strong> Terjadi kesalahan.</p>
                                            <ul>
                                                <li v-for="val in result.status.message" style="color: #F0F0F0;">@{{ val }}</li>
                                            </ul>
                                        </div><!--end.alert-->
                                    </div>
                                </div>
                                <div v-if="success" >
                                    <div class="rows">
                                        <div class="alert-custom alert alert-green alert-dismissible" role="alert">
                                            <img class="icon-sign" src="{{asset('/assets/images/material/icon-03.png')}}"  style="vertical-align: top;">
                                            <p><strong>Pembelian Berhasil!</strong><br>Silahkan klik data transaksi di bawah ini. <br><a href="{{route('pulsa.reports')}}" class="btn btn-cari">DATA TRANSAKSI</a></p>
                                        </div><!--end.alert-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="left-section" v-else>
                            <div class="alert-custom alert alert-red alert-dismissible" role="alert" v-if="showInqueryFailed">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <img class="icon-sign" src="{{asset('/assets/images/material/icon-02.png')}}">
                                <p><strong>Opps!</strong> Terjadi Kesalahan ! Error:500</p>
                            </div><!--end.alert-->
                            <div class="alert-custom alert alert-red alert-dismissible" role="alert" v-else>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <img class="icon-sign" src="{{asset('/assets/images/material/icon-02.png')}}">
                                <p><strong>Opps!</strong> @{{ resultInquery.details.error_msg }}</p>
                            </div>
                        </div>
                    </div>
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
                </div>
            </div>
        </section>
    </div>
{{--    pulsaTransaction:function(){--}}
{{--    if(this.term===true){--}}
{{--    this.errorTerm=false;--}}
{{--    $('#transactionLoader').show();--}}
{{--    $('#formValidation').hide();--}}
{{--    var attributes={'username':this.username,'password':this.password,'number':this.phoneNumber,'code':this.code,'price':parseInt(this.resultInquery.total)+parseInt(this.com)};--}}
{{--    this.$http.post(window.url,attributes).then((response)=>{--}}
{{--    console.log("Berhasil");--}}

{{--    $('#transactionLoader').hide();--}}
{{--    console.log("HIDE");--}}
{{--    console.log(response.data);--}}
{{--    this.result=response.data;--}}
{{--    console.log(this.result.status.code);--}}
{{--    if(this.result.status.code==200){--}}
{{--    return this.success=true;--}}
{{--    }else{--}}
{{--    console.log(this.result.status.message);--}}
{{--    return this.failed=true;--}}
{{--    }--}}
{{--    },(response)=>{--}}
{{--    console.log("GAGAL BRO");--}}
{{--    console.log(response.data);--}}
{{--    $('#transactionLoader').hide();--}}
{{--    this.failed=true;--}}
{{--    });--}}
{{--    }else{--}}
{{--    this.errorTerm=true;--}}
{{--    }--}}
{{--    }--}}
@endsection
@section('js')
    @parent
    <script src="{{url('/')}}/captcha-handler?get=bdc-script-include.js" type="text/javascript"></script>
    <script>
        $('#transactionLoader').hide();
        Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
        Vue.http.options.emulateJSON = true;
        var pulsa = new Vue({
            el:"#pulsa",
            data:{
                com:window.com,
                phoneNumber:"",
                code:"",
                username:'',
                password:'',
                showInquery:false,
                showInquerySuccess:false,
                showInqueryFailed:false,
                loader:false,
                failed:false,
                success:false,
                term:false,
                errorTerm:false,
                result:null,
                logo:null,
                resultInquery:
                    {'status':{'message':null},'details':[
                        {'error_msg':null}
                    ]}
                ,
                indosat:[
                    {'value':'137','name':'IM3 Reguler Rp 5.000'},
                    {'value':'138','name':'IM3 Reguler Rp 10.000'},
                    {'value':'139','name':'IM3 Reguler Rp 25.000'},
                    {'value':'140','name':'IM3 Reguler Rp 50.000'},
                    {'value':'141','name':'IM3 Reguler Rp 100.000'},
                    {'value':'145','name':'Mentari Reguler Rp 5.000'},
                    {'value':'146','name':'Mentari Reguler Rp 10.000'},
                    {'value':'147','name':'Mentari Reguler Rp 25.000'},
                    {'value':'148','name':'Mentari Reguler Rp 50.000'},
                    {'value':'149','name':'Mentari Reguler Rp 100.000'},
                    {'value':'153','name':'Indosat Data 1GB'},
                    {'value':'154','name':'Indosat Data 2GB'},
                    {'value':'155','name':'Indosat Data 3GB'},
                    {'value':'158','name':'Indosat Data 5GB'}
                ],
                telkomsel:[
                    {'value':'205','name':'Simpati Voucher Rp 5.000'},
                    {'value':'206','name':'Simpati Voucher Rp 10.000'},
                    {'value':'207','name':'Simpati Voucher Rp 20.000'},
                    {'value':'208','name':'Simpati Voucher Rp 25.000'},
                    {'value':'209','name':'Simpati Voucher Rp 50.000'},
                    {'value':'210','name':'Simpati Voucher Rp 100.000'},
                    {'value':"344",'name':"Simpati Voucher Rp 150.000"},
                    {'value':"345",'name':"Simpati Voucher Rp 200.000"},
                    {'value':'211','name':'Telkomsel Data 10MB'},
                    {'value':'212','name':'Telkomsel Data 30MB'},
                    {'value':'213','name':'Telkomsel Data 80MB'},
                    {'value':'214','name':'Telkomsel Data 150MB'},
                    {'value':'215','name':'Telkomsel Data 450MB'},
                    {'value':'216','name':'Telkomsel Data 1.5GB'}
                ],
                xl:[
                    {'value':'109','name':'XL Voucher Rp 5.000'},
                    {'value':'110','name':'XL Voucher Rp 10.000'},
                    {'value':'111','name':'XL Voucher Rp 25.000'},
                    {'value':'112','name':'XL Voucher Rp 50.000'},
                    {'value':'113','name':'XL Voucher Rp 100.000'},
                    {'value':'114','name':'XL Voucher Rp 200.000'},
                    {'value':'115','name':'XL HotRoad 3G Bulanan 2.1GB'},
                    {'value':'116','name':'XL HotRoad 3G Bulanan 5.1GB'},
                    {'value':'117','name':'XL HotRoad 4G Bulanan (11,5GB+BONUS 1GB [4G])'},
                    //{'value':'118','name':'XL HotRoad 5GB'},
                    {'value':'119','name':'XL Super Ngebut 2GB'},
                    {'value':'120','name':'XL Super Ngebut 5GB'},
                    {'value':'121','name':'XL Super Ngebut 12GB'},
                    {'value':'122','name':'XL BlackBerry Full BIS Bonus Pulsa 40.000'}
                ],
                axis:[
                    {'value':'160','name':'Axis Rp 5.000'},
                    {'value':'161','name':'Axis Rp 10.000'},
                    {'value':'163','name':'Axis Rp 25.000'},
                    {'value':'164','name':'Axis Rp 50.000'},
                    {'value':'165','name':'Axis Rp 100.000'},
                    {'value':'166','name':'Axis Bronet 1GB 1 Bulan'},
                    {'value':'167','name':'Axis Karet 24Jam 1GB'},
                    {'value':'168','name':'Axis Bronet 2GB 2 Bulan'},
                    {'value':'169','name':'Axis Karet 24Jam 2GB'},
                    {'value':'170','name':'Axis Karet 24Jam 3GB'},
                    {'value':'171','name':'Axis Bronet 3GB 2 Bulan'},
                    {'value':'172','name':'Axis Karet 24Jam 5GB'},
                    {'value':'173','name':'Axis Bronet 5GB 2 Bulan'},
                    {'value':'174','name':'Axis Internet Gaul Unlimited'}
                ],
                three:[
                    {'value':'176','name':'Three Rp 5.000'},
                    {'value':'177','name':'Three Rp 10.000'},
                    {'value':'178','name':'Three Rp 20.000'},
                    {'value':'179','name':'Three Rp 30.000'},
                    {'value':'180','name':'Three Rp 50.000'},
                    {'value':'181','name':'Three Rp 100.000'},
                    {'value':'182','name':'Three AON 1GB'},
                    {'value':'183','name':'Three AON 2GB'},
                    {'value':'184','name':'Three AON 3GB'},
                    {'value':'185','name':'Three AON 4GB'},
                    {'value':'186','name':'Three AON 5GB'},
                    {'value':'187','name':'Three AON 6GB'},
                    {'value':'188','name':'Three AON 8GB'},
                    {'value':'189','name':'Three AON 10GB'},
                    {'value':'190','name':'Three Xtra 20MB'},
                    {'value':'191','name':'Three Xtra 80MB'},
                    {'value':'192','name':'Three Xtra 650MB'},
                    {'value':'193','name':'Three Xtra 1.25GB'},
                    {'value':'194','name':'Three Xtra 4.25GB'},
                    {'value':'195','name':'Three NetMax 5GB+Pulsa 15000'},
                    {'value':'196','name':'Three NetMax 8GB+Pulsa 50.000'},
                    {'value':'197','name':'Three Reguler 1GB'},
                    {'value':'198','name':'Three Reguler 2GB'},
                    {'value':'199','name':'Three Reguler 3GB'},
                    {'value':'200','name':'Three Reguler 4GB'},
                    {'value':'201','name':'Three Reguler 5GB'},
                    {'value':'202','name':'Three Reguler 6GB'},
                    {'value':'203','name':'Three Reguler 8GB'},
                    {'value':'204','name':'Three Reguler 10GB'}
                ],
                smartfren:[
                    {'value':'123','name':'Smartfren Rp 5.000'},
                    {'value':'124','name':'Smartfren Rp 10.000'},
                    {'value':'125','name':'Smartfren Rp 20.000'},
                    {'value':'126','name':'Smartfren Rp 25.000'},
                    {'value':'127','name':'Smartfren Rp 50.000'},
                    {'value':'128','name':'Smartfren Rp 100.000'}
                ],
                bolt:[
                    {'value':'217','name':'Bolt 4G 25.000'},
                    {'value':'218','name':'Bolt 4G 50.000'},
                    {'value':'219','name':'Bolt 4G 100.000'},
                    {'value':'220','name':'Bolt 4G 150.000'},
                    {'value':'221','name':'Bolt 4G 200.000'}
                ],
                nominals:null,
                btnInquery:false
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
            computed:{
                nominals:function () {
                    if(this.phoneNumber.length>=4){
                        switch (this.phoneNumber.substring(0,4)){
                            case '0811':this.showInquery=false;return this.nominals=this.telkomsel;break;case '0812':this.showInquery=false;return this.nominals=this.telkomsel;break;case '0813':this.showInquery=false;return this.nominals=this.telkomsel;break;case '0821':this.showInquery=false;return this.nominals=this.telkomsel;break;case '0859':this.showInquery=false;return this.nominals=this.xl;break;case '0822':this.showInquery=false;return this.nominals=this.telkomsel;break;case '0823':this.showInquery=false;return this.nominals=this.telkomsel;break;case '0851':this.showInquery=false;return this.nominals=this.telkomsel;break;case '0852':this.showInquery=false;return this.nominals=this.telkomsel;break;case '0853':this.showInquery=false;return this.nominals=this.telkomsel;break;case '0814':this.showInquery=false;return this.nominals=this.indosat;break;case '0815':this.showInquery=false;return this.nominals=this.indosat;break;case '0816':this.showInquery=false;return this.nominals=this.indosat;break;case '0855':this.showInquery=false;return this.nominals=this.indosat;break;case '0856':this.showInquery=false;return this.nominals=this.indosat;break;case '0857':this.showInquery=false;return this.nominals=this.indosat;break;case '0858':this.showInquery=false;return this.nominals=this.indosat;break;case '0817':this.showInquery=false;return this.nominals=this.xl;break;case '0818':this.showInquery=false;return this.nominals=this.xl;break;case '0819':this.showInquery=false;return this.nominals=this.xl;break;case '0877':this.showInquery=false;return this.nominals=this.xl;break;case '0878':this.showInquery=false;return this.nominals=this.xl;break;case '0895':this.showInquery=false;return this.nominals=this.three;break;case '0896':this.showInquery=false;return this.nominals=this.three;break;case '0897':this.showInquery=false;return this.nominals=this.three;break;case '0898':this.showInquery=false;return this.nominals=this.three;break;case '0899':this.showInquery=false;return this.nominals=this.three;break;case '0831':return this.nominals=this.axis;break;case '0832':return this.nominals=this.axis;break;case '0833':return this.nominals=this.axis;break;case '0838':return this.nominals=this.axis;break;case '0881':return this.nominals=this.smartfren;break;case '0882':return this.nominals=this.smartfren;break;case '0883':return this.nominals=this.smartfren;break;case '0884':return this.nominals=this.smartfren;break;case '0885':return this.nominals=this.smartfren;break;case '0886':return this.nominals=this.smartfren;break;case '0887':return this.nominals=this.smartfren;break;case '0888':return this.nominals=this.smartfren;break;case '9980':return this.nominals=this.bolt;case '9981':return this.nominals=this.bolt;case '9982':return this.nominals=this.bolt;case '9983':return this.nominals=this.bolt;case '9984':return this.nominals=this.bolt;case '9985':return this.nominals=this.bolt;case '9986':return this.nominals=this.bolt;case '9987':return this.nominals=this.bolt;case '9989':return this.nominals=this.bolt;case '9988':return this.nominals=this.bolt;case '0889':return this.nominals=this.smartfren;break;case '9988':return this.nominals=this.bolt;case '9990':return this.nominals=this.bolt;break;case '9991':return this.nominals=this.bolt;break;case '9992':return this.nominals=this.bolt;break;case '9993':return this.nominals=this.bolt;break;case '9994':return this.nominals=this.bolt;break;case '9995':return this.nominals=this.bolt;break;case '9996':return this.nominals=this.bolt;break;case '9997':return this.nominals=this.bolt;break;case '9998':return this.nominals=this.bolt;break;case '9999':return this.nominals=this.bolt;break;default:return this.nominals=[{'value':'','name':'Nomer tidak terdaftar'}];break;
                        }
                    }else{
                        return this.nominal=[{'value':'','name':'Masukan Nomor HP'}];
                    }
                },
                btnInquery:function () {
                    if(this.phoneNumber.length>=10){
                        return true;
                    }
                },
                nominalInput:function(){
                    if(this.phoneNumber.length>=4){
                        this.showInquery=false;
                        return true;
                    }else{
                        return false;
                    }
                }
            },
            methods:{
                inquery:function(){
                    this.loader=true;
                    this.showInquery=false;
                    this.showInquerySuccess=false;
                    this.showInqueryFailed=false;
                    $('#formValidation').show();
                    this.success=false;
                    var endPoint='{{ route('pulsa.new_inquery') }}';
                    var attributes={'number':this.phoneNumber,'code':this.code};
                    if(this.phoneNumber!=null){
                        this.$http.post(endPoint,attributes).then((response)=>{
                        this.loader=false;
                        this.resultInquery=response.data;
                        this.logo=window.urlLogo+'/'+this.resultInquery.details.logo;
                        if(response.data.status.code==200){
                            this.showInquery=true;
                            this.showInquerySuccess=true;
                        }else {
                            this.showInquery=true;
                            //this.showInqueryFailed=true;
                        }
                    },(response)=>{
                            this.showInquery=true;
                            this.showInqueryFailed=true;
                            this.loader=false;
                            //console.log("GAGAL BRO");
                        });
                    }else{
                        console.log("Number = null");
                    }
                },
            },
            mounted:function () {
                this.phoneNumber=window.request.phoneNumber;
                this.code=window.request.code;
                this.inquery();
            }
        });
    </script>
@endsection
