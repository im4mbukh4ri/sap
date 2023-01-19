@extends('layouts.public')
@section('css')
    @parent
@endsection
@section('content')
    <section class="section-pilih-seat">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="blue-title-big">Tiket Deposit</h3>
                    <div id="dataSearch" class="box-orange">
                        <div class="row-form">
                             <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
<script type="text/javascript">
        $('.money').mask("#,##0", {reverse: true});
</script>
                            <form action="{{route('deposits.ticket_create')}}" method="POST">
                                {{csrf_field()}}
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="received_bank">Rek. Tujuan Transfer</label>
                                        <select name="sip_bank_id" id="sip_bank_id" class="form-control" required>
                                            @foreach(\App\SipBank::where('status',1)->get() as $bank)
                                            <option value="{{$bank->id}}">{{$bank->bank_name}} - {{ $bank->number }} - {{ $bank->owner_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="nominal">Nominal Deposit</label>
                                        <input type="text" name="nominal" id="nominal" class="form-control money" required min="0">
                                    </div>
                                </div><!--end.col-md-4-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="note">Catatan (Opsional)</label>
                                        <input type="text" name="note" id="note" class="form-control" placeholder="Catatan tambahan.">
                                    </div>
                                </div><!--end.col-md-4-->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="btnSubmit">&nbsp;</label>
                                        <button type="submit" class="btn btn-cari">
                                            <span class="glyphicon glyphicon-check"> Submit</span>
                                        </button>
                                    </div>
                                </div><!--end.col-md-4-->
                            </div><!--end.row-->
                            </form>
                        </div><!--end.row-form-->
                    </div><!--end.box-range-->
                </div><!--end.col-md-12-->
            </div><!--end.row-->
        </div><!--end.container-->
    </section>
@endsection
@section('js')
    @parent
@endsection
