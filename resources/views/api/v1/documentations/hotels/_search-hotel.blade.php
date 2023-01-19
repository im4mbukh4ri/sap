<h5>Request</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#reqHotelSchedule1" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#reqHotelSchedule2" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="reqHotelSchedule1" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>POST</td>
            </tr>
            <tr>
                <th>URL</th>
                <td>{{ route('api.hotels_search') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="reqHotelSchedule2" role="tabpanel">
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
                <td>client id</td>
            </tr>
            <tr>
                <th>des</th>
                <td>YA</td>
                <td>Kode kota tujuan</td>
            </tr>
            <tr>
                <th>checkin</th>
                <td>YA</td>
                <td>Tanggal checkin. Format = yyyy-mm-dd.</td>
            </tr>
            <tr>
                <th>checkout</th>
                <td>YA</td>
                <td>Tanggal checkout. Format = yyyy-mm-dd.</td>
            </tr>
            <tr>
                <th>adt</th>
                <td>YA</td>
                <td>Jumlah tamu dewasa (numeric). <strong>minimal 1</strong>.</td>
            </tr>
            <tr>
                <th>chd</th>
                <td>YA</td>
                <td>Jumlah tamu anak (numeric). <strong>WAJIB 0</strong>.</td>
            </tr>
            <tr>
                <th>room</th>
                <td>YA</td>
                <td>Jumlah kamar (numeric). <strong>minimal 1</strong>.</td>
            </tr>
            <tr>
                <th>room_type</th>
                <td>TIDAK</td>
                <td>Tipe kamar. (twin, double). <strong>minimal 0</strong>.</td>
            </tr>
            </tbody>
        </table>
    </div>
</div><h5>Response</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#resHotelSchedule1" role="tab">Repsonse Berhasil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resHotelSchedule2" role="tab">Response Gagal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resHotelSchedule3" role="tab">Penjelasan</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resHotelSchedule1" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px">
                <code class="language-markup">
{
    "status": {
        "code": 200,
        "confirm": "success",
        "message": [
            "Success search hotel"
        ]
    },
    "details": {
        "des": "WSASIDBDO",
        "checkin": "2017-09-27",
        "checkout": "2017-09-28",
        "room": "1",
        "adt": "1",
        "chd": "0",
        "jml": "20",
        "next": "8462",
        "hotels": [
            {
                "name": "Lotus Hotel Bandung",
                "address": "Jl.Tubagus Ismail VIII no.45  ",
                "star": "2",
                "kurs": "IDR",
                "price": "220000",
                "nta": "220000",
                "image": "cdn.infiniqa.com/hotel/mg/WSASIDBDO000172/hd/61eeDcKg1Hqy0hY3jFiFnJf7nVUEFESe8cLq_+7dhrLaEe+MTf68tiX_+w0dJcsTNOw2RZCNrMTEguFzpUlYDURk0RVy4W3twM1xrdLq1jpemApLXH_+KxqrJSlocApGWL6FT0=.jpg",
                "selectedID": "8443"
            },
            {
                "name": "Cihampelas Hotel 1",
                "address": "Jl. Cihampelas No. 240  ",
                "star": "2",
                "kurs": "IDR",
                "price": "250000",
                "nta": "250000",
                "image": "cdn.infiniqa.com/hotel/mg/WSASIDBDO000053/hd/kpNGeKi3fcRjuqSJYRY+iQK8dVFZ_+R6mYGL0ymh5nmVXac_+ATlki76eI2w4SD9tigYlREpFP5ksoe7q7_+49KQumiak1x3F70+yCNKRp_+pU6zGdZWhxxhtDUE5ljg+lYGo6E=.jpg",
                "selectedID": "8444"
            },
            {
                "name": "Cihampelas Hotel 2 Bandung by LARIZ",
                "address": "Jl. Cihampelas No. 222  ",
                "star": "3",
                "kurs": "IDR",
                "price": "250000",
                "nta": "250000",
                "image": "cdn.infiniqa.com/hotel/mg/WSASIDBDO000054/hd/LjkRIzxRJSNwt5RyHiBDAvFkNVkeEd_+hmBPR_+Llah0JwVWHK_+JKrG+BSSC78ZVoq+LapsdmFr9azV8UDshwN+3JTfWG8l2dHcY2fardMg3WmZtoookWlahWNXtkhiXPDd2A=.jpg",
                "selectedID": "8445"
            },
            {
                "name": "Orange Home s Syariah",
                "address": "Jl. Babakan Jeruk No 76  ",
                "star": "0",
                "kurs": "IDR",
                "price": "255253",
                "nta": "255253",
                "image": "cdn.infiniqa.com/images/nopict.gif",
                "selectedID": "8446"
            },
            {
                "name": "Vio Veteran",
                "address": "Jl. Veteran No 32  ",
                "star": "2",
                "kurs": "IDR",
                "price": "270000",
                "nta": "270000",
                "image": "cdn.infiniqa.com/images/nopict.gif",
                "selectedID": "8447"
            },
            {
                "name": "Cassadua Residence Bandung",
                "address": "Jl. Cassa No. 2  ",
                "star": "2",
                "kurs": "IDR",
                "price": "271108",
                "nta": "271108",
                "image": "cdn.infiniqa.com/images/nopict.gif",
                "selectedID": "8448"
            },
            {
                "name": "Meize Hotel Bandung",
                "address": "jl. Sumbawa No. 7  ",
                "star": "3",
                "kurs": "IDR",
                "price": "271471",
                "nta": "271471",
                "image": "cdn.infiniqa.com/hotel/mg/WSASIDBDO000181/hd/0i9v0ooYCNfBSMvDfe2+b6+H9SZfKe5RrrGpwBtqfMjNTDduk5G5aoBWI45RubLPwA3iXeWZih7OgFFiV6_+vqbPlh8+85Osrlp2EnMzQuZr79pduYS+kApawLXm9CETMznh9.jpg",
                "selectedID": "8449"
            },
            {
                "name": "Favehotel Braga",
                "address": "jalan Braga No 99-101,Bandung 40111 Indonesia ",
                "star": "3",
                "kurs": "IDR",
                "price": "275720",
                "nta": "275720",
                "image": "cdn.infiniqa.com/images/nopict.gif",
                "selectedID": "8450"
            },
            {
                "name": "Vio Cihampelas",
                "address": "Jl. Cihampelas No. 18  ",
                "star": "2",
                "kurs": "IDR",
                "price": "290000",
                "nta": "290000",
                "image": "cdn.infiniqa.com/hotel/mg/WSASIDBDO000314/hd/Jr6cyvnABo37jTTjxUxBf9Fzc+QQ+0IzvSJixwngKIrOHoqkR8Gug7DzzACy4p45rRrdZ5H_+ttW4SdkG5hYdmx2M9gvkCtHJXO4nx0UpgGx3uCWl0Je79EetDt+9N3rDJ29o.jpg",
                "selectedID": "8451"
            },
            {
                "name": "Pasar Baru Square Hotel Bandung Managed by Dafam",
                "address": "Jl. Otto Iskandardinata No. 81-89  ",
                "star": "3",
                "kurs": "IDR",
                "price": "293250",
                "nta": "293250",
                "image": "cdn.infiniqa.com/images/nopict.gif",
                "selectedID": "8452"
            },
            {
                "name": "Alqueby Hotel",
                "address": "Jl. Terusan Jakarta Utara No.7 Antapani  ",
                "star": "2",
                "kurs": "IDR",
                "price": "299000",
                "nta": "299000",
                "image": "cdn.infiniqa.com/hotel/mg/WSASIDBDO000006/hd/AXe1_+ADh9drkQ7DKwY7VppYsjhw9jOiisSqPDE3bp1qYHDKtKr5ttJ2POBD2m30QLu_+nRjBhNAWGkNAIWFSQUpzrIVkxEYVvIT5ykGUKLQ5_+Pvsr46fi4fLyGIJWv+s2Ef0=.jpg",
                "selectedID": "8453"
            },
            {
                "name": "Idea s  Bandung",
                "address": "Jl. Ibrahim Adjie (Kiaracondong) No. 414  ",
                "star": "1",
                "kurs": "IDR",
                "price": "300000",
                "nta": "300000",
                "image": "cdn.infiniqa.com/images/nopict.gif",
                "selectedID": "8454"
            },
            {
                "name": "Ilos Hotel",
                "address": "Jalan. Babakan Jeruk III no 37 - 39, Pasteur, Band  ",
                "star": "1",
                "kurs": "IDR",
                "price": "300000",
                "nta": "300000",
                "image": "cdn.infiniqa.com/hotel/mg/WSASIDBDO000145/hd/tNPSsKajegc7fGWG41XUCH8D3UqAh6GRTaT5ELnNun_+49M4PRIGOWCFxdAt6_+FS4WVYiUU7QqmWaALghuAGYzSzhBHrfbbzbyGJYnRWumYk9fCaU61aw8coxyg8DeDj_+nXI=.jpg",
                "selectedID": "8455"
            },
            {
                "name": "Cihampelas Hotel 3 Bandung by LARIZ",
                "address": "Jl. Cihampelas No. 179  ",
                "star": "2",
                "kurs": "IDR",
                "price": "305000",
                "nta": "305000",
                "image": "cdn.infiniqa.com/hotel/mg/WSASIDBDO000055/hd/wV2fBnqjE_+HR5YSQmbjb3k6rAsR9mUeuxdeU1YY8mylMDcAsy7ViZTkjmaOD73luSrRFe_+oz+SpDjYOwaJ8JDDcPKl0EjYzuAMQOCb4HiSyK3AoGfmi1iom1Tic2a7hpXvk=.jpg",
                "selectedID": "8456"
            }
        ]
    }
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resHotelSchedule2" role="tabpanel">
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
------- RESPONSE GAGAL transaction_id salah / tidak ditemukan ----------
{
  "status": {
    "code": 400,
    "confirm": "failed",
    "message": [
      "transaction_id tidak ditemukan"
    ]
  }
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resHotelSchedule3" role="tabpanel">
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
