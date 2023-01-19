<h5>Request</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#reqPpobService1" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#reqPpobService2" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="reqPpobService1" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>POST</td>
            </tr>
            <tr>
                <th>URL</th>
                <td>{{ route('api.ppob_services') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="reqPpobService2" role="tabpanel">
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
            </tbody>
        </table>
    </div>
</div><h5>Response</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#resPpobService1" role="tab">Repsonse Berhasil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resPpobService2" role="tab">Response Gagal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resPpobService3" role="tab">Penjelasan</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resPpobService1" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px">
                <code class="language-markup">
{
  "status": {
    "code": 200,
    "confirm": "success",
    "message": [
      "Berhasil mendapatkan service"
    ]
  },
  "details": [
    {
      "id": 2,
      "name": "PLN Prabayar",
      "code": "PRA",
      "status": 1
    },
    {
      "id": 3,
      "name": "PLN Pascabayar",
      "code": "PAS",
      "status": 1
    },
    {
      "id": 4,
      "name": "Telepon",
      "code": "TLP",
      "status": 1
    },
    {
      "id": 5,
      "name": "Internet",
      "code": "NET",
      "status": 1
    },
    {
      "id": 6,
      "name": "TV Berlangganan",
      "code": "TVK",
      "status": 1
    },
    {
      "id": 7,
      "name": "Multi Finance",
      "code": "MFN",
      "status": 1
    },
    {
      "id": 8,
      "name": "PDAM",
      "code": "PAM",
      "status": 1
    },
    {
      "id": 9,
      "name": "Asuransi",
      "code": "INS",
      "status": 1
    },
    {
      "id": 18,
      "name": "Voucher Games",
      "code": "GAME",
      "status": 0
    }
  ]
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resPpobService2" role="tabpanel">
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
    <div class="tab-pane fade" id="resPpobService3" role="tabpanel">
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