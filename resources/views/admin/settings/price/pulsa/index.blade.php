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
                    <h3 class="blue-title-big">Setting Pulsa</h3>
                    <br>
                    @foreach($operators as $key => $operator)
                        @if($key==0||$key==2||$key==4||$key==6||$key==8)
                        <div class="row">
                        @endif
                        <div class="col-md-6">
                            <div class="panel panel-default blue-panel">
                                <form method="POST" action="{{ route('admin.settings_price_pulsa_update',$operator->id) }}">
                                    {{ csrf_field() }}
                                    <div class="panel-heading" style="color: white;">{{ $operator->name }}</div>
                                    <div class="panel-body">
                                        <img src="{{ asset('/images/logo/operator/'.logoOperator($operator->id))}}" class="img-responsive" style="height: 75px; width: auto; display: block; margin: auto;">
                                        <table class="table">
                                            <tr>
                                                <td style="width: 40%;text-align: center;">Nominal</td>
                                                <td style="width: 20%;text-align: center;">Market Price</td>
                                                <td style="width: 20%;text-align: center;">Komisi</td>
                                                <td style="width: 20%;text-align: center;">Markup Free Member</td>
                                                <td style="width: 20%;text-align: center;">Markup Smart Point</td>
                                                <td style="width: 20%;text-align: center;">Status</td>
                                            </tr>
                                            @foreach($operator->childs as $child)
                                                {!! \Illuminate\Support\Facades\Log::info($child->name) !!}
                                                <tr>
                                                    <td>{{ $child->name }}</td>
                                                    <td><input type="number" name="price[]" class="form-control" value="{{$child->pulsa_price->first()->price}}"></td>
                                                    <td><input type="number" name="commission[]" class="form-control" value="{{$child->pulsa_commission->first()->commission}}"> </td>
                                                    <td><input type="number" name="markup[]" class="form-control" value="{{(int) $child->pulsa_markup->first()->markup}}"></td>
                                                    <td><input type="number" name="bv_markup[]" class="form-control" value="{{(int) $child->pulsa_bv_markup->first()->markup}}"></td>
                                                    <td>{{ ($child->status)? 'open': 'close' }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                    <div class="panel-footer">
                                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @if($key==1||$key==3||$key==5||$key==7||$key==9)
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    @parent
    <script src="{{asset('/assets/js/public/sweetalert.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $(document.body).on('click', '.js-submit-confirm', function (event) {
                event.preventDefault();
                var $form = $(this).closest('form');
                var $el = $(this);
                var text = $el.data('confirm-message') ? $el.data('confirm-message') : 'Anda tidak bisa membatalkan proses ini!';
                swal({
                        title: 'Anda akan menghapus banner dipilih.',
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
        });
    </script>
@endsection