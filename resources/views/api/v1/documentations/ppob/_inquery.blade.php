<h5>Request</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#reqPpobInquery1" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#reqPpobInquery2" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="reqPpobInquery1" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>POST</td>
            </tr>
            <tr>
                <th>URL</th>
                <td>{{ route('api.ppob_inquery') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="reqPpobInquery2" role="tabpanel">
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
                <th>service_id</th>
                <td>YA</td>
                <td>ID service, value : PLN,TLP,NET,TVK,MFN,PAM,INS</td>
            </tr>
            <tr>
                <th>product_id</th>
                <td>YA</td>
                <td>ID Produk, ( PLN PASCABAYAR product_id = PAS, PLN PRABAYAR = PLA20 dst. )</td>
            </tr>
            <tr>
                <th>number</th>
                <td>YA</td>
                <td>No. Pelanggan</td>
            </tr>
            <tr>
                <th>client_id</th>
                <td>YA</td>
                <td>Client ID</td>
            </tr>
            </tbody>
        </table>
    </div>
</div><h5>Response</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#resPpobInquery1" role="tab">Repsonse Berhasil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resPpobInquery2" role="tab">Response Gagal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resPpobInquery3" role="tab">Penjelasan</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resPpobInquery1" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px">
                <code class="language-markup">
{
  "status": {
    "code": 200,
    "confirm": "success",
    "message": [
      "Berhasil inquery"
    ]
  },
  "details": {
    "inquery": {
      "error_code": "000",
      "error_msg": "",
      "noid": "0001457614258",
      "nama": "MOCH RAMDHANIE MUBARA(PST:  4)",
      "bill_qty": "1",
      "nominal": "1632000",
      "admin": "2500",
      "nra": "1000",
      "price": "1637000",
      "commission": 790
    }
  }
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resPpobInquery2" role="tabpanel">
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
    <div class="tab-pane fade" id="resPpobInquery3" role="tabpanel">
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