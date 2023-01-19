<!DOCTYPE html>
<html class="load-full-screen">
<head>
    <meta name="_token" id="token" value="{{csrf_token()}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Smart In Pays">
    <meta name="author" content="sip">

    <title>SIP</title>

    @section('cs')
    <!-- STYLES -->
    <link href="{{asset('/assets/css/animate.min.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/css/bootstrap-select.min.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/css/owl.carousel.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/css/owl-carousel-theme.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/css/bootstrap.min.css')}}" rel="stylesheet" media="screen">
    <link href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css' rel='stylesheet' type='text/css'>

    <link href="{{asset('/assets/css/flexslider.css')}}" rel="stylesheet" media="screen">
    <link href="{{asset('/assets/css/style.css')}}" rel="stylesheet" media="screen">
    <link href="{{asset('/assets/css/select2.css')}}" rel="stylesheet" media="screen">
    <!-- LIGHT -->
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/color/blue.css')}}" id="select-style">
    <link href="{{asset('/assets/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">

    <link href="{{asset('/assets/css/light.css')}}" rel="stylesheet" media="screen">

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,800,700,600' rel='stylesheet' type='text/css'>

    <style>
        footer {
            bottom: 0;
            width: 100%;
        }
    </style>
    @show


</head>
<body class="load-full-screen">




