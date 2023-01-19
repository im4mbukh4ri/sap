@extends('layouts.public')
@section('css')
    @parent
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
@endsection
@section('content')
    <section class="section-pilih-seat">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::open(['route'=>['admin.announcements_update',$announcement],'method'=>'post','enctype'=>'multipart/form-data']) !!}
                            <input type="hidden" name="file_name" value="{{$announcement->picture->file_name}}">
                            <div class="form-group">
                                <input type="text" id="title" name="title" class="form-control" value="{{$announcement->title}}">
                                <label for="title" class="">Judul</label>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="btn btn-default btn-sm">
                                            <span>Upload Gambar</span>
                                            <input type="file" name="picture">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <img class="img-responsive" src="{{$announcement->picture->url}}" style="display: block;margin: auto;">
                                </div>
                            </div>
                            <textarea id="content" name="content">{{$announcement->content}}</textarea>
                            <button type="submit" class="btn btn-primary">Update</button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Proses</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($announcements as $announcement)
                                    <tr>
                                        <td>{{$announcement->title}}</td>
                                        <td><a href="javascript:void(0)" data-toggle="modal" data-target=".announcement{{$announcement->id}}"> <i class="fa fa-search"></i></a> |<a href="{{route('admin.announcements_edit',$announcement)}}"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;| <i class="fa fa-trash"></i> </td>
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
                                                        <img src="{{$announcement->picture->url}}" class="img-responsive" style="display: block;margin: auto;">
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
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    @parent
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>
    <script>
        $('#content').summernote({
            height: 250,
            placeholder:'Informasi tambahan (Opsional)',
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['para', ['ol', 'paragraph']]
            ],
            popover: {
                air: [
                    ['font', ['bold', 'italic', 'underline']]
                ]
            }
        });
    </script>
@endsection