<h5>Request</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#reqHotelDetail1" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#reqHotelDetail2" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="reqHotelDetail1" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>POST</td>
            </tr>
            <tr>
                <th>URL</th>
                <td>{{ route('api.hotels_detail') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="reqHotelDetail2" role="tabpanel">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Wajib</th>
                <th>Keterangan</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th>access_token</th>
                <td>YA/TIDAK</td>
                <td>Gunakan akses token yang didapat ketika GET TOKEN. Jika tidak menggunakan parameter ini, maka
                    gunakan "Authorization : Bearer < access_token >" pada header request
                </td>
            </tr>
            <tr>
                <th>client_id</th>
                <td>YA</td>
                <td>client id</td>
            </tr>
            <tr>
                <th>selected_id</th>
                <td>YA</td>
                <td>Selected ID.</td>
            </tr>
            </tbody>
        </table>
    </div>
</div><h5>Response</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#resHotelDetail1" role="tab">Repsonse Berhasil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resHotelDetail2" role="tab">Response Gagal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resHotelDetail3" role="tab">Penjelasan</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resHotelDetail1" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px">
                <code class="language-markup">
{
    "status": {
        "code": 200,
        "confirm": "success",
        "message": [
            "Success search detail hotel"
        ]
    },
    "details": {
        "mmid": "mastersip",
        "selectedID": "318299",
        "checkin": "2017-10-18",
        "checkout": "2017-10-20",
        "des": "WSASIDSRG",
        "room": "1",
        "adt": "2",
        "chd": "0",
        "details": {
            "data": {
                "name": "Dafam Semarang",
                "rating": "4.00",
                "rooms": "100 kamar",
                "address": "Jl. Imam Bonjol 188 Semarang , NONE, South Eastern Asia - Asia",
                "email": "info@dafamsemarang.com",
                "website": null
            },
            "fasilitas": [
                "220 Volt",
                "24 Room Service",
                "Air-condition",
                "Alarm Clock",
                "Babysit",
                "Bar_Lounge",
                "Business Center",
                "Coffee",
                "Concierge",
                "Copy",
                "Creditcard",
                "Fax",
                "Fitness Center",
                "Laundry",
                "Massage",
                "Meeting Rooms",
                "Minibar",
                "Morningcall",
                "Non Smoking Room",
                "Pets Not Allowed",
                "Rent car",
                "Restaurant",
                "Room service",
                "Safe Deposit Box",
                "Smoke Alarm",
                "Spa",
                "Taxi",
                "Teacoffee",
                "Telephone",
                "TV",
                "Valetpark",
                "Water",
                "Wifi"
            ],
            "rooms": [
                {
                    "characteristic": "DELUXE",
                    "bed": "Twin",
                    "board": "Room Only",
                    "price": "890000",
                    "nta": "890000",
                    "selectedIDroom": "44000"
                },
                {
                    "characteristic": "DELUXE",
                    "bed": "Double",
                    "board": "Room Only",
                    "price": "890000",
                    "nta": "890000",
                    "selectedIDroom": "44001"
                },
                {
                    "characteristic": "DELUXE",
                    "bed": "Twin",
                    "board": "Bed and Breakfast",
                    "price": "980000",
                    "nta": "980000",
                    "selectedIDroom": "44002"
                },
                {
                    "characteristic": "DELUXE",
                    "bed": "Double",
                    "board": "Bed and Breakfast",
                    "price": "980000",
                    "nta": "980000",
                    "selectedIDroom": "44003"
                },
                {
                    "characteristic": "TWIN/DOUBLE ROOM - DE LUXE",
                    "bed": "Double",
                    "board": "Room Only",
                    "price": "1023936",
                    "nta": "1023936",
                    "selectedIDroom": "44004"
                },
                {
                    "characteristic": "TWIN/DOUBLE ROOM - DE LUXE",
                    "bed": "Twin",
                    "board": "Room Only",
                    "price": "1023936",
                    "nta": "1023936",
                    "selectedIDroom": "44005"
                },
                {
                    "characteristic": "TWIN/DOUBLE ROOM - DE LUXE",
                    "bed": "Twin",
                    "board": "Breakfast",
                    "price": "1136023",
                    "nta": "1136023",
                    "selectedIDroom": "44006"
                },
                {
                    "characteristic": "TWIN/DOUBLE ROOM - DE LUXE",
                    "bed": "Double",
                    "board": "Breakfast",
                    "price": "1136023",
                    "nta": "1136023",
                    "selectedIDroom": "44007"
                },
                {
                    "characteristic": "EXECUTIVE",
                    "bed": "Double",
                    "board": "Room Only",
                    "price": "1170000",
                    "nta": "1170000",
                    "selectedIDroom": "44008"
                },
                {
                    "characteristic": "EXECUTIVE",
                    "bed": "Twin",
                    "board": "Room Only",
                    "price": "1170000",
                    "nta": "1170000",
                    "selectedIDroom": "44009"
                },
                {
                    "characteristic": "EXECUTIVE",
                    "bed": "Twin",
                    "board": "Bed and Breakfast",
                    "price": "1270000",
                    "nta": "1270000",
                    "selectedIDroom": "44010"
                },
                {
                    "characteristic": "EXECUTIVE",
                    "bed": "Double",
                    "board": "Bed and Breakfast",
                    "price": "1270000",
                    "nta": "1270000",
                    "selectedIDroom": "44011"
                },
                {
                    "characteristic": "TWIN/DOUBLE ROOM - EXECUTIVE",
                    "bed": "Twin",
                    "board": "Breakfast",
                    "price": "1376208",
                    "nta": "1376208",
                    "selectedIDroom": "44012"
                },
                {
                    "characteristic": "TWIN/DOUBLE ROOM - EXECUTIVE",
                    "bed": "Double",
                    "board": "Breakfast",
                    "price": "1376208",
                    "nta": "1376208",
                    "selectedIDroom": "44013"
                },
                {
                    "characteristic": "JUNIOR SUITE",
                    "bed": "Double",
                    "board": "Room Only",
                    "price": "1480000",
                    "nta": "1480000",
                    "selectedIDroom": "44014"
                },
                {
                    "characteristic": "JUNIOR SUITE",
                    "bed": "Twin",
                    "board": "Room Only",
                    "price": "1480000",
                    "nta": "1480000",
                    "selectedIDroom": "44015"
                },
                {
                    "characteristic": "JUNIOR SUITE",
                    "bed": "Double",
                    "board": "Bed and Breakfast",
                    "price": "1570000",
                    "nta": "1570000",
                    "selectedIDroom": "44016"
                },
                {
                    "characteristic": "JUNIOR SUITE",
                    "bed": "Twin",
                    "board": "Bed and Breakfast",
                    "price": "1570000",
                    "nta": "1570000",
                    "selectedIDroom": "44017"
                }
            ],
            "policy": [
                "1. No cancel and no refund"
            ],
            "images": [
                "hotel.mysmartinpays.com/storage/images/dafam-semarang/0XOCGxgdtVh5MP0gE4NrxKnc7jCTnBILXgnBLZuz.jpeg",
                "hotel.mysmartinpays.com/storage/images/dafam-semarang/Uk46LiDD9KVSQbzZrDJlCYXMMobEy7T0xhPFp307.jpeg",
                "hotel.mysmartinpays.com/storage/images/dafam-semarang/NooSHFk0b2rolCqGZdLpSQni1butpDMf0pag0LXX.jpeg",
                "hotel.mysmartinpays.com/storage/images/dafam-semarang/CteSrvRBILhhL7XZUfcCRp5aZQcMQDNKUxrAQiIx.jpeg",
                "hotel.mysmartinpays.com/storage/images/dafam-semarang/q1YVlg9WM4zUQOirCCHdm0qFlbL0F9ImKCrDFSJq.jpeg",
                "hotel.mysmartinpays.com/storage/images/dafam-semarang/RXgL1C0ThzD0n5dJ9wRomSDmJh9Lf27oUarLzqFa.jpeg",
                "hotel.mysmartinpays.com/storage/images/dafam-semarang/ASBtVvxtWgZ7UyWATcDm3zY8iqsxEgtSn6JvTJ0b.jpeg",
                "hotel.mysmartinpays.com/storage/images/dafam-semarang/CPej4rKjM8VhqlcUidowXcv33fRsQV91BTrVK8MZ.jpeg"
            ],
            "promo": null
        }
    }
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resHotelDetail2" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px;">
                <code class="language-markup">

-------------------- RESPONSE GAGAL clinet_id salah -------------------
{
    "status": {
        "code": 400,
        "confirm": "failed",
        "message": [
            "Anda tidak terdaftar",
            "clinet_id tidak ditemukan"
        ]
    }
}
------- RESPONSE GAGAL transaction_id salah / tidak ditemukan ----------
{
  "status": {
    "code": 400,
    "confirm": "failed",
    "message": [
      "transaction_id tidak ditemukan"
    ]
  }
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resHotelDetail3" role="tabpanel">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Keterangan</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th>code</th>
                <td>Kode status response</td>
            </tr>
            <tr>
                <th>confirm</th>
                <td>konfirmasi status response</td>
            </tr>
            <tr>
                <th>message</th>
                <td>Pesan response</td>
            </tr>
            <tr>
                <th>access_token</th>
                <td>Token yang di gunakan untuk request ketika login</td>
            </tr>
            <tr>
                <th>token_type</th>
                <td>Tipe token</td>
            </tr>

            <tr>
                <th>expires_in</th>
                <td>Masa berlaku token (detik)</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
