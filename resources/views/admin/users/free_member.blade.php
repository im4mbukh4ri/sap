@extends('layouts.public')
@section('css')
    @parent
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
@endsection
@section('content')
    <section class="section-pilih-seat">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="blue-title-big">FREE MEMBER</h3>
                    @if(isset($total))
                        <div class="row">
                            <div class="col-md-6">
                              <div id="operatorChart" style="height: 500px; width: auto;"></div>
                            </div>
                            <div class="col-md-6">
                              <div class="table-responsive">
                                <table class="table">
                                  <thead>
                                    <tr>
                                      <th>Statistik Free Member</th>
                                      <th></th>
                                      <th></th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>Free Member Aktif</td>
                                      <td>:</td>
                                      <td>{{$total['aktif']}}</td>
                                    </tr>
                                    <tr>
                                      <td>Free Member Pasif</td>
                                      <td>:</td>
                                      <td>{{$total['pasif']}}</td>
                                    </tr>
                                    <tr>
                                      <td>Free Member Unverified</td>
                                      <td>:</td>
                                      <td>{{$total['unverified']}}</td>
                                    </tr>
                                    <tr>
                                      <td>Total Free Member</td>
                                      <td>:</td>
                                      <td>{{$total['free_member']}}</td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    @parent
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script src="{{asset('/assets/js/admin/jquery.dataTables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/assets/js/admin/dataTables.bootstrap4.min.js')}}" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            @if(isset($total))
            new Morris.Donut({
                element: 'operatorChart',
                data: [
                  {label: "Aktif", value: "{{ $total['aktif'] }}"},
                  {label: "Pasif", value: "{{ $total['pasif'] }}"},
                  {label: "Unverified", value: "{{ $total['unverified'] }}"},
                ]
            });
            $('#nominalTable').DataTable({
                "order": [[ 1, "desc" ]],
                "paging":false,
                'iDisplayLength':100,
                "searching":false
            });
            @endif
        });
    </script>
@endsection
