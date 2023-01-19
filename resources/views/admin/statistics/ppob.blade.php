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
                    <h3 class="blue-title-big">STATISTIK PPOB</h3>
                    <div id="dataSearch" class="box-orange">
                        <form action="" method="GET">
                            <div class="row-form">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group group-addon-select">
                                            <label for="adt">Periode Tahun</label>
                                            <div class="input-group custom-input">
                                                <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                                <select id="adt" name="adt" class="form-control">
                                                    <option value="2017" selected>2017</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div><!--end.col-md-4-->
                                    <div class="col-md-3">
                                        <br>
                                        <button type="submit" class="btn btn-cari">Lihat Statistik</button>
                                    </div><!--end.col-md-4-->
                                </div><!--end.row-->
                            </div><!--end.row-form-->
                        </form>
                    </div><!--end.box-->
                    <?php
                    $months=['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'];
                    ?>
                    <div class="dataTable">
                        <table id="data-table" class="text-center table table-striped table-bordered dt-responsive nowrap table-custom-blue">
                            <thead>
                            <tr>
                                <th>Bulan</th>
                                <th>Jumlah Transaksi</th>
                                <th>Market Price</th>
                                <th>Smart Value</th>
                                <th>Komisi</th>
                                <th>90</th>
                                <th>10</th>
                                <th>Smart Cash</th>
                                <th>Smart Point</th>
                                <th>Pusat</th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($statistics as $key => $statistic)
                                @if($statistic->count()!=0)
                                    <?php
                                    $paxpaid=array();
                                    $nta=array();
                                    $nra=array();
                                    $commission90=array();
                                    $commission10=array();
                                    $smartCash=array();
                                    $smartPoint=array();
                                    $centre=array();
                                    foreach ($statistic as $value){
                                        $paxpaid[]=$value->paxpaid;
                                        $nta[]=floor($value->nta);
                                        $nra[]=ceil($value->nra);
                                        if($value->transaction_commission){
                                            $commission90[]=floor($value->transaction_commission->komisi);
                                            $commission10[]=floor($value->transaction_commission->free);
                                            $smartCash[]=$value->transaction_commission->member;
                                            $smartPoint[]=$value->transaction_commission->bv;
                                            $centre[]=$value->transaction_commission->pusat;
                                        }else{
                                            $commission90[]=0;
                                            $commission10[]=0;
                                            $smartCash[]=0;
                                            $smartPoint[]=0;
                                            $centre[]=0;
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td>{{$months[$key]}}, 2017</td>
                                        <td>{{ $statistic->count() }}</td>
                                        <td style="text-align: right;">{{ number_format(collect($paxpaid)->sum()) }}</td>
                                        <td style="text-align: right;">{{ number_format(collect($nta)->sum()) }}</td>
                                        <td style="text-align: right;">{{ number_format(collect($nra)->sum()) }}</td>
                                        <td style="text-align: right;">{{ number_format(collect($commission90)->sum()) }}</td>
                                        <td style="text-align: right;">{{ number_format(collect($commission10)->sum()) }}</td>
                                        <td style="text-align: right;">{{ number_format(collect($smartCash)->sum()) }}</td>
                                        <td style="text-align: right;">{{ number_format(collect($smartPoint)->sum()) }}</td>
                                        <td style="text-align: right;">{{ number_format(collect($centre)->sum()) }}</td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="ppobChart" style="height: 250px;"></div>
                </div>
            </div>
            <div class="row">
                <h2>Statistik Device</h2>
                @foreach($statistics as $key => $statistic)
                    @if($statistic->count()!=0)
                        <div class="col-md-4">
                            <h3>{{$months[$key]}}</h3>
                            <div id="deviceChart{{$key}}" style="height: 250px;"></div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
@endsection
@section('js')
    @parent
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script>
        var months=['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'];
        new Morris.Line({
            element: 'ppobChart',
            data: [
                    @foreach($statistics as $key => $statistic)
                    @if($statistic->count()!=0)
                { month: new Date().setMonth({{$key}}), value: '{{$statistic->count()}}' },
                @endif
                @endforeach
            ],
            dateFormat:function (x) {
                return months[new Date(x).getMonth().toString()];
            },
            xkey: 'month',
            ykeys: ['value'],
            xLabels:'month',
            labels: ['Jumlah Transaksi'],
            xLabelFormat:function (x) {
                return months[x.getMonth()];
            }
        });
        @foreach($statistics as $key => $statistic)
                @if($statistic->count()!=0)
        <?php
            $android=array();
            $web=array();
            $undefined=array();
            foreach ($statistic as $value){
                if($value->device=='android'){
                    $android[]=1;
                }elseif($value->device=='web'){
                    $web[]=1;
                }else{
                    $undefined[]=1;
                }
            }
            ?>
            new Morris.Donut({
            element: 'deviceChart{{$key}}',
            data: [
                {label: "Web", value: '{{ collect($web)->sum() }}'},
                {label: "Android", value: '{{ collect($android)->sum() }}'},
                {label: "Undefined", value: '{{ collect($undefined)->sum() }}'}
            ]
        });
        @endif
        @endforeach
    </script>
@endsection
