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
                            @forelse($tickets as $key => $history)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{ date("d M Y H:i",strtotime($history->created_at)) }}</td>
                                    <td>{{ $history->user->username }}</td>
                                    <td class="text-right">{{ number_format($history->debit) }}</td>
                                    <td class="text-right">{{ number_format($history->credit) }}</td>
                                    <td class="text-right">{{ number_format($history->deposit) }}</td>
                                    <td class="text-left">{{ $history->note }}</td>
                                <th>Keterangan</th>
                            </tr>

                            </thead>
                            <tbody>
                  <?php $totDeb = 0;
$totKre = 0;?>
                            @forelse($tickets as $key => $history)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right"></td>
                                    <td class="text-right"></td>
                                    <td class="text-left"></td>
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
            <div class="row">
              <div class="col-md-4">
                <div class="table-responsive">
                  <table class="table">
                    <tr>
                      <td>Total Debet</td>
                      <td>:</td>
                      <td>IDR </td>
                    </tr>
                    <tr>
                      <td>Total Kredit</td>
                      <td>:</td>
                      <td>IDR </td>
                    </tr>
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
            $(document.body).on('click', '.js-submit-confirm', function (event) {
                event.preventDefault();
                var $form = $(this).closest('form');
                var $el = $(this);
                var text = $el.data('confirm-message') ? $el.data('confirm-message') : 'Anda tidak bisa membatalkan proses ini!'
                swal({
                        title: 'Anda akan menambahkan deposit.',
                        text: text,
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#0c5484',
                        confirmButtonText: 'Ya!',
                        cancelButtonText: 'Batal',
                        closeOnConfirm: true
                    },
                    function () {
                        $form.submit()
                    })
            });

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
                'aLengthMenu':[100,500]
            });
        });
    </script>
@endsection
