@extends('layouts.public')
@section('css')
    @parent
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
    <link href="{{asset('assets/css/public/summernote.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('/assets/css/public/sweetalert.css')}}">
@endsection
@section('content')
    <section class="section-pilih-seat">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="blue-title-big">PROGRAM CHARITY</h3>
                            <hr>
                            {!! Form::open(['route'=>'admin.operational_charitis','method'=>'post','enctype'=>'multipart/form-data']) !!}
                            <div class="form-group">
                                <label for="title" class="">Judul</label>
                                <input type="text" id="title" name="title" class="form-control" autofocus>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="file-field">
                                        <div class="btn btn-default btn-sm">
                                            <span>Upload Gambar</span>
                                            <input type="file" name="file">
                                        </div>
                                    </div>
                                </div>
                            </div><br>
                            <textarea id="content" name="content"></textarea>
                            <button type="submit" class="btn btn-blue">Post Charity</button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h3 class="blue-title-big">List Program Charity</h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th style="width:80%;">Judul</th>
                                    <th style="width:20%"><a class="btn btn-md btn-primary" href="{{route('admin.operational_charitis')}}">ADD <i class="fa fa-plus"></i></a></th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($charites as $chariti)
                                    <tr>
                                        <td>{{$chariti->title}}</td>
                                        <td class="text-center">
                                          <form action="{{ route('admin.operational_charity.status') }}" method="POST">
                                            <a href="javascript:void(0)" data-toggle="modal" data-target=".chariti{{$chariti->id}}"> <i class="fa fa-search"></i></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="{{url('admin/operational/charity').'/'.$chariti->id.('/edit')}}"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                            {{ csrf_field() }}
                                            {{ Form::hidden('id', $chariti->id, ['class'=> 'charity_id', 'id' => 'charity_id']) }}
                                            {{ Form::hidden('title', $chariti->title , ['class'=> 'charity_title', 'id' => 'charity_title']) }}
                                            @if($chariti->status==0)
                                            {{ Form::hidden('status','1', ['class'=> 'status']) }}
                                            <a href="javascript:void(0)" data-confirm-message="{{$chariti->title}}" class="fa fa-close charities_open"></a>
                                            @else
                                            {{ Form::hidden('status','0', ['class'=> 'status']) }}
                                            <a href="javascript:void(0)" data-confirm-message="{{$chariti->title}}" class="fa fa-check charities_close"></a>
                                             @endif
                                           </form>
                                        </td>
                                    </tr>
                                    <div class="modal fade chariti{{$chariti->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h4 class="modal-title" id="myModalLabel">{{$chariti->title}}</h4>
                                                </div>
                                                <div class="modal-body">
                                                    @if($chariti->url_image)
                                                        <img src="{{$chariti->url_image}}" class="img-fluid">
                                                    @endif
                                                    {!! $chariti->content !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="modal fade edit{{$chariti->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h4 class="modal-title" id="myModalLabel">Edit Program Charity</h4>
                                                </div>
                                                <div class="modal-body">
                                                    {!! Form::open(['route'=>'admin.operational_charitis','method'=>'post','enctype'=>'multipart/form-data']) !!}
						                            <div class="form-group">
						                                <label for="title" class="">Judul</label>
						                                <input type="text" id="title" value="{!! $chariti->title !!}" name="title" class="form-control">
						                            </div>
						                            <div class="row">
						                                <div class="col-md-12">
						                                    <div class="file-field">
						                                        <div class="btn btn-default btn-sm">
						                                            <span>Edit Gambar</span>
						                                            <input type="file" name="file">
						                                        </div>
						                                    </div>
						                                </div>
						                            </div><br>

						                            <textarea id="content2" name="content2">{!! $chariti->content !!}</textarea>
						                            <button type="submit" class="btn btn-blue">Post</button>
						                            <input type="hidden" name="id_charity" value="{{$chariti->id}}">
						                            {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="3">Belum ada berita diposting.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div></div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>
    <script src="{{asset('/assets/js/public/sweetalert.min.js')}}"></script>
    <script>
        $(document).ready(function(){
             $(document.body).on('click', '.charities_close', function (event) {
                event.preventDefault();
                var $form = $(this).closest('form');
                var $el = $(this);
                var text = $el.data('confirm-message') ? $el.data('confirm-message') : 'Gagal coba'
                swal({
                        html: true,
                        title:text,
                        // title: "Apakah Anda yakin ingin menutup charity ini?",
                        text: "Apakah Anda yakin ingin menutup charity ini?",
                        showCancelButton: true,
                        confirmButtonColor: '#0c5484',
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Batal',
                        closeOnConfirm: true
                    },
                    function () {
                        // $('.password').val(inputValue);
                        $form.submit()
                    })
            });
        });
    </script>

    <script>
        $(document).ready(function(){
             $(document.body).on('click', '.charities_open', function (event) {
                event.preventDefault();
                var $form = $(this).closest('form');
                var $el = $(this);
                var text = $el.data('confirm-message') ? $el.data('confirm-message') : 'Gagal coba'
                swal({
                        html: true,
                        title: text,
                        // title: "Apakah Anda yakin ingin membuka charity?",
                        text: "Apakah Anda yakin ingin membuka charity?",
                        showCancelButton: true,
                        confirmButtonColor: '#0c5484',
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Batal',
                        closeOnConfirm: true
                    },
                    function () {
                        // $('.password').val(inputValue);
                        $form.submit()
                    })
            });
        });
    </script>
    <script>
        $('#content').summernote({
            height: 250,
            placeholder:'Informasi tambahan (Opsional)',
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['para', ['ol', 'paragraph']],
                ['insert', ['link']]
            ],
            popover: {
                air: [
                    ['font', ['bold', 'italic', 'underline']]
                ]
            }
        });
    </script>
@endsection
