@extends('layouts.public')
@section('css')
    @parent
    <link href="{{asset('/assets/css/admin/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <style>
        .modal-mask {
            position: fixed;
            z-index: 9998;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, .5);
            display: table;
            transition: opacity .3s ease;
        }

        .modal-wrapper {
            display: table-cell;
            vertical-align: middle;
        }

        .modal-container {
            width: 300px;
            margin: 0px auto;
            padding: 20px 30px;
            background-color: #fff;
            border-radius: 2px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
            transition: all .3s ease;
            font-family: Helvetica, Arial, sans-serif;
        }

        .modal-header h3 {
            margin-top: 0;
            color: #42b983;
        }

        .modal-body {
            margin: 20px 0;
        }

        .modal-default-button {
            float: right;
        }

        /*
         * The following styles are auto-applied to elements with
         * transition="modal" when their visibility is toggled
         * by Vue.js.
         *
         * You can easily play with the modal transition by editing
         * these styles.
         */

        .modal-enter {
            opacity: 0;
        }

        .modal-leave-active {
            opacity: 0;
        }

        .modal-enter .modal-container,
        .modal-leave-active .modal-container {
            -webkit-transform: scale(1.1);
            transform: scale(1.1);
        }
    </style>
@endsection
@section('content')
    <section class="section-pilih-seat">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div id="myApp">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="blue-title-big">Transfer Deposit</h3>
                                <hr>
                                <div class="form-group input-group">
                                    <input type="text" class="form-control" placeholder="username" v-model="username">
                                    <span class="input-group-btn">
                                    <button class="btn btn-blue" type="button" v-on:click="getUser">Cari</button>
                                </span>
                                </div>
                            </div>
                        </div>
                        <div class="row" v-show="loading">
                            <div class="progress">
                                <div class="indeterminate" style="width: 70%"></div>
                            </div>
                        </div>
                        <div class="row" v-if="success">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>Data Member</h4>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                <tr>
                                                    <td>Username</td>
                                                    <td>:</td>
                                                    <td>@{{ result.detail.user.username }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Nama</td>
                                                    <td>:</td>
                                                    <td> @{{ result.detail.user.name }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="nominal"><i class="fa fa-money prefix"></i> Nominal</label>
                                            <input type="number" name="nominal" v-model="nominal" class="form-control" required min="5000">
                                            <p style="color:red;">Minimal tranfer deposit Rp5.000 <br></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="note"><i class="fa fa-book prefix"></i> Catatan Tambahan (Opsional)</label>
                                            <textarea id="note" name="note" v-model="note" class="form-control"></textarea>
                                            <p>Ex: Penambahan deposit IDR xxxx. < disini catatan tambahan ><br></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="password"><i class="fa fa-lock prefix"></i> Password</label>
                                            <input type="password" name="password" v-model="password" class="form-control" required>
                                            <p v-if="wrongPassword" style="color:red;">Password salah !<br></p>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button class="btn btn-blue" @click="requestTransfer" id="sendBtn"> Kirim</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" v-if="failed">
                            <div class="col-md-12">
                                <h4>@{{ result.status.message }}</h4>
                            </div>
                        </div>
                        <transition v-if="showModal">
                            <div class="modal-mask">
                                <div class="modal-wrapper">
                                    <div class="modal-container">
                                        <div class="modal-body text-center">
                                            <slot name="body">
                                              <div v-show="process">
                                                <p>Mohon tunggu.</p>
                                                <img src="{{ asset('/assets/images/Preloader_2.gif') }}" class="img-responsive" alt="loading" style="display: block;margin-left: auto;margin-right: auto;">
                                              </div>
                                              <p>@{{msgResponse}}</p>
                                              <br />
                                              <div class="form-group" v-if="formOTP">
                                                <label>Masukan kode dibawah ini :</label>
                                                <input type="number" v-model="otp" class="form-control" />
                                              </div>
                                              <br />
                                              <br />
                                              <button class="btn btn-primary" @click="doTransfer" v-show="btnTrf" ><i class="fa fa-warning"></i> Transfer</button>
                                              <button class="btn btn-default" @click="doRefresh" v-show="btnCls" >Tutup</button>
                                            </slot>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </transition>
                    </div>
                </div>
                <div class="col-md-7">
                    <h3 class="blue-title-big">Transfer Deposit Hari Ini</h3>
                    <hr>
                    <div class="table-responsive">
                        @can('admin-access')
                          <table class="table" id="depositTable">
                              <thead>
                              <tr>
                                  <th class="align-middle">Username</th>
                                  <th class="align-middle">Deposit Awal <br>(IDR)</th>
                                  <th class="align-middle">Debit <br>(IDR)</th>
                                  <th class="align-middle">Kredit <br>(IDR)</th>
                                  <th class="align-middle">Deposit Akhir <br>(IDR)</th>
                                  <th class="align-middle">Waktu</th>
                              </tr>
                              </thead>
                              <tbody>
                              @forelse($deposits as $deposit)
                                  <tr>
                                      <td>{{$deposit->user->username}}</td>
                                      <td>{{number_format($deposit->user_deposit)}}</td>
                                      <td>{{number_format($deposit->debit)}}</td>
                                      <td>{{number_format($deposit->credit)}}</td>
                                      <td>{{number_format($deposit->user_deposit+$deposit->credit-$deposit->debit)}}</td>
                                      <td>{{date('H:i',strtotime($deposit->created_at))}}</td>
                                  </tr>
                              @empty
                                  <tr>
                                      <td colspan="6">Belum ada data.</td>
                                  </tr>
                              @endforelse
                              </tbody>
                          </table>
                        @else
                          <table class="table" id="depositTable">
                              <thead>
                              <tr>
                                  <th class="align-middle">Username</th>
                                  <th class="align-middle">Kredit <br>(IDR)</th>
                                  <th class="align-middle">Waktu</th>
                                  <th class="align-middle">Catatan</th>
                              </tr>
                              </thead>
                              <tbody>
                              @forelse($deposits as $deposit)
                                  <tr>
                                      <td>{{$deposit->user->username}}</td>
                                      <td>{{number_format($deposit->credit)}}</td>
                                      <td>{{date('H:i',strtotime($deposit->created_at))}}</td>
                                      <td>{{$deposit->note}}</td>
                                  </tr>
                              @empty
                                  <tr>
                                      <td colspan="6">Belum ada data.</td>
                                  </tr>
                              @endforelse
                              </tbody>
                          </table>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    @parent
    <script src="{{asset('/assets/js/vue.js')}}"></script>
    <script src="{{asset('/assets/js/vue-resource.min.js')}}"></script>
    <script src="{{asset('/assets/js/admin/jquery.dataTables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/assets/js/admin/dataTables.bootstrap4.min.js')}}" type="text/javascript"></script>
{{--    <script type="text/javascript">--}}
{{--        Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');--}}
{{--        Vue.http.options.emulateJSON = true;--}}
{{--        var myApp= new Vue({--}}
{{--            el:'#myApp',--}}
{{--            data:{--}}
{{--                url:'{{url('/rest/users/')}}',--}}
{{--                req:'{{route('deposits.request')}}',--}}
{{--                trans:'{{route('deposits.transfer_deposit')}}',--}}
{{--                username:'',--}}
{{--                success:false,--}}
{{--                failed:false,--}}
{{--                result:null,--}}
{{--                loading:false,--}}
{{--                nominal:5000,--}}
{{--                password:'',--}}
{{--                note:'',--}}
{{--                wrongPassword:false,--}}
{{--                to_user:'',--}}
{{--                showModal:false,--}}
{{--                process:true,--}}
{{--                msgResponse:'',--}}
{{--                formOTP:false,--}}
{{--                otp:'',--}}
{{--                btnTrf:false,--}}
{{--                btnCls:false--}}
{{--            },--}}
{{--            filters:{--}}
{{--                addCommas:function (v) {--}}
{{--                    v += '';--}}
{{--                    x = v.split('.');--}}
{{--                    x1 = x[0];--}}
{{--                    //x2 = x.length > 1 ? '.' + x[1] : '';--}}
{{--                    var rgx = /(\d+)(\d{3})/;--}}
{{--                    while (rgx.test(x1)) {--}}
{{--                        x1 = x1.replace(rgx, '$1' + ',' + '$2');--}}
{{--                    }--}}
{{--                    return x1 ;//+x2;--}}
{{--                }--}}
{{--            },--}}
{{--            methods:{--}}
{{--                getUser:function () {--}}
{{--                    this.loading=true;--}}
{{--                    this.failed=false;--}}
{{--                    this.success=false;--}}
{{--                    this.$http.get(this.url+'/'+this.username).then((response)=>{--}}
{{--                    this.result=response.data;--}}
{{--                    this.to_user=response.data.detail.user.id--}}
{{--                    if(this.result.status.code==200){--}}
{{--                        this.loading=false;--}}
{{--                        this.success=true;--}}
{{--                        this.failed=false;--}}
{{--                    }else{--}}
{{--                        this.loading=false;--}}
{{--                        this.failed=true;--}}
{{--                        this.success=false;--}}
{{--                    }--}}
{{--                },(response)=>{--}}
{{--                        this.failed=true;--}}
{{--                        this.success=false;--}}
{{--                    });--}}
{{--                },--}}
{{--                requestTransfer:function(){--}}
{{--                  if(Number(this.nominal)<5000){--}}
{{--                    return alert('Minimal transfer 5000');--}}
{{--                  }--}}
{{--                  $('#sendBtn').hide();--}}
{{--                  this.showModal=true;--}}
{{--                  this.wrongPassword=false;--}}
{{--                  this.formOTP=false;--}}
{{--                  this.msgResponse='';--}}
{{--                  this.process=true;--}}
{{--                  var request= {--}}
{{--                    to_user:this.to_user,--}}
{{--                    nominal:this.nominal,--}}
{{--                    password:this.password,--}}
{{--                    note:this.note,--}}
{{--                  };--}}
{{--                  this.$http.post(this.req,request).then((response)=>{--}}

{{--                    if(response.body.status.code==200){--}}
{{--                      this.btnTrf=true;--}}
{{--                      this.process=false;--}}
{{--                      this.msgResponse=response.body.status.message;--}}
{{--                      this.formOTP=true;--}}
{{--                    }else if(response.body.status.code==401){--}}
{{--                      this.wrongPassword=true;--}}
{{--                      this.showModal=false;--}}
{{--                      $('#sendBtn').show();--}}
{{--                    }else{--}}
{{--                      this.process=false;--}}
{{--                      this.msgResponse=response.body.status.message--}}
{{--                      this.btnCls=true;--}}
{{--                    }--}}
{{--                  },(response)=>{--}}
{{--                    this.process=false;--}}
{{--                    this.msgResponse=response.body.status.message;--}}
{{--                  });--}}
{{--                },--}}
{{--                doTransfer:function(){--}}
{{--                  this.msgResponse='';--}}
{{--                  this.process=true;--}}
{{--                  this.formOTP=false;--}}
{{--                  this.btnTrf=false;--}}
{{--                  var request = {--}}
{{--                    otp:Number(this.otp)--}}
{{--                  }--}}
{{--                  this.$http.post(this.trans,request).then((response)=>{--}}
{{--                    if(response.body.status.code==200){--}}
{{--                      this.process=false;--}}
{{--                      this.msgResponse=response.body.status.message--}}
{{--                      this.btnCls=true;--}}
{{--                    }else{--}}
{{--                      this.process=false;--}}
{{--                      this.msgResponse=response.body.status.message--}}
{{--                      this.btnCls=true;--}}
{{--                    }--}}
{{--                  },(response)=>{--}}
{{--                    this.process=false;--}}
{{--                    this.msgResponse='OTP yang Anda masukan salah.',--}}
{{--                    this.formOTP=true;--}}
{{--                    this.btnTrf=true;--}}
{{--                  });--}}
{{--                },--}}
{{--                doRefresh:function(){--}}
{{--                  location.reload();--}}
{{--                }--}}
{{--            }--}}
{{--        });--}}
{{--        $(document).ready(function() {--}}
{{--            $('#depositTable').DataTable({--}}
{{--                "order": [[ 5, "desc" ]]--}}
{{--            });--}}
{{--        } );--}}
{{--    </script>--}}

@endsection
