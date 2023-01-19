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
                    <h3 class="blue-title-big">STATISTIK POINT REWARD</h3>
                    <div id="dataSearch" class="box-orange">
                        <form action="{{route('admin.statistics_point_reward')}}" method="GET">
                            {{csrf_field()}}
                            <div class="row-form">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="whiteFont">Dari tanggal</label>
                                            <div class="input-group custom-input">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                <input type="text" name="start_date" class="form-control" id="datepicker1">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-menu-down"></i></span>
                                            </div>
                                        </div>
                                    </div><!--end.col-md-4-->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="whiteFont">Sampai tanggal</label>
                                            <div class="input-group custom-input">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                <input type="text" name="end_date" class="form-control" id="datepicker2">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-menu-down"></i></span>
                                            </div>
                                        </div>
                                    </div><!--end.col-md-4-->
                                    <div class="col-md-3">
                                        <br>
                                        <button type="submit" class="btn btn-cari">
                                            <span class="glyphicon glyphicon-search"></span> Lihat Statistik</button>
                                    </div><!--end.col-md-4-->
                                </div><!--end.row-->
                            </div><!--end.row-form-->
                        </form>
                    </div><!--end.box-->
                    @if(isset($points))
                        <div class="row">
                            <div class="col-md-6">
                              <div class="table-responsive">
                                <table id="data-table" class="table table-custom-blue">
                                    <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>PR Debit</th>
                                        <th>PR Kredit</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      $totalDebit=0;
                                      $totalCredit=0;
                                       ?>
                                      @foreach ($points as $key => $point)
                                        <?php
                                        $totalDebit+=$point[0]->debit;
                                        $totalCredit+=$point[0]->credit;
                                         ?>
                                        <tr>
                                          <td>{{ date('d M',strtotime(old('start_date'). ' + '.$key.' days')) }}</td>
                                          <td>{{$point[0]->debit}}</td>
                                          <td>{{$point[0]->credit}}</td>
                                        </tr>
                                      @endforeach
                                    </tbody>
                                </table>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="table-responsive">
                                <table class="table">
                                  <thead>
                                    <tr>
                                      <th></th>
                                      <th></th>
                                      <th>Total Point Reward</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>Debit</td>
                                      <td>:</td>
                                      <td>{{$totalDebit}}</td>
                                    </tr>
                                    <tr>
                                      <td>Kredit</td>
                                      <td>:</td>
                                      <td>{{$totalCredit}}</td>
                                    </tr>
                                    <tr>
                                      <td>Point Semua member</td>
                                      <td>:</td>
                                      <td>{{$all[0]->point}}</td>
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
            $("#datepicker1").datepicker({
                // todayHighlight:1,
                // todayBtn:  1,
                // autoclose: true,
                // startDate:'0d',
                onSelect: function(date) {
                    var myDate=date;
                    var mySplit=myDate.split('-');
                    var d = new Date(mySplit[2],mySplit[1]-1,mySplit[0]);
                    var newD= new Date(d.setDate(d.getDate()+31));
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

            @if(isset($transactions))
            new Morris.Donut({
                element: 'operatorChart',
                data: [
                @foreach($transactions as $key => $transaction )
                        @if(count($transaction)>0)
                {label: "{{ (isset( $transaction[0]))?$transaction[0]->ppob_service->name:'' }}", value: '{{ count($transaction) }}'},
                        @endif
                    @endforeach

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
