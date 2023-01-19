<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="_token" id="token" value="{{csrf_token()}}">
    <title>Admin | SIP</title>
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
                <a href="{{route('admin.index')}}"><img src="{{asset('/assets/logo/logotext-blue.png')}}" class="img-fluid flex-center"></a>
            </div>
        </li>
        <li>
            <ul class="social">
                <li><a class="icons-sm fb-ic"><i class="fa fa-facebook"> </i></a></li>
                <li><a class="icons-sm pin-ic"><i class="fa fa-pinterest"> </i></a></li>
                <li><a class="icons-sm gplus-ic"><i class="fa fa-google-plus"> </i></a></li>
                <li><a class="icons-sm tw-ic"><i class="fa fa-twitter"> </i></a></li>
            </ul>
        </li>
        <li>
            <ul class="collapsible collapsible-accordion">
                <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-users"></i> Member<i class="fa fa-angle-down rotate-icon"></i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="{{route('admin.users_index')}}" class="waves-effect">Daftar Member</a></li>
                            <li><a href="#" class="waves-effect">Registrasi Member</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
        <li>
            <ul class="collapsible collapsible-accordion">
                <li><a href="{{route('admin.deposits_index')}}" class="collapsible-header waves-effect"><i class="fa fa-money"></i> Deposit</a></li>
            </ul>
        </li>
        <li>
            <ul class="collapsible collapsible-accordion">
                <li><a href="{{route('admin.announcements_index')}}" class="collapsible-header waves-effect"><i class="fa fa-newspaper-o"></i> Posting Berita</a></li>
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
            <p>Smart In Pays</p>
        </div>

        <ul class="nav navbar-nav float-xs-right">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> Profile</a>
                <div class="dropdown-menu dropdown-primary dd-right" aria-labelledby="dropdownMenu1" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                    <a class="dropdown-item" href="{{url('logout')}}">Logout</a>
                </div>
            </li>
        </ul>
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