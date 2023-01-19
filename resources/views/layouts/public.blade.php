<?php $user = auth()->user();?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->
<head>
    <meta name="_token" id="token" value="{{csrf_token()}}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIP</title>
    <meta name="description" content="">
    <link rel="shortcut icon" href="https://www.smartinpays.com/favicon.png" type="image/x-icon"/>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--Style-->
    @section('css')

    <link rel="stylesheet" href="{{asset('/assets/css/public/reset.css')}}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css">
    <link rel="stylesheet" href="{{asset('/assets/css/public/jquery-ui.css')}}"/>
    <link rel="stylesheet" href="{{asset('/assets/css/public/select2.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('/assets/css/public/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/css/public/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/public/media1024.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/public/media768.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/public/media480.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/public/media320.css')}}"/>
    <link rel="stylesheet" href="{{asset('/assets/css/public/jquery.bxslider.css')}}">
    @show
    <!--link rel="stylesheet" href="css/style-temp.css"-->
    <!--js-->
        <script src="{{asset('/assets/js/public/jquery-1.9.1.min.js')}}"></script>
        <script>window.jQuery || document.write('<script src="{{asset('/assets/js/public/jquery-1.9.1.min.js')}}"><\/script>')</script>
        <script src="{{asset('/assets/js/public/modernizr-2.6.2.min.js')}}"></script>
        <script src="{{asset('/assets/js/public/SmoothScroll.js')}}"></script>
        <script src="{{asset('/assets/js/public/jquery-ui.min.js')}}"></script>
        <script src="{{asset('/assets/js/public/select2.full.min.js')}}"></script>
        <script src="{{asset('/assets/js/public/bootstrap.min.js')}}"></script>
        <script src="{{asset('/assets/js/public/jquery.bxslider.js')}}"></script>
        <script src="{{asset('/assets/js/public/js_lib.js')}}"></script>
        <script src="{{asset('/assets/js/public/js_run.js')}}"></script>
