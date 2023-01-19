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
                    <h3 class="blue-title-big">Banner Mobile Apps</h3>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-lg btn-orange" data-toggle="modal" data-target="#formBanner"><i class="fa fa-plus"></i> Tambah Banner</button>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        @foreach($banners as $banner)
                        <div class="col-md-6">
                            <div class="panel panel-default blue-panel">
                                <div class="panel-heading" style="color: white;">{{ date("d M y H:i",strtotime($banner->created_at)) }} @if($banner->status===1) <span class="pull-right">Status : <label class="label label-success">Aktif</label></span>@else <span class="pull-right">Status : <label class="label label-danger">Non-aktif</label></span>@endif</div>
                                <div class="panel-body">

                                    <form action="{{ route('admin.banners_update') }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ Form::hidden('id',$banner->id) }}
                                        @if($banner->status===1)
                                            <button class="btn btn-danger pull-right" type="submit"><i class="fa fa-circle-o"></i> Non-aktifkan</button>
                                        @else
                                            <button class="btn btn-success pull-right" type="submit"><i class="fa fa-circle"></i> Aktifkan</button>
                                        @endif
                                    </form>
                                    <br>
                                    <br>
                                    <img src="{{ $banner->url_banner }}" class="img-responsive" alt="banner" style="height: 300px; display: block; margin: auto;">
                                </div>
                                <div class="panel-footer">
                                    <form action="{{ route('admin.banners_destroy') }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ Form::hidden('id',$banner->id) }}
                                        <button class="btn btn-danger js-submit-confirm" type="submit"><i class="fa fa-trash-o"></i> Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="formBanner" tabindex="-1" role="dialog" aria-labelledby="formBannerLabel">
        <div class="modal-dialog" role="document">
            <form action="{{ route('admin.banners_store') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Upload Banner</h4>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputFile">Masukan Banner</label>
                            <input type="file" name="banner">
                            <p class="help-block"></p>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">BATAL</button>
                    <button type="submit" class="btn btn-primary">UPLOAD</button>
                </div>
            </div>
            </form>
        </div>
    </div>
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