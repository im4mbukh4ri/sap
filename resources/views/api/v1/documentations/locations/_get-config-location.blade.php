<h5>Request</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#reqConfLocation1" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#reqConfLocation2" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="reqConfLocation1" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>POST</td>
            </tr>
            <tr>
                <th>URL</th>
                <td>{{route('api.locations_config')}}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="reqConfLocation2" role="tabpanel">
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
              <td>share_location</td>
              <td>YA</td>
              <td>value 0 atau 1. 0 = false (lokasi user tidak di share / tidak ditampilkan di map). 1 = true (lokasi user di share / ditampilkan di map) </td>
            </tr>
            <tr>
              <td>share_location</td>
              <td>YA</td>
              <td>value 0 atau 1. 0 = false (lokasi user tidak di share / tidak ditampilkan di map). 1 = true (lokasi user di share / ditampilkan di map) </td>
            </tr>
            </tbody>
        </table>
    </div>
</div><h5>Response</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#resConfLocation1" role="tab">Response Berhasil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resConfLocation2" role="tab">Response Gagal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resConfLocation3" role="tab">Penjelasan</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resConfLocation1" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px">
                <code class="language-markup">
------- RESPONSE BERHASIL ----------
------- update response Login dan Refresh Token -------
{
    "status": {
        "code": 200,
        "confirm": "success",
        "message": [
            "Login berhasil."
        ]
    },
    "details": {
        "token": {
            //some data
        },
        "user": {
            //some data
        },
        "referral": "3SGJQM",
        "upline": {
            //some data
        },
        "config": {
            "AIRLINES": [
                //some data
            ],
            "PPOB": [
                //some data
            ],
            "KAI": "CLOSE",
            "BUS": "CLOSE",
            "HOTEL": "CLOSE",
            “_comment”: “For except PRO users”,
            “LOCATIONS”: “CLOSE”,
            “_comment”:”For PRO users”,
            "LOCATIONS": {
                "android": {
                    "share_location": 0,
                    "show_on_map": 0
                },
                "ios": {
                    "share_location": 1,
                    "show_on_map": 0
                }
            }
        },
        "banners": [
            {
                "id": 6,
                "file_name": "mobile-slider-2.jpg",
                "url_banner": "https://mysmartinpays.com/images/banners/mobile/mobile-slider-2.jpg",
                "status": 1,
                "created_at": "2017-02-20 19:10:00"
            },
            ...
            ...
            ...
            dan seterusnya

                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resConfLocation2" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px;">
                <code class="language-markup">
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resConfLocation3" role="tabpanel">
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