<!-- BEGIN: SITE-WRAPPER -->
<div class="site-wrapper">
    <div class="row transparent-menu-top">
        <div class="container clear-padding">
            <div class="navbar-contact">
                <div class="col-md-7 col-sm-6 clear-padding">
                    <a href="#" class="transition-effect"><i class="fa fa-phone"></i> (021) 123456789</a>
                    <a href="#" class="transition-effect"><i class="fa fa-envelope-o"></i> support@sip.com</a>
                </div>
                <div class="col-md-5 col-sm-6 clear-padding search-box">
                    <div class="col-md-4 col-xs-3 clear-padding">
                    </div>
                    <div class="col-md-8 col-xs-9 clear-padding user-logged">
                        <a href="#" class="transition-effect">
                            <img src="{{asset('/assets/images/user.jpg')}}" alt="cruise">
                            Hi, {{$user->name}}
                        </a>
                        <a href="{{ url('/logout') }}" class="transition-effect" >
                            <i class="fa fa-sign-out"></i>Sign Out
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row light-menu">
        <div class="container clear-padding">
            <!-- BEGIN: HEADER -->
            <div class="navbar-wrapper">
                <div class="navbar navbar-default" role="navigation">
                    <!-- BEGIN: NAV-CONTAINER -->
                    <div class="nav-container">
                        <div class="navbar-header">
                            <!-- BEGIN: TOGGLE BUTTON (RESPONSIVE)-->
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>

                            <!-- BEGIN: LOGO -->
                            <img src="{{asset('/assets/logo/logotext-blue.png')}}" class="img-responsive" style="width:auto;height:50px;">
                        </div>

                        <!-- BEGIN: NAVIGATION -->
                        <div class="navbar-collapse collapse">
                            <ul class="nav navbar-nav navbar-right">
                                <li class="">
                                    <a class="" href="{{url('/')}}" ><i class="fa fa-home"></i> HOME </a>
                                </li>
                                <li class="dropdown">
                                    <a class="dropdown-toggle" href="#" data-toggle="dropdown"><i class="fa  fa-line-chart"></i> LAYANAN <i class="fa fa-caret-down"></i></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{route('airlines.index')}}"> Airlines </a></li>
                                        <li><a href="#"> Hotel </a></li>
                                        <li><a href="#"> Kereta Api </a></li>
                                        <li><a href="#"> PPOB </a></li>
                                        <li><a href="#"> Shuttle / Bus </a></li>
                                    </ul>
                                </li>
                                {{--<li class="dropdown mega">--}}
                                    {{--<a class="dropdown-toggle" href="#" data-toggle="dropdown"><i class="fa fa-bed"></i> LAYANAN <i class="fa fa-caret-down"></i></a>--}}
                                    {{--<ul class="dropdown-menu mega-menu">--}}
                                        {{--<li class="col-md-2 col-sm-4 links">--}}
                                            {{--<h5>AIRLINES</h5>--}}
                                            {{--<ul>--}}
                                                {{--<li><a href="hotel.html">Cek Jadwal</a></li>--}}
                                                {{--<li><a href="hotel-list.html">Data Transaksi</a></li>--}}
                                            {{--</ul>--}}
                                            {{--<h5 class="top-margin">Kereta Api</h5>--}}
                                            {{--<ul>--}}
                                                {{--<li><a href="#">Cek Jadwal</a></li>--}}
                                                {{--<li><a href="#">Data Transaksi</a></li>--}}
                                            {{--</ul>--}}
                                        {{--</li>--}}
                                        {{--<li class="col-md-2 col-sm-4 links">--}}
                                            {{--<h5>Shuttle / Bus</h5>--}}
                                            {{--<ul>--}}
                                                {{--<li><a href="#">Cek Jadwal</a></li>--}}
                                                {{--<li><a href="#">Data Transaksi</a></li>--}}
                                            {{--</ul>--}}
                                            {{--<h5 class="top-margin">Hotel</h5>--}}
                                            {{--<ul>--}}
                                                {{--<li><a href="#">Cari Hotel</a></li>--}}
                                                {{--<li><a href="#">Data Transaksi</a></li>--}}
                                            {{--</ul>--}}
                                        {{--</li>--}}
                                        {{--<li class="col-md-4 col-sm-4 links">--}}
                                            {{--<h5>PPOB</h5>--}}
                                            {{--<ul class="col-md-6">--}}
                                                {{--<li><a href="">BPJS Kesehatan</a></li>--}}
                                                {{--<li><a href="">Internet</a></li>--}}
                                                {{--<li><a href="">Multi Finance</a></li>--}}
                                                {{--<li><a href="">PLN Prabayar</a></li>--}}
                                                {{--<li><a href="">PLN Pascabayar</a></li>--}}
                                            {{--</ul>--}}
                                            {{--<ul class="col-md-6">--}}
                                                {{--<li><a href="">Pulsa Elektrik</a></li>--}}
                                                {{--<li><a href="">PDAM</a></li>--}}
                                                {{--<li><a href="">Telepon Pascabayar</a></li>--}}
                                                {{--<li><a href="">TV Berlangganan</a></li>--}}
                                                {{--<li><a href="">Data Transaksi</a></li>--}}
                                            {{--</ul>--}}
                                        {{--</li>--}}
                                        {{--<li class="col-md-4 col-sm-4 links">--}}
                                            {{--<h5>Kwitansi</h5>--}}
                                            {{--<ul class="col-md-6">--}}
                                                {{--<li><a href="">Pembuatan Kwitansi</a></li>--}}
                                                {{--<li><a href="">Daftar Kwitansi</a></li>--}}
                                            {{--</ul>--}}
                                        {{--</li>--}}
                                    {{--</ul>--}}
                                    {{--<div class="clearfix"></div>--}}
                                {{--</li>--}}
                                <li class="dropdown">
                                    <a class="dropdown-toggle" href="#" data-toggle="dropdown"><i class="fa fa-money"></i> KEUANGAN <i class="fa fa-caret-down"></i></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#"> Buku Saldo </a></li>
                                        <li><a href="#"> Transfer Saldo </a></li>
                                        <li><a href="#"> Topup </a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="dropdown-toggle" href="#" data-toggle="dropdown"><i class="fa  fa-line-chart"></i> STATISTIK <i class="fa fa-caret-down"></i></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{route('airlines.report')}}"> Laporan Airlines </a></li>
                                        <li><a href="#"> Laporan Kereta Api </a></li>
                                        <li><a href="#"> Laporan Shuttle / Bus </a></li>
                                        <li><a href="#"> Laporan Hotel </a></li>
                                        <li><a href="#"> Laporan PPOB </a></li>
                                        <li><a href="#"> Laporan Keseluruhan </a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="dropdown-toggle" href="#" data-toggle="dropdown"><i class="fa fa-headphones"></i> SUPPORT <i class="fa fa-caret-down"></i></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#"> Panduan Sistem </a></li>
                                        <li><a href="#"> Syarat dan Ketentuan </a></li>
                                        <li><a href="#"> Informasi Kontak </a></li>
                                        <li><a href="#"> Survey </a></li>
                                    </ul>
                                </li>
                                <li class="dropdown"><a><span class="alert alert-info"><i class="fa fa-money"></i> IDR <span id="deposit">{{number_format($user->deposit)}}</span> &nbsp; &nbsp;</span></a></li>
                            </ul>
                        </div>
                        <!-- END: NAVIGATION -->
                    </div>
                    <!--END: NAV-CONTAINER -->
                </div>
            </div>
            <!-- END: HEADER -->
            @include('flash::message')
        </div>
    </div>
@yield('search')
@yield('content')
    <?php
        /*
    <!--END: HOW IT WORK -->

    <!-- BEGIN: HOW IT WORK
    <section id="how-it-work">
            <div class="row work-row">
                <div class="container">
                    <div class="section-title text-center">
                        <h2>MENGAPA SIP MERUPAKAN PILIHAN PINTAR ANDA?</h2>
                    </div>
                    <div class="work-step">
                        <div class="col-md-4 col-sm-4 first-step text-center">
                            <i class="fa fa-search"></i>
                            <h5>TEKNOLOGI EFISIEN</h5>
                            <p>Lain dengan online travel agent pada umumnya, biaya operasional kami jauh lebih rendah berkat sistem online aman & mutakhir</p>
                        </div>
                        <div class="col-md-4 col-sm-4 second-step text-center">
                            <i class="fa fa-heart-o"></i>
                            <h5>HARGA JUJUR</h5>
                            <p>Harga di awal sudah final, gratis biaya transaksi dan tanpa biaya tersembunyi.</p>
                        </div>
                        <div class="col-md-4 col-sm-4 third-step text-center">
                            <i class="fa fa-shopping-cart"></i>
                            <h5>BEST PRICE GUARANTEE</h5>
                            <p>Jika menemukan harga lebih murah dari pemesanan Anda di Traveloka, klaim dan kami akan menggantinya.</p>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    END: HOW IT WORK -->
        */ ?>

    <!-- START: FOOTER -->
    <section id="footer">
        <footer>
