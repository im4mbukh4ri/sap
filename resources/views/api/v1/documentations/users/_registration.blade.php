<h5>Request</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#reqUsrReg1" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#reqUsrReg2" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="reqUsrReg1" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>POST</td>
            </tr>
            <tr>
                <th>URL</th>
                <td>{{ route('api.users_free_registration') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="reqUsrReg2" role="tabpanel">
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
                <th>username</th>
                <td>YA</td>
                <td>Username member ( unique ) baru</td>
            </tr>
            <tr>
                <th>name</th>
                <td>YA</td>
                <td>Nama lengkap member baru</td>
            </tr>
            <tr>
                <th>email</th>
                <td>YA</td>
                <td>Email</td>
            </tr>
            <tr>
                <th>member_phone</th>
                <td>YA</td>
                <td>No tlp. member baru</td>
            </tr>
            <tr>
                <th>password</th>
                <td>YA</td>
                <td>Password untuk member baru</td>
            </tr>
            <tr>
                <th>birth_date</th>
                <td>YA</td>
                <td>Tanggal lahir member baru. Format yyyy-mm-dd</td>
            </tr>
            <tr>
                <th>gender</th>
                <td>YA</td>
                <td>Jenis kelamin. value : L / P</td>
            </tr>
            <tr>
                <th>referral</th>
                <td>YA</td>
                <td>Kode referral member</td>
            </tr>
            <tr>
                <th>device_type</th>
                <td>YA</td>
                <td>Tipe device ( android/ios )</td>
            </tr>
            <tr>
                <th>device_id</th>
                <td>YA</td>
                <td>ID device</td>
            </tr>
            </tbody>
        </table>
    </div>
</div><h5>Response</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#resUserReg1" role="tab">Repsonse Berhasil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resUserReg2" role="tab">Response Gagal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resUserReg3" role="tab">Penjelasan</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resUserReg1" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px">
                <code class="language-markup">
{
  "status": {
    "code": 200,
    "confirm": "success",
    "message": [
      "Berhasil registrasi"
    ]
  },
  "details": {
    "data": {
      "client_id": "2FBHpAE77XjsI0jck1tTY8gvVaYGvF5i125fAsiX",
      "username": "memberfreeAPI3",
      "name": "Coba member Dfree dari API 3",
      "email": "cobamemberfree3@gmail.com",
      "password": "12345",
      "birth_date": "2007-04-03",
      "gender": "L",
      "referral": "7BHIUN",
      "member_phone": "085817763645",
      "device_type":"android",
      "device_id":"2345hfsdf7vh"
    }
  }
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resUserReg2" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px;">
                <code class="language-markup">
------- RESPONSE JIKA TIDAK MENGIRIMKAN TOKEN --------
{
    "status": {
        "code": 400,
        "confirm": "failed",
        "message": [
            "Session Anda telah habis, silahkan logout dan login kembali"
        ]
    }
}

------- RESPONSE JIKA REFERRAL TIDAK DI ISI ----------
{
    "status": {
        "code": 400,
        "confirm": "failed",
        "message": [
            "Referral wajib di isi."
        ]
    }
}
------- RESPONSE DEVICE ID & DEVICE TYPE SUDAH TERDAFTAR -------------
{
  "status": {
    "code": 400,
    "confirm": "failed",
    "message": [
      "Device Anda sudah terdaftar dengan username yang lain."
    ]
  }
}
-------------------- RESPONSE USERNAME SUDAH TERDAFTAR ---------------
{
  "status": {
    "code": 400,
    "confirm": "failed",
    "message": {
      "username": [
        "The username has already been taken."
      ]
    }
  }
}
------------------ RESPONSE KODE REFERRAL TIDAK TERDAFTAR -------------
{
  "status": {
    "code": 400,
    "confirm": "failed",
    "message": {
      "referral": [
        "The selected referral is invalid."
      ]
    }
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
    <div class="tab-pane fade" id="resUserReg3" role="tabpanel">
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
