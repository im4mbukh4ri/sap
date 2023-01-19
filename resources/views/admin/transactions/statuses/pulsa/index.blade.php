@extends('layouts.public')
@section('css')
    @parent
@endsection
@section('content')
    <section class="section-pilih-seat">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="blue-title-big">CEK STATUS TRANSAKSI PULSA & PPOB</h3>
                    <div id="dataSearch" class="box-orange">
                        <form action="{{route('admin.transactions_pulsa_status')}}" method="GET">
                            {{csrf_field()}}
                            <div class="row-form">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="whiteFont">ID Transaksi</label>
                                            <div class="input-group custom-input">
                                                <input type="text" name="id" class="form-control" value="{{ old('id') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <br>
                                        <button type="submit" class="btn btn-cari btn-sm">
                                            <span class="glyphicon glyphicon-search"></span> Cari Data</button>
                                    </div><!--end.col-md-4-->
                                </div><!--end.row-->
                            </div><!--end.row-form-->
                        </form>
                    </div><!--end.box-->

                    @if(isset($transaction))
                        <table class="table">
                            <tr>
                                <th>Operator</th>
                                <td>{{$transaction->ppob_service->parent->name}}</td>
                                <th>Market Price</th>
                                <td>IDR {{ number_format($transaction->paxpaid) }}</td>
                            </tr>
                            <tr>
                                <th>Nominal</th>
                                <td>{{$transaction->ppob_service->name}}</td>
                                <th>Smart Price</th>
                                @if($transaction->transaction_commission)
                                <td>IDR {{ number_format($transaction->paxpaid-$transaction->transaction_commission->member) }}</td>
                                @else
                                <td>-</td>
                                @endif
                            </tr>
                            <tr>
                                <th>No. HP.</th>
                                <td>{{$transaction->number}}</td>
                                <th>Smart Cash</th>
                                @if($transaction->transaction_commission)
                                <td>IDR {{ number_format($transaction->transaction_commission->member) }}</td>
                                @else
                                <td>-</td>
                                @endif
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <?php
switch ($transaction->status) {
case 'SUCCESS':
    echo "<label class='label label-success'>SUCCESS</label>";
    break;
case 'PENDING':
    echo "<label class='label label-warning'>PENDING</label>";
    break;
case 'FAILED':
    echo "<label class='label label-danger'>FAILED</label>";
    break;
case 'PROCESS':
    echo "<label class='label label-info'>ON PROCESS</label>";
    break;
}
?>
                                </td>
                                <th>Serial Number</th>
                                <td>{{ $transaction->serial_number }}</td>
                            </tr>
                        </table>
                        @if($transaction->service === 1)
                        <div class="row">
                            <div class="col-md-6">
                                <form action="{{ route('admin.transactions_pulsa_status_update') }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{$transaction->id}}">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="status" style="color: #0b0b0b;">UPDATE STATUS</label>
                                            <div class="input-group custom-input">
                                                <select name="status" id="status">
                                                    <option value="SUCCESS" {{($transaction->status=='SUCCESS')?'selected':''}}>SUCCESS</option>
                                                    <option value="PENDING" {{($transaction->status=='PENDING')?'selected':''}}>PENDING</option>
                                                    <option value="FAILED" {{($transaction->status=='FAILED')?'selected':''}}>FAILED</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <br>
                                        <button type="submit" class="btn btn-cari btn-sm">
                                            <span class="glyphicon glyphicon-refresh"></span> UPDATE</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                      @endif
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    @parent
@endsection
