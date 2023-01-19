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
                            <h3 class="blue-title-big">QUESTIONNAIRE</h3>
                            <hr>
                            On progress
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h3 class="blue-title-big">List Questionnaire</h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th style="width:80%;">Judul</th>
                                    <th style="width:20%"><a class="btn btn-md btn-primary" href="{{route('admin.questionnaires_index')}}">ADD <i class="fa fa-plus"></i></a></th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($questionnaires as $questionnaire)
                                    <tr>
                                        <td>{{$questionnaire->title}}</td>
                                        <td class="text-center">
                                          <form action="{{ route('admin.questionnaires.status') }}" method="POST">
                                            <a href="{{url('admin/questionnaire').'/'.$questionnaire->id.('/result')}}"><i class="fa fa-search"></i></a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                            <a href="{{url('admin/questionnaire').'/'.$questionnaire->id.('/edit')}}" onclick="return false;"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                            {{ csrf_field() }}
                                            {{ Form::hidden('id', $questionnaire->id, ['class'=> 'questionnaire_id', 'id' => 'questionnaire_id']) }}
                                            {{ Form::hidden('title', $questionnaire->title , ['class'=> 'questionnaire_title', 'id' => 'questionnaire_title']) }}
                                            @if($questionnaire->status==0)
                                            {{ Form::hidden('status','1', ['class'=> 'status']) }}
                                            <a href="javascript:void(0)" data-confirm-message="{{$questionnaire->title}}" class="fa fa-close questionnaire_open_tutup"></a>
                                            @else
                                            {{ Form::hidden('status','0', ['class'=> 'status']) }}
                                            <a href="javascript:void(0)" data-confirm-message="{{$questionnaire->title}}" class="fa fa-check questionnaire_close_tutup"></a>
                                             @endif
                                          </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">Belum ada kuisioner diposting.</td>
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
             $(document.body).on('click', '.questionnaire_close', function (event) {
                event.preventDefault();
                var $form = $(this).closest('form');
                var $el = $(this);
                var text = $el.data('confirm-message') ? $el.data('confirm-message') : 'Gagal coba'
                swal({
                        html: true,
                        title:text,
                        text: "Apakah Anda yakin ingin menutup Questionnaire ini?",
                        showCancelButton: true,
                        confirmButtonColor: '#0c5484',
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Batal',
                        closeOnConfirm: true
                    },
                    function () {
                        $form.submit()
                    })
            });
        });
    </script>

    <script>
        $(document).ready(function(){
             $(document.body).on('click', '.questionnaire_open', function (event) {
                event.preventDefault();
                var $form = $(this).closest('form');
                var $el = $(this);
                var text = $el.data('confirm-message') ? $el.data('confirm-message') : 'Gagal coba'
                swal({
                        html: true,
                        title: text,
                        text: "Apakah Anda yakin ingin membuka Questionnaire ini?",
                        showCancelButton: true,
                        confirmButtonColor: '#0c5484',
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Batal',
                        closeOnConfirm: true
                    },
                    function () {
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
