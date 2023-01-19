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
					 	<h3 class="blue-title-big">History Charity</h3>
					 	<div id="dataSearch" class="box-orange">
							<form action="{{route('charities.report')}}" method="GET">
								{{csrf_field()}}
							 <div class="row-form">
								 <div class="row">
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
											<th class="text-center">No</th>
    										<th class="text-center">Tgl. Transaksi</th>
											<th class="text-center">Username</th>
    										<th class="text-center">Program Charity</th>
											<th class="text-center">Nominal (IDR)</th>
											<th class="text-center">Status</th>
											<th class="text-center">Action</th>
   									</tr>
    								</thead>
    								<tbody>
    									<?php $nominal = 0;?>
    									@foreach ($charities as $key => $charity)
												<tr>
													<td>{{ $key+1 }}</td>
													<td>{{ date('d M Y H:i',strtotime($charity->created_at)) }}</td>
													<td>{{ $charity->user->username }}</td>
													<td>{{ $charity->charity->title }}</td>
													<td class="text-right">{{ number_format($charity->nominal) }}</td>
													<td>@if($charity)
                                                            <?php
switch ($charity->status) {
case 'PROCESS':
	echo '<label class=\'label label-primary\'>PROCESS</label>';
	break;
case 'SUCCESS':
	echo '<label class=\'label label-success\'>SUCCESS</label>';
	break;
case 'FAILED':
	echo '<label class=\'label label-danger\'>FAILED</label>';
	break;
}
?>
														@endif</td>
													<td></td>
												</tr>
												<?php $nominal += $charity->nominal;?>
												@endforeach

									</tbody>
    							</table>
						</div>
					 </div>
				</div>
				<div class="row">
                <div class="col-md-4">

                    <table class="text-right table table-striped table-bordered dt-responsive nowrap table-custom-blue">
                        <tbody>
                        <tr>
                            <th>Total Transaksi</th>
                            <td>{{count($charities)}}</td>
                        </tr>
                        <tr>
                            <th>Total Nominal</th>
                            <td>IDR {{number_format($nominal)}}</td>
                        </tr>
                        </tbody>
                    </table>
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
