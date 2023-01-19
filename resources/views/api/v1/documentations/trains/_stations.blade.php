<h5>Request</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#reqStations1" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#reqStations2" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="reqStations1" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>GET</td>
            </tr>
            <tr>
                <th>URL</th>
                <td>{{ route("rest.train_stations")}}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="reqStations2" role="tabpanel">
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
            <a class="nav-link waves-light active" data-toggle="tab" href="#resStations1" role="tab">Repsonse Berhasil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resStations2" role="tab">Response Gagal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resStations3" role="tab">Penjelasan</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resStations1" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px">
                <code class="language-markup">
[
  {
    "code": "AKB",
    "name": "Aekloba",
    "city": "Medan"
  },
  {
    "code": "AW",
    "name": "Awipari",
    "city": "Tasikmalaya"
  },
  {
    "code": "AWN",
    "name": "Arjawinangun",
    "city": "Cirebon"
  },
  {
    "code": "BAP",
    "name": "Bandarkalipah",
    "city": "Medan"
  },
  {
    "code": "BAT",
    "name": "Barat",
    "city": "Magetan"
  },
  {
    "code": "BB",
    "name": "Brebes",
    "city": "Brebes"
  },
  {
    "code": "BBD",
    "name": "Babadan",
    "city": "Ponorogo"
  },
  {
    "code": "BBG",
    "name": "Brumbung",
    "city": "Demak"
  },
  {
    "code": "BBK",
    "name": "Babakan",
    "city": "Cirebon"
  },
  {
    "code": "BBN",
    "name": "Brambanan",
    "city": "Yogyakarta"
  },
  {
    "code": "BBT",
    "name": "Babat",
    "city": "Lamongan"
  },
  {
    "code": "BBU",
    "name": "Blambanganumpu",
    "city": "Lampung"
  },
  {
    "code": "BD",
    "name": "Bandung",
    "city": "Bandung"
  },
  {
    "code": "BDT",
    "name": "Bandartinggi",
    "city": "Medan"
  },
  {
    "code": "BDW",
    "name": "Bangoduwa",
    "city": "Jatibarang"
  },
  {
    "code": "BG",
    "name": "Bangil",
    "city": "Pasuruan"
  },
  {
    "code": "BGM",
    "name": "Bungamas",
    "city": "Lahat"
  },
  {
    "code": "BGR",
    "name": "Bagor",
    "city": "Nganjuk"
  },
  {
    "code": "BIB",
    "name": "Blimbingpendopo",
    "city": "Prabumulih"
  },
  {
    "code": "BIJ",
    "name": "Binjai",
    "city": "Binjai"
  },
  {
    "code": "BJ",
    "name": "Bojonegoro",
    "city": "Bojonegoro"
  },
  {
    "code": "BJG",
    "name": "Bojong",
    "city": "Pekalongan"
  },
  {
    "code": "BJI",
    "name": "Banjarsari",
    "city": "Ciamis"
  },
  {
    "code": "BJL",
    "name": "Bajalinggei",
    "city": "Medan"
  },
  {
    "code": "BJR",
    "name": "Banjar",
    "city": "Banjar"
  },
  {
    "code": "BKA",
    "name": "Bulakamba",
    "city": "Brebes"
  },
  {
    "code": "BKI",
    "name": "Bekri",
    "city": "Lampung"
  },
  {
    "code": "BKS",
    "name": "Bekasi",
    "city": "Bekasi"
  },
  {
    "code": "BL",
    "name": "Blitar",
    "city": "Blitar"
  },
  {
    "code": "BMA",
    "name": "Bumiayu",
    "city": "Brebes"
  },
  {
    "code": "BMG",
    "name": "Blimbing",
    "city": "Malang"
  },
  {
    "code": "BOO",
    "name": "Bogor",
    "city": "Bogor"
  },
  {
    "code": "BRN",
    "name": "Baron",
    "city": "Nganjuk"
  },
  {
    "code": "BTA",
    "name": "Baturaja",
    "city": "Baturaja"
  },
  {
    "code": "BTG",
    "name": "Batang",
    "city": "Batang"
  },
  {
    "code": "BTK",
    "name": "Batangkuis",
    "city": "Medan"
  },
  {
    "code": "BTT",
    "name": "Batu Tulis",
    "city": "Bogor"
  },
  {
    "code": "BW",
    "name": "Banyuwangibaru",
    "city": "Banyuwangi"
  },
  {
    "code": "CAW",
    "name": "Ciawi",
    "city": "Tasikmalaya"
  },
  {
    "code": "CB",
    "name": "Cibatu",
    "city": "Garut"
  },
  {
    "code": "CBB",
    "name": "Cibeber",
    "city": "Cianjur"
  },
  {
    "code": "CBD",
    "name": "Cibadak",
    "city": "Sukabumi"
  },
  {
    "code": "CCL",
    "name": "Cicalengka",
    "city": "Bandung"
  },
  {
    "code": "CCR",
    "name": "Cicurug",
    "city": "Sukabumi"
  },
  {
    "code": "CD",
    "name": "Cikadongdong",
    "city": "Bandung"
  },
  {
    "code": "CGB",
    "name": "Cigombong",
    "city": "Bogor"
  },
  {
    "code": "CI",
    "name": "Ciamis",
    "city": "Ciamis"
  },
  {
    "code": "CJ",
    "name": "Cianjur",
    "city": "Cianjur"
  },
  {
    "code": "CKP",
    "name": "Cikampek",
    "city": "Cikampek"
  },
  {
    "code": "CLD",
    "name": "Ciledug",
    "city": "Cirebon"
  },
  {
    "code": "CLG",
    "name": "Cilegon",
    "city": "Cilegon"
  },
  {
    "code": "CLH",
    "name": "Cilegeh",
    "city": "Indramayu"
  },
  {
    "code": "CLK",
    "name": "Cilaku",
    "city": "Cianjur"
  },
  {
    "code": "CMI",
    "name": "Cimahi",
    "city": "Bandung"
  },
  {
    "code": "CN",
    "name": "Cirebon",
    "city": "Cirebon"
  },
  {
    "code": "CNP",
    "name": "CirebonPrujakan",
    "city": "Cirebon"
  },
  {
    "code": "CO",
    "name": "Comal",
    "city": "Pemalang"
  },
  {
    "code": "CP",
    "name": "Cilacap",
    "city": "Cilacap"
  },
  {
    "code": "CPD",
    "name": "Cipeundeuy",
    "city": "Garut"
  },
  {
    "code": "CPI",
    "name": "Cipari",
    "city": "Cilacap"
  },
  {
    "code": "CRA",
    "name": "Cipunegara",
    "city": "Subang"
  },
  {
    "code": "CRB",
    "name": "Caruban",
    "city": "Madiun"
  },
  {
    "code": "CRG",
    "name": "Cireungas",
    "city": "Sukabumi"
  },
  {
    "code": "CSA",
    "name": "Cisaat",
    "city": "Sukabumi"
  },
  {
    "code": "CU",
    "name": "Cepu",
    "city": "Blora"
  },
  {
    "code": "DEN",
    "name": "Denpasar",
    "city": "Denpasar"
  },
  {
    "code": "DMR",
    "name": "Dolokmerangir",
    "city": "Medan"
  },
  {
    "code": "DPL",
    "name": "Doplang",
    "city": "Blora"
  },
  {
    "code": "GB",
    "name": "Gombong",
    "city": "Gombong"
  },
  {
    "code": "GD",
    "name": "Gundih",
    "city": "Grobongan"
  },
  {
    "code": "GDB",
    "name": "Gedebage",
    "city": "Bandung"
  },
  {
    "code": "GDG",
    "name": "Gedangan",
    "city": "Sidoarjo"
  },
  {
    "code": "GDM",
    "name": "Gandrungmangun",
    "city": "Cilacap"
  },
  {
    "code": "GDS",
    "name": "Gandasoli",
    "city": "Sukabumi"
  },
  {
    "code": "GG",
    "name": "Geneng",
    "city": "Ngawi"
  },
  {
    "code": "GHM",
    "name": "Giham",
    "city": "Lampung"
  },
  {
    "code": "GI",
    "name": "Grati",
    "city": "Pasuruan"
  },
  {
    "code": "GLM",
    "name": "Glenmore",
    "city": "Banyuwangi"
  },
  {
    "code": "GM",
    "name": "Gumilir",
    "city": "Cilacap"
  },
  {
    "code": "GMR",
    "name": "Gambir",
    "city": "Jakarta"
  },
  {
    "code": "GNM",
    "name": "Gunungmegang",
    "city": "Prabumulih"
  },
  {
    "code": "GRM",
    "name": "Garum",
    "city": "Blitar"
  },
  {
    "code": "HGL",
    "name": "Haurgeulis",
    "city": "Indramayu"
  },
  {
    "code": "HL",
    "name": "Hengelo",
    "city": "Medan"
  },
  {
    "code": "HRP",
    "name": "Haurpugur",
    "city": "Bandung"
  },
  {
    "code": "IJ",
    "name": "Ijo",
    "city": "Gombong"
  },
  {
    "code": "JAK",
    "name": "Jakarta Kota",
    "city": "Jakarta"
  },
  {
    "code": "JG",
    "name": "Jombang",
    "city": "Jombang"
  },
  {
    "code": "JN",
    "name": "Jenar",
    "city": "Purworejo"
  },
  {
    "code": "JNG",
    "name": "Jatinegara",
    "city": "Jakarta"
  },
  {
    "code": "JR",
    "name": "Jember",
    "city": "Jember"
  },
  {
    "code": "JRL",
    "name": "Jeruklegi",
    "city": "Cilacap"
  },
  {
    "code": "JTB",
    "name": "Jatibarang",
    "city": "Indramayu"
  },
  {
    "code": "JTR",
    "name": "Jatiroto",
    "city": "Jember"
  },
  {
    "code": "KA",
    "name": "Karanganyar",
    "city": "Kebumen"
  },
  {
    "code": "KAB",
    "name": "Kadokangangabus",
    "city": "Indramayu"
  },
  {
    "code": "KAC",
    "name": "Kiaracondong",
    "city": "Bandung"
  },
  {
    "code": "KB",
    "name": "Kotabumi",
    "city": "Lampung"
  },
  {
    "code": "KBD",
    "name": "Kalibodri",
    "city": "Kendal"
  },
  {
    "code": "KBR",
    "name": "Kalibaru",
    "city": "Banyuwangi"
  },
  {
    "code": "KBS",
    "name": "Kebasen",
    "city": "Banyumas"
  },
  {
    "code": "KD",
    "name": "Kediri",
    "city": "Kediri"
  },
  {
    "code": "KDB",
    "name": "Kedungbanteng",
    "city": "Sragen"
  },
  {
    "code": "KE",
    "name": "Karang Tengah",
    "city": "Sukabumi"
  },
  {
    "code": "KEJ",
    "name": "Kedungjati",
    "city": "Grobongan"
  },
  {
    "code": "KG",
    "name": "Kedunggalar",
    "city": "Ngawi"
  },
  {
    "code": "KGB",
    "name": "Ketanggungan Baru",
    "city": "Brebes"
  },
  {
    "code": "KGG",
    "name": "Ketanggungan",
    "city": "Brebes"
  },
  {
    "code": "KGT",
    "name": "Karangjati",
    "city": "Grobongan"
  },
  {
    "code": "KIS",
    "name": "Kisaran",
    "city": "Kisaran"
  },
  {
    "code": "KIT",
    "name": "Kalitidu",
    "city": "Bojonegoro"
  },
  {
    "code": "KJ",
    "name": "Kemranjen",
    "city": "Banyumas"
  },
  {
    "code": "KK",
    "name": "Klakah",
    "city": "Lumajang"
  },
  {
    "code": "KLN",
    "name": "Kaliwungu",
    "city": "Kendal"
  },
  {
    "code": "KLT",
    "name": "Kalisat",
    "city": "Jember"
  },
  {
    "code": "KM",
    "name": "Kebumen",
    "city": "Kebumen"
  },
  {
    "code": "KNE",
    "name": "Karangasem",
    "city": "Banyuwangi"
  },
  {
    "code": "KNS",
    "name": "Krengseng",
    "city": "Pekalongan"
  },
  {
    "code": "KOP",
    "name": "Kotapadang",
    "city": "Lubuk Linggau"
  },
  {
    "code": "KPN",
    "name": "Kepanjen",
    "city": "Malang"
  },
  {
    "code": "KPT",
    "name": "Kertapati",
    "city": "Pelembang"
  },
  {
    "code": "KRN",
    "name": "Krian",
    "city": "Sidoarjo"
  },
  {
    "code": "KRO",
    "name": "Kebonromo",
    "city": "Sragen"
  },
  {
    "code": "KRR",
    "name": "Karangsari",
    "city": "Banyumas"
  },
  {
    "code": "KRT",
    "name": "Kretek",
    "city": "Brebes"
  },
  {
    "code": "KRW",
    "name": "Karangsuwung",
    "city": "Cirebon"
  },
  {
    "code": "KSB",
    "name": "Kesamben",
    "city": "Blitar"
  },
  {
    "code": "KSL",
    "name": "Kalisetail",
    "city": "Banyuwangi"
  },
  {
    "code": "KT",
    "name": "Klaten",
    "city": "Klaten"
  },
  {
    "code": "KTA",
    "name": "Kutoarjo",
    "city": "Kutoarjo"
  },
  {
    "code": "KTM",
    "name": "Kertasemaya",
    "city": "Indramayu"
  },
  {
    "code": "KTS",
    "name": "Kertosono",
    "city": "Nganjuk"
  },
  {
    "code": "KWG",
    "name": "Kawunganten",
    "city": "Cilacap"
  },
  {
    "code": "KWN",
    "name": "Kutowinangun",
    "city": "Kebumen"
  },
  {
    "code": "KYA",
    "name": "Kroya",
    "city": "Cilacap"
  },
  {
    "code": "LBG",
    "name": "Lebeng",
    "city": "Cilacap"
  },
  {
    "code": "LBJ",
    "name": "Lebakjero",
    "city": "Garut"
  },
  {
    "code": "LBP",
    "name": "Lubukpakam",
    "city": "Deli Serdang"
  },
  {
    "code": "LG",
    "name": "Linggapura",
    "city": "Brebes"
  },
  {
    "code": "LL",
    "name": "Leles",
    "city": "Garut"
  },
  {
    "code": "LLG",
    "name": "Lubuk Linggau",
    "city": "Lubuk Linggau"
  },
  {
    "code": "LMG",
    "name": "Lamongan",
    "city": "Lamongan"
  },
  {
    "code": "LMP",
    "name": "Limapuluh",
    "city": "Medan"
  },
  {
    "code": "LN",
    "name": "Langen",
    "city": "Banjar"
  },
  {
    "code": "LOS",
    "name": "Losari",
    "city": "Cirebon"
  },
  {
    "code": "LP",
    "name": "Lampegan",
    "city": "Cianjur"
  },
  {
    "code": "LPN",
    "name": "Lempuyangan",
    "city": "Yogyakarta"
  },
  {
    "code": "LR",
    "name": "Larangan",
    "city": "Brebes"
  },
  {
    "code": "LRA",
    "name": "Larangan",
    "city": "Brebes"
  },
  {
    "code": "LT",
    "name": "Lahat",
    "city": "Lahat"
  },
  {
    "code": "LW",
    "name": "Lawang",
    "city": "Malang"
  },
  {
    "code": "LWG",
    "name": "Luwung",
    "city": "Cirebon"
  },
  {
    "code": "MA",
    "name": "Maos",
    "city": "Cilacap"
  },
  {
    "code": "MBM",
    "name": "Membangmuda",
    "city": "Medan"
  },
  {
    "code": "MBU",
    "name": "Merbau",
    "city": "Rantau Prapat"
  },
  {
    "code": "MDN",
    "name": "Medan",
    "city": "Medan"
  },
  {
    "code": "ME",
    "name": "Muara Enim",
    "city": "Muara Enim"
  },
  {
    "code": "MER",
    "name": "Merak",
    "city": "Cilegon"
  },
  {
    "code": "ML",
    "name": "Malang",
    "city": "Malang"
  },
  {
    "code": "MLK",
    "name": "Malang Kota Lama",
    "city": "Malang"
  },
  {
    "code": "MLW",
    "name": "Meluwung",
    "city": "Cilacap"
  },
  {
    "code": "MN",
    "name": "Madiun",
    "city": "Madiun"
  },
  {
    "code": "MNJ",
    "name": "Manonjaya",
    "city": "Tasikmalaya"
  },
  {
    "code": "MP",
    "name": "Martapura",
    "city": "Kotabumi"
  },
  {
    "code": "MR",
    "name": "Mojokerto",
    "city": "Mojokerto"
  },
  {
    "code": "MRI",
    "name": "Manggarai",
    "city": "Jakarta"
  },
  {
    "code": "MSG",
    "name": "Maseng",
    "city": "Bogor"
  },
  {
    "code": "MSL",
    "name": "Muarasaling",
    "city": "Lubuk Linggau"
  },
  {
    "code": "MSR",
    "name": "Masaran",
    "city": "Sragen"
  },
  {
    "code": "NBO",
    "name": "Ngrombo",
    "city": "Grobongan"
  },
  {
    "code": "NG",
    "name": "Nagrek",
    "city": "Garut"
  },
  {
    "code": "NJ",
    "name": "Nganjuk",
    "city": "Nganjuk"
  },
  {
    "code": "NT",
    "name": "Ngunut",
    "city": "Tulungagung"
  },
  {
    "code": "NTG",
    "name": "Notog",
    "city": "Banyumas"
  },
  {
    "code": "PA",
    "name": "Paron",
    "city": "Madiun"
  },
  {
    "code": "PAT",
    "name": "Patuguran",
    "city": "Brebes"
  },
  {
    "code": "PB",
    "name": "Probolinggo",
    "city": "Probolinggo"
  },
  {
    "code": "PBA",
    "name": "Perbaungan",
    "city": "Medan"
  },
  {
    "code": "PBM",
    "name": "Prabumulih",
    "city": "Prabumulih"
  },
  {
    "code": "PDL",
    "name": "Padalarang",
    "city": "Bandung"
  },
  {
    "code": "PGB",
    "name": "Pegadenbaru",
    "city": "Subang"
  },
  {
    "code": "PHA",
    "name": "Padanghalaban",
    "city": "Medan"
  },
  {
    "code": "PK",
    "name": "Pekalongan",
    "city": "Pekalongan"
  },
  {
    "code": "PLB",
    "name": "Plabuan",
    "city": "Pekalongan"
  },
  {
    "code": "PLD",
    "name": "Plered",
    "city": "Purwakarta"
  },
  {
    "code": "PME",
    "name": "Pamingke",
    "city": "Medan"
  },
  {
    "code": "PML",
    "name": "Pemalang",
    "city": "Pemalang"
  },
  {
    "code": "PNW",
    "name": "Paninjawan",
    "city": "Baturaja"
  },
  {
    "code": "PPK",
    "name": "Prupuk",
    "city": "Tegal"
  },
  {
    "code": "PPR",
    "name": "Papar",
    "city": "Kediri"
  },
  {
    "code": "PRA",
    "name": "Perlanaan",
    "city": "Medan"
  },
  {
    "code": "PRB",
    "name": "Prembun",
    "city": "Kebumen"
  },
  {
    "code": "PRK",
    "name": "Parungkuda",
    "city": "Sukabumi"
  },
  {
    "code": "PS",
    "name": "Pasuruan",
    "city": "Pasuruan"
  },
  {
    "code": "PSE",
    "name": "Pasar Senen",
    "city": "Jakarta"
  },
  {
    "code": "PTA",
    "name": "Petarukan",
    "city": "Pemalang"
  },
  {
    "code": "PUR",
    "name": "Puluraja",
    "city": "Medan"
  },
  {
    "code": "PWK",
    "name": "Purwakarta",
    "city": "Purwakarta"
  },
  {
    "code": "PWS",
    "name": "Purwosari",
    "city": "Solo"
  },
  {
    "code": "PWT",
    "name": "Purwokerto",
    "city": "Purwokerto"
  },
  {
    "code": "RAP",
    "name": "Rantau Prapat",
    "city": "Rantau Prapat"
  },
  {
    "code": "RBG",
    "name": "Randublatung",
    "city": "Blora"
  },
  {
    "code": "RBP",
    "name": "Rambipuji",
    "city": "Jember"
  },
  {
    "code": "RCK",
    "name": "Rancaekek",
    "city": "Bandung"
  },
  {
    "code": "RGP",
    "name": "Rogojampi",
    "city": "Banyuwangi"
  },
  {
    "code": "RH",
    "name": "Rendeh",
    "city": "Bandung"
  },
  {
    "code": "RJP",
    "name": "Rajapolah",
    "city": "Tasikmalaya"
  },
  {
    "code": "RPH",
    "name": "Rampah",
    "city": "Serdang Bedagai"
  },
  {
    "code": "SBI",
    "name": "Surabaya Pasar Turi",
    "city": "Surabaya"
  },
  {
    "code": "SBJ",
    "name": "Sei Bejangkar",
    "city": "Medan"
  },
  {
    "code": "SBP",
    "name": "Sumberpucung",
    "city": "Malang"
  },
  {
    "code": "SDA",
    "name": "Sidoarjo",
    "city": "Sidoarjo"
  },
  {
    "code": "SDR",
    "name": "Sidareja",
    "city": "Cilacap"
  },
  {
    "code": "SDU",
    "name": "Sindanglaut",
    "city": "Cirebon"
  },
  {
    "code": "SG",
    "name": "Serang",
    "city": "Serang"
  },
  {
    "code": "SGG",
    "name": "Songgom",
    "city": "Brebes"
  },
  {
    "code": "SGU",
    "name": "Surabaya, Gubeng",
    "city": "Surabaya"
  },
  {
    "code": "SI",
    "name": "Sukabumi",
    "city": "Sukabumi"
  },
  {
    "code": "SIR",
    "name": "Siantar",
    "city": "Pematang Siantar"
  },
  {
    "code": "SK",
    "name": "Solojebres",
    "city": "Solo"
  },
  {
    "code": "SKP",
    "name": "Sikampuh",
    "city": "Cilacap"
  },
  {
    "code": "SLO",
    "name": "Solobalapan",
    "city": "Solo"
  },
  {
    "code": "SLW",
    "name": "Slawi",
    "city": "Tegal"
  },
  {
    "code": "SMB",
    "name": "Sembung",
    "city": "Jombang"
  },
  {
    "code": "SMC",
    "name": "Semarangponcol",
    "city": "Semarang"
  },
  {
    "code": "SMT",
    "name": "Semarangtawang",
    "city": "Semarang"
  },
  {
    "code": "SNA",
    "name": "Saungnaga",
    "city": "Lahat"
  },
  {
    "code": "SPH",
    "name": "Sumpiuh",
    "city": "Banyumas"
  },
  {
    "code": "SPJ",
    "name": "Sepanjang",
    "city": "Sidoarjo"
  },
  {
    "code": "SR",
    "name": "Sragen",
    "city": "Sragen"
  },
  {
    "code": "SRD",
    "name": "Saradan",
    "city": "Madiun"
  },
  {
    "code": "SRI",
    "name": "Sragi",
    "city": "Pekalongan"
  },
  {
    "code": "SRJ",
    "name": "Sumberrejo",
    "city": "Bojonegoro"
  },
  {
    "code": "SRW",
    "name": "Sruweng",
    "city": "Kebumen"
  },
  {
    "code": "STL",
    "name": "Sentolo",
    "city": "Yogyakarta"
  },
  {
    "code": "SWD",
    "name": "Sumberwadung",
    "city": "Banyuwangi"
  },
  {
    "code": "SWT",
    "name": "Srowot",
    "city": "Klaten"
  },
  {
    "code": "TA",
    "name": "Tulungagung",
    "city": "Tulungagung"
  },
  {
    "code": "TAL",
    "name": "Talun",
    "city": "Blitar"
  },
  {
    "code": "TBI",
    "name": "Tebing Tinggi",
    "city": "Medan"
  },
  {
    "code": "TBK",
    "name": "Tambak",
    "city": "Banyumas"
  },
  {
    "code": "TG",
    "name": "Tegal",
    "city": "Tegal"
  },
  {
    "code": "TGL",
    "name": "Tanggul",
    "city": "Jember"
  },
  {
    "code": "TGN",
    "name": "Tanjung",
    "city": "Brebes"
  },
  {
    "code": "TGR",
    "name": "Temuguruh",
    "city": "Banyuwangi"
  },
  {
    "code": "THB",
    "name": "Tanah Abang",
    "city": "Jakarta"
  },
  {
    "code": "TI",
    "name": "Tebingtinggi",
    "city": "Lahat"
  },
  {
    "code": "TIS",
    "name": "Terisi",
    "city": "Indramayu"
  },
  {
    "code": "TJS",
    "name": "Tanjungrasa",
    "city": "Subang"
  },
  {
    "code": "TLY",
    "name": "Tulungbuyut",
    "city": "Lampung"
  },
  {
    "code": "TNB",
    "name": "Tanjungbalai",
    "city": "Tanjung Balai"
  },
  {
    "code": "TNG",
    "name": "Tangerang",
    "city": "Tangerang"
  },
  {
    "code": "TNK",
    "name": "Tanjungkarang",
    "city": "Lampung"
  },
  {
    "code": "TPK",
    "name": "Tanjung Priuk",
    "city": "Jakarta"
  },
  {
    "code": "TSM",
    "name": "Tasikmalaya",
    "city": "Tasikmalaya"
  },
  {
    "code": "TW",
    "name": "Telawa",
    "city": "Boyolali"
  },
  {
    "code": "UJM",
    "name": "Ujanmas",
    "city": "Muara Enim"
  },
  {
    "code": "UJN",
    "name": "Ujungnegoro",
    "city": "Batang"
  },
  {
    "code": "WB",
    "name": "Warung Bandrek",
    "city": "Garut"
  },
  {
    "code": "WDW",
    "name": "Waruduwur",
    "city": "Cirebon"
  },
  {
    "code": "WG",
    "name": "Wlingin",
    "city": "Blitar"
  },
  {
    "code": "WIL",
    "name": "Wilangan",
    "city": "Nganjuk"
  },
  {
    "code": "WK",
    "name": "Walikukun",
    "city": "Ngawi"
  },
  {
    "code": "WLR",
    "name": "Weleri",
    "city": "Kendal"
  },
  {
    "code": "WNS",
    "name": "Wonosari",
    "city": "Kebumen"
  },
  {
    "code": "WO",
    "name": "Wonokromo",
    "city": "Surabaya"
  },
  {
    "code": "WT",
    "name": "Wates",
    "city": "Yogyakarta"
  },
  {
    "code": "YK",
    "name": "Yogyakarta",
    "city": "Yogyakarta"
  }
]
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resStations2" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px;">
                <code class="language-markup">

                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resStations3" role="tabpanel">

    </div>
</div>
