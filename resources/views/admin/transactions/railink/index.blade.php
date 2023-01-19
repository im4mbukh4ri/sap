@extends('layouts.public')
@section('css')
    @parent
@endsection
@section('content')
    <section class="section-pilih-seat">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="blue-title-big">TRANSAKSI KERETA</h3>
                    <div id="dataSearch" class="box-orange">
                        <form action="{{route('admin.transactions_railink')}}" method="GET">
                            {{csrf_field()}}
                            <div class="row-form">
                                <div class="row">
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
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="whiteFont">Status</label>
                                            <div class="input-group custom-input">
                                                <?php $statuses=[
                                                    'issued'=>'ISSUED',
                                                ];
                                                ?>
                                                <select class="form-control full-width" name="status">
                                                    @foreach($statuses as $key => $status)
                                                        @if(old('status')==$key)
                                                            <option value="{{$key}}" selected>{{ $status }}</option>
                                                        @else
                                                            <option value="{{$key}}">{{ $status }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
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
                    @if(count($bookings)>0)
                    <div class="row">
                        <div class="col-md-3">
                            <form action="{{route('admin.transactions_railink')}}" method="GET" target="_blank" >
                            {{csrf_field()}}
                                 <input type="hidden" name="export" id="export" value="1">
                                 <input type="hidden" name="start_date" class="form-control" value="{{old('start_date')}}">
                                 <input type="hidden" name="end_date" class="form-control" value="{{old('end_date')}}">
                                 <input type="hidden" name="status" value="{{old('status')}}">
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
                                <th class="text-center">No. & Tgl. Transaksi</th>
                                <th class="text-center">PNR</th>
                                <th class="text-center">Rute</th>
                                <th class="text-center">Pemesan</th>
                                <th class="text-center">Total Fare (IDR)</th>
                                <th class="text-center">Komisi (IDR)</th>
                                <th class="text-center">Status</th>
                                <th></th>
                            </tr>

                            </thead>
                            <tbody>
                              @forelse($bookings as $booking)
                                    <tr>
                                        <td><strong>{{ $booking->transaction->user->username }}</strong><br><strong>{{$booking->transaction->id}}</strong><br>{{date("d M y H:i",strtotime($booking->created_at))}}</td>
                                        <td>{{ $booking->train_name }}<br>
                                            <strong style="color: red;">{{ $booking->pnr }}</strong>
                                        </td>
                                        <td>{!!($booking)?$booking->origin:'<label class=\'label label-danger\'>Error</label>'!!} - {!!($booking)?$booking->destination:'<label class=\'label label-danger\'>Error</label>'!!}</td>
                                        <td style="text-align: left;">{{$booking->transaction->buyer->name}}<br>{{$booking->transaction->buyer->phone}}<br>{{$booking->transaction->buyer->email}}</td>
                                        <td style="text-align: right;">
                                          Market Price : {{number_format($booking->paxpaid)}} <br>
                                            Smart Value : {{number_format($booking->nta)}} <br>
                                            Komisi : {{number_format($booking->nra)}}
                                        </td>
                                        <td style="text-align: right;">
                                            Smart Price : {{(isset($booking->commission))?number_format($booking->paxpaid-$booking->commission->member):0 }}<br>
                                            SIP : {{ (isset($booking->commission))?number_format($booking->commission->pusat):0 }}<br>
                                            Smart Point : {{ (isset($booking->commission))?number_format($booking->commission->bv):0 }}<br>
                                            Smart Cash : {{ (isset($booking->commission))?number_format($booking->commission->member):0 }}
                                        </td>
                                        <td>
                                            @if($booking)
                                                <?php
                                                switch ($booking->status){
                                                    case 'issued':
                                                        echo '<label class=\'label label-success\'>ISSUED</label>';
                                                        break;
                                                    case 'process':
                                                        echo '<label class=\'label label-default\'>PROCESS</label>';
                                                        break;
                                                    default:
                                                        echo '<label class=\'label label-danger\'>ERROR</label>';
                                                        break;
                                                }
                                                ?>
                                            @endif
                                        </td>
                                        <td>
                                          @if($booking->status=="ISSUED")
                                            <a href="{{route('railinks.receipts',$booking->transaction->id)}}" class="btn btn-info"><i class="fa fa-download"></i></a>
                                          @endif
                                        </td>
                                    </tr>
                            @empty
                                <tr>
                                    <td colspan="8">Tidak ada data</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="pull-right">
                            {!! $bookings->appends(array('_token'=>$_token,'start_date'=>$startDate,'end_date'=>$endDate,'status'=>$statusReq))->links() !!}
                        </div>
                    </div>
                    @if(count($bookings)>0)
                    <div class="row">
                        <div class="col-md-4">
                            <table class="text-right dataTable table table-striped table-bordered dt-responsive nowrap table-custom-blue">
                              <tbody>
                                  <tr>
                                      <td class="text-left"><strong>Total Market Price</strong></td>
                                      <td>IDR {{number_format($totalAmount[0]->total_marketprice)}}</td>
                                  </tr>
                                  <tr>
                                      <td class="text-left"><strong>Total Smart Price</strong></td>
                                      <td>IDR {{number_format($totalAmount[0]->total_marketprice-$totalAmount[0]->total_smarcash)}}</td>
                                  </tr>
                                  <tr>
                                      <td class="text-left"><strong>Total SIP</strong></td>
                                      <td>IDR {{number_format($totalAmount[0]->total_pusat)}}</td>
                                  </tr>
                                  <tr>
                                      <td class="text-left"><strong>Total Smart Point</strong></td>
                                      <td>IDR {{number_format($totalAmount[0]->total_smartpoint)}}</td>
                                  </tr>
                                  <tr>
                                      <td class="text-left"><strong>Total Smart Cash</strong></td>
                                      <td>IDR {{number_format($totalAmount[0]->total_smarcash)}}</td>
                                  </tr>
                              </tbody>
                            </table>
                        </div>
                    </div>@endif
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    @parent
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
        });
    </script>
@endsection
