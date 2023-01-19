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
                            <h3 class="blue-title-big">Buat Admin Baru</h3>
                            <hr>
                            <form action="{{route('admin.postadministrator')}}" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                     <div class="form-group">
                                    <label for="title" class="">Nama</label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control">
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                     <div class="form-group">
                                    <label for="title" class="">Username</label>
                                    <input type="text" id="username" name="username" value="{{ old('username') }}" class="form-control">
                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label>Jenis Kelamin</label><br>
                                        <div class="col-md-6">
                                            <label class="radio-inline">
                                                <input type="radio" id="byDate" name="gender" checked class="show_hide" value="L">Laki - Laki
                                            </label>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="radio-inline">
                                                <input type="radio" name="gender" id="byPnr" class="show_hide" value="P"> Perempuan
                                            </label>
                                        </div>
                                        @if ($errors->has('gender'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('gender') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title" class="">Tanggal Lahir</label>
                                        <input type="text" id="datepicker1" name="birth_date" value="{{ old('birth_date') }}" class="form-control">
                                        @if ($errors->has('birth_date'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('birth_date') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title" class="">Level</label>
                                        <select name="role" class="form-control">
                                            <option value="admin">Admin</option>
                                            <option value="acc">Accouinting</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title" class="">No Telpon</label>
                                        <input type="number" id="member_phone" name="member_phone" value="{{ old('member_phone') }}" class="form-control">
                                        @if ($errors->has('member_phone'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('member_phone') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                     <div class="form-group">
                                        <label for="title" class="">Email</label>
                                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control">
                                        @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                     <div class="form-group">
                                        <label for="title" class="">Password</label>
                                        <input type="password" id="password" name="password" value="{{ old('password') }}" class="form-control">
                                        @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-blue ">SIMPAN</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h3 class="blue-title-big">List Admin</h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive dataTable">
                                <table class="table table-striped nowrap table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="text-align: left;">No</th>
                                            <th style="text-align: left;">Nama</th>
                                            <th style="text-align: left;">Username</th>
                                            <th style="text-align: left;">Level</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $no = 1;?>
                                    @foreach($administrators as $administrator)
                                        <tr>
                                            <td>{{ $no++ }}.</td>
                                            <td>{{ ucwords($administrator->name) }}</td>
                                            <td>{{ $administrator->username }}</td>
                                            <td>@if($administrator->role =='acc') Accounting @else {{ ucwords($administrator->role) }} @endif</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
    <script>
        $(document).ready(function () {
            $("#datepicker1").datepicker({
                maxDate: new Date(),
                dateFormat:'dd-mm-yy'
            });
        });
    </script>
@endsection
