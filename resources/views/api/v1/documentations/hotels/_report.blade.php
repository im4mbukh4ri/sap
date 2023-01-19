<h5>Request</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#reqHotelReport1" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#reqHotelReport2" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="reqHotelReport1" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>POST</td>
            </tr>
            <tr>
                <th>URL</th>
                <td>{{ route('api.hotels_reports') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="reqHotelReport2" role="tabpanel">
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
                <th>clinet_id</th>
                <td>YA</td>
                <td>clinet id</td>
            </tr>
            <tr>
                <th>start_date</th>
                <td>YA</td>
                <td>Tanggal Awal (yyyy-mm-dd)</td>
            </tr>

            <tr>
                <th>end_date</th>
                <td>YA</td>
                <td>Tanggal Akhir (yyyy-mm-dd)</td>
            </tr>
            </tbody>
        </table>
    </div>
</div><h5>Response</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#resHotelReport1" role="tab">Repsonse Berhasil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resHotelReport2" role="tab">Response Gagal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resHotelReport3" role="tab">Penjelasan</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resHotelReport1" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px">
                <code class="language-markup">
{
    "status": {
        "code": 200,
        "confirm": "success",
        "message": [
            "Berhasil mendapatkan report"
        ]
    },
    "details": [
        {
            "id": 1502463,
            "created_at": "2017-08-30 21:14:23",
            "updated_at": "2017-08-30 21:14:25",
            "user_id": 1327,
            "hotel_id": 16,
            "checkin": "2017-09-27",
            "checkout": "2017-09-28",
            "adt": 1,
            "chd": 0,
            "inf": 0,
            "room": 1,
            "total_fare": 529366,
            "nta": 509366,
            "nra": 20000,
            "pr": 0,
            "status": "issued",
            "device": "web",
            "hotel_name": "Hotel 81 Princess"
        },
        {
            "id": 1556206,
            "created_at": "2017-08-28 07:50:06",
            "updated_at": "2017-08-28 07:50:08",
            "user_id": 1327,
            "hotel_id": 7,
            "checkin": "2017-08-29",
            "checkout": "2017-08-30",
            "adt": 1,
            "chd": 0,
            "inf": 0,
            "room": 1,
            "total_fare": 220000,
            "nta": 200000,
            "nra": 20000,
            "pr": 0,
            "status": "issued",
            "device": "web",
            "hotel_name": "Lotus Hotel Bandung"
        },
        {
            "id": 1556783,
            "created_at": "2017-08-28 07:59:43",
            "updated_at": "2017-08-28 07:59:44",
            "user_id": 1327,
            "hotel_id": 13,
            "checkin": "2017-08-28",
            "checkout": "2017-08-29",
            "adt": 4,
            "chd": 0,
            "inf": 0,
            "room": 1,
            "total_fare": 1355367,
            "nta": 1335367,
            "nra": 20000,
            "pr": 0,
            "status": "issued",
            "device": "web",
            "hotel_name": "Bounty"
        },
        {
            "id": 1557793,
            "created_at": "2017-08-28 08:16:33",
            "updated_at": "2017-08-28 08:16:36",
            "user_id": 1327,
            "hotel_id": 15,
            "checkin": "2017-08-28",
            "checkout": "2017-08-29",
            "adt": 1,
            "chd": 0,
            "inf": 0,
            "room": 2,
            "total_fare": 1690000,
            "nta": 805000,
            "nra": 885000,
            "pr": 0,
            "status": "issued",
            "device": "web",
            "hotel_name": "Favehotel MT Haryono"
        }
    ]
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resHotelReport2" role="tabpanel">
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
------- RESPONSE GAGAL access_token salah (Authorization) ----------
{
  "status": {
    "code": 400,
    "confirm": "failed",
    "message": [
      "access_denied",
      "The resource owner or authorization server denied the request."
    ]
  }
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resHotelReport3" role="tabpanel">
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
                <th></th>
            </tr>
            </tbody>
        </table>
    </div>
</div>
