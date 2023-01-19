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
                    <h3 class="blue-title-big">Data Member</h3>
                    <div id="dataSearch" class="box-orange">
                        <form action="{{route('admin.users_index')}}" method="GET">
                            {{csrf_field()}}
                            <div class="row-form">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="whiteFont" for="q">Username / Email</label>
                                            <input type="text" name="q" class="form-control" value="{{ old('q') }}" id="q">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="whiteFont" for="type">Tipe</label>
                                            <select name="type" class="form-control" id="type">
                                                <option value="0" <?=(old('type')==0)?'selected':'' ?>>ALL</option>
                                                <option value="2" <?=(old('type')==2)?'selected':'' ?>>Basic</option>
                                                <option value="3" <?=(old('type')==3)?'selected':'' ?>>Advance</option>
                                                <option value="4" <?=(old('type')==4)?'selected':'' ?>>Pro</option>
                                                <option value="5" <?=(old('type')==5)?'selected':'' ?>>Free</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <br>
                                        <button type="submit" class="btn btn-cari">
                                            <span class="glyphicon glyphicon-search"></span> Cari Data</button>
                                    </div><!--end.col-md-4-->
                                </div><!--end.row-->
                            </div><!--end.row-form-->
                        </form>
                    </div>
                    <div>
                      <strong>Total data : {{$total}}</strong>
                    </div>
                    <div class="table-responsive dataTable">
                        <table class="table table-striped table-bordered dt-responsive nowrap table-custom-blue">
                            <thead>
                            <tr>
                                <th style="width: 5%;">Username</th>
                                <th style="width: 10%;">Data Agen</th>
                                <th style="width: 20%;">Alamat</th>
                                <th style="width: 15%;">Register</th>
                                <th style="width: 15%;">Last Login</th>
                                <th style="width: 10%;">Deposit</th>
                                <th style="width: 10%;">Status</th>
                                @if(Auth::user()->role == 'acc') @else <th style="width: 15%;">Proses</th>@endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $key => $user)
                            <tr>
                                <td>{{ $user->username }}<br><br><strong>Upline : </strong><br>{{ $user->parent->username }}</td>
                                <td>{{ $user->name }}<br>{{ ($user->phone_number)?$user->phone_number: 'Unverified' }}<br>{{ $user->email }}</td>
                                <td>{{ $user->address->detail }}<br>
                                    @if($user->address->subdistrict)
                                        {{ $user->address->subdistrict->name }},
                                        {{ $user->address->subdistrict->city->name }}<br>
                                        {{ $user->address->subdistrict->city->province->name }}
                                    @endif
                                </td>
                                <td>{{ date("d-M-y H:i",strtotime($user->created_at)) }}</td>
                                <td>{{ date("d-M-y H:i",strtotime($user->updated_at)) }}</td>
                                <td>IDR {{ number_format($user->deposit) }}</td>
                                <td>{{ $user->status_active }}</td>
                                @if(Auth::user()->role == 'acc') @else <td><a href="{{ route('admin.users_show',$user) }}" class="btn btn-xs btn-blue"><i class="fa fa-edit"></i></a>
                                  @if( $user->actived == 1)
                                    <a href="{{ route('admin.users_lock',$user) }}" class="btn btn-xs btn-warning js-submit-confirm" data-confirm-message="Lock member dipilih?"><i class="fa fa-lock"></i></a>
                                  @else
                                    <a href="{{ route('admin.users_unlock',$user) }}" class="btn btn-xs btn-success js-submit-confirm" data-confirm-message="Unlock member dipilih?"><i class="fa fa-key"></i></a>
                                  @endif
                                </td>@endif
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $users->appends(compact('_token','q','type'))->links() !!}
                    </div>
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
                var href =$(this).attr('href');
                var $el = $(this);
                var text = $el.data('confirm-message') ? $el.data('confirm-message') : 'Anda tidak bisa membatalkan proses ini!';
                swal({
                        title: 'Perhatian',
                        text: text,
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#0c5484',
                        confirmButtonText: 'Ya!',
                        cancelButtonText: 'Batal',
                        closeOnConfirm: true
                    },
                    function () {
                        window.location.href=href;
                    })
            });
        });
    </script>
@endsection
