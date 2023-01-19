@extends('layouts.public')
@section('css')
    @parent
    <link rel="stylesheet" href="{{asset('/assets/css/public/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/css/public/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/css/public/sweetalert.css')}}">
@endsection
@section('content')
    <section class="section-pilih-seat">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="blue-title-big">HISTORY PULSA</h3>
                    <div id="dataSearch" class="box-orange">
                        <form action="{{route('pulsa.reports')}}" method="GET">
                            {{csrf_field()}}
                            <div class="row-form">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="whiteFont">Dari tanggal</label>
                                            <div class="input-group custom-input">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                <input type="text" name="from" class="form-control" id="datepicker1" value="{{old('from')}}">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-menu-down"></i></span>
                                            </div>
                                        </div>
                                    </div><!--end.col-md-4-->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="whiteFont">Sampai tanggal</label>
                                            <div class="input-group custom-input">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                <input type="text" name="until" class="form-control" id="datepicker2" value="{{old('until')}}">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-menu-down"></i></span>
                                            </div>
                                        </div>
                                    </div><!--end.col-md-4-->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="whiteFont">Status</label>
                                            <div class="input-group custom-input full-width">
                                                <?php
$statuses = [
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
                                    <div class="col-md-3">
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
                                <th>No. & Tgl. Transaksi</th>
                                <th>No. Pelanggan</th>
                                <th>Produk</th>
                                {{-- <th>Komisi (IDR)</th> --}}
                                <th>Smart Price (IDR)</th>
                                <th>Status</th>
                                <th></th>
                            </tr>

                            </thead>
                            <tbody>
                            <?php $k = 1;?>
                            @forelse($transactions as $key => $transaction)
                                <tr>
                                    <td>{{$k++}}</td>
                                    <td>
                                    @if(strtotime($transaction->created_at) > 1504373880)
                                    {{$transaction->id}}
                                    @else
                                    {{$transaction->id_transaction}}
                                    @endif
                                    <br>{{date("d M Y H:i:s",strtotime($transaction->created_at))}}</td>
                                    <td>{{ $transaction->number }}</td>
                                    <td class="text-left">{{ $transaction->ppob_service->parent->name }}<br>{{ $transaction->ppob_service->name }}</td>
                                    {{-- <td style="text-align: right;">Smart Point : {{ (isset($transaction->transaction_commission))?number_format($transaction->transaction_commission->bv):0 }}<br>Smart Cash : {{ (isset($transaction->transaction_commission))?number_format($transaction->transaction_commission->member):0 }}</td> --}}
                                    <td style="text-align: right;">{{ (isset($transaction->transaction_commission))?number_format($transaction->paxpaid-$transaction->transaction_commission->member):0 }}</td>
                                    <td>@if($transaction->status=="PENDING")<label class="label label-warning">{{ $transaction->status }}</label>@elseif($transaction->status=='FAILED')<label class="label label-danger">{{ $transaction->status }}</label>@else <label class="label label-success">{{ $transaction->status }}</label> @endif </td>
                                    {{-- <td><a href="{{ route('pulsa.receipt',$transaction) }}" target="_blank"><i class="fa fa-download"></i></a></td> --}}
                                    <td>
                                      @if($transaction->status=="SUCCESS")
                                        <form action="{{ route('pulsa.receipt',$transaction) }}" method="GET" target="_blank">
                                          <input type="hidden" name="service_fee" class="service_fee" value="0">
                                          <button class="btn btn-primary js-submit-confirm" ><i class="fa fa-download"></i></button>
                                        </form>
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
                    </div>
                    @if(count($transactions)>0)
        						<div class="row">
        								<div class="col-md-4">
        										<table class="text-right dataTable table table-striped table-bordered dt-responsive nowrap table-custom-blue">
                              <tbody>
                              <tr>
                                  <td class="text-left">Total Smart Price</td>
                                  <td>IDR {{ number_format($totalAmount[0]->total_marketprice-$totalAmount[0]->total_smarcash) }}</td>
                              </tr>
                              {{-- <tr>
                                  <td class="text-left">Total Smartpoint</td>
                                  <td>IDR {{ number_format($totalAmount[0]->total_smartpoint)}}</td>
                              </tr> --}}
                              {{-- <tr>
                                  <td class="text-left">Total Smartcash </td>
                                  <td>IDR {{ number_format($totalAmount[0]->total_smarcash)}}</td>
                              </tr> --}}
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
    <script src="{{asset('/assets/js/public/datatables.min.js')}}"></script>
    <script src="{{asset('/assets/js/public/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('/assets/js/public/responsive.bootstrap.min.js')}}"></script>
    <script src="{{asset('/assets/js/public/sweetalert.min.js')}}"></script>
    <script>
        $(document).ready(function () {
          $(document.body).on('click', '.js-submit-confirm', function (event) {
              event.preventDefault();
              var $form = $(this).closest('form');
              var $el = $(this);
              var text = $el.data('confirm-message') ? $el.data('confirm-message') : 'Silahkan isi service fee (Opsional) !';
              swal({
                      title: "Service Fee Tambahan.",
                      text: text,
                      type: "input",
                      showCancelButton: true,
                      confirmButtonColor: '#0c5484',
                      confirmButtonText: 'Download',
                      cancelButtonText: 'Tutup',
                      closeOnConfirm: false
                  },
                  function (inputValue) {
                      if (inputValue === false) return false;
                      if (isNaN(inputValue)) {
                          swal.showInputError("Yang dimasukan harus angka.");
                          return false
                      }
                      if(inputValue === ""){
                          $('.service_fee').val(0);
                      }else{
                          $('.service_fee').val(inputValue);
                      }
                      $form.submit();
                      swal("Download","Proses download selesai", "success");

                  })
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
