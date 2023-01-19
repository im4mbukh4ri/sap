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
                    <h3 class="blue-title-big">TRANSAKSI TRANSFER DEPOSIT</h3>
                    <div id="dataSearch" class="box-orange">
                        <form action="{{route('admin.transactions_transfer_deposit')}}" method="GET">
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
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="whiteFont">Status</label>
                                            <div class="input-group custom-input">
                                                <?php $statuses = [
	'Waitting',
	'Success',
	'Expired',
	'Cancel',
];?>
                                                <select class="form-control full-width" name="status">
                                                    <option value="">All</option>
                                                    @foreach($statuses as $key => $status)
                                                        @if(old('status')!=null&&old('status')==$key)
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
                    <?php $no = 0;
$count = 1;
function num($rp) {
	if ($rp != 0) {
		$hasil = number_format($rp, 0, '.', ',');
	} else {
		$hasil = 0;
	}
	return $hasil;
}
$no = 1;
$sum = 0;
$sms_tkm = array();
$sms_tdk_tkm = array();
$tfr_deposit = array();
$deposit_sukses = array();
$deposit_non_sukses = array();
?>

                    <div class="dataTable">
                        <table id="data-table" class="text-center table table-striped table-bordered dt-responsive nowrap table-custom-blue">
                            <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Tangal Transaksi</th>
                                <th class="text-center">Dari User</th>
                                <th class="text-center">Ke User</th>
                                <th class="text-center">Nominal</th>
                                <th class="text-center">OTP</th>
                                <th class="text-center">Expaired OTP</th>
                                <th class="text-center">Biaya (IDR)</th>
                                <th class="text-center">Device</th>
                                <th class="text-center">Konfirmasi</th>
                                <th class="text-center">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transferdeposites as $transferdeposit)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ date('d M y H:i:s',strtotime($transferdeposit->created_at)) }}</td>
                                <td>{{ $transferdeposit->fromUser->username }}</td>
                                <td>{{ $transferdeposit->toUser->username }}</td>
                                <td class="text-right">{{ num($transferdeposit->nominal) }}</td>
                                <td>{{ $transferdeposit->otp }}</td>
                                <td>{{ date('d M y H:i:s',strtotime($transferdeposit->expired)) }}</td>
                                <td class="text-right">{{ num($transferdeposit->admin) }}</td>
                                <td>{{ $transferdeposit->device }}</td>


                                 @if($transferdeposit->confirmed =='0')
                                <td>Tidak di Konfirmasi</td>
                                @else
                                <td>Di Konfirmasi</td>
                                @endif

                                @if($transferdeposit->status =='0')
                                <td><label class='label label-warning'><strong><font color="white">Waitting</font></strong></label></td>
                                @elseif($transferdeposit->status =='1')
                                <td><label class='label label-success'><strong><font color="white">Success</font></strong></label></td>
                                @elseif($transferdeposit->status =='2')
                                <td><label class='label label-danger'><strong><font color="white">Expired</font></strong></label></td>
                                @elseif($transferdeposit->status =='3')
                                <td><label class='label label-info'><strong><font color="white">Cancel</font></strong></label></td>
                                @else
                                <td><label class='label label-danger'><strong><font color="white">Failed</font></strong></label></td>
                                @endif
                            </tr>
                            <?php $tfr_deposit[] = 1;
if ($transferdeposit->status == '1') {
	$deposit_sukses[] = $transferdeposit->nominal;
} else {
	$deposit_non_sukses[] = $transferdeposit->nominal;
}
if ($transferdeposit->status != '4') {
	$sms_tkm[] = 1;
} else {
	$sms_tdk_tkm[] = 1;
}
;?>
                            @endforeach
                            </tbody>
                            @if($tfr_deposit < 1)
                                <tr>
                                    <td colspan="11">Tidak ada data</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                    </div>
                    </div>
                    <?php $tot_sms_tkm = collect($sms_tkm)->sum();
$tot_sms_tdk_tkm = collect($sms_tdk_tkm)->sum();
$tot_tfr_deposit = collect($tfr_deposit)->sum();
$tot_deposit_sukses = collect($deposit_sukses)->sum();
$tot_deposit_non_sukses = collect($deposit_non_sukses)->sum();
?>
                    <div class="row">
                    <div class="col-md-4">
                    <div class="table-responsive">
                            <table class="text-right table table-striped table-bordered dt-responsive nowrap table-custom-blue">
                                    <tbody>
                                    <tr>
                                        <td>Total SMS Terkirim</td>
                                        <td>{{ $tot_sms_tkm }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total SMS Tidak Terkirim</td>
                                        <td>{{ $tot_sms_tdk_tkm }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Admin Transfer Deposit</td>
                                        <td>IDR {{ num(($tot_sms_tkm)*1000) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Nominal Transfer Deposit</td>
                                        <td>IDR {{ num($tot_deposit_sukses) }}</td>
                                    </tr>
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
    <script src="{{asset('/assets/js/public/sweetalert.min.js')}}"></script>
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
                'responsive':true,
                'iDisplayLength':100,
                'aLengthMenu':[100,500]
            });
        });
    </script>
@endsection
