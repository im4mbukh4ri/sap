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
                    <h3 class="blue-title-big">SALDO CHARITY</h3>
                    <div id="dataSearch" class="box-orange">
                        <form action="{{route('admin.operational_charity.saldo')}}" method="GET">
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
                    <div class="dataTable table-responsive">
                        <table id="data-table" class="text-center table table-striped table-bordered dt-responsive nowrap table-custom-blue">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>No. Transaksi</th>
                                <th>Tanggal Transaksi</th>
                                {{--<th>Saldo Awal (IDR)</th>--}}
                                <th>Debit (IDR)</th>
                                <th>Kredit (IDR)</th>
                                <th>Saldo (IDR)</th>
                                <th>Keterangan</th>
                            </tr>

                            </thead>
                            <tbody>
<?php
$debit = array();
$credit = array();
$lastDeposit = null;
$i = 1;
?>
                            @forelse($saldoses as $key => $saldo)
                            <?php
$explode = explode('|', $saldo->note);
$debit[] = $saldo->debit;
$credit[] = $saldo->credit;
($key == 0) ? $lastDeposit = $saldo->deposit : $lastDeposit = $lastDeposit;
?>
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $saldo->user->username }}</td>
                                    <td>{{ $saldo->id }}</td>
                                    <td>{{date("d M Y H:i",strtotime($saldo->created_at))}}</td>
                                    {{--<td class="text-right">{{number_format($saldo->deposit)}}</td>--}}
                                    <td class="text-right">{{number_format($saldo->debit)}}</td>
                                    <td class="text-right">{{number_format($saldo->credit)}}</td>
                                    <td class="text-right">{{number_format($saldo->deposit-$saldo->debit+$saldo->credit)}}</td>
                                    <td class="text-left">{{isset($explode[2])?$explode[2]:'Tidak ada keterangan.'}}</td>
                                </tr>
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
            <div class="row">
                <div class="col-md-4">
                    <?php
$totalDebit = collect($debit)->sum();
$totalCredit = collect($credit)->sum();

?>
                    <table class="text-right table table-striped table-bordered dt-responsive nowrap table-custom-blue">
                        <tbody>
                        <tr>
                            <th>Total Debit</th>
                            <td>IDR {{number_format($totalDebit)}}</td>
                        </tr>
                        <tr>
                            <th>Total Kredit</th>
                            <td>IDR {{number_format($totalCredit)}}</td>
                        </tr>
                        <tr>
                            <th>Saldo Awal</th>
                            <td>IDR {{number_format($lastDeposit)}}</td>
                        </tr>
                        <tr>
                            <th>Saldo Akhir</th>
                            <td>IDR {{number_format($lastDeposit-$totalDebit+$totalCredit)}}</td>
                        </tr>
                        </tbody>
                    </table>
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