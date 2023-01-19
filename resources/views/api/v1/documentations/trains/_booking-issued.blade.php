<h5>Request</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#reqTrainBookingIssued1" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#reqTrainBookingIssued2" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="reqTrainBookingIssued1" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>POST</td>
            </tr>
            <tr>
                <th>URL</th>
                <td>{{ route("api.trains_booking_issued")}}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="reqTrainBookingIssued2" role="tabpanel">
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
                  <th>org</th>
                  <td>YA</td>
                  <td>Kode stasiun keberangkatan</td>
              </tr>
              <tr>
                  <th>des</th>
                  <td>YA</td>
                  <td>Kode stasiun tujuan</td>
              </tr>
              <tr>
                  <th>trip</th>
                  <td>YA</td>
                  <td>R = untuk pulang pergi, O = untuk sekali jalan.</td>
              </tr>
              <tr>
                  <th>tgl_dep</th>
                  <td>YA</td>
                  <td>Tanggal keberangkatan. Format = yyyy-mm-dd.</td>
              </tr>
              <tr>
                  <th>tgl_ret</th>
                  <td>TIDAK</td>
                  <td>Tanggal kembali. Format = yyyy-mm-dd.<strong> Wajib jika trip=R</strong>.</td>
              </tr>
              <tr>
                  <th>adt</th>
                  <td>YA</td>
                  <td>Jumlah penumpang dewasa (numeric). <strong>minimal 1</strong>.</td>
              </tr>
              <tr>
                  <th>chd</th>
                  <td>YA</td>
                  <td>Jumlah penumpang anak (numeric). <strong>WAJIB 0</strong>.</td>
              </tr>
              <tr>
                  <th>inf</th>
                  <td>YA</td>
                  <td>Jumlah penumpang bayi (numeric). <strong>minimal 0</strong>.</td>
              </tr>
              <tr>
                <th>cpname</th>
                <td>YA</td>
                <td>Nama pemesan.</td>
              </tr>
              <tr>
                <th>cpmail</th>
                <td>YA</td>
                <td>Email pemesan.</td>
              </tr>
              <tr>
                <th>cptlp</th>
                <td>YA</td>
                <td>Email tlp.</td>
              </tr>
              <tr>
                <th>nmadt_1</th>
                <td>YA</td>
                <td>Nama lengkap penumpang dewasa.</td>
              </tr>
              <tr>
                <th>hpadt_1</th>
                <td>YA</td>
                <td>No. hp penumpang dewasa.</td>
              </tr>
              <tr>
                <th>idadt_1</th>
                <td>YA</td>
                <td> > 17thn No ID penumpang (KTP/SIM/PASPORT) / < 17thn tanggal lahir dgn format ddmmyyyy .</td>
              </tr>
              <tr>
                <th>seatadt_1</th>
                <td>YA</td>
                <td>Kursi penumpang dewasa. format = kode_wagon-no_wagon-seat . Ex. EKS-2-1A</td>
              </tr>
              <tr>
                <th>nminf_1</th>
                <td>YA</td>
                <td>Nama lengkap penumpang bayi. <strong>Jika inf > 0 </strong></td>
              </tr>
              <tr>
                <th>seatinf_1</th>
                <td>YA</td>
                <td>Kursi penumpang dewasa. format = kode_wagon-no_wagon-seat . Ex. EKS-2-1A <strong>Jika trip = R , maka seat return disimpan setelah seat departure dengan pemisah koma ex:EKS-2-1A,EKS-4-10B</strong></td>
              </tr>
              <tr>
                <th>selectedIDret</th>
                <td>TIDAK</td>
                <td>selectedIDret. <strong>Wajib jika trip = R </strong></td>
              </tr>
            </tbody>
        </table>
    </div>
</div><h5>Response</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#resTrainBookingIssued1" role="tab">Repsonse Berhasil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resTrainBookingIssued2" role="tab">Response Gagal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resTrainBookingIssued3" role="tab">Penjelasan</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resTrainBookingIssued1" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px">
                <code class="language-markup">
{
  "status": {
    "code": 200,
    "confirm": "success",
    "message": "success input transaction to database"
  },
  "response": {
    "transaction": {
      "id": "1375069",
      "user_id": 3,
      "trip_type_id": "O",
      "sip_service_id": 3,
      "adt": "1",
      "chd": "0",
      "inf": "0",
      "total_fare": 120000,
      "device": "android",
      "buyer_id": 6545,
      "updated_at": "2017-06-02 10:44:29",
      "created_at": "2017-06-02 10:44:29"
    },
    "booking": {
      "departure": {
        "origin": "BD",
        "destination": "GMR",
        "paxpaid": 120000,
        "train_name": "ARGO PARAHYANGAN FAKULTATIF",
        "train_number": "37F",
        "class": "Eksekutif",
        "subclass": "A",
        "etd": "2017-06-12 04:00:00",
        "eta": "2017-06-12 07:09:00",
        "train_transaction_id": "1375069",
        "updated_at": "2017-06-02 10:44:33",
        "created_at": "2017-06-02 10:44:29",
        "id": 12,
        "nta": "95000",
        "nra": 25000,
        "status": "issued",
        "pnr": "NTWGIP"
      },
      "return": null
    }
  }
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resTrainBookingIssued2" role="tabpanel">
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
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resTrainBookingIssued3" role="tabpanel">

    </div>
</div>
