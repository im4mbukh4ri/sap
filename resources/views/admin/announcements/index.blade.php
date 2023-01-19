@extends('layouts.public')
@section('css')
    @parent
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
@endsection
@section('content')
    <section class="section-pilih-seat">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="blue-title-big">Posting Pengumuman / Berita</h3>
                            <hr>
                            {!! Form::open(['route'=>'admin.announcements_create','method'=>'post','enctype'=>'multipart/form-data']) !!}
                            <div class="form-group">
                                <label for="title" class="">Judul</label>
                                <input type="text" id="title" name="title" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="file-field">
                                        <div class="btn btn-default btn-sm">
                                            <span>Upload Gambar</span>
                                            <input type="file" name="picture">
                                        </div>
                                    </div>
                                </div>
                            </div><br>
                            <textarea id="content" name="content"></textarea>
                            <button type="submit" class="btn btn-blue">Post</button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h3 class="blue-title-big">List Pengumuman / Berita</h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th style="width:80%;">Judul</th>
                                    <th style="width:20%">Proses</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($announcements as $announcement)
                                    <tr>
                                        <td>{{$announcement->title}}</td>
                                        <td><a href="javascript:void(0)" data-toggle="modal" data-target=".announcement{{$announcement->id}}"> <i class="fa fa-search"></i></a>&nbsp;&nbsp;|<a href="{{route('admin.announcements_edit',$announcement)}}"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;|<a href="{{route('admin.announcements_destroy',$announcement)}}"><i class="fa fa-trash"></i></a></td>
                                    </tr>
                                    <div class="modal fade announcement{{$announcement->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h4 class="modal-title" id="myModalLabel">{{$announcement->title}}</h4>
                                                </div>
                                                <div class="modal-body">
                                                    @if($announcement->picture)
                                                        <img src="{{$announcement->picture->url}}" class="img-fluid">
                                                    @endif
                                                    {!! $announcement->content !!}
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
