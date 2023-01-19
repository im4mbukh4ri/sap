<h5>Request</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#reqPointHistory1" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#reqPointHistory2" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="reqPointHistory1" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>POST</td>
            </tr>
            <tr>
                <th>URL</th>
                <td>{{ route('api.points_histories') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="reqPointHistory2" role="tabpanel">
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
                <td>Format (yyyy-mm-dd)</td>
            </tr>
            <tr>
                <th>end_date</th>
                <td>YA</td>
                <td>Format (yyyy-mm-dd)</td>
            </tr>
            </tbody>
        </table>
        <sup>*</sup><span style="color:red;">Maksimal 31 hari</span>
    </div>
</div>
<h5>Response</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#resPointHistory1" role="tab">Repsonse Berhasil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resPointHistory2" role="tab">Response Gagal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resPointHistory3" role="tab">Penjelasan</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resPointHistory1" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px">
                <code class="language-markup">
{
  "status": {
    "code": 200,
    "confirm": "success",
    "message": [
      "Berhasil cek history point."
    ]
  },
  "details": {
    "point_histories": [
      {
        "id": 7,
        "user_id": 2,
        "point": 15,
        "debit": 3,
        "credit": 0,
        "note": "airlines|1804638|Issued Sriwijaya Air CGK-DPS (IDBFOK)",
        "created_at": "2017-04-10 13:56:41",
        "updated_at": "2017-04-10 13:56:41"
      },
      {
        "id": 8,
        "user_id": 2,
        "point": 12,
        "debit": 0,
        "credit": 3,
        "note": "airlines|1804638|Gagal Issued Sriwijaya Air CGK-DPS (IDBFOK)",
        "created_at": "2017-04-10 13:56:42",
        "updated_at": "2017-04-10 13:56:42"
      }
    ]
  }
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resPointHistory2" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px;">
                <code class="language-markup">
------------------- RESPONSE GAGAL > 31 HARI --------------------------
{
  "status": {
    "code": 400,
    "confirm": "failed",
    "message": [
      "History point yang bisa Anda cek maksimal 31 hari."
    ]
  }
}
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
    <div class="tab-pane fade" id="resPointHistory3" role="tabpanel">
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
            </tbody>
        </table>
    </div>
</div>