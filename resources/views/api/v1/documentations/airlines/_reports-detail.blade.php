<h5>Request</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#reqAirReportDetail1" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#reqAirReportDetail2" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="reqAirReportDetail1" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>POST</td>
            </tr>
            <tr>
                <th>URL</th>
                <td>{{ route('api.airlines_reports_detail') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="reqAirReportDetail2" role="tabpanel">
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
                <th>transaction_id</th>
                <td>YA</td>
                <td>ID Transaksi</td>
            </tr>
            </tbody>
        </table>
    </div>
</div><h5>Response</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#resReportDetail1" role="tab">Repsonse Berhasil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resReportDetail2" role="tab">Response Gagal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resReportDetail3" role="tab">Penjelasan</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resReportDetail1" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px">
                <code class="language-markup">
{
  "status": {
    "code": 200,
    "confirm": "success",
    "message": [
      "Berhasil mendapatkan detail report"
    ]
  },
  "details": {
    "transactions": {
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
      "destination": "DPS",
      "booking": [
        {
          "id": 7,
          "airlines_transaction_id": 1521890,
          "airlines_code": "GA",
          "origin": "CGK",
          "destination": "DPS",
          "paxpaid": 2107000,
          "status": "booking",
          "nta": 2057000,
          "nra": 50000,
          "deleted_at": null,
          "departure_date": "18-04-2017",
          "return_date": "21-04-2017",
          "departure_etd": "18-04-17 07:15",
          "departure_eta": "18-04-17 10:10",
          "return_etd": "21-04-17 07:05",
          "return_eta": "21-04-17 07:45",
          "itineraries": [
            {
              "id": 12,
              "airlines_booking_id": 7,
              "pnr": "ZACRKM",
              "depart_return_id": "d",
              "leg": 1,
              "flight_number": "GA438",
              "class": "V",
              "std": "CGK",
              "sta": "DPS",
              "etd": "2017-04-18 07:15:00",
              "eta": "2017-04-18 10:10:00"
            },
            {
              "id": 13,
              "airlines_booking_id": 7,
              "pnr": "ZACRKM",
              "depart_return_id": "r",
              "leg": 1,
              "flight_number": "GA401",
              "class": "S",
              "std": "DPS",
              "sta": "CGK",
              "etd": "2017-04-21 07:05:00",
              "eta": "2017-04-21 07:45:00"
            }
          ]
        }
      ],
      "passengers": [
        {
          "id": 7,
          "airlines_transaction_id": 1521890,
          "type": "adt",
          "title": "MR",
          "first_name": "dhanie",
          "last_name": "aja",
          "birth_date": "0000-00-00",
          "national": "Indonesia"
        }
      ],
      "buyer": {
        "id": 7,
        "name": "Risky",
        "email": "cobaemail@sip.com",
        "phone": "085718187373"
      }
    }
  }
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resReportDetail2" role="tabpanel">
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
    <div class="tab-pane fade" id="resReportDetail3" role="tabpanel">
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
