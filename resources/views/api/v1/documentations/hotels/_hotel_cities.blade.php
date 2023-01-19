<h5>Request</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#reqHotelCity1" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#reqHotelCity2" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="reqHotelCity1" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>GET</td>
            </tr>
            <tr>
                <th>URL</th>
                <td>{{ route("rest.hotels_cities")}}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="reqHotelCity2" role="tabpanel">
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
                <th colspan="3">Tidak ada parameter</th>
            </tr>
            </tbody>
        </table>
    </div>
</div><h5>Response</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#resHotel1" role="tab">Repsonse Berhasil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resHotel2" role="tab">Response Gagal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resHotel3" role="tab">Penjelasan</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resHotel1" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px">
                <code class="language-markup">
[
    {
        "id": "WSASHKCCI",
        "city": "Cheung Chau Island",
        "international": 1,
        "country": "Hong Kong"
    },
    {
        "id": "WSASHKHKG",
        "city": "Hong Kong City",
        "international": 1,
        "country": "Hong Kong"
    },
    {
        "id": "WSASHKKLN",
        "city": "Kowloon",
        "international": 1,
        "country": "Hong Kong"
    },
    {
        "id": "WSASHKLTD",
        "city": "Lantau Island",
        "international": 1,
        "country": "Hong Kong"
    },
    {
        "id": "WSASHKNTS",
        "city": "New Territories",
        "international": 1,
        "country": "Hong Kong"
    },
    {
        "id": "WSASIDABA",
        "city": "Ambarawa",
        "international": 0,
        "country": "Indonesia"
    },
    {
        "id": "WSASIDAEG",
        "city": "Padang Sidempuan",
        "international": 0,
        "country": "Indonesia"
    },
    {
        "id": "WSASIDAMQ",
        "city": "Ambon",
        "international": 0,
        "country": "Indonesia"
    },
    {
        "id": "WSASIDAYR",
        "city": "Anyer",
        "international": 0,
        "country": "Indonesia"
    },
    {
        "id": "WSASIDBDJ",
        "city": "Banjarmasin",
        "international": 0,
        "country": "Indonesia"
    },
    {
        "id": "WSASIDBDO",
        "city": "Bandung",
        "international": 0,
        "country": "Indonesia"
    },
    {
        "id": "WSASIDBDS",
        "city": "Bondowoso",
        "international": 0,
        "country": "Indonesia"
    },
    {
        "id": "WSASIDBEJ",
        "city": "Berau",
        "international": 0,
        "country": "Indonesia"
    },
    {
        "id": "WSASIDBGR",
        "city": "Bogor",
        "international": 0,
        "country": "Indonesia"
    },
    {
        "id": "WSASIDBIK",
        "city": "Biak",
        "international": 0,
        "country": "Indonesia"
    }
]
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resHotel2" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px;">
                <code class="language-markup">

                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resHotel3" role="tabpanel">

    </div>
</div>
