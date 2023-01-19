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
                    <h3 class="blue-title-big">LAPORAN KONFIRMASI DEPOSIT</h3>
                    <div id="dataSearch" class="box-orange">
                        <form action="{{route('admin.deposits_ticket')}}" method="GET">
                            {{csrf_field()}}
                            <div class="row-form">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="whiteFont">Dari tanggal</label>
                                            <div class="input-group custom-input">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                <input type="text" name="from" class="form-control" id="datepicker1" value="{{old('from')}}" required>
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-menu-down"></i></span>
                                            </div>
                                        </div>
                                    </div><!--end.col-md-4-->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="whiteFont">Sampai tanggal</label>
                                            <div class="input-group custom-input">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                <input type="text" name="until" class="form-control" id="datepicker2" value="{{old('until')}}" required>
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-menu-down"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label class="whiteFont" for="sip_bank_id">Bank</label>
                                            <select class="form-control" id="sip_bank_id" name="sip_bank_id" required>
                                                <option value="ALL" {{(old('sip_bank_id')=="ALL")?'selected':''}}>ALL</option>
                                                <option value="3" {{(old('sip_bank_id')=="3")?'selected':''}}>BCA</option>
                                                <option value="4" {{(old('sip_bank_id')=="4")?'selected':''}}>BRI</option>
                                                <option value="1" {{(old('sip_bank_id')=="1")?'selected':''}}>MANDIRI</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="whiteFont" for="status">Status</label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="ALL" {{(old('status')=="ALL")?'selected':''}}>ALL</option>
                                                <option value="waiting-transfer" {{(old('status')=="waiting-transfer")?'selected':''}}>Menunggu Transfer</option>
                                                <option value="cancel" {{(old('status')=="cancel")?'selected':''}}>Cancel</option>
                                                <option value="accepted" {{(old('status')=="accepted")?'selected':''}}>Accepted</option>
                                                <option value="rejected" {{(old('status')=="rejected")?'selected':''}}>Rejected</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <br>
                                        <button type="submit" class="btn btn-cari">
                                            <span class="glyphicon glyphicon-search"></span> Cari Data</button>
                                    </div><!--end.col-md-4-->
                                </div><!--end.row-->
                            </div><!--end.row-form-->
                        </form>
                    </div><!--end.box-->
                    @if(count($tickets)>0)
                    <div class="row">
                        <div class="col-md-3">
                            <form action="{{route('admin.deposits_ticket')}}" method="GET" target="_blank" >
                            {{csrf_field()}}
                                 <input type="hidden" name="export" id="export" value="1">
                                 <input type="hidden" name="from" class="form-control" value="{{old('from')}}">
                                 <input type="hidden" name="until" class="form-control" value="{{old('until')}}">
                                 <input type="hidden" name="sip_bank_id" class="form-control" value="{{old('sip_bank_id')}}">
                                 <input type="hidden" name="status" value="{{old('status')}}">
                                 <button type="submit" class="btn btn-cari"><span class="glyphicon glyphicon-download"></span> Export to Excel</button>
                            </form>
                            <hr>
                        </div>
                    </div>
                    @endif
                    <div class="dataTable">
                        <table id="data-table" class="text-center table table-striped table-bordered dt-responsive nowrap table-custom-blue">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Waktu</th>
                                <th>Rekening Tujuan</th>
                                <th>Nominal</th>
                                <th>Status</th>
                                <th></th>
                            </tr>

                            </thead>
                            <tbody>
                              <?php
                                $accepted=array();
                                $canceled=array();
                                $rejected=array();
                              ?>
                            @forelse($tickets as $key => $history)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{date("d-m-Y H:i",strtotime($history->created_at))}}<br>{{ $history->user->username }}</td>
                                    <td>{{$history->sip_bank->bank_name}} - {{$history->sip_bank->number}} ( {{$history->sip_bank->owner_name}} )</td>
                                    {{-- <td class="text-right">@if($history->sip_bank_id===1)IDR {{number_format($history->nominal,'2',',','.')}}@else IDR {{number_format($history->nominal,'2','.',',')}} @endif</td> --}}
                                    <td class="text-right">IDR {{number_format($history->nominal,'2','.',',')}}</td>
                                    @if($history->status!='waiting-transfer')
                                        @if($history->status=='accepted')
                                            <?php
                                                $accepted[]=$history->nominal;
                                             ?>
                                            <td><span class="label label-success">Accepted</span></td>
                                            <td></td>
                                        @elseif ($history->status=='cancel')
                                          <?php
                                            $canceled[]=$history->nominal;
                                          ?>
                                          <td><span class="label label-info">Canceled</span></td>
                                          <td></td>
                                        @else
                                          <?php
                                            $rejected[]=$history->nominal;
                                          ?>
                                            <td><span class="label label-danger">Rejected</span></td>
                                            <td></td>
                                        @endif
                                    @else
                                        <td class="form-inline">
                                            <form action="{{ route('admin.deposits_ticket_update') }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ Form::hidden('ticket_id',$history->id) }}
                                                <span class="label label-warning" style="color: #0b0b0b">{{ $history->last_status }}</span> |
                                                <button class="btn btn-xs btn-blue js-submit-confirm" type="submit"><i class="fa fa-check"></i> Accept</button>
                                            </form>
                                        </td>
                                        <td><form action="{{ route('admin.deposits_ticket_cancel') }}" method="POST">{{ csrf_field() }}<input type="hidden" name="id" value="{{ $history->id }}"><button class="btn btn-xs btn-danger">X Reject</button></form></td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">Tidak ada data</td>
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
                      <td>Accepted</td>
                      <td>:</td>
                      <td>IDR {{number_format(collect($accepted)->sum())}}</td>
                    </tr>
                    <tr>
                      <td>Rejected</td>
                      <td>:</td>
                      <td>IDR {{number_format(collect($rejected)->sum())}}</td>
                    </tr>
                    <tr>
                      <td>Canceled</td>
                      <td>:</td>
                      <td>IDR {{number_format(collect($canceled)->sum())}}</td>
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
