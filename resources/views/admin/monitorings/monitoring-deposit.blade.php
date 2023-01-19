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
                    <h3 class="blue-title-big">MONITORING DEPOSIT</h3>
<br>
                    <div class="dataTable">
                        <table id="data-table" class="text-center table table-striped table-bordered dt-responsive nowrap table-custom-blue">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Waktu</th>
                                <th>User id</th>
                                <th>Debet</th>
                                <th>Kredit</th>
                                <th>Saldo Akhir</th>
                                <th>Keterangan</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($deposits as $key => $deposit)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{ date("d M Y H:i",strtotime($deposit->created_at)) }}</td>
                                    <td>{{ $deposit->user->username }}</td>
                                    <td class="text-right">{{ number_format($deposit->debit) }}</td>
                                    <td class="text-right">{{ number_format($deposit->credit) }}</td>
                                    <td class="text-right">{{ number_format($deposit->deposit-$deposit->debit+$deposit->credit) }}</td>
                                    <td class="text-left">{{ isset(explode('|',$deposit->note)[2])?explode('|',$deposit->note)[2]:$deposit->note }}</td>
                            </tr>
                          @empty
                                <tr>
                                    <td colspan="7">Tidak ada data</td>
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
    <script src="{{asset('/assets/js/public/datatables.min.js')}}"></script>
    <script src="{{asset('/assets/js/public/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $(document).ready(function () {

            $("#datepicker1").datepicker({
                onSelect: function(date) {
                    $( "#datepicker2" ).datepicker( "option","minDate",date);
                    $( "#datepicker2" ).datepicker( "option","maxDate",new Date());
                    $( "#datepicker2" ).datepicker( "setDate",date);
                },
                maxDate: new Date(),
                dateFormat:'dd-mm-yy'

            });
            $( "#datepicker2" ).datepicker({
                maxDate: new Date(),
                dateFormat:'dd-mm-yy'
            });
            // $('#data-table').DataTable({
            //     'paging':true,
            //     'ordering':false,
            //     'info':false,
            //     'responsive':true,
            //     'iDisplayLength':100
            // });
            $('#data-table').DataTable({
                'paging':true,
                'ordering':false,
                'info':false,
                'responsive':true,
                'iDisplayLength':100,
                'aLengthMenu':[100]
            });
        });
    </script>
@endsection
