@extends('layouts.public')
@section('css')
	@parent
	<link rel="stylesheet" href="{{asset('/assets/css/public/datatables.min.css')}}">
	<link rel="stylesheet" href="{{asset('/assets/css/public/dataTables.bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('/assets/css/public/responsive.bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('/assets/css/public/sweetalert.css')}}">

@endsection
@section('content')
		 <section class="section-pilih-seat">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
					 	<h3 class="blue-title-big">HISTORY MASKAPAI</h3>
					 	<div id="dataSearch" class="box-orange">
							<form action="{{route('airlines.reports')}}" method="GET">
								{{csrf_field()}}
							 <div class="row-form">
								 <div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label class="whiteFont">Dari tanggal</label>
											<div class="input-group custom-input">
												<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
												<input type="text" name="from" class="form-control" id="datepicker1">
												<span class="input-group-addon"><i class="glyphicon glyphicon-menu-down"></i></span>
											</div>
										</div>
									</div><!--end.col-md-4-->
									<div class="col-md-3">
										<div class="form-group">
											<label class="whiteFont">Sampai tanggal</label>
											<div class="input-group custom-input">
												<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
												<input type="text" name="until" class="form-control" id="datepicker2">
												<span class="input-group-addon"><i class="glyphicon glyphicon-menu-down"></i></span>
											</div>
										</div>
									</div><!--end.col-md-4-->
									<div class="col-md-3">
											<div class="form-group">
													<label class="whiteFont">Status</label>
													<div class="input-group custom-input">
															<?php $statuses = [
'waiting-issued' => 'MENUNGGU ISSUED',
'booking' => 'BOOKED',
'issued' => 'ISSUED',
'cancel' => 'CANCEL',
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
						<div class="table-responsive dataTable">
    							<table id="data-table" class="text-center table table-striped table-bordered dt-responsive nowrap table-custom-blue">
    								<thead>
    									<tr>
    										<th class="text-center">No. & Tgl. Transaksi</th>
											<th class="text-center">PNR</th>
											<th class="text-center">Rute</th>
    										<th class="text-center">Pemesan</th>
											{{-- <th class="text-center">Komisi (IDR)</th> --}}
											<th class="text-center">Smart Price (IDR)</th>
    										<th class="text-center">Status</th>
    										<th class="text-center">&nbsp;</th>
											<th></th>
    									</tr>

    								</thead>
    								<tbody>
    									@forelse($transactions as $key => $transaction)
											@foreach($transaction->bookings()->where('status', 'LIKE', '%' . $statusReq . '%')->where('status','<>','failed')->get() as $booking)
												<tr>
													<td><strong>{{$transaction->id}}</strong><br>{{date("d M y H:i",strtotime($transaction->created_at))}}</td>
													<td>{{ acName($booking->airlines_code) }}<br>
														<strong style="color: red;">{{ $booking->itineraries->first()->pnr }}</strong>
													</td>
													<td>{!!($booking)?$booking->origin:'<label class=\'label label-danger\'>Error</label>'!!} - {!!($booking)?$booking->destination:'<label class=\'label label-danger\'>Error</label>'!!}</td>
													<td>{{$transaction->buyer->name}}<br>{{$transaction->buyer->phone}}</td>
													{{-- <td style="text-align: right;">
														Smart Point : {{ (isset($booking->transaction_commission))?number_format($booking->transaction_commission->bv):'' }}<br>
														Smart Cash : {{ (isset($booking->transaction_commission))?number_format($booking->transaction_commission->member):'' }}
													</td> --}}
													@if(isset($booking->transaction_commission))
														<td style="text-align: right;">{{number_format($booking->paxpaid-$booking->transaction_commission->member)}}</td>
													@else
														<td style="text-align: right;">{{number_format($booking->paxpaid)}}</td>
													@endif
													<td>
														@if($booking)
                                                            <?php
switch ($booking->status) {
case 'booking':
	echo '<label class=\'label label-primary\'>BOOKED</label>';
	break;
case 'issued':
	echo '<label class=\'label label-success\'>ISSUED</label>';
	break;
case 'waiting-issued':
	echo '<label class=\'label label-warning\'>PROSES ISSUED</label>';
	break;
case 'canceled':
	echo '<label class=\'label label-danger\'>CANCELED</label>';
	break;
case 'process':
	echo '<label class=\'label label-default\'>LOADING</label>';
	break;
default:
	echo '<label class=\'label label-danger\'>ERROR</label>';
	break;
}
?>
														@endif
													</td>
													<td><a href="{{route('airlines.report_show',$transaction->id)}}" class="btn btn-md btn-primary"><span class="fa fa-info"></span></a> @if($booking->status=='booking')| <a href="{{ route('airlines.cancel',$transaction->id) }}" class="btn btn-md btn-danger"><span class="fa fa-close"></span></a>@endif</td>
													<td>
														@if($booking->status=='issued')
															<form action="{{ route('airlines.receipts',$transaction->id) }}" method="GET" target="_blank"><input type="hidden" name="service_fee" class="service_fee" value="0">
																<button class="btn btn-info js-submit-confirm" ><i class="fa fa-download"></i></button>
															</form>
														@endif
													</td>
												</tr>
											@endforeach
										@empty
											<tr>
												<td colspan="9">Tidak ada data</td>
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
														<td>IDR {{ number_format($totalAmount[0]->total_marketprice - $totalAmount[0]->total_smarcash) }}</td>
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
