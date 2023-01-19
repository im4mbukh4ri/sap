@extends('layouts.public')
@section('css')
    @parent
    <link href="{{asset('/assets/css/admin/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection
@section('content')
    <section class="section-pilih-seat">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div id="myApp">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="blue-title-big">Manual Deposit</h3>
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
                                                    <td>Deposit</td>
                                                    <td>:</td>
                                                    <td>IDR @{{ result.detail.user.deposit | addCommas }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        {!! Form::open(['route'=>'admin.deposits_update','method'=>'post']) !!}
                                        <input type="hidden" name="username" :value="result.detail.user.username">
                                        <input type="hidden" name="user_deposit" :value="result.detail.user.deposit">
                                        <div class="form-group">
                                            <label for="deposit"><i class="fa fa-check prefix"></i> Jenis</label>
                                            <select name="deposit" id="deposit" class="form-control" required>
                                                <option value="debit"> Penarikan (debit)</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="nominal"><i class="fa fa-money prefix"></i> Nominal</label>
                                            <input type="number" name="nominal" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="note"><i class="fa fa-book prefix"></i> Catatan Tambahan (Opsional)</label>
                                            <textarea id="note" name="note" class="form-control"></textarea>
                                            <p>Ex: Penambahan deposit IDR xxxx. < disini catatan tambahan ><br></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="password"><i class="fa fa-lock prefix"></i> Password</label>
                                            <input type="password" name="password" class="form-control" required>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-blue"> Simpan</button>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" v-if="failed">
                            <div class="col-md-12">
                                <h4>@{{ result.status.message }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <h3 class="blue-title-big">Manual Deposit Hari Ini</h3>
                    <hr>
                    
                    <div class="table-responsive">
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
    <script type="text/javascript">
        Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
        Vue.http.options.emulateJSON = true;
        var myApp= new Vue({
            el:'#myApp',
            data:{
                url:'{{url('/rest/users/')}}',
                username:'',
                success:false,
                failed:false,
                result:null,
                loading:false,
                nominal:0
            },
            filters:{
                addCommas:function (v) {
                    v += '';
                    x = v.split('.');
                    x1 = x[0];
                    //x2 = x.length > 1 ? '.' + x[1] : '';
                    var rgx = /(\d+)(\d{3})/;
                    while (rgx.test(x1)) {
                        x1 = x1.replace(rgx, '$1' + ',' + '$2');
                    }
                    return x1 ;//+x2;
                }
            },
            methods:{
                getUser:function () {
                    this.loading=true;
                    this.failed=false;
                    this.success=false;
                    this.$http.get(this.url+'/'+this.username).then((response)=>{
                        console.log(this.url);
                        console.log(this.username);
                        console.log(this.url+'/'+this.username);
                        this.result=response.data;
                        if(this.result.status.code==200){
                            this.loading=false;
                            this.success=true;
                            this.failed=false;
                            console.log("Berhasil mendapatkan response dengan code 200");
                        }else{
                            this.loading=false;
                            this.failed=true;
                            this.success=false;
                            console.log("Berhasil mendapatkan response dengan code 400");
                        }
                    },(response)=>{
                        this.failed=true;
                        this.success=false;
                        console.log("Berhasil mendapatkan response dengan code 400");
                    });
                }
            }
        });
            $(document).ready(function() {
                $('#depositTable').DataTable({
                    "order": [[ 5, "desc" ]]
                });
            } );
    </script>

@endsection