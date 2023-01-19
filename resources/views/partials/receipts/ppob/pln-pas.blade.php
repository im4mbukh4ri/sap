<!DOCTYPE html>
<html>
<head>
    <title>Struk PLN Prabayar</title>
    <style>
        html,body,div,p,hr,table,tr,td{margin:0px;padding:0px;font-family:Arial;font-size:14px;}
        html{background-color:#777777;}
        .div_main{width:800px;margin:0px auto;background-color:#ffffff;}
    </style>
</head>
<body>
<div class="div_main">
    <div style="padding:25px;">
        <div style="width:100%;display:table;">
            <div style="width:35%;float:left;">
                <div style="border-right:2px solid #2699d0;">
                    <img src="{{ asset('/assets/logo/logotext-blue.png') }}" style="height:80px;">
                </div>
            </div>
            <div style="width:65%;float:right;">
                <div style="padding-left:15px;">
                    <p style="color:#2699d0;font-size:18px;line-height:1.25em;">
                        <b>STRUK PEMBAYARAN TAGIHAN PLN</b><br>
                        TGL. PEMBAYARAN : {{ date('d-m-Y',strtotime($data->created_at)) }}
                    </p>
                </div>
            </div>
        </div>
        <br>
        <br>
        <br>
        <br>
        <div style="width:100%;margin-top:20px;display:table;">
            <div style="width:30%;background-color:#2699d0;float:left;">
                <p style="color:#ffffff;line-height:40px;text-align: center;"><b>Purchase Details</b></p>
            </div>
            <div style="width:70%;float:right;">
                <div style="padding-left:10px;">
                    <hr style="margin-top:19px;border:none;border-top:2px solid #2699d0;">
                </div>
            </div>
        </div>
        <br>
        <br>
        <br>
        <div>
            <table border="0" width="100%">
                <tr>
                    <td style="text-align: left; text-transform: uppercase;width: 15%;">ID PELANGGAN</td>
                    <td style="text-align: left; text-transform: uppercase;width: 40%;">: {{$data->number}}</td>
                    <td style="text-align: left; text-transform: uppercase;width: 15%;">PERIODE</td>
                    <td style="text-align: left; text-transform: uppercase;width: 15%;">: {{  $data->pln_pasca->period  }}</td>
                </tr>
                <tr>
                    <td style="text-align: left; text-transform: uppercase"> NAMA</td>
                    <td style="text-align: left; text-transform: uppercase">: {{ $data->pln_pasca->customer_name }}</td>
                    <td style="text-align: left; text-transform: uppercase">RP TAGIHAN</td>
                    <td style="text-align: left; text-transform: uppercase">: RP {{ number_format($data->pln_pasca->nominal) }}</td>
                </tr>
                <tr>
                    <td style="text-align: left; text-transform: uppercase">GOL / DAYA</td>
                    <td style="text-align: left; text-transform: uppercase">: {{ $data->pln_pasca->golongan_daya }}</td>
                    <td style="text-align: left; text-transform: uppercase">ADMIN BANK</td>
                    <td style="text-align: left; text-transform: uppercase">: RP {{ number_format($data->pln_pasca->admin) }}</td>
                </tr>
                <tr>
                    <td style="text-align: left; text-transform: uppercase">STAND METER</td>
                    <td style="text-align: left; text-transform: uppercase">: {{  $data->pln_pasca->stand_meter }}</td>
                    @if((int)$data->service_fee>0)
                        <td style="text-align: left; text-transform: uppercase">SERVICE FEE</td>
                        <td style="text-align: left; text-transform: uppercase">: RP {{ number_format($data->service_fee) }}</td>
                    @else
                        <td style="text-align: left; text-transform: uppercase">TOTAL BAYAR</td>
                        <td style="text-align: left; text-transform: uppercase">: RP {{ number_format($data->paxpaid) }}</td>
                    @endif
                </tr>
                @if((int)$data->service_fee>0)
                    <tr>
                        <td style="text-align: left; text-transform: uppercase"></td>
                        <td style="text-align: left; text-transform: uppercase"></td>
                        <td style="text-align: left; text-transform: uppercase">TOTAL BAYAR</td>
                        <td style="text-align: left; text-transform: uppercase">: RP {{ number_format($data->paxpaid+(int)$data->service_fee) }}</td>
                    </tr>
                @endif
            </table>
        </div>
        <h5 style="text-align: center;text-transform: uppercase;">PLN MENYATAKAN STRUK INI SEBAGAI TANDA BUKTI PEMBAYARAN YANG SAH. INFO HUB : 123. MOHON DI SIMPAN DENGAN BAIK</h5>
    </div>
    <br>
    <div style="background-color:#2699d0;">
        <div style="padding:10px 25px;">
            <div style="width:100%;display:table;">
                <table style="margin-left:20px;float:left;">
                    <tr>
                        <td rowspan="2"><img src="{{ asset('images/logo/theme/email-icon.PNG') }}" style="height:32px;"></td>
                        <td><p style="padding-left:5px;color:#ffffff;font-size:12px;">Email :</p></td>
                    </tr>
                    <tr>
                        <td><p style="padding-left:5px;color:#ffffff;"><b>cs@mysmartinpays.net</b></p></td>
                    </tr>
                </table>
            </div>
        </div>
        <br>
        <br>
        <br>
    </div>
</div>
</body>
</html>