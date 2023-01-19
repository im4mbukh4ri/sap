<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Homepage | SIP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"
          integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('/assets/css/style-login.css')}}">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="50">
@if(isset($message))
    <div class="alert alert-success alert-dismissible" role="alert" style="margin-bottom: 0;" id="notif">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        {!! $message !!}
    </div>
    <script>
        function detectLink() {
            if (navigator.userAgent.match(/Android/i)) {
                $("#linkAndroid").show();
                $("#linkIPhone").hide();
            } else if (navigator.userAgent.match(/iPhone/i)) {
                $("#linkAndroid").hide();
                $("#linkIPhone").hide();
            } else {
                $("#linkAndroid").hide();
                $("#linkiphone").hide();
            }
        }

        detectLink();
    </script>
@else
    <div class="alert alert-success alert-dismissible" role="alert" style="margin-bottom: 0;" id="notif">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        <p>Install aplikasi SIP sekarang. <a href="market://details?id=com.droid.sip"
                                             class="btn btn-primary">Install</a></p>
    </div>
    <script>
        $("#notif").hide();
    </script>
@endif
@include('flash::message')
<header id="header">
    <nav class="navbar navbar-default m-b-0 navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="javascript:void(0)">
                    <img src="{{asset('/assets/images/login/logo.png')}}" alt="SmartInpays" class="img-responsive">
                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#ns-hero">Home</a></li>
                    <li><a href="#ns-homepage-service">Service</a></li>
                    <li><a href="#ns-homepage-about">About Us</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="login">
                        <a href="#">Login
                            <span>
                        <img src="{{asset('/assets/images/login/log-in.png')}}" alt="login" class="icon-login">
                        </span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
    </nav>
</header>
@yield('content')

<footer id="footer" class="bg-dark pad-default homepage p-b-0">
    <div class="container">
        <div class="inner-section">
            <div class="row">
                <div class="col-sm-4">
                    <p class="text-uppercase text-white bold font-24">Our Company</p>
                    <p class="text-grey">Smart In Pays adalah sebuah perusahaan yang bergerak dalam bidang aplikasi /
                        platform penyedia layanan Digital Payment Business, dimana setiap membernya bisa melakukan
                        transaksi jual beli secara online.</p>
                </div>
                <div class="col-sm-4">
                    <p class="ns-subtitle text-white bold font-24">Layanan Pengaduan Konsumen</p>
                    <ul class="ns-list-contact">
                        <li class="text-grey">
                            <i class="fa fa-map-marker text-center"></i>
                            Direktorat Jenderal Perlindungan Konsumen dan Tertib Niaga
                        </li>
                        <li class="text-grey">
                            <i class="fa fa-phone text-center"></i>
                            021-3858171, 021-3451692
                        </li>
                        <li class="text-grey">
                            <i class="fa fa-fax text-center"></i>
                            021-3858205, 021-3842531
                        </li>
                        <li class="text-grey">
                            <i class="fa fa-envelope text-center"></i>
                            contact.us@kemendag.go.id
                        </li>
                    </ul>
                
                </div>
                <div class="col-sm-4">
                    <p class="ns-subtitle text-white bold font-24">Contact Us</p>
                    <ul class="ns-list-contact">
                        <li class="text-grey">
                            <i class="fa fa-map-marker text-center"></i>
                            PT. Prioritas Inti Sejahtera<br>
                            Greenlake City, Rukan Sentra Niaga Blok O No.2<br>
                            Duri Kosambi, Cengkareng<br>
                            Jakarta Barat
                        </li>
                        <li class="text-grey">
                            <i class="fa fa-phone text-center"></i>
                            021-54317931
                        </li>
                        <li class="text-grey">
                            <i class="fa fa-phone text-center"></i>
                            1500 107
                        </li>
                        <li class="text-grey">
                            <i class="fa fa-envelope text-center"></i>
                            info@smartinpays.net
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom bg-black font-15">
        <div class="container">
            <div class="row">
                <div class="col-sm-7">
                    <p class="text-light-grey">© 2018 SmartInPays. All rights reserved.</p>
                </div>
                <div class="col-sm-5">
                </div>
            </div>
        </div>
    </div>
</footer>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
<script src="{{asset('/assets/js/main-login.js')}}"></script>
<script>
    function detectMobile() {
        if (navigator.userAgent.match(/Android/i)) {
            $("#notif").show();
        } else {
            console.log('Bukan Android');
        }
    }

    $(document).ready(function () {
            detectMobile();
        }
    );
</script>
<script>$('#flash-overlay-modal').modal();</script>
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-96142964-1', 'auto');
    ga('send', 'pageview');

</script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
    (function () {
        var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/587f2c2a926a51336fe70d73/default';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
</script>
</html>