<!doctype html>
<html>
<meta charset="UTF-8">
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{asset('/assets/css/public/bootstrap.css')}}">
<link href="{{asset('/assets/css/styles.css')}}" rel="stylesheet">
<body>
<div class="main">
    <div class="main-bg">
        <div class="main-overlay" style="background:#294963 url({{asset('/assets/images/material/img002-bg.jpg')}}) no-repeat center center;background-size:cover">
            <div></div>
        </div>
        <div class="slice-overlay"></div>
    </div>
    <div class="main-inner">
        <div class="main-container">
            <div class="header">
                <img src="{{asset('/assets/images/material/img001-logo-white.png')}}">
            </div>
            <div class="content">
                <div class="before-verified">
                    <h5 class="title">Verifikasi email dan no telepon Anda</h5>
                    <div class="form-box">
                        <div>
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                            <form method="GET" action="{{route('request_otp')}}">
                                {{csrf_field()}}
                                <p class="form-label"><span>No Telepon</span>:</p>
                                <div class="form-input">
                                    <h4><img src="{{asset('/assets/images/material/img003-phone.png')}}"></h4>
                                    <input name="no_telepon" id="input-no" type="text" value="{{old('no_telepon')}}" placeholder="081234567890">
                                </div>
                                <input class="btn-submit verifikasi" type="submit" value="Verifikasi">
                            </form>
                        </div>
                    </div>
                    <p>Pastikan Anda mengisi no telepon dan alamat email dengan benar, setelah ini proses verifikasi
                        <br>akan dikirimkan via OTP (One Time Password) pada sms Anda.</p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="{{asset('/assets/js/public/jquery-1.9.1.min.js')}}"></script>
<script src="{{asset('/assets/js/scripts.js')}}"></script>
</html>