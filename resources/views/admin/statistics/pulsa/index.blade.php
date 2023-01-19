@extends('layouts.public')
@section('css')
    @parent
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
@endsection
@section('content')
    <section class="section-pilih-seat">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="blue-title-big">STATISTIK PULSA</h3>
                    <div id="dataSearch" class="box-orange">
                        <form action="{{route('admin.statistics_pulsa_operator')}}" method="GET">
                            {{csrf_field()}}
                            <div class="row-form">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="whiteFont">Dari tanggal</label>
                                            <div class="input-group custom-input">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                <input type="text" name="start_date" class="form-control" id="datepicker1">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-menu-down"></i></span>
                                            </div>
                                        </div>
                                    </div><!--end.col-md-4-->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="whiteFont">Sampai tanggal</label>
                                            <div class="input-group custom-input">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                <input type="text" name="end_date" class="form-control" id="datepicker2">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-menu-down"></i></span>
                                            </div>
                                        </div>
                                    </div><!--end.col-md-4-->
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="whiteFont">Operator</label>
                                            <div class="input-group custom-input">
                                                <?php $operators=[
                                                    '14'=>'Axis',
                                                    '17'=>'Bolt',
                                                    '13'=>'Indosat',
                                                    '11'=>'Smartfren',
                                                    '16'=>'Telkomsel',
                                                    '15'=>'Three',
                                                    '10'=>'XL'
                                                ];
                                                ?>
                                                <select class="form-control full-width" name="operator_id" required>
                                                    <option value="">Pilih operator </option>
                                                    @foreach($operators as $key => $operator)
                                                        @if(old('operator_id')==$key)
                                                            <option value="{{$key}}" selected>{{ $operator }}</option>
                                                        @else

                                                            <option value="{{$key}}">{{ $operator }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <br>
                                        <button type="submit" class="btn btn-cari">
                                            <span class="glyphicon glyphicon-search"></span> Lihat Statistik</button>
                                    </div><!--end.col-md-4-->
                                </div><!--end.row-->
                            </div><!--end.row-form-->
                        </form>
                    </div><!--end.box-->
                    @if(isset($transactions))
                        <div class="row">
                            <div class="col-md-12">
                                    <table id="data-table" class="table table-custom-blue">
                                        <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Jumlah Transaksi</th>
                                            <th>Market Price</th>
                                            <th>Smart Value</th>
                                            <th>Komisi</th>
                                            <th>Komisi 90</th>
                                            <th>Komisi 10</th>
                                            <th>Smart Cash</th>
                                            <th>Smart Point</th>
                                            <th>SIP</th>
                                            <th>Subsidi</th>
                                        </tr>
                                        </thead>
                                        @foreach($days as $key => $day)
                                            <?php
                                            $trx=array();
                                            $paxpaid=array();
                                            $nta=array();
                                            $nra=array();
                                            $komisi=array();
                                            $free=array();
                                            $sip=array();
                                            $smartCash=array();
                                            $smartPoint=array();
                                            $pointReward=array();
                                            ?>
                                            @foreach( $day as $v)
                                                <?php
                                                $trx[]=$v[0]->total_trx;
                                                $paxpaid[]=$v[0]->paxpaid;
                                                $nta[]=$v[0]->nta;
                                                $nra[]=$v[0]->nra;
                                                $komisi[]=$v[0]->komisi;
                                                $free[]=$v[0]->free;
                                                $sip[]=$v[0]->sip;
                                                $smartCash[]=$v[0]->smart_cash;
                                                $smartPoint[]=$v[0]->smart_point;
                                                $pointReward[]=$v[0]->point_reward;
                                                ?>
                                            @endforeach
                                            <tr>
                                                <td>{{ date('d M',strtotime(old('start_date'). ' + '.$key.' days')) }}</td>
                                                <td style="text-align: center;">{{ collect($trx)->sum() }}</td>
                                                <td style="text-align: right;">{{ number_format(collect($paxpaid)->sum()) }}</td>
                                                <td style="text-align: right;">{{ number_format(collect($nta)->sum()) }}</td>
                                                <td style="text-align: right;">{{ number_format(collect($nra)->sum()) }}</td>
                                                <td style="text-align: right;">{{ number_format(collect($komisi)->sum()) }}</td>
                                                <td style="text-align: right;">{{ number_format(collect($free)->sum()) }}</td>
                                                <td style="text-align: right;">{{ number_format(collect($smartCash)->sum()) }}</td>
                                                <td style="text-align: right;">{{ number_format(collect($smartPoint)->sum()) }}</td>
                                                <td style="text-align: right;">{{ number_format(collect($sip)->sum()) }}</td>
                                                <td style="text-align: center;">{{ number_format(collect($paxpaid)->sum()-collect($smartCash)->sum()-collect($pointReward)->sum()-collect($nta)->sum()) }}</td>

                                            </tr>
                                        @endforeach
                                    </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table" id="nominalTable">
                                    <thead>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Jumlah Transaksi</th>
                                    </tr>
                                    </thead>
                                    @foreach($transactions as $key => $transaction )
                                        @if(count($transaction)>0)
                                        <tr>
                                            <td> {{ (isset($transaction[0]))?$transaction[0]->ppob_service->name:'' }}</td>
                                            <td>{{ count($transaction) }}</td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </table>
                            </div>
                            <div class="col-md-6">
                                <div id="operatorChart" style="height: 500px; width: auto;"></div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    @parent
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script src="{{asset('/assets/js/admin/jquery.dataTables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/assets/js/admin/dataTables.bootstrap4.min.js')}}" type="text/javascript"></script>
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
                    var newD= new Date(d.setDate(d.getDate()+31));
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

            @if(isset($transactions))
            new Morris.Donut({
                element: 'operatorChart',
                data: [
                @foreach($transactions as $key => $transaction )
                        @if(count($transaction)>0)
                {label: "{{ (isset( $transaction[0]))?$transaction[0]->ppob_service->name:'' }}", value: '{{ count($transaction) }}'},
                        @endif
                    @endforeach

                ]
            });
            $('#nominalTable').DataTable({
                "order": [[ 1, "desc" ]],
                "paging":false,
                'iDisplayLength':100,
                "searching":false
            });
            @endif
        });
    </script>
@endsection
