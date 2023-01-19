<!doctype html>
<html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Flight</title>
<style>
    @font-face {
        font-family: Roboto;
        font-weight: 100;
        src: url({{asset('/assets/fonts/Roboto-Thin.ttf')}})
    }

    @font-face {
        font-family: Roboto;
        font-weight: 300;
        src: url({{asset('/assets/fonts/Roboto-Light.ttf')}})
    }

    @font-face {
        font-family: Roboto;
        font-weight: 400;
        src: url({{asset('/assets/fonts/Roboto-Regular.ttf')}})
    }

    @font-face {
        font-family: Roboto;
        font-weight: 500;
        src: url({{asset('/assets/fonts/Roboto-Medium.ttf')}})
    }

    @font-face {
        font-family: Roboto;
        font-weight: 700;
        src: url({{asset('/assets/fonts/Roboto-Bold.ttf')}})
    }

    @font-face {
        font-family: Roboto;
        font-weight: 900;
        src: url({{asset('/assets/fonts/Roboto-Black.ttf')}})
    }

    html, body, body * {
        margin: 0px auto;
        padding: 0px;
        box-sizing: border-box;
        line-height: 100%;
        outline: none;
    }

    html, body {
        height: 100%;
        background-color: #c0c0c0;
    }

    body {
        font-family: Roboto;
        font-size: 11px;
        font-weight: 400;
    }

    h1, h2, h3, h4, h5, h6, p {
        font-weight: 400;
    }

    h1 {
        font-size: 4em;
    }

    h2 {
        font-size: 3em;
    }

    h3 {
        font-size: 2.4em;
    }

    h4 {
        font-size: 2em;
    }

    h5 {
        font-size: 1.6em;
    }

    h6 {
        font-size: 1.2em;
    }

    p {
        font-size: 1em;
    }

    .page {
        width: 210mm;
        min-height: 297mm;
        margin: 0mm auto;
        padding: 10mm;
        background-color: #ffffff;
    }

    .main {
        width: 100%;
        margin: 0px auto;
        position: relative;
        overflow: hidden;
    }

    .div-table {
        display: table;
    }

    .div-col {
        display: table-cell;
        vertical-align: middle;
    }

    .f-100 {
        font-weight: 100;
    }

    .f-300 {
        font-weight: 300;
    }

    .f-400 {
        font-weight: 400;
    }

    .f-500 {
        font-weight: 500;
    }

    .f-700 {
        font-weight: 700;
    }

    .f-900 {
        font-weight: 900;
    }

    .main.header {
        height: 25mm;
    }

    .header.div-table {
        width: 100%;
        min-height: 75px;
    }

    .header.div-col:last-of-type {
        width: 38%;
        padding-right: 2mm;
        border-right: 4px solid #0fa2c1;
    }

    .header-img {
        height: 18mm;
    }

    .header.div-col > h5 {
        line-height: 144%;
        text-align: right;
    }

    .header.div-col > h5 > span {
        display: inline-table;
    }

    .header.div-col > h5 > span:first-of-type {
        width: 40mm;
    }

    .header.div-col > h5 > span:last-of-type {
        width: 24mm;
    }

    .header.div-col > h5:last-of-type > span:last-of-type {
        color: #0fa2c1;
    }

    .main.content {
        height: 200mm;
    }

    .main.content > h4 {
        margin-bottom: 6mm;
    }

    .flight.div-table {
        width: 100%;
    }

    .flight.div-col {
        vertical-align: top;
    }

    .flight-vendor {
        width: 30%;
    }

    .logo-vendor {
        height: 8mm;
        margin-bottom: 2mm;
    }

    .flight-vendor > * {
        line-height: 128%;
    }

    .flight-date {
        width: 50%;
        padding-top: 1mm;
    }

    .flight-date > p {
        height: 5mm;
    }

    .flight-date > p > span {
        color: #888888;
    }

    .flight-time.div-table {
        width: 100%;
    }

    .flight-time.div-table:first-of-type {
        height: 15mm;
    }

    .flight-time.div-col {
        height: 100%;
        position: relative;
        vertical-align: top;
    }

    .flight-time.div-col:first-of-type {
        width: 8mm;
    }

    .flight-time.div-col:nth-of-type(2) {
        width: 8mm;
        text-align: center;
    }

    .flight-time.div-col:nth-of-type(2) > span {
        width: 4mm;
        height: 4mm;
        position: relative;
        border-radius: 50%;
        display: inline-block;
        z-index: 1;
    }

    .span-depart {
        background-color: #0fa2c1;
        border: 1px solid #e6e6e6;
    }

    .span-depart:after {
        width: 1px;
        height: 13mm;
        margin: auto;
        position: absolute;
        top: 108%;
        left: 0px;
        right: 0px;
        background-color: #0fa2c1;
        content: '';
        display: inline-block;
        z-index: 0;
    }

    .span-arrive {
        background-color: #ffffff;
        border: 1px solid #0fa2c1;
    }

    .flight-time.div-col > p {
        line-height: 4mm;
    }

    .flight-terminal {
        color: #888888;
    }

    .flight-bookingid {
        width: 20%;
        padding-top: 1mm;
        text-align: right;
    }

    .flight-bookingid > p {
        margin-top: 5mm;
        line-height: 4mm;
    }

    .flight-bookingid > h5 {
        margin-top: 8px;
        color: #0fa2c1;
    }

    .flight-transit.div-table {
        width: 100%;
        margin: 3mm auto;
    }

    .flight-transit.div-col:first-of-type {
        width: 30%;
    }

    .flight-transit.div-col:last-of-type {
        width: 20%;
    }

    .flight-transit-detail > p {
        width: 72%;
        margin-left: 0px;
        padding: 2px 12px;
        background-color: #e6e6e6;
        border-left: 1px solid #efbf2f;
        border-radius: 6px;
    }

    .flight-transit-detail > p > * {
        vertical-align: middle;
    }

    .icon-transit {
        height: 6mm;
    }

    .flight-transit-detail > p > span:not(.text-transit) {
        width: 4px;
        height: 4px;
        margin-left: 1.5mm;
        margin-right: 2.5mm;
        background-color: #555555;
        border-radius: 50%;
        display: inline-block;
    }

    .text-transit {
        color: #555555;
    }

    .flight-tnc.div-table {
        width: 100%;
        margin: 6mm auto;
        padding: 3mm;
        border-top: 1px solid #e6e6e6;
        border-bottom: 1px solid #e6e6e6;
    }

    .flight-tnc.div-col:first-of-type {
        width: 38%;
    }

    .flight-tnc.div-col:nth-of-type(2) {
        width: 36%;
    }

    .flight-tnc.div-col:last-of-type {
        width: 26%;
    }

    .flight-tnc.div-col > * {
        display: inline-table;
        vertical-align: middle;
    }

    .flight-tnc.div-col > img {
        height: 8mm;
        margin-right: 4mm;
    }

    .flight-tnc.div-col > p {
        line-height: 128%;
    }

    .tnc-boardingpass > p {
        width: 50%;
    }

    .tnc-clock > p {
        width: 37%;
    }

    .tnc-info > p {
        width: 72%;
    }

    .flight-person.div-table {
        width: 100%;
    }

    .flight-person.div-col {
        vertical-align: top;
    }

    .flight-person.div-col:not(.person-name) {
        text-align: center;
    }

    .person-no {
        width: 8%;
    }

    .person-name {
        width: 28%;
    }

    .person-type {
        width: 40%;
    }

    .person-facilities {
        width: 24%;
    }

    .flight-person.div-col > p {
        min-height: 8mm;
    }

    .flight-person.div-col > p > span {
        display: inline-table;
    }

    .flight-person.div-col > p > span:first-of-type {
        width: 36%;
    }

    .flight-person.div-col > p > span:last-of-type {
        width: 24%;
    }

    .main.footer {
        height: 52mm;
        border-top: 1px solid #e6e6e6;
    }

    .footer-top.div-table {
        width: 100%;
    }

    .footer-top.div-col {
        width: 50%;
        padding: 3mm 0mm;
    }

    .footer-top.div-col:last-of-type {
        text-align: right;
    }

    .footer-top.div-col > div {
        display: inline-table;
        vertical-align: middle;
    }

    .footer-top.div-col > div > img {
        height: 14mm;
        margin-right: 4mm;
    }

    .footer-top.div-col p {
        line-height: 176%;
    }

    .footer-bot.div-table {
        width: 100%;
        background-color: #e6e6e6;
    }

    .footer-bot.div-col {
        height: 30mm;
        position: relative;
    }

    .footer-bot.div-col:first-of-type {
        width: 16%;
    }

    .footer-bot.div-col:nth-of-type(3) {
        width: 16%;
    }

    .footer-bot.div-col:last-of-type {
        width: 20%;
    }

    .img-phone {
        height: 90%;
        position: absolute;
        bottom: 0px;
        left: 0px;
    }

    .footer-text > * {
        line-height: 160%;
    }

    .footer-text > h5 {
        margin-bottom: 4px;
    }

    .img-qrcode-blue {
        height: 100%;
    }

    .footer-download > a {
        width: 100%;
        display: block;
    }

    .footer-download > a:last-of-type {
        margin-top: 2mm;
    }

    .footer-download > a > img {
        width: 88%;
        margin-left: 0px;
        display: block;
    }

    @page {
        margin: 0;
        size: A4;
    }

    @media print {
        html, body {
            width: 210mm;
            height: 297mm;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            margin: 0mm auto;
            padding: 10mm;
            background-color: #ffffff;
        }

        .page {
            width: initial;
            min-height: initial;
            margin: 0;
            background-color: initial;
        }

        .pagebreak {
            clear: both;
            page-break-after: always;
        }
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        border: 1px solid black;
    }

    th {
        background-color: #e6e6e6;
        height: 25px;
    }

    td {
        height: 20px;
        padding: 5px;
    }


