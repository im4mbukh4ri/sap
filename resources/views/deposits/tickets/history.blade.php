@extends('layouts.public')
@section('css')
    @parent
    <link rel="stylesheet" href="{{asset('/assets/css/public/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/css/public/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/css/public/responsive.bootstrap.min.css')}}">
@endsection
@section('content')
    <section class="section-pilih-seat">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="blue-title-big">HISTORY TIKET DEPOSIT</h3>
                    <div id="dataSearch" class="box-orange">
                        <form action="{{route('deposits.ticket_histories')}}" method="GET">
                            {{csrf_field()}}
                            <div class="row-form">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="whiteFont">Dari tanggal</label>
                                            <div class="input-group custom-input">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                <input type="text" name="from" class="form-control" id="datepicker1" value="{{old('from')}}">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-menu-down"></i></span>
                                            </div>
                                        </div>
                                    </div><!--end.col-md-4-->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="whiteFont">Sampai tanggal</label>
                                            <div class="input-group custom-input">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                <input type="text" name="until" class="form-control" id="datepicker2" value="{{old('until')}}">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-menu-down"></i></span>
                                            </div>
                                        </div>
                                    </div><!--end.col-md-4-->
                                    <div class="col-md-4">
                                        <br>
                                        <button type="submit" class="btn btn-cari">
                                            <span class="glyphicon glyphicon-search"></span> Cari Data</button>
                                    </div><!--end.col-md-4-->
                                </div><!--end.row-->
                            </div><!--end.row-form-->
                        </form>
                    </div><!--end.box-->
                    <div class="table-responsive dataTable">
                        <table id="data-table" class="text-center table table-striped table-bordered dt-responsive nowrap table-custom-blue">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Tiket Deposit</th>
                                <th>Rek. Tujuan</th>
                                <th>Nominal Deposit</th>
                                <th>Kode Unik</th>
                                <th>Total Tiket Deposit</th>
                                <th>Status</th>
                                <th></th>
                            </tr>

                            </thead>
                            <tbody>
                            <?php $i=1;?>
                            @forelse($histories as $key => $history)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{date("d-m-Y H:i",strtotime($history->created_at))}}</td>
                                    <td>{{$history->sip_bank->bank_name}} - {{$history->sip_bank->number}} ( {{$history->sip_bank->owner_name}} )</td>
                                    <td class="text-right">IDR {{number_format($history->nominal_request)}}</td>
                                    <td class="text-right">{{number_format($history->unique_code)}}</td>
                                    <td class="text-right">IDR {{number_format($history->nominal)}}</td>
                                    <td>
                                        <?php
                                        switch ($history->status){
                                            case 'waiting-transfer':
                                                echo "<label class='label label-warning'>$history->last_status</label>";
                                                break;
                                            case 'accepted':
                                                echo "<label class='label label-success'>$history->last_status</label>";
                                                break;
                                            case 'cancel':
                                                echo "<label class='label label-info'>$history->last_status</label>";
                                                break;
                                            case 'rejected':
                                                echo "<label class='label label-danger'>$history->last_status</label>";
                                                break;
                                        }
                                        ?>

                                    </td>
                                    <td>@if($history->status=='waiting-transfer') <form action="{{ route('deposits.ticket_cancel') }}" method="POST">{{ csrf_field() }}<input type="hidden" name="id" value="{{ $history->id }}"><button class="btn btn-xs btn-danger">X</button></form> @endif</td>
                                </tr>
                                <?php $i++;?>
                            @empty
                                <tr>
                                    <td colspan="8">Tidak ada data</td>
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
    <script src="{{asset('/assets/js/public/datatables.min.js')}}"></script>
    <script src="{{asset('/assets/js/public/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('/assets/js/public/responsive.bootstrap.min.js')}}"></script>
    <script>
        $(document).ready(function () {

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
