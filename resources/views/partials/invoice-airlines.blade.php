<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" media="all" href="{{asset('theme/css/invoice.css')}}"/>
</head>
</html>
<body>
<div id='page'>
    <div>
        <h2>
            Bukti Pembayaran
            <span style='position: absolute; right: 0'>
No.
<span style='color: #31445c !important'>{{$order->id}}</span>
</span>
        </h2>
        <img src="https://www.sejahterapratama.com/images/logo_onoopo.png" width="175" height="62" alt="OnoOpo.Com">
        <div style='margin-top: 40px; margin-bottom: 20px;'>
            <p>Dear {{$order->user->name}},</p>
            Terima kasih atas kepercayaan Anda bertransaksi melalui OnoOpo.com.
        </div>
        <div>
            <table border='0' cellpadding='5' cellspacing='0' id='templateList' width='100%'>
                <tr>
                    <th colspan='8' style='background: #31445c !important'>
                        <h4 style='text-align: center; color: #ffffff !important; line-height: 0;font-size: 1.2em; font-weight: bold;'>
                            Bukti Pembayaran
                        </h4>
                    </th>
                </tr>
                <tr>
                    <td align='left' colspan='2' valign='top'>
                        Nomor Tagihan
                    </td>
                    <td align='left' colspan='6' valign='top'>
                        <strong>{{$order->id}}</strong>
                    </td>
                </tr>
                <tr>
                    <td align='left' colspan='2' valign='top'>
                        Waktu Transaksi
                    </td>
                    <td align='left' colspan='6' valign='top'>
                        <strong>
                            {{date("d M y H:i",strtotime($order->created_at))}}
                            <span>WIB</span>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td align='left' colspan='2' valign='top'>
                        Pembeli
                    </td>
                    <td align='left' colspan='6' valign='top'>
                        <strong>{{$order->user->name}}</strong>
                    </td>
                </tr>
                <tr>
                    <td align='left' colspan='2' valign='top'>
                        Tujuan pengiriman
                    </td>
                    <td align='left' colspan='6' valign='top'>
                        <strong>
                            {{$order->address->name}}
                        </strong>
                        <br>
                        {{$order->address->detail}}
                        <br>
                        {{$order->address->subdistrict->name}},  {{$order->address->subdistrict->city->name}}
                        <br>
                        {{$order->address->subdistrict->city->province->name}}
                        <br>
                        No. Telp: {{$order->address->phone}}
                    </td>
                </tr>
                <?php $i=1; ?>
                @foreach($order->details as $order_detail)
                    <tr>
                        <th colspan='8' style='background: #31445c !important'></th>
                    </tr>
                    <tr>
                        <td align='center' colspan='8' style='background-color: #e0e0e0 !important' valign='top'>
                            <strong>Transaksi{{$order->id}}-{{$i}}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td align='left' colspan='2' valign='top'>
                            Nomor Transaksi
                        </td>
                        <td align='left' colspan='6' valign='top'>
                            <strong>#{{$order_detail->product->id}}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td align='left' colspan='2' valign='top'>
                            Penjual
                        </td>
                        <td align='left' colspan='6' valign='top'>
                            {{$order_detail->merchant->name}}
                        </td>
                    <tr>
                        <td align='left' colspan='2' valign='top'>
                            Alamat
                        </td>
                        <td align='left' colspan='6' valign='top'>
                            {{$order_detail->merchant->address->detail}}
                            <br>
                            {{$order_detail->merchant->address->subdistrict->name}},  {{$order_detail->merchant->address->subdistrict->city->name}}
                            <br>
                            {{$order_detail->merchant->address->subdistrict->city->province->name}}
                        </td>
                    </tr>
                    <tr>
                        <td align='left' colspan='1' valign='top'>
                            Catatan Pembeli
                        </td>
                        <td align='left' colspan='7' valign='top'>
                            <p>{{$order_detail->note_buyer}}</p>
                        </td>
                    </tr>
                    </tr>
                    <tr>
                        <td align='center' colspan='4' style='background-color: #e0e0e0 !important' valign='top'>
                            <strong>Nama</strong>
                        </td>
                        <td align='center' colspan='1' style='background-color: #e0e0e0 !important' valign='top'>
                            <strong>Jumlah</strong>
                        </td>
                        <td align='center' colspan='3' style='background-color: #e0e0e0 !important' valign='top'>
                            <strong>Harga</strong>
                        </td>
                    </tr>
                    <tr>
                        <td align='left' colspan='4' valign='middle'>
                            <a class='product-name-link' href='#' style='font-weight: bold; text-decoration: none;' title='{{$order_detail->product->name}}'>
                                {{$order_detail->product->name}}
                            </a>
                        </td>
                        <td align='center' colspan='1' valign='middle'>
                            {{$order_detail->quantity}}
                        </td>
                        <td align='right' colspan='3' valign='middle'>
                            <span class='currency positive'>Rp</span><span class='amount positive'>{{number_format($order_detail->price)}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td align='left' colspan='5' valign='top'>
                            Subtotal Harga Barang
                        </td>
                        <td align='right' colspan='3' valign='top'>
                            <strong><span class='currency positive'>Rp</span><span class='amount positive'>{{number_format($order_detail->price*$order_detail->quantity)}}</span></strong>
                        </td>
                    </tr>
                    <?php $i++;
                    $arrayPrice[]=$order_detail->price;
                    $arrayFee[]=$order_detail->fee;
                    ?>

                @endforeach
                <tr>
                    <th colspan='8' style='background: #31445c !important'>
                        <strong style='text-align: center; color: #ffffff !important; line-height: 0; font-weight: bold;'>
                            Rincian Biaya
                        </strong>
                    </th>
                </tr>
                <tr>
                    <td align='left' colspan='5' valign='top'>
                        Total Harga Barang
                    </td>
                    <td align='right' colspan='3' valign='top'>
                        <strong><span class='currency positive'>Rp</span><span class='amount positive'>{{number_format(collect($arrayPrice)->sum())}}</span></strong>
                    </td>
                </tr>
                <tr>
                    <td align='left' colspan='5' valign='top'>
                        Biaya Kirim
                    </td>
                    <td align='right' colspan='3' valign='top'>
                        <strong><span class='currency positive'>Rp</span><span class='amount positive'>{{number_format(collect($arrayFee)->sum())}}</span></strong>
                    </td>
                </tr>
                <tr>
                    <td align='left' colspan='5' valign='top'>
                        Kode Pembayaran
                        <small>(Hanya dibebankan kepada pembeli)</small>
                    </td>
                    <td align='right' colspan='3' valign='top'>
                        <strong>{{number_format($order->unique_payment)}}</strong>
                    </td>
                </tr>
                <tr>
                    <td align='left' colspan='5' valign='top'>
                        <strong>TOTAL PEMBAYARAN</strong>
                    </td>
                    <td align='right' class='grandTotal' colspan='3' valign='top'>
                        <strong><span class='currency positive'>Rp</span><span class='amount positive'>{{number_format($order->total_payment+$order->unique_payment)}}</span></strong>
                    </td>
                </tr>
                <tr style='visibility: hidden;'>
                    <td width='12%'></td>
                    <td width='13%'></td>
                    <td width='12%'></td>
                    <td width='13%'></td>
                    <td width='12%'></td>
                    <td width='13%'></td>
                    <td width='12%'></td>
                    <td width='13%'></td>
                </tr>
            </table>
        </div>
    </div>
    <br>
    <div style='margin-top: 40px;'>
        <p>- OnoOpo.com merupakan marketplace yang hanya menjadi perantara antara penjual dan pembeli<br>
            - Kuitansi ini hanya berlaku sebagai bukti pembayaran pembeli kepada penjual, bukan sebagai nota pembelian

        </p>
    </div>
    <script>
        print();
    </script>


</div>
</body>
