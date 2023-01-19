<!DOCTYPE html>
<html>
<head>
    <title>Struk Pulsa Prabayar</title>
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
                    <table>
                        <tr>
                            <td><p style="color:#2699d0;font-size:18px;line-height:1.25em;">
                                    <b>STRUK PEMBELIAN PULSA</b><br>
                                    TGL. PEMBELIAN : {{ date('d-m-Y H:i',strtotime($data->created_at)) }}
                                </p></td>
                            <td style="text-align: right;">
                                <img src="{{ asset('/images/logo/operator/'.logoOperator($data->ppob_service->parent_id)) }}" style="height: 80px;width: auto;">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <br>
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
                    <td style="text-align: left; text-transform: uppercase;width: 15%;">Operator</td>
                    <td style="text-align: left; text-transform: uppercase;width: 40%;">: {{$data->ppob_service->parent->name}}</td>
                </tr>
                <tr>
                    <td style="text-align: left; text-transform: uppercase;width: 15%;">Nominal</td>
                    <td style="text-align: left; text-transform: uppercase;width: 40%;">: {{$data->ppob_service->name}}</td>
                </tr>
                <tr>
                    <td style="text-align: left; text-transform: uppercase;width: 15%;">No. HP</td>
                    <td style="text-align: left; text-transform: uppercase;width: 40%;">: {{$data->number}}</td>
                </tr>
                <tr>
                    <td style="text-align: left; text-transform: uppercase">Status</td>
                    <td style="text-align: left; text-transform: uppercase">: {{ $data->status }}</td>
                </tr>
                @if($data->serial_number)
                  <tr>
                      <td style="text-align: left; text-transform: uppercase">SN</td>
                      <td style="text-align: left; text-transform: uppercase">: {{ $data->serial_number->serial_number }}</td>
                  </tr>
                @endif
                @if((int)$data->service_fee>0)
                  <tr>
                      <td style="text-align: left; text-transform: uppercase">TOTAL BAYAR</td>
                      <td style="text-align: left; text-transform: uppercase">: IDR {{ number_format($data->paxpaid+(int)$data->service_fee) }}</td>
                  </tr>
                @endif
            </table>
        </div>
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
