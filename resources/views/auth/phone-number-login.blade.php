@extends('layouts.login')
@section('content')
    <main class="homepage">
        <section class="ns-hero pr">
            <div class="container" id="ns-hero">
                <div class="hero-caption pa translateY-center text-white">
                    <p class="label-text bold">Welcome To :</p>
                    <h1 class="title bold">Smart In Pays</h1>
                    <p>Smart In Pays adalah sebuah perusahaan yang bergerak dalam bidang aplikasi / platform penyedia
                        layanan <span>Digital Payment Business</span>, dimana setiap membernya bisa melakukan transaksi
                        jual beli secara online</p>
                </div>
            </div>
        </section>
        <section class="ns-popup-login">
            <div class="ns-popup-login-form pa translate-center">
                <button class="close-popup pa">
                    <img src="{{asset('/assets/images/login/cancel.png')}}" alt="close popup">
                </button>
                <div class="ns-popup-login-form-top hidden-xs pr">
                    <img src="{{asset('/assets/images/login/logo.png')}}" alt="SmartInpays"
                         class="img-responsive small-logo pa translate-center">
                    <a href="https://web.smartinpays.com"
                       class="label-text translateX-center text-white text-center text-uppercase">
                        web.smartinpays.com</a>
                </div>
                <div class="ns-popup-login-form-middle">
                    {{--                    <a href="https://web.smartinpays.com" class="btn btn-primary">Sign In</a>--}}
                </div>
            </div>
        </section>
        <section class="ns-homepage-service pad-default" id="ns-homepage-service">
            <div class="container">
                <div class="table m-auto pr width-auto">
                    <h1 class="ns-title-section text-center">Layanan <span class="bold">Kami</span></h1>
                </div>
                <div class="ns-services-slider m-t-40">
                    <!-- <div class="row"> -->
                    <div class="col-sm-3 col-xs-12">
                        <div class="ns-service-thumbnail">
                            <div class="ns-thumbnail-top">
                                <img src="{{asset('/assets/images/login/services/smart-trip.png')}}" alt="Smart Trip"
                                     class="img-responsive m-auto">
                            </div>
                            <div class="ns-thumbnail-middle">
                                <p class="thumbnail-title bold text-center font-24">Smart Trip</p>
                                <p class="text-center">Menciptakan sistem untuk travelling dengan mudah dan
                                    nyaman</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-12">
                        <div class="ns-service-thumbnail">
                            <div class="ns-thumbnail-top">
                                <img src="{{asset('/assets/images/login/services/smart-payment.png')}}"
                                     alt="Smart Payment" class="img-responsive m-auto">
                            </div>
                            <div class="ns-thumbnail-middle">
                                <p class="thumbnail-title bold text-center font-24">Smart Payment</p>
                                <p class="text-center">Dompet Digital yg berfungsi untuk pembayaran seluruh transaksi
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-12">
                        <div class="ns-service-thumbnail">
                            <div class="ns-thumbnail-top">
                                <img src="{{asset('/assets/images/login/services/smart-foundation.png')}}"
                                     alt="Smart Foundation" class="img-responsive m-auto">
                            </div>
                            <div class="ns-thumbnail-middle">
                                <p class="thumbnail-title bold text-center font-24">Smart Foundation</p>
                                <p class="text-center">Sarana untuk berbagi dan peduli terhadap sesama
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-12">
                        <div class="ns-service-thumbnail">
                            <div class="ns-thumbnail-top">
                                <img src="{{asset('/assets/images/login/services/smart-store.png')}}" alt="Smart Store"
                                     class="img-responsive m-auto">
                            </div>
                            <div class="ns-thumbnail-middle">
                                <p class="thumbnail-title bold text-center font-24">Smart Store</p>
                                <p class="text-center">Menyediakan produk-produk berkualitas yang dihasilkan oleh Smart
                                    Lab dan Smart Academy
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- </div> -->
                </div>
            </div>
        </section>
        <section class="ns-homepage-apps pad-default">
            <div class="container">
                <div class="ns-home-apps-image col-sm-5">
                    <img src="{{asset('/assets/images/login/apps.png')}}" alt="user friendly"
                         class="img-responsive m-auto">
                </div>
                <div class="ns-home-apps-caption col-sm-7 text-dark-grey">
                    <p class="ns-home-apps-caption-title text-dark-blue bold font-24">Download Aplikasi Smart In Pays
                        sekarang!</p>
                    <p>Download Aplikasi kami dan dapatkan pelayanan terbaik</p>
                    <ul>
                        <li>- Pengisian Pulsa</li>
                        <li>- Pembayaran tagihan/PPOB (Payment Point Online Bank)</li>
                        <li>- Booking Online</li>
                        <li>- Dan Pembayaran Lainnya</li>
                    </ul>
                    <div class="link-store-container flex">
                        <a href="javascript:void(0)" class="ns-link-store">
                            <img src="{{asset('/assets/images/login/appstore.png')}}" alt="" class="img-responsive">
                        </a>
                        <a href="https://play.google.com/store/apps/details?id=com.droid.sip&hl=id"
                           class="ns-link-store">
                            <img src="{{asset('/assets/images/login/google-play-badge.png')}}" alt=""
                                 class="img-responsive">
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <section class="ns-homepage-about pr" id="ns-homepage-about">
            <div class="container-fluid">
                <div class="row row-equal">
                    <div class="col-sm-12 col-md-6 pad-default">
                        <div class="about-info-container">
                            <div id="ns-about-slider" class="ns-about-mobile-slider">
                                <div>
                                    <div class="about-info mobile-text-white pad-0-32">
                                        <div class="table m-auto m-r-0 text-right pr width-auto">
                                            <h1 class="ns-title-section">Tentang <span class="bold">Kami</span></h1>
                                        </div>
                                        <p class="text-right m-t-40">Smart In Pays adalah sebuah perusahaan yang
                                            bergerak dalam bidang aplikasi / platform penyedia layanan Digital Payment
                                            Business, dimana setiap membernya bisa melakukan transaksi jual beli secara
                                            online. </p>
                                    </div>
                                </div>
                                <div>
                                    <div class="about-info mobile-text-white pad-0-32">
                                        <div class="table m-auto m-r-0 text-right pr width-auto">
                                            <h1 class="ns-title-section bold">Visi</h1>
                                        </div>
                                        <p class="text-right m-t-40">Memberikan Edukasi Digital dan mengubah cara
                                            bertransaksi masyarakat Indonesia</p>
                                    </div>
                                </div>
                                <div>
                                    <div class="about-info mobile-text-white pad-0-32">
                                        <div class="table m-auto m-r-0 text-right pr width-auto">
                                            <h1 class="ns-title-section text-right bold">Misi</h1>
                                        </div>
                                        <p class="text-right m-t-40">Menciptakan wirausahawan independen dan terkemuka
                                            yang mampu mengubah ekonomi Indonesia untuk masa depan yang lebih baik.
                                        </p>
                                        <p class="text-right m-t-40">Mendukung prinsip ekonomi kerakyatan dengan
                                            memberikan peluang bagi setiap anggota untuk menjadi pengusaha di bidang
                                            pemasaran jaringan bisnis gaya hidup.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 about-background hidden-sm"></div>
                </div>
            </div>
        </section>
        <section class="ns-homepage-partner pad-default">
            <div class="container">
                <div class="table m-auto pr width-auto">
                    <h1 class="ns-title-section text-center">Rekan <span class="bold">Kami</span></h1>
                </div>
                <div class="ns-logo-images-container m-t-40">
                    <div>
                        <img src="{{asset('/assets/images/login/partner/air-asia.png')}}" alt="efficient"
                             class="img-responsive m-auto">
                    </div>
                    <div>
                        <img src="{{asset('/assets/images/login/partner/Axis.png')}}" alt="efficient"
                             class="img-responsive m-auto">
                    </div>
                    <div>
                        <img src="{{asset('/assets/images/login/partner/Bolt.png')}}" alt="efficient"
                             class="img-responsive m-auto">
                    </div>
                    {{--<div>--}}
                    {{--<img src="{{asset('/assets/images/login/partner/Cipaganti.png')}}" alt="efficient" class="img-responsive m-auto">--}}
                    {{--</div>--}}
                    <div>
                        <img src="{{asset('/assets/images/login/partner/Citilink.png')}}" alt="efficient"
                             class="img-responsive m-auto">
                    </div>
                    <div>
                        <img src="{{asset('/assets/images/login/partner/Garuda.png')}}" alt="efficient"
                             class="img-responsive m-auto">
                    </div>
                    <div>
                        <img src="{{asset('/assets/images/login/partner/Grand-Sahid.png')}}" alt="efficient"
                             class="img-responsive m-auto">
                    </div>
                    <div>
                        <img src="{{asset('/assets/images/login/partner/Indosat.png')}}" alt="efficient"
                             class="img-responsive m-auto">
                    </div>

                    <div>
                        <img src="{{asset('/assets/images/login/partner/Indovision.png')}}" alt="efficient"
                             class="img-responsive m-auto">
                    </div>
                    <div>
                        <img src="{{asset('/assets/images/login/partner/KA.png')}}" alt="efficient"
                             class="img-responsive m-auto">
                    </div>
                    <div>
                        <img src="{{asset('/assets/images/login/partner/Mahakam.png')}}" alt="efficient"
                             class="img-responsive m-auto">
                    </div>
                    <div>
                        <img src="{{asset('/assets/images/login/partner/MCF.png')}}" alt="efficient"
                             class="img-responsive m-auto">
                    </div>
                    <div>
                        <img src="{{asset('/assets/images/login/partner/Mercure.png')}}" alt="efficient"
                             class="img-responsive m-auto">
                    </div>
                    <div>
                        <img src="{{asset('/assets/images/login/partner/Garuda.png')}}" alt="efficient"
                             class="img-responsive m-auto">
                    </div>
                    <div>
                        <img src="{{asset('/assets/images/login/partner/Palyja.png')}}" alt="efficient"
                             class="img-responsive m-auto">
                    </div>
                    <div>
                        <img src="{{asset('/assets/images/login/partner/PLN.png')}}" alt="efficient"
                             class="img-responsive m-auto">
                    </div>
                    {{--<div>--}}
                    {{--<img src="{{asset('/assets/images/login/partner/Railink.png')}}" alt="efficient" class="img-responsive m-auto">--}}
                    {{--</div>--}}
                    <div>
                        <img src="{{asset('/assets/images/login/partner/Sheraton.png')}}" alt="efficient"
                             class="img-responsive m-auto">
                    </div>
                    <div>
                        <img src="{{asset('/assets/images/login/partner/Smartfren.png')}}" alt="efficient"
                             class="img-responsive m-auto">
                    </div>
                    <div>
                        <img src="{{asset('/assets/images/login/partner/Speedy.png')}}" alt="efficient"
                             class="img-responsive m-auto">
                    </div>
                    <div>
                        <img src="{{asset('/assets/images/login/partner/Sriwijaya-Air.png')}}" alt="efficient"
                             class="img-responsive m-auto">
                    </div>
                    <div>
                        <img src="{{asset('/assets/images/login/partner/Telkomsel.png')}}" alt="efficient"
                             class="img-responsive m-auto">
                    </div>
                    <div>
                        <img src="{{asset('/assets/images/login/partner/The-ritz-carlton.png')}}" alt="efficient"
                             class="img-responsive m-auto">
                    </div>
                    <div>
                        <img src="{{asset('/assets/images/login/partner/Three.png')}}" alt="efficient"
                             class="img-responsive m-auto">
                    </div>
                    <div>
                        <img src="{{asset('/assets/images/login/partner/Trans-vision.png')}}" alt="efficient"
                             class="img-responsive m-auto">
                    </div>
                    <div>
                        <img src="{{asset('/assets/images/login/partner/XL.png')}}" alt="efficient"
                             class="img-responsive m-auto">
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection