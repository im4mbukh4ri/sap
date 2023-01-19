@extends('layouts.public')
@section('css')
    @parent
    <link rel="stylesheet" href="{{asset('/assets/css/public/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/css/public/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/css/public/responsive.bootstrap.min.css')}}">
@endsection
@section('content')
    <section class="section-pilih-seat">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="blue-title-big">TOTAL DEPOSIT MEMBER</h3>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-3">
                </div>
                <div class="col-md-6">
                    <table class="text-right table table-striped table-bordered dt-responsive nowrap table-custom-blue">
                        <tbody>
                          <tr>
                              <th>TIPE MEMBER</th>
                              <th>JUMLAH MEMBER </th>
                              <th>TOTAL DEPOSIT </th>
                          </tr>
                        <tr>
                            <td>Basic</td>
                            <td>{{ $total['basic'] }}</td>
                            <td>IDR {{ number_format($total_deposit['basic']) }}</td>
                        </tr>
                        <tr>
                            <td>Advance</td>
                            <td>{{ $total['advance'] }}</td>
                            <td>IDR {{ number_format($total_deposit['advance']) }}</td>
                        </tr>
                        <tr>
                            <td>Pro</td>
                            <td>{{ $total['pro'] }}</td>
                            <td>IDR {{ number_format($total_deposit['pro']) }}</td>
                        </tr>
                        <tr>
                            <td>Free</td>
                            <td>{{ $total['free'] }}</td>
                            <td>IDR {{ number_format($total_deposit['free']) }}</td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td>{{ $total['ALL'] }}</td>
                            <td>IDR {{ number_format($total_deposit['ALL']) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-3">
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
                'iDisplayLength':100,
                'aLengthMenu':[100,500]
            });
        });
    </script>
@endsection
