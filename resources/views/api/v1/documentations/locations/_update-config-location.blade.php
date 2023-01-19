<h5>Request</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#reqUpLoc1" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#reqUpLoc2" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="reqUpLoc1" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>POST</td>
            </tr>
            <tr>
                <th>URL</th>
                <td>{{ route('api.locations_config') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="reqUpLoc2" role="tabpanel">
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
                <td>Isi dengan client id user
                </td>
            </tr>
            <tr>
                <th>password</th>
                <td>YA</td>
                <td>Isi dengan input password dari user.
                </td>
            </tr>
            <tr>
                <th>share_location</th>
                <td>YA</td>
                <td>Isi dengan input user 0 atau 1. 0=Tidak, 1=Ya
                </td>
            </tr>
            <tr>
                <th>show_on_map</th>
                <td>YA</td>
                <td>Isi dengan input user 0 atau 1. 0=Tidak, 1=Ya
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div><h5>Response</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#resUpLocation1" role="tab">Response Berhasil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resUpLocation2" role="tab">Response Gagal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resUpLocation3" role="tab">Penjelasan</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resUpLocation1" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px">
                <code class="language-markup">
------- RESPONSE BERHASIL ----------
{
    "status": {
        "code": 200,
        "confirm": "success",
        "message": [
            "Success update location configuration."
        ]
    },
    "details": {
        “_comment”: “Gunakan data share_location dan show_on_map yang diterima untuk tampilan konfigurasi location yang baru”,
        "share_location": "0",
        "show_on_map": "0"
    }
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resUpLocation2" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px;">
                <code class="language-markup">
------- RESPONSE GAGAL client_id tidak ditemukan ----------
{
    "status": {
        "code": 400,
        "confirm": "failed",
        "message": [
            "Client Id tidak ditemukan"
        ]
    }
}
------- RESPONSE GAGAL value share_location bukan 0 atau 1 ----------
{
    "status": {
        "code": 400,
        "confirm": "failed",
        "message": [
            "Value share location harus 0 atau 1. 0 = tidak, 1 = ya"
        ]
    }
}
------- RESPONSE GAGAL value show_on_map bukan 0 atau 1 ----------
{
    "status": {
        "code": 400,
        "confirm": "failed",
        "message": [
            "Value share show_on_map harus 0 atau 1. 0 = tidak, 1 = ya"
        ]
    }
}
------- RESPONSE GAGAL salah password ----------
{
    "status": {
        "code": 400,
        "confirm": "failed",
        "message": [
            "Password anda salah"
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
    <div class="tab-pane fade" id="resUpLocation3" role="tabpanel">
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
