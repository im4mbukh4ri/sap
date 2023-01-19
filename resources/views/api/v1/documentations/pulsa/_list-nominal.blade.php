<h5>Request</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#reqPulNom1" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#reqPulNom2" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="reqPulNom1" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>POST</td>
            </tr>
            <tr>
                <th>URL</th>
                <td>{{ route('api.pulsa_nominal') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="reqPulNom2" role="tabpanel">
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
                <th>operator_id</th>
                <td>YA</td>
                <td>Didapat dari id list operator</td>
            </tr>
            </tbody>
        </table>
    </div>
</div><h5>Response</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#resPulNom1" role="tab">Repsonse Berhasil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resPulNom2" role="tab">Response Gagal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resPulNom3" role="tab">Penjelasan</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resPulNom1" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px">
                <code class="language-markup">
{
  "status": {
    "code": 200,
    "confirm": "success",
    "message": [
      "Berhasil mendapatkan nominal"
    ]
  },
  "details": {
    "nominal": [
      {
        "id": 137,
        "name": "IM3 Reguler Rp 5.000",
        "code": "BI5",
        "status": 1
      },
      {
        "id": 138,
        "name": "IM3 Reguler Rp 10.000",
        "code": "BI10",
        "status": 1
      },
      {
        "id": 139,
        "name": "IM3 Reguler Rp 25.000",
        "code": "BI25",
        "status": 1
      },
      {
        "id": 140,
        "name": "IM3 Reguler Rp 50.000",
        "code": "BI50",
        "status": 1
      },
      {
        "id": 141,
        "name": "IM3 Reguler Rp 100.000",
        "code": "BI100",
        "status": 1
      },
      {
        "id": 142,
        "name": "IM3 SMS Rp 5.000",
        "code": "BIS5",
        "status": 1
      },
      {
        "id": 143,
        "name": "IM3 SMS Rp 10.000",
        "code": "BIS10",
        "status": 1
      },
      {
        "id": 144,
        "name": "IM3 SMS Rp 25.000",
        "code": "BIS25",
        "status": 1
      },
      {
        "id": 145,
        "name": "Mentari Reguler Rp 5.000",
        "code": "BM5",
        "status": 1
      },
      {
        "id": 146,
        "name": "Mentari Reguler Rp 10.000",
        "code": "BM10",
        "status": 1
      },
      {
        "id": 147,
        "name": "Mentari Reguler Rp 25.000",
        "code": "BM25",
        "status": 1
      },
      {
        "id": 148,
        "name": "Mentari Reguler Rp 50.000",
        "code": "BM50",
        "status": 1
      },
      {
        "id": 149,
        "name": "Mentari Reguler Rp 100.000",
        "code": "BM100",
        "status": 1
      },
      {
        "id": 150,
        "name": "Mentari SMS Rp 5.000",
        "code": "BMS5",
        "status": 1
      },
      {
        "id": 151,
        "name": "Mentari SMS Rp 10.000",
        "code": "BMS10",
        "status": 1
      },
      {
        "id": 152,
        "name": "Mentari SMS Rp 25.000",
        "code": "BMS25",
        "status": 1
      },
      {
        "id": 153,
        "name": "Indosat Data 1GB",
        "code": "ID1",
        "status": 1
      },
      {
        "id": 154,
        "name": "Indosat Data 2GB",
        "code": "ID2",
        "status": 1
      },
      {
        "id": 155,
        "name": "Indosat Data 3GB",
        "code": "ID3",
        "status": 1
      },
      {
        "id": 156,
        "name": "Indosat Data 4GB",
        "code": "ID4",
        "status": 1
      },
      {
        "id": 157,
        "name": "Indosat Data 3GB",
        "code": "ID45",
        "status": 1
      },
      {
        "id": 158,
        "name": "Indosat Data 5GB",
        "code": "ID5",
        "status": 1
      }
    ]
  }
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resPulNom2" role="tabpanel">
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
    <div class="tab-pane fade" id="resPulNom3" role="tabpanel">
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