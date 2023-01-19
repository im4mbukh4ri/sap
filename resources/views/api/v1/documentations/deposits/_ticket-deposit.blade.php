<h5>Request</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#reqDepTicket1" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#reqDepTicket2" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="reqDepTicket1" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>POST</td>
            </tr>
            <tr>
                <th>URL</th>
                <td>{{ route('api.deposits_ticket') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="reqDepTicket2" role="tabpanel">
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
                <th>nominal</th>
                <td>YA</td>
                <td>Nominal deposit</td>
            </tr>
            <tr>
                <th>bank_id</th>
                <td>YA</td>
                <td>ID rekening bank di list bank.</td>
            </tr>
            <tr>
                <th>note</th>
                <td>TIDAK</td>
                <td>Tambahan catatan (opsional).</td>
            </tr>
            </tbody>
        </table>
    </div>
</div><h5>Response</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#resDepTicket1" role="tab">Repsonse Berhasil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resDepTicket2" role="tab">Response Gagal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resDepTicket3" role="tab">Penjelasan</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resDepTicket1" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px">
                <code class="language-markup">
{
  "status": {
    "code": 200,
    "confirm": "success",
    "message": [
      "Tiket deposit berhasil"
    ]
  },
  "details": {
    "ticket": {
      "nominal_request": "2000000",
      "unique_code": 5531,
      "nominal": 2005531,
      "sip_bank_id": "1",
      "note": null,
      "updated_at": "2017-01-26 09:51:58",
      "created_at": "2017-01-26 09:51:58",
      "id": 2
    }
  }
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resDepTicket2" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px;">
                <code class="language-markup">
------------------- RESPONSE GAGAL LEBIH DARI 3 KALI ------------------
{
  "status": {
    "code": 400,
    "confirm": "failed",
    "message": [
      "Tiket deposit gagal. Anda telah melakukan tiket deposit 3X hari ini. Untuk melakukan tiket deposit lagi. Silahkan lakukan transfer untuk tiket sebelumnya."
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
    <div class="tab-pane fade" id="resDepTicket3" role="tabpanel">
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
                <th>nominal_request</th>
                <td>nominal ketika request</td>
            </tr>
            <tr>
                <th>unique_code</th>
                <td>Kode unik</td>
            </tr>
            <tr>
                <th>nominal</th>
                <td>Nominal yang harus di transfer</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>