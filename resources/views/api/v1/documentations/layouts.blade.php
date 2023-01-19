<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="_token" id="token" value="{{csrf_token()}}">
    <title>API Documentations | SIP</title>
    @section('css')
        <script src="https://use.fontawesome.com/f90854d6b2.js"></script>
        <!-- Bootstrap -->
        <link href="{{asset('/assets/css/admin/bootstrap.min.css')}}" rel="stylesheet">
        <!-- End Bootstrap -->
        <!-- MDB -->
        <link href="{{asset('/assets/css/admin/mdb-pro.min.css')}}" rel="stylesheet">
        <!-- End MDB -->
    @show
</head>
<body class="fixed-sn mdb-skin">

<header>
    <ul id="slide-out" class="side-nav fixed custom-scrollbar">
        <li>
            <div class="logo-wrapper waves-light">
                <a href="{{route('api.documentations_index')}}"><img src="{{asset('/assets/logo/logotext-blue.png')}}" class="img-fluid flex-center"></a>
            </div>
        </li>
        <li>
            <ul class="collapsible collapsible-accordion">
                <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-key"></i>GET TOKEN<i class="fa fa-angle-down rotate-icon"></i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="#getToken" class="waves-effect">GET TOKEN</a></li>
                        </ul>
                    </div>
                </li>
                <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-user"></i> MEMBERSHIP<i class="fa fa-angle-down rotate-icon"></i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="#registrasiMemberFree" class="waves-effect">REGISTRASI MEMBER FREE</a></li>
                            <li><a href="#resetPassword" class="waves-effect">RESET PASSWORD</a></li>
                            <li><a href="#changePassword" class="waves-effect">GANTI PASSWORD</a></li>
                            <li><a href="#uploadPhoto" class="waves-effect">UPLOAD FOTO MEMBER</a></li>
                        </ul>
                    </div>
                </li>
                <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-map-marker"></i> LOCATIONS<i class="fa fa-angle-down rotate-icon"></i></a>
                    <div class="collapsible-body">
                        <ul>
                            {{-- <li><a href="#configLoc" class="waves-effect">GET CONFIG LOCATION</a></li> --}}
                            <li><a href="#getMemberPro" class="waves-effect">GET MEMBER PRO</a></li>
                            <li><a href="#updateConfLoc" class="waves-effect">UPDATE KONFIGURASI LOCATION</a></li>
                        </ul>
                    </div>
                </li>
                <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-lock"></i>LOGIN, GET AKSES<i class="fa fa-angle-down rotate-icon"></i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="#login" class="waves-effect">LOGIN</a></li>
                            <li><a href="#access" class="waves-effect">GET AKSES</a> </li>
                        </ul>
                    </div>
                </li>
                <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-plane"></i> AIRLINES<i class="fa fa-angle-down rotate-icon"></i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="#getSchedule" class="waves-effect">GET SCHEDULE</a></li>
                            <li><a href="#getScheduleClass" class="waves-effect">GET SCHEDULE CLASS</a></li>
                            <li><a href="#getFare" class="waves-effect">GET FARE</a> </li>
                            <li><a href="#booking" class="waves-effect">BOOKING</a></li>
                            <li><a href="#cancelBooking" class="waves-effect">CANCEL BOOKING</a></li>
                            <li><a href="#issued" class="waves-effect">ISSUED</a></li>
                            <li><a href="#bookingIssued" class="waves-effect">BOOKING ISSUED</a> </li>
                            <li><a href="#airlinesReport" class="waves-effect">REPORTS</a></li>
                            <li><a href="#airlinesReportDetail" class="waves-effect">REPORT DETAIL</a> </li>
                        </ul>
                    </div>
                </li>
                <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-train"></i> KERETA API<i class="fa fa-angle-down rotate-icon"></i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="#trainGetSchedule" class="waves-effect">GET SCHEDULE</a></li>
                            <li><a href="#trainGetSeat" class="waves-effect">GET SEAT</a></li>
                            <li><a href="#trainBookingIssued" class="waves-effect">BOOKING ISSUED</a></li>
                            <li><a href="#trainReport" class="waves-effect">REPORT</a></li>
                        </ul>
                    </div>
                </li>
                <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-building"></i> HOTEL<i class="fa fa-angle-down rotate-icon"></i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="#listCities" class="waves-effect">LIST KOTA</a></li>
                            <li><a href="#hotelSearch" class="waves-effect">SEARCH HOTEL</a></li>
                            <li><a href="#hotelNext" class="waves-effect">SEARCH HOTEL NEXT</a></li>
                            <li><a href="#hotelKeyword" class="waves-effect">SEARCH HOTEL KEYWORD</a></li>
                            <li><a href="#hotelSort" class="waves-effect">SEARCH HOTEL SORT</a></li>
                            <li><a href="#hotelDetail" class="waves-effect">HOTEL DETAIL</a></li>
                            <li><a href="#hotelBookingIssued" class="waves-effect">BOOKING ISSUED HOTEL</a></li>
                            <li><a href="#reportHotel" class="waves-effect">REPORT HOTEL</a></li>
                        </ul>
                    </div>
                </li>
                <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-money"></i> DEPOSIT<i class="fa fa-angle-down rotate-icon"></i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="#cekSaldo" class="waves-effect">CEK SALDO</a></li>
                            <li><a href="#listBank" class="waves-effect">LIST BANK</a></li>
                            <li><a href="#tiketDeposit" class="waves-effect">TIKET DEPOSIT</a> </li>
                            <li><a href="#historyTiketDeposit" class="waves-effect">HISTORY TIKET DEPOSIT</a></li>
                            <li><a href="#cancelTiketDeposit" class="waves-effect">CANCEL TIKET DEPOSIT</a></li>
                            <li><a href="#historyDeposit" class="waves-effect">HISTORY DEPOSIT</a></li>
                            <li><a href="#transferDeposit" class="waves-effect">REQUEST OTP TRANSFER DEPOSIT</a></li>
                            <li><a href="#confTransferDeposit" class="waves-effect">KONFIRMASI TRANSFER DEPOSIT</a></li>
                            <li><a href="#historyTransfer" class="waves-effect">HISTORY TRANSFER</a></li>
                        </ul>
                    </div>
                </li>
                <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-phone"></i> PULSA<i class="fa fa-angle-down rotate-icon"></i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="#listOperator" class="waves-effect">LIST OPERATOR</a></li>
                            <li><a href="#listNominal" class="waves-effect">LIST NOMINAL</a></li>
                            <li><a href="#inqueryPulsa" class="waves-effect">INQUERY PULSA</a></li>
                            <li><a href="#transaksiPulsa" class="waves-effect">TRANSAKSI PULSA</a></li>
                            <li><a href="#reportPulsa" class="waves-effect">REPORT PULSA</a></li>
                        </ul>
                    </div>
                </li>
                <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-bar-chart"></i> PPOB<i class="fa fa-angle-down rotate-icon"></i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="#listService" class="waves-effect">LIST SERVICE</a></li>
                            <li><a href="#listProduct" class="waves-effect">LIST PRODUK</a></li>
                            <li><a href="#inqueryPpob" class="waves-effect">INQUERY PPOB</a></li>
                            <li><a href="#transaksiPpob" class="waves-effect">TRANSAKSI PPOB</a></li>
                            <li><a href="#reportPpob" class="waves-effect">REPORT PPOB</a></li>
                        </ul>
                    </div>
                </li>
                <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-user"></i> POINT REWARD<i class="fa fa-angle-down rotate-icon"></i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="#pointBalance" class="waves-effect">CEK POINT</a></li>
                            <li><a href="#pointHistory" class="waves-effect">HISTORY POINT</a></li>
                        </ul>
                    </div>
                </li>
                <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-user"></i> Nomer Tersimpan<i class="fa fa-angle-down rotate-icon"></i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="#numberSaved" class="waves-effect">CARI NOMOR</a></li>
                            <li><a href="#numberAdd" class="waves-effect">TAMBAH NOMOR</a></li>
                            <li><a href="#numberDestroy" class="waves-effect">HAPUS NOMOR</a></li>
                        </ul>
                    </div>
                </li>
                <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-user"></i> Autodebet<i class="fa fa-angle-down rotate-icon"></i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="#autodebitList" class="waves-effect">LIST AUTODEBET</a></li>
                            <li><a href="#autodebitAdd" class="waves-effect">TAMBAH AUTODEBET</a></li>
                            <li><a href="#autodebitDestroy" class="waves-effect">HAPUS AUTODEBET</a></li>
                        </ul>
                    </div>
                </li>
                <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-user"></i> CHARITY<i class="fa fa-angle-down rotate-icon"></i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="#listCharity" class="waves-effect">LIST CHARITY</a></li>
                            <li><a href="#transferCharity" class="waves-effect">TRANSFER CHARITY</a></li>
                            <li><a href="#historyCharity" class="waves-effect">HISTORY CHARITY</a></li>
                        </ul>
                    </div>
                </li>
                <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-bars"></i> KUISONER<i class="fa fa-angle-down rotate-icon"></i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="#viewQuestionnaire" class="waves-effect">VIEW KUISONER</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
    </ul>
    <nav class="navbar navbar-fixed-top scrolling-navbar double-nav">

        <!-- SideNav slide-out button -->
        <div class="float-xs-left">
            <a href="#" data-activates="slide-out" class="button-collapse"><i class="fa fa-bars"></i></a>
        </div>
        <!-- Breadcrumb-->
        <div class="breadcrumb-dn">
            <p>Smart In Pays API Documentations</p>
        </div>
    </nav>
</header>

<main>
    <div class="container-fluid">
        @include('flash::message')
        @yield('content')
    </div>
</main>


@section('js')
    <script src="{{asset('/assets/js/admin/jquery-3.1.1.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/assets/js/admin/tether.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/assets/js/admin/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/assets/js/admin/mdb-pro.min.js')}}" type="text/javascript"></script>
    <script>
        // SideNav init
        $(".button-collapse").sideNav();

        // Custom scrollbar init
        var el = document.querySelector('.custom-scrollbar');
        Ps.initialize(el);
    </script>
    <script>
        $('#flash-overlay-modal').modal();
    </script>
@show
</body>
</html>
