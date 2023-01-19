<?php

namespace App\Http\Controllers;

use App\Log;
use App\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use JavaScript;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','csrf']);
    }
    public function bonusTransaksi()
    {
        $year = date("Y");
        $user = auth()->user();
        $userId = $user->id;
        $username = $user->username;

        $totalMember = $this->getCurl("101", $username, $year);
        $bonus = $this->getCurl("102", $username, $year);
        $bonusTransaksi = $this->getCurl("104", $username, $year);

        $totalFree = User::where('type_user_id', 5)->where('upline', $userId)->count();

        $months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('users.bonus_transaksi', compact('totalMember', 'totalFree', 'bonus', 'bonusTransaksi', 'months', 'year'));
    }

    public function getCurl($type, $username, $year)
    {
        $curl = curl_init();

        $parameters = [
            'access_id' => '1031MYSIP201704',
            'access_pass' => '300980e7d88a85adb814387ffb914066',
            'access_type' => $type,
            'username' => $username,
            'curr_year' => $year,
        ];

        $options = [
            CURLOPT_URL => "https://access.sipindonesia.com/api/mysip_view.asp",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($parameters),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/x-www-form-urlencoded'
            ]
        ];
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $data = str_replace('"[', '[', $response);
        $data = str_replace(']"', ']', $data);
        $data = json_decode($data, true);
        return $data;
    }
}
