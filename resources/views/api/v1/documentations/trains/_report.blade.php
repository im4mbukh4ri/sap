<h5>Request</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#reqTrainReport1" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#reqTrainReport2" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="reqTrainReport1" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>POST</td>
            </tr>
            <tr>
                <th>URL</th>
                <td>{{ route('api.trains_reports') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="reqTrainReport2" role="tabpanel">
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
            <a class="nav-link waves-light active" data-toggle="tab" href="#resTrainReport1" role="tab">Repsonse Berhasil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resTrainReport2" role="tab">Response Gagal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resTrainReport3" role="tab">Penjelasan</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resTrainReport1" role="tabpanel">
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
      "id": 1380782,
      "created_at": "2017-06-02 12:19:42",
      "updated_at": "2017-06-02 12:19:42",
      "trip_type_id": "R",
      "adt": 1,
      "chd": 0,
      "inf": 0,
      "total_fare": 260000,
      "device": "android",
      "booking": [
        {
          "created_at": "2017-06-02 12:19:42",
          "updated_at": "2017-06-02 12:19:44",
          "train_transaction_id": 1380782,
          "depart_return_id": "d",
          "origin": "BD",
          "destination": "GMR",
          "train_name": "ARGO PARAHYANGAN FAKULTATIF",
          "train_number": "37F",
          "class": "Eksekutif",
          "subclass": "A",
          "etd": "2017-06-12 04:00:00",
          "eta": "2017-06-12 07:09:00",
          "paxpaid": 120000,
          "nta": 95000,
          "nra": 25000,
          "pr": 0,
          "status": "issued",
          "pnr": "XL06QP"
        },
        {
          "created_at": "2017-06-02 12:19:42",
          "updated_at": "2017-06-02 12:19:44",
          "train_transaction_id": 1380782,
          "depart_return_id": "r",
          "origin": "GMR",
          "destination": "BD",
          "train_name": "ARGO PARAHYANGAN",
          "train_number": "20",
          "class": "Eksekutif",
          "subclass": "A",
          "etd": "2017-06-20 05:05:00",
          "eta": "2017-06-20 08:39:00",
          "paxpaid": 140000,
          "nta": 95000,
          "nra": 45000,
          "pr": 0,
          "status": "issued",
          "pnr": "1LGIEW"
        }
      ]
    }
  ]
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resTrainReport2" role="tabpanel">
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
    <div class="tab-pane fade" id="resTrainReport3" role="tabpanel">
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