<?php /*
		<div class="row main-footer-sub">
			<div class="container clear-padding">
				<div class="col-md-7 col-sm-7">
				</div>
				<div class="col-md-5 col-sm-5">
					<div class="social-media pull-right">
						<ul>
							<li><a href="#"><i class="fa fa-facebook"></i></a></li>
							<li><a href="#"><i class="fa fa-twitter"></i></a></li>
							<li><a href="#"><i class="fa fa-instagram"></i></a></li>
							<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							<li><a href="#"><i class="fa fa-youtube"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="main-footer row">
			<div class="container clear-padding">
				<div class="col-md-3 col-sm-6 about-box">
					<h3><img src="assets/logo/logotext-blue.png" class="img-responsive" style="width:auto;height:50px;"></h3>
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
				</div>
				<div class="col-md-3 col-sm-6 links">
					<h4>Popular Tours</h4>
					<ul>
						<li><a href="#">Romantic France</a></li>
						<li><a href="#">Wonderful Lodnon</a></li>
						<li><a href="#">Awesome Amsterdam</a></li>
						<li><a href="#">Wild Africa</a></li>
						<li><a href="#">Beach Goa</a></li>
						<li><a href="#">Casino Los Vages</a></li>
						<li><a href="#">Romantic France</a></li>
					</ul>
				</div>
				<div class="clearfix visible-sm-block"></div>
				<div class="col-md-3 col-sm-6 links">
					<h4>Our Services</h4>
					<ul>
						<li><a href="#">Domestic Flights</a></li>
						<li><a href="#">International Flights</a></li>
						<li><a href="#">Tours & Holidays</a></li>
						<li><a href="#">Domestic Hotels</a></li>
						<li><a href="#">International Hotels</a></li>
						<li><a href="#">Cruise Holidays</a></li>
						<li><a href="#">Car Rental</a></li>
					</ul>
				</div>
				<div class="col-md-3 col-sm-6 contact-box">
					<h4>Contact Us</h4>
					<p><i class="fa fa-home"></i> Street #156 Burbank, Studio City Hollywood, California USA</p>
					<p><i class="fa fa-phone"></i> +91 1234567890</p>
					<p><i class="fa fa-envelope-o"></i> support@domain.com</p>
				</div>
				<div class="clearfix"></div>
				<div class="col-md-12 text-center we-accept">
					<h4>We Accept</h4>
					<ul>
						<li><img src="assets/images/card/mastercard.png" alt="cruise"></li>
						<li><img src="assets/images/card/visa.png" alt="cruise"></li>
						<li><img src="assets/images/card/american-express.png" alt="cruise"></li>
						<li><img src="assets/images/card/mastercard.png" alt="cruise"></li>
					</ul>
				</div>
			</div>
		</div>
*/ ?>
            <div class="main-footer-nav row">
                <div class="container clear-padding">
                    <div class="col-md-6 col-sm-6">
                        <img src="{{asset('/assets/logo/logotext-blue.png')}}" class="img-responsive" style="width:auto;height:50px;">
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <?php /*<ul>
                            <li><a href="#">FLIGHTS</a></li>
                            <li><a href="#">TOURS</a></li>
                            <li><a href="#">CARS</a></li>
                            <li><a href="#">HOTELS</a></li>
                        </ul>
                        */ ?>
                    </div>
                </div>
            </div>
        </footer>
    </section>
    <!-- END: FOOTER -->
</div>
<!-- END: SITE-WRAPPER -->
<!-- Load Scripts -->
@section('js')
@include('footer')
<script src="{{asset('/assets/js/respond.js')}}"></script>
<script src="{{asset('/assets/js/jquery.js')}}"></script>
<script src="{{asset('/assets/plugins/owl.carousel.min.js')}}"></script>
<script src="{{asset('/assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('/assets/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('/assets/js/bootstrap-select.min.js')}}"></script>
<script src="{{asset('/assets/plugins/wow.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/assets/plugins/supersized.3.1.3.min.js')}}"></script>
<script src="{{asset('/assets/js/js.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<script src="/assets/js/vue.js"></script>
<script src="/assets/js/vue-resource.min.js"></script>
<script>
    $('#flash-overlay-modal').modal();
</script>
@show
</body>
</html>
