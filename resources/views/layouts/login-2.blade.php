<!DOCTYPE html>
<html class="full-screen">
<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="LimpidThemes">

    <title>Login | SIP</title>

    <!-- Styles -->
    <link href="{{asset('/assets/css/animate.min.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/css/bootstrap.min.css')}}" rel="stylesheet" media="screen">
    <link href="{{asset('/assets/css/style.css')}}" rel="stylesheet" media="screen">
    <link href="{{asset('/assets/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">

    <link href="{{asset('/assets/css/light.css')}}" rel="stylesheet" media="screen">
    <link href='https://fonts.googleapis.com/css?family=Raleway:400,600,700,900' rel='stylesheet' type='text/css'>

    <script src="{{asset('/assets/js/respond.js')}}"></script>
    <script src="{{asset('/assets/js/jquery.js')}}"></script>
</head>
<body class="full-screen" >
@if(isset($message))
    <div class="alert alert-success alert-dismissible" role="alert" style="margin-bottom: 0;" id="notif">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {!! $message !!}
    </div>
    <script>
        function detectLink() {
            if(navigator.userAgent.match(/Android/i)){
                $("#linkAndroid").show();
                $("#linkIPhone").hide();
            }else if(navigator.userAgent.match(/iPhone/i)){
                $("#linkAndroid").hide();
                $("#linkIPhone").hide();
            }else{
                $("#linkAndroid").hide();
                $("#linkiphone").hide();
            }
        }
        detectLink();
    </script>
@else
    <div class="alert alert-success alert-dismissible" role="alert" style="margin-bottom: 0;" id="notif">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <p>Install aplikasi SIP sekarang. <a href="market://details?id=com.droid.sip" class="btn btn-primary">Install</a></p>
    </div>
    <script>
        $("#notif").hide();
    </script>
@endif
@include('flash::message')
@yield('content')
<!-- Load Scripts -->
<script src="{{asset('/assets/plugins/jquery.plugin.min.js')}}"></script>
<script src="{{asset('/assets/plugins/jquery.countdown.min.js')}}"></script>
<script src="{{asset('/assets/plugins/wow.min.js')}}"></script>
<script src="{{asset('/assets/js/bootstrap.min.js')}}"></script>
<script>
    function detectMobile() {
        if(navigator.userAgent.match(/Android/i)){
            $("#notif").show();
        }else{
            console.log('Bukan Android');
        }
    }
    $(document).ready(function () {
        detectMobile();
        }
    );
</script>
<script>$('#flash-overlay-modal').modal();</script>
</body>
</html>