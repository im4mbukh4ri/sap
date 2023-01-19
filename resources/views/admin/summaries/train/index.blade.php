@extends('layouts.public')
@section('css')
    @parent
@endsection
@section('content')
    <section class="section-pilih-seat">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="blue-title-big">SUMMARY KERETA API</h3>
                    <div id="dataSearch" class="box-orange">
                        <form action="{{route('admin.operational_summaries_train')}}" method="GET">
                            {{csrf_field()}}
                            <input type="hidden" name="sort" value="total_market_price">
                            <div class="row-form">
                                <div class="row">
                                    <div id="hideDiv" class="hideDiv">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="whiteFont">Dari tanggal</label>
                                            <div class="input-group custom-input">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                <input type="text" name="from" class="form-control" id="datepicker1">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-menu-down"></i></span>
                                            </div>
                                        </div>
                                    </div><!--end.col-md-4-->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="whiteFont">Sampai tanggal</label>
                                            <div class="input-group custom-input">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                <input type="text" name="until" class="form-control" id="datepicker2">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-menu-down"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group full-width">
                                            <label class="whiteFont">Limit</label>
                                            <div class="input-group custom-input">
                                                <?php $limits = [
	'10' => '10',
	'20' => '20',
	'30' => '30',
	'40' => '40',
	'50' => '50',
	'60' => '60',
	'70' => '70',
	'80' => '80',
	'90' => '90',
	'100' => '100',
];
?>
                                                <select class="form-control" name="limit">
                                                    @foreach($limits as $key => $limit)
                                                        @if(old('limit')==$key)
                                                            <option value="{{$key}}" selected>{{ $limit }}</option>
                                                        @else

                                                            <option value="{{$key}}">{{ $limit }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2"><br>
                                        <button type="submit" class="btn btn-cari">
                                            <span class="glyphicon glyphicon-search"></span> Cari Data</button>
                                    </div><!--end.col-md-4-->
                                </div><!--end.row-->
                            </div><!--end.row-form-->
                        </form>
                    </div><!--end.box-->
                    @if(count($summaries)>0)
                    <div class="row">
                        <div class="col-md-3">
                            <form action="{{route('admin.operational_summaries_train')}}" method="GET" target="_blank" >
                            {{csrf_field()}}
                                 <input type="hidden" name="export" id="export" value="1">
                                 <input type="hidden" name="from" class="form-control" value="{{old('from')}}">
                                 <input type="hidden" name="until" class="form-control" value="{{old('until')}}">
                                 <input type="hidden" name="sort" value="{{old('sort')}}">
                                 <input type="hidden" name="limit" value="{{old('limit')}}">
                                 <button type="submit" class="btn btn-cari"><span class="glyphicon glyphicon-download"></span> Export to Excel</button>
                            </form>
                            <hr>
                        </div>
                    </div>
                    @endif

                    <div class="table-responsive dataTable">
                        <table id="data-table" class="text-center table table-striped table-bordered dt-responsive nowrap table-custom-blue">
                            <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Username</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Jumlah Transaksi</th>
                                <th class="text-center">Market Price (IDR)</th>
                                <th class="text-center">Smart Cash (IDR)</th>
                                <th class="text-center">Smart Price (IDR)</th>
                            </tr>

                            </thead>
                            <tbody>
                                @forelse($summaries as $key => $summary)
                                    <tr>
    <td>{{$key+1}}</td>
    <td>{{ $summary->username }}</td>
    <td>{{ $summary->name }}</td>
    <td>{{ $summary->total_transactions }}</td>
    <td class="text-right">{{ number_format($summary->total_market_price) }}</td>
    <td class="text-right">{{ number_format($summary->total_smart_price) }}</td>
    <td class="text-right">{{ number_format($summary->total_market_price - $summary->total_smart_price) }}</td>
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
        </div>
    </section>
@endsection
@section('js')
    @parent

    <script>
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
        });
    </script>
@endsection
