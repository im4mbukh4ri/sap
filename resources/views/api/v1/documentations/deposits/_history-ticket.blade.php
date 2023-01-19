<h5>Request</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#reqDepTicketHistory1" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#reqDepTicketHistory2" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="reqDepTicketHistory1" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>POST</td>
            </tr>
            <tr>
                <th>URL</th>
                <td>{{ route('api.deposits_ticket_histories') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="reqDepTicketHistory2" role="tabpanel">
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
            <a class="nav-link waves-light active" data-toggle="tab" href="#resDepTicketHistory1" role="tab">Repsonse Berhasil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resDepTicketHistory2" role="tab">Response Gagal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resDepTicketHistory3" role="tab">Penjelasan</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resDepTicketHistory1" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px">
                <code class="language-markup">
{
  "status": {
    "code": 200,
    "confirm": "success",
    "message": null
  },
  "details": {
    "ticket": [
      {
        "id": 1,
        "sip_bank_id": 1,
        "nominal_request": 2000000,
        "unique_code": 4267,
        "nominal": 2004267,
        "status": "waiting-transfer",
        "note": null,
        "created_at": "2017-01-26 08:57:24",
        "updated_at": "2017-01-26 08:57:24"
      },
      {
        "id": 2,
        "sip_bank_id": 1,
        "nominal_request": 2000000,
        "unique_code": 5531,
        "nominal": 2005531,
        "status": "waiting-transfer",
        "note": null,
        "created_at": "2017-01-26 09:51:58",
        "updated_at": "2017-01-26 09:51:58"
      },
      {
        "id": 3,
        "sip_bank_id": 1,
        "nominal_request": 2000000,
        "unique_code": 7846,
        "nominal": 2007846,
        "status": "waiting-transfer",
        "note": null,
        "created_at": "2017-01-26 09:53:09",
        "updated_at": "2017-01-26 09:53:09"
      }
    ]
  }
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resDepTicketHistory2" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px;">
                <code class="language-markup">
------------------- RESPONSE GAGAL > 31 HARI --------------------------
{
  "status": {
    "code": 400,
    "confirm": "failed",
    "message": [
      "History deposit yang bisa Anda cek maksimal 31 hari."
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
    <div class="tab-pane fade" id="resDepTicketHistory3" role="tabpanel">
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