<h5>Request</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#reqAirBookIssued1" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#reqAirBookIssued2" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="reqAirBookIssued1" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>POST</td>
            </tr>
            <tr>
                <th>URL</th>
                <td>{{ route('api.airlines_booking_issued') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="reqAirBookIssued2" role="tabpanel">
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
                <td>Client id yang didapat ketika login</td>
            </tr>
            <tr>
                <th>acDep</th>
                <td>YA</td>
                <td>Kode maskapai keberangkatan</td>
            </tr>
            <tr>
                <th>acRet</th>
                <td>TIDAK</td>
                <td>Kode maskapai kembali. <strong>Wajib jika flight=R</strong></td>
            </tr>
            <tr>
                <th>org</th>
                <td>YA</td>
                <td>Kode bandara keberangkatan</td>
            </tr>
            <tr>
                <th>des</th>
                <td>YA</td>
                <td>Kode bandara tujuan</td>
            </tr>
            <tr>
                <th>flight</th>
                <td>YA</td>
                <td>R = untuk pulang pergi, O = untuk sekali jalan.</td>
            </tr>
            <tr>
                <th>tgl_dep</th>
                <td>YA</td>
                <td>Tanggal keberangkatan. Format = yyyy-mm-dd</td>
            </tr>
            <tr>
                <th>tgl_ret</th>
                <td>TIDAK</td>
                <td>Tanggal kembali. Format = yyyy-mm-dd. <strong>Wajib jika flight=R</strong></td>
            </tr>
            <tr>
                <th>adt</th>
                <td>YA</td>
                <td>Jumlah penumpang dewasa (numeric). <strong>minimal 1</strong></td>
            </tr>
            <tr>
                <th>chd</th>
                <td>YA</td>
                <td>Jumlah penumpang anak (numeric).<strong>minimal 0</strong></td>
            </tr>
            <tr>
                <th>inf</th>
                <td>YA</td>
                <td>Jumlah penumpang bayi (numeric).<strong>minimal 0</strong></td>
            </tr>
            <tr>
                <th>cpname</th>
                <td>YA</td>
                <td>Nama pemesan</td>
            </tr>
            <tr>
                <th>cpmail</th>
                <td>YA</td>
                <td>Email pemesan</td>
            </tr>
            <tr>
                <th>cptlp</th>
                <td>YA</td>
                <td>Telp. pemesan</td>
            </tr>
            <tr>
                <th>titadt_1</th>
                <td>YA</td>
                <td>Title penumpang dewasa ke satu. value = MR / MRS . <strong>Gunakan titadt_2 dst. sesuai banyaknya penumpang dewasa</strong></td>
            </tr>
            <tr>
                <th>fnadt_1</th>
                <td>YA</td>
                <td>Nama depan penumpang dewasa ke satu. <strong>Gunakan fnadt_2 dst. sesuai banyaknya penumpang dewasa</strong></td>
            </tr>
            <tr>
                <th>lnadt_1</th>
                <td>YA</td>
                <td>Nama belakang penumpang dewasa ke satu. <strong>Gunakan lnadt_2 dst. sesuai banyaknya penumpang dewasa</strong></td>
            </tr>
            <tr>
                <th>hpadt_1</th>
                <td>YA</td>
                <td>No hp. penumpang dewasa ke satu. <strong>Gunakan hpadt_2 dst. sesuai banyaknya penumpang dewasa</strong></td>
            </tr>
            <tr>
                <th>titchd_1</th>
                <td>TIDAK</td>
                <td>Title penumpang anak ke satu. value = MSTR / MISS . <strong>Gunakan titchd_2 dst. sesuai banyaknya penumpang anak</strong>. <strong>Wajib jika ada penumpang anak / chd!=0</strong></td>
            </tr>
            <tr>
                <th>fnchd_1</th>
                <td>TIDAK</td>
                <td>Nama depan penumpang anak ke satu. <strong>Gunakan fnchd_2 dst. sesuai banyaknya penumpang anak</strong>.  <strong>Wajib jika ada penumpang anak / chd!=0</strong></td>
            </tr>
            <tr>
                <th>lnchd_1</th>
                <td>TIDAK</td>
                <td>Nama belakang penumpang anak ke satu. <strong>Gunakan lnchd_2 dst. sesuai banyaknya penumpang anak</strong>.  <strong>Wajib jika ada penumpang anak / chd!=0</strong></td>
            </tr>
            <tr>
                <th>birthchd_1</th>
                <td>YA</td>
                <td>Tanggal lahir penumpang anak ke satu. Format yyyy-mm-dd <strong>Gunakan birthchd_1 dst. sesuai banyaknya penumpang anak</strong>. <strong>Wajib jika ada penumpang anak / chd!=0</strong></td>
            </tr>
            <tr>
                <th>titinf_1</th>
                <td>TIDAK</td>
                <td>Title penumpang bayi ke satu. value = MSTR / MISS . <strong>Gunakan titinf_2 dst. sesuai banyaknya penumpang bayi</strong>. <strong>Wajib jika ada penumpang bayi / inf!=0</strong></td>
            </tr>
            <tr>
                <th>fninf_1</th>
                <td>TIDAK</td>
                <td>Nama depan penumpang bayi ke satu. <strong>Gunakan fninf_2 dst. sesuai banyaknya penumpang bayi</strong>.  <strong>Wajib jika ada penumpang bayi / inf!=0</strong></td>
            </tr>
            <tr>
                <th>lninf_1</th>
                <td>TIDAK</td>
                <td>Nama belakang penumpang bayi ke satu. <strong>Gunakan lninf_2 dst. sesuai banyaknya penumpang bayi</strong>.  <strong>Wajib jika ada penumpang inf / inf!=0</strong></td>
            </tr>
            <tr>
                <th>birthinf_1</th>
                <td>YA</td>
                <td>Tanggal lahir penumpang bayi ke satu. Format yyyy-mm-dd <strong>Gunakan birthinf_1 dst. sesuai banyaknya penumpang bayi</strong>. <strong>Wajib jika ada penumpang bayi / inf!=0</strong></td>
            </tr>
            <tr>
                <th>total_fare</th>
                <td>YA</td>
                <td>Total fare yang di dapat ketika get_fare</td>
            </tr>
            <tr>
                <th>result_get_fare</th>
                <td>YA <strong>(Domestic)</strong></td>
                <td>value = response ketika get_fare</td>
            </tr>
            <tr>
                <th>selectedIDdep</th>
                <td>YA <strong>(Domestic)</strong></td>
                <td>selected ID departure</td>
            </tr>
            <tr>
                <th>selectedIDret</th>
                <td>YA <strong>(Domestic)</strong></td>
                <td>selected ID return</td>
            </tr>
            <tr>
              <th>cabin</th>
              <td>YA <strong>(International)</strong></td>
              <td>Hanya untuk international, value : economy / business</td>
            </tr>
            {{-- <tr>
              <th>trxId</th>
              <td>YA <strong>(International)</strong></td>
              <td>Hanya untuk international,di dapat dari get_fare dengan parameter trxId</td>
            </tr> --}}
            <tr>
              <th>passnoadt_1</th>
              <td>YA <strong>(International)</strong></td>
              <td>No. Passport. <strong>Gunakan passnoadt_2 dst. sesuai banyaknya penumpang dewasa</strong></td>
            </tr>
            <tr>
              <th>natadt_1</th>
              <td>YA <strong>(International)</strong></td>
              <td>Kode negara. <strong>Gunakan natadt_2 dst. sesuai banyaknya penumpang dewasa</strong></td>
            </tr>
            <tr>
              <th>passnatadt_1</th>
              <td>YA <strong>(International)</strong></td>
              <td>Kode negara asal penumpang. <strong>Gunakan passnatadt_2 dst. sesuai banyaknya penumpang dewasa</strong></td>
            </tr>
            <tr>
              <th>birthadt_1</th>
              <td>YA <strong>(International)</strong></td>
              <td>Tanggal lahir. <strong>Gunakan birthadt_2 dst. sesuai banyaknya penumpang dewasa</strong></td>
            </tr>
            <tr>
              <th>passenddateadt_1</th>
              <td>YA <strong>(International)</strong></td>
              <td>Masa berlaku passport. <strong>Gunakan passenddateadt_2 dst. sesuai banyaknya penumpang dewasa</strong></td>
            </tr>
            <tr>
              <th>passnochd_1</th>
              <td>TIDAK <strong>(International)</strong></td>
              <td>No. Passport. <strong>Gunakan passnochd_2 dst. sesuai banyaknya penumpang anak</strong></td>
            </tr>
            <tr>
              <th>natchd_1</th>
              <td>TIDAK <strong>(International)</strong></td>
              <td>Kode negara. <strong>Gunakan natchd_2 dst. sesuai banyaknya penumpang anak</strong></td>
            </tr>
            <tr>
              <th>passnatchd_1</th>
              <td>TIDAK <strong>(International)</strong></td>
              <td>Kode negara asal penumpang. <strong>Gunakan passnatchd_2 dst. sesuai banyaknya penumpang anak</strong></td>
            </tr>
            <tr>
              <th>birthchd_1</th>
              <td>TIDAK <strong>(International)</strong></td>
              <td>Tanggal lahir. <strong>Gunakan birthchd_2 dst. sesuai banyaknya penumpang anak</strong></td>
            </tr>
            <tr>
              <th>passenddatechd_1</th>
              <td>TIDAK <strong>(International)</strong></td>
              <td>Masa berlaku passport. <strong>Gunakan passenddatechd_2 dst. sesuai banyaknya penumpang anak</strong></td>
            </tr>
            <tr>
              <th>passnoinf_1</th>
              <td>TIDAK <strong>(International)</strong></td>
              <td>No. Passport. <strong>Gunakan passnoinf_2 dst. sesuai banyaknya penumpang bayi</strong></td>
            </tr>
            <tr>
              <th>natinf_1</th>
              <td>TIDAK <strong>(International)</strong></td>
              <td>Kode negara. <strong>Gunakan natinf_2 dst. sesuai banyaknya penumpang bayi</strong></td>
            </tr>
            <tr>
              <th>passnatinf_1</th>
              <td>TIDAK <strong>(International)</strong></td>
              <td>Kode negara asal penumpang. <strong>Gunakan passnatinf_2 dst. sesuai banyaknya penumpang bayi</strong></td>
            </tr>
            <tr>
              <th>birthchd_1</th>
              <td>TIDAK <strong>(International)</strong></td>
              <td>Tanggal lahir. <strong>Gunakan birthchd_2 dst. sesuai banyaknya penumpang bayi</strong></td>
            </tr>
            <tr>
              <th>passenddateinf_1</th>
              <td>TIDAK <strong>(International)</strong></td>
              <td>Masa berlaku passport. <strong>Gunakan passenddateinf_2 dst. sesuai banyaknya penumpang bayi</strong></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<h5>Response</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#resBookIssued1" role="tab">Repsonse Berhasil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resBookIssued2" role="tab">Response Gagal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resBookIssued3" role="tab">Penjelasan</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resBookIssued1" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px">
                <code class="language-markup">
{
    "status": {
        "code": 200,
        "confirm": "success",
        "message": [
            "Booking berhasil"
        ]
    },
    "details": {
        "transaction": {
            "id": "1948029",
            "user_id": 3,
            "trip_type_id": "R",
            "adt": "1",
            "chd": "0",
            "inf": "0",
            "total_fare": "976200",
            "expired": "2017-01-09 17:50:35",
            "buyer_id": 38,
            "updated_at": "2017-01-09 14:47:14",
            "created_at": "2017-01-09 14:47:09"
        },
        "booking": {
            "airlines_code": "SJ",
            "origin": "CGK",
            "destination": "SUB",
            "paxpaid": "976200",
            "status": "booking",
            "nta": "926200",
            "nra": 50000,
            "airlines_transaction_id": "1948029",
            "updated_at": "2017-01-09 14:47:14",
            "created_at": "2017-01-09 14:47:09",
            "id": 51,
            "departure_date": "15-03-2017",
            "return_date": "17-03-2017",
            "departure_etd": "15-03-17 05:00",
            "departure_eta": "15-03-17 06:15",
            "return_etd": "17-03-17 07:00",
            "return_eta": "17-03-17 08:20",
            "itineraries": [
                {
                    "id": 85,
                    "airlines_booking_id": "51",
                    "pnr": "WSPTCE",
                    "depart_return_id": "d",
                    "leg": "1",
                    "flight_number": "SJ268",
                    "class": "X",
                    "std": "CGK",
                    "sta": "SUB",
                    "etd": "2017-03-15 05:00:00",
                    "eta": "2017-03-15 06:15:00",
                    "created_at": "2017-01-09 14:47:09",
                    "updated_at": "2017-01-09 14:47:14"
                },
                {
                    "id": 86,
                    "airlines_booking_id": "51",
                    "pnr": "WSPTCE",
                    "depart_return_id": "r",
                    "leg": "1",
                    "flight_number": "SJ269",
                    "class": "X",
                    "std": "SUB",
                    "sta": "CGK",
                    "etd": "2017-03-17 07:00:00",
                    "eta": "2017-03-17 08:20:00",
                    "created_at": "2017-01-09 14:47:09",
                    "updated_at": "2017-01-09 14:47:14"
                }
            ]
        }
    }
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resBookIssued2" role="tabpanel">
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
------------- RESPONSE GAGAL TETAPI DATA TETAP TERSIMPAN --------------
{
    "status": {
        "code": 400,
        "confirm": "failed",
        "message": [
            "Nama pemesan, email, dan no hp pemesan harus diisi."
        ]
    },
    "details": {
        "transaction": {
            "id": "1947317",
            "user_id": 3,
            "trip_type_id": "R",
            "adt": "1",
            "chd": "0",
            "inf": "0",
            "total_fare": "976200",
            "expired": "0000-00-00 00:00:00",
            "buyer_id": 36,
            "updated_at": "2017-01-09 14:35:17",
            "created_at": "2017-01-09 14:35:17"
        },
        "deposit": "1300000.00",
        "booking": {
            "airlines_code": "SJ",
            "origin": "CGK",
            "destination": "SUB",
            "paxpaid": 0,
            "status": "failed",
            "nta": 0,
            "nra": 0,
            "airlines_transaction_id": "1947317",
            "updated_at": "2017-01-09 14:35:17",
            "created_at": "2017-01-09 14:35:17",
            "id": 49,
            "departure_date": "15-03-2017",
            "return_date": "17-03-2017",
            "departure_etd": "15-03-17 05:00",
            "departure_eta": "15-03-17 06:15",
            "return_etd": "17-03-17 07:00",
            "return_eta": "17-03-17 08:20",
            "itineraries": [
                {
                    "id": 81,
                    "airlines_booking_id": "49",
                    "pnr": "######",
                    "depart_return_id": "d",
                    "leg": "1",
                    "flight_number": "SJ268",
                    "class": "X",
                    "std": "CGK",
                    "sta": "SUB",
                    "etd": "2017-03-15 05:00:00",
                    "eta": "2017-03-15 06:15:00",
                    "created_at": "2017-01-09 14:35:17",
                    "updated_at": "2017-01-09 14:35:17"
                },
                {
                    "id": 82,
                    "airlines_booking_id": "49",
                    "pnr": "######",
                    "depart_return_id": "r",
                    "leg": "1",
                    "flight_number": "SJ269",
                    "class": "X",
                    "std": "SUB",
                    "sta": "CGK",
                    "etd": "2017-03-17 07:00:00",
                    "eta": "2017-03-17 08:20:00",
                    "created_at": "2017-01-09 14:35:17",
                    "updated_at": "2017-01-09 14:35:17"
                }
            ]
        }
    }
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resBookIssued3" role="tabpanel">
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
