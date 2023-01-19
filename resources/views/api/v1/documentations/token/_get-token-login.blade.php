<p>
  Untuk melakukan registrasi member dan reset password diperlukan token untuk dapet mengakses URL registrasi dan reset password.
</p>
<p>
    Sebelum melakukan request untuk login, Diperlukan token untuk dapat mengakses URL login dengan mengirimkan
    parameter login yang diperlukan.
</p>
<h5>Request</h5>
<!-- Nav tabs -->
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#panel51" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#panel52" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="panel51" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>GET</td>
            </tr>
            <tr>
                <th>URL</th>
                <td>{{ route('api.token_getlogin') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="panel52" role="tabpanel">
        Tidak ada parameter yang dikirim
    </div>
</div>
<h5>Response</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#resToken1" role="tab">Repsonse Berhasil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resToken2" role="tab">Response Gagal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resToken3" role="tab">Penjelasan</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resToken1" role="tabpanel">
            <pre class="code-toolbar">
                <code class="language-markup">
{
    "status": {
        "code": 200,
        "confirm": "success",
        "message": [
            "Success get token login."
        ]
    },
    "details": {
        "token": {
            "access_token": "y4qDbQC3oUXZQbteiUZlWNyOFGiwYsAvPpYzWylT",
            "token_type": "Bearer",
            "expires_in": 3600
        }
    }
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resToken2" role="tabpanel">
            <pre class="code-toolbar">
                <code class="language-markup">
{
    "status": {
        "code": 400,
        "confirm": "failed",
        "message": [
            "Failed get token login."
        ]
    },
    "details": {}
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resToken3" role="tabpanel">
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
                <th>access_token</th>
                <td>Token yang di gunakan untuk request ketika login</td>
            </tr>
            <tr>
                <th>token_type</th>
                <td>Tipe token</td>
            </tr>

            <tr>
                <th>expires_in</th>
                <td>Masa berlaku token (detik)</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
