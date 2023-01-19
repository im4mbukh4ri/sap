@extends('layouts.public')
@section('css')
    @parent
    <link rel="stylesheet" href="{{asset('/assets/css/admin/summernote.css')}}">
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <form action="{{ route('admin.sip_contents_update',$content) }}" method="POST">
            {{csrf_field()}}
            <div class="form-group">
                <label for="title">Title</label>
                <input id="title" class="full-width" type="text" name="title" value="{{ $content->title }}">
            </div>
            <hr>
            <div class="form-group">
                <textarea id="summernote" name="value">{!! $content->content !!}</textarea>
            </div>
            <hr>
            <button type="submit" class="btn btn-orange">Simpan</button>
        </form>
    </div>
</div>
@endsection
@section('js')
    @parent
    <script src="{{asset('/assets/css/admin/summernote.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 300
            });
        });
    </script>
@endsection