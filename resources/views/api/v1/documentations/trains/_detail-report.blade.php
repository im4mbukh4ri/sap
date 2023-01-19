<h5>Request</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#reqTrainReportDetail1" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#reqTrainReportDetail2" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="reqTrainReportDetail1" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>POST</td>
            </tr>
            <tr>
                <th>URL</th>
                <td>{{ route('api.trains_reports_detail') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="reqTrainReportDetail2" role="tabpanel">
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
            <a class="nav-link waves-light active" data-toggle="tab" href="#resTrainReportDetail1" role="tab">Repsonse Berhasil</a>
<pre>

</pre>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resTrainReportDetail2" role="tab">Response Gagal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resTrainReportDetail3" role="tab">Penjelasan</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resTrainReportDetail1" role="tabpanel">
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
            "id": 1361370,
            "created_at": "2017-08-31 13:36:10",
            "updated_at": "2017-08-31 13:36:10",
            "sip_service_id": 3,
            "trip_type_id": "O",
            "adt": 1,
            "chd": 0,
            "inf": 0,
            "total_fare": 307500,
            "device": "ios",
            "booking": [
                {
                    "created_at": "2017-08-31 13:36:10",
                    "updated_at": "2017-08-31 13:36:12",
                    "train_transaction_id": 1361370,
                    "depart_return_id": "d",
                    "origin": "PSE",
                    "destination": "MN",
                    "train_name": "SINGASARI",
                    "train_number": "156",
                    "class": "Ekonomi",
                    "subclass": "C",
                    "etd": "2017-09-02 12:25:00",
                    "eta": "2017-09-03 00:26:00",
                    "paxpaid": 300000,
                    "nta": 95000,
                    "nra": 212500,
                    "pr": 0,
                    "admin": 7500,
                    "status": "issued",
                    "pnr": "E17DOM"
                }
            ],
            "passengers": [
                {
                    "id": 659,
                    "created_at": "2017-08-31 13:36:10",
                    "updated_at": "2017-08-31 13:36:10",
                    "train_transaction_id": 1361370,
                    "name": "Rosyad Irmi",
                    "type": "adt",
                    "identity_number": "1390903523",
                    "phone": "098789",
                    "seat": {
                        "departure": {
                            "wagon_code": "EKO",
                            "wagon_number": "3",
                            "seat": "12A"
                        }
                    }
                }
            ],
            "buyer": {
                "name": "Rosyad",
                "email": "rosyad@mail.com",
                "phone": "0987890"
            }
        }
    }
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resTrainReportDetail2" role="tabpanel">
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
    <div class="tab-pane fade" id="resTrainReportDetail3" role="tabpanel">
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
