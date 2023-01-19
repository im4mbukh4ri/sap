@extends('layouts.public')
@section('css')
    @parent
    <link rel="stylesheet" href="{{asset('/assets/css/public/sweetalert.css')}}">

@endsection
@section('content')
    <section class="section-pilih-seat">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="blue-title-big">Setting Point & Limit Deposit</h3>
                    <br>
                    <div class="col-md-6">
                        <div class="panel panel-default blue-panel">
                            <form method="POST" action="{{ route('admin.settings_point_update') }}">
                                {{ csrf_field() }}
                                <div class="panel-heading" style="color: white;"></div>
                                <div class="panel-body">
                                    <table class="table">
                                        <tr>
                                            <th>Point Reward<br><span class="help-block">Point yang didapatkan oleh refferal</span> </th>
                                            <td><input type="number" name="point_reward" value="{{ $point_reward->point }}" class="form-control col-md-2"></td>
                                        </tr>
                                        <tr>
                                            <th>Point Value<br><span class="help-block">Nilai satu point</span> </th>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-addon">IDR</div>
                                                    <input type="number" name="point_value" class="form-control" value="{{ $point_value->idr }}">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Point Max<br><span class="help-block">Maksimal point yang bisa digunakan</span> </th>
                                            <td><input type="number" name="point_max" value="{{ $point_max->point }}" class="form-control col-md-2"></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="panel-footer">
                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default blue-panel">
                            <form method="POST" action="{{ route('admin.settings_point_update') }}">
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
<script type="text/javascript">
        $('.money').mask("#,##0", {reverse: true});
</script>
                                {{ csrf_field() }}
                                <div class="panel-heading" style="color: white;"></div>
                                <div class="panel-body">
                                    <table class="table">

                                        <tr>
                                            <th>Basic<br><span class="help-block">Limit Deposit</span> </th>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-addon">IDR</div>
                                                    <input type="text" name="basic" class="form-control money" value="{{ number_format($basic->idr) }}">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Advance<br><span class="help-block">Limit Deposit</span> </th>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-addon">IDR</div>
                                                    <input type="text" name="advance" class="form-control money" value="{{ number_format($advance->idr) }}">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Pro<br><span class="help-block">Limit Deposit</span> </th>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-addon">IDR</div>
                                                    <input type="number" name="pro" class="form-control" placeholder="Unlimited" disabled="">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Free<br><span class="help-block">Limit Deposit</span> </th>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-addon">IDR</div>
                                                    <input type="text" name="free" class="form-control money" value="{{ number_format($free->idr) }}">
                                                    <input type="hidden" name="limit" value="1">
                                                </div>
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                                <div class="panel-footer">
                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    @parent
    <script src="{{asset('/assets/js/public/sweetalert.min.js')}}"></script>
@endsection