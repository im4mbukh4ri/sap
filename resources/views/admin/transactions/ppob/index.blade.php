@extends('layouts.public')
@section('css')
    @parent
@endsection
@section('content')
    <section class="section-pilih-seat">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="blue-title-big">TRANSAKSI PPOB</h3>
                    <div id="dataSearch" class="box-orange">
                        <form action="{{route('admin.transactions_ppob')}}" method="GET">
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
                                            <label class="whiteFont">Layanan</label>
                                            <div class="input-group custom-input">
                                                <?php $services = [
	2 => 'PLN Prabayar',
	3 => 'PLN Pascabayar',
	4 => 'Telepon',
	5 => 'Internet',
	6 => 'TV Berlangganan',
	7 => 'Multi Finance',
	8 => 'PDAM',
	9 => 'Asuransi',
  18 => 'Voucher Game',
  348 => 'Kartu Kredit'
];
?>
                                                <select class="form-control full-width" name="service" required>
                                                    <option value="">PILIH LAYANAN</option>
                                                    @foreach($services as $key => $service)
                                                        @if(old('service')==$key)
                                                            <option value="{{$key}}" selected>{{ $service }}</option>
                                                        @else

                                                            <option value="{{$key}}">{{ $service }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="whiteFont">Status</label>
                                            <div class="input-group custom-input">
                                                <?php
$statuses = [
	'PROCESS' => 'PROSES',
	'SUCCESS' => 'SUKSES',
	'PENDING' => 'PENDING',
	'FAILED' => 'GAGAL',
];
?>
                                                <select class="form-control full-width" name="status">
                                                    <option value="">ALL</option>
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
                    @if(count($transactions)>0)
                    <div class="row">
                        <div class="col-md-3">
                            <form action="{{route('admin.transactions_ppob')}}" method="GET" target="_blank" >
                            {{csrf_field()}}
                                 <input type="hidden" name="export" id="export" value="1">
                                 <input type="hidden" name="start_date" class="form-control" value="{{old('start_date')}}">
                                 <input type="hidden" name="end_date" class="form-control" value="{{old('end_date')}}">
                                 <input type="hidden" name="status" value="{{old('status')}}">
                                 <input type="hidden" name="service" value="{{old('service')}}">
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
                                <th>No. & Tgl. Transaksi</th>
                                <th>No. Pelanggan</th>
                                <th>Produk</th>
                                <th>Paxpaid (IDR)</th>
                                <th>Komisi (IDR)</th>
                                <th>Status</th>
                                <th></th>
                            </tr>

                            </thead>
                            <tbody>
                            @forelse($transactions as $key => $transaction)
                                <tr>
                                    <td><strong>{{$transaction->user->username}}</strong><br><strong>
                                    @if(strtotime($transaction->created_at) > 1504373880)
                                    {{$transaction->id}}
                                    @else
                                    {{$transaction->id_transaction}}
                                    @endif</strong><br>{{date("d M Y H:i:s",strtotime($transaction->created_at))}}</td>
                                    <td><br>{{ $transaction->number }}</td>
                                    <td class="text-left">{{ $transaction->parent }}<br>{{ $transaction->ppob_service->name }}</td>
                                    <td style="text-align: right;">Market Price : {{ number_format($transaction->paxpaid) }}<br>Smart Value : {{ number_format($transaction->nta) }}<br>Komisi : {{ number_format($transaction->nra) }}</td>
                                    <td style="text-align: right;">Smart Price : {{ ($transaction->transaction_commission)?number_format($transaction->paxpaid-$transaction->transaction_commission->member):0 }}
                                      <br>SIP : {{ number_format((isset($transaction->transaction_commission->pusat))?$transaction->transaction_commission->pusat:0) }}<br>Smart Point : {{ number_format((isset($transaction->transaction_commission->bv))?$transaction->transaction_commission->bv:0) }}<br>Smart Cash : {{ number_format((isset($transaction->transaction_commission->member))?$transaction->transaction_commission->member:0) }}</td>
                                    <td>@if($transaction->status=="PENDING")<label class="label label-warning">{{ $transaction->status }}</label>@elseif($transaction->status=="SUCCESS")<label class="label label-success">{{ $transaction->status }}</label>@else <label class="label label-danger">{{ $transaction->status }}</label> @endif </td>
                                    <td>
                                      @if($transaction->status=="SUCCESS")
                                        <a href="{{route('ppob.receipt',$transaction->id)}}" class="btn btn-info"><i class="fa fa-download"></i></a>
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
                        @if($transactions!=null)
                        <div class="pull-right">
                            {!! $transactions->appends(array('_token'=>$_token,'start_date'=>$startDate,'end_date'=>$endDate,'service'=>old('service'),'status'=>$statusReq))->links() !!}
                        </div>
                        @endif
                    </div>
                    @if(count($transactions)>0)
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
                        $( "#datepicker4" ).datepicker( "option","maxDate",new Date());
                    }else{
                        $( "#datepicker2" ).datepicker( "option","maxDate",newD);
                        $( "#datepicker4" ).datepicker( "option","maxDate",newD);
                    }
                    $( "#datepicker2" ).datepicker( "option","minDate",date);
                    $( "#datepicker2" ).datepicker( "setDate",date);
                    $( "#datepicker3" ).datepicker( "option","minDate",date);
                    $( "#datepicker3" ).datepicker( "setDate",date);
                    $( "#datepicker4" ).datepicker( "option","minDate",date);
                    $( "#datepicker4" ).datepicker( "setDate",date);
                },
                maxDate: new Date(),
                dateFormat:'dd-mm-yy'
            });
            $( "#datepicker1" ).datepicker( "setDate",window.request.from);
            $( "#datepicker3" ).datepicker( "setDate",window.request.from);
            $( "#datepicker2" ).datepicker({
                maxDate: new Date(),
                dateFormat:'dd-mm-yy'
            });
            $( "#datepicker4" ).datepicker({
                maxDate: new Date(),
                dateFormat:'dd-mm-yy'
            });
            $( "#datepicker2" ).datepicker( "setDate", window.request.until);
            $( "#datepicker2" ).datepicker( "option","minDate", window.request.until);
            $( "#datepicker4" ).datepicker( "setDate", window.request.until);
            $( "#datepicker4" ).datepicker( "option","minDate", window.request.until);

        });
    </script>
@endsection
