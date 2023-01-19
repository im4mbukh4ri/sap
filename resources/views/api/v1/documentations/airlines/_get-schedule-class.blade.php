<h5>Request</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#reqAirClass1" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#reqAirClass2" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="reqAirClass1" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>POST</td>
            </tr>
            <tr>
                <th>URL</th>
                <td>{{ route('api.airlines_get_class') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="reqAirClass2" role="tabpanel">
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
                <td>YA</td>
                <td>Kode maskapai keberangkatan</td>
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
                <th>selectedIDdep</th>
                <td>YA</td>
                <td>selected ID departure</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#resAirClass1" role="tab">RESPONSE BERHASIL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resAirClass2" role="tab">RESPONSE GAGAL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resAirClass3" role="tab">PENJELASAN</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resAirClass1" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px">
                <code class="language-markup">
{
    "status": {
        "code": 200,
        "confirm": "success",
        "message": [
            "Success get schedule class."
        ]
    },
    "details": {
        "error_code": "000",
        "error_msg": "",
        "mmid": "mastersip",
        "ac": "GA",
        "org": "CGK",
        "des": "SUB",
        "flight": "O",
        "tgl_dep": "2017-01-10",
        "tgl_ret": "",
        "adt": "1",
        "chd": "0",
        "inf": "0",
        "schedule": {
            "departure": [
                {
                    "Flights": [
                        {
                            "FlightNo": "GA318",
                            "Transit": "0",
                            "STD": "CGK",
                            "STA": "SUB",
                            "ETD": "2017-01-10 15:10",
                            "ETA": "2017-01-10 16:45"
                        }
                    ],
                    "Fares": [
                        [
                            {
                                "SubClass": "H",
                                "SeatAvb": "9",
                                "TotalFare": "817000",
                                "selectedIDdep": "463695"
                            },
                            {
                                "SubClass": "S",
                                "SeatAvb": "9",
                                "TotalFare": "927000",
                                "selectedIDdep": "463696"
                            },
                            {
                                "SubClass": "V",
                                "SeatAvb": "9",
                                "TotalFare": "1037000",
                                "selectedIDdep": "463697"
                            },
                            {
                                "SubClass": "Y",
                                "SeatAvb": "9",
                                "TotalFare": "1644200",
                                "selectedIDdep": "463698"
                            },
                            {
                                "SubClass": "D",
                                "SeatAvb": "9",
                                "TotalFare": "2777600",
                                "selectedIDdep": "463699"
                            },
                            {
                                "SubClass": "C",
                                "SeatAvb": "9",
                                "TotalFare": "3207300",
                                "selectedIDdep": "463700"
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
    <div class="tab-pane fade" id="resAirClass2" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px">
                <code class="language-markup">
---------------------------------------- ERROR PARAMETER ------------------------------------------
{
    "status": {
        "code": 400,
        "confirm": "failed",
        "message": [
            "Unknown airline code."
        ]
    },
    "details": {
        "error_code": "001",
        "error_msg": "Unknown airline code."
    }
}
------------------------------------------ ERROR TOKEN --------------------------------------------
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
    <div class="tab-pane fade" id="resAirClass3" role="tabpanel">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Keterangan</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
