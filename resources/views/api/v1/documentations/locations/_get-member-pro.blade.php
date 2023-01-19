<h5>Request</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#reqLocation1" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#reqLocation2" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="reqLocation1" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>GET</td>
            </tr>
            <tr>
                <th>URL</th>
                <td>{{ route('api.locations_pro') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="reqLocation2" role="tabpanel">
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
                <th>Authorization</th>
                <td>YA</td>
                <td>Gunakan akses token yang didapat ketika GET TOKEN pada header request "Authorization : Bearer < access_token >"
                </td>
            </tr>
            <tr>
                <th>lat</th>
                <td>YA</td>
                <td>Gunakan lat untuk mengetahui posisi user
                </td>
            </tr>
            <tr>
                <th>lng</th>
                <td>YA</td>
                <td>Gunakan lng untuk mengetahui posisi user
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div><h5>Response</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#resLocation1" role="tab">Response Berhasil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resLocation2" role="tab">Response Gagal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resLocation3" role="tab">Penjelasan</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resLocation1" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px">
                <code class="language-markup">
------- RESPONSE BERHASIL ----------
------- show on map 1 berarti user bisa melihat map lokasi member pro -------
------- show on map 0 berarti user tidak bisa melihat map lokasi member pro -------
{
    "status": {
        "code": 200,
        "confirm": "success",
        "message": null
    },
    "details": [
        {
            "user_id": 1328,
            "show_on_map": 1,
            "lat": "-6.183804",
            "lng": "106.967397",
            "name": "CHRISTOPHER CHIAM",
            "phone": "081211653625",
            "referral": "8ICZB3"
        },
        {
            "user_id": 1327,
            "show_on_map": 0,
            "lat": null,
            "lng": null,
            "name": "trialdev",
            "phone": "085718187373",
            "referral": "3SGJQM"
        }
    ]
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resLocation2" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px;">
                <code class="language-markup">
------- RESPONSE GAGAL tidak ada member pro disekitar lokasi user ----------
{
    "status": {
        "code": 400,
        "confirm": "failed",
        "message": [
            "Tidak ada member disekitar lokasi Anda."
        ]
    }
}
------- RESPONSE GAGAL user tidak memberi izin location pada aplikasi ----------
------- ini terjadi ketka nilai lat dan lng adalah 0 -------
{
    "status": {
        "code": 400,
        "confirm": "failed",
        "message": "GPS di perangkat Anda belum diaktifkan."
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
    <div class="tab-pane fade" id="resLocation3" role="tabpanel">
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
