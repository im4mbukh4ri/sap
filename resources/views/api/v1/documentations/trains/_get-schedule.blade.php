<h5>Request</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#reqTrainSchedule1" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#reqTrainSchedule2" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="reqTrainSchedule1" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>POST</td>
            </tr>
            <tr>
                <th>URL</th>
                <td>{{ route('api.trains_get_schedule') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="reqTrainSchedule2" role="tabpanel">
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
                <th>client_id/th>
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
            </tbody>
        </table>
    </div>
</div><h5>Response</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#resTrainSchedule1" role="tab">Repsonse Berhasil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resTrainSchedule2" role="tab">Response Gagal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resTrainSchedule3" role="tab">Penjelasan</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resTrainSchedule1" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px">
                <code class="language-markup">
{
  "status": {
    "code": 200,
    "confirm": "success",
    "message": [
      "Success get schedule"
    ]
  },
  "details": {
    "queries": {
      "trip": "O",
      "org": "BD",
      "des": "GMR",
      "tgl_dep": "2017-06-12",
      "adt": "1",
      "chd": "0",
      "inf": "0"
    },
    "schedule": {
      "departure": [
        {
          "TrainNo": "37F",
          "TrainName": "ARGO PARAHYANGAN FAKULTATIF",
          "STD": "BD",
          "STA": "GMR",
          "ETD": "2017-06-12 04:00",
          "ETA": "2017-06-12 07:09",
          "Fares": [
            {
              "SubClass": "A",
              "Class": "Eksekutif",
              "SeatAvb": "91",
              "TotalFare": "120000",
              "priceAdt": "120000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481761"
            },
            {
              "SubClass": "C",
              "Class": "Ekonomi",
              "SeatAvb": "195",
              "TotalFare": "80000",
              "priceAdt": "80000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481762"
            }
          ]
        },
        {
          "TrainNo": "19",
          "TrainName": "ARGO PARAHYANGAN",
          "STD": "BD",
          "STA": "GMR",
          "ETD": "2017-06-12 05:00",
          "ETA": "2017-06-12 08:15",
          "Fares": [
            {
              "SubClass": "A",
              "Class": "Eksekutif",
              "SeatAvb": "0",
              "TotalFare": "120000",
              "priceAdt": "120000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481763"
            },
            {
              "SubClass": "H",
              "Class": "Eksekutif",
              "SeatAvb": "0",
              "TotalFare": "115000",
              "priceAdt": "115000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481764"
            },
            {
              "SubClass": "I",
              "Class": "Eksekutif",
              "SeatAvb": "0",
              "TotalFare": "105000",
              "priceAdt": "105000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481765"
            },
            {
              "SubClass": "J",
              "Class": "Eksekutif",
              "SeatAvb": "0",
              "TotalFare": "100000",
              "priceAdt": "100000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481766"
            },
            {
              "SubClass": "C",
              "Class": "Ekonomi",
              "SeatAvb": "0",
              "TotalFare": "80000",
              "priceAdt": "80000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481767"
            }
          ]
        },
        {
          "TrainNo": "21",
          "TrainName": "ARGO PARAHYANGAN",
          "STD": "BD",
          "STA": "GMR",
          "ETD": "2017-06-12 06:30",
          "ETA": "2017-06-12 09:45",
          "Fares": [
            {
              "SubClass": "A",
              "Class": "Eksekutif",
              "SeatAvb": "136",
              "TotalFare": "120000",
              "priceAdt": "120000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481768"
            },
            {
              "SubClass": "H",
              "Class": "Eksekutif",
              "SeatAvb": "0",
              "TotalFare": "115000",
              "priceAdt": "115000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481769"
            },
            {
              "SubClass": "I",
              "Class": "Eksekutif",
              "SeatAvb": "0",
              "TotalFare": "105000",
              "priceAdt": "105000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481770"
            },
            {
              "SubClass": "J",
              "Class": "Eksekutif",
              "SeatAvb": "0",
              "TotalFare": "100000",
              "priceAdt": "100000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481771"
            },
            {
              "SubClass": "B",
              "Class": "Bisnis",
              "SeatAvb": "86",
              "TotalFare": "95000",
              "priceAdt": "95000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481772"
            },
            {
              "SubClass": "K",
              "Class": "Bisnis",
              "SeatAvb": "9",
              "TotalFare": "90000",
              "priceAdt": "90000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481773"
            },
            {
              "SubClass": "N",
              "Class": "Bisnis",
              "SeatAvb": "0",
              "TotalFare": "85000",
              "priceAdt": "85000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481774"
            },
            {
              "SubClass": "O",
              "Class": "Bisnis",
              "SeatAvb": "0",
              "TotalFare": "80000",
              "priceAdt": "80000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481775"
            },
            {
              "SubClass": "C",
              "Class": "Ekonomi",
              "SeatAvb": "96",
              "TotalFare": "70000",
              "priceAdt": "70000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481776"
            }
          ]
        },
        {
          "TrainNo": "33",
          "TrainName": "ARGO PARAHYANGAN",
          "STD": "BD",
          "STA": "GMR",
          "ETD": "2017-06-12 08:35",
          "ETA": "2017-06-12 11:50",
          "Fares": [
            {
              "SubClass": "A",
              "Class": "Eksekutif",
              "SeatAvb": "315",
              "TotalFare": "120000",
              "priceAdt": "120000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481777"
            },
            {
              "SubClass": "H",
              "Class": "Eksekutif",
              "SeatAvb": "8",
              "TotalFare": "115000",
              "priceAdt": "115000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481778"
            },
            {
              "SubClass": "I",
              "Class": "Eksekutif",
              "SeatAvb": "3",
              "TotalFare": "105000",
              "priceAdt": "105000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481779"
            },
            {
              "SubClass": "J",
              "Class": "Eksekutif",
              "SeatAvb": "2",
              "TotalFare": "100000",
              "priceAdt": "100000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481780"
            }
          ]
        },
        {
          "TrainNo": "23",
          "TrainName": "ARGO PARAHYANGAN",
          "STD": "BD",
          "STA": "GMR",
          "ETD": "2017-06-12 11:35",
          "ETA": "2017-06-12 14:57",
          "Fares": [
            {
              "SubClass": "A",
              "Class": "Eksekutif",
              "SeatAvb": "161",
              "TotalFare": "120000",
              "priceAdt": "120000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481781"
            },
            {
              "SubClass": "H",
              "Class": "Eksekutif",
              "SeatAvb": "12",
              "TotalFare": "115000",
              "priceAdt": "115000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481782"
            },
            {
              "SubClass": "I",
              "Class": "Eksekutif",
              "SeatAvb": "8",
              "TotalFare": "105000",
              "priceAdt": "105000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481783"
            },
            {
              "SubClass": "J",
              "Class": "Eksekutif",
              "SeatAvb": "7",
              "TotalFare": "100000",
              "priceAdt": "100000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481784"
            },
            {
              "SubClass": "C",
              "Class": "Ekonomi",
              "SeatAvb": "315",
              "TotalFare": "80000",
              "priceAdt": "80000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481785"
            }
          ]
        },
        {
          "TrainNo": "25",
          "TrainName": "ARGO PARAHYANGAN",
          "STD": "BD",
          "STA": "GMR",
          "ETD": "2017-06-12 14:45",
          "ETA": "2017-06-12 18:03",
          "Fares": [
            {
              "SubClass": "A",
              "Class": "Eksekutif",
              "SeatAvb": "166",
              "TotalFare": "120000",
              "priceAdt": "120000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481786"
            },
            {
              "SubClass": "H",
              "Class": "Eksekutif",
              "SeatAvb": "10",
              "TotalFare": "115000",
              "priceAdt": "115000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481787"
            },
            {
              "SubClass": "I",
              "Class": "Eksekutif",
              "SeatAvb": "8",
              "TotalFare": "105000",
              "priceAdt": "105000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481788"
            },
            {
              "SubClass": "J",
              "Class": "Eksekutif",
              "SeatAvb": "4",
              "TotalFare": "100000",
              "priceAdt": "100000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481789"
            },
            {
              "SubClass": "C",
              "Class": "Ekonomi",
              "SeatAvb": "313",
              "TotalFare": "80000",
              "priceAdt": "80000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481790"
            }
          ]
        },
        {
          "TrainNo": "27",
          "TrainName": "ARGO PARAHYANGAN",
          "STD": "BD",
          "STA": "GMR",
          "ETD": "2017-06-12 16:10",
          "ETA": "2017-06-12 19:27",
          "Fares": [
            {
              "SubClass": "A",
              "Class": "Eksekutif",
              "SeatAvb": "178",
              "TotalFare": "120000",
              "priceAdt": "120000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481791"
            },
            {
              "SubClass": "H",
              "Class": "Eksekutif",
              "SeatAvb": "4",
              "TotalFare": "115000",
              "priceAdt": "115000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481792"
            },
            {
              "SubClass": "I",
              "Class": "Eksekutif",
              "SeatAvb": "4",
              "TotalFare": "105000",
              "priceAdt": "105000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481793"
            },
            {
              "SubClass": "J",
              "Class": "Eksekutif",
              "SeatAvb": "0",
              "TotalFare": "100000",
              "priceAdt": "100000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481794"
            },
            {
              "SubClass": "C",
              "Class": "Ekonomi",
              "SeatAvb": "313",
              "TotalFare": "80000",
              "priceAdt": "80000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481795"
            }
          ]
        },
        {
          "TrainNo": "29",
          "TrainName": "ARGO PARAHYANGAN",
          "STD": "BD",
          "STA": "GMR",
          "ETD": "2017-06-12 19:40",
          "ETA": "2017-06-12 22:56",
          "Fares": [
            {
              "SubClass": "A",
              "Class": "Eksekutif",
              "SeatAvb": "144",
              "TotalFare": "120000",
              "priceAdt": "120000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481796"
            },
            {
              "SubClass": "H",
              "Class": "Eksekutif",
              "SeatAvb": "23",
              "TotalFare": "115000",
              "priceAdt": "115000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481797"
            },
            {
              "SubClass": "I",
              "Class": "Eksekutif",
              "SeatAvb": "12",
              "TotalFare": "105000",
              "priceAdt": "105000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481798"
            },
            {
              "SubClass": "J",
              "Class": "Eksekutif",
              "SeatAvb": "2",
              "TotalFare": "100000",
              "priceAdt": "100000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481799"
            },
            {
              "SubClass": "C",
              "Class": "Ekonomi",
              "SeatAvb": "306",
              "TotalFare": "80000",
              "priceAdt": "80000",
              "priceChd": "0",
              "priceInf": "0",
              "selectedIDdep": "1481800"
            }
          ]
        }
      ]
    }
  }
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resTrainSchedule2" role="tabpanel">
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
    <div class="tab-pane fade" id="resTrainSchedule3" role="tabpanel">
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
