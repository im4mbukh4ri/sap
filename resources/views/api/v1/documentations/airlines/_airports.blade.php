<h5>Request</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#reqAirports1" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="##reqAirports2" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="reqAirports1" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>GET</td>
            </tr>
            <tr>
                <th>URL domestic</th>
                <td>{{ route('rest.airports_domestic') }}</td>
            </tr>
            <tr>
                <th>URL international</th>
                <td>{{ route('rest.airports_international') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="reqAirports2" role="tabpanel">
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
            <a class="nav-link waves-light active" data-toggle="tab" href="#resAirport1" role="tab">Repsonse Berhasil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resAirport2" role="tab">Response Gagal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resAirport3" role="tab">Penjelasan</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resAirport1" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px">
                <code class="language-markup">
[
  {
    "id": "ABU",
    "name": "HALIWEN",
    "city": "Atambua, Indonesia"
  },
  {
    "id": "AEG",
    "name": "AEK GODANG ",
    "city": "Tapanuli Selatan-Aek Godang, Indonesia"
  },
  {
    "id": "AMQ",
    "name": "PATTIMURA",
    "city": "Ambon, Indonesia"
  },
  {
    "id": "ARD",
    "name": "MALI",
    "city": "Alor Island, Indonesia"
  },
  {
    "id": "BDJ",
    "name": "SYAMSUDDIN NOOR",
    "city": "Banjarmasin, Indonesia"
  },
  {
    "id": "BDO",
    "name": "HUSEIN SASTRANEGARA",
    "city": "Bandung, Indonesia"
  },
  {
    "id": "BEJ",
    "name": "KALIMARAU",
    "city": "Berau, Indonesia"
  },
  {
    "id": "BIK",
    "name": "FRANS KAISIEPO",
    "city": "Biak, Indonesia"
  },
  {
    "id": "BJW",
    "name": "SOA",
    "city": "Bajawa, Indonesia"
  },
  {
    "id": "BKS",
    "name": "Fatmawati Soekarno",
    "city": "Bengkulu, Indonesia"
  },
  {
    "id": "BMU",
    "name": "Muhammad Salahuddin",
    "city": "Bima, Indonesia"
  },
  {
    "id": "BPN",
    "name": "Sepinggan",
    "city": "BalikPapan, Indonesia"
  },
  {
    "id": "BTH",
    "name": "Hang Nadim",
    "city": "Batam, Indonesia"
  },
  {
    "id": "BTJ",
    "name": "Sultan Iskandar Muda",
    "city": "Banda Aceh, Indonesia"
  },
  {
    "id": "BTK",
    "name": "Buntok",
    "city": "Buntok"
  },
  {
    "id": "BTW",
    "name": "BATU LICIN",
    "city": "Batu Licin, Indonesia"
  },
  {
    "id": "BUW",
    "name": "Baubau",
    "city": "Baubau, Indonesia"
  },
  {
    "id": "BWX",
    "name": "BLIMBINGSARI",
    "city": "Banyuwangi, Indonesia"
  },
  {
    "id": "CGK",
    "name": "SOEKARNO HATTA",
    "city": "Jakarta - Cengkareng, Indonesia"
  },
  {
    "id": "DEX",
    "name": "NOP GOLIAT ",
    "city": "DEKAI, Indonesia"
  },
  {
    "id": "DJB",
    "name": "Sultan Thaha Syaifuddin",
    "city": "Jambi, Indonesia"
  },
  {
    "id": "DJJ",
    "name": "Sentani",
    "city": "Jayapura, Indonesia"
  },
  {
    "id": "DOB",
    "name": "DOBO",
    "city": "Kepulauan Aru, Indonesia"
  },
  {
    "id": "DPM",
    "name": "Pagar Alam",
    "city": "Pagar Alam"
  },
  {
    "id": "DPS",
    "name": "NGURAH RAI",
    "city": "Denpasar, Bali, Indonesia"
  },
  {
    "id": "DQJ",
    "name": "Banyuwangi",
    "city": "Banyuwangi"
  },
  {
    "id": "DTB",
    "name": "Silangit",
    "city": "Silangit, Indonesia"
  },
  {
    "id": "DUM",
    "name": "PINANG KAMPAI ",
    "city": "Dumai, Riau, Indonesia"
  },
  {
    "id": "ENE",
    "name": "H. Hasan Aroeboesman",
    "city": "Ende, Indonesia"
  },
  {
    "id": "FKQ",
    "name": "Fakfak",
    "city": "FakFak, Indonesia"
  },
  {
    "id": "FLZ",
    "name": "SIBOLGA",
    "city": "Pinangsori, Indonesia"
  },
  {
    "id": "GLX",
    "name": "GAMARMALAMO",
    "city": "Halmahera Utara, Indonesia"
  },
  {
    "id": "GNS",
    "name": "Gunung Sitoli, Binaka",
    "city": "GunungSitoli, Indonesia"
  },
  {
    "id": "GTO",
    "name": "Jalaluddin",
    "city": "Gorontalo, Indonesia"
  },
  {
    "id": "HLP",
    "name": "HALIM PERDANAKUSUMA",
    "city": "Jakarta - Halim, Indonesia"
  },
  {
    "id": "JBB",
    "name": "NOTOHADINEGORO",
    "city": "Jember, Indonesia"
  },
  {
    "id": "JOG",
    "name": "Adi Sutjipto",
    "city": "Yogyakarta, Indonesia"
  },
  {
    "id": "KAZ",
    "name": "TOBELO",
    "city": "Tobelo, Indonesia"
  },
  {
    "id": "KBU",
    "name": "Kotabaru",
    "city": "Kotabaru, Indonesia"
  },
  {
    "id": "KDI",
    "name": "Haluoleo",
    "city": "Kendari, Indonesia"
  },
  {
    "id": "KLK",
    "name": "Kuala Kurun",
    "city": "Kuala Kurun"
  },
  {
    "id": "KLP",
    "name": "Kuala Pembuang",
    "city": "Kuala Pembuang"
  },
  {
    "id": "KNG",
    "name": "Kaimana, Utarom",
    "city": "Kaimana, Indonesia"
  },
  {
    "id": "KNO",
    "name": "KUALA NAMU",
    "city": "Medan - Kuala Namu, Indonesia"
  },
  {
    "id": "KOE",
    "name": "El Tari",
    "city": "Kupang, Indonesia"
  },
  {
    "id": "KTG",
    "name": "RAHADI OESMAN",
    "city": "Ketapang, Indonesia"
  },
  {
    "id": "LAH",
    "name": "LABUHA, OESMAN SADIK",
    "city": "Labuha, Indonesia"
  },
  {
    "id": "LBJ",
    "name": "Labuanbajo, Komodo",
    "city": "LabuanBajo, Indonesia"
  },
  {
    "id": "LKA",
    "name": "GEWAYANTANA",
    "city": "Flores Timur, Indonesia"
  },
  {
    "id": "LLG",
    "name": "SILAMPARI",
    "city": "Lubuklinggau , Indonesia"
  },
  {
    "id": "LLO",
    "name": "PALOPO LAGALIGO ",
    "city": "Palopo Lagaligo , Indonesia"
  },
  {
    "id": "LOP",
    "name": "Lombok",
    "city": "Lombok, Mataram, Indonesia"
  },
  {
    "id": "LSW",
    "name": "Lhokseumawe, Malikussaleh",
    "city": "Lhokseumawe, Indonesia"
  },
  {
    "id": "LUV",
    "name": "DUMATUBUN ",
    "city": "Tual, Indonesia"
  },
  {
    "id": "LUW",
    "name": "Syukuran Aminuddin Amir",
    "city": "Luwuk, Indonesia"
  },
  {
    "id": "LWE",
    "name": "Lewoleba",
    "city": "Lewoleba"
  },
  {
    "id": "MBE",
    "name": "MONBETSU ",
    "city": "MONBETSU , Indonesia"
  },
  {
    "id": "MDC",
    "name": "Sam Ratulangi",
    "city": "Manado, Indonesia"
  },
  {
    "id": "MEQ",
    "name": "Meulaboh, Cut Nyak Dien",
    "city": "Meulaboh, Indonesia"
  },
  {
    "id": "MES",
    "name": "Polonia",
    "city": "Medan"
  },
  {
    "id": "MJU",
    "name": "MAMUJU",
    "city": "Mamuju, Indonesia"
  },
  {
    "id": "MKQ",
    "name": "Mopah",
    "city": "Merauke, Indonesia"
  },
  {
    "id": "MKW",
    "name": "Rendani",
    "city": "Manokwari, Indonesia"
  },
  {
    "id": "MLG",
    "name": "Abdul Rachman Saleh",
    "city": "Malang, Indonesia"
  },
  {
    "id": "MLK",
    "name": "MELALAN",
    "city": "Kutai Barat, Indonesia"
  },
  {
    "id": "MLN",
    "name": "ROBERT ATTY BESSING",
    "city": "Malinau, Indonesia"
  },
  {
    "id": "MNA",
    "name": "MELANGUANE",
    "city": "North Sulawesi, Indonesia"
  },
  {
    "id": "MOF",
    "name": "WAI OTI",
    "city": "Maumere, Indonesia"
  },
  {
    "id": "MRB",
    "name": "MUARA BUNGO",
    "city": "Bungo, Indonesia"
  },
  {
    "id": "MSA",
    "name": "Mamasa",
    "city": "Mamasa"
  },
  {
    "id": "MTA",
    "name": "Manis Mata",
    "city": "Manis Mata"
  },
  {
    "id": "MTW",
    "name": "BERINGIN",
    "city": "Barito Utara, Indonesia"
  },
  {
    "id": "MWK",
    "name": "MATAK",
    "city": "Pal Matak, Kepulauan Riau, Indonesia"
  },
  {
    "id": "MXB",
    "name": "Masamba",
    "city": "Masamba"
  },
  {
    "id": "NAH",
    "name": "Naha",
    "city": "Tahuna, Indonesia"
  },
  {
    "id": "NBX",
    "name": "Nabire",
    "city": "Nabire, Indonesia"
  },
  {
    "id": "NNX",
    "name": "NUNUKAN",
    "city": "Nunukan, Indonesia"
  },
  {
    "id": "NPO",
    "name": "Nangapinoh",
    "city": "Nangapinoh"
  },
  {
    "id": "NTX",
    "name": "RANAI",
    "city": "Natuna, Indonesia"
  },
  {
    "id": "OBO",
    "name": "TOKACHI OBIHIRO ",
    "city": "Obihiro, Indonesia"
  },
  {
    "id": "OTI",
    "name": "MOROTAI",
    "city": "Pulau Morotai, Indonesia"
  },
  {
    "id": "PCU",
    "name": "Puruk Cahu",
    "city": "Puruk Cahu"
  },
  {
    "id": "PDG",
    "name": "MINANGKABAU",
    "city": "Padang, Indonesia"
  },
  {
    "id": "PGK",
    "name": "DEPATI AMIR",
    "city": "Pangkal pinang, Indonesia"
  },
  {
    "id": "PKN",
    "name": "PANGKALAN BUN",
    "city": "Kotawaringin Barat, Indonesia"
  },
  {
    "id": "PKU",
    "name": "Sultan Syarif Kasim II",
    "city": "Pekanbaru, Indonesia"
  },
  {
    "id": "PKY",
    "name": "TJILIK RIWUT",
    "city": "Palangka raya, Indonesia"
  },
  {
    "id": "PLM",
    "name": "Sultan Mahmud Badaruddin II",
    "city": "Palembang, Indonesia"
  },
  {
    "id": "PLW",
    "name": "Mutiara",
    "city": "Palu, Indonesia"
  },
  {
    "id": "PNK",
    "name": "SUPADIO",
    "city": "Pontianak, Indonesia"
  },
  {
    "id": "PSJ",
    "name": "Poso, Kasiguncu",
    "city": "Poso, Indonesia"
  },
  {
    "id": "PSU",
    "name": "PUTUSSIBAU",
    "city": "Kapuas Hulu, Indonesia"
  },
  {
    "id": "PUM",
    "name": "Sangia Nibandera Pomalaa",
    "city": "Pomalaa, Indonesia"
  },
  {
    "id": "RAQ",
    "name": "Raha",
    "city": "Raha"
  },
  {
    "id": "RJM",
    "name": "MARINDA",
    "city": "Raja Ampat, Indonesia"
  },
  {
    "id": "RPI",
    "name": "Rampi",
    "city": "Rampi"
  },
  {
    "id": "RTG",
    "name": "FRANS SALES LEGA",
    "city": "Ruteng, Indonesia"
  },
  {
    "id": "RTI",
    "name": "LEKUNIK",
    "city": "Rote Ndao, Indonesia"
  },
  {
    "id": "SBG",
    "name": "SABANG",
    "city": "Banda Aceh, Indonesia"
  },
  {
    "id": "SGQ",
    "name": "Sangata",
    "city": "Sangata"
  },
  {
    "id": "SIQ",
    "name": "Dabo",
    "city": "Singkep"
  },
  {
    "id": "SKO",
    "name": "Seko",
    "city": "Seko"
  },
  {
    "id": "SLY",
    "name": "Selayar",
    "city": "Selayar"
  },
  {
    "id": "SMG",
    "name": "SIMEULEU",
    "city": "SIMEULEU, Indonesia"
  },
  {
    "id": "SMQ",
    "name": "H. Asan Sampit",
    "city": "Sampit, Indonesia"
  },
  {
    "id": "SOC",
    "name": "Adisumarmo",
    "city": "Solo, Indonesia"
  },
  {
    "id": "SOQ",
    "name": "Dominique Edward Osok",
    "city": "Sorong, Indonesia"
  },
  {
    "id": "SQG",
    "name": "SUSILO",
    "city": "Sintang, Indonesia"
  },
  {
    "id": "SRG",
    "name": "Achmad Yani",
    "city": "Semarang, Indonesia"
  },
  {
    "id": "SRI",
    "name": "TEMINDUNG",
    "city": "Samarinda, Indonesia"
  },
  {
    "id": "SUB",
    "name": "Juanda",
    "city": "Surabaya, Indonesia"
  },
  {
    "id": "SWQ",
    "name": "SUMBAWA, BRANG BIJI",
    "city": "Sumbawa, Indonesia"
  },
  {
    "id": "SXK",
    "name": "OLILIT",
    "city": "Maluku Tenggara Barat, Indonesia"
  },
  {
    "id": "TIM",
    "name": "Mozes Kilangin",
    "city": "Timika, Indonesia"
  },
  {
    "id": "TJG",
    "name": "WARUKIN",
    "city": "Tabalong, Indonesia"
  },
  {
    "id": "TJQ",
    "name": "H.A.S HANANDJOEDDIN",
    "city": "Tanjung Pandan, Belitung, Indonesia"
  },
  {
    "id": "TJS",
    "name": "TANJUNG HARAPAN",
    "city": "Tanjung Selor, Indonesia"
  },
  {
    "id": "TKG",
    "name": "Radin Inten II",
    "city": "Lampung, Indonesia"
  },
  {
    "id": "TLI",
    "name": "TOLI TOLI",
    "city": "Toli-Toli, Indonesia"
  },
  {
    "id": "TMC",
    "name": "TAMPOLAKA",
    "city": "Tambolaka, Indonesia"
  },
  {
    "id": "TNJ",
    "name": "Raja Haji FIsabilillah",
    "city": "Tanjung Pinang, Indonesia"
  },
  {
    "id": "TRK",
    "name": "JUWATA",
    "city": "Tarakan, Indonesia"
  },
  {
    "id": "TSB",
    "name": "Tumbang Samba",
    "city": "Tumbang Samba"
  },
  {
    "id": "TTE",
    "name": "SULTAN BABULLAH",
    "city": "Ternate, Indonesia"
  },
  {
    "id": "TTR",
    "name": "Tana Toraja",
    "city": "Tana Toraja"
  },
  {
    "id": "TXE",
    "name": "TAKENGON REMBELE",
    "city": "Aceh, Indonesia"
  },
  {
    "id": "UOL",
    "name": "POGUGOL",
    "city": "Buol, Indonesia"
  },
  {
    "id": "UPG",
    "name": "SULTAN HASANUDDIN",
    "city": "Ujungpandang, Makassar, Indonesia"
  },
  {
    "id": "VPM",
    "name": "TANJUNG API",
    "city": "Ampana, Indonesia"
  },
  {
    "id": "WGI",
    "name": "WANGI WANGI, MATAHORA",
    "city": "Wangi wangi, Indonesia"
  },
  {
    "id": "WGP",
    "name": "WAINGAPU",
    "city": "Waingapu, Indonesia"
  },
  {
    "id": "WKB",
    "name": "Wakatobi",
    "city": "Wakatobi"
  },
  {
    "id": "WMX",
    "name": "WAMENA",
    "city": "Jayawijaya, Indonesia"
  },
  {
    "id": "WNI",
    "name": "MATAHORA",
    "city": "Wakatobi, Indonesia"
  },
  {
    "id": "WUB",
    "name": "BULI",
    "city": "Buli, Indonesia"
  },
  {
    "id": "YKR",
    "name": "SELAYAR",
    "city": "Selayar, Indonesia"
  }
]
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resAirport2" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px;">
                <code class="language-markup">

                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resAirport3" role="tabpanel">

    </div>
</div>
