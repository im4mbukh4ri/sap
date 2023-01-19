<h5>Request</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#reqPulOpt1" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#reqPulOpt2" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="reqPulOpt1" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>POST</td>
            </tr>
            <tr>
                <th>URL</th>
                <td>{{ route('api.pulsa_operators') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="reqPulOpt2" role="tabpanel">
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
            <a class="nav-link waves-light active" data-toggle="tab" href="#resPulOpt1" role="tab">Repsonse Berhasil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resPulOpt2" role="tab">Response Gagal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resPulOpt3" role="tab">Penjelasan</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resPulOpt1" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px">
                <code class="language-markup">
{
  "status": {
    "code": 200,
    "confirm": "failed",
    "message": [
      "Berhasil mendapatkan operator"
    ]
  },
  "details": {
    "operators": [
      {
        "id": 10,
        "name": "Excelcomindo (XL)",
        "code": null,
        "status": 1
      },
      {
        "id": 11,
        "name": "Smartfren",
        "code": null,
        "status": 1
      },
      {
        "id": 12,
        "name": "Esia",
        "code": null,
        "status": 1
      },
      {
        "id": 13,
        "name": "Indosat",
        "code": null,
        "status": 1
      },
      {
        "id": 14,
        "name": "Axis",
        "code": null,
        "status": 1
      },
      {
        "id": 15,
        "name": "Three",
        "code": null,
        "status": 1
      },
      {
        "id": 16,
        "name": "Telkomsel",
        "code": null,
        "status": 1
      },
      {
        "id": 17,
        "name": "Bolt",
        "code": null,
        "status": 1
      }
    ]
  }
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resPulOpt2" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px;">
                <code class="language-markup">
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
    <div class="tab-pane fade" id="resPulOpt3" role="tabpanel">
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