</style>
<body>
<div class="page">
    <div class="main header">
        <div class="header div-table">
            <div class="header div-col">
                <img class="header-img" src="{{asset('/images/eticket/img-header.png')}}">
            </div>
            <div class="header div-col">
                <h5 class="f-700">E-ticket Flight</h5>
                <h5>This is not a boarding pass</h5>
                <h5>
                    <span>Transaction ID</span>
                    <span>:</span>
                    <span class="f-500">{{$transaction->id}}</span>
                </h5>
            </div>
        </div>
    </div>
    <div class="main content">
        <h4>{{$flight}}</h4>
        <?php $countFlight = count($itineraries); ?>
        @foreach ($itineraries as $i => $itinerary)
            <div class="flight div-table">
                <div class="flight div-col flight-vendor">
                    <img class="logo-vendor" src="{{'https://www.gstatic.com/flights/airline_logos/70px/'.getLogo($itinerary->flight_number).'.png'}}">
                    <h6 class="f-700">{{ acName(substr($itinerary->flight_number,0,2)) }}</h6>
                    <h6>{{$itinerary->flight_number}}</h6>
                    @if($transaction->international)
                        <h6>Subclass {{$itinerary->class}} </h6>
                    @else
                        <h6>Subclass {{$itinerary->class}}
                            ({{getAirlinesClass($itinerary->flight_number,$itinerary->class)}})</h6>
                    @endif
                </div>
                <div class="flight div-col flight-date">
                    <p class="f-500">{{date('l, d M Y',strtotime($itinerary->etd))}}</span></p>
                    <div class="flight-time div-table">
                        <div class="flight-time div-col">
                            <p class="f-500">{{date('H.i',strtotime($itinerary->etd))}}</p>
                        </div>
                        <div class="flight-time div-col">
                            <span class="span-depart"></span>
                        </div>
                        <div class="flight-time div-col">
                            <?php $std = getAirport($itinerary->std); ?>
                            <p class="flight-city f-500">{{$std->city}} ({{$std->id}})</p>
                            <p class="flight-terminal">{{$std->name}}</p>
                        </div>
                    </div>
                    <div class="flight-time div-table">
                        <div class="flight-time div-col">
                            <p class="f-500">{{date('H.i',strtotime($itinerary->eta))}}</p>
                        </div>
                        <div class="flight-time div-col">
                            <span class="span-arrive"></span>
                        </div>
                        <div class="flight-time div-col">
                            <?php $sta = getAirport($itinerary->sta); ?>
                            <p class="flight-city f-500">{{$sta->city}} ({{$sta->id}})</p>
                            <p class="flight-terminal">{{$sta->name}}</p>
                        </div>
                    </div>
                </div>
                <div class="flight div-col flight-bookingid">
                    <p class="f-500">Booking ID</p>
                    <h5 class="f-500">{{ $itinerary->pnr }}</h5>
                </div>
            </div>
            @if($i+1<$countFlight)
                <div class="flight-transit div-table">
                    <div class="flight-transit div-col">
                    </div>
                    <div class="flight-transit div-col flight-transit-detail">
                        <p>
                            <img class="icon-transit" src="{{asset('/images/eticket/icon-transit.png')}}">
                            <span></span>
                            <span class="text-transit f-700">
									<?php
                                $etd = \Carbon\Carbon::createFromFormat('Y-m-d H:i', date('Y-m-d H:i', strtotime($itineraries[$i]->eta)));
                                $eta = \Carbon\Carbon::createFromFormat('Y-m-d H:i', date('Y-m-d H:i', strtotime($itineraries[$i + 1]->etd)));
                                $h = $etd->diffInHours($eta, false);
                                $m = $etd->addHours($h)->diffInMinutes($eta, false);
                                $hShow = $h != "0" ? $h . ' h' : '';
                                $mShow = $m != "0" ? $m . ' m' : '';
                                $showTime = $hShow . ' ' . $mShow;
                                ?>
                                {{$showTime}} transit in {{$sta->city}}
								</span>
                        </p>
                    </div>
                    <div class="flight-transit div-col">
                    </div>
                </div>
            @endif
        @endforeach
        <div class="flight-tnc div-table">
            <div class="flight-tnc div-col tnc-boardingpass">
                <img src="{{asset('/images/eticket/icon-boardingpass.png')}}">
                <p>Show e-ticket and the identity of the passengers at check-in</p>
            </div>
            <div class="flight-tnc div-col tnc-clock">
                <img src="{{asset('/images/eticket/icon-clock.png')}}">
                <p>Check-in <span class="f-900">at least 90 minutes</span> before departure</p>
            </div>
            <div class="flight-tnc div-col tnc-info">
                <img src="{{asset('/images/eticket/icon-info.png')}}">
                <p>All time shown are in local airport time</p>
            </div>
        </div>
        <div class="flight-person div-table">
            <div class="flight-person div-col person-no">
                <p class="f-500">No</p>
            </div>
            <div class="flight-person div-col person-name">
                <p class="f-500">Passenger</p>
            </div>
            <div class="flight-person div-col person-type">
                <p class="f-500">Ticket Type</p>
            </div>
            <div class="flight-person div-col person-facilities">
                <p class="f-500">No. Ticket</p>
            </div>
        </div>
        @foreach ($passengers as $i => $passenger)
            <div class="flight-person div-table">
                <div class="flight-person div-col person-no">
                    <p class="f-500">{{$i+1}}</p>
                </div>
                <div class="flight-person div-col person-name">
                    <p class="f-500">{{$passenger->title}}. {{$passenger->first_name}} {{$passenger->last_name}}</p>
                </div>
                <div class="flight-person div-col person-type">
                    <p class="f-500">{{ $passenger->type_passenger->type }}</p>
                </div>
                <div class="flight-person div-col person-facilities">
                    <p class="f-500">
                        @if($flight == 'Departure Flight')
                            {{$passenger->departure_ticket_number}}
                        @else
                            {{$passenger->return_ticket_number}}
                        @endif
                    </p>
                </div>
            </div>
        @endforeach
    </div>
    <div class="main footer">
        <div class="footer-top div-table">
            <div class="footer-top div-col">
                <div>
                    <img src="{{asset('/images/eticket/icon-support.png')}}">
                </div>
                <div>
                    <p>Customer Service (ID)</p>
                    <p>1500 107</p>
                </div>
            </div>
            <div class="footer-top div-col">
                <p>Email Customer Service</p>
                <p>cs@smartinpays.com</p>
            </div>
        </div>
        <div class="footer-bot div-table">
            <div class="footer-bot div-col">
                <img class="img-phone" src="{{asset('/images/eticket/img-phone.png')}}">
            </div>
            <div class="footer-bot div-col footer-text">
                <h5 class="f-700">No need to print!</h5>
                <p>Get special prices with Smart In Pays Application</p>
                <p>Order and get special promos for Smart In Pays application users</p>
                <p>Scan this QR to download Smart In Pays APP</p>
            </div>
            <div class="footer-bot div-col">
                <img class="img-qrcode-blue" src="{{asset('/images/eticket/img-qrcode-blue.png')}}">
            </div>
            <div class="footer-bot div-col footer-download">
                <a href="#"><img class="btn-playstore" src="{{asset('/images/eticket/btn-playstore.png')}}"></a>
                <a href="#"><img class="btn-appstore" src="{{asset('/images/eticket/btn-appstore.png')}}"></a>
            </div>
        </div>
    </div>
