<h5>Request</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#reqAirReport1" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#reqAirReport2" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="reqAirReport1" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>POST</td>
            </tr>
            <tr>
                <th>URL</th>
                <td>{{ route('api.airlines_reports') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="reqAirReport2" role="tabpanel">
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
                <td>Client id yang didapat ketika login</td>
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
            <a class="nav-link waves-light active" data-toggle="tab" href="#resReport1" role="tab">Repsonse Berhasil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resReport2" role="tab">Response Gagal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resReport3" role="tab">Penjelasan</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resReport1" role="tabpanel">
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
      "id": 1423968,
      "user_id": 2,
      "buyer_id": 5,
      "trip_type_id": "R",
      "adt": 1,
      "chd": 0,
      "inf": 0,
      "total_fare": 3015600,
      "created_at": "2017-01-03 13:12:48",
      "updated_at": "2017-01-03 13:12:55",
      "expired": "2017-01-03 16:16:09",
      "status": "booking",
      "origin": "CGK",
      "destination": "DPS"
    },
    {
      "id": 1519942,
      "user_id": 2,
      "buyer_id": 6,
      "trip_type_id": "O",
      "adt": 1,
      "chd": 0,
      "inf": 0,
      "total_fare": 428000,
      "created_at": "2017-01-04 15:52:22",
      "updated_at": "2017-01-04 15:52:27",
      "expired": "2017-01-04 18:55:42",
      "status": "booking",
      "origin": "CGK",
      "destination": "JOG"
    },
    {
      "id": 1521890,
      "user_id": 2,
      "buyer_id": 7,
      "trip_type_id": "R",
      "adt": 1,
      "chd": 0,
      "inf": 0,
      "total_fare": 2107000,
      "created_at": "2017-01-04 16:24:50",
      "updated_at": "2017-01-04 16:24:55",
      "expired": "2017-01-04 19:28:10",
      "status": "booking",
      "origin": "CGK",
      "destination": "DPS"
    }
  ]
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resReport2" role="tabpanel">
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
    <div class="tab-pane fade" id="resReport3" role="tabpanel">
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
