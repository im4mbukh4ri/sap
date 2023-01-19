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
                <div class="after-verified">
                    <h5 class="title">Kami telah mengirimkan kode OTP ke {{$phoneNumber}}</h5>
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
                            <form method="POST" action="{{url('/login')}}">
                                {{csrf_field()}}
                                <p class="form-label"><span>Masukkan kode OTP</span>:</p>
                                <div class="form-input">
                                    <input type="hidden" name="phone_number" value="{{$phoneNumber}}">
                                    <input id="input-otp" name="password" value="{{old('password')}}" type="number">
                                </div>
                                <p class="form-label"><img src="{{asset('/assets/images/material/img005-resend.png')}}">Kirim ulang kode OTP setelah <span class="timer">07:00</span></p>
                                <input class="btn-submit verifikasi" type="submit" value="LOGIN">
                            </form>
                            <form method="POST" action="{{route('login.otp')}}">
                                {{csrf_field()}}
                                <input type="hidden" name="phone_number" value="{{$phoneNumber}}">
                            <input class="btn-submit resend" type="submit" value="Resend">
                            </form>
                        </div>
                    </div>
                    <p>Setelah Anda menerima SMS kode OTP, masukkan kode OTP Anda pada form pengisian di atas.</p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="{{asset('/assets/js/public/jquery-1.9.1.min.js')}}"></script>
<script src="{{asset('/assets/js/scripts.js')}}"></script>
<script>
    $sec=420
    $timer=setInterval(function(){startTimer()},1000)

    $('body').on('click','.btn-submit.resend',function(){
        $(".timer").html("07:00");
        $sec=420
        $timer=setInterval(function(){startTimer()},1000)
        $('.btn-submit.verifikasi').show()
        $('.btn-submit.resend').hide()
    })

    function startTimer(){
        var minutes=Math.floor($sec/60)
        var seconds=Math.floor($sec%60)

        minutes=minutes<10?"0"+minutes:minutes
        seconds=seconds<10?"0"+seconds:seconds

        $(".timer").html(minutes+":"+seconds)
        $sec--

        if($sec<0){
            clearInterval($timer)
            $('.btn-submit.verifikasi').hide()
            $('.btn-submit.resend').show()
        }
    }
</script>
</html>