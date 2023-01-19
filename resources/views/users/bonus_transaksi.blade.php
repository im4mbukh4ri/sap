@extends('layouts.public')

@section('css')
    @parent
    <link rel="stylesheet" href="{{asset('/assets/css/public/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/css/public/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/css/public/responsive.bootstrap.min.css')}}">
@endsection
@section('content')
    <section>
      <div class="container">
          <div class="row">
              <div align="center" class="col-md-12">
                <h2>Statistik Bonus Transaksi Tahun {{$year}}<h2>
              </div>
              <div class="col-md-12">
                <div class="col-md-4">
                  <div align="center" id="deviceChart" style="height: 250px;"></div>
                  <div align="center">
                    <h6>
                      <span style="background-color:#ff8e17;"> &nbsp;&nbsp;&nbsp;&nbsp; </span>
                      &nbsp;&nbsp; Free User &nbsp;&nbsp;
                      <span style="background-color:rgb(11, 98, 164);"> &nbsp;&nbsp;&nbsp;&nbsp; </span>
                      &nbsp;&nbsp; Member &nbsp;&nbsp;
                    </h6>
                  </div>
                  <br>
                  <div class="dataTable table-responsive">
                      <table id="data-table" class="text-center table table-striped table-bordered dt-responsive nowrap table-custom-blue">
                          <thead>
                          <tr>
                              <th><h5>TRANSACTION DIFFERENCE</h5></th>
                          </tr>
                          </thead>
                          <tbody>
                              <tr>
                                <?php
                                $allMember = (int) $totalMember['data']+ (int) $totalFree;
                                $percentFreeUser = 0;
                                if($allMember !== 0){
                                    $percentFreeUser = (int) $totalFree / (int) $allMember * 100;
                                }

                                ?>
                                  <td> <h3><span style="background-color:#ff8e17;"> &nbsp;&nbsp;&nbsp;&nbsp; </span> &nbsp;&nbsp;{{ floor($percentFreeUser) }}% - @if($allMember === 0) 0% @else {{ 100 - floor($percentFreeUser)}}% @endif &nbsp;&nbsp;<span style="background-color:rgb(11, 98, 164);"> &nbsp;&nbsp;&nbsp;&nbsp; </span></h3></td>
                              </tr>
                          </tbody>
                      </table>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="dataTable table-responsive">
                      <table id="data-table" class="text-center table table-striped table-bordered dt-responsive nowrap table-custom-blue">
                          <thead>
                          <tr>
                              <th></th>
                              <th><h5>TRANSACTION</h5></th>
                              <th><h5>SMART POINT</h5></th>
                          </tr>

                          </thead>
                          <tbody>
                              <tr>
                                  <td><h5>MEMBER</h5></td>
                                  <td><h5>{{number_format($bonusTransaksi['data'][0]['transaksi_member'])}}</h5></td>
                                  <td><h5>{{number_format($bonusTransaksi['data'][0]['smartpoint_member'])}}</h5></td>
                              </tr>
                              <tr>
                                  <td><h5>FREE USER</h5></td>
                                  <td><h5>{{number_format($bonusTransaksi['data'][0]['transaksi_free'])}}</h5></td>
                                  <td><h5>{{number_format($bonusTransaksi['data'][0]['smartpoint_free'])}}</h5></td>
                              </tr>
                              <tr>
                                  <td><h5>TOTAL TRANSACTION</h5></td>
                                  <td><h5>{{number_format($bonusTransaksi['data'][0]['total_transaksi'])}}</h5></td>
                                  <td><h5>{{number_format($bonusTransaksi['data'][0]['total_smartpoint'])}}</h5></td>
                              </tr>
                          </tbody>
                      </table>
                  </div>
                  <div class="dataTable table-responsive">
                      <table id="data-table" class="text-center table table-striped table-bordered dt-responsive nowrap table-custom-blue">
                          <thead>
                          <tr>
                              <th colspan="2" ><h5>BONUS PER BULAN<h5></th>
                          </tr>
                          </thead>
                          <tbody>
                          @for ($i = 0; $i < 6; $i++)
                              <tr>
                                  <td style="width:50%;">
                                    <p>{{$months[$i]}}</p>
                                    @if($bonus['status'] === "200")
                                    <h3>{{number_format($bonus['data'][$i]['bonus'])}}</h3>
                                    @else
                                    <h3>-</h3>
                                    @endif
                                  </td>
                                  <td style="width:50%;">
                                    <p>{{$months[$i+6]}}</p>
                                    @if($bonus['status'] === "200")
                                    <h3>{{number_format($bonus['data'][$i+6]['bonus'])}}</h3>
                                    @else
                                    <h3>-</h3>
                                    @endif
                                  </td>
                              </tr>
                          @endfor
                          </tbody>
                      </table>
                  </div>
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
    <script src="{{asset('/assets/js/public/responsive.bootstrap.min.js')}}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script>
        // test commit
    new Morris.Donut({
        element: 'deviceChart',
        data: [
        @if($totalMember['status'] === "200")
            {label: "Member", value: {{$totalMember['data']}}},
        @else
        {label: "Member", value: '0',
        @endif
            {label: "Free User", value: {{$totalFree}}},
        ],
        colors: [
           'rgb(11, 98, 164)',
           '#ff8e17',
         ]
    });
    </script>

@endsection
