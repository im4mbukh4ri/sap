<h5>Request</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#reqDepHistory1" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#reqDepHistory2" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="reqDepHistory1" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>POST</td>
            </tr>
            <tr>
                <th>URL</th>
                <td>{{ route('api.deposits_histories') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="reqDepHistory2" role="tabpanel">
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
                <th>clinet_id</th>
                <td>YA</td>
                <td>clinet id</td>
            </tr>
            <tr>
                <th>start_date</th>
                <td>YA</td>
                <td>Format (yyyy-mm-dd)</td>
            </tr>
            <tr>
                <th>end_date</th>
                <td>YA</td>
                <td>Format (yyyy-mm-dd)</td>
            </tr>
            </tbody>
        </table>
        <sup>*</sup><span style="color:red;">Maksimal 31 hari</span>
    </div>
</div>
<h5>Response</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#resDepHistory1" role="tab">Repsonse Berhasil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resDepHistory2" role="tab">Response Gagal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resDepHistory3" role="tab">Penjelasan</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resDepHistory1" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px">
                <code class="language-markup">
{
  "status": {
    "code": 200,
    "confirm": "success",
    "message": null
  },
  "details": {
    "deposit_histories": [
      {
        "id": 172,
        "deposit": 76466230,
        "debit": 21078,
        "credit": 0,
        "note": "ppob|15311148|Payment Voucher PLN 20.000 - 32115074109",
        "created_at": "2017-01-25 09:25:48",
        "updated_at": "2017-01-25 09:25:48"
      },
      {
        "id": 174,
        "deposit": 76445152,
        "debit": 0,
        "credit": 522,
        "note": "ppob|15311262|Kredit komisi referal ( member_free )Voucher PLN 20.000 - 32115074109",
        "created_at": "2017-01-25 09:27:43",
        "updated_at": "2017-01-25 09:27:43"
      },
      {
        "id": 175,
        "deposit": 76445674,
        "debit": 177630,
        "credit": 0,
        "note": "ppob|15312426|Payment Halo (Telkomsel) - 08114095005",
        "created_at": "2017-01-25 09:47:06",
        "updated_at": "2017-01-25 09:47:06"
      },
      {
        "id": 178,
        "deposit": 76268044,
        "debit": 0,
        "credit": 870,
        "note": "ppob|15312539|Kredit komisi referal ( member_free )Halo (Telkomsel) - 08114095005",
        "created_at": "2017-01-25 09:48:59",
        "updated_at": "2017-01-25 09:48:59"
      },
      {
        "id": 179,
        "deposit": 76268914,
        "debit": 635750,
        "credit": 0,
        "note": "ppob|15313676|Payment Speedy - 122372250445",
        "created_at": "2017-01-25 10:07:56",
        "updated_at": "2017-01-25 10:07:56"
      },
      {
        "id": 180,
        "deposit": 75633164,
        "debit": 635170,
        "credit": 0,
        "note": "ppob|15313880|Payment Speedy - 122372250445",
        "created_at": "2017-01-25 10:11:20",
        "updated_at": "2017-01-25 10:11:20"
      },
      {
        "id": 181,
        "deposit": 74997994,
        "debit": 630750,
        "credit": 0,
        "note": "ppob|15313975|Payment Speedy - 122372250445",
        "created_at": "2017-01-25 10:12:55",
        "updated_at": "2017-01-25 10:12:55"
      },
      {
        "id": 182,
        "deposit": 74367244,
        "debit": 0,
        "credit": 630750,
        "note": "ppob|15313975|Refund Speedy - 122372250445",
        "created_at": "2017-01-25 10:12:55",
        "updated_at": "2017-01-25 10:12:55"
      },
      {
        "id": 183,
        "deposit": 74997994,
        "debit": 635550,
        "credit": 0,
        "note": "ppob|15314024|Payment Speedy - 122372250445",
        "created_at": "2017-01-25 10:13:44",
        "updated_at": "2017-01-25 10:13:44"
      },
      {
        "id": 184,
        "deposit": 74362444,
        "debit": 0,
        "credit": 635550,
        "note": "ppob|15314024|Refund Speedy - 122372250445",
        "created_at": "2017-01-25 10:13:44",
        "updated_at": "2017-01-25 10:13:44"
      },
      {
        "id": 185,
        "deposit": 74997994,
        "debit": 635170,
        "credit": 0,
        "note": "ppob|15314042|Payment Speedy - 122372250445",
        "created_at": "2017-01-25 10:14:02",
        "updated_at": "2017-01-25 10:14:02"
      },
      {
        "id": 186,
        "deposit": 74362824,
        "debit": 0,
        "credit": 635170,
        "note": "ppob|15314042|Refund Speedy - 122372250445",
        "created_at": "2017-01-25 10:14:02",
        "updated_at": "2017-01-25 10:14:02"
      },
      {
        "id": 187,
        "deposit": 74997994,
        "debit": 635170,
        "credit": 0,
        "note": "ppob|15314078|Payment Speedy - 122372250445",
        "created_at": "2017-01-25 10:14:38",
        "updated_at": "2017-01-25 10:14:38"
      },
      {
        "id": 188,
        "deposit": 74362824,
        "debit": 0,
        "credit": 635170,
        "note": "ppob|15314078|Refund Speedy - 122372250445",
        "created_at": "2017-01-25 10:14:38",
        "updated_at": "2017-01-25 10:14:38"
      },
      {
        "id": 189,
        "deposit": 74997994,
        "debit": 635170,
        "credit": 0,
        "note": "ppob|15314605|Payment Speedy - 122372250445",
        "created_at": "2017-01-25 10:23:25",
        "updated_at": "2017-01-25 10:23:25"
      },
      {
        "id": 190,
        "deposit": 74362824,
        "debit": 97600,
        "credit": 0,
        "note": "ppob|15315239|Payment Simpati Voucher Rp 100.000 - 08121413004",
        "created_at": "2017-01-25 10:33:59",
        "updated_at": "2017-01-25 10:33:59"
      },
      {
        "id": 191,
        "deposit": 74265224,
        "debit": 97300,
        "credit": 0,
        "note": "ppob|15315797|Payment Simpati Voucher Rp 100.000 - 08121413004",
        "created_at": "2017-01-25 10:43:17",
        "updated_at": "2017-01-25 10:43:17"
      },
      {
        "id": 192,
        "deposit": 74167924,
        "debit": 20889,
        "credit": 0,
        "note": "ppob|15315964|Payment Voucher PLN 20.000 - 32115074109",
        "created_at": "2017-01-25 10:46:04",
        "updated_at": "2017-01-25 10:46:04"
      },
      {
        "id": 193,
        "deposit": 74147035,
        "debit": 20889,
        "credit": 0,
        "note": "ppob|15316620|Payment Voucher PLN 20.000 - 32115074109",
        "created_at": "2017-01-25 10:57:00",
        "updated_at": "2017-01-25 10:57:00"
      },
      {
        "id": 195,
        "deposit": 74126146,
        "debit": -711,
        "credit": 0,
        "note": "ppob|15316931|Payment PLN Pascabayar - 544101745784",
        "created_at": "2017-01-25 11:02:11",
        "updated_at": "2017-01-25 11:02:11"
      },
      {
        "id": 196,
        "deposit": 74126857,
        "debit": 600384,
        "credit": 0,
        "note": "ppob|15317120|Payment PLN Pascabayar - 544101745784",
        "created_at": "2017-01-25 11:05:21",
        "updated_at": "2017-01-25 11:05:21"
      },
      {
        "id": 197,
        "deposit": 73526473,
        "debit": 600384,
        "credit": 0,
        "note": "ppob|15317844|Payment PLN Pascabayar - 544101745784",
        "created_at": "2017-01-25 11:17:24",
        "updated_at": "2017-01-25 11:17:24"
      },
      {
        "id": 198,
        "deposit": 72926089,
        "debit": 600384,
        "credit": 0,
        "note": "ppob|15317937|Payment PLN Pascabayar - 544101745784",
        "created_at": "2017-01-25 11:18:57",
        "updated_at": "2017-01-25 11:18:57"
      },
      {
        "id": 199,
        "deposit": 72325705,
        "debit": 62105,
        "credit": 0,
        "note": "ppob|15318483|Payment Telepon (Telkom) - 03619072591",
        "created_at": "2017-01-25 11:28:03",
        "updated_at": "2017-01-25 11:28:03"
      },
      {
        "id": 200,
        "deposit": 72263600,
        "debit": 62105,
        "credit": 0,
        "note": "ppob|15318559|Payment Telepon (Telkom) - 03619072591",
        "created_at": "2017-01-25 11:29:19",
        "updated_at": "2017-01-25 11:29:19"
      },
      {
        "id": 201,
        "deposit": 72201495,
        "debit": 62105,
        "credit": 0,
        "note": "ppob|15318580|Payment Telepon (Telkom) - 03619072591",
        "created_at": "2017-01-25 11:29:40",
        "updated_at": "2017-01-25 11:29:40"
      },
      {
        "id": 202,
        "deposit": 72139390,
        "debit": 600384,
        "credit": 0,
        "note": "ppob|15318598|Payment PLN Pascabayar - 544101745784",
        "created_at": "2017-01-25 11:29:58",
        "updated_at": "2017-01-25 11:29:58"
      },
      {
        "id": 203,
        "deposit": 71539006,
        "debit": 600384,
        "credit": 0,
        "note": "ppob|15318612|Payment PLN Pascabayar - 544101745784",
        "created_at": "2017-01-25 11:30:12",
        "updated_at": "2017-01-25 11:30:12"
      },
      {
        "id": 204,
        "deposit": 70938622,
        "debit": 20889,
        "credit": 0,
        "note": "ppob|15318781|Payment Voucher PLN 20.000 - 32115074109",
        "created_at": "2017-01-25 11:33:01",
        "updated_at": "2017-01-25 11:33:01"
      },
      {
        "id": 205,
        "deposit": 70917733,
        "debit": 20889,
        "credit": 0,
        "note": "ppob|15318811|Payment Voucher PLN 20.000 - 32115074109",
        "created_at": "2017-01-25 11:33:31",
        "updated_at": "2017-01-25 11:33:31"
      },
      {
        "id": 206,
        "deposit": 70896844,
        "debit": 20889,
        "credit": 0,
        "note": "ppob|15319136|Payment Voucher PLN 20.000 - 32115074109",
        "created_at": "2017-01-25 11:38:56",
        "updated_at": "2017-01-25 11:38:56"
      },
      {
        "id": 207,
        "deposit": 70875955,
        "debit": 20889,
        "credit": 0,
        "note": "ppob|15319148|Payment Voucher PLN 20.000 - 32115074109",
        "created_at": "2017-01-25 11:39:08",
        "updated_at": "2017-01-25 11:39:08"
      },
      {
        "id": 208,
        "deposit": 70855066,
        "debit": 20889,
        "credit": 0,
        "note": "ppob|15319331|Payment Voucher PLN 20.000 - 32115074109",
        "created_at": "2017-01-25 11:42:11",
        "updated_at": "2017-01-25 11:42:11"
      },
      {
        "id": 209,
        "deposit": 70834177,
        "debit": 20889,
        "credit": 0,
        "note": "ppob|15320193|Payment Voucher PLN 20.000 - 32115074109",
        "created_at": "2017-01-25 11:56:33",
        "updated_at": "2017-01-25 11:56:33"
      },
      {
        "id": 210,
        "deposit": 70813288,
        "debit": 600384,
        "credit": 0,
        "note": "ppob|15320223|Payment PLN Pascabayar - 544101745784",
        "created_at": "2017-01-25 11:57:03",
        "updated_at": "2017-01-25 11:57:03"
      },
      {
        "id": 211,
        "deposit": 70212904,
        "debit": 62105,
        "credit": 0,
        "note": "ppob|15320290|Payment Telepon (Telkom) - 03619072591",
        "created_at": "2017-01-25 11:58:10",
        "updated_at": "2017-01-25 11:58:10"
      },
      {
        "id": 212,
        "deposit": 70150799,
        "debit": 600384,
        "credit": 0,
        "note": "ppob|15322983|Payment PLN Pascabayar - 544101745784",
        "created_at": "2017-01-25 12:43:03",
        "updated_at": "2017-01-25 12:43:03"
      },
      {
        "id": 213,
        "deposit": 69550415,
        "debit": 62105,
        "credit": 0,
        "note": "ppob|15323015|Payment Telepon (Telkom) - 03619072591",
        "created_at": "2017-01-25 12:43:35",
        "updated_at": "2017-01-25 12:43:35"
      },
      {
        "id": 214,
        "deposit": 69488310,
        "debit": 11225,
        "credit": 0,
        "note": "ppob|15323112|Payment IM3 Reguler Rp 10.000 - 085810818047",
        "created_at": "2017-01-25 12:45:12",
        "updated_at": "2017-01-25 12:45:12"
      },
      {
        "id": 215,
        "deposit": 69477085,
        "debit": 25450,
        "credit": 0,
        "note": "ppob|15323143|Payment IM3 Reguler Rp 25.000 - 085810818047",
        "created_at": "2017-01-25 12:45:43",
        "updated_at": "2017-01-25 12:45:43"
      },
      {
        "id": 216,
        "deposit": 69451635,
        "debit": 62105,
        "credit": 0,
        "note": "ppob|15323381|Payment Telepon (Telkom) - 03619072591",
        "created_at": "2017-01-25 12:49:41",
        "updated_at": "2017-01-25 12:49:41"
      },
      {
        "id": 217,
        "deposit": 69389530,
        "debit": 6225,
        "credit": 0,
        "note": "ppob|15323511|Payment IM3 Reguler Rp 5.000 - 085718187373",
        "created_at": "2017-01-25 12:51:51",
        "updated_at": "2017-01-25 12:51:51"
      },
      {
        "id": 218,
        "deposit": 69383305,
        "debit": 25450,
        "credit": 0,
        "note": "ppob|15323531|Payment IM3 Reguler Rp 25.000 - 085718187373",
        "created_at": "2017-01-25 12:52:11",
        "updated_at": "2017-01-25 12:52:11"
      },
      {
        "id": 219,
        "deposit": 69357855,
        "debit": 62105,
        "credit": 0,
        "note": "ppob|15323661|Payment Telepon (Telkom) - 03619072591",
        "created_at": "2017-01-25 12:54:21",
        "updated_at": "2017-01-25 12:54:21"
      },
      {
        "id": 220,
        "deposit": 69295750,
        "debit": 62105,
        "credit": 0,
        "note": "ppob|15323722|Payment Telepon (Telkom) - 03619072591",
        "created_at": "2017-01-25 12:55:22",
        "updated_at": "2017-01-25 12:55:22"
      },
      {
        "id": 221,
        "deposit": 69233645,
        "debit": 122125,
        "credit": 0,
        "note": "ppob|15323747|Payment Halo (Telkomsel) - 08115659799",
        "created_at": "2017-01-25 12:55:47",
        "updated_at": "2017-01-25 12:55:47"
      },
      {
        "id": 222,
        "deposit": 69111520,
        "debit": 562855,
        "credit": 0,
        "note": "ppob|15323856|Payment Speedy - 172502206117",
        "created_at": "2017-01-25 12:57:36",
        "updated_at": "2017-01-25 12:57:36"
      },
      {
        "id": 223,
        "deposit": 68548665,
        "debit": 563250,
        "credit": 0,
        "note": "ppob|15324341|Payment Telkomvision - 172502206117",
        "created_at": "2017-01-25 13:05:41",
        "updated_at": "2017-01-25 13:05:41"
      },
      {
        "id": 224,
        "deposit": 67985415,
        "debit": 563250,
        "credit": 0,
        "note": "ppob|15325162|Payment Telkomvision - 172502206117",
        "created_at": "2017-01-25 13:19:22",
        "updated_at": "2017-01-25 13:19:22"
      },
      {
        "id": 225,
        "deposit": 67422165,
        "debit": 789828,
        "credit": 0,
        "note": "ppob|15325279|Payment Indovision - 301010461845",
        "created_at": "2017-01-25 13:21:19",
        "updated_at": "2017-01-25 13:21:19"
      },
      {
        "id": 226,
        "deposit": 66632337,
        "debit": 789828,
        "credit": 0,
        "note": "ppob|15325356|Payment Indovision - 301010461845",
        "created_at": "2017-01-25 13:22:36",
        "updated_at": "2017-01-25 13:22:36"
      },
      {
        "id": 227,
        "deposit": 65842509,
        "debit": 789196,
        "credit": 0,
        "note": "ppob|15325475|Payment Indovision - 301010461845",
        "created_at": "2017-01-25 13:24:35",
        "updated_at": "2017-01-25 13:24:35"
      },
      {
        "id": 228,
        "deposit": 65053313,
        "debit": 789196,
        "credit": 0,
        "note": "ppob|15325514|Payment Indovision - 301010461845",
        "created_at": "2017-01-25 13:25:14",
        "updated_at": "2017-01-25 13:25:14"
      },
      {
        "id": 229,
        "deposit": 64264117,
        "debit": 607210,
        "credit": 0,
        "note": "ppob|15326402|Payment Mega Auto Finance - 1511601216",
        "created_at": "2017-01-25 13:40:02",
        "updated_at": "2017-01-25 13:40:02"
      },
      {
        "id": 230,
        "deposit": 63656907,
        "debit": 0,
        "credit": 607210,
        "note": "ppob|15326402|Refund Mega Auto Finance - 1511601216",
        "created_at": "2017-01-25 13:40:02",
        "updated_at": "2017-01-25 13:40:02"
      },
      {
        "id": 231,
        "deposit": 64264117,
        "debit": 607210,
        "credit": 0,
        "note": "ppob|15326602|Payment Mega Auto Finance - 1511601216",
        "created_at": "2017-01-25 13:43:22",
        "updated_at": "2017-01-25 13:43:22"
      },
      {
        "id": 232,
        "deposit": 63656907,
        "debit": 0,
        "credit": 607210,
        "note": "ppob|15326602|Refund Mega Auto Finance - 1511601216",
        "created_at": "2017-01-25 13:43:22",
        "updated_at": "2017-01-25 13:43:22"
      },
      {
        "id": 233,
        "deposit": 64264117,
        "debit": 607210,
        "credit": 0,
        "note": "ppob|15327035|Payment Mega Auto Finance - 1511601216",
        "created_at": "2017-01-25 13:50:35",
        "updated_at": "2017-01-25 13:50:35"
      },
      {
        "id": 234,
        "deposit": 63656907,
        "debit": 0,
        "credit": 607210,
        "note": "ppob|15327035|Refund Mega Auto Finance - 1511601216",
        "created_at": "2017-01-25 13:50:35",
        "updated_at": "2017-01-25 13:50:35"
      },
      {
        "id": 235,
        "deposit": 64264117,
        "debit": 607210,
        "credit": 0,
        "note": "ppob|15327116|Payment Mega Auto Finance - 1511601216",
        "created_at": "2017-01-25 13:51:56",
        "updated_at": "2017-01-25 13:51:56"
      },
      {
        "id": 236,
        "deposit": 63656907,
        "debit": 607210,
        "credit": 0,
        "note": "ppob|15330663|Payment Mega Auto Finance - 1511601216",
        "created_at": "2017-01-25 14:51:03",
        "updated_at": "2017-01-25 14:51:03"
      },
      {
        "id": 237,
        "deposit": 63049697,
        "debit": 607210,
        "credit": 0,
        "note": "ppob|15330841|Payment Mega Auto Finance - 1511601216",
        "created_at": "2017-01-25 14:54:01",
        "updated_at": "2017-01-25 14:54:01"
      },
      {
        "id": 238,
        "deposit": 62442487,
        "debit": 2092210,
        "credit": 0,
        "note": "ppob|15330874|Payment WOM Finance - 810300004458",
        "created_at": "2017-01-25 14:54:34",
        "updated_at": "2017-01-25 14:54:34"
      },
      {
        "id": 239,
        "deposit": 60350277,
        "debit": 70089,
        "credit": 0,
        "note": "ppob|15330997|Payment PDAM Kab. Bogor - 19018962",
        "created_at": "2017-01-25 14:56:37",
        "updated_at": "2017-01-25 14:56:37"
      },
      {
        "id": 240,
        "deposit": 60280188,
        "debit": 70089,
        "credit": 0,
        "note": "ppob|15333519|Payment PDAM Kab. Bogor - 19018962",
        "created_at": "2017-01-25 15:38:39",
        "updated_at": "2017-01-25 15:38:39"
      },
      {
        "id": 241,
        "deposit": 60210099,
        "debit": 70089,
        "credit": 0,
        "note": "ppob|15333599|Payment PDAM Kab. Bogor - 19018962",
        "created_at": "2017-01-25 15:39:59",
        "updated_at": "2017-01-25 15:39:59"
      },
      {
        "id": 242,
        "deposit": 60140010,
        "debit": 70089,
        "credit": 0,
        "note": "ppob|15333734|Payment PDAM Kab. Bogor - 19018962",
        "created_at": "2017-01-25 15:42:14",
        "updated_at": "2017-01-25 15:42:14"
      },
      {
        "id": 243,
        "deposit": 60069921,
        "debit": 1637000,
        "credit": 0,
        "note": "ppob|15333974|Payment BPJS Kesehatan - 0001457614258",
        "created_at": "2017-01-25 15:46:14",
        "updated_at": "2017-01-25 15:46:14"
      },
      {
        "id": 244,
        "deposit": 58432921,
        "debit": 0,
        "credit": 1637000,
        "note": "ppob|15333974|Refund BPJS Kesehatan - 0001457614258",
        "created_at": "2017-01-25 15:46:14",
        "updated_at": "2017-01-25 15:46:14"
      },
      {
        "id": 245,
        "deposit": 60069921,
        "debit": 1637000,
        "credit": 0,
        "note": "ppob|15335318|Payment BPJS Kesehatan - 0001457614258",
        "created_at": "2017-01-25 16:08:38",
        "updated_at": "2017-01-25 16:08:38"
      },
      {
        "id": 246,
        "deposit": 58432921,
        "debit": 0,
        "credit": 1637000,
        "note": "ppob|15335318|Refund BPJS Kesehatan - 0001457614258",
        "created_at": "2017-01-25 16:08:38",
        "updated_at": "2017-01-25 16:08:38"
      },
      {
        "id": 247,
        "deposit": 60069921,
        "debit": 1637000,
        "credit": 0,
        "note": "ppob|15336764|Payment BPJS Kesehatan - 0001457614258",
        "created_at": "2017-01-25 16:32:44",
        "updated_at": "2017-01-25 16:32:44"
      },
      {
        "id": 248,
        "deposit": 58432921,
        "debit": 0,
        "credit": 1637000,
        "note": "ppob|15336764|Refund BPJS Kesehatan - 0001457614258",
        "created_at": "2017-01-25 16:32:44",
        "updated_at": "2017-01-25 16:32:44"
      },
      {
        "id": 249,
        "deposit": 60069921,
        "debit": 1637000,
        "credit": 0,
        "note": "ppob|15336866|Payment BPJS Kesehatan - 0001457614258",
        "created_at": "2017-01-25 16:34:26",
        "updated_at": "2017-01-25 16:34:26"
      },
      {
        "id": 250,
        "deposit": 58432921,
        "debit": 1637000,
        "credit": 0,
        "note": "ppob|15337764|Payment BPJS Kesehatan - 0001457614258",
        "created_at": "2017-01-25 16:49:24",
        "updated_at": "2017-01-25 16:49:24"
      },
      {
        "id": 251,
        "deposit": 56795921,
        "debit": 1637000,
        "credit": 0,
        "note": "ppob|15337843|Payment BPJS Kesehatan - 0001457614258",
        "created_at": "2017-01-25 16:50:43",
        "updated_at": "2017-01-25 16:50:43"
      },
      {
        "id": 252,
        "deposit": 55158921,
        "debit": 20889,
        "credit": 0,
        "note": "ppob|15357183|Payment Voucher PLN 20.000 - 32115074109",
        "created_at": "2017-01-25 22:13:03",
        "updated_at": "2017-01-25 22:13:03"
      },
      {
        "id": 253,
        "deposit": 55138032,
        "debit": 20889,
        "credit": 0,
        "note": "ppob|15357201|Payment Voucher PLN 20.000 - 32115074109",
        "created_at": "2017-01-25 22:13:21",
        "updated_at": "2017-01-25 22:13:21"
      },
      {
        "id": 254,
        "deposit": 55117143,
        "debit": 20889,
        "credit": 0,
        "note": "ppob|15357230|Payment Voucher PLN 20.000 - 32115074109",
        "created_at": "2017-01-25 22:13:50",
        "updated_at": "2017-01-25 22:13:50"
      },
      {
        "id": 255,
        "deposit": 55096254,
        "debit": 6225,
        "credit": 0,
        "note": "ppob|15357542|Payment IM3 Reguler Rp 5.000 - 085718187373",
        "created_at": "2017-01-25 22:19:02",
        "updated_at": "2017-01-25 22:19:02"
      },
      {
        "id": 256,
        "deposit": 55090029,
        "debit": 1637000,
        "credit": 0,
        "note": "ppob|15361007|Payment BPJS Kesehatan - 0001457614258",
        "created_at": "2017-01-25 23:16:47",
        "updated_at": "2017-01-25 23:16:47"
      },
      {
        "id": 257,
        "deposit": 53453029,
        "debit": 1637000,
        "credit": 0,
        "note": "ppob|15361198|Payment BPJS Kesehatan - 0001457614258",
        "created_at": "2017-01-25 23:19:58",
        "updated_at": "2017-01-25 23:19:58"
      },
      {
        "id": 258,
        "deposit": 51816029,
        "debit": 1637000,
        "credit": 0,
        "note": "ppob|15361406|Payment BPJS Kesehatan - 0001457614258",
        "created_at": "2017-01-25 23:23:26",
        "updated_at": "2017-01-25 23:23:26"
      }
    ]
  }
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resDepHistory2" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px;">
                <code class="language-markup">
------------------- RESPONSE GAGAL > 31 HARI --------------------------
{
  "status": {
    "code": 400,
    "confirm": "failed",
    "message": [
      "History deposit yang bisa Anda cek maksimal 31 hari."
    ]
  }
}
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
    <div class="tab-pane fade" id="resDepHistory3" role="tabpanel">
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
