<h5>Request</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#reqHotelBookingIssued1" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#reqHotelBookingIssued2" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="reqHotelBookingIssued1" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>POST</td>
            </tr>
            <tr>
                <th>URL</th>
                <td>{{ route('api.hotels_booking_issued') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="reqHotelBookingIssued2" role="tabpanel">
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
                <th>des</th>
                <td>YA</td>
                <td>Kode kota tujuan</td>
            </tr>
            <tr>
                <th>checkin</th>
                <td>YA</td>
                <td>Tanggal checkin. Format = yyyy-mm-dd.</td>
            </tr>
            <tr>
                <th>checkout</th>
                <td>YA</td>
                <td>Tanggal checkout. Format = yyyy-mm-dd.</td>
            </tr>
            <tr>
                <th>adt</th>
                <td>YA</td>
                <td>Jumlah tamu dewasa (numeric). <strong>minimal 1</strong>.</td>
            </tr>
            <tr>
                <th>chd</th>
                <td>YA</td>
                <td>Jumlah tamu anak (numeric). <strong>WAJIB 0</strong>.</td>
            </tr>
            <tr>
                <th>room</th>
                <td>YA</td>
                <td>Jumlah kamar (numeric). <strong>minimal 1</strong>.</td>
            </tr>
            <tr>
                <th>title</th>
                <td>YA</td>
                <td>Title tamu, (MR,MRS etc.).</td>
            </tr>
            <tr>
                <th>name</th>
                <td>YA</td>
                <td>Nama tamu.</td>
            </tr>
            <tr>
                <th>phone_number</th>
                <td>YA</td>
                <td>No. HP tamu.</td>
            </tr>
            <tr>
                <th>selected_id</th>
                <td>YA</td>
                <td>selected_id hotel</td>
            </tr>
            <tr>
                <th>bed_{}</th>
                <td>YA</td>
                <td>Di isi selectedIDroom dari detail hotel. <strong>{}</strong>=1 jika room = 1 (bed_1). </td>
            </tr>
            </tbody>
        </table>
    </div>
</div><h5>Response</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#resHotelBookingIssued1" role="tab">Repsonse Berhasil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resHotelBookingIssued2" role="tab">Response Gagal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resHotelBookingIssued3" role="tab">Penjelasan</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resHotelBookingIssued1" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px">
                <code class="language-markup">
{
    "status": {
        "code": 200,
        "confirm": "success",
        "message": "Berhasil create data transaction"
    },
    "details": {
        "id": "1510804",
        "user_id": 2,
        "hotel_id": 18,
        "checkin": "2017-09-27",
        "checkout": "2017-09-28",
        "adt": 1,
        "chd": 0,
        "inf": 0,
        "room": 1,
        "total_fare": 325700,
        "pr": 0,
        "device": "web",
        "updated_at": "2017-09-05 18:26:46",
        "created_at": "2017-09-05 18:26:44",
        "status": "issued",
        "nta": 305700,
        "nra": 20000,
        "hotel": {
            "id": 18,
            "hotel_city_id": "WSASIDBDO",
            "name": "Karang Setra Bandung",
            "rating": 3,
            "address": "Jl. Bungur No. 2, Sukajadi, Sukajadi, 40162 Bandun  , Sukajadi, South Eastern Asia - Asia",
            "email": "frontoffice@karangsetrahotelbandung.com",
            "website": null,
            "url_image": "cdn.infiniqa.com/",
            "created_at": "2017-09-05 18:09:39",
            "updated_at": "2017-09-05 18:09:39"
        }
    }
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resHotelBookingIssued2" role="tabpanel">
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
    <div class="tab-pane fade" id="resHotelBookingIssued3" role="tabpanel">
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
