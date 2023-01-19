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
                    <h3 class="blue-title-big">TRANSAKSI RESET PASSWORD</h3>
                    <div id="dataSearch" class="box-orange">
                        <form action="{{route('admin.transactions_reset_password')}}" method="GET">
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
                                                    'Failed',
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
                    <div class="dataTable">
                        <table id="data-table" class="text-center table table-striped table-bordered dt-responsive nowrap table-custom-blue">
                            <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Tangal Transaksi</th>
                                <th class="text-center">Member</th>
                                <th class="text-center">OTP</th>
                                <th class="text-center">Expaired OTP</th>
                                <th class="text-center">Biaya (IDR)</th>
                                <th class="text-center">Tipe</th>
                                <th class="text-center">Confirmed</th>
                                <th class="text-center">Status</th> 
                            </tr>
                            </thead>
<?php $no=0;
$count=1;
function num($rp){
if($rp!=0){
  $hasil = number_format($rp,0, '.', ',');
  }
  else{
  $hasil=0;
  }
return $hasil;
}
$no=1;$sum=0;$firstLogin=array();$resetpass=array();$biayafirstLogin=array();$biayaresetpass=array();$sms_tkm = array();$sms_tdk_tkm = array();?>
                            <tbody>
                            @foreach($resetpasswords as $resetpassword)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ date('d M y H:i:s',strtotime($resetpassword->created_at)) }}</td>
                                <td>{{ $resetpassword->user->username }}</td>
                                <td>{{ $resetpassword->otp }}</td>
                                <td>{{ date('d M y H:i:s',strtotime($resetpassword->expired)) }}</td>
                                <td class="text-right">IDR {{ num($resetpassword->admin) }}</td>
                                @if($resetpassword->activation =='0')
                                <?php $resetpass[] = 1;
                                $biayaresetpass[] = $resetpassword->admin;?>
                                <td>Reset Password</td>
                                @else
                                <?php $firstLogin[] = 1;
                                $biayafirstLogin[] = $resetpassword->admin;?>
                                <td>First Login</td>
                                @endif

                                 @if($resetpassword->confirmed =='0')
                                <td>Tidak di Konfirmasi</td>
                                @else
                                <td>Di Konfirmasi</td>
                                @endif

                                @if($resetpassword->status =='0')
                                <td><label class='label label-warning'><strong><font color="white">Waitting</font></strong></label></td>
                                @elseif($resetpassword->status =='1')
                                <td><label class='label label-success'><strong><font color="white">Success</font></strong></label></td>
                                @elseif($resetpassword->status =='2')
                                <td><label class='label label-danger'><strong><font color="white">Expired</font></strong></label></td>
                                @elseif($resetpassword->status =='3')
                                <td><label class='label label-info'><strong><font color="white">Cancel</font></strong></label></td>
                                @else
                                <td><label class='label label-danger'><strong><font color="white">Failed</font></strong></label></td>
                                @endif
                            </tr>
                            
                             
                            <?php $sum+=$resetpassword->admin;
                                    if($resetpassword->status !='4'){
                                        $sms_tkm[] = 1;
                                    }else{
                                        $sms_tdk_tkm[] =1;
                                    };?>
                            @endforeach
                            </tbody> 
                        </table>
                    </div>
                    <?php $tot_sms_tkm=collect($sms_tkm)->sum();
                    $tot_sms_tdk_tkm=collect($sms_tdk_tkm)->sum();
                    $tot_resetpass=collect($resetpass)->sum();
                    $tot_firstLogin=collect($firstLogin)->sum();
                    $tot_biayaresetpass=collect($biayaresetpass)->sum();
                    $tot_biayafirstLogin=collect($biayafirstLogin)->sum();?>
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
                                        <td>Total SMS First Login</td>
                                        <td>{{ $tot_firstLogin }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total SMS Reset Password</td>
                                        <td>{{ $tot_resetpass }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Admin First Login</td>
                                        <td>IDR {{ num($tot_biayafirstLogin) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Admin Reset Password</td>
                                        <td>IDR {{ num($tot_biayaresetpass) }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
