@extends('api.v1.documentations.layouts')
@section('css')
    @parent
@endsection
@section('content')
    <h1>GET TOKEN</h1>
    <h3 id="getToken">GET TOKEN</h3>
    @include('api.v1.documentations.token._get-token-login')
    <hr>
    <h1>MEMBERSHIP</h1>
    <h3 id="registrasiMemberFree">REGISTRASI MEMBER FREE</h3>
    @include('api.v1.documentations.users._registration')
    <hr>
    <h3 id="resetPassword">RESET PASSWORD MEMBER</h3>
    @include('api.v1.documentations.users._reset-password')
    <hr>
    <h3 id="changePassword">GANTI PASSWORD MEMBER</h3>
    @include('api.v1.documentations.users._change-password')
    <hr>
    <h3 id="uploadPhoto">UPLOAD FOTO MEMBER</h3>
    @include('api.v1.documentations.users._upload-photo')
    <hr>
    <h1>LOCATIONS</h1>
    <hr>
    {{-- <h3 id="configLoc">Get Config Location</h3>
    @include('api.v1.documentations.locations._get-config-location')
    <hr> --}}
    <h3 id="getMemberPro">Get Member Pro</h3>
    @include('api.v1.documentations.locations._get-member-pro')
    <hr>
    <h3 id="updateConfLoc">Update Konfigurasi Location</h3>
    @include('api.v1.documentations.locations._update-config-location')
    <hr>
    <h1>LOGIN, AKSES TOKEN</h1>
    <hr>
    <h3 id="login">LOGIN</h3>
    @include('api.v1.documentations.token._login')
    <hr>
    <h3 id="access">GET AKSES ( Refresh token )</h3>
    @include('api.v1.documentations.token._refresh-token')
    <hr>
    <h1 id="getSchedule">AIRLINES</h1>
    <hr>
    <h3 id="getScheduleClass">AIRPORTS</h3>
    @include('api.v1.documentations.airlines._airports')
    <hr>
    @include('api.v1.documentations.airlines._get-schedule')
    <hr>
    <h3 id="getScheduleClass">AIRLINES GET SCHEDULE CLASS ( KHUSUS GARUDA AIRLINES (GA) )</h3>
    @include('api.v1.documentations.airlines._get-schedule-class')
    <hr>
    <h3 id="getFare">AIRLINES GET FARE</h3>
    @include('api.v1.documentations.airlines._get-fare')
    <hr>
    <h3 id="booking">AIRLINES BOOKING</h3>
    @include('api.v1.documentations.airlines._booking')
    <hr>
    <h3 id="cancelBooking">AIRLINES CANCEL BOOKING</h3>
    @include('api.v1.documentations.airlines._cancel-booking')
    <hr>
    <h3 id="issued">AIRLINES ISSUED</h3>
    @include('api.v1.documentations.airlines._issued')
    <hr>
    <h3 id="bookingIssued">AIRLINES BOOKING ISSUED</h3>
    @include('api.v1.documentations.airlines._booking-issued')
    <hr>
    <h3 id="airlinesReport">AIRLINES REPORTS</h3>
    @include('api.v1.documentations.airlines._reports')
    <h3 id="airlinesReportDetail">AIRLINES REPORT DETAIL</h3>
    @include('api.v1.documentations.airlines._reports-detail')
    <hr>
    <h1>KERETA API</h1>
    <hr />
    <h3 id="trainStation">STATION</h3>
    @include('api.v1.documentations.trains._stations')
    <hr />
    <h3 id="trainGetSchedule">GET SCHEDULE</h3>
    @include('api.v1.documentations.trains._get-schedule')
    <hr />
    <h3 id="trainGetSeat">GET SEAT</h3>
    @include('api.v1.documentations.trains._get-seat')
    <h3 id="trainBookingIssued">BOOKING ISSUED</h3>
    @include('api.v1.documentations.trains._booking-issued')
    <hr />
    <h3 id="trainReport">REPORT</h3>
    @include('api.v1.documentations.trains._report')
    <hr />
    <h3 id="trainBookingIssued">DETAIL REPORT</h3>
    @include('api.v1.documentations.trains._detail-report')
    <hr />
    <hr>
    <h1>HOTEL</h1>
    <hr>
    <h3 id="listCities">LIST KOTA</h3>
    @include('api.v1.documentations.hotels._hotel_cities')
    <hr>
    <hr>
    <h3 id="hotelSearch">SEARCH HOTEL</h3>
    @include('api.v1.documentations.hotels._search-hotel')
    <hr>
    <hr>
    <h3 id="hotelNext">SEARCH NEXT</h3>
    @include('api.v1.documentations.hotels._search-hotel-next')
    <hr>
    <h3 id="hotelKeyword">SEARCH KEYWORD</h3>
    @include('api.v1.documentations.hotels._search-hotel-keyword')
    <hr>
    <h3 id="hotelSort">SEARCH SORT</h3>
    @include('api.v1.documentations.hotels._search-sort')
    <hr>
    <h3 id="hotelDetail">DETAIL HOTEL</h3>
    @include('api.v1.documentations.hotels._detail-hotel')
    <hr>
    <h3 id="hotelBookingIssued">BOOKING ISSUED HOTEL</h3>
    @include('api.v1.documentations.hotels._hotel-booking-issued')
    <hr>
    <h3 id="reportHotel">REPORT HOTEL</h3>
    @include('api.v1.documentations.hotels._report')
    <hr>
    <h1>DEPOSIT</h1>
    <hr>
    <h3 id="cekSaldo">CEK SALDO</h3>
    @include('api.v1.documentations.deposits._check-balance')
    <hr>
    <h3 id="listBank">LIST BANK</h3>
    @include('api.v1.documentations.deposits._list-bank')
    <hr>
    <h3 id="tiketDeposit">TIKET DEPOSIT</h3>
    @include('api.v1.documentations.deposits._ticket-deposit')
    <hr>
    <h3 id="historyTiketDeposit">HISTORY TIKET DEPOSIT</h3>
    @include('api.v1.documentations.deposits._history-ticket')
    <hr>
    <h3 id="cancelTiketDeposit">CANCEL TIKET DEPOSIT</h3>
    @include('api.v1.documentations.deposits._cancel-ticket-deposit')
    <hr>
    <h3 id="historyDeposit">HISTORY DEPOSIT ( BUKU SALDO )</h3>
    @include('api.v1.documentations.deposits._history-deposit')
    <hr>
    <h3 id="transferDeposit">REQUEST OTP TRANSFER DEPOSIT</h3>
    @include('api.v1.documentations.deposits._transfer-deposit')
    <hr>
    <h3 id="confTransferDeposit">KONFIRMASI TRANSFER DEPOSIT</h3>
    @include('api.v1.documentations.deposits._confirm-transfer-deposit')
    <hr>
    <h3 id="historyTransfer">HISTORY TRANSFER</h3>
    @include('api.v1.documentations.deposits._history-tranfer')
    <hr>
    <h1>PULSA</h1>
    <hr>
    <h3 id="listOperator">LIST OPERATOR</h3>
    @include('api.v1.documentations.pulsa._list-operator')
    <hr>
    <h3 id="listNominal">LIST NOMINAL</h3>
    @include('api.v1.documentations.pulsa._list-nominal')
    <hr>
    <h3 id="inqueryPulsa">INQUERY PULSA</h3>
    @include('api.v1.documentations.pulsa._inquery')
    <hr>
    <h3 id="transaksiPulsa">TRANSAKSI PULSA</h3>
    @include('api.v1.documentations.pulsa._transaction')
    <hr>
    <h3 id="reportPulsa">REPORT PULSA</h3>
    @include('api.v1.documentations.pulsa._reports')
    <hr>
    <h1>PPOB</h1>
    <hr>
    <h3 id="listService">LIST SERVICE</h3>
    @include('api.v1.documentations.ppob._list-service')
    <hr>
    <h3 id="listProduct">LIST PRODUK</h3>
    @include('api.v1.documentations.ppob._list-products')
    <hr>
    <h3 id="inqueryPpob">INQUERY PPOB</h3>
    @include('api.v1.documentations.ppob._inquery')
    <hr>
    <h3 id="transaksiPpob">TRANSAKSI PPOB</h3>
    @include('api.v1.documentations.ppob._transaction')
    <hr>
    <h3 id="reportPpob">REPORT PPOB</h3>
    @include('api.v1.documentations.ppob._report')
    <hr>
    <h1>SUPPORTS</h1>
    <h3 id="supportTerm">SYARAT DAN KETENTUAN</h3>
    @include('api.v1.documentations.supports._terms')
    <hr>
    <h3 id="supportFaq">FAQ</h3>
    @include('api.v1.documentations.supports._faqs')
    <h1>POINT REWARD</h1>
    <hr>
    <h3 id="pointHistory">CEK MAKSIMAL POINT</h3>
    @include('api.v1.documentations.points._max-point')
    <h3 id="pointBalance">CEK POINT</h3>
    @include('api.v1.documentations.points._check-balance')
    <hr>
    <h3 id="pointHistory">HISTORY POINT</h3>
    @include('api.v1.documentations.points._history-point')
    <hr>
    <h1>Nomor Tersimpan</h1>
    <h3  id="numberSaved">Cari Nomor</h3>
    @include('api.v1.documentations.number_saveds._search-number')
    <hr />
    <h3 id="numberAdd">Tambah Nomor</h3>
    @include('api.v1.documentations.number_saveds._add-number')
    <hr>
    <h3  id="numberDestroy">Hapus Nomor</h3>
    @include('api.v1.documentations.number_saveds._destroy-number')
    <hr>
    <h1>Autodebet</h1>
    <h3 id="autodebitList">List Autodebet</h3>
    @include('api.v1.documentations.autodebits._autodebits-list')
    <hr />
    <h3 id="autodebitAdd">Tambah Autodebet</h3>
    @include('api.v1.documentations.autodebits._autodebits-store')
    <hr />
    <h3 id="autodebitDestroy">Hapus Autodebet</h3>
    @include('api.v1.documentations.autodebits._autodebits-destroy')
    <h1>CHARITY</h1>
    <hr>
    <h3 id="listCharity">List Charity</h3>
    @include('api.v1.documentations.charities._list-charities')
    <hr>
    <h3 id="transferCharity">Transfer Charity</h3>
    @include('api.v1.documentations.charities._transfer-charities')
    <hr>
    <h3 id="historyCharity">Hisotry Charity</h3>
    @include('api.v1.documentations.charities._histories-charities')
    <hr>
    {{-- <h1>QUESTIONNAIRES</h1>
    <hr>
    <h3 id="viewQuestionnaire">View Questionnaires</h3>
    @include('api.v1.documentations.questionnaires._get-view-questionnaire')
    <hr> --}}
@endsection
@section('js')
    @parent

@endsection
