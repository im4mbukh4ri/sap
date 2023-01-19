<h3>AIRLINES GET SCHEDULE</h3>
<p>Untuk mendaptkan jadwal penerbangan maskapai.</p>
<h5>Request</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#reqAirGetSch1" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#reqAirGetSch2" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="reqAirGetSch1" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>POST</td>
            </tr>
            <tr>
                <th>URL</th>
                <td>{{ route('api.airlines_get_schedule') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="reqAirGetSch2" role="tabpanel">
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
                <th>ac</th>
                <td>YA <strong>(domestik)</strong></td>
                <td>Kode maskapai..</td>
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
              <th>cabin</th>
              <td>YA <strong>(International)</strong></td>
              <td>Hanya untuk international. Value : economy / business</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<p><strong style="color: red">NOTE</strong>: parameter request dapat bertipe json atau tidak. <br> ac = GA , JT, SJ, KD, dan setersunya.</p>
<h5>Response</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#resGetSch1" role="tab">Repsonse Berhasil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resGetSchInt" role="tab">Repsonse International</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resGetSch2" role="tab">Response Gagal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resGetSch3" role="tab">Penjelasan</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resGetSch1" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px;">
                <code class="language-markup">
{
    "status": {
        "code": 200,
        "confirm": "success",
        "message": [
            "Success get schedule."
        ]
    },
    "details": {
        "error_code": "000",
        "error_msg": "",
        "mmid": "mastersip",
        "ac": "JT",
        "org": "CGK",
        "des": "JOG",
        "flight": "R",
        "tgl_dep": "2017-03-08",
        "tgl_ret": "2017-03-29",
        "adt": "1",
        "chd": "0",
        "inf": "0",
        "schedule": {
            "departure": [
                {
                    "Flights": [
                        {
                            "FlightNo": "ID6360",
                            "Transit": 0,
                            "STD": "CGK",
                            "STA": "JOG",
                            "ETD": "2017-03-08 05:40",
                            "ETA": "2017-03-08 06:50"
                        }
                    ],
                    "Fares": [
                        [
                            {
                                "SubClass": "T",
                                "SeatAvb": "7",
                                "TotalFare": "498000",
                                "TotalNTA": 433000,
                                "selectedIDdep": "457016"
                            },
                            {
                                "SubClass": "Q",
                                "SeatAvb": "7",
                                "TotalFare": "506000",
                                "TotalNTA": 441000,
                                "selectedIDdep": "457017"
                            },
                            {
                                "SubClass": "N",
                                "SeatAvb": "7",
                                "TotalFare": "575000",
                                "TotalNTA": 510000,
                                "selectedIDdep": "457018"
                            },
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "619000",
                                "TotalNTA": 554000,
                                "selectedIDdep": "457019"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "663000",
                                "TotalNTA": 598000,
                                "selectedIDdep": "457020"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "693000",
                                "TotalNTA": 628000,
                                "selectedIDdep": "457021"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "748000",
                                "TotalNTA": 683000,
                                "selectedIDdep": "457022"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "803000",
                                "TotalNTA": 738000,
                                "selectedIDdep": "457023"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "869000",
                                "TotalNTA": 804000,
                                "selectedIDdep": "457024"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "960000",
                                "TotalNTA": 895000,
                                "selectedIDdep": "457025"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "1026000",
                                "TotalNTA": 961000,
                                "selectedIDdep": "457026"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "1078000",
                                "TotalNTA": 1013000,
                                "selectedIDdep": "457027"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "1152800",
                                "TotalNTA": 1087800,
                                "selectedIDdep": "457028"
                            },
                            {
                                "SubClass": "Z",
                                "SeatAvb": "3",
                                "TotalFare": "798000",
                                "TotalNTA": 733000,
                                "selectedIDdep": "457029"
                            },
                            {
                                "SubClass": "I",
                                "SeatAvb": "5",
                                "TotalFare": "1078000",
                                "TotalNTA": 1013000,
                                "selectedIDdep": "457030"
                            },
                            {
                                "SubClass": "D",
                                "SeatAvb": "7",
                                "TotalFare": "1496000",
                                "TotalNTA": 1431000,
                                "selectedIDdep": "457031"
                            },
                            {
                                "SubClass": "C",
                                "SeatAvb": "7",
                                "TotalFare": "2035000",
                                "TotalNTA": 1970000,
                                "selectedIDdep": "457032"
                            }
                        ]
                    ]
                },
                {
                    "Flights": [
                        {
                            "FlightNo": "JT544",
                            "Transit": 0,
                            "STD": "CGK",
                            "STA": "JOG",
                            "ETD": "2017-03-08 05:55",
                            "ETA": "2017-03-08 07:05"
                        }
                    ],
                    "Fares": [
                        [
                            {
                                "SubClass": "X",
                                "SeatAvb": "4",
                                "TotalFare": "360500",
                                "TotalNTA": 295500,
                                "selectedIDdep": "457033"
                            },
                            {
                                "SubClass": "V",
                                "SeatAvb": "7",
                                "TotalFare": "363000",
                                "TotalNTA": 298000,
                                "selectedIDdep": "457034"
                            },
                            {
                                "SubClass": "T",
                                "SeatAvb": "7",
                                "TotalFare": "407000",
                                "TotalNTA": 342000,
                                "selectedIDdep": "457035"
                            },
                            {
                                "SubClass": "Q",
                                "SeatAvb": "7",
                                "TotalFare": "440000",
                                "TotalNTA": 375000,
                                "selectedIDdep": "457036"
                            },
                            {
                                "SubClass": "N",
                                "SeatAvb": "7",
                                "TotalFare": "484000",
                                "TotalNTA": 419000,
                                "selectedIDdep": "457037"
                            },
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "542000",
                                "TotalNTA": 477000,
                                "selectedIDdep": "457038"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "550000",
                                "TotalNTA": 485000,
                                "selectedIDdep": "457039"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "605000",
                                "TotalNTA": 540000,
                                "selectedIDdep": "457040"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "649000",
                                "TotalNTA": 584000,
                                "selectedIDdep": "457041"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "693000",
                                "TotalNTA": 628000,
                                "selectedIDdep": "457042"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "748000",
                                "TotalNTA": 683000,
                                "selectedIDdep": "457043"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "828000",
                                "TotalNTA": 763000,
                                "selectedIDdep": "457044"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "858000",
                                "TotalNTA": 793000,
                                "selectedIDdep": "457045"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "924000",
                                "TotalNTA": 859000,
                                "selectedIDdep": "457046"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "987800",
                                "TotalNTA": 922800,
                                "selectedIDdep": "457047"
                            }
                        ]
                    ]
                },
                {
                    "Flights": [
                        {
                            "FlightNo": "ID6362",
                            "Transit": 0,
                            "STD": "CGK",
                            "STA": "JOG",
                            "ETD": "2017-03-08 07:50",
                            "ETA": "2017-03-08 09:00"
                        }
                    ],
                    "Fares": [
                        [
                            {
                                "SubClass": "T",
                                "SeatAvb": "7",
                                "TotalFare": "498000",
                                "TotalNTA": 433000,
                                "selectedIDdep": "457048"
                            },
                            {
                                "SubClass": "Q",
                                "SeatAvb": "7",
                                "TotalFare": "506000",
                                "TotalNTA": 441000,
                                "selectedIDdep": "457049"
                            },
                            {
                                "SubClass": "N",
                                "SeatAvb": "7",
                                "TotalFare": "575000",
                                "TotalNTA": 510000,
                                "selectedIDdep": "457050"
                            },
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "619000",
                                "TotalNTA": 554000,
                                "selectedIDdep": "457051"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "663000",
                                "TotalNTA": 598000,
                                "selectedIDdep": "457052"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "693000",
                                "TotalNTA": 628000,
                                "selectedIDdep": "457053"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "748000",
                                "TotalNTA": 683000,
                                "selectedIDdep": "457054"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "803000",
                                "TotalNTA": 738000,
                                "selectedIDdep": "457055"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "869000",
                                "TotalNTA": 804000,
                                "selectedIDdep": "457056"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "960000",
                                "TotalNTA": 895000,
                                "selectedIDdep": "457057"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "1026000",
                                "TotalNTA": 961000,
                                "selectedIDdep": "457058"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "1078000",
                                "TotalNTA": 1013000,
                                "selectedIDdep": "457059"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "1152800",
                                "TotalNTA": 1087800,
                                "selectedIDdep": "457060"
                            },
                            {
                                "SubClass": "Z",
                                "SeatAvb": "3",
                                "TotalFare": "798000",
                                "TotalNTA": 733000,
                                "selectedIDdep": "457061"
                            },
                            {
                                "SubClass": "I",
                                "SeatAvb": "5",
                                "TotalFare": "1078000",
                                "TotalNTA": 1013000,
                                "selectedIDdep": "457062"
                            },
                            {
                                "SubClass": "D",
                                "SeatAvb": "7",
                                "TotalFare": "1496000",
                                "TotalNTA": 1431000,
                                "selectedIDdep": "457063"
                            },
                            {
                                "SubClass": "C",
                                "SeatAvb": "7",
                                "TotalFare": "2035000",
                                "TotalNTA": 1970000,
                                "selectedIDdep": "457064"
                            }
                        ]
                    ]
                },
                {
                    "Flights": [
                        {
                            "FlightNo": "ID6368",
                            "Transit": 0,
                            "STD": "CGK",
                            "STA": "JOG",
                            "ETD": "2017-03-08 11:50",
                            "ETA": "2017-03-08 13:00"
                        }
                    ],
                    "Fares": [
                        [
                            {
                                "SubClass": "T",
                                "SeatAvb": "7",
                                "TotalFare": "498000",
                                "TotalNTA": 433000,
                                "selectedIDdep": "457065"
                            },
                            {
                                "SubClass": "Q",
                                "SeatAvb": "7",
                                "TotalFare": "506000",
                                "TotalNTA": 441000,
                                "selectedIDdep": "457066"
                            },
                            {
                                "SubClass": "N",
                                "SeatAvb": "7",
                                "TotalFare": "575000",
                                "TotalNTA": 510000,
                                "selectedIDdep": "457067"
                            },
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "619000",
                                "TotalNTA": 554000,
                                "selectedIDdep": "457068"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "663000",
                                "TotalNTA": 598000,
                                "selectedIDdep": "457069"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "693000",
                                "TotalNTA": 628000,
                                "selectedIDdep": "457070"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "748000",
                                "TotalNTA": 683000,
                                "selectedIDdep": "457071"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "803000",
                                "TotalNTA": 738000,
                                "selectedIDdep": "457072"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "869000",
                                "TotalNTA": 804000,
                                "selectedIDdep": "457073"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "960000",
                                "TotalNTA": 895000,
                                "selectedIDdep": "457074"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "1026000",
                                "TotalNTA": 961000,
                                "selectedIDdep": "457075"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "1078000",
                                "TotalNTA": 1013000,
                                "selectedIDdep": "457076"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "1152800",
                                "TotalNTA": 1087800,
                                "selectedIDdep": "457077"
                            },
                            {
                                "SubClass": "Z",
                                "SeatAvb": "3",
                                "TotalFare": "798000",
                                "TotalNTA": 733000,
                                "selectedIDdep": "457078"
                            },
                            {
                                "SubClass": "I",
                                "SeatAvb": "5",
                                "TotalFare": "1078000",
                                "TotalNTA": 1013000,
                                "selectedIDdep": "457079"
                            },
                            {
                                "SubClass": "D",
                                "SeatAvb": "7",
                                "TotalFare": "1496000",
                                "TotalNTA": 1431000,
                                "selectedIDdep": "457080"
                            },
                            {
                                "SubClass": "C",
                                "SeatAvb": "7",
                                "TotalFare": "2035000",
                                "TotalNTA": 1970000,
                                "selectedIDdep": "457081"
                            }
                        ]
                    ]
                },
                {
                    "Flights": [
                        {
                            "FlightNo": "JT554",
                            "Transit": 0,
                            "STD": "CGK",
                            "STA": "JOG",
                            "ETD": "2017-03-08 17:00",
                            "ETA": "2017-03-08 18:10"
                        }
                    ],
                    "Fares": [
                        [
                            {
                                "SubClass": "X",
                                "SeatAvb": "5",
                                "TotalFare": "360500",
                                "TotalNTA": 295500,
                                "selectedIDdep": "457082"
                            },
                            {
                                "SubClass": "V",
                                "SeatAvb": "7",
                                "TotalFare": "363000",
                                "TotalNTA": 298000,
                                "selectedIDdep": "457083"
                            },
                            {
                                "SubClass": "T",
                                "SeatAvb": "7",
                                "TotalFare": "407000",
                                "TotalNTA": 342000,
                                "selectedIDdep": "457084"
                            },
                            {
                                "SubClass": "Q",
                                "SeatAvb": "7",
                                "TotalFare": "440000",
                                "TotalNTA": 375000,
                                "selectedIDdep": "457085"
                            },
                            {
                                "SubClass": "N",
                                "SeatAvb": "7",
                                "TotalFare": "484000",
                                "TotalNTA": 419000,
                                "selectedIDdep": "457086"
                            },
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "542000",
                                "TotalNTA": 477000,
                                "selectedIDdep": "457087"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "550000",
                                "TotalNTA": 485000,
                                "selectedIDdep": "457088"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "605000",
                                "TotalNTA": 540000,
                                "selectedIDdep": "457089"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "649000",
                                "TotalNTA": 584000,
                                "selectedIDdep": "457090"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "693000",
                                "TotalNTA": 628000,
                                "selectedIDdep": "457091"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "748000",
                                "TotalNTA": 683000,
                                "selectedIDdep": "457092"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "828000",
                                "TotalNTA": 763000,
                                "selectedIDdep": "457093"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "858000",
                                "TotalNTA": 793000,
                                "selectedIDdep": "457094"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "924000",
                                "TotalNTA": 859000,
                                "selectedIDdep": "457095"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "987800",
                                "TotalNTA": 922800,
                                "selectedIDdep": "457096"
                            }
                        ]
                    ]
                },
                {
                    "Flights": [
                        {
                            "FlightNo": "JT564",
                            "Transit": 0,
                            "STD": "CGK",
                            "STA": "JOG",
                            "ETD": "2017-03-08 18:05",
                            "ETA": "2017-03-08 19:15"
                        }
                    ],
                    "Fares": [
                        [
                            {
                                "SubClass": "X",
                                "SeatAvb": "5",
                                "TotalFare": "360500",
                                "TotalNTA": 295500,
                                "selectedIDdep": "457097"
                            },
                            {
                                "SubClass": "V",
                                "SeatAvb": "7",
                                "TotalFare": "363000",
                                "TotalNTA": 298000,
                                "selectedIDdep": "457098"
                            },
                            {
                                "SubClass": "T",
                                "SeatAvb": "7",
                                "TotalFare": "407000",
                                "TotalNTA": 342000,
                                "selectedIDdep": "457099"
                            },
                            {
                                "SubClass": "Q",
                                "SeatAvb": "7",
                                "TotalFare": "440000",
                                "TotalNTA": 375000,
                                "selectedIDdep": "457100"
                            },
                            {
                                "SubClass": "N",
                                "SeatAvb": "7",
                                "TotalFare": "484000",
                                "TotalNTA": 419000,
                                "selectedIDdep": "457101"
                            },
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "542000",
                                "TotalNTA": 477000,
                                "selectedIDdep": "457102"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "550000",
                                "TotalNTA": 485000,
                                "selectedIDdep": "457103"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "605000",
                                "TotalNTA": 540000,
                                "selectedIDdep": "457104"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "649000",
                                "TotalNTA": 584000,
                                "selectedIDdep": "457105"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "693000",
                                "TotalNTA": 628000,
                                "selectedIDdep": "457106"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "748000",
                                "TotalNTA": 683000,
                                "selectedIDdep": "457107"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "828000",
                                "TotalNTA": 763000,
                                "selectedIDdep": "457108"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "858000",
                                "TotalNTA": 793000,
                                "selectedIDdep": "457109"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "924000",
                                "TotalNTA": 859000,
                                "selectedIDdep": "457110"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "987800",
                                "TotalNTA": 922800,
                                "selectedIDdep": "457111"
                            }
                        ]
                    ]
                },
                {
                    "Flights": [
                        {
                            "FlightNo": "JT568",
                            "Transit": 0,
                            "STD": "CGK",
                            "STA": "JOG",
                            "ETD": "2017-03-08 19:00",
                            "ETA": "2017-03-08 20:10"
                        }
                    ],
                    "Fares": [
                        [
                            {
                                "SubClass": "X",
                                "SeatAvb": "5",
                                "TotalFare": "360500",
                                "TotalNTA": 295500,
                                "selectedIDdep": "457112"
                            },
                            {
                                "SubClass": "V",
                                "SeatAvb": "7",
                                "TotalFare": "363000",
                                "TotalNTA": 298000,
                                "selectedIDdep": "457113"
                            },
                            {
                                "SubClass": "T",
                                "SeatAvb": "7",
                                "TotalFare": "407000",
                                "TotalNTA": 342000,
                                "selectedIDdep": "457114"
                            },
                            {
                                "SubClass": "Q",
                                "SeatAvb": "7",
                                "TotalFare": "440000",
                                "TotalNTA": 375000,
                                "selectedIDdep": "457115"
                            },
                            {
                                "SubClass": "N",
                                "SeatAvb": "7",
                                "TotalFare": "484000",
                                "TotalNTA": 419000,
                                "selectedIDdep": "457116"
                            },
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "542000",
                                "TotalNTA": 477000,
                                "selectedIDdep": "457117"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "550000",
                                "TotalNTA": 485000,
                                "selectedIDdep": "457118"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "605000",
                                "TotalNTA": 540000,
                                "selectedIDdep": "457119"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "649000",
                                "TotalNTA": 584000,
                                "selectedIDdep": "457120"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "693000",
                                "TotalNTA": 628000,
                                "selectedIDdep": "457121"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "748000",
                                "TotalNTA": 683000,
                                "selectedIDdep": "457122"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "828000",
                                "TotalNTA": 763000,
                                "selectedIDdep": "457123"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "858000",
                                "TotalNTA": 793000,
                                "selectedIDdep": "457124"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "924000",
                                "TotalNTA": 859000,
                                "selectedIDdep": "457125"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "987800",
                                "TotalNTA": 922800,
                                "selectedIDdep": "457126"
                            }
                        ]
                    ]
                },
                {
                    "Flights": [
                        {
                            "FlightNo": "ID6596",
                            "Transit": 0,
                            "STD": "CGK",
                            "STA": "SUB",
                            "ETD": "2017-03-08 04:30",
                            "ETA": "2017-03-08 06:00"
                        },
                        {
                            "FlightNo": "IW1843",
                            "Transit": 0,
                            "STD": "SUB",
                            "STA": "JOG",
                            "ETD": "2017-03-08 07:30",
                            "ETA": "2017-03-08 08:40"
                        }
                    ],
                    "Fares": [
                        [
                            {
                                "SubClass": "T",
                                "SeatAvb": "7",
                                "TotalFare": "616000",
                                "TotalNTA": 551000,
                                "selectedIDdep": "457127"
                            },
                            {
                                "SubClass": "Q",
                                "SeatAvb": "7",
                                "TotalFare": "707000",
                                "TotalNTA": 642000,
                                "selectedIDdep": "457128"
                            },
                            {
                                "SubClass": "N",
                                "SeatAvb": "7",
                                "TotalFare": "737000",
                                "TotalNTA": 672000,
                                "selectedIDdep": "457129"
                            },
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "803000",
                                "TotalNTA": 738000,
                                "selectedIDdep": "457130"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "858000",
                                "TotalNTA": 793000,
                                "selectedIDdep": "457131"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "960000",
                                "TotalNTA": 895000,
                                "selectedIDdep": "457132"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "1012000",
                                "TotalNTA": 947000,
                                "selectedIDdep": "457133"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "1089000",
                                "TotalNTA": 1024000,
                                "selectedIDdep": "457134"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "1177000",
                                "TotalNTA": 1112000,
                                "selectedIDdep": "457135"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "1265000",
                                "TotalNTA": 1200000,
                                "selectedIDdep": "457136"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "1353000",
                                "TotalNTA": 1288000,
                                "selectedIDdep": "457137"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "1463000",
                                "TotalNTA": 1398000,
                                "selectedIDdep": "457138"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "1564200",
                                "TotalNTA": 1499200,
                                "selectedIDdep": "457139"
                            },
                            {
                                "SubClass": "Z",
                                "SeatAvb": "3",
                                "TotalFare": "960000",
                                "TotalNTA": 895000,
                                "selectedIDdep": "457140"
                            },
                            {
                                "SubClass": "I",
                                "SeatAvb": "5",
                                "TotalFare": "1463000",
                                "TotalNTA": 1398000,
                                "selectedIDdep": "457141"
                            },
                            {
                                "SubClass": "D",
                                "SeatAvb": "7",
                                "TotalFare": "2035000",
                                "TotalNTA": 1970000,
                                "selectedIDdep": "457142"
                            },
                            {
                                "SubClass": "C",
                                "SeatAvb": "7",
                                "TotalFare": "2772000",
                                "TotalNTA": 2707000,
                                "selectedIDdep": "457143"
                            }
                        ],
                        [
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "603000",
                                "TotalNTA": 598000,
                                "selectedIDdep": "457144"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "647000",
                                "TotalNTA": 642000,
                                "selectedIDdep": "457145"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "702000",
                                "TotalNTA": 697000,
                                "selectedIDdep": "457146"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "768000",
                                "TotalNTA": 763000,
                                "selectedIDdep": "457147"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "823000",
                                "TotalNTA": 818000,
                                "selectedIDdep": "457148"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "889000",
                                "TotalNTA": 884000,
                                "selectedIDdep": "457149"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "966000",
                                "TotalNTA": 961000,
                                "selectedIDdep": "457150"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "1032000",
                                "TotalNTA": 1027000,
                                "selectedIDdep": "457151"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "1120000",
                                "TotalNTA": 1115000,
                                "selectedIDdep": "457152"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "1192600",
                                "TotalNTA": 1187600,
                                "selectedIDdep": "457153"
                            }
                        ]
                    ]
                },
                {
                    "Flights": [
                        {
                            "FlightNo": "JT690",
                            "Transit": 0,
                            "STD": "CGK",
                            "STA": "SUB",
                            "ETD": "2017-03-08 05:00",
                            "ETA": "2017-03-08 06:30"
                        },
                        {
                            "FlightNo": "IW1843",
                            "Transit": 0,
                            "STD": "SUB",
                            "STA": "JOG",
                            "ETD": "2017-03-08 07:30",
                            "ETA": "2017-03-08 08:40"
                        }
                    ],
                    "Fares": [
                        [
                            {
                                "SubClass": "X",
                                "SeatAvb": "7",
                                "TotalFare": "465000",
                                "TotalNTA": 400000,
                                "selectedIDdep": "457154"
                            },
                            {
                                "SubClass": "V",
                                "SeatAvb": "7",
                                "TotalFare": "484000",
                                "TotalNTA": 419000,
                                "selectedIDdep": "457155"
                            },
                            {
                                "SubClass": "T",
                                "SeatAvb": "7",
                                "TotalFare": "564000",
                                "TotalNTA": 499000,
                                "selectedIDdep": "457156"
                            },
                            {
                                "SubClass": "Q",
                                "SeatAvb": "7",
                                "TotalFare": "608000",
                                "TotalNTA": 543000,
                                "selectedIDdep": "457157"
                            },
                            {
                                "SubClass": "N",
                                "SeatAvb": "7",
                                "TotalFare": "638000",
                                "TotalNTA": 573000,
                                "selectedIDdep": "457158"
                            },
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "693000",
                                "TotalNTA": 628000,
                                "selectedIDdep": "457159"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "737000",
                                "TotalNTA": 672000,
                                "selectedIDdep": "457160"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "803000",
                                "TotalNTA": 738000,
                                "selectedIDdep": "457161"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "869000",
                                "TotalNTA": 804000,
                                "selectedIDdep": "457162"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "935000",
                                "TotalNTA": 870000,
                                "selectedIDdep": "457163"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "1012000",
                                "TotalNTA": 947000,
                                "selectedIDdep": "457164"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "1089000",
                                "TotalNTA": 1024000,
                                "selectedIDdep": "457165"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "1166000",
                                "TotalNTA": 1101000,
                                "selectedIDdep": "457166"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "1254000",
                                "TotalNTA": 1189000,
                                "selectedIDdep": "457167"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "1337600",
                                "TotalNTA": 1272600,
                                "selectedIDdep": "457168"
                            }
                        ],
                        [
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "603000",
                                "TotalNTA": 598000,
                                "selectedIDdep": "457169"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "647000",
                                "TotalNTA": 642000,
                                "selectedIDdep": "457170"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "702000",
                                "TotalNTA": 697000,
                                "selectedIDdep": "457171"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "768000",
                                "TotalNTA": 763000,
                                "selectedIDdep": "457172"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "823000",
                                "TotalNTA": 818000,
                                "selectedIDdep": "457173"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "889000",
                                "TotalNTA": 884000,
                                "selectedIDdep": "457174"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "966000",
                                "TotalNTA": 961000,
                                "selectedIDdep": "457175"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "1032000",
                                "TotalNTA": 1027000,
                                "selectedIDdep": "457176"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "1120000",
                                "TotalNTA": 1115000,
                                "selectedIDdep": "457177"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "1192600",
                                "TotalNTA": 1187600,
                                "selectedIDdep": "457178"
                            }
                        ]
                    ]
                },
                {
                    "Flights": [
                        {
                            "FlightNo": "JT30",
                            "Transit": 0,
                            "STD": "CGK",
                            "STA": "DPS",
                            "ETD": "2017-03-08 05:40",
                            "ETA": "2017-03-08 08:30"
                        },
                        {
                            "FlightNo": "JT569",
                            "Transit": 0,
                            "STD": "DPS",
                            "STA": "JOG",
                            "ETD": "2017-03-08 10:25",
                            "ETA": "2017-03-08 10:40"
                        }
                    ],
                    "Fares": [
                        [
                            {
                                "SubClass": "Q",
                                "SeatAvb": "5",
                                "TotalFare": "703000",
                                "TotalNTA": 638000,
                                "selectedIDdep": "457179"
                            },
                            {
                                "SubClass": "N",
                                "SeatAvb": "7",
                                "TotalFare": "769000",
                                "TotalNTA": 704000,
                                "selectedIDdep": "457180"
                            },
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "824000",
                                "TotalNTA": 759000,
                                "selectedIDdep": "457181"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "890000",
                                "TotalNTA": 825000,
                                "selectedIDdep": "457182"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "967000",
                                "TotalNTA": 902000,
                                "selectedIDdep": "457183"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "1034000",
                                "TotalNTA": 969000,
                                "selectedIDdep": "457184"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "1111000",
                                "TotalNTA": 1046000,
                                "selectedIDdep": "457185"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "1209000",
                                "TotalNTA": 1144000,
                                "selectedIDdep": "457186"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "1308000",
                                "TotalNTA": 1243000,
                                "selectedIDdep": "457187"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "1386000",
                                "TotalNTA": 1321000,
                                "selectedIDdep": "457188"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "1496000",
                                "TotalNTA": 1431000,
                                "selectedIDdep": "457189"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "1598300",
                                "TotalNTA": 1533300,
                                "selectedIDdep": "457190"
                            }
                        ],
                        [
                            {
                                "SubClass": "X",
                                "SeatAvb": "7",
                                "TotalFare": "400600",
                                "TotalNTA": 395600,
                                "selectedIDdep": "457191"
                            },
                            {
                                "SubClass": "V",
                                "SeatAvb": "7",
                                "TotalFare": "423000",
                                "TotalNTA": 418000,
                                "selectedIDdep": "457192"
                            },
                            {
                                "SubClass": "T",
                                "SeatAvb": "7",
                                "TotalFare": "478000",
                                "TotalNTA": 473000,
                                "selectedIDdep": "457193"
                            },
                            {
                                "SubClass": "Q",
                                "SeatAvb": "7",
                                "TotalFare": "548000",
                                "TotalNTA": 543000,
                                "selectedIDdep": "457194"
                            },
                            {
                                "SubClass": "N",
                                "SeatAvb": "7",
                                "TotalFare": "577000",
                                "TotalNTA": 572000,
                                "selectedIDdep": "457195"
                            },
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "632000",
                                "TotalNTA": 627000,
                                "selectedIDdep": "457196"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "676000",
                                "TotalNTA": 671000,
                                "selectedIDdep": "457197"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "742000",
                                "TotalNTA": 737000,
                                "selectedIDdep": "457198"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "808000",
                                "TotalNTA": 803000,
                                "selectedIDdep": "457199"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "874000",
                                "TotalNTA": 869000,
                                "selectedIDdep": "457200"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "951000",
                                "TotalNTA": 946000,
                                "selectedIDdep": "457201"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "1017000",
                                "TotalNTA": 1012000,
                                "selectedIDdep": "457202"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "1094000",
                                "TotalNTA": 1089000,
                                "selectedIDdep": "457203"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "1182000",
                                "TotalNTA": 1177000,
                                "selectedIDdep": "457204"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "1270000",
                                "TotalNTA": 1265000,
                                "selectedIDdep": "457205"
                            }
                        ]
                    ]
                },
                {
                    "Flights": [
                        {
                            "FlightNo": "JT34",
                            "Transit": 0,
                            "STD": "CGK",
                            "STA": "DPS",
                            "ETD": "2017-03-08 04:30",
                            "ETA": "2017-03-08 07:20"
                        },
                        {
                            "FlightNo": "JT569",
                            "Transit": 0,
                            "STD": "DPS",
                            "STA": "JOG",
                            "ETD": "2017-03-08 10:25",
                            "ETA": "2017-03-08 10:40"
                        }
                    ],
                    "Fares": [
                        [
                            {
                                "SubClass": "Q",
                                "SeatAvb": "5",
                                "TotalFare": "703000",
                                "TotalNTA": 638000,
                                "selectedIDdep": "457206"
                            },
                            {
                                "SubClass": "N",
                                "SeatAvb": "7",
                                "TotalFare": "769000",
                                "TotalNTA": 704000,
                                "selectedIDdep": "457207"
                            },
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "824000",
                                "TotalNTA": 759000,
                                "selectedIDdep": "457208"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "890000",
                                "TotalNTA": 825000,
                                "selectedIDdep": "457209"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "967000",
                                "TotalNTA": 902000,
                                "selectedIDdep": "457210"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "1034000",
                                "TotalNTA": 969000,
                                "selectedIDdep": "457211"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "1111000",
                                "TotalNTA": 1046000,
                                "selectedIDdep": "457212"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "1209000",
                                "TotalNTA": 1144000,
                                "selectedIDdep": "457213"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "1308000",
                                "TotalNTA": 1243000,
                                "selectedIDdep": "457214"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "1386000",
                                "TotalNTA": 1321000,
                                "selectedIDdep": "457215"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "1496000",
                                "TotalNTA": 1431000,
                                "selectedIDdep": "457216"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "1598300",
                                "TotalNTA": 1533300,
                                "selectedIDdep": "457217"
                            }
                        ],
                        [
                            {
                                "SubClass": "X",
                                "SeatAvb": "7",
                                "TotalFare": "400600",
                                "TotalNTA": 395600,
                                "selectedIDdep": "457218"
                            },
                            {
                                "SubClass": "V",
                                "SeatAvb": "7",
                                "TotalFare": "423000",
                                "TotalNTA": 418000,
                                "selectedIDdep": "457219"
                            },
                            {
                                "SubClass": "T",
                                "SeatAvb": "7",
                                "TotalFare": "478000",
                                "TotalNTA": 473000,
                                "selectedIDdep": "457220"
                            },
                            {
                                "SubClass": "Q",
                                "SeatAvb": "7",
                                "TotalFare": "548000",
                                "TotalNTA": 543000,
                                "selectedIDdep": "457221"
                            },
                            {
                                "SubClass": "N",
                                "SeatAvb": "7",
                                "TotalFare": "577000",
                                "TotalNTA": 572000,
                                "selectedIDdep": "457222"
                            },
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "632000",
                                "TotalNTA": 627000,
                                "selectedIDdep": "457223"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "676000",
                                "TotalNTA": 671000,
                                "selectedIDdep": "457224"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "742000",
                                "TotalNTA": 737000,
                                "selectedIDdep": "457225"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "808000",
                                "TotalNTA": 803000,
                                "selectedIDdep": "457226"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "874000",
                                "TotalNTA": 869000,
                                "selectedIDdep": "457227"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "951000",
                                "TotalNTA": 946000,
                                "selectedIDdep": "457228"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "1017000",
                                "TotalNTA": 1012000,
                                "selectedIDdep": "457229"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "1094000",
                                "TotalNTA": 1089000,
                                "selectedIDdep": "457230"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "1182000",
                                "TotalNTA": 1177000,
                                "selectedIDdep": "457231"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "1270000",
                                "TotalNTA": 1265000,
                                "selectedIDdep": "457232"
                            }
                        ]
                    ]
                },
                {
                    "Flights": [
                        {
                            "FlightNo": "ID6370",
                            "Transit": 0,
                            "STD": "CGK",
                            "STA": "SUB",
                            "ETD": "2017-03-08 06:00",
                            "ETA": "2017-03-08 07:30"
                        },
                        {
                            "FlightNo": "IW1811",
                            "Transit": 0,
                            "STD": "SUB",
                            "STA": "JOG",
                            "ETD": "2017-03-08 11:10",
                            "ETA": "2017-03-08 12:20"
                        }
                    ],
                    "Fares": [
                        [
                            {
                                "SubClass": "T",
                                "SeatAvb": "7",
                                "TotalFare": "616000",
                                "TotalNTA": 551000,
                                "selectedIDdep": "457233"
                            },
                            {
                                "SubClass": "Q",
                                "SeatAvb": "7",
                                "TotalFare": "707000",
                                "TotalNTA": 642000,
                                "selectedIDdep": "457234"
                            },
                            {
                                "SubClass": "N",
                                "SeatAvb": "7",
                                "TotalFare": "737000",
                                "TotalNTA": 672000,
                                "selectedIDdep": "457235"
                            },
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "803000",
                                "TotalNTA": 738000,
                                "selectedIDdep": "457236"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "858000",
                                "TotalNTA": 793000,
                                "selectedIDdep": "457237"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "960000",
                                "TotalNTA": 895000,
                                "selectedIDdep": "457238"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "1012000",
                                "TotalNTA": 947000,
                                "selectedIDdep": "457239"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "1089000",
                                "TotalNTA": 1024000,
                                "selectedIDdep": "457240"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "1177000",
                                "TotalNTA": 1112000,
                                "selectedIDdep": "457241"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "1265000",
                                "TotalNTA": 1200000,
                                "selectedIDdep": "457242"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "1353000",
                                "TotalNTA": 1288000,
                                "selectedIDdep": "457243"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "1463000",
                                "TotalNTA": 1398000,
                                "selectedIDdep": "457244"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "1564200",
                                "TotalNTA": 1499200,
                                "selectedIDdep": "457245"
                            },
                            {
                                "SubClass": "Z",
                                "SeatAvb": "3",
                                "TotalFare": "960000",
                                "TotalNTA": 895000,
                                "selectedIDdep": "457246"
                            },
                            {
                                "SubClass": "I",
                                "SeatAvb": "5",
                                "TotalFare": "1463000",
                                "TotalNTA": 1398000,
                                "selectedIDdep": "457247"
                            },
                            {
                                "SubClass": "D",
                                "SeatAvb": "7",
                                "TotalFare": "2035000",
                                "TotalNTA": 1970000,
                                "selectedIDdep": "457248"
                            },
                            {
                                "SubClass": "C",
                                "SeatAvb": "7",
                                "TotalFare": "2772000",
                                "TotalNTA": 2707000,
                                "selectedIDdep": "457249"
                            }
                        ],
                        [
                            {
                                "SubClass": "N",
                                "SeatAvb": "7",
                                "TotalFare": "548000",
                                "TotalNTA": 543000,
                                "selectedIDdep": "457250"
                            },
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "603000",
                                "TotalNTA": 598000,
                                "selectedIDdep": "457251"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "647000",
                                "TotalNTA": 642000,
                                "selectedIDdep": "457252"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "702000",
                                "TotalNTA": 697000,
                                "selectedIDdep": "457253"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "768000",
                                "TotalNTA": 763000,
                                "selectedIDdep": "457254"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "823000",
                                "TotalNTA": 818000,
                                "selectedIDdep": "457255"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "889000",
                                "TotalNTA": 884000,
                                "selectedIDdep": "457256"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "966000",
                                "TotalNTA": 961000,
                                "selectedIDdep": "457257"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "1032000",
                                "TotalNTA": 1027000,
                                "selectedIDdep": "457258"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "1120000",
                                "TotalNTA": 1115000,
                                "selectedIDdep": "457259"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "1192600",
                                "TotalNTA": 1187600,
                                "selectedIDdep": "457260"
                            }
                        ]
                    ]
                }
            ],
            "return": [
                {
                    "Flights": [
                        {
                            "FlightNo": "JT565",
                            "Transit": 0,
                            "STD": "JOG",
                            "STA": "CGK",
                            "ETD": "2017-03-29 07:30",
                            "ETA": "2017-03-29 08:45"
                        }
                    ],
                    "Fares": [
                        [
                            {
                                "SubClass": "X",
                                "SeatAvb": "1",
                                "TotalFare": "335500",
                                "TotalNTA": 295500,
                                "selectedIDret": "457261"
                            },
                            {
                                "SubClass": "V",
                                "SeatAvb": "7",
                                "TotalFare": "338000",
                                "TotalNTA": 298000,
                                "selectedIDret": "457262"
                            },
                            {
                                "SubClass": "T",
                                "SeatAvb": "7",
                                "TotalFare": "382000",
                                "TotalNTA": 342000,
                                "selectedIDret": "457263"
                            },
                            {
                                "SubClass": "Q",
                                "SeatAvb": "7",
                                "TotalFare": "415000",
                                "TotalNTA": 375000,
                                "selectedIDret": "457264"
                            },
                            {
                                "SubClass": "N",
                                "SeatAvb": "7",
                                "TotalFare": "459000",
                                "TotalNTA": 419000,
                                "selectedIDret": "457265"
                            },
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "517000",
                                "TotalNTA": 477000,
                                "selectedIDret": "457266"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "525000",
                                "TotalNTA": 485000,
                                "selectedIDret": "457267"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "580000",
                                "TotalNTA": 540000,
                                "selectedIDret": "457268"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "624000",
                                "TotalNTA": 584000,
                                "selectedIDret": "457269"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "668000",
                                "TotalNTA": 628000,
                                "selectedIDret": "457270"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "723000",
                                "TotalNTA": 683000,
                                "selectedIDret": "457271"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "803000",
                                "TotalNTA": 763000,
                                "selectedIDret": "457272"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "833000",
                                "TotalNTA": 793000,
                                "selectedIDret": "457273"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "899000",
                                "TotalNTA": 859000,
                                "selectedIDret": "457274"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "962800",
                                "TotalNTA": 922800,
                                "selectedIDret": "457275"
                            }
                        ]
                    ]
                },
                {
                    "Flights": [
                        {
                            "FlightNo": "JT561",
                            "Transit": 0,
                            "STD": "JOG",
                            "STA": "CGK",
                            "ETD": "2017-03-29 07:50",
                            "ETA": "2017-03-29 09:00"
                        }
                    ],
                    "Fares": [
                        [
                            {
                                "SubClass": "V",
                                "SeatAvb": "2",
                                "TotalFare": "338000",
                                "TotalNTA": 298000,
                                "selectedIDret": "457276"
                            },
                            {
                                "SubClass": "T",
                                "SeatAvb": "7",
                                "TotalFare": "382000",
                                "TotalNTA": 342000,
                                "selectedIDret": "457277"
                            },
                            {
                                "SubClass": "Q",
                                "SeatAvb": "7",
                                "TotalFare": "415000",
                                "TotalNTA": 375000,
                                "selectedIDret": "457278"
                            },
                            {
                                "SubClass": "N",
                                "SeatAvb": "7",
                                "TotalFare": "459000",
                                "TotalNTA": 419000,
                                "selectedIDret": "457279"
                            },
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "517000",
                                "TotalNTA": 477000,
                                "selectedIDret": "457280"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "525000",
                                "TotalNTA": 485000,
                                "selectedIDret": "457281"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "580000",
                                "TotalNTA": 540000,
                                "selectedIDret": "457282"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "624000",
                                "TotalNTA": 584000,
                                "selectedIDret": "457283"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "668000",
                                "TotalNTA": 628000,
                                "selectedIDret": "457284"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "723000",
                                "TotalNTA": 683000,
                                "selectedIDret": "457285"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "803000",
                                "TotalNTA": 763000,
                                "selectedIDret": "457286"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "833000",
                                "TotalNTA": 793000,
                                "selectedIDret": "457287"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "899000",
                                "TotalNTA": 859000,
                                "selectedIDret": "457288"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "962800",
                                "TotalNTA": 922800,
                                "selectedIDret": "457289"
                            }
                        ]
                    ]
                },
                {
                    "Flights": [
                        {
                            "FlightNo": "ID6369",
                            "Transit": 0,
                            "STD": "JOG",
                            "STA": "CGK",
                            "ETD": "2017-03-29 09:45",
                            "ETA": "2017-03-29 11:00"
                        }
                    ],
                    "Fares": [
                        [
                            {
                                "SubClass": "Q",
                                "SeatAvb": "7",
                                "TotalFare": "481000",
                                "TotalNTA": 441000,
                                "selectedIDret": "457290"
                            },
                            {
                                "SubClass": "N",
                                "SeatAvb": "7",
                                "TotalFare": "550000",
                                "TotalNTA": 510000,
                                "selectedIDret": "457291"
                            },
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "594000",
                                "TotalNTA": 554000,
                                "selectedIDret": "457292"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "638000",
                                "TotalNTA": 598000,
                                "selectedIDret": "457293"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "668000",
                                "TotalNTA": 628000,
                                "selectedIDret": "457294"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "723000",
                                "TotalNTA": 683000,
                                "selectedIDret": "457295"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "778000",
                                "TotalNTA": 738000,
                                "selectedIDret": "457296"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "844000",
                                "TotalNTA": 804000,
                                "selectedIDret": "457297"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "935000",
                                "TotalNTA": 895000,
                                "selectedIDret": "457298"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "1001000",
                                "TotalNTA": 961000,
                                "selectedIDret": "457299"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "1053000",
                                "TotalNTA": 1013000,
                                "selectedIDret": "457300"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "1127800",
                                "TotalNTA": 1087800,
                                "selectedIDret": "457301"
                            },
                            {
                                "SubClass": "Z",
                                "SeatAvb": "2",
                                "TotalFare": "773000",
                                "TotalNTA": 733000,
                                "selectedIDret": "457302"
                            },
                            {
                                "SubClass": "I",
                                "SeatAvb": "3",
                                "TotalFare": "1053000",
                                "TotalNTA": 1013000,
                                "selectedIDret": "457303"
                            },
                            {
                                "SubClass": "D",
                                "SeatAvb": "5",
                                "TotalFare": "1471000",
                                "TotalNTA": 1431000,
                                "selectedIDret": "457304"
                            },
                            {
                                "SubClass": "C",
                                "SeatAvb": "7",
                                "TotalFare": "2010000",
                                "TotalNTA": 1970000,
                                "selectedIDret": "457305"
                            }
                        ]
                    ]
                },
                {
                    "Flights": [
                        {
                            "FlightNo": "ID6375",
                            "Transit": 0,
                            "STD": "JOG",
                            "STA": "CGK",
                            "ETD": "2017-03-29 17:45",
                            "ETA": "2017-03-29 19:00"
                        }
                    ],
                    "Fares": [
                        [
                            {
                                "SubClass": "Q",
                                "SeatAvb": "7",
                                "TotalFare": "481000",
                                "TotalNTA": 441000,
                                "selectedIDret": "457306"
                            },
                            {
                                "SubClass": "N",
                                "SeatAvb": "7",
                                "TotalFare": "550000",
                                "TotalNTA": 510000,
                                "selectedIDret": "457307"
                            },
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "594000",
                                "TotalNTA": 554000,
                                "selectedIDret": "457308"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "638000",
                                "TotalNTA": 598000,
                                "selectedIDret": "457309"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "668000",
                                "TotalNTA": 628000,
                                "selectedIDret": "457310"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "723000",
                                "TotalNTA": 683000,
                                "selectedIDret": "457311"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "778000",
                                "TotalNTA": 738000,
                                "selectedIDret": "457312"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "844000",
                                "TotalNTA": 804000,
                                "selectedIDret": "457313"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "935000",
                                "TotalNTA": 895000,
                                "selectedIDret": "457314"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "1001000",
                                "TotalNTA": 961000,
                                "selectedIDret": "457315"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "1053000",
                                "TotalNTA": 1013000,
                                "selectedIDret": "457316"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "1127800",
                                "TotalNTA": 1087800,
                                "selectedIDret": "457317"
                            },
                            {
                                "SubClass": "Z",
                                "SeatAvb": "1",
                                "TotalFare": "773000",
                                "TotalNTA": 733000,
                                "selectedIDret": "457318"
                            },
                            {
                                "SubClass": "I",
                                "SeatAvb": "2",
                                "TotalFare": "1053000",
                                "TotalNTA": 1013000,
                                "selectedIDret": "457319"
                            },
                            {
                                "SubClass": "D",
                                "SeatAvb": "4",
                                "TotalFare": "1471000",
                                "TotalNTA": 1431000,
                                "selectedIDret": "457320"
                            },
                            {
                                "SubClass": "C",
                                "SeatAvb": "7",
                                "TotalFare": "2010000",
                                "TotalNTA": 1970000,
                                "selectedIDret": "457321"
                            }
                        ]
                    ]
                },
                {
                    "Flights": [
                        {
                            "FlightNo": "JT555",
                            "Transit": 0,
                            "STD": "JOG",
                            "STA": "CGK",
                            "ETD": "2017-03-29 18:50",
                            "ETA": "2017-03-29 20:05"
                        }
                    ],
                    "Fares": [
                        [
                            {
                                "SubClass": "V",
                                "SeatAvb": "2",
                                "TotalFare": "338000",
                                "TotalNTA": 298000,
                                "selectedIDret": "457322"
                            },
                            {
                                "SubClass": "T",
                                "SeatAvb": "7",
                                "TotalFare": "382000",
                                "TotalNTA": 342000,
                                "selectedIDret": "457323"
                            },
                            {
                                "SubClass": "Q",
                                "SeatAvb": "7",
                                "TotalFare": "415000",
                                "TotalNTA": 375000,
                                "selectedIDret": "457324"
                            },
                            {
                                "SubClass": "N",
                                "SeatAvb": "7",
                                "TotalFare": "459000",
                                "TotalNTA": 419000,
                                "selectedIDret": "457325"
                            },
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "517000",
                                "TotalNTA": 477000,
                                "selectedIDret": "457326"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "525000",
                                "TotalNTA": 485000,
                                "selectedIDret": "457327"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "580000",
                                "TotalNTA": 540000,
                                "selectedIDret": "457328"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "624000",
                                "TotalNTA": 584000,
                                "selectedIDret": "457329"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "668000",
                                "TotalNTA": 628000,
                                "selectedIDret": "457330"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "723000",
                                "TotalNTA": 683000,
                                "selectedIDret": "457331"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "803000",
                                "TotalNTA": 763000,
                                "selectedIDret": "457332"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "833000",
                                "TotalNTA": 793000,
                                "selectedIDret": "457333"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "899000",
                                "TotalNTA": 859000,
                                "selectedIDret": "457334"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "962800",
                                "TotalNTA": 922800,
                                "selectedIDret": "457335"
                            }
                        ]
                    ]
                },
                {
                    "Flights": [
                        {
                            "FlightNo": "JT545",
                            "Transit": 0,
                            "STD": "JOG",
                            "STA": "CGK",
                            "ETD": "2017-03-29 20:00",
                            "ETA": "2017-03-29 21:15"
                        }
                    ],
                    "Fares": [
                        [
                            {
                                "SubClass": "V",
                                "SeatAvb": "2",
                                "TotalFare": "338000",
                                "TotalNTA": 298000,
                                "selectedIDret": "457336"
                            },
                            {
                                "SubClass": "T",
                                "SeatAvb": "7",
                                "TotalFare": "382000",
                                "TotalNTA": 342000,
                                "selectedIDret": "457337"
                            },
                            {
                                "SubClass": "Q",
                                "SeatAvb": "7",
                                "TotalFare": "415000",
                                "TotalNTA": 375000,
                                "selectedIDret": "457338"
                            },
                            {
                                "SubClass": "N",
                                "SeatAvb": "7",
                                "TotalFare": "459000",
                                "TotalNTA": 419000,
                                "selectedIDret": "457339"
                            },
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "517000",
                                "TotalNTA": 477000,
                                "selectedIDret": "457340"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "525000",
                                "TotalNTA": 485000,
                                "selectedIDret": "457341"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "580000",
                                "TotalNTA": 540000,
                                "selectedIDret": "457342"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "624000",
                                "TotalNTA": 584000,
                                "selectedIDret": "457343"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "668000",
                                "TotalNTA": 628000,
                                "selectedIDret": "457344"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "723000",
                                "TotalNTA": 683000,
                                "selectedIDret": "457345"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "803000",
                                "TotalNTA": 763000,
                                "selectedIDret": "457346"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "833000",
                                "TotalNTA": 793000,
                                "selectedIDret": "457347"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "899000",
                                "TotalNTA": 859000,
                                "selectedIDret": "457348"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "962800",
                                "TotalNTA": 922800,
                                "selectedIDret": "457349"
                            }
                        ]
                    ]
                },
                {
                    "Flights": [
                        {
                            "FlightNo": "ID6367",
                            "Transit": 0,
                            "STD": "JOG",
                            "STA": "CGK",
                            "ETD": "2017-03-29 20:20",
                            "ETA": "2017-03-29 21:35"
                        }
                    ],
                    "Fares": [
                        [
                            {
                                "SubClass": "Q",
                                "SeatAvb": "7",
                                "TotalFare": "481000",
                                "TotalNTA": 441000,
                                "selectedIDret": "457350"
                            },
                            {
                                "SubClass": "N",
                                "SeatAvb": "7",
                                "TotalFare": "550000",
                                "TotalNTA": 510000,
                                "selectedIDret": "457351"
                            },
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "594000",
                                "TotalNTA": 554000,
                                "selectedIDret": "457352"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "638000",
                                "TotalNTA": 598000,
                                "selectedIDret": "457353"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "668000",
                                "TotalNTA": 628000,
                                "selectedIDret": "457354"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "723000",
                                "TotalNTA": 683000,
                                "selectedIDret": "457355"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "778000",
                                "TotalNTA": 738000,
                                "selectedIDret": "457356"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "844000",
                                "TotalNTA": 804000,
                                "selectedIDret": "457357"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "935000",
                                "TotalNTA": 895000,
                                "selectedIDret": "457358"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "1001000",
                                "TotalNTA": 961000,
                                "selectedIDret": "457359"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "1053000",
                                "TotalNTA": 1013000,
                                "selectedIDret": "457360"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "1127800",
                                "TotalNTA": 1087800,
                                "selectedIDret": "457361"
                            },
                            {
                                "SubClass": "Z",
                                "SeatAvb": "2",
                                "TotalFare": "773000",
                                "TotalNTA": 733000,
                                "selectedIDret": "457362"
                            },
                            {
                                "SubClass": "I",
                                "SeatAvb": "3",
                                "TotalFare": "1053000",
                                "TotalNTA": 1013000,
                                "selectedIDret": "457363"
                            },
                            {
                                "SubClass": "D",
                                "SeatAvb": "5",
                                "TotalFare": "1471000",
                                "TotalNTA": 1431000,
                                "selectedIDret": "457364"
                            },
                            {
                                "SubClass": "C",
                                "SeatAvb": "7",
                                "TotalFare": "2010000",
                                "TotalNTA": 1970000,
                                "selectedIDret": "457365"
                            }
                        ]
                    ]
                },
                {
                    "Flights": [
                        {
                            "FlightNo": "IW1814",
                            "Transit": 0,
                            "STD": "JOG",
                            "STA": "SUB",
                            "ETD": "2017-03-29 06:00",
                            "ETA": "2017-03-29 07:10"
                        },
                        {
                            "FlightNo": "ID6391",
                            "Transit": 0,
                            "STD": "SUB",
                            "STA": "CGK",
                            "ETD": "2017-03-29 08:20",
                            "ETA": "2017-03-29 09:50"
                        }
                    ],
                    "Fares": [
                        [
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "638000",
                                "TotalNTA": 598000,
                                "selectedIDret": "457366"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "682000",
                                "TotalNTA": 642000,
                                "selectedIDret": "457367"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "737000",
                                "TotalNTA": 697000,
                                "selectedIDret": "457368"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "803000",
                                "TotalNTA": 763000,
                                "selectedIDret": "457369"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "858000",
                                "TotalNTA": 818000,
                                "selectedIDret": "457370"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "924000",
                                "TotalNTA": 884000,
                                "selectedIDret": "457371"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "1001000",
                                "TotalNTA": 961000,
                                "selectedIDret": "457372"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "1067000",
                                "TotalNTA": 1027000,
                                "selectedIDret": "457373"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "1155000",
                                "TotalNTA": 1115000,
                                "selectedIDret": "457374"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "1227600",
                                "TotalNTA": 1187600,
                                "selectedIDret": "457375"
                            }
                        ],
                        [
                            {
                                "SubClass": "T",
                                "SeatAvb": "7",
                                "TotalFare": "556000",
                                "TotalNTA": 551000,
                                "selectedIDret": "457376"
                            },
                            {
                                "SubClass": "Q",
                                "SeatAvb": "7",
                                "TotalFare": "647000",
                                "TotalNTA": 642000,
                                "selectedIDret": "457377"
                            },
                            {
                                "SubClass": "N",
                                "SeatAvb": "7",
                                "TotalFare": "677000",
                                "TotalNTA": 672000,
                                "selectedIDret": "457378"
                            },
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "743000",
                                "TotalNTA": 738000,
                                "selectedIDret": "457379"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "798000",
                                "TotalNTA": 793000,
                                "selectedIDret": "457380"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "900000",
                                "TotalNTA": 895000,
                                "selectedIDret": "457381"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "952000",
                                "TotalNTA": 947000,
                                "selectedIDret": "457382"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "1029000",
                                "TotalNTA": 1024000,
                                "selectedIDret": "457383"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "1117000",
                                "TotalNTA": 1112000,
                                "selectedIDret": "457384"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "1205000",
                                "TotalNTA": 1200000,
                                "selectedIDret": "457385"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "1293000",
                                "TotalNTA": 1288000,
                                "selectedIDret": "457386"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "1403000",
                                "TotalNTA": 1398000,
                                "selectedIDret": "457387"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "1504200",
                                "TotalNTA": 1499200,
                                "selectedIDret": "457388"
                            },
                            {
                                "SubClass": "Z",
                                "SeatAvb": "3",
                                "TotalFare": "900000",
                                "TotalNTA": 895000,
                                "selectedIDret": "457389"
                            },
                            {
                                "SubClass": "I",
                                "SeatAvb": "5",
                                "TotalFare": "1403000",
                                "TotalNTA": 1398000,
                                "selectedIDret": "457390"
                            },
                            {
                                "SubClass": "D",
                                "SeatAvb": "7",
                                "TotalFare": "1975000",
                                "TotalNTA": 1970000,
                                "selectedIDret": "457391"
                            },
                            {
                                "SubClass": "C",
                                "SeatAvb": "7",
                                "TotalFare": "2712000",
                                "TotalNTA": 2707000,
                                "selectedIDret": "457392"
                            }
                        ]
                    ]
                },
                {
                    "Flights": [
                        {
                            "FlightNo": "JT560",
                            "Transit": 0,
                            "STD": "JOG",
                            "STA": "DPS",
                            "ETD": "2017-03-29 07:25",
                            "ETA": "2017-03-29 09:40"
                        },
                        {
                            "FlightNo": "JT17",
                            "Transit": 0,
                            "STD": "DPS",
                            "STA": "CGK",
                            "ETD": "2017-03-29 10:50",
                            "ETA": "2017-03-29 11:45"
                        }
                    ],
                    "Fares": [
                        [
                            {
                                "SubClass": "V",
                                "SeatAvb": "7",
                                "TotalFare": "458000",
                                "TotalNTA": 418000,
                                "selectedIDret": "457393"
                            },
                            {
                                "SubClass": "T",
                                "SeatAvb": "7",
                                "TotalFare": "513000",
                                "TotalNTA": 473000,
                                "selectedIDret": "457394"
                            },
                            {
                                "SubClass": "Q",
                                "SeatAvb": "7",
                                "TotalFare": "583000",
                                "TotalNTA": 543000,
                                "selectedIDret": "457395"
                            },
                            {
                                "SubClass": "N",
                                "SeatAvb": "7",
                                "TotalFare": "612000",
                                "TotalNTA": 572000,
                                "selectedIDret": "457396"
                            },
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "667000",
                                "TotalNTA": 627000,
                                "selectedIDret": "457397"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "711000",
                                "TotalNTA": 671000,
                                "selectedIDret": "457398"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "777000",
                                "TotalNTA": 737000,
                                "selectedIDret": "457399"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "843000",
                                "TotalNTA": 803000,
                                "selectedIDret": "457400"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "909000",
                                "TotalNTA": 869000,
                                "selectedIDret": "457401"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "986000",
                                "TotalNTA": 946000,
                                "selectedIDret": "457402"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "1052000",
                                "TotalNTA": 1012000,
                                "selectedIDret": "457403"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "1129000",
                                "TotalNTA": 1089000,
                                "selectedIDret": "457404"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "1217000",
                                "TotalNTA": 1177000,
                                "selectedIDret": "457405"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "1305000",
                                "TotalNTA": 1265000,
                                "selectedIDret": "457406"
                            }
                        ],
                        [
                            {
                                "SubClass": "N",
                                "SeatAvb": "5",
                                "TotalFare": "709000",
                                "TotalNTA": 704000,
                                "selectedIDret": "457407"
                            },
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "764000",
                                "TotalNTA": 759000,
                                "selectedIDret": "457408"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "830000",
                                "TotalNTA": 825000,
                                "selectedIDret": "457409"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "907000",
                                "TotalNTA": 902000,
                                "selectedIDret": "457410"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "974000",
                                "TotalNTA": 969000,
                                "selectedIDret": "457411"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "1051000",
                                "TotalNTA": 1046000,
                                "selectedIDret": "457412"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "1149000",
                                "TotalNTA": 1144000,
                                "selectedIDret": "457413"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "1248000",
                                "TotalNTA": 1243000,
                                "selectedIDret": "457414"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "1326000",
                                "TotalNTA": 1321000,
                                "selectedIDret": "457415"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "1436000",
                                "TotalNTA": 1431000,
                                "selectedIDret": "457416"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "1538300",
                                "TotalNTA": 1533300,
                                "selectedIDret": "457417"
                            }
                        ]
                    ]
                },
                {
                    "Flights": [
                        {
                            "FlightNo": "IW1814",
                            "Transit": 0,
                            "STD": "JOG",
                            "STA": "SUB",
                            "ETD": "2017-03-29 06:00",
                            "ETA": "2017-03-29 07:10"
                        },
                        {
                            "FlightNo": "ID6573",
                            "Transit": 0,
                            "STD": "SUB",
                            "STA": "CGK",
                            "ETD": "2017-03-29 10:35",
                            "ETA": "2017-03-29 12:05"
                        }
                    ],
                    "Fares": [
                        [
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "638000",
                                "TotalNTA": 598000,
                                "selectedIDret": "457418"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "682000",
                                "TotalNTA": 642000,
                                "selectedIDret": "457419"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "737000",
                                "TotalNTA": 697000,
                                "selectedIDret": "457420"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "803000",
                                "TotalNTA": 763000,
                                "selectedIDret": "457421"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "858000",
                                "TotalNTA": 818000,
                                "selectedIDret": "457422"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "924000",
                                "TotalNTA": 884000,
                                "selectedIDret": "457423"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "1001000",
                                "TotalNTA": 961000,
                                "selectedIDret": "457424"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "1067000",
                                "TotalNTA": 1027000,
                                "selectedIDret": "457425"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "1155000",
                                "TotalNTA": 1115000,
                                "selectedIDret": "457426"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "1227600",
                                "TotalNTA": 1187600,
                                "selectedIDret": "457427"
                            }
                        ],
                        [
                            {
                                "SubClass": "T",
                                "SeatAvb": "5",
                                "TotalFare": "556000",
                                "TotalNTA": 551000,
                                "selectedIDret": "457428"
                            },
                            {
                                "SubClass": "Q",
                                "SeatAvb": "7",
                                "TotalFare": "647000",
                                "TotalNTA": 642000,
                                "selectedIDret": "457429"
                            },
                            {
                                "SubClass": "N",
                                "SeatAvb": "7",
                                "TotalFare": "677000",
                                "TotalNTA": 672000,
                                "selectedIDret": "457430"
                            },
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "743000",
                                "TotalNTA": 738000,
                                "selectedIDret": "457431"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "798000",
                                "TotalNTA": 793000,
                                "selectedIDret": "457432"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "900000",
                                "TotalNTA": 895000,
                                "selectedIDret": "457433"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "952000",
                                "TotalNTA": 947000,
                                "selectedIDret": "457434"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "1029000",
                                "TotalNTA": 1024000,
                                "selectedIDret": "457435"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "1117000",
                                "TotalNTA": 1112000,
                                "selectedIDret": "457436"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "1205000",
                                "TotalNTA": 1200000,
                                "selectedIDret": "457437"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "1293000",
                                "TotalNTA": 1288000,
                                "selectedIDret": "457438"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "1403000",
                                "TotalNTA": 1398000,
                                "selectedIDret": "457439"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "1504200",
                                "TotalNTA": 1499200,
                                "selectedIDret": "457440"
                            },
                            {
                                "SubClass": "Z",
                                "SeatAvb": "3",
                                "TotalFare": "900000",
                                "TotalNTA": 895000,
                                "selectedIDret": "457441"
                            },
                            {
                                "SubClass": "I",
                                "SeatAvb": "5",
                                "TotalFare": "1403000",
                                "TotalNTA": 1398000,
                                "selectedIDret": "457442"
                            },
                            {
                                "SubClass": "D",
                                "SeatAvb": "7",
                                "TotalFare": "1975000",
                                "TotalNTA": 1970000,
                                "selectedIDret": "457443"
                            },
                            {
                                "SubClass": "C",
                                "SeatAvb": "7",
                                "TotalFare": "2712000",
                                "TotalNTA": 2707000,
                                "selectedIDret": "457444"
                            }
                        ]
                    ]
                },
                {
                    "Flights": [
                        {
                            "FlightNo": "JT560",
                            "Transit": 0,
                            "STD": "JOG",
                            "STA": "DPS",
                            "ETD": "2017-03-29 07:25",
                            "ETA": "2017-03-29 09:40"
                        },
                        {
                            "FlightNo": "JT29",
                            "Transit": 0,
                            "STD": "DPS",
                            "STA": "CGK",
                            "ETD": "2017-03-29 11:50",
                            "ETA": "2017-03-29 12:45"
                        }
                    ],
                    "Fares": [
                        [
                            {
                                "SubClass": "V",
                                "SeatAvb": "7",
                                "TotalFare": "458000",
                                "TotalNTA": 418000,
                                "selectedIDret": "457445"
                            },
                            {
                                "SubClass": "T",
                                "SeatAvb": "7",
                                "TotalFare": "513000",
                                "TotalNTA": 473000,
                                "selectedIDret": "457446"
                            },
                            {
                                "SubClass": "Q",
                                "SeatAvb": "7",
                                "TotalFare": "583000",
                                "TotalNTA": 543000,
                                "selectedIDret": "457447"
                            },
                            {
                                "SubClass": "N",
                                "SeatAvb": "7",
                                "TotalFare": "612000",
                                "TotalNTA": 572000,
                                "selectedIDret": "457448"
                            },
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "667000",
                                "TotalNTA": 627000,
                                "selectedIDret": "457449"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "711000",
                                "TotalNTA": 671000,
                                "selectedIDret": "457450"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "777000",
                                "TotalNTA": 737000,
                                "selectedIDret": "457451"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "843000",
                                "TotalNTA": 803000,
                                "selectedIDret": "457452"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "909000",
                                "TotalNTA": 869000,
                                "selectedIDret": "457453"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "986000",
                                "TotalNTA": 946000,
                                "selectedIDret": "457454"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "1052000",
                                "TotalNTA": 1012000,
                                "selectedIDret": "457455"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "1129000",
                                "TotalNTA": 1089000,
                                "selectedIDret": "457456"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "1217000",
                                "TotalNTA": 1177000,
                                "selectedIDret": "457457"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "1305000",
                                "TotalNTA": 1265000,
                                "selectedIDret": "457458"
                            }
                        ],
                        [
                            {
                                "SubClass": "N",
                                "SeatAvb": "2",
                                "TotalFare": "709000",
                                "TotalNTA": 704000,
                                "selectedIDret": "457459"
                            },
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "764000",
                                "TotalNTA": 759000,
                                "selectedIDret": "457460"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "830000",
                                "TotalNTA": 825000,
                                "selectedIDret": "457461"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "907000",
                                "TotalNTA": 902000,
                                "selectedIDret": "457462"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "974000",
                                "TotalNTA": 969000,
                                "selectedIDret": "457463"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "1051000",
                                "TotalNTA": 1046000,
                                "selectedIDret": "457464"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "1149000",
                                "TotalNTA": 1144000,
                                "selectedIDret": "457465"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "1248000",
                                "TotalNTA": 1243000,
                                "selectedIDret": "457466"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "1326000",
                                "TotalNTA": 1321000,
                                "selectedIDret": "457467"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "1436000",
                                "TotalNTA": 1431000,
                                "selectedIDret": "457468"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "1538300",
                                "TotalNTA": 1533300,
                                "selectedIDret": "457469"
                            }
                        ]
                    ]
                },
                {
                    "Flights": [
                        {
                            "FlightNo": "IW1814",
                            "Transit": 0,
                            "STD": "JOG",
                            "STA": "SUB",
                            "ETD": "2017-03-29 06:00",
                            "ETA": "2017-03-29 07:10"
                        },
                        {
                            "FlightNo": "JT591",
                            "Transit": 0,
                            "STD": "SUB",
                            "STA": "CGK",
                            "ETD": "2017-03-29 12:10",
                            "ETA": "2017-03-29 13:40"
                        }
                    ],
                    "Fares": [
                        [
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "638000",
                                "TotalNTA": 598000,
                                "selectedIDret": "457470"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "682000",
                                "TotalNTA": 642000,
                                "selectedIDret": "457471"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "737000",
                                "TotalNTA": 697000,
                                "selectedIDret": "457472"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "803000",
                                "TotalNTA": 763000,
                                "selectedIDret": "457473"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "858000",
                                "TotalNTA": 818000,
                                "selectedIDret": "457474"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "924000",
                                "TotalNTA": 884000,
                                "selectedIDret": "457475"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "1001000",
                                "TotalNTA": 961000,
                                "selectedIDret": "457476"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "1067000",
                                "TotalNTA": 1027000,
                                "selectedIDret": "457477"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "1155000",
                                "TotalNTA": 1115000,
                                "selectedIDret": "457478"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "1227600",
                                "TotalNTA": 1187600,
                                "selectedIDret": "457479"
                            }
                        ],
                        [
                            {
                                "SubClass": "Q",
                                "SeatAvb": "7",
                                "TotalFare": "548000",
                                "TotalNTA": 543000,
                                "selectedIDret": "457480"
                            },
                            {
                                "SubClass": "N",
                                "SeatAvb": "7",
                                "TotalFare": "578000",
                                "TotalNTA": 573000,
                                "selectedIDret": "457481"
                            },
                            {
                                "SubClass": "M",
                                "SeatAvb": "7",
                                "TotalFare": "633000",
                                "TotalNTA": 628000,
                                "selectedIDret": "457482"
                            },
                            {
                                "SubClass": "L",
                                "SeatAvb": "7",
                                "TotalFare": "677000",
                                "TotalNTA": 672000,
                                "selectedIDret": "457483"
                            },
                            {
                                "SubClass": "K",
                                "SeatAvb": "7",
                                "TotalFare": "743000",
                                "TotalNTA": 738000,
                                "selectedIDret": "457484"
                            },
                            {
                                "SubClass": "H",
                                "SeatAvb": "7",
                                "TotalFare": "809000",
                                "TotalNTA": 804000,
                                "selectedIDret": "457485"
                            },
                            {
                                "SubClass": "B",
                                "SeatAvb": "7",
                                "TotalFare": "875000",
                                "TotalNTA": 870000,
                                "selectedIDret": "457486"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "7",
                                "TotalFare": "952000",
                                "TotalNTA": 947000,
                                "selectedIDret": "457487"
                            },
                            {
                                "SubClass": "W",
                                "SeatAvb": "7",
                                "TotalFare": "1029000",
                                "TotalNTA": 1024000,
                                "selectedIDret": "457488"
                            },
                            {
                                "SubClass": "G",
                                "SeatAvb": "7",
                                "TotalFare": "1106000",
                                "TotalNTA": 1101000,
                                "selectedIDret": "457489"
                            },
                            {
                                "SubClass": "A",
                                "SeatAvb": "7",
                                "TotalFare": "1194000",
                                "TotalNTA": 1189000,
                                "selectedIDret": "457490"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "7",
                                "TotalFare": "1277600",
                                "TotalNTA": 1272600,
                                "selectedIDret": "457491"
                            }
                        ]
                    ]
                }
            ]
        }
    }
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resGetSchInt" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px;">
                <code class="language-markup">
                  {
                    "status": {
                      "code": 200,
                      "confirm": "success",
                      "message": [
                        "Success get schedule."
                      ]
                    },
                    "details": {
                      "error_code": "000",
                      "error_msg": "",
                      "mmid": "mastersip",
                      "org": "CGK",
                      "des": "LHR",
                      "flight": "O",
                      "tgl_dep": "2017-05-23",
                      "tgl_ret": "",
                      "adt": "1",
                      "chd": "0",
                      "inf": "0",
                      "cabin": "economy",
                      "schedule": {
                        "departure": [
                          {
                            "ac": "KL",
                            "food": true,
                            "tax": false,
                            "baggage": "1 Piece",
                            "durasi": "1260",
                            "Flights": [
                              {
                                "ac": "GA",
                                "FlightNo": "GA818",
                                "STD": "CGK",
                                "STA": "KUL",
                                "ETD": "2017-05-23 16:40",
                                "ETA": "2017-05-23 19:45"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL810",
                                "STD": "KUL",
                                "STA": "AMS",
                                "ETD": "2017-05-23 23:20",
                                "ETA": "2017-05-24 06:00"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL1001",
                                "STD": "AMS",
                                "STA": "LHR",
                                "ETD": "2017-05-24 07:20",
                                "ETA": "2017-05-24 07:40"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 14610376,
                                "selectedIDdep": "4830849",
                                "TotalFare": 14620376
                              }
                            ]
                          },
                          {
                            "ac": "QR",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1185",
                            "Flights": [
                              {
                                "ac": "QR",
                                "FlightNo": "QR955",
                                "STD": "CGK",
                                "STA": "DOH",
                                "ETD": "2017-05-23 00:20",
                                "ETA": "2017-05-23 04:55"
                              },
                              {
                                "ac": "BA",
                                "FlightNo": "BA122",
                                "STD": "DOH",
                                "STA": "LHR",
                                "ETD": "2017-05-23 08:45",
                                "ETA": "2017-05-23 14:05"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11944629,
                                "selectedIDdep": "4830850",
                                "TotalFare": 11954629
                              }
                            ]
                          },
                          {
                            "ac": "KL",
                            "food": true,
                            "tax": false,
                            "baggage": "1 Piece",
                            "durasi": "1445",
                            "Flights": [
                              {
                                "ac": "GA",
                                "FlightNo": "GA818",
                                "STD": "CGK",
                                "STA": "KUL",
                                "ETD": "2017-05-23 16:40",
                                "ETA": "2017-05-23 19:45"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL810",
                                "STD": "KUL",
                                "STA": "AMS",
                                "ETD": "2017-05-23 23:20",
                                "ETA": "2017-05-24 06:00"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL1009",
                                "STD": "AMS",
                                "STA": "LHR",
                                "ETD": "2017-05-24 10:15",
                                "ETA": "2017-05-24 10:45"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 14610376,
                                "selectedIDdep": "4830851",
                                "TotalFare": 14620376
                              }
                            ]
                          },
                          {
                            "ac": "KL",
                            "food": true,
                            "tax": false,
                            "baggage": "1 Piece",
                            "durasi": "1340",
                            "Flights": [
                              {
                                "ac": "GA",
                                "FlightNo": "GA818",
                                "STD": "CGK",
                                "STA": "KUL",
                                "ETD": "2017-05-23 16:40",
                                "ETA": "2017-05-23 19:45"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL810",
                                "STD": "KUL",
                                "STA": "AMS",
                                "ETD": "2017-05-23 23:20",
                                "ETA": "2017-05-24 06:00"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL1007",
                                "STD": "AMS",
                                "STA": "LHR",
                                "ETD": "2017-05-24 08:40",
                                "ETA": "2017-05-24 09:00"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 14610376,
                                "selectedIDdep": "4830852",
                                "TotalFare": 14620376
                              }
                            ]
                          },
                          {
                            "ac": "EK",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1170",
                            "Flights": [
                              {
                                "ac": "EK",
                                "FlightNo": "EK359",
                                "STD": "CGK",
                                "STA": "DXB",
                                "ETD": "2017-05-23 00:40",
                                "ETA": "2017-05-23 05:40"
                              },
                              {
                                "ac": "QF",
                                "FlightNo": "QF9",
                                "STD": "DXB",
                                "STA": "LHR",
                                "ETD": "2017-05-23 09:05",
                                "ETA": "2017-05-23 14:10"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11817191,
                                "selectedIDdep": "4830853",
                                "TotalFare": 11827191
                              }
                            ]
                          },
                          {
                            "ac": "QR",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1060",
                            "Flights": [
                              {
                                "ac": "QR",
                                "FlightNo": "QR955",
                                "STD": "CGK",
                                "STA": "DOH",
                                "ETD": "2017-05-23 00:20",
                                "ETA": "2017-05-23 04:55"
                              },
                              {
                                "ac": "QR",
                                "FlightNo": "QR7",
                                "STD": "DOH",
                                "STA": "LHR",
                                "ETD": "2017-05-23 06:35",
                                "ETA": "2017-05-23 12:00"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11944629,
                                "selectedIDdep": "4830854",
                                "TotalFare": 11954629
                              }
                            ]
                          },
                          {
                            "ac": "MH",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1605",
                            "Flights": [
                              {
                                "ac": "MH",
                                "FlightNo": "MH724",
                                "STD": "CGK",
                                "STA": "KUL",
                                "ETD": "2017-05-23 19:50",
                                "ETA": "2017-05-23 22:55"
                              },
                              {
                                "ac": "MH",
                                "FlightNo": "MH4",
                                "STD": "KUL",
                                "STA": "LHR",
                                "ETD": "2017-05-24 09:50",
                                "ETA": "2017-05-24 16:35"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 10392580,
                                "selectedIDdep": "4830855",
                                "TotalFare": 10402580
                              }
                            ]
                          },
                          {
                            "ac": "QR",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1660",
                            "Flights": [
                              {
                                "ac": "QR",
                                "FlightNo": "QR955",
                                "STD": "CGK",
                                "STA": "DOH",
                                "ETD": "2017-05-23 00:20",
                                "ETA": "2017-05-23 04:55"
                              },
                              {
                                "ac": "QR",
                                "FlightNo": "QR5",
                                "STD": "DOH",
                                "STA": "LHR",
                                "ETD": "2017-05-23 16:30",
                                "ETA": "2017-05-23 22:00"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11944629,
                                "selectedIDdep": "4830856",
                                "TotalFare": 11954629
                              }
                            ]
                          },
                          {
                            "ac": "EY",
                            "food": true,
                            "tax": false,
                            "baggage": "2 Piece",
                            "durasi": "1855",
                            "Flights": [
                              {
                                "ac": "EY",
                                "FlightNo": "EY475",
                                "STD": "CGK",
                                "STA": "AUH",
                                "ETD": "2017-05-23 17:50",
                                "ETA": "2017-05-23 23:20"
                              },
                              {
                                "ac": "EY",
                                "FlightNo": "EY17",
                                "STD": "AUH",
                                "STA": "LHR",
                                "ETD": "2017-05-24 13:50",
                                "ETA": "2017-05-24 18:45"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 10113230,
                                "selectedIDdep": "4830857",
                                "TotalFare": 10123230
                              }
                            ]
                          },
                          {
                            "ac": "QR",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1135",
                            "Flights": [
                              {
                                "ac": "QR",
                                "FlightNo": "QR955",
                                "STD": "CGK",
                                "STA": "DOH",
                                "ETD": "2017-05-23 00:20",
                                "ETA": "2017-05-23 04:55"
                              },
                              {
                                "ac": "QR",
                                "FlightNo": "QR3",
                                "STD": "DOH",
                                "STA": "LHR",
                                "ETD": "2017-05-23 07:45",
                                "ETA": "2017-05-23 13:15"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11944629,
                                "selectedIDdep": "4830858",
                                "TotalFare": 11954629
                              }
                            ]
                          },
                          {
                            "ac": "EY",
                            "food": true,
                            "tax": false,
                            "baggage": "2 Piece",
                            "durasi": "1510",
                            "Flights": [
                              {
                                "ac": "EY",
                                "FlightNo": "EY475",
                                "STD": "CGK",
                                "STA": "AUH",
                                "ETD": "2017-05-23 17:50",
                                "ETA": "2017-05-23 23:20"
                              },
                              {
                                "ac": "EY",
                                "FlightNo": "EY19",
                                "STD": "AUH",
                                "STA": "LHR",
                                "ETD": "2017-05-24 08:10",
                                "ETA": "2017-05-24 13:00"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 10095121,
                                "selectedIDdep": "4830859",
                                "TotalFare": 10105121
                              }
                            ]
                          },
                          {
                            "ac": "QR",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1415",
                            "Flights": [
                              {
                                "ac": "QR",
                                "FlightNo": "QR955",
                                "STD": "CGK",
                                "STA": "DOH",
                                "ETD": "2017-05-23 00:20",
                                "ETA": "2017-05-23 04:55"
                              },
                              {
                                "ac": "QR",
                                "FlightNo": "QR1",
                                "STD": "DOH",
                                "STA": "LHR",
                                "ETD": "2017-05-23 12:20",
                                "ETA": "2017-05-23 17:55"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11944629,
                                "selectedIDdep": "4830860",
                                "TotalFare": 11954629
                              }
                            ]
                          },
                          {
                            "ac": "SQ",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1245",
                            "Flights": [
                              {
                                "ac": "SQ",
                                "FlightNo": "SQ961",
                                "STD": "CGK",
                                "STA": "SIN",
                                "ETD": "2017-05-23 17:00",
                                "ETA": "2017-05-23 19:50"
                              },
                              {
                                "ac": "SQ",
                                "FlightNo": "SQ306",
                                "STD": "SIN",
                                "STA": "LHR",
                                "ETD": "2017-05-24 01:10",
                                "ETA": "2017-05-24 07:45"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 23615396,
                                "selectedIDdep": "4830861",
                                "TotalFare": 23625396
                              }
                            ]
                          },
                          {
                            "ac": "EK",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "2175",
                            "Flights": [
                              {
                                "ac": "EK",
                                "FlightNo": "EK359",
                                "STD": "CGK",
                                "STA": "DXB",
                                "ETD": "2017-05-23 00:40",
                                "ETA": "2017-05-23 05:40"
                              },
                              {
                                "ac": "QF",
                                "FlightNo": "QF1",
                                "STD": "DXB",
                                "STA": "LHR",
                                "ETD": "2017-05-24 02:10",
                                "ETA": "2017-05-24 06:55"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "7",
                                "price": 13875030,
                                "selectedIDdep": "4830862",
                                "TotalFare": 13885030
                              }
                            ]
                          },
                          {
                            "ac": "CZ",
                            "food": true,
                            "tax": false,
                            "baggage": "1 Piece",
                            "durasi": "1820",
                            "Flights": [
                              {
                                "ac": "GA",
                                "FlightNo": "GA898",
                                "STD": "CGK",
                                "STA": "CAN",
                                "ETD": "2017-05-23 08:40",
                                "ETA": "2017-05-23 14:45"
                              },
                              {
                                "ac": "CZ",
                                "FlightNo": "CZ307",
                                "STD": "CAN",
                                "STA": "AMS",
                                "ETD": "2017-05-24 00:05",
                                "ETA": "2017-05-24 06:45"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL1007",
                                "STD": "AMS",
                                "STA": "LHR",
                                "ETD": "2017-05-24 08:40",
                                "ETA": "2017-05-24 09:00"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 16648732,
                                "selectedIDdep": "4830863",
                                "TotalFare": 16658732
                              }
                            ]
                          },
                          {
                            "ac": "MH",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "2200",
                            "Flights": [
                              {
                                "ac": "MH",
                                "FlightNo": "MH712",
                                "STD": "CGK",
                                "STA": "KUL",
                                "ETD": "2017-05-23 09:55",
                                "ETA": "2017-05-23 12:55"
                              },
                              {
                                "ac": "MH",
                                "FlightNo": "MH4",
                                "STD": "KUL",
                                "STA": "LHR",
                                "ETD": "2017-05-24 09:50",
                                "ETA": "2017-05-24 16:35"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 10629172,
                                "selectedIDdep": "4830864",
                                "TotalFare": 10639172
                              }
                            ]
                          },
                          {
                            "ac": "EY",
                            "food": true,
                            "tax": false,
                            "baggage": "2 Piece",
                            "durasi": "2245",
                            "Flights": [
                              {
                                "ac": "EY",
                                "FlightNo": "EY471",
                                "STD": "CGK",
                                "STA": "AUH",
                                "ETD": "2017-05-23 00:10",
                                "ETA": "2017-05-23 05:40"
                              },
                              {
                                "ac": "EY",
                                "FlightNo": "EY11",
                                "STD": "AUH",
                                "STA": "LHR",
                                "ETD": "2017-05-24 02:35",
                                "ETA": "2017-05-24 07:35"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 10113230,
                                "selectedIDdep": "4830865",
                                "TotalFare": 10123230
                              }
                            ]
                          },
                          {
                            "ac": "MH",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1560",
                            "Flights": [
                              {
                                "ac": "MH",
                                "FlightNo": "MH712",
                                "STD": "CGK",
                                "STA": "KUL",
                                "ETD": "2017-05-23 09:55",
                                "ETA": "2017-05-23 12:55"
                              },
                              {
                                "ac": "MH",
                                "FlightNo": "MH2",
                                "STD": "KUL",
                                "STA": "LHR",
                                "ETD": "2017-05-23 23:15",
                                "ETA": "2017-05-24 05:55"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 9000280,
                                "selectedIDdep": "4830866",
                                "TotalFare": 9010280
                              }
                            ]
                          },
                          {
                            "ac": "GA",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1130",
                            "Flights": [
                              {
                                "ac": "EY",
                                "FlightNo": "EY471",
                                "STD": "CGK",
                                "STA": "AUH",
                                "ETD": "2017-05-23 00:10",
                                "ETA": "2017-05-23 05:40"
                              },
                              {
                                "ac": "EY",
                                "FlightNo": "EY19",
                                "STD": "AUH",
                                "STA": "LHR",
                                "ETD": "2017-05-23 08:10",
                                "ETA": "2017-05-23 13:00"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "4",
                                "price": 9590715,
                                "selectedIDdep": "4830867",
                                "TotalFare": 9600715
                              }
                            ]
                          },
                          {
                            "ac": "GA",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "2245",
                            "Flights": [
                              {
                                "ac": "EY",
                                "FlightNo": "EY471",
                                "STD": "CGK",
                                "STA": "AUH",
                                "ETD": "2017-05-23 00:10",
                                "ETA": "2017-05-23 05:40"
                              },
                              {
                                "ac": "EY",
                                "FlightNo": "EY11",
                                "STD": "AUH",
                                "STA": "LHR",
                                "ETD": "2017-05-24 02:35",
                                "ETA": "2017-05-24 07:35"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "4",
                                "price": 9609370,
                                "selectedIDdep": "4830868",
                                "TotalFare": 9619370
                              }
                            ]
                          },
                          {
                            "ac": "CZ",
                            "food": true,
                            "tax": false,
                            "baggage": "1 Piece",
                            "durasi": "1900",
                            "Flights": [
                              {
                                "ac": "CZ",
                                "FlightNo": "CZ388",
                                "STD": "CGK",
                                "STA": "CAN",
                                "ETD": "2017-05-23 09:05",
                                "ETA": "2017-05-23 14:45"
                              },
                              {
                                "ac": "CZ",
                                "FlightNo": "CZ307",
                                "STD": "CAN",
                                "STA": "AMS",
                                "ETD": "2017-05-24 00:05",
                                "ETA": "2017-05-24 06:45"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL1009",
                                "STD": "AMS",
                                "STA": "LHR",
                                "ETD": "2017-05-24 10:15",
                                "ETA": "2017-05-24 10:45"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 12245212,
                                "selectedIDdep": "4830869",
                                "TotalFare": 12255212
                              }
                            ]
                          },
                          {
                            "ac": "KL",
                            "food": true,
                            "tax": false,
                            "baggage": "1 Piece",
                            "durasi": "1630",
                            "Flights": [
                              {
                                "ac": "GA",
                                "FlightNo": "GA818",
                                "STD": "CGK",
                                "STA": "KUL",
                                "ETD": "2017-05-23 16:40",
                                "ETA": "2017-05-23 19:45"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL810",
                                "STD": "KUL",
                                "STA": "AMS",
                                "ETD": "2017-05-23 23:20",
                                "ETA": "2017-05-24 06:00"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL1017",
                                "STD": "AMS",
                                "STA": "LHR",
                                "ETD": "2017-05-24 13:20",
                                "ETA": "2017-05-24 13:50"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 12559516,
                                "selectedIDdep": "4830870",
                                "TotalFare": 12569516
                              }
                            ]
                          },
                          {
                            "ac": "CZ",
                            "food": true,
                            "tax": false,
                            "baggage": "1 Piece",
                            "durasi": "1795",
                            "Flights": [
                              {
                                "ac": "CZ",
                                "FlightNo": "CZ388",
                                "STD": "CGK",
                                "STA": "CAN",
                                "ETD": "2017-05-23 09:05",
                                "ETA": "2017-05-23 14:45"
                              },
                              {
                                "ac": "CZ",
                                "FlightNo": "CZ307",
                                "STD": "CAN",
                                "STA": "AMS",
                                "ETD": "2017-05-24 00:05",
                                "ETA": "2017-05-24 06:45"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL1007",
                                "STD": "AMS",
                                "STA": "LHR",
                                "ETD": "2017-05-24 08:40",
                                "ETA": "2017-05-24 09:00"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "6",
                                "price": 12245212,
                                "selectedIDdep": "4830871",
                                "TotalFare": 12255212
                              }
                            ]
                          },
                          {
                            "ac": "KL",
                            "food": true,
                            "tax": false,
                            "baggage": "1 Piece",
                            "durasi": "1205",
                            "Flights": [
                              {
                                "ac": "GA",
                                "FlightNo": "GA822",
                                "STD": "CGK",
                                "STA": "SIN",
                                "ETD": "2017-05-23 20:40",
                                "ETA": "2017-05-23 23:30"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL836",
                                "STD": "SIN",
                                "STA": "AMS",
                                "ETD": "2017-05-24 00:40",
                                "ETA": "2017-05-24 07:35"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL1009",
                                "STD": "AMS",
                                "STA": "LHR",
                                "ETD": "2017-05-24 10:15",
                                "ETA": "2017-05-24 10:45"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 14668972,
                                "selectedIDdep": "4830872",
                                "TotalFare": 14678972
                              }
                            ]
                          },
                          {
                            "ac": "CX",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1640",
                            "Flights": [
                              {
                                "ac": "CX",
                                "FlightNo": "CX718",
                                "STD": "CGK",
                                "STA": "HKG",
                                "ETD": "2017-05-23 08:20",
                                "ETA": "2017-05-23 14:20"
                              },
                              {
                                "ac": "CX",
                                "FlightNo": "CX251",
                                "STD": "HKG",
                                "STA": "LHR",
                                "ETD": "2017-05-23 23:55",
                                "ETA": "2017-05-24 05:40"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 19665300,
                                "selectedIDdep": "4830873",
                                "TotalFare": 19675300
                              }
                            ]
                          },
                          {
                            "ac": "EY",
                            "food": true,
                            "tax": false,
                            "baggage": "2 Piece",
                            "durasi": "1755",
                            "Flights": [
                              {
                                "ac": "GA",
                                "FlightNo": "GA834",
                                "STD": "CGK",
                                "STA": "SIN",
                                "ETD": "2017-05-23 13:45",
                                "ETA": "2017-05-23 16:35"
                              },
                              {
                                "ac": "EY",
                                "FlightNo": "EY473",
                                "STD": "SIN",
                                "STA": "AUH",
                                "ETD": "2017-05-23 20:10",
                                "ETA": "2017-05-23 23:30"
                              },
                              {
                                "ac": "EY",
                                "FlightNo": "EY19",
                                "STD": "AUH",
                                "STA": "LHR",
                                "ETD": "2017-05-24 08:10",
                                "ETA": "2017-05-24 13:00"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "4",
                                "price": 10151836,
                                "selectedIDdep": "4830874",
                                "TotalFare": 10161836
                              }
                            ]
                          },
                          {
                            "ac": "KL",
                            "food": true,
                            "tax": false,
                            "baggage": "1 Piece",
                            "durasi": "1100",
                            "Flights": [
                              {
                                "ac": "GA",
                                "FlightNo": "GA822",
                                "STD": "CGK",
                                "STA": "SIN",
                                "ETD": "2017-05-23 20:40",
                                "ETA": "2017-05-23 23:30"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL836",
                                "STD": "SIN",
                                "STA": "AMS",
                                "ETD": "2017-05-24 00:40",
                                "ETA": "2017-05-24 07:35"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL1007",
                                "STD": "AMS",
                                "STA": "LHR",
                                "ETD": "2017-05-24 08:40",
                                "ETA": "2017-05-24 09:00"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 14668972,
                                "selectedIDdep": "4830875",
                                "TotalFare": 14678972
                              }
                            ]
                          },
                          {
                            "ac": "BA",
                            "food": true,
                            "tax": false,
                            "baggage": "1 Piece",
                            "durasi": "1525",
                            "Flights": [
                              {
                                "ac": "GA",
                                "FlightNo": "GA860",
                                "STD": "CGK",
                                "STA": "HKG",
                                "ETD": "2017-05-23 10:10",
                                "ETA": "2017-05-23 16:10"
                              },
                              {
                                "ac": "BA",
                                "FlightNo": "BA28",
                                "STD": "HKG",
                                "STA": "LHR",
                                "ETD": "2017-05-23 23:45",
                                "ETA": "2017-05-24 05:35"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "5",
                                "price": 14812400,
                                "selectedIDdep": "4830876",
                                "TotalFare": 14822400
                              }
                            ]
                          },
                          {
                            "ac": "EY",
                            "food": true,
                            "tax": false,
                            "baggage": "2 Piece",
                            "durasi": "1430",
                            "Flights": [
                              {
                                "ac": "GA",
                                "FlightNo": "GA834",
                                "STD": "CGK",
                                "STA": "SIN",
                                "ETD": "2017-05-23 13:45",
                                "ETA": "2017-05-23 16:35"
                              },
                              {
                                "ac": "EY",
                                "FlightNo": "EY473",
                                "STD": "SIN",
                                "STA": "AUH",
                                "ETD": "2017-05-23 20:10",
                                "ETA": "2017-05-23 23:30"
                              },
                              {
                                "ac": "EY",
                                "FlightNo": "EY11",
                                "STD": "AUH",
                                "STA": "LHR",
                                "ETD": "2017-05-24 02:35",
                                "ETA": "2017-05-24 07:35"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "4",
                                "price": 10151836,
                                "selectedIDdep": "4830877",
                                "TotalFare": 10161836
                              }
                            ]
                          },
                          {
                            "ac": "TK",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1145",
                            "Flights": [
                              {
                                "ac": "TK",
                                "FlightNo": "TK57",
                                "STD": "CGK",
                                "STA": "IST",
                                "ETD": "2017-05-23 20:45",
                                "ETA": "2017-05-24 04:55"
                              },
                              {
                                "ac": "TK",
                                "FlightNo": "TK1979",
                                "STD": "IST",
                                "STA": "LHR",
                                "ETD": "2017-05-24 07:45",
                                "ETA": "2017-05-24 09:50"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 9377252,
                                "selectedIDdep": "4830878",
                                "TotalFare": 9387252
                              }
                            ]
                          },
                          {
                            "ac": "QR",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1045",
                            "Flights": [
                              {
                                "ac": "QR",
                                "FlightNo": "QR959",
                                "STD": "CGK",
                                "STA": "DOH",
                                "ETD": "2017-05-23 09:00",
                                "ETA": "2017-05-23 13:35"
                              },
                              {
                                "ac": "QR",
                                "FlightNo": "QR15",
                                "STD": "DOH",
                                "STA": "LHR",
                                "ETD": "2017-05-23 14:55",
                                "ETA": "2017-05-23 20:25"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11944629,
                                "selectedIDdep": "4830879",
                                "TotalFare": 11954629
                              }
                            ]
                          },
                          {
                            "ac": "KL",
                            "food": true,
                            "tax": false,
                            "baggage": "1 Piece",
                            "durasi": "1615",
                            "Flights": [
                              {
                                "ac": "GA",
                                "FlightNo": "GA822",
                                "STD": "CGK",
                                "STA": "SIN",
                                "ETD": "2017-05-23 20:40",
                                "ETA": "2017-05-23 23:30"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL836",
                                "STD": "SIN",
                                "STA": "AMS",
                                "ETD": "2017-05-24 00:40",
                                "ETA": "2017-05-24 07:35"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL1023",
                                "STD": "AMS",
                                "STA": "LHR",
                                "ETD": "2017-05-24 17:15",
                                "ETA": "2017-05-24 17:35"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 14668972,
                                "selectedIDdep": "4830880",
                                "TotalFare": 14678972
                              }
                            ]
                          },
                          {
                            "ac": "KL",
                            "food": true,
                            "tax": false,
                            "baggage": "1 Piece",
                            "durasi": "1535",
                            "Flights": [
                              {
                                "ac": "GA",
                                "FlightNo": "GA822",
                                "STD": "CGK",
                                "STA": "SIN",
                                "ETD": "2017-05-23 20:40",
                                "ETA": "2017-05-23 23:30"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL836",
                                "STD": "SIN",
                                "STA": "AMS",
                                "ETD": "2017-05-24 00:40",
                                "ETA": "2017-05-24 07:35"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL1021",
                                "STD": "AMS",
                                "STA": "LHR",
                                "ETD": "2017-05-24 15:50",
                                "ETA": "2017-05-24 16:15"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 14668972,
                                "selectedIDdep": "4830881",
                                "TotalFare": 14678972
                              }
                            ]
                          },
                          {
                            "ac": "QR",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1215",
                            "Flights": [
                              {
                                "ac": "QR",
                                "FlightNo": "QR957",
                                "STD": "CGK",
                                "STA": "DOH",
                                "ETD": "2017-05-23 18:45",
                                "ETA": "2017-05-23 23:20"
                              },
                              {
                                "ac": "QR",
                                "FlightNo": "QR11",
                                "STD": "DOH",
                                "STA": "LHR",
                                "ETD": "2017-05-24 03:30",
                                "ETA": "2017-05-24 09:00"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11944629,
                                "selectedIDdep": "4830882",
                                "TotalFare": 11954629
                              }
                            ]
                          },
                          {
                            "ac": "MH",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1050",
                            "Flights": [
                              {
                                "ac": "MH",
                                "FlightNo": "MH722",
                                "STD": "CGK",
                                "STA": "KUL",
                                "ETD": "2017-05-23 18:25",
                                "ETA": "2017-05-23 21:30"
                              },
                              {
                                "ac": "MH",
                                "FlightNo": "MH2",
                                "STD": "KUL",
                                "STA": "LHR",
                                "ETD": "2017-05-23 23:15",
                                "ETA": "2017-05-24 05:55"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 9000280,
                                "selectedIDdep": "4830883",
                                "TotalFare": 9010280
                              }
                            ]
                          },
                          {
                            "ac": "QR",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1395",
                            "Flights": [
                              {
                                "ac": "QR",
                                "FlightNo": "QR957",
                                "STD": "CGK",
                                "STA": "DOH",
                                "ETD": "2017-05-23 18:45",
                                "ETA": "2017-05-23 23:20"
                              },
                              {
                                "ac": "QR",
                                "FlightNo": "QR7",
                                "STD": "DOH",
                                "STA": "LHR",
                                "ETD": "2017-05-24 06:35",
                                "ETA": "2017-05-24 12:00"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11944629,
                                "selectedIDdep": "4830884",
                                "TotalFare": 11954629
                              }
                            ]
                          },
                          {
                            "ac": "KL",
                            "food": true,
                            "tax": false,
                            "baggage": "1 Piece",
                            "durasi": "1460",
                            "Flights": [
                              {
                                "ac": "GA",
                                "FlightNo": "GA822",
                                "STD": "CGK",
                                "STA": "SIN",
                                "ETD": "2017-05-23 20:40",
                                "ETA": "2017-05-23 23:30"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL836",
                                "STD": "SIN",
                                "STA": "AMS",
                                "ETD": "2017-05-24 00:40",
                                "ETA": "2017-05-24 07:35"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL1019",
                                "STD": "AMS",
                                "STA": "LHR",
                                "ETD": "2017-05-24 14:40",
                                "ETA": "2017-05-24 15:00"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 14668972,
                                "selectedIDdep": "4830885",
                                "TotalFare": 14678972
                              }
                            ]
                          },
                          {
                            "ac": "QR",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1995",
                            "Flights": [
                              {
                                "ac": "QR",
                                "FlightNo": "QR957",
                                "STD": "CGK",
                                "STA": "DOH",
                                "ETD": "2017-05-23 18:45",
                                "ETA": "2017-05-23 23:20"
                              },
                              {
                                "ac": "QR",
                                "FlightNo": "QR5",
                                "STD": "DOH",
                                "STA": "LHR",
                                "ETD": "2017-05-24 16:30",
                                "ETA": "2017-05-24 22:00"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11993870,
                                "selectedIDdep": "4830886",
                                "TotalFare": 12003870
                              }
                            ]
                          },
                          {
                            "ac": "KL",
                            "food": true,
                            "tax": false,
                            "baggage": "1 Piece",
                            "durasi": "1390",
                            "Flights": [
                              {
                                "ac": "GA",
                                "FlightNo": "GA822",
                                "STD": "CGK",
                                "STA": "SIN",
                                "ETD": "2017-05-23 20:40",
                                "ETA": "2017-05-23 23:30"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL836",
                                "STD": "SIN",
                                "STA": "AMS",
                                "ETD": "2017-05-24 00:40",
                                "ETA": "2017-05-24 07:35"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL1017",
                                "STD": "AMS",
                                "STA": "LHR",
                                "ETD": "2017-05-24 13:20",
                                "ETA": "2017-05-24 13:50"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 12618112,
                                "selectedIDdep": "4830887",
                                "TotalFare": 12628112
                              }
                            ]
                          },
                          {
                            "ac": "KL",
                            "food": true,
                            "tax": false,
                            "baggage": "0 KG",
                            "durasi": "1320",
                            "Flights": [
                              {
                                "ac": "KL",
                                "FlightNo": "KL810",
                                "STD": "CGK",
                                "STA": "KUL",
                                "ETD": "2017-05-23 18:45",
                                "ETA": "2017-05-23 21:55"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL810",
                                "STD": "KUL",
                                "STA": "AMS",
                                "ETD": "2017-05-23 23:20",
                                "ETA": "2017-05-24 06:00"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL1009",
                                "STD": "AMS",
                                "STA": "LHR",
                                "ETD": "2017-05-24 10:15",
                                "ETA": "2017-05-24 10:45"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 14610376,
                                "selectedIDdep": "4830888",
                                "TotalFare": 14620376
                              }
                            ]
                          },
                          {
                            "ac": "QR",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1900",
                            "Flights": [
                              {
                                "ac": "QR",
                                "FlightNo": "QR957",
                                "STD": "CGK",
                                "STA": "DOH",
                                "ETD": "2017-05-23 18:45",
                                "ETA": "2017-05-23 23:20"
                              },
                              {
                                "ac": "QR",
                                "FlightNo": "QR15",
                                "STD": "DOH",
                                "STA": "LHR",
                                "ETD": "2017-05-24 14:55",
                                "ETA": "2017-05-24 20:25"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11993870,
                                "selectedIDdep": "4830889",
                                "TotalFare": 12003870
                              }
                            ]
                          },
                          {
                            "ac": "QR",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1470",
                            "Flights": [
                              {
                                "ac": "QR",
                                "FlightNo": "QR957",
                                "STD": "CGK",
                                "STA": "DOH",
                                "ETD": "2017-05-23 18:45",
                                "ETA": "2017-05-23 23:20"
                              },
                              {
                                "ac": "QR",
                                "FlightNo": "QR3",
                                "STD": "DOH",
                                "STA": "LHR",
                                "ETD": "2017-05-24 07:45",
                                "ETA": "2017-05-24 13:15"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11944629,
                                "selectedIDdep": "4830890",
                                "TotalFare": 11954629
                              }
                            ]
                          },
                          {
                            "ac": "KL",
                            "food": true,
                            "tax": false,
                            "baggage": "0 KG",
                            "durasi": "1215",
                            "Flights": [
                              {
                                "ac": "KL",
                                "FlightNo": "KL810",
                                "STD": "CGK",
                                "STA": "KUL",
                                "ETD": "2017-05-23 18:45",
                                "ETA": "2017-05-23 21:55"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL810",
                                "STD": "KUL",
                                "STA": "AMS",
                                "ETD": "2017-05-23 23:20",
                                "ETA": "2017-05-24 06:00"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL1007",
                                "STD": "AMS",
                                "STA": "LHR",
                                "ETD": "2017-05-24 08:40",
                                "ETA": "2017-05-24 09:00"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 14610376,
                                "selectedIDdep": "4830891",
                                "TotalFare": 14620376
                              }
                            ]
                          },
                          {
                            "ac": "GA",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1510",
                            "Flights": [
                              {
                                "ac": "EY",
                                "FlightNo": "EY475",
                                "STD": "CGK",
                                "STA": "AUH",
                                "ETD": "2017-05-23 17:50",
                                "ETA": "2017-05-23 23:20"
                              },
                              {
                                "ac": "EY",
                                "FlightNo": "EY19",
                                "STD": "AUH",
                                "STA": "LHR",
                                "ETD": "2017-05-24 08:10",
                                "ETA": "2017-05-24 13:00"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "4",
                                "price": 9590715,
                                "selectedIDdep": "4830892",
                                "TotalFare": 9600715
                              }
                            ]
                          },
                          {
                            "ac": "QR",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1750",
                            "Flights": [
                              {
                                "ac": "QR",
                                "FlightNo": "QR957",
                                "STD": "CGK",
                                "STA": "DOH",
                                "ETD": "2017-05-23 18:45",
                                "ETA": "2017-05-23 23:20"
                              },
                              {
                                "ac": "QR",
                                "FlightNo": "QR1",
                                "STD": "DOH",
                                "STA": "LHR",
                                "ETD": "2017-05-24 12:20",
                                "ETA": "2017-05-24 17:55"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11993870,
                                "selectedIDdep": "4830893",
                                "TotalFare": 12003870
                              }
                            ]
                          },
                          {
                            "ac": "BA",
                            "food": true,
                            "tax": false,
                            "baggage": "1 Piece",
                            "durasi": "1900",
                            "Flights": [
                              {
                                "ac": "GA",
                                "FlightNo": "GA864",
                                "STD": "CGK",
                                "STA": "BKK",
                                "ETD": "2017-05-23 16:40",
                                "ETA": "2017-05-23 20:10"
                              },
                              {
                                "ac": "BA",
                                "FlightNo": "BA10",
                                "STD": "BKK",
                                "STA": "LHR",
                                "ETD": "2017-05-24 11:40",
                                "ETA": "2017-05-24 18:20"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "8",
                                "price": 7936800,
                                "selectedIDdep": "4830894",
                                "TotalFare": 7946800
                              }
                            ]
                          },
                          {
                            "ac": "EK",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1140",
                            "Flights": [
                              {
                                "ac": "EK",
                                "FlightNo": "EK357",
                                "STD": "CGK",
                                "STA": "DXB",
                                "ETD": "2017-05-23 17:55",
                                "ETA": "2017-05-23 22:55"
                              },
                              {
                                "ac": "QF",
                                "FlightNo": "QF1",
                                "STD": "DXB",
                                "STA": "LHR",
                                "ETD": "2017-05-24 02:10",
                                "ETA": "2017-05-24 06:55"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11817191,
                                "selectedIDdep": "4830895",
                                "TotalFare": 11827191
                              }
                            ]
                          },
                          {
                            "ac": "MH",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1690",
                            "Flights": [
                              {
                                "ac": "MH",
                                "FlightNo": "MH722",
                                "STD": "CGK",
                                "STA": "KUL",
                                "ETD": "2017-05-23 18:25",
                                "ETA": "2017-05-23 21:30"
                              },
                              {
                                "ac": "MH",
                                "FlightNo": "MH4",
                                "STD": "KUL",
                                "STA": "LHR",
                                "ETD": "2017-05-24 09:50",
                                "ETA": "2017-05-24 16:35"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 10629172,
                                "selectedIDdep": "4830896",
                                "TotalFare": 10639172
                              }
                            ]
                          },
                          {
                            "ac": "KL",
                            "food": true,
                            "tax": false,
                            "baggage": "0 KG",
                            "durasi": "1135",
                            "Flights": [
                              {
                                "ac": "KL",
                                "FlightNo": "KL810",
                                "STD": "CGK",
                                "STA": "KUL",
                                "ETD": "2017-05-23 18:45",
                                "ETA": "2017-05-23 21:55"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL810",
                                "STD": "KUL",
                                "STA": "AMS",
                                "ETD": "2017-05-23 23:20",
                                "ETA": "2017-05-24 06:00"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL1001",
                                "STD": "AMS",
                                "STA": "LHR",
                                "ETD": "2017-05-24 07:20",
                                "ETA": "2017-05-24 07:40"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 12559516,
                                "selectedIDdep": "4830897",
                                "TotalFare": 12569516
                              }
                            ]
                          },
                          {
                            "ac": "TK",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1545",
                            "Flights": [
                              {
                                "ac": "TK",
                                "FlightNo": "TK57",
                                "STD": "CGK",
                                "STA": "IST",
                                "ETD": "2017-05-23 20:45",
                                "ETA": "2017-05-24 04:55"
                              },
                              {
                                "ac": "TK",
                                "FlightNo": "TK1971",
                                "STD": "IST",
                                "STA": "LHR",
                                "ETD": "2017-05-24 14:25",
                                "ETA": "2017-05-24 16:30"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 9377252,
                                "selectedIDdep": "4830898",
                                "TotalFare": 9387252
                              }
                            ]
                          },
                          {
                            "ac": "SQ",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1015",
                            "Flights": [
                              {
                                "ac": "SQ",
                                "FlightNo": "SQ965",
                                "STD": "CGK",
                                "STA": "SIN",
                                "ETD": "2017-05-23 19:00",
                                "ETA": "2017-05-23 21:50"
                              },
                              {
                                "ac": "SQ",
                                "FlightNo": "SQ322",
                                "STD": "SIN",
                                "STA": "LHR",
                                "ETD": "2017-05-23 23:30",
                                "ETA": "2017-05-24 05:55"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 23615396,
                                "selectedIDdep": "4830899",
                                "TotalFare": 23625396
                              }
                            ]
                          },
                          {
                            "ac": "SQ",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1305",
                            "Flights": [
                              {
                                "ac": "SQ",
                                "FlightNo": "SQ959",
                                "STD": "CGK",
                                "STA": "SIN",
                                "ETD": "2017-05-23 14:10",
                                "ETA": "2017-05-23 17:00"
                              },
                              {
                                "ac": "SQ",
                                "FlightNo": "SQ322",
                                "STD": "SIN",
                                "STA": "LHR",
                                "ETD": "2017-05-23 23:30",
                                "ETA": "2017-05-24 05:55"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 23615396,
                                "selectedIDdep": "4830900",
                                "TotalFare": 23625396
                              }
                            ]
                          },
                          {
                            "ac": "CZ",
                            "food": true,
                            "tax": false,
                            "baggage": "1 Piece",
                            "durasi": "1920",
                            "Flights": [
                              {
                                "ac": "CZ",
                                "FlightNo": "CZ3038",
                                "STD": "CGK",
                                "STA": "CAN",
                                "ETD": "2017-05-23 13:05",
                                "ETA": "2017-05-23 19:05"
                              },
                              {
                                "ac": "CZ",
                                "FlightNo": "CZ303",
                                "STD": "CAN",
                                "STA": "LHR",
                                "ETD": "2017-05-24 09:30",
                                "ETA": "2017-05-24 15:05"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "8",
                                "price": 10886239,
                                "selectedIDdep": "4830901",
                                "TotalFare": 10896239
                              }
                            ]
                          },
                          {
                            "ac": "QR",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "2105",
                            "Flights": [
                              {
                                "ac": "QR",
                                "FlightNo": "QR959",
                                "STD": "CGK",
                                "STA": "DOH",
                                "ETD": "2017-05-23 09:00",
                                "ETA": "2017-05-23 13:35"
                              },
                              {
                                "ac": "BA",
                                "FlightNo": "BA122",
                                "STD": "DOH",
                                "STA": "LHR",
                                "ETD": "2017-05-24 08:45",
                                "ETA": "2017-05-24 14:05"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11993870,
                                "selectedIDdep": "4830902",
                                "TotalFare": 12003870
                              }
                            ]
                          },
                          {
                            "ac": "GA",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1185",
                            "Flights": [
                              {
                                "ac": "EY",
                                "FlightNo": "EY475",
                                "STD": "CGK",
                                "STA": "AUH",
                                "ETD": "2017-05-23 17:50",
                                "ETA": "2017-05-23 23:20"
                              },
                              {
                                "ac": "EY",
                                "FlightNo": "EY11",
                                "STD": "AUH",
                                "STA": "LHR",
                                "ETD": "2017-05-24 02:35",
                                "ETA": "2017-05-24 07:35"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "4",
                                "price": 9590715,
                                "selectedIDdep": "4830903",
                                "TotalFare": 9600715
                              }
                            ]
                          },
                          {
                            "ac": "CZ",
                            "food": true,
                            "tax": false,
                            "baggage": "1 Piece",
                            "durasi": "2285",
                            "Flights": [
                              {
                                "ac": "CZ",
                                "FlightNo": "CZ388",
                                "STD": "CGK",
                                "STA": "CAN",
                                "ETD": "2017-05-23 09:05",
                                "ETA": "2017-05-23 14:45"
                              },
                              {
                                "ac": "CZ",
                                "FlightNo": "CZ307",
                                "STD": "CAN",
                                "STA": "AMS",
                                "ETD": "2017-05-24 00:05",
                                "ETA": "2017-05-24 06:45"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL1029",
                                "STD": "AMS",
                                "STA": "LHR",
                                "ETD": "2017-05-24 16:55",
                                "ETA": "2017-05-24 17:10"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 12245212,
                                "selectedIDdep": "4830904",
                                "TotalFare": 12255212
                              }
                            ]
                          },
                          {
                            "ac": "GA",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1300",
                            "Flights": [
                              {
                                "ac": "GA",
                                "FlightNo": "GA88",
                                "STD": "CGK",
                                "STA": "AMS",
                                "ETD": "2017-05-23 22:10",
                                "ETA": "2017-05-24 07:20"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL1017",
                                "STD": "AMS",
                                "STA": "LHR",
                                "ETD": "2017-05-24 13:20",
                                "ETA": "2017-05-24 13:50"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 16608930,
                                "selectedIDdep": "4830905",
                                "TotalFare": 16618930
                              }
                            ]
                          },
                          {
                            "ac": "KL",
                            "food": true,
                            "tax": false,
                            "baggage": "1 Piece",
                            "durasi": "1590",
                            "Flights": [
                              {
                                "ac": "GA",
                                "FlightNo": "GA822",
                                "STD": "CGK",
                                "STA": "SIN",
                                "ETD": "2017-05-23 20:40",
                                "ETA": "2017-05-23 23:30"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL836",
                                "STD": "SIN",
                                "STA": "AMS",
                                "ETD": "2017-05-24 00:40",
                                "ETA": "2017-05-24 07:35"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL1029",
                                "STD": "AMS",
                                "STA": "LHR",
                                "ETD": "2017-05-24 16:55",
                                "ETA": "2017-05-24 17:10"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 14668972,
                                "selectedIDdep": "4830906",
                                "TotalFare": 14678972
                              }
                            ]
                          },
                          {
                            "ac": "SQ",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1040",
                            "Flights": [
                              {
                                "ac": "SQ",
                                "FlightNo": "SQ953",
                                "STD": "CGK",
                                "STA": "SIN",
                                "ETD": "2017-05-23 07:55",
                                "ETA": "2017-05-23 10:45"
                              },
                              {
                                "ac": "SQ",
                                "FlightNo": "SQ318",
                                "STD": "SIN",
                                "STA": "LHR",
                                "ETD": "2017-05-23 12:35",
                                "ETA": "2017-05-23 19:15"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 23615396,
                                "selectedIDdep": "4830907",
                                "TotalFare": 23625396
                              }
                            ]
                          },
                          {
                            "ac": "TK",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1435",
                            "Flights": [
                              {
                                "ac": "TK",
                                "FlightNo": "TK57",
                                "STD": "CGK",
                                "STA": "IST",
                                "ETD": "2017-05-23 20:45",
                                "ETA": "2017-05-24 04:55"
                              },
                              {
                                "ac": "TK",
                                "FlightNo": "TK1985",
                                "STD": "IST",
                                "STA": "LHR",
                                "ETD": "2017-05-24 12:45",
                                "ETA": "2017-05-24 14:40"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 9377252,
                                "selectedIDdep": "4830908",
                                "TotalFare": 9387252
                              }
                            ]
                          },
                          {
                            "ac": "TK",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1905",
                            "Flights": [
                              {
                                "ac": "TK",
                                "FlightNo": "TK57",
                                "STD": "CGK",
                                "STA": "IST",
                                "ETD": "2017-05-23 20:45",
                                "ETA": "2017-05-24 04:55"
                              },
                              {
                                "ac": "TK",
                                "FlightNo": "TK1987",
                                "STD": "IST",
                                "STA": "LHR",
                                "ETD": "2017-05-24 20:20",
                                "ETA": "2017-05-24 22:30"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 9377252,
                                "selectedIDdep": "4830909",
                                "TotalFare": 9387252
                              }
                            ]
                          },
                          {
                            "ac": "QR",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1800",
                            "Flights": [
                              {
                                "ac": "QR",
                                "FlightNo": "QR959",
                                "STD": "CGK",
                                "STA": "DOH",
                                "ETD": "2017-05-23 09:00",
                                "ETA": "2017-05-23 13:35"
                              },
                              {
                                "ac": "QR",
                                "FlightNo": "QR11",
                                "STD": "DOH",
                                "STA": "LHR",
                                "ETD": "2017-05-24 03:30",
                                "ETA": "2017-05-24 09:00"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11993870,
                                "selectedIDdep": "4830910",
                                "TotalFare": 12003870
                              }
                            ]
                          },
                          {
                            "ac": "CX",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1275",
                            "Flights": [
                              {
                                "ac": "CX",
                                "FlightNo": "CX776",
                                "STD": "CGK",
                                "STA": "HKG",
                                "ETD": "2017-05-23 14:25",
                                "ETA": "2017-05-23 20:25"
                              },
                              {
                                "ac": "CX",
                                "FlightNo": "CX251",
                                "STD": "HKG",
                                "STA": "LHR",
                                "ETD": "2017-05-23 23:55",
                                "ETA": "2017-05-24 05:40"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 19665300,
                                "selectedIDdep": "4830911",
                                "TotalFare": 19675300
                              }
                            ]
                          },
                          {
                            "ac": "TK",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1800",
                            "Flights": [
                              {
                                "ac": "TK",
                                "FlightNo": "TK57",
                                "STD": "CGK",
                                "STA": "IST",
                                "ETD": "2017-05-23 20:45",
                                "ETA": "2017-05-24 04:55"
                              },
                              {
                                "ac": "TK",
                                "FlightNo": "TK1983",
                                "STD": "IST",
                                "STA": "LHR",
                                "ETD": "2017-05-24 18:35",
                                "ETA": "2017-05-24 20:45"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 9377252,
                                "selectedIDdep": "4830912",
                                "TotalFare": 9387252
                              }
                            ]
                          },
                          {
                            "ac": "QR",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "2335",
                            "Flights": [
                              {
                                "ac": "QR",
                                "FlightNo": "QR959",
                                "STD": "CGK",
                                "STA": "DOH",
                                "ETD": "2017-05-23 09:00",
                                "ETA": "2017-05-23 13:35"
                              },
                              {
                                "ac": "QR",
                                "FlightNo": "QR1",
                                "STD": "DOH",
                                "STA": "LHR",
                                "ETD": "2017-05-24 12:20",
                                "ETA": "2017-05-24 17:55"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11993870,
                                "selectedIDdep": "4830913",
                                "TotalFare": 12003870
                              }
                            ]
                          },
                          {
                            "ac": "QR",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "2055",
                            "Flights": [
                              {
                                "ac": "QR",
                                "FlightNo": "QR959",
                                "STD": "CGK",
                                "STA": "DOH",
                                "ETD": "2017-05-23 09:00",
                                "ETA": "2017-05-23 13:35"
                              },
                              {
                                "ac": "QR",
                                "FlightNo": "QR3",
                                "STD": "DOH",
                                "STA": "LHR",
                                "ETD": "2017-05-24 07:45",
                                "ETA": "2017-05-24 13:15"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11993870,
                                "selectedIDdep": "4830914",
                                "TotalFare": 12003870
                              }
                            ]
                          },
                          {
                            "ac": "GA",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1115",
                            "Flights": [
                              {
                                "ac": "GA",
                                "FlightNo": "GA88",
                                "STD": "CGK",
                                "STA": "AMS",
                                "ETD": "2017-05-23 22:10",
                                "ETA": "2017-05-24 07:20"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL1009",
                                "STD": "AMS",
                                "STA": "LHR",
                                "ETD": "2017-05-24 10:15",
                                "ETA": "2017-05-24 10:45"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 16608930,
                                "selectedIDdep": "4830915",
                                "TotalFare": 16618930
                              }
                            ]
                          },
                          {
                            "ac": "QR",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1140",
                            "Flights": [
                              {
                                "ac": "QR",
                                "FlightNo": "QR959",
                                "STD": "CGK",
                                "STA": "DOH",
                                "ETD": "2017-05-23 09:00",
                                "ETA": "2017-05-23 13:35"
                              },
                              {
                                "ac": "QR",
                                "FlightNo": "QR5",
                                "STD": "DOH",
                                "STA": "LHR",
                                "ETD": "2017-05-23 16:30",
                                "ETA": "2017-05-23 22:00"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11944629,
                                "selectedIDdep": "4830916",
                                "TotalFare": 11954629
                              }
                            ]
                          },
                          {
                            "ac": "QR",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1980",
                            "Flights": [
                              {
                                "ac": "QR",
                                "FlightNo": "QR959",
                                "STD": "CGK",
                                "STA": "DOH",
                                "ETD": "2017-05-23 09:00",
                                "ETA": "2017-05-23 13:35"
                              },
                              {
                                "ac": "QR",
                                "FlightNo": "QR7",
                                "STD": "DOH",
                                "STA": "LHR",
                                "ETD": "2017-05-24 06:35",
                                "ETA": "2017-05-24 12:00"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11993870,
                                "selectedIDdep": "4830917",
                                "TotalFare": 12003870
                              }
                            ]
                          },
                          {
                            "ac": "EY",
                            "food": true,
                            "tax": false,
                            "baggage": "2 Piece",
                            "durasi": "1370",
                            "Flights": [
                              {
                                "ac": "GA",
                                "FlightNo": "GA836",
                                "STD": "CGK",
                                "STA": "SIN",
                                "ETD": "2017-05-23 14:45",
                                "ETA": "2017-05-23 17:45"
                              },
                              {
                                "ac": "EY",
                                "FlightNo": "EY473",
                                "STD": "SIN",
                                "STA": "AUH",
                                "ETD": "2017-05-23 20:10",
                                "ETA": "2017-05-23 23:30"
                              },
                              {
                                "ac": "EY",
                                "FlightNo": "EY11",
                                "STD": "AUH",
                                "STA": "LHR",
                                "ETD": "2017-05-24 02:35",
                                "ETA": "2017-05-24 07:35"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "4",
                                "price": 10151836,
                                "selectedIDdep": "4830918",
                                "TotalFare": 10161836
                              }
                            ]
                          },
                          {
                            "ac": "TG",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1480",
                            "Flights": [
                              {
                                "ac": "TG",
                                "FlightNo": "TG434",
                                "STD": "CGK",
                                "STA": "BKK",
                                "ETD": "2017-05-23 12:35",
                                "ETA": "2017-05-23 16:05"
                              },
                              {
                                "ac": "TG",
                                "FlightNo": "TG910",
                                "STD": "BKK",
                                "STA": "LHR",
                                "ETD": "2017-05-24 01:10",
                                "ETA": "2017-05-24 07:15"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 7018344,
                                "selectedIDdep": "4830919",
                                "TotalFare": 7028344
                              }
                            ]
                          },
                          {
                            "ac": "KL",
                            "food": true,
                            "tax": false,
                            "baggage": "0 KG",
                            "durasi": "1705",
                            "Flights": [
                              {
                                "ac": "KL",
                                "FlightNo": "KL810",
                                "STD": "CGK",
                                "STA": "KUL",
                                "ETD": "2017-05-23 18:45",
                                "ETA": "2017-05-23 21:55"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL810",
                                "STD": "KUL",
                                "STA": "AMS",
                                "ETD": "2017-05-23 23:20",
                                "ETA": "2017-05-24 06:00"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL1029",
                                "STD": "AMS",
                                "STA": "LHR",
                                "ETD": "2017-05-24 16:55",
                                "ETA": "2017-05-24 17:10"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 14610376,
                                "selectedIDdep": "4830920",
                                "TotalFare": 14620376
                              }
                            ]
                          },
                          {
                            "ac": "SQ",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1125",
                            "Flights": [
                              {
                                "ac": "SQ",
                                "FlightNo": "SQ965",
                                "STD": "CGK",
                                "STA": "SIN",
                                "ETD": "2017-05-23 19:00",
                                "ETA": "2017-05-23 21:50"
                              },
                              {
                                "ac": "SQ",
                                "FlightNo": "SQ306",
                                "STD": "SIN",
                                "STA": "LHR",
                                "ETD": "2017-05-24 01:10",
                                "ETA": "2017-05-24 07:45"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 23615396,
                                "selectedIDdep": "4830921",
                                "TotalFare": 23625396
                              }
                            ]
                          },
                          {
                            "ac": "EY",
                            "food": true,
                            "tax": false,
                            "baggage": "2 Piece",
                            "durasi": "1695",
                            "Flights": [
                              {
                                "ac": "GA",
                                "FlightNo": "GA836",
                                "STD": "CGK",
                                "STA": "SIN",
                                "ETD": "2017-05-23 14:45",
                                "ETA": "2017-05-23 17:45"
                              },
                              {
                                "ac": "EY",
                                "FlightNo": "EY473",
                                "STD": "SIN",
                                "STA": "AUH",
                                "ETD": "2017-05-23 20:10",
                                "ETA": "2017-05-23 23:30"
                              },
                              {
                                "ac": "EY",
                                "FlightNo": "EY19",
                                "STD": "AUH",
                                "STA": "LHR",
                                "ETD": "2017-05-24 08:10",
                                "ETA": "2017-05-24 13:00"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "4",
                                "price": 10151836,
                                "selectedIDdep": "4830922",
                                "TotalFare": 10161836
                              }
                            ]
                          },
                          {
                            "ac": "MH",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1850",
                            "Flights": [
                              {
                                "ac": "MH",
                                "FlightNo": "MH720",
                                "STD": "CGK",
                                "STA": "KUL",
                                "ETD": "2017-05-23 15:45",
                                "ETA": "2017-05-23 18:50"
                              },
                              {
                                "ac": "MH",
                                "FlightNo": "MH4",
                                "STD": "KUL",
                                "STA": "LHR",
                                "ETD": "2017-05-24 09:50",
                                "ETA": "2017-05-24 16:35"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 10629172,
                                "selectedIDdep": "4830923",
                                "TotalFare": 10639172
                              }
                            ]
                          },
                          {
                            "ac": "MH",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1210",
                            "Flights": [
                              {
                                "ac": "MH",
                                "FlightNo": "MH720",
                                "STD": "CGK",
                                "STA": "KUL",
                                "ETD": "2017-05-23 15:45",
                                "ETA": "2017-05-23 18:50"
                              },
                              {
                                "ac": "MH",
                                "FlightNo": "MH2",
                                "STD": "KUL",
                                "STA": "LHR",
                                "ETD": "2017-05-23 23:15",
                                "ETA": "2017-05-24 05:55"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 9000280,
                                "selectedIDdep": "4830924",
                                "TotalFare": 9010280
                              }
                            ]
                          },
                          {
                            "ac": "EK",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1185",
                            "Flights": [
                              {
                                "ac": "EK",
                                "FlightNo": "EK359",
                                "STD": "CGK",
                                "STA": "DXB",
                                "ETD": "2017-05-23 00:40",
                                "ETA": "2017-05-23 05:40"
                              },
                              {
                                "ac": "EK",
                                "FlightNo": "EK29",
                                "STD": "DXB",
                                "STA": "LHR",
                                "ETD": "2017-05-23 09:40",
                                "ETA": "2017-05-23 14:25"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11817191,
                                "selectedIDdep": "4830925",
                                "TotalFare": 11827191
                              }
                            ]
                          },
                          {
                            "ac": "KL",
                            "food": true,
                            "tax": false,
                            "baggage": "0 KG",
                            "durasi": "1650",
                            "Flights": [
                              {
                                "ac": "KL",
                                "FlightNo": "KL810",
                                "STD": "CGK",
                                "STA": "KUL",
                                "ETD": "2017-05-23 18:45",
                                "ETA": "2017-05-23 21:55"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL810",
                                "STD": "KUL",
                                "STA": "AMS",
                                "ETD": "2017-05-23 23:20",
                                "ETA": "2017-05-24 06:00"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL1021",
                                "STD": "AMS",
                                "STA": "LHR",
                                "ETD": "2017-05-24 15:50",
                                "ETA": "2017-05-24 16:15"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 14610376,
                                "selectedIDdep": "4830926",
                                "TotalFare": 14620376
                              }
                            ]
                          },
                          {
                            "ac": "TG",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "2170",
                            "Flights": [
                              {
                                "ac": "TG",
                                "FlightNo": "TG434",
                                "STD": "CGK",
                                "STA": "BKK",
                                "ETD": "2017-05-23 12:35",
                                "ETA": "2017-05-23 16:05"
                              },
                              {
                                "ac": "TG",
                                "FlightNo": "TG916",
                                "STD": "BKK",
                                "STA": "LHR",
                                "ETD": "2017-05-24 12:40",
                                "ETA": "2017-05-24 18:45"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 7038185,
                                "selectedIDdep": "4830927",
                                "TotalFare": 7048185
                              }
                            ]
                          },
                          {
                            "ac": "EY",
                            "food": true,
                            "tax": false,
                            "baggage": "2 Piece",
                            "durasi": "1765",
                            "Flights": [
                              {
                                "ac": "GA",
                                "FlightNo": "GA816",
                                "STD": "CGK",
                                "STA": "KUL",
                                "ETD": "2017-05-23 13:35",
                                "ETA": "2017-05-23 17:00"
                              },
                              {
                                "ac": "EY",
                                "FlightNo": "EY411",
                                "STD": "KUL",
                                "STA": "AUH",
                                "ETD": "2017-05-23 19:35",
                                "ETA": "2017-05-23 22:55"
                              },
                              {
                                "ac": "EY",
                                "FlightNo": "EY19",
                                "STD": "AUH",
                                "STA": "LHR",
                                "ETD": "2017-05-24 08:10",
                                "ETA": "2017-05-24 13:00"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "4",
                                "price": 10095121,
                                "selectedIDdep": "4830928",
                                "TotalFare": 10105121
                              }
                            ]
                          },
                          {
                            "ac": "MH",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1420",
                            "Flights": [
                              {
                                "ac": "MH",
                                "FlightNo": "MH716",
                                "STD": "CGK",
                                "STA": "KUL",
                                "ETD": "2017-05-23 12:15",
                                "ETA": "2017-05-23 15:25"
                              },
                              {
                                "ac": "MH",
                                "FlightNo": "MH2",
                                "STD": "KUL",
                                "STA": "LHR",
                                "ETD": "2017-05-23 23:15",
                                "ETA": "2017-05-24 05:55"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 9000280,
                                "selectedIDdep": "4830929",
                                "TotalFare": 9010280
                              }
                            ]
                          },
                          {
                            "ac": "EK",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1055",
                            "Flights": [
                              {
                                "ac": "EK",
                                "FlightNo": "EK359",
                                "STD": "CGK",
                                "STA": "DXB",
                                "ETD": "2017-05-23 00:40",
                                "ETA": "2017-05-23 05:40"
                              },
                              {
                                "ac": "EK",
                                "FlightNo": "EK1",
                                "STD": "DXB",
                                "STA": "LHR",
                                "ETD": "2017-05-23 07:45",
                                "ETA": "2017-05-23 12:15"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11817191,
                                "selectedIDdep": "4830930",
                                "TotalFare": 11827191
                              }
                            ]
                          },
                          {
                            "ac": "SQ",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "975",
                            "Flights": [
                              {
                                "ac": "SQ",
                                "FlightNo": "SQ951",
                                "STD": "CGK",
                                "STA": "SIN",
                                "ETD": "2017-05-23 05:25",
                                "ETA": "2017-05-23 08:10"
                              },
                              {
                                "ac": "SQ",
                                "FlightNo": "SQ308",
                                "STD": "SIN",
                                "STA": "LHR",
                                "ETD": "2017-05-23 09:00",
                                "ETA": "2017-05-23 15:40"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 23615396,
                                "selectedIDdep": "4830931",
                                "TotalFare": 23625396
                              }
                            ]
                          },
                          {
                            "ac": "EY",
                            "food": true,
                            "tax": false,
                            "baggage": "2 Piece",
                            "durasi": "1440",
                            "Flights": [
                              {
                                "ac": "GA",
                                "FlightNo": "GA816",
                                "STD": "CGK",
                                "STA": "KUL",
                                "ETD": "2017-05-23 13:35",
                                "ETA": "2017-05-23 17:00"
                              },
                              {
                                "ac": "EY",
                                "FlightNo": "EY411",
                                "STD": "KUL",
                                "STA": "AUH",
                                "ETD": "2017-05-23 19:35",
                                "ETA": "2017-05-23 22:55"
                              },
                              {
                                "ac": "EY",
                                "FlightNo": "EY11",
                                "STD": "AUH",
                                "STA": "LHR",
                                "ETD": "2017-05-24 02:35",
                                "ETA": "2017-05-24 07:35"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "4",
                                "price": 10095121,
                                "selectedIDdep": "4830932",
                                "TotalFare": 10105121
                              }
                            ]
                          },
                          {
                            "ac": "MH",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "2060",
                            "Flights": [
                              {
                                "ac": "MH",
                                "FlightNo": "MH716",
                                "STD": "CGK",
                                "STA": "KUL",
                                "ETD": "2017-05-23 12:15",
                                "ETA": "2017-05-23 15:25"
                              },
                              {
                                "ac": "MH",
                                "FlightNo": "MH4",
                                "STD": "KUL",
                                "STA": "LHR",
                                "ETD": "2017-05-24 09:50",
                                "ETA": "2017-05-24 16:35"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 10629172,
                                "selectedIDdep": "4830933",
                                "TotalFare": 10639172
                              }
                            ]
                          },
                          {
                            "ac": "EK",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1440",
                            "Flights": [
                              {
                                "ac": "EK",
                                "FlightNo": "EK359",
                                "STD": "CGK",
                                "STA": "DXB",
                                "ETD": "2017-05-23 00:40",
                                "ETA": "2017-05-23 05:40"
                              },
                              {
                                "ac": "EK",
                                "FlightNo": "EK3",
                                "STD": "DXB",
                                "STA": "LHR",
                                "ETD": "2017-05-23 14:15",
                                "ETA": "2017-05-23 18:40"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11817191,
                                "selectedIDdep": "4830934",
                                "TotalFare": 11827191
                              }
                            ]
                          },
                          {
                            "ac": "SQ",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1050",
                            "Flights": [
                              {
                                "ac": "SQ",
                                "FlightNo": "SQ967",
                                "STD": "CGK",
                                "STA": "SIN",
                                "ETD": "2017-05-23 20:15",
                                "ETA": "2017-05-23 23:05"
                              },
                              {
                                "ac": "SQ",
                                "FlightNo": "SQ306",
                                "STD": "SIN",
                                "STA": "LHR",
                                "ETD": "2017-05-24 01:10",
                                "ETA": "2017-05-24 07:45"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 23615396,
                                "selectedIDdep": "4830935",
                                "TotalFare": 23625396
                              }
                            ]
                          },
                          {
                            "ac": "EK",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1535",
                            "Flights": [
                              {
                                "ac": "EK",
                                "FlightNo": "EK359",
                                "STD": "CGK",
                                "STA": "DXB",
                                "ETD": "2017-05-23 00:40",
                                "ETA": "2017-05-23 05:40"
                              },
                              {
                                "ac": "EK",
                                "FlightNo": "EK5",
                                "STD": "DXB",
                                "STA": "LHR",
                                "ETD": "2017-05-23 15:45",
                                "ETA": "2017-05-23 20:15"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11817191,
                                "selectedIDdep": "4830936",
                                "TotalFare": 11827191
                              }
                            ]
                          },
                          {
                            "ac": "EK",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "2185",
                            "Flights": [
                              {
                                "ac": "EK",
                                "FlightNo": "EK359",
                                "STD": "CGK",
                                "STA": "DXB",
                                "ETD": "2017-05-23 00:40",
                                "ETA": "2017-05-23 05:40"
                              },
                              {
                                "ac": "EK",
                                "FlightNo": "EK7",
                                "STD": "DXB",
                                "STA": "LHR",
                                "ETD": "2017-05-24 02:30",
                                "ETA": "2017-05-24 07:05"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11835900,
                                "selectedIDdep": "4830937",
                                "TotalFare": 11845900
                              }
                            ]
                          },
                          {
                            "ac": "QR",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1565",
                            "Flights": [
                              {
                                "ac": "QR",
                                "FlightNo": "QR955",
                                "STD": "CGK",
                                "STA": "DOH",
                                "ETD": "2017-05-23 00:20",
                                "ETA": "2017-05-23 04:55"
                              },
                              {
                                "ac": "QR",
                                "FlightNo": "QR15",
                                "STD": "DOH",
                                "STA": "LHR",
                                "ETD": "2017-05-23 14:55",
                                "ETA": "2017-05-23 20:25"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11944629,
                                "selectedIDdep": "4830938",
                                "TotalFare": 11954629
                              }
                            ]
                          },
                          {
                            "ac": "QR",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "2320",
                            "Flights": [
                              {
                                "ac": "QR",
                                "FlightNo": "QR955",
                                "STD": "CGK",
                                "STA": "DOH",
                                "ETD": "2017-05-23 00:20",
                                "ETA": "2017-05-23 04:55"
                              },
                              {
                                "ac": "QR",
                                "FlightNo": "QR11",
                                "STD": "DOH",
                                "STA": "LHR",
                                "ETD": "2017-05-24 03:30",
                                "ETA": "2017-05-24 09:00"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11993870,
                                "selectedIDdep": "4830939",
                                "TotalFare": 12003870
                              }
                            ]
                          },
                          {
                            "ac": "KL",
                            "food": true,
                            "tax": false,
                            "baggage": "0 KG",
                            "durasi": "1575",
                            "Flights": [
                              {
                                "ac": "KL",
                                "FlightNo": "KL810",
                                "STD": "CGK",
                                "STA": "KUL",
                                "ETD": "2017-05-23 18:45",
                                "ETA": "2017-05-23 21:55"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL810",
                                "STD": "KUL",
                                "STA": "AMS",
                                "ETD": "2017-05-23 23:20",
                                "ETA": "2017-05-24 06:00"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL1019",
                                "STD": "AMS",
                                "STA": "LHR",
                                "ETD": "2017-05-24 14:40",
                                "ETA": "2017-05-24 15:00"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 14610376,
                                "selectedIDdep": "4830940",
                                "TotalFare": 14620376
                              }
                            ]
                          },
                          {
                            "ac": "KL",
                            "food": true,
                            "tax": false,
                            "baggage": "0 KG",
                            "durasi": "1505",
                            "Flights": [
                              {
                                "ac": "KL",
                                "FlightNo": "KL810",
                                "STD": "CGK",
                                "STA": "KUL",
                                "ETD": "2017-05-23 18:45",
                                "ETA": "2017-05-23 21:55"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL810",
                                "STD": "KUL",
                                "STA": "AMS",
                                "ETD": "2017-05-23 23:20",
                                "ETA": "2017-05-24 06:00"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL1017",
                                "STD": "AMS",
                                "STA": "LHR",
                                "ETD": "2017-05-24 13:20",
                                "ETA": "2017-05-24 13:50"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 12559516,
                                "selectedIDdep": "4830941",
                                "TotalFare": 12569516
                              }
                            ]
                          },
                          {
                            "ac": "EK",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1590",
                            "Flights": [
                              {
                                "ac": "EK",
                                "FlightNo": "EK357",
                                "STD": "CGK",
                                "STA": "DXB",
                                "ETD": "2017-05-23 17:55",
                                "ETA": "2017-05-23 22:55"
                              },
                              {
                                "ac": "EK",
                                "FlightNo": "EK29",
                                "STD": "DXB",
                                "STA": "LHR",
                                "ETD": "2017-05-24 09:40",
                                "ETA": "2017-05-24 14:25"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11817191,
                                "selectedIDdep": "4830942",
                                "TotalFare": 11827191
                              }
                            ]
                          },
                          {
                            "ac": "EK",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1695",
                            "Flights": [
                              {
                                "ac": "EK",
                                "FlightNo": "EK357",
                                "STD": "CGK",
                                "STA": "DXB",
                                "ETD": "2017-05-23 17:55",
                                "ETA": "2017-05-23 22:55"
                              },
                              {
                                "ac": "EK",
                                "FlightNo": "EK31",
                                "STD": "DXB",
                                "STA": "LHR",
                                "ETD": "2017-05-24 11:30",
                                "ETA": "2017-05-24 16:10"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11835900,
                                "selectedIDdep": "4830943",
                                "TotalFare": 11845900
                              }
                            ]
                          },
                          {
                            "ac": "SQ",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1190",
                            "Flights": [
                              {
                                "ac": "SQ",
                                "FlightNo": "SQ951",
                                "STD": "CGK",
                                "STA": "SIN",
                                "ETD": "2017-05-23 05:25",
                                "ETA": "2017-05-23 08:10"
                              },
                              {
                                "ac": "SQ",
                                "FlightNo": "SQ318",
                                "STD": "SIN",
                                "STA": "LHR",
                                "ETD": "2017-05-23 12:35",
                                "ETA": "2017-05-23 19:15"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 23615396,
                                "selectedIDdep": "4830944",
                                "TotalFare": 23625396
                              }
                            ]
                          },
                          {
                            "ac": "MH",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1090",
                            "Flights": [
                              {
                                "ac": "MH",
                                "FlightNo": "MH726",
                                "STD": "CGK",
                                "STA": "KUL",
                                "ETD": "2017-05-23 04:25",
                                "ETA": "2017-05-23 07:25"
                              },
                              {
                                "ac": "MH",
                                "FlightNo": "MH4",
                                "STD": "KUL",
                                "STA": "LHR",
                                "ETD": "2017-05-23 09:50",
                                "ETA": "2017-05-23 16:35"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 8304130,
                                "selectedIDdep": "4830945",
                                "TotalFare": 8314130
                              }
                            ]
                          },
                          {
                            "ac": "MH",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1890",
                            "Flights": [
                              {
                                "ac": "MH",
                                "FlightNo": "MH726",
                                "STD": "CGK",
                                "STA": "KUL",
                                "ETD": "2017-05-23 04:25",
                                "ETA": "2017-05-23 07:25"
                              },
                              {
                                "ac": "MH",
                                "FlightNo": "MH2",
                                "STD": "KUL",
                                "STA": "LHR",
                                "ETD": "2017-05-23 23:15",
                                "ETA": "2017-05-24 05:55"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 9236872,
                                "selectedIDdep": "4830946",
                                "TotalFare": 9246872
                              }
                            ]
                          },
                          {
                            "ac": "EY",
                            "food": true,
                            "tax": false,
                            "baggage": "2 Piece",
                            "durasi": "1475",
                            "Flights": [
                              {
                                "ac": "EY",
                                "FlightNo": "EY471",
                                "STD": "CGK",
                                "STA": "AUH",
                                "ETD": "2017-05-23 00:10",
                                "ETA": "2017-05-23 05:40"
                              },
                              {
                                "ac": "EY",
                                "FlightNo": "EY17",
                                "STD": "AUH",
                                "STA": "LHR",
                                "ETD": "2017-05-23 13:50",
                                "ETA": "2017-05-23 18:45"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 10095121,
                                "selectedIDdep": "4830947",
                                "TotalFare": 10105121
                              }
                            ]
                          },
                          {
                            "ac": "GA",
                            "food": true,
                            "tax": false,
                            "baggage": "0 KG",
                            "durasi": "1030",
                            "Flights": [
                              {
                                "ac": "GA",
                                "FlightNo": "GA86",
                                "STD": "CGK",
                                "STA": "SIN",
                                "ETD": "2017-05-23 07:45",
                                "ETA": "2017-05-23 10:35"
                              },
                              {
                                "ac": "GA",
                                "FlightNo": "GA86",
                                "STD": "SIN",
                                "STA": "LHR",
                                "ETD": "2017-05-23 12:00",
                                "ETA": "2017-05-23 18:55"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 7427243,
                                "selectedIDdep": "4830948",
                                "TotalFare": 7437243
                              }
                            ]
                          },
                          {
                            "ac": "EY",
                            "food": true,
                            "tax": false,
                            "baggage": "2 Piece",
                            "durasi": "1130",
                            "Flights": [
                              {
                                "ac": "EY",
                                "FlightNo": "EY471",
                                "STD": "CGK",
                                "STA": "AUH",
                                "ETD": "2017-05-23 00:10",
                                "ETA": "2017-05-23 05:40"
                              },
                              {
                                "ac": "EY",
                                "FlightNo": "EY19",
                                "STD": "AUH",
                                "STA": "LHR",
                                "ETD": "2017-05-23 08:10",
                                "ETA": "2017-05-23 13:00"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 10095121,
                                "selectedIDdep": "4830949",
                                "TotalFare": 10105121
                              }
                            ]
                          },
                          {
                            "ac": "BA",
                            "food": true,
                            "tax": false,
                            "baggage": "1 Piece",
                            "durasi": "1635",
                            "Flights": [
                              {
                                "ac": "CX",
                                "FlightNo": "CX718",
                                "STD": "CGK",
                                "STA": "HKG",
                                "ETD": "2017-05-23 08:20",
                                "ETA": "2017-05-23 14:20"
                              },
                              {
                                "ac": "BA",
                                "FlightNo": "BA28",
                                "STD": "HKG",
                                "STA": "LHR",
                                "ETD": "2017-05-23 23:45",
                                "ETA": "2017-05-24 05:35"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "5",
                                "price": 14257700,
                                "selectedIDdep": "4830950",
                                "TotalFare": 14267700
                              }
                            ]
                          },
                          {
                            "ac": "QR",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1520",
                            "Flights": [
                              {
                                "ac": "QR",
                                "FlightNo": "QR957",
                                "STD": "CGK",
                                "STA": "DOH",
                                "ETD": "2017-05-23 18:45",
                                "ETA": "2017-05-23 23:20"
                              },
                              {
                                "ac": "BA",
                                "FlightNo": "BA122",
                                "STD": "DOH",
                                "STA": "LHR",
                                "ETD": "2017-05-24 08:45",
                                "ETA": "2017-05-24 14:05"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11944629,
                                "selectedIDdep": "4830951",
                                "TotalFare": 11954629
                              }
                            ]
                          },
                          {
                            "ac": "EK",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1150",
                            "Flights": [
                              {
                                "ac": "EK",
                                "FlightNo": "EK357",
                                "STD": "CGK",
                                "STA": "DXB",
                                "ETD": "2017-05-23 17:55",
                                "ETA": "2017-05-23 22:55"
                              },
                              {
                                "ac": "EK",
                                "FlightNo": "EK7",
                                "STD": "DXB",
                                "STA": "LHR",
                                "ETD": "2017-05-24 02:30",
                                "ETA": "2017-05-24 07:05"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11817191,
                                "selectedIDdep": "4830952",
                                "TotalFare": 11827191
                              }
                            ]
                          },
                          {
                            "ac": "MH",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1485",
                            "Flights": [
                              {
                                "ac": "MH",
                                "FlightNo": "MH710",
                                "STD": "CGK",
                                "STA": "KUL",
                                "ETD": "2017-05-23 11:10",
                                "ETA": "2017-05-23 14:15"
                              },
                              {
                                "ac": "MH",
                                "FlightNo": "MH2",
                                "STD": "KUL",
                                "STA": "LHR",
                                "ETD": "2017-05-23 23:15",
                                "ETA": "2017-05-24 05:55"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 9000280,
                                "selectedIDdep": "4830953",
                                "TotalFare": 9010280
                              }
                            ]
                          },
                          {
                            "ac": "CZ",
                            "food": true,
                            "tax": false,
                            "baggage": "1 Piece",
                            "durasi": "1660",
                            "Flights": [
                              {
                                "ac": "CZ",
                                "FlightNo": "CZ3038",
                                "STD": "CGK",
                                "STA": "CAN",
                                "ETD": "2017-05-23 13:05",
                                "ETA": "2017-05-23 19:05"
                              },
                              {
                                "ac": "CZ",
                                "FlightNo": "CZ307",
                                "STD": "CAN",
                                "STA": "AMS",
                                "ETD": "2017-05-24 00:05",
                                "ETA": "2017-05-24 06:45"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL1009",
                                "STD": "AMS",
                                "STA": "LHR",
                                "ETD": "2017-05-24 10:15",
                                "ETA": "2017-05-24 10:45"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 12245212,
                                "selectedIDdep": "4830954",
                                "TotalFare": 12255212
                              }
                            ]
                          },
                          {
                            "ac": "CZ",
                            "food": true,
                            "tax": false,
                            "baggage": "1 Piece",
                            "durasi": "1555",
                            "Flights": [
                              {
                                "ac": "CZ",
                                "FlightNo": "CZ3038",
                                "STD": "CGK",
                                "STA": "CAN",
                                "ETD": "2017-05-23 13:05",
                                "ETA": "2017-05-23 19:05"
                              },
                              {
                                "ac": "CZ",
                                "FlightNo": "CZ307",
                                "STD": "CAN",
                                "STA": "AMS",
                                "ETD": "2017-05-24 00:05",
                                "ETA": "2017-05-24 06:45"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL1007",
                                "STD": "AMS",
                                "STA": "LHR",
                                "ETD": "2017-05-24 08:40",
                                "ETA": "2017-05-24 09:00"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "6",
                                "price": 12245212,
                                "selectedIDdep": "4830955",
                                "TotalFare": 12255212
                              }
                            ]
                          },
                          {
                            "ac": "KL",
                            "food": true,
                            "tax": false,
                            "baggage": "1 Piece",
                            "durasi": "1445",
                            "Flights": [
                              {
                                "ac": "GA",
                                "FlightNo": "GA816",
                                "STD": "CGK",
                                "STA": "KUL",
                                "ETD": "2017-05-23 13:35",
                                "ETA": "2017-05-23 17:00"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL810",
                                "STD": "KUL",
                                "STA": "AMS",
                                "ETD": "2017-05-23 23:20",
                                "ETA": "2017-05-24 06:00"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL1001",
                                "STD": "AMS",
                                "STA": "LHR",
                                "ETD": "2017-05-24 07:20",
                                "ETA": "2017-05-24 07:40"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 14610376,
                                "selectedIDdep": "4830956",
                                "TotalFare": 14620376
                              }
                            ]
                          },
                          {
                            "ac": "KL",
                            "food": true,
                            "tax": false,
                            "baggage": "1 Piece",
                            "durasi": "1525",
                            "Flights": [
                              {
                                "ac": "GA",
                                "FlightNo": "GA816",
                                "STD": "CGK",
                                "STA": "KUL",
                                "ETD": "2017-05-23 13:35",
                                "ETA": "2017-05-23 17:00"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL810",
                                "STD": "KUL",
                                "STA": "AMS",
                                "ETD": "2017-05-23 23:20",
                                "ETA": "2017-05-24 06:00"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL1007",
                                "STD": "AMS",
                                "STA": "LHR",
                                "ETD": "2017-05-24 08:40",
                                "ETA": "2017-05-24 09:00"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 14610376,
                                "selectedIDdep": "4830957",
                                "TotalFare": 14620376
                              }
                            ]
                          },
                          {
                            "ac": "SQ",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1135",
                            "Flights": [
                              {
                                "ac": "SQ",
                                "FlightNo": "SQ961",
                                "STD": "CGK",
                                "STA": "SIN",
                                "ETD": "2017-05-23 17:00",
                                "ETA": "2017-05-23 19:50"
                              },
                              {
                                "ac": "SQ",
                                "FlightNo": "SQ322",
                                "STD": "SIN",
                                "STA": "LHR",
                                "ETD": "2017-05-23 23:30",
                                "ETA": "2017-05-24 05:55"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 23615396,
                                "selectedIDdep": "4830958",
                                "TotalFare": 23625396
                              }
                            ]
                          },
                          {
                            "ac": "EK",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1460",
                            "Flights": [
                              {
                                "ac": "EK",
                                "FlightNo": "EK357",
                                "STD": "CGK",
                                "STA": "DXB",
                                "ETD": "2017-05-23 17:55",
                                "ETA": "2017-05-23 22:55"
                              },
                              {
                                "ac": "EK",
                                "FlightNo": "EK1",
                                "STD": "DXB",
                                "STA": "LHR",
                                "ETD": "2017-05-24 07:45",
                                "ETA": "2017-05-24 12:15"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11817191,
                                "selectedIDdep": "4830959",
                                "TotalFare": 11827191
                              }
                            ]
                          },
                          {
                            "ac": "EK",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1290",
                            "Flights": [
                              {
                                "ac": "EK",
                                "FlightNo": "EK359",
                                "STD": "CGK",
                                "STA": "DXB",
                                "ETD": "2017-05-23 00:40",
                                "ETA": "2017-05-23 05:40"
                              },
                              {
                                "ac": "EK",
                                "FlightNo": "EK31",
                                "STD": "DXB",
                                "STA": "LHR",
                                "ETD": "2017-05-23 11:30",
                                "ETA": "2017-05-23 16:10"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11817191,
                                "selectedIDdep": "4830960",
                                "TotalFare": 11827191
                              }
                            ]
                          },
                          {
                            "ac": "MH",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "2125",
                            "Flights": [
                              {
                                "ac": "MH",
                                "FlightNo": "MH710",
                                "STD": "CGK",
                                "STA": "KUL",
                                "ETD": "2017-05-23 11:10",
                                "ETA": "2017-05-23 14:15"
                              },
                              {
                                "ac": "MH",
                                "FlightNo": "MH4",
                                "STD": "KUL",
                                "STA": "LHR",
                                "ETD": "2017-05-24 09:50",
                                "ETA": "2017-05-24 16:35"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 10629172,
                                "selectedIDdep": "4830961",
                                "TotalFare": 10639172
                              }
                            ]
                          },
                          {
                            "ac": "EK",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1845",
                            "Flights": [
                              {
                                "ac": "EK",
                                "FlightNo": "EK357",
                                "STD": "CGK",
                                "STA": "DXB",
                                "ETD": "2017-05-23 17:55",
                                "ETA": "2017-05-23 22:55"
                              },
                              {
                                "ac": "EK",
                                "FlightNo": "EK3",
                                "STD": "DXB",
                                "STA": "LHR",
                                "ETD": "2017-05-24 14:15",
                                "ETA": "2017-05-24 18:40"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11835900,
                                "selectedIDdep": "4830962",
                                "TotalFare": 11845900
                              }
                            ]
                          },
                          {
                            "ac": "EK",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1940",
                            "Flights": [
                              {
                                "ac": "EK",
                                "FlightNo": "EK357",
                                "STD": "CGK",
                                "STA": "DXB",
                                "ETD": "2017-05-23 17:55",
                                "ETA": "2017-05-23 22:55"
                              },
                              {
                                "ac": "EK",
                                "FlightNo": "EK5",
                                "STD": "DXB",
                                "STA": "LHR",
                                "ETD": "2017-05-24 15:45",
                                "ETA": "2017-05-24 20:15"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 11835900,
                                "selectedIDdep": "4830963",
                                "TotalFare": 11845900
                              }
                            ]
                          },
                          {
                            "ac": "KL",
                            "food": true,
                            "tax": false,
                            "baggage": "1 Piece",
                            "durasi": "1630",
                            "Flights": [
                              {
                                "ac": "GA",
                                "FlightNo": "GA816",
                                "STD": "CGK",
                                "STA": "KUL",
                                "ETD": "2017-05-23 13:35",
                                "ETA": "2017-05-23 17:00"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL810",
                                "STD": "KUL",
                                "STA": "AMS",
                                "ETD": "2017-05-23 23:20",
                                "ETA": "2017-05-24 06:00"
                              },
                              {
                                "ac": "KL",
                                "FlightNo": "KL1009",
                                "STD": "AMS",
                                "STA": "LHR",
                                "ETD": "2017-05-24 10:15",
                                "ETA": "2017-05-24 10:45"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 14610376,
                                "selectedIDdep": "4830964",
                                "TotalFare": 14620376
                              }
                            ]
                          },
                          {
                            "ac": "EY",
                            "food": true,
                            "tax": false,
                            "baggage": "2 Piece",
                            "durasi": "1185",
                            "Flights": [
                              {
                                "ac": "EY",
                                "FlightNo": "EY475",
                                "STD": "CGK",
                                "STA": "AUH",
                                "ETD": "2017-05-23 17:50",
                                "ETA": "2017-05-23 23:20"
                              },
                              {
                                "ac": "EY",
                                "FlightNo": "EY11",
                                "STD": "AUH",
                                "STA": "LHR",
                                "ETD": "2017-05-24 02:35",
                                "ETA": "2017-05-24 07:35"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 10095121,
                                "selectedIDdep": "4830965",
                                "TotalFare": 10105121
                              }
                            ]
                          },
                          {
                            "ac": "BA",
                            "food": true,
                            "tax": false,
                            "baggage": "1 Piece",
                            "durasi": "1270",
                            "Flights": [
                              {
                                "ac": "CX",
                                "FlightNo": "CX776",
                                "STD": "CGK",
                                "STA": "HKG",
                                "ETD": "2017-05-23 14:25",
                                "ETA": "2017-05-23 20:25"
                              },
                              {
                                "ac": "BA",
                                "FlightNo": "BA28",
                                "STD": "HKG",
                                "STA": "LHR",
                                "ETD": "2017-05-23 23:45",
                                "ETA": "2017-05-24 05:35"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "5",
                                "price": 14257700,
                                "selectedIDdep": "4830966",
                                "TotalFare": 14267700
                              }
                            ]
                          },
                          {
                            "ac": "KE",
                            "food": true,
                            "tax": false,
                            "baggage": "1 Piece",
                            "durasi": "1520",
                            "Flights": [
                              {
                                "ac": "KE",
                                "FlightNo": "KE628",
                                "STD": "CGK",
                                "STA": "ICN",
                                "ETD": "2017-05-23 22:05",
                                "ETA": "2017-05-24 07:15"
                              },
                              {
                                "ac": "KE",
                                "FlightNo": "KE907",
                                "STD": "ICN",
                                "STA": "LHR",
                                "ETD": "2017-05-24 13:15",
                                "ETA": "2017-05-24 17:25"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 18175914,
                                "selectedIDdep": "4830967",
                                "TotalFare": 18185914
                              }
                            ]
                          },
                          {
                            "ac": "CZ",
                            "food": true,
                            "tax": false,
                            "baggage": "1 Piece",
                            "durasi": "2160",
                            "Flights": [
                              {
                                "ac": "CZ",
                                "FlightNo": "CZ388",
                                "STD": "CGK",
                                "STA": "CAN",
                                "ETD": "2017-05-23 09:05",
                                "ETA": "2017-05-23 14:45"
                              },
                              {
                                "ac": "CZ",
                                "FlightNo": "CZ303",
                                "STD": "CAN",
                                "STA": "LHR",
                                "ETD": "2017-05-24 09:30",
                                "ETA": "2017-05-24 15:05"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "8",
                                "price": 10886239,
                                "selectedIDdep": "4830968",
                                "TotalFare": 10896239
                              }
                            ]
                          },
                          {
                            "ac": "GA",
                            "food": true,
                            "tax": false,
                            "baggage": "30 KG",
                            "durasi": "1125",
                            "Flights": [
                              {
                                "ac": "GA",
                                "FlightNo": "GA824",
                                "STD": "CGK",
                                "STA": "SIN",
                                "ETD": "2017-05-23 06:10",
                                "ETA": "2017-05-23 09:00"
                              },
                              {
                                "ac": "GA",
                                "FlightNo": "GA86",
                                "STD": "SIN",
                                "STA": "LHR",
                                "ETD": "2017-05-23 12:00",
                                "ETA": "2017-05-23 18:55"
                              }
                            ],
                            "Fares": [
                              {
                                "seatAvl": "9",
                                "price": 10143305,
                                "selectedIDdep": "4830969",
                                "TotalFare": 10153305
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
    <div class="tab-pane fade" id="resGetSch2" role="tabpanel">
            <pre class="code-toolbar">
                <code class="language-markup">
{
    "status": {
        "code": 400,
        "confirm": "failed",
        "message": [
            "Check your mandatory parameters. Should not blank"
        ]
    },
    "details": {
        "error_code": "001",
        "error_msg": "Check your mandatory parameters. Should not blank"
    }
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resGetSch3" role="tabpanel">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Keterangan</th>
            </tr>
            <tr>
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
                <th>error_code</th>
                <td>Kode error dari maskapai</td>
            </tr>
            <tr>
                <th>error_msg</th>
                <td>Pesan error dari maskapai</td>
            </tr>
            <tr>
                <th>Bersambung</th>
            </tr>
            </tbody>
        </table>
    </div>
</div>
