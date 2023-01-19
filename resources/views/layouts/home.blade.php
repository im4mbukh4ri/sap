<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Smart in Pays</title>
    <meta name="description" content="Smart In Pays adalah perusahaan yang bergerak di bidang Multipayment Bisnis, Tour & Travel yang memungkinkan pengguna untuk menemukan dan memesan beragam produk transportasi, akomodasi, gaya hidup, dan layanan keuangan seperti PPOB (Payment Point Online Bank) untuk pembayaran PLN, PDAM, Token listrik prabayar, Pulsa, Tiket Pesawat, Tiket Kereta Api, Hotel, Pelni dan tagihan lainnya.">
    <meta name="keywords" content="Smart In Pays, SIP, sip, ppob, pulsa,hotel, pulsa, Tour & Travel,Multipayment">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/icon/fav-icon.png">
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.0.3/dist/tailwind.min.css">
    <link rel="stylesheet" href="/assets/css/custom.css"><!-- <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet"> -->
    <script src="https://unpkg.com/vue/dist/vue.min.js"></script>
    <script src="https://unpkg.com/vue-i18n/dist/vue-i18n.js"></script>
    <script src="https://unpkg.com/vue-lazyload/vue-lazyload.js"></script>
</head>

<body class="leading-normal tracking-normal text-gray-900">
    <div class="h-screen pb-14 bg-right bg-cover" id="app">
        <!-- modal dialog -->
        <div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
            <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
            <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
                <!-- Add margin if you want to see some of the overlay behind the modal-->
                <div class="modal-content py-4 text-left px-6">
                    <!--Title-->
                    <div class="flex justify-between items-center pb-3">
                        <div></div>
                        <div class="modal-close cursor-pointer z-50" @click="toggleModal"><svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                            </svg></div>
                    </div>
                    <!--Body-->
                    <div><a class="btn-sip primary block" @click="goTo('auth/login')">Login</a></div>
                </div>
            </div>
        </div><!-- alert mobile -->
        <div id="alert-mobile" v-if="alertMobile">
            <div class="w-full flex flex-row align-center">
                <div class="w-4/6">
                    <div class="alert-mobile-content d-flex h-100">
                        <div @click="hideAlertMobile" class="pl-2 pr-4"><img v-lazy="`assets/images/icon/icon-close.png`" class="w-100 icon-close"></div><img v-lazy="`assets/images/icon/icon-sip.png`" class="w-100 icon-app mr-3">
                        <div>Smart In Pays App</div>
                    </div>
                </div>
                <div class="w-2/6 flex align-center justify-end"><a class="btn-sip primary" style="padding: 8px 20px;
                font-size: 16px;
                font-weight: 600;
                border-radius: 30px;
                max-height: 40px" @click="goTo('open-app')">@{{ $t("open") }}</a></div>
            </div>
        </div>
        <!--header-->
        <div class="w-full mx-auto sip-header fixed">
            <div class="container w-full mx-auto">
                <div class="w-full flex items-center justify-between">
                    <div class="flex w-1/2"><a class="flex items-center hover:no-underline" @click="moveTo('sipSection1')"><img src="/assets/images/logo.png" class="sip-logo"></a></div>
                    <div class="flex w-1/2 justify-end content-center">
                        <div class="sip-menu"><a class="btn-sip primary mr-8" @click="goTo('auth/login')">Login</a>
                            <div class="flex justify-center">
                                <div class="relative"><button @click="dropdownLang = !dropdownLang" class="relative flex p-2 focus:outline-none"><img class="mr-4" v-lazy="lang == 'id' ? '/assets/images/lang/id.png' : '/assets/images/lang/en.png'" style="width: 30px;height:20px"> <svg class="fill-current h-5 w-5" style="color: #828282" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                        </svg></button>
                                    <div v-show="dropdownLang" @click="dropdownLang = false" class="fixed inset-0 h-full w-full z-10"></div>
                                    <div v-show="dropdownLang" class="absolute right-0 mt-2 py-2 w-full bg-white rounded-md shadow-xl z-20" style="right: 10px; width: 150px"><a @click="()=>{lang='id';dropdownLang = false}" class="cursor-pointer block flex flex-row align-center justify-end text-center px-4 py-2 text-md capitalize text-gray-700">Indonesia <img v-lazy="`/assets/images/lang/id.png`" style="width: 30px;height:20px" class="ml-3"> </a><a @click="()=>{lang='en';dropdownLang = false}" class="block cursor-pointer text-center px-4 py-2 text-md capitalize text-gray-700 block flex flex-row justify-end align-center">English <img v-lazy="`/assets/images/lang/en.png`" style="width: 30px;height:20px" class="ml-3"></a></div>
                                </div>
                            </div>
                        </div>
                        <div class="sip-menu-mobile"><a class="menu-mobile" @click="toggleModal"><img v-lazy="`/assets/images/icon/icon-menu.png`" class="icon-sip"></a></div>
                    </div>
                </div>
            </div>
        </div><!-- jumbroton -->
        <div class="w-full flex justify-end jumbotron"><img src="assets/images/jumbotron.png" class=""></div>
        <div class="flex justify-start jumbotron" style="left: 20%"><img src="assets/images/jumbroton-2.png" class="slide-in-bottom-subtitle"></div><!-- scorll to button --> <button class="btn-icon-sip primary btn-scroll-to focus:outline-none" @click="nextSection" v-show="showBtnNextSection"><img v-lazy="`/assets/images/icon/arraw-down.png`" class="w-2/3"></button>
        <!--Section 1-->
        <section class="container pt-24 md:pt-30 px-6 mx-auto flex flex-wrap flex-col md:flex-row items-center" id="sip-section-1" ref="sipSection1">
            <!--Left Col-->
            <div class="flex flex-col w-full md:w-3/6 justify-center lg:items-start overflow-y-hidden">
                <div class="mb-4 text-left slide-in-bottom-h1 title">@{{ $t("section1.title") }}</div>
                <div class="mb-9 md:mb-7 text-left slide-in-bottom-subtitle subtitle" style="max-width: 565px">@{{ $t('section1.subtitle') }}</div>
                <div class="flex w-full justify-start pb-30 lg:pb-0 fade-in"><img src="/assets/images/app-store.png" class="h-10 pr-4 sip-store cursor-pointer" @click="goTo('app-store')"> <img src="/assets/images/google-play.png" class="h-10 sip-store cursor-pointer" @click="goTo('play-store')"></div>
            </div>
            <!--Right Col-->
            <div class="w-full md:w-3/6 py-6 overflow-y-hidden text-right" style="position: relative; min-height: 400px"><img class="mx-auto lg:mr-0 slide-in-bottom app-image" src="/assets/images/app-image.png" style="width: 80%"> <img class="w-full py-5 mx-0 slide-in-bottom app-image-mobile" src="/assets/images/app-image-mobile.png"></div>
        </section>
        <!--Section 2-->
        <section class="container pt-20 md:pt-30 px-6 mx-auto flex flex-wrap flex-col md:flex-row items-center" id="sip-section-2" ref="sipSection2">
            <!--Left Col-->
            <div class="flex flex-col w-full md:w-3/6 justify-center lg:items-start overflow-y-hidden image-style">
                <div style="position: absolute"></div><img class="w-100 slide-in-bottom" v-lazy="`/assets/images/image-section-2.png`">
            </div>
            <!--Right Col-->
            <div class="w-full md:w-3/6 py-6 overflow-y-hidden pl-0 md:pl-20">
                <div class="head-title mb-1">@{{ $t("section2.head_title") }}</div>
                <div class="mb-3 text-left slide-in-bottom-h1 title">@{{ $t("section2.title") }}</div>
                <p class="mb-9 md:mb-4 text-left slide-in-bottom-subtitle subtitle">@{{ $t("section2.subtitle") }}</p>
            </div>
        </section>
        <!--Section 3-->
        <section class="my-20 py-10 md:py-20 px-6 mx-auto flex flex-wrap flex-col md:flex-row items-center" id="sip-section-3">
            <div class="w-full title text-center">@{{ $t("section3.title") }}</div>
            <div class="container flex flex-wrap flex-col md:flex-row items-center mx-auto">
                <div class="flex flex-col w-full md:w-3/6 px-0 md:px-8">
                    <div class="card-3">@{{ $t("section3.desc1") }}</div>
                </div>
                <div class="flex flex-col w-full md:w-3/6 px-0 md:px-8">
                    <div class="card-3">@{{ $t("section3.desc2") }}</div>
                </div>
                <div class="flex flex-col w-full md:w-3/6 px-0 md:px-8">
                    <div class="card-3">@{{ $t("section3.desc3") }}</div>
                </div>
                <div class="flex flex-col w-full md:w-3/6 px-0 md:px-8">
                    <div class="card-3">@{{ $t("section3.desc4") }}</div>
                </div>
            </div>
        </section>
        <!--Section 4-->
        <section class="container py-24 md:py-40 px-6 mx-auto" id="sip-section-4">
            <div class="title">@{{ $t("sections4.title") }}</div>
            <div class="mx-auto flex flex-wrap flex-col md:flex-row items-center mb-4 md:mb-12 pb-4 md:pb-12">
                <!--Left Col-->
                <div class="flex flex-col w-full md:w-3/6 justify-center lg:items-start overflow-y-hidden px-5 lg:px-20"><img class="w-100 slide-in-bottom mx-auto" v-lazy="`/assets/images/section-4-2.png`"></div>
                <!--Right Col-->
                <div class="w-full md:w-3/6 py-6 overflow-y-hidden pl-0 md:pl-20">
                    <div style="max-width: 449px">
                        <div class="mb-2 text-left slide-in-bottom-h1 subtitle">@{{ $t("sections4.subtitle1") }}</div>
                        <p class="mb-8 text-left slide-in-bottom-subtitle description">@{{ $t("sections4.desc1") }}</p>
                        <div class="flex flex-wrap flex-row slide-in-bottom-subtitle justify-start"><a class="btn-icon-sip" v-for="item in section4Transport"><img v-lazy="item"></a></div>
                    </div>
                </div>
            </div>
            <div class="mx-auto flex flex-wrap flex-col md:flex-row items-center mt-4 md:mt-12 pt-4 md:pt-12">
                <!--Right Col-->
                <div class="w-full md:w-3/6 py-6 overflow-y-hidden pl-0 md:pl-20">
                    <div style="max-width: 550px">
                        <div class="mb-2 text-left slide-in-bottom-h1 subtitle">@{{ $t("sections4.subtitle2") }}</div>
                        <p class="mb-8 text-left slide-in-bottom-subtitle description">@{{ $t("sections4.desc2") }}</p>
                        <div class="flex flex-wrap flex-row slide-in-bottom-subtitle justify-between md:justify-start"><a class="btn-icon-sip" v-for="item in section4Bill"><img v-lazy="item"></a></div>
                    </div>
                </div>
                <!--Left Col-->
                <div class="flex flex-col w-full md:w-3/6 justify-center lg:items-start overflow-y-hidden px-5 lg:px-20"><img class="w-100 slide-in-bottom mx-auto" v-lazy="`/assets/images/section-4-1.png`"></div>
            </div>
        </section>
        <!--Section download-->
        <section id="sip-section-download">
            <div class="container mx-auto flex flex-row flex flex-wrap flex-col lg:flex-row items-center">
                <!--Left Col-->
                <div class="flex flex-col w-full md:w-6/6 lg:w-3/6">
                    <div class="text-center md:text-left slide-in-bottom-subtitle description z-10">
                        <div class="mb-8" v-html="$t('section_download.title')"></div>
                        <div class="flex w-full flex-col md:flex-row justify-center lg:justify-start pb-30 lg:pb-0 fade-in"><a class="btn-sip btn-downlod mr-0 md:mr-3 mb-5 md:mb-0 cursor-pointer" @click="goTo('app-store')"><img v-lazy="`/assets/images/icon/icon-app-store.png`" class="h-10 mr-2"> App Store </a><a class="btn-sip btn-downlod cursor-pointer" @click="goTo('play-store')"><img v-lazy="`/assets/images/icon/icon-play-store.png`" class="h-10 mr-2"> Play Store</a></div>
                    </div>
                </div>
                <!--Right Col-->
                <div class="w-full md:w-3/6 py-6 overflow-y-hidden"><img class="w-6/6 slide-in-bottom app-image-2" v-lazy="`/assets/images/app-image-2.png`"></div>
            </div>
        </section>
        <!--Section 5-->
        <section class="pb-0 md:pb-40 pt-24 md:pt-40 px-6" id="sip-section-5">
            <div class="container mx-auto">
                <div class="title">@{{ $t("sections5.title") }}</div>
                <div class="mx-auto flex flex-no-wrap overflow-x-scroll md:overflow-x-hidden scrolling-touch justify-start items-center md:justify-center mb-12 pb-12 overflow-x-auto"><a :class="`btn-sip tab ${tabSection5Selected == tab.id ? ' active ' : ''}`" v-for="tab in tabSection5" @click="tabSection5Selected = tab.id">@{{ $t(tab.name) }}</a></div>
                <div class="flex flex-no-wrap flex-col lg:flex-row" v-if="tabSection5Active.name">
                    <div :class=" `${ tabSection5Active.products.length > 1 ? ' w-full lg:w-2/6 px-0 md:px-6 lg:px-10  mb-5' : ' w-full '} `" v-for="product in tabSection5Active.products">
                        <div class="card-5">
                            <div class="card-cap"><img v-lazy="product.cap" class=""></div>
                            <div class="card-title black--text">@{{ $t(product.name) }}</div>
                            <div class="partners" :class=" `${ tabSection5Active.products.length > 1 ? ' justify-start ' : ' justify-start '} `">
                                <div class="partner-box" v-for="partner in product.partners" :style="`${product.name == 'flight' ? ' margin-right: 0px;' :'' }`"><img v-lazy="partner" class="" :style="`${product.name == 'pelni' ? ' max-height: 80px;max-width: 50px;' :'' }`"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- footer -->
        <div class="sip-footer">
            <div class="section-1">
                <div class="container flex flex-wrap flex-row mx-auto">
                    <div class="flex flex-col w-3/12">
                        <div class="title" style="margin-top: -13px"><img v-lazy="`/assets/images/footer/logo-white.png`" class="w-60" style="max-width: 168px"></div><a class="" style="margin-bottom: 30px">
                            <div class="w-full flex flex-row items-start"><img v-lazy="`/assets/images/icon/map.png`" style="width: 16px; height: 16px" class="mt-1"> <span class="pl-3" style="font-size: 12px">Greenlake City Ruko Sentra Niaga,<br>Blk. O No.2, RT.7/RW.8, Duri Kosambi,<br>Kecamatan Cengkareng, Kota Jakarta Barat,<br>Daerah Khusus Ibukota Jakarta 11610</span></div>
                        </a>
                        <div class="flex items-center mb-7"><img v-lazy="`/assets/images/footer/clock-white.png`" class="w-20" style="max-width: 45px">
                            <div class="flex-col w-5/6 pl-2 pt-3">
                                <div class="text-xs font-normal">@{{ $t("contact_us") }}</div><a class="text-xl" @click="goTo('cs')">1500-107</a>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-row w-3/12 pl-5">
                        <div class="flex flex-col w-6/12">
                            <div class="title">@{{ $t("product") }}</div>
                            <div><a @click="goTo('airlines')">@{{ $t("flight") }} </a><a @click="goTo('hotel')">@{{ $t("hotel") }} </a><a @click="goTo('trains')">@{{ $t("train") }} </a><a @click="goTo('ships')">Pelni </a><a @click="goTo('pulsa')">@{{ $t("pulsa") }} </a><a @click="goTo('bills')">@{{ $t("bills") }} </a><a @click="goTo('voucher_game')">Voucher Game</a></div>
                        </div>
                        <div class="flex flex-col w-6/12">
                            <div class="title">@{{ $t("support") }}</div>
                            <div><a @click="goTo('info/help-center')">@{{ $t("help_center") }} </a><a @click="goTo('info/tac')">@{{ $t("terms_and_conditions") }}</a></div>
                        </div>
                    </div>
                    <div class="flex flex-col w-3/12 pl-5">
                        <div class="title">@{{ $t("download") }} Smart In Pays App</div>
                        <div class=""><a @click="goTo('app-store')"><img v-lazy="`/assets/images/footer/app-store.png`" class="w-60" style="max-width: 160px"> </a><a @click="goTo('play-store')"><img v-lazy="`/assets/images/footer/google-play.png`" class="w-60" style="max-width: 160px"></a></div>
                        <div>
                            <div class="flex items-center text-md mb-2 mt-5 font-normal">@{{ $t("follow_us") }}</div>
                            <div class="flex flex-row"><a class="pr-4" @click="goTo('fb')"><img v-lazy="`/assets/images/footer/facebook.png`" class="w-8"> </a><a class="pr-4" @click="goTo('ig')"><img v-lazy="`/assets/images/footer/instagram.png`" class="w-8"> </a>
                                <!-- <a class="pr-4">
                  <img src="/assets/images/footer/linkedin.png" class="w-8" />
                </a> --> <a class="pr-4" @click="goTo('youtube')"><img v-lazy="`/assets/images/footer/youtube.png`" class="w-8"></a>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col w-3/12 pl-5">
                        <div class="title">Layanan Pengaduan Konsumen</div><a class="">
                            <div class="w-full flex flex-row items-start"><img v-lazy="`/assets/images/icon/map.png`" style="width: 16px; height: 16px" class="mt-1"> <span class="pl-2">Direktorat Jenderal Perlindungan Konsumen dan Tertib Niaga</span></div>
                        </a><a href="tel:+62-21-3858205">
                            <div class="w-full flex flex-row items-start"><img v-lazy="`/assets/images/icon/phone-1.png`" style="width: 16px; height: 16px" class="mt-1"> <span class="pl-2">+62-21-3858171, +62-21-3451692</span></div>
                        </a><a>
                            <div class="w-full flex flex-row items-start"><img v-lazy="`/assets/images/icon/fax.png`" style="width: 16px; height: 16px" class="mt-1"> <span class="pl-2">+62-21-3858205, +62-21-3842531</span></div>
                        </a><a class="" href="mailto:contact.us@kemendag.go.id">
                            <div class="w-full flex flex-row items-start"><img v-lazy="`/assets/images/icon/email.png`" style="width: 16px; height: 16px" class="mt-1"> <span class="pl-2">contact.us@kemendag.go.id</span></div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="section-2">Copyright © 2021</div>
        </div>
    </div>
</body>


<script type="module" src="assets/js/app.js"></script>
<script type="text/javascript">
    var Tawk_API = Tawk_API || {},
        Tawk_LoadStart = new Date();
    var hideLiveChat = window.screen.width < 968;
    if (!hideLiveChat) {
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = "https://embed.tawk.to/587f2c2a926a51336fe70d73/default";
            s1.charset = "UTF-8";
            s1.setAttribute("crossorigin", "*");
            s0.parentNode.insertBefore(s1, s0);
        })();
    }
</script>

</html>