<h5>Request</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#reqAirIssued1" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#reqAirIssued2" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="reqAirIssued1" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>POST</td>
            </tr>
            <tr>
                <th>URL</th>
                <td>{{ route('api.airlines_issued') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="reqAirIssued2" role="tabpanel">
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
                <td>ID Transaksi, Didapat ketika booking</td>
            </tr>
            </tbody>
        </table>
    </div>
</div><h5>Response</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#resIssued1" role="tab">Repsonse Berhasil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resIssued2" role="tab">Response Gagal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resIssued3" role="tab">Penjelasan</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resIsseud1" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px">
                <code class="language-markup">
{
  "status": {
    "code": 200,
    "confirm": "success",
    "message": [
        "Issued berhasil"
    ]
  },
  "details": {
    "transaction": {
      "id": 1730151,
      "user_id": 2,
      "buyer_id": 40,
      "trip_type_id": "R",
      "adt": 1,
      "chd": 0,
      "inf": 0,
      "total_fare": 1174800,
      "created_at": "2017-01-18 16:02:31",
      "updated_at": "2017-01-18 16:02:36",
      "expired": "2017-01-18 19:06:10",
      "deleted_at": null,
      "user": {
        "id": 2,
        "username": "member_silver",
        "name": "Member Silver",
        "email": "silver@sip.com",
        "role": "silver",
        "deposit": "84888119.00",
        "gender": "L",
        "birth_date": "1993-03-04",
        "actived": 1,
        "suspended": 0,
        "upline": 1,
        "login_status": 0,
        "created_at": "2016-10-06 23:00:50",
        "updated_at": "2017-01-18 14:51:03",
        "type_user_id": 2,
        "address_id": 1
      },
      "bookings": [
        {
          "id": 53,
          "airlines_transaction_id": 1730151,
          "airlines_code": "QG",
          "origin": "CGK",
          "destination": "JOG",
          "paxpaid": 1174800,
          "status": "issued",
          "nta": 1124800,
          "nra": 50000,
          "created_at": "2017-01-18 16:02:31",
          "updated_at": "2017-01-18 16:12:34",
          "deleted_at": null,
          "departure_date": "28-01-2017",
          "return_date": "09-02-2017",
          "departure_etd": "28-01-17 13:05",
          "departure_eta": "28-01-17 14:10",
          "return_etd": "09-02-17 14:40",
          "return_eta": "09-02-17 16:10",
          "transaction_commission": {
            "id": 24,
            "airlines_booking_id": 53,
            "nra": 50000,
            "pusat": 25000,
            "bv": 5000,
            "member": 20000,
            "created_at": "2017-01-18 16:02:36",
            "updated_at": "2017-01-18 16:02:36"
          },
          "airline": {
            "code": "QG",
            "name": "Citilink",
            "icon": "QG.png",
            "status": 1
          },
          "itineraries": [
            {
              "id": 88,
              "airlines_booking_id": 53,
              "pnr": "NEVFTG",
              "depart_return_id": "d",
              "leg": 1,
              "flight_number": "QG946",
              "class": "H",
              "std": "CGK",
              "sta": "JOG",
              "etd": "2017-01-28 13:05:00",
              "eta": "2017-01-28 14:10:00",
              "created_at": "2017-01-18 16:02:31",
              "updated_at": "2017-01-18 16:02:37"
            },
            {
              "id": 89,
              "airlines_booking_id": 53,
              "pnr": "NEVFTG",
              "depart_return_id": "r",
              "leg": 1,
              "flight_number": "QG947",
              "class": "M",
              "std": "JOG",
              "sta": "CGK",
              "etd": "2017-02-09 14:40:00",
              "eta": "2017-02-09 16:10:00",
              "created_at": "2017-01-18 16:02:31",
              "updated_at": "2017-01-18 16:02:37"
            }
          ],
          "transaction_number": {
            "id": 30,
            "airlines_booking_id": 53,
            "transaction_number": "AIR170118237918"
          }
        }
      ]
    },
    "booking": [
      {
        "id": 53,
        "airlines_transaction_id": 1730151,
        "airlines_code": "QG",
        "origin": "CGK",
        "destination": "JOG",
        "paxpaid": 1174800,
        "status": "issued",
        "nta": 1124800,
        "nra": 50000,
        "created_at": "2017-01-18 16:02:31",
        "updated_at": "2017-01-18 16:12:34",
        "deleted_at": null,
        "departure_date": "28-01-2017",
        "return_date": "09-02-2017",
        "departure_etd": "28-01-17 13:05",
        "departure_eta": "28-01-17 14:10",
        "return_etd": "09-02-17 14:40",
        "return_eta": "09-02-17 16:10",
        "transaction_commission": {
          "id": 24,
          "airlines_booking_id": 53,
          "nra": 50000,
          "pusat": 25000,
          "bv": 5000,
          "member": 20000,
          "created_at": "2017-01-18 16:02:36",
          "updated_at": "2017-01-18 16:02:36"
        },
        "airline": {
          "code": "QG",
          "name": "Citilink",
          "icon": "QG.png",
          "status": 1
        },
        "itineraries": [
          {
            "id": 88,
            "airlines_booking_id": 53,
            "pnr": "NEVFTG",
            "depart_return_id": "d",
            "leg": 1,
            "flight_number": "QG946",
            "class": "H",
            "std": "CGK",
            "sta": "JOG",
            "etd": "2017-01-28 13:05:00",
            "eta": "2017-01-28 14:10:00",
            "created_at": "2017-01-18 16:02:31",
            "updated_at": "2017-01-18 16:02:37"
          },
          {
            "id": 89,
            "airlines_booking_id": 53,
            "pnr": "NEVFTG",
            "depart_return_id": "r",
            "leg": 1,
            "flight_number": "QG947",
            "class": "M",
            "std": "JOG",
            "sta": "CGK",
            "etd": "2017-02-09 14:40:00",
            "eta": "2017-02-09 16:10:00",
            "created_at": "2017-01-18 16:02:31",
            "updated_at": "2017-01-18 16:02:37"
          }
        ],
        "transaction_number": {
          "id": 30,
          "airlines_booking_id": 53,
          "transaction_number": "AIR170118237918"
        }
      }
    ]
  }
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resIssued2" role="tabpanel">
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
    <div class="tab-pane fade" id="resIssued3" role="tabpanel">
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