</head>
<body>
<!--[if lt IE 7]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
<![endif]-->
<!-- header -->
<header id="mainheader">
    <nav class="navbar navbar-default navbar-bootsnipp ">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand logo" href="{{ url('/') }}"><img width="90" src="{{asset('assets/images/material/sip-logo.png')}}"></a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul id="main-menu" class="nav navbar-nav">
                    @can('admin-access')
                        <li class="{{setActive(['index','home'])}}"><a href="{{ url('/') }}">Home</a></li>
                        <li class="hasChild {{setActive(['admin.users_index','admin.deposits_ticket'])}}">
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"> Membership <b class="caret"></b> </a>
                            <ul class="dropdown-menu">
                                <li class="{{ setActive('admin.users_index') }}"><a href="{{ route('admin.users_index') }}">Data Member</a></li>
                                <li><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" > Free User <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('admin.users_unverified') }}">List Free User Unverified</a></li>
                                        <li><a href="{{ route('admin.users_pasif') }}">List Free User Pasif</a></li>
                                        <li><a href="{{ route('admin.users_aktif') }}">List Free User Aktif</a></li>
                                        <li><a href="{{ route('admin.free_users') }}">Total Free User</a></li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" >Deposit Member <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('admin.deposits_index') }}">Manual Deposit</a></li>
                                        <li><a href="{{ route('admin.report_manual_deposit') }}">Report Manual Deposit</a></li>
                                        <li><a href="{{ route('admin.deposits_ticket') }}">Konfirmasi Deposit</a></li>
                                        <li><a href="{{ route('admin.deposits_histories') }}">Buku Saldo</a></li>
                                        <li><a href="{{ route('admin.deposits_total') }}">Total Deposit</a></li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" >Point Member <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('admin.point_histories') }}">History Point</a></li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" >Transaksi Member <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('admin.transactions_airlines') }}">Transaksi Airlines</a></li>
                                        <li><a href="{{ route('admin.transactions_train') }}">Transaksi Kereta Api</a></li>
                                        <li><a href="{{ route('admin.transactions_railink') }}">Transaksi Railink</a></li>
                                        <li><a href="{{ route('admin.transactions_pulsa') }}">Transaksi Pulsa</a></li>
                                        <li><a href="{{ route('admin.transactions_ppob') }}">Transaksi PPOB</a></li>
                                        <li><a href="{{ route('admin.transactions_hotel') }}">Transaksi Hotel</a></li>
                                        <li><a href="{{ route('admin.transactions_reset_password')}}">Transaksi Reset Password</a></li>
                                        <li><a href="{{ route('admin.transactions_transfer_deposit')}}">Transaksi Transfer Deposit</a></li>
                                        <li><a href="{{ route('admin.transactions_charity')}}">Transaksi Charity</a></li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" >Summary Member <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('admin.operational_summaries_airlines') }}">Summary Airlines</a></li>
                                        <li><a href="{{ route('admin.operational_summaries_train') }}">Summary Kereta Api</a></li>
                                        <li><a href="{{ route('admin.operational_summaries_railink') }}">Summary Railink</a></li>
                                        <li><a href="{{ route('admin.operational_summaries_pulsa') }}">Summary Pulsa</a></li>
                                        <li><a href="{{ route('admin.operational_summaries_ppob') }}">Summary PPOB</a></li>
                                        <li><a href="{{ route('admin.operational_summaries_hotel') }}">Summary Hotel</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="hasChild {{setActive(['admin.banner_index'])}}">
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"> Statistik <b class="caret"></b> </a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('admin.statistics_airlines') }}" >Statistik Airlines</a></li>
                                <li><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" >Statistik Pulsa <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('admin.statistics_pulsa_operator') }}">Per Operator</a></li>
                                        <li><a href="{{ route('admin.statistics_pulsa') }}">Semua Operator</a></li>
                                    </ul>
                                </li>
                                <li><a href="{{ route('admin.statistics_ppob') }}">Statistik PPOB</a> </li>
                                <li><a href="{{ route('admin.statistics_point_reward') }}">Statistik Point Reward</a> </li>
                                <li><a href="{{ route('admin.questionnaires_index') }}">Statistik Kuisoner</a> </li>
                            </ul>
                        </li>

                        <li class="hasChild {{setActive(['admin.banner_index'])}}">
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"> Settings <b class="caret"></b> </a>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" >Mobile Apps <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('admin.banners_index') }}">Banner Mobile</a></li>
                                    </ul>
                                </li>
                                <li><a href="{{ route('admin.announcements_index') }}"> Berita</a> </li>
                                @if($user->username == 'mastersip')
                                <li><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" >Pulsa <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('admin.settings_price_pulsa') }}">Harga Pulsa</a></li>
                                    </ul>
                                </li>
                                <li><a href="{{ route('admin.settings_point') }}"> Point & Deposit</a> </li>
                                <li><a href="{{ route('admin.sip_contents') }}"> Content</a> </li>
                                <li><a href="{{ route('admin.administrator') }}"> Administrator</a> </li>
                                @endif
                            </ul>
                        </li>
                        <li class="hasChild {{setActive(['admin.banner_index'])}}">
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"> Operasional <b class="caret"></b> </a>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" >Monitoring <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('admin.operational_airlines_monitoring_pass') }}"> Monitoring Airlines</a> </li>
                                        <li><a href="{{ route('admin.pulsa_monitorings') }}"> Monitoring Pulsa</a> </li>
                                        <li><a href="{{ route('admin.ppob_monitorings') }}"> Monitoring PPOB</a> </li>
                                        <li><a href="{{ route('admin.deposits_monitorings') }}"> Monitoring Deposit</a> </li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" >Pulsa & PPOB <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('admin.transactions_pulsa_status') }}"> Cek Status Pulsa & PPOB</a> </li>
                                    </ul>
                                </li>
                                @if($user->role == 'admin')
                                <li><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" >Charity <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('admin.operational_charitis')}}"> Program Charity</a> </li>
                                        <li><a href="{{ route('admin.operational_charity.saldo')}}"> Saldo Charity</a> </li>
                                    </ul>
                                </li>
                                @endif
                            </ul>
                        </li>
                    @elsecan('acc-access')
                    <li class="{{setActive(['index','home'])}}"><a href="{{ url('/') }}">Home</a></li>
                        <li class="hasChild {{setActive(['admin.users_index','admin.deposits_ticket'])}}">
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"> Membership <b class="caret"></b> </a>
                            <ul class="dropdown-menu">
                                <li class="{{ setActive('admin.users_index') }}"><a href="{{ route('admin.users_index') }}">Data Member</a></li>
                                <li><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" >Deposit Member <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('admin.deposits_index') }}">Manual Deposit</a></li>
                                        <li><a href="{{ route('admin.deposits_ticket') }}">Konfirmasi Deposit</a></li>
                                        <li><a href="{{ route('admin.deposits_histories') }}">Buku Saldo</a></li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" >Point Member <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('admin.point_histories') }}">History Point</a></li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" >Transaksi Member <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('admin.transactions_airlines') }}">Transaksi Airlines</a></li>
                                        <li><a href="{{ route('admin.transactions_train') }}">Transaksi Kereta Api</a></li>
                                        <li><a href="{{ route('admin.transactions_railink') }}">Transaksi Railink</a></li>
                                        <li><a href="{{ route('admin.transactions_pulsa') }}">Transaksi Pulsa</a></li>
                                        <li><a href="{{ route('admin.transactions_ppob') }}">Transaksi PPOB</a></li>
                                        <li><a href="{{ route('admin.transactions_hotel') }}">Transaksi Hotel</a></li>
                                        <li><a href="{{ route('admin.transactions_reset_password')}}">Transaksi Reset Password</a></li>
                                        <li><a href="{{ route('admin.transactions_transfer_deposit')}}">Transaksi Transfer Deposit</a></li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" >Summary Member <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('admin.operational_summaries_airlines') }}">Summary Airlines</a></li>
                                        <li><a href="{{ route('admin.operational_summaries_train') }}">Summary Kereta Api</a></li>
                                        <li><a href="{{ route('admin.operational_summaries_railink') }}">Summary Railink</a></li>
                                        <li><a href="{{ route('admin.operational_summaries_pulsa') }}">Summary Pulsa</a></li>
                                        <li><a href="{{ route('admin.operational_summaries_ppob') }}">Summary PPOB</a></li>
                                        <li><a href="{{ route('admin.operational_summaries_hotel') }}">Summary Hotel</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="hasChild {{setActive(['admin.banner_index'])}}">
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"> Settings <b class="caret"></b> </a>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" >Mobile Apps <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('admin.banners_index') }}">Banner Mobile</a></li>
                                    </ul>
                                </li>
                                @if(auth()->user()->id == 1)
                                <li><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" >Pulsa <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('admin.settings_price_pulsa') }}">Harga Pulsa</a></li>
                                    </ul>
                                </li>

                                <li><a href="{{ route('admin.settings_point') }}"> Point Reward</a> </li>
                                <li><a href="{{ route('admin.administrator') }}"> Administrator</a> </li>
                                @endif
                                <li><a href="{{ route('admin.announcements_index') }}"> Berita</a> </li>

                            </ul>
                        </li>
                        <li class="hasChild {{setActive(['admin.banner_index'])}}">
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"> Operasional <b class="caret"></b> </a>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" >Airlines <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('admin.operational_airlines_monitoring_pass') }}"> Monitoring Passenger</a> </li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" >Pulsa <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('admin.transactions_pulsa_status') }}"> Cek Status</a> </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="{{setActive(['index','home'])}}"><a href="{{ url('/') }}">Home</a></li>
                        <li class="hasChild {{setActive(['airlines.reports','ppob.reports'])}}">
                            <a href="javascript:void(0)" class="dropdown-toggle " data-toggle="dropdown">Layanan <b class="caret"></b> </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">Airlines <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ url('/?services=airlines') }}">Cek Jadwal</a></li>
                                        <li><a href="{{ route('airlines.reports') }}">Data Transaksi</a></li>
                                        <li><a href="{{ route('airlines.checkin') }}">Online Check in</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">Kereta Api <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ url('/?services=train') }}">Cek Jadwal</a></li>
                                        <li><a href="{{ route('trains.reports') }}">Data Transaksi</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">Railink <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ url('/?services=railink') }}">Cek Jadwal</a></li>
                                        <li><a href="{{ route('railinks.reports') }}">Data Transaksi</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">Hotel <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ url('/?services=hotel') }}">Cari Hotel</a></li>
                                        <li><a href="{{ route('hotels.reports') }}">Data Transaksi</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">Pulsa <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ url('/?services=pulsa') }}">Transaksi Pulsa</a></li>
                                        <li><a href="{{ route('pulsa.reports') }}">Data Transaksi</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">PPOB <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ url('/?services=ppob') }}">Transaksi PPOB</a></li>
                                        <li><a href="{{ route('ppob.reports') }}">Data Transaksi</a></li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">Smart Pays <b class="caret"></b></a>
                                  <ul class="dropdown-menu">
                                      <li><a href="{{route('autodebit.index')}}">Daftar Autodebet</a></li>
                                      <li><a href="{{ route('number_saveds.index') }}">Nomor Tersimpan</a></li>
                                  </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="{{setActive(['deposits.histories','deposits.tickets','deposits.ticket_histories'])}}">
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"> Keuangan <b class="caret"></b> </a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('deposits.histories') }}" >Buku Saldo</a></li>
                                <li><a href="{{ route('deposits.tickets') }}" >Tiket Deposit</a></li>
                                <li><a href="{{ route('deposits.ticket_histories') }}" >Data Topup</a></li>
                                <li><a href="{{ route('deposits.transfer_index') }}" >Transfer Deposit</a></li>
                                <li><a href="{{ route('points.histories') }}" >Point Reward</a></li>
                                <li><a href="{{ route('bonus.transaksi') }}" >Bonus Transaksi</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">Charity <b class="caret"></b> </a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('charities.index') }}" >Program Charity</a></li>
                                <li><a href="{{ route('charities.report') }}" >Data Charity</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">Support <b class="caret"></b> </a>
                            <ul class="dropdown-menu">
                                {{--<li><a href="{{route('sip.news')}}" >Informasi</a></li>--}}
                                {{--<li><a href="javascript:void(0)" >Panduan Sistem</a></li>--}}
                                <li><a href="{{ route('sip.term') }}" >Syarat dan Ketentuan</a></li>
                                {{--<li><a href="javascript:void(0)" >Informasi Kontak</a></li>--}}
                                <li><a href="{{ route('sip.faq') }}" >FAQ</a></li>
                            </ul>
                        </li>
                        <li><a href="{{route('sip.news')}}">News </a></li>
                    @endcan
                </ul>
                <ul id="menu-profile" class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <div class="info-detail">
                                <p>Selamat datang,</p>
                                <p>{{ $user->name }}</p>
                                <p><strong> IDR {{number_format($user->deposit)}}</strong></p>
                            </div>
                            <div class="thumb-menu-profile">
                                <?php
                                $photo = $user->photo()->first();
                                ?>
                                <img src="{{ asset( (isset($photo))?$photo->url_photo:'/assets/images/material/default_avatar.jpg') }}">
                            </div>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('profiles.index') }}">Info</a></li>
                            <li><a href="{{ url('/logout') }}">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
</header>
<!-- end of header -->
@include('flash::message')
<div id="middle-content" class="homepage">
@yield('content')
</div>

<!--Footer -->
<footer id="footer" style="height:39px;position:fixed; bottom: 0 ;width:100%;">
    <p>@2017 PT. SUKSES INTEGRITAS PERKASA All Right Reserved</p>
</footer>
<!--end of Footer -->
@include('footer')
@section('js')
    <script src="{{asset('/assets/js/vue.js')}}"></script>
    <script src="{{asset('/assets/js/vue-resource.min.js')}}"></script>
    <script src="{{asset('/assets/js/public/my-js.js')}}"></script>
    <script>$('#flash-overlay-modal').modal();</script>
@show
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-96142964-1', 'auto');
    ga('send', 'pageview');

</script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/587f2c2a926a51336fe70d73/default';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
</script>
<!--End of Tawk.to Script-->
</body>
</html>
