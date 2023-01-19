@extends('layouts.public')
@section('css')
    @parent
    <link rel="stylesheet" href="{{asset('/assets/css/public/sweetalert.css')}}">
@endsection
@section('content')
    <section class="section-pilih-seat">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="blue-title-big">Data Free Member Belum Terverifikasi</h3>
                    <div id="dataSearch" class="box-orange">
                        <form action="{{route('admin.users_unverified')}}" method="GET">
                            {{csrf_field()}}
                            <div class="row-form">
                                <div class="row">

                                    <br>
                                    <div id="hideDiv" class="hideDiv">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="whiteFont">Dari tanggal</label>
                                            <div class="input-group custom-input">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                <input type="text" name="start_date" class="form-control" id="datepicker1">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-menu-down"></i></span>
                                            </div>
                                        </div>
                                    </div><!--end.col-md-4-->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="whiteFont">Sampai tanggal</label>
                                            <div class="input-group custom-input">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                <input type="text" name="end_date" class="form-control" id="datepicker2">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-menu-down"></i></span>
                                            </div>
                                        </div>
                                    </div><!--end.col-md-4-->

                                    </div>


                                    <div class="col-md-2">
                                        <br>
                                        <button type="submit" class="btn btn-cari">
                                            <span class="glyphicon glyphicon-search"></span> Cari Data</button>
                                    </div><!--end.col-md-4-->
                                </div><!--end.row-->
                            </div><!--end.row-form-->
                        </form>
                    </div><!--end.box-->
                    @if($total>0)
                    <div class="row">
                        <div class="col-md-3">
                            <form action="{{route('admin.users_unverified')}}" method="GET" target="_blank" >
                            {{csrf_field()}}
                                 <input type="hidden" name="export" id="export" value="1">
                                 <input type="hidden" name="start_date" class="form-control" value="{{old('start_date')}}">
                                 <input type="hidden" name="end_date" class="form-control" value="{{old('end_date')}}">
                                 <button type="submit" class="btn btn-cari"><span class="glyphicon glyphicon-download"></span> Export to Excel</button>
                            </form>
                            <hr>
                        </div>
                    </div>
                    @endif
                    <br>
                    <strong>Total data : {{$total}}</strong>
                    <div class="table-responsive dataTable">
                        <table class="table table-striped table-bordered dt-responsive nowrap table-custom-blue">
                            <thead>
                            <tr>
                                <th style="width: 15%;">Username</th>
                                <th style="width: 20%;">Upline</th>
                                <th style="width: 20%;">Nama</th>
                                <th style="width: 10%;">Kontak</th>
                                <th style="width: 20%;">Email</th>
                                <th style="width: 15%;">Register</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($users as $key => $user)
                            <tr>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->parent->username }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->address->phone }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ date("d-M-y H:i",strtotime($user->created_at))}}</td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="8" align="center">Tidak ada data</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {!! $users->appends(array('_token'=>$_token,'start_date'=>$startDate,'end_date'=>$endDate,'status'=>$statusReq))->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    @parent
    <script src="{{asset('/assets/js/public/sweetalert.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $(document.body).on('click', '.js-submit-confirm', function (event) {
                event.preventDefault();
                var href =$(this).attr('href');
                var $el = $(this);
                var text = $el.data('confirm-message') ? $el.data('confirm-message') : 'Anda tidak bisa membatalkan proses ini!';
                swal({
                        title: 'Perhatian',
                        text: text,
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#0c5484',
                        confirmButtonText: 'Ya!',
                        cancelButtonText: 'Batal',
                        closeOnConfirm: true
                    },
                    function () {
                        window.location.href=href;
                    })
            });
        });

        $(".slidingDiv").hide();
            $(document).ready(function () {
                $('#byDate').click(function(){
                    $(".slidingDiv").hide();
                    $(".hideDiv").show();
                });
                $('#byPnr').click(function(){
                    $(".hideDiv").hide();
                    $(".slidingDiv").show();
                });
                $("#datepicker1").datepicker({
                    // todayHighlight:1,
                    // todayBtn:  1,
                    // autoclose: true,
                    // startDate:'0d',
                    onSelect: function(date) {
                        var myDate=date;
                        var mySplit=myDate.split('-');
                        var d = new Date(mySplit[2],mySplit[1]-1,mySplit[0]);
                        var newD= new Date(d.setDate(d.getDate()+30));
                        console.log(newD.getDate());
                        if(newD>new Date()){
                            $( "#datepicker2" ).datepicker( "option","maxDate",new Date());
                        }else{
                            $( "#datepicker2" ).datepicker( "option","maxDate",newD);
                        }
                        $( "#datepicker2" ).datepicker( "option","minDate",date);
                        $( "#datepicker2" ).datepicker( "setDate",date);
                    },
                    maxDate: new Date(),
                    dateFormat:'dd-mm-yy'
                });
                $( "#datepicker1" ).datepicker( "setDate",window.request.from);
                $( "#datepicker2" ).datepicker({
                    maxDate: new Date(),
                    dateFormat:'dd-mm-yy'
                });
                $( "#datepicker2" ).datepicker( "setDate", window.request.until);
                $( "#datepicker2" ).datepicker( "option","minDate", window.request.until);
                $('#data-table').DataTable({
                    'paging':true,
                    'ordering':false,
                    'info':false,
                    'iDisplayLength':100,
                    'aLengthMenu':[100,500]
                });
            });
        </script>
    @endsection
