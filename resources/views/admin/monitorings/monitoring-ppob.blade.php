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
                    <h3 class="blue-title-big">MONITORING PPOB</h3>
<br>
                    <div class="dataTable">
                        <table id="data-table" class="text-center table table-striped table-bordered dt-responsive nowrap table-custom-blue">
                            <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Username</th>
                                <th>Produk</th>
                                <th>ID Pelanggan</th>
                                <th>Market Price</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($transactions as $key => $transaction)
                                <tr>
                                    <td>{{ date("d M Y H:i",strtotime($transaction->created_at)) }}</td>
                                    <td>{{ $transaction->user->username }}</td>
                                    <td class="text-left">{{ $transaction->ppob_service->name}}</td>
                                    <td>{{ $transaction->number }}</td>
                                    <td class="text-right">{{ number_format($transaction->paxpaid) }}</td>
                                    <td>@if($transaction->status=="PENDING")<label class="label label-warning">{{ $transaction->status }}</label>@elseif($transaction->status=="SUCCESS")<label class="label label-success">{{ $transaction->status }}</label>@else <label class="label label-danger">{{ $transaction->status }}</label> @endif </td>
                                </tr>
                          @empty
                                <tr>
                                    <td colspan="6">Tidak ada data</td>
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