</div>

@if($showPrice)
    <div class="page">
        <div class="main header">
            <div class="header div-table">
                <div class="header div-col">
                    <img class="header-img" src="{{asset('/images/eticket/img-header.png')}}">
                </div>
                <div class="header div-col">
                    <h5 class="f-700">Purchese Detail</h5>
                    <h5>&nbsp;</h5>
                    <h5>
                        <span>Transaction ID</span>
                        <span>:</span>
                        <span class="f-500">{{$transaction->id}}</span>
                    </h5>
                </div>
            </div>
        </div>
        <div class="main content">
            <br/>
            <table>
                <tr>
                    <th>Item Type</th>
                    <th>Description</th>
                    <th>Total Pax</th>
                    <th>Total Rp.</th>
                </tr>
                <?php $totalPaxpaid = 0;
                $bookings = $transaction->bookings;
                ?>
                @foreach($bookings as $booking)
                    <tr>
                        <td>Flight Ticket</td>
                        <td> {{ $booking->airline->name }} {{ $booking->origin }}
                            - {{ $booking->destination }}
                        </td>
                        <td style="text-align: center;"> {{ $transaction->adt + $transaction->chd + $transaction->inf }}</td>
                        <td style="text-align: right;"> {{ number_format($booking->paxpaid) }}</td>
                    </tr>
                    <?php $totalPaxpaid += $booking->paxpaid; ?>
                @endforeach
                <tr>
                    <td style="border: none;">&nbsp;</td>
                    <td style="border: none;">&nbsp;</td>
                    <td>Total</td>
                    <td style="text-align: right;"> {{  number_format($totalPaxpaid) }}</td>
                </tr>
                <tr>
                    <td style="border: none;">&nbsp;</td>
                    <td style="border: none;">&nbsp;</td>
                    <td>Service Fee</td>
                    <td style="text-align: right;">{{ number_format($serviceFee) }}</td>
                </tr>
                <tr>
                    <td style="border: none;">&nbsp;</td>
                    <td style="border: none;">&nbsp;</td>
                    <td>Total Payment</td>
                    <td style="text-align: right;"> {{ number_format($totalPaxpaid + $serviceFee) }}</td>
                </tr>
            </table>
        </div>
        <div class="main footer">
            <div class="footer-top div-table">
                <div class="footer-top div-col">
                    <div>
                        <img src="{{asset('/images/eticket/icon-support.png')}}">
                    </div>
                    <div>
                        <p>Customer Service (ID)</p>
                        <p>1500 107</p>
                    </div>
                </div>
                <div class="footer-top div-col">
                    <p>Email Customer Service</p>
                    <p>cs@smartinpays.com</p>
                </div>
            </div>
            <div class="footer-bot div-table">
                <div class="footer-bot div-col">
                    <img class="img-phone" src="{{asset('/images/eticket/img-phone.png')}}">
                </div>
                <div class="footer-bot div-col footer-text">
                    <h5 class="f-700">No need to print!</h5>
                    <p>Get special prices with Smart In Pays Application</p>
                    <p>Order and get special promos for Smart In Pays application users</p>
                    <p>Scan this QR to download Smart In Pays APP</p>
                </div>
                <div class="footer-bot div-col">
                    <img class="img-qrcode-blue" src="{{asset('/images/eticket/img-qrcode-blue.png')}}">
                </div>
                <div class="footer-bot div-col footer-download">
                    <a href="#"><img class="btn-playstore" src="{{asset('/images/eticket/btn-playstore.png')}}"></a>
                    <a href="#"><img class="btn-appstore" src="{{asset('/images/eticket/btn-appstore.png')}}"></a>
                </div>
            </div>
        </div>
    </div>
@endif
</body>
</html>