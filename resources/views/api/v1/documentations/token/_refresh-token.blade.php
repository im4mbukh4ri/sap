<p> GET AKSES / Refresh token berfungsi untuk memperbaharui akses token</p>
<h5>Request</h5>
<!-- Nav tabs -->
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#reqAccess1" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#reqAccess2" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="reqAccess1" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>POST</td>
            </tr>
            <tr>
                <th>URL</th>
                <td>{{ route('api.token_access') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="reqAccess2" role="tabpanel">
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
                <th>grant_type</th>
                <td>YA</td>
                <td>value = refresh_token</td>
            </tr>
            <tr>
                <th>client_id</th>
                <td>YA</td>
                <td>client id yang di dapat ketika login.</td>
            </tr>
            <tr>
                <th>client_secret</th>
                <td>YA</td>
                <td>client secret yang didapat ketika login.</td>
            </tr>
            <tr>
                <th>refresh_token</th>
                <td>YA</td>
                <td>refresh_token terakhir yang di dapat.</td>
            </tr>
            <tr>
                <th>version</th>
                <td>YA</td>
                <td>value = versi aplikasi</td>
            </tr>
            <tr>
                <th>lat</th>
                <td>YA</td>
                <td>Titik latitude user.</td>
            </tr>
            <tr>
                <th>lng</th>
                <td>YA</td>
                <td>Titik longitude user</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<h5>Response</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#resAccess1" role="tab">Repsonse Berhasil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resAccess2" role="tab">Response Gagal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resAccess3" role="tab">Penjelasan</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resAccess1" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px;">
                <code class="language-markup">
{
    "status": {
        "code": 200,
        "confirm": "success",
        "message": [
            "Refresh token berhasil"
        ]
    },
    "details": {
        "token": {
            "access_token": "NS1KHwfclJQNQMZErZQ0pHc9HoEN7Eb3w1pZXu1N",
            "token_type": "Bearer",
            "expires_in": 3600,
            "refresh_token": "XtAS4F4oSZJOegOe81tpauMUBEGg846DQpEqSU0l",
            "client_id": "z2vjsy7F6AwPoTOuEqRbPtCcKbgWusneLiaNmfVo",
            "client_secret": "RBbtfEvlGeWqmkKPxblY2b11ufXa8T7LaIQOT3Rq"
        },
        "user": {
            "id": 3,
            "username": "member_gold",
            "name": "Member Gold",
            "email": "gold@sip.com",
            "role": "gold",
            "deposit": "1300000.00",
            "gender": "L",
            "birth_date": "1993-03-04",
            "actived": "1",
            "suspended": "0",
            "upline": "1",
            "login_status": "0",
            "created_at": "2016-10-06 23:00:50",
            "updated_at": "2017-01-06 13:56:52",
            "type_user_id": "3",
            "address_id": "1"
        },
        "config": {
            "AIRLINES": [
                {
                    "product": "GA",
                    "status": "OPEN"
                },
                {
                    "product": "ID",
                    "status": "OPEN"
                },
                {
                    "product": "IL",
                    "status": "OPEN"
                },
                {
                    "product": "IN",
                    "status": "OPEN"
                },
                {
                    "product": "IW",
                    "status": "OPEN"
                },
                {
                    "product": "JT",
                    "status": "OPEN"
                },
                {
                    "product": "KD",
                    "status": "OPEN"
                },
                {
                    "product": "MV",
                    "status": "OPEN"
                },
                {
                    "product": "QG",
                    "status": "OPEN"
                },
                {
                    "product": "QZ",
                    "status": "OPEN"
                },
                {
                    "product": "SJ",
                    "status": "OPEN"
                }
            ],
            "PPOB": [
                {
                    "product": "PUL",
                    "status": "OPEN"
                },
                {
                    "product": "PRA",
                    "status": "OPEN"
                },
                {
                    "product": "PAS",
                    "status": "OPEN"
                },
                {
                    "product": "TLP",
                    "status": "OPEN"
                },
                {
                    "product": "NET",
                    "status": "OPEN"
                },
                {
                    "product": "TVK",
                    "status": "OPEN"
                },
                {
                    "product": "MFN",
                    "status": "OPEN"
                },
                {
                    "product": "PAM",
                    "status": "OPEN"
                },
                {
                    "product": "INS",
                    "status": "OPEN"
                },
                {
                    "product": "GAME",
                    "status": "CLOSE"
                }
            ],
            "KAI": "CLOSE",
            "BUS": "CLOSE",
            "HOTEL": "CLOSE"
        }
    }
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resAccess2" role="tabpanel">
            <pre class="code-toolbar">
                <code class="language-markup">
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
    <div class="tab-pane fade" id="resAccess3" role="tabpanel">
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
                <td>Token terbaru. Token yang di gunakan untuk request <strong>REQUEST BERIKUTNYA ( SETELAH LOGIN )</strong></td>
            </tr>
            <tr>
                <th>token_type</th>
                <td>Tipe token</td>
            </tr>

            <tr>
                <th>expires_in</th>
                <td>Masa berlaku token (detik)</td>
            </tr>
            <tr>
                <th>refresh_token</th>
                <td>refresh token, untuk memperbaharui token.</td>
            </tr>
            <tr>
                <th>client_id</th>
                <td>diperlukan ketika melakukan refresh token</td>
            </tr>
            <tr>
                <th>client_secret</th>
                <td>diperlukan untuk melakukan refresh token</td>
            </tr>
            <tr>
                <th>users</th>
                <td>Data users ( member )</td>
            </tr>
            <tr>
                <th>config</th>
                <td>Konfigurasi layanan SIP</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
