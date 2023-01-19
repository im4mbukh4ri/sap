<?php
function logoOperator($operator_id)
{
    $logo = null;
    switch ($operator_id) {
        case 10:
            $logo = 'xl.png';
            break;
        case 11:
            $logo = 'smartfren.png';
            break;
        case 12:
            $logo = 'esia.png';
            break;
        case 13:
            $logo = 'indosat.png';
            break;
        case 14:
            $logo = 'axis.png';
            break;
        case 15:
            $logo = 'three.png';
            break;
        case 16:
            $logo = 'telkomsel.png';
            break;
        case 17:
            $logo = 'bolt.png';
            break;
    }
    return $logo;
}

function daysDifference($endDate, $beginDate)
{
    //format tanggal yyyy-mm-dd
    //explode the date by "-" and storing to array
    $date_parts1 = explode("-", $beginDate);
    $date_parts2 = explode("-", $endDate);
    //gregoriantojd() Converts a Gregorian date to Julian Day Count
    $start_date = gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
    $end_date = gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);
    return $end_date - $start_date;
}

function getService($id)
{
    $service = null;
    switch ($id) {
        case 1:
            $service = "PUL";
            break;
        case 2:
            $service = "PLN";
            break;
        case 3:
            $service = "PLN";
            break;
        case 4:
            $service = "TLP";
            break;
        case 5:
            $service = "NET";
            break;
        case 6:
            $service = "TVK";
            break;
        case 7:
            $service = "MFN";
            break;
        case 8:
            $service = "PAM";
            break;
        case 9:
            $service = "INS";
            break;
        case 18:
            $service = "GAME";
            break;
        case 348:
            $service = "CC";
            break;
    }
    return $service;
}

function monthList()
{
    return [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember'
    ];
}

function newMonthList()
{
    return [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];
}

function dateList()
{
    return [
        '01' => '1',
        '02' => '2',
        '03' => '3',
        '04' => '4',
        '05' => '5',
        '06' => '6',
        '07' => '7',
        '08' => '8',
        '09' => '9',
        '10' => '10',
        '11' => '11',
        '12' => '12',
        '13' => '13',
        '14' => '14',
        '15' => '15',
        '16' => '16',
        '17' => '17',
        '18' => '18',
        '19' => '19',
        '20' => '20',
        '21' => '21',
        '22' => '22',
        '23' => '23',
        '24' => '24',
        '25' => '25',
        '26' => '26',
        '27' => '27',
        '28' => '28',
        '29' => '29',
        '30' => '30',
        '31' => '31',
    ];
}

function yearListAdt()
{
    $year = array();
    for ($i = 2016; $i >= 1917; $i--) {
        $year[$i] = $i;
    }
    return $year;
}

function monthListChd()
{
    // $start=\Carbon\Carbon::now()->subYears(12);
    // $startYear=date('n',strtotime($start->toDateString()));
    // $month=array();
    // for($i=intval($startYear);$i<=12;$i++){
    //     //for($i=2014;$i>=2004;$i--){
    //     $month[(strlen(''.$i)==1)?'0'.$i:$i]=newMonthList()[$i];
    // }
    // // return $month;
    return monthList();
}

function yearListChd()
{
    $start = \Carbon\Carbon::now()->subYears(12);
    $end = \Carbon\Carbon::now()->subYears(2);
    $startYear = date('Y', strtotime($start->toDateString()));
    $endYear = date('Y', strtotime($end->toDateString()));
    $year = array();
    for ($i = intval($endYear); $i >= intval($startYear); $i--) {
        //for($i=2014;$i>=2004;$i--){
        $year[$i] = $i;
    }
    return $year;
}

function monthListInf()
{
    // $start=\Carbon\Carbon::now()->subYears(2);
    // $startYear=date('n',strtotime($start->toDateString()));
    // $month=array();
    // for($i=intval($startYear);$i<=12;$i++){
    //     //for($i=2014;$i>=2004;$i--){
    //     $month[(strlen(''.$i)==1)?'0'.$i:$i]=newMonthList()[$i];
    // }
    // return $month;
    return monthList();
}

function yearListInf()
{
    $start = \Carbon\Carbon::now()->subYears(2);
    $end = \Carbon\Carbon::now();
    $startYear = date('Y', strtotime($start->toDateString()));
    $endYear = date('Y', strtotime($end->toDateString()));
    $year = array();
    for ($i = intval($endYear); $i >= intval($startYear); $i--) {
        //for($i=2016;$i>=2014;$i--){
        $year[$i] = $i;
    }
    return $year;
}

function yearListPassport()
{
    $year = array();
    for ($i = 2037; $i >= 2017; $i--) {
        $year[$i] = $i;
    }
    return $year;
}

function myMonth($date)
{
    $month = date('n', strtotime($date));
    $indonesiaMonth = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    $result = $indonesiaMonth[(int)$month - 1];
    return $result;
}

function myDay($date)
{
    $day = date('D', strtotime($date));
    $indonesiaDay = [
        'Sun' => 'Minggu',
        'Mon' => 'Senin',
        'Tue' => 'Selasa',
        'Wed' => 'Rabu',
        'Thu' => 'Kamis',
        'Fri' => 'Jumat',
        'Sat' => 'Sabtu'
    ];
    $result = $indonesiaDay[$day];
    return $result;
}

function setActive($uri, $output = "active")
{
    if (is_array($uri)) {
        foreach ($uri as $u) {
            if (Route::is($u)) {
                return $output;
            }
        }
    } else {
        if (Route::is($uri)) {
            return $output;
        }
    }
}

function getSelectedIdDepFare($array)
{
    $selectedIDdepArr = array();
    for ($i = 0; $i < count($array); $i++) {
        $selectedIDdepArr[] = $array[$i]['selectedIDdep'];
    }
    $selectedIDdep = implode(",", $selectedIDdepArr);
    return $selectedIDdep;
}

function getSelectedIdRetFare($array)
{
    $selectedIDretArr = array();
    for ($i = 0; $i < count($array); $i++) {
        $selectedIDretArr[] = $array[$i]['selectedIDret'];
    }
    $selectedIDret = implode(",", $selectedIDretArr);
    return $selectedIDret;
}

function getSelectedIdDep($array)
{
    $selectedIDdepArr = array();
    for ($i = 0; $i < count($array); $i++) {
        $selectedIDdepArr[] = $array[$i][0]['selectedIDdep'];
    }
    $selectedIDdep = implode(",", $selectedIDdepArr);
    return $selectedIDdep;
}

function getSelectedIdRet($array)
{
    $selectedIDdepArr = array();
    for ($i = 0; $i < count($array); $i++) {
        $selectedIDdepArr[] = $array[$i][0]['selectedIDret'];
    }
    $selectedIDdep = implode(",", $selectedIDdepArr);
    return $selectedIDdep;
}

function getFlightNumber($array)
{
    $flightNumberArr = array();
    for ($i = 0; $i < count($array); $i++) {
        $flightNumberArr[] = $array[$i]['FlightNo'];
    }
    $flightNumber = implode(",", $flightNumberArr);
    return $flightNumber;
}

function getAC($flightNumber)
{
    $ac = substr($flightNumber, 0, 2);
//    if ($ac=="ID") $ac="JT";
//    if ($ac=="IW") $ac="JT";
//    if ($ac=="IN") $ac="SJ";
    // $filter=($ac=="ID"||$ac=="IW")?"JT":(($ac=="IN")?"SJ":(($ac=="XT")?"QZ":$ac));
    // $filter=($ac=="ID"||$ac=="IW")?"JT":(($ac=="IN")?"SJ":($ac=="XT")?"QZ":(($ac=="8B")?"MV":$ac));
    if ($ac == 'ID' || $ac == 'IW') {
        return $filter = 'JT';
    }
    if ($ac == 'IN') {
        return $filter = 'SJ';
    }
    if ($ac == 'XT') {
        return $filter = 'QZ';
    }
    if ($ac == '8B') {
        return $filter = 'MV';
    }
    return $filter = $ac;
}

function getLogo($flightNumber)
{
    $ac = substr($flightNumber, 0, 2);
    $filter = ($ac == "XT") ? "QZ" : $ac;
    return $filter;
}

function getAirport($airportCode)
{
    $airport = App\Airport::find($airportCode);
    return $airport;
}

function getStation($stationCode)
{
    $station = App\Station::find($stationCode);
    return $station;
}

function getAirlineDetail($airline_code)
{
    $airline = [
        '3K' =>
            array(
                'code' => '3K',
                'name' => 'Jetstar',
                'icon' => '3K.png',
            ),
        'AA' =>
            array(
                'code' => 'AA',
                'name' => 'American Airlines',
                'icon' => 'AA.png',
            ),
        'AK' =>
            array(
                'code' => 'AK',
                'name' => 'AirAsia',
                'icon' => 'AK.png',
            ),
        'BA' =>
            array(
                'code' => 'BA',
                'name' => 'BRITISH AIRWAYS',
                'icon' => 'BA.png',
            ),
        'CI' =>
            array(
                'code' => 'CI',
                'name' => 'CHINA AIRLINES',
                'icon' => 'CI.png',
            ),
        'CX' =>
            array(
                'code' => 'CX',
                'name' => 'CATHAY PACIFIC',
                'icon' => 'CX.png',
            ),
        'CZ' =>
            array(
                'code' => 'CZ',
                'name' => 'CHINA SOUTHEN',
                'icon' => 'CZ.png',
            ),
        'D7' =>
            array(
                'code' => 'D7',
                'name' => 'AirAsia',
                'icon' => 'D7.png',
            ),
        'EK' =>
            array(
                'code' => 'EK',
                'name' => 'Emirates',
                'icon' => 'EK.png',
            ),
        'EY' =>
            array(
                'code' => 'EY',
                'name' => 'ETIHAD AIRWAYS',
                'icon' => 'EY.png',
            ),
        'FD' =>
            array(
                'code' => 'FD',
                'name' => 'AirAsia',
                'icon' => 'FD.png',
            ),
        'GA' =>
            array(
                'code' => 'GA',
                'name' => 'Garuda Indonesia',
                'icon' => 'GA.png',
            ),
        'I5' =>
            array(
                'code' => 'I5',
                'name' => 'AirAsia',
                'icon' => 'I5.png',
            ),
        'ID' =>
            array(
                'code' => 'ID',
                'name' => 'Batik Air',
                'icon' => 'ID.png',
            ),
        'IL' =>
            array(
                'code' => 'IL',
                'name' => 'Trigana Air',
                'icon' => 'trigana.png',
            ),
        'IN' =>
            array(
                'code' => 'IN',
                'name' => 'NAM Air',
                'icon' => 'IN.png',
            ),
        'IW' =>
            array(
                'code' => 'IW',
                'name' => 'Whings Air',
                'icon' => 'IW.png',
            ),
        'JL' =>
            array(
                'code' => 'JL',
                'name' => 'JAPAN AIRLINES',
                'icon' => 'JL.png',
            ),
        'JQ' =>
            array(
                'code' => 'JQ',
                'name' => 'Jetstar',
                'icon' => 'JQ.png',
            ),
        'JT' =>
            array(
                'code' => 'JT',
                'name' => 'Lion Air',
                'icon' => 'JT.png',
            ),
        'KD' =>
            array(
                'code' => 'KD',
                'name' => 'Kalstar Aviation',
                'icon' => 'kalstar.png',
            ),
        'KE' =>
            array(
                'code' => 'KE',
                'name' => 'KOREAN AIR',
                'icon' => 'KE.png',
            ),
        'KL' =>
            array(
                'code' => 'KL',
                'name' => 'KLM',
                'icon' => 'KL.png',
            ),
        'MH' =>
            array(
                'code' => 'MH',
                'name' => 'malaysia airlines',
                'icon' => 'MH.png',
            ),
        'MI' =>
            array(
                'code' => 'MI',
                'name' => 'SILKAIR',
                'icon' => 'MI.png',
            ),
        'MV' =>
            array(
                'code' => 'MV',
                'name' => 'Transnusa',
                'icon' => 'transnusa.png',
            ),
        '8B' =>
            array(
                'code' => '8B',
                'name' => 'Transnusa',
                'icon' => '8B.png',
            ),
        'NH' =>
            array(
                'code' => 'NH',
                'name' => 'ANA',
                'icon' => 'NH.png',
            ),
        'OD' =>
            array(
                'code' => 'OD',
                'name' => 'malindo air',
                'icon' => 'OD.png',
            ),
        'QF' =>
            array(
                'code' => 'QF',
                'name' => 'QANTAS',
                'icon' => 'QF.png',
            ),
        'QG' =>
            array(
                'code' => 'QG',
                'name' => 'Citilink',
                'icon' => 'QG.png',
            ),
        'QR' =>
            array(
                'code' => 'QR',
                'name' => 'QATAR AIRLINES',
                'icon' => 'QR.png',
            ),
        'QZ' =>
            array(
                'code' => 'QZ',
                'name' => 'AirAsia',
                'icon' => 'QZ.png',
            ),
        'SJ' =>
            array(
                'code' => 'SJ',
                'name' => 'Sriwijaya Air',
                'icon' => 'SJ.png',
            ),
        'SL' =>
            array(
                'code' => 'SL',
                'name' => 'Thai Lion air',
                'icon' => 'SL.png',
            ),
        'SQ' =>
            array(
                'code' => 'SQ',
                'name' => 'SINGAPORE AIRLINES',
                'icon' => 'SQ.png',
            ),
        'SV' =>
            array(
                'code' => 'SV',
                'name' => 'SAUDIA',
                'icon' => 'SV.png',
            ),
        'TG' =>
            array(
                'code' => 'TG',
                'name' => 'THAI',
                'icon' => 'TG.png',
            ),
        'TK' =>
            array(
                'code' => 'TK',
                'name' => 'TURKISH AIRLINES',
                'icon' => 'TK.png',
            ),
        'TL' =>
            array(
                'code' => 'TL',
                'name' => 'airnorth',
                'icon' => 'TL.png',
            ),
        'TR' =>
            array(
                'code' => 'TR',
                'name' => 'tigerair',
                'icon' => 'TR.png',
            ),
        'TZ' =>
            array(
                'code' => 'TZ',
                'name' => 'scoot',
                'icon' => 'TZ.png',
            ),
        'VY' =>
            array(
                'code' => 'VY',
                'name' => 'vueling',
                'icon' => 'VY.png',
            ),
        'XJ' =>
            array(
                'code' => 'XJ',
                'name' => 'AirAsia',
                'icon' => 'XJ.png',
            ),
        'XT' =>
            array(
                'code' => 'XT',
                'name' => 'AirAsia',
                'icon' => 'XT.png',
            ),
        'Z2' =>
            array(
                'code' => 'Z2',
                'name' => 'ZestAir',
                'icon' => 'Z2.png',
            )
    ];
    return $airline[$airline_code];
}

function acName($code)
{
    $ac = [
        'SJ' => 'Sriwijaya Air',
        'GA' => 'Garuda Indonesia',
        'QZ' => 'AirAsia',
        'QG' => 'Citilink',
        'XN' => 'Xpress Air',
        'KD' => 'Kalstar Aviation',
        'JT' => 'Lion Air',
        'MV' => 'Transnusa',
        '8B' => 'Transnusa',
        'IL' => 'Trigana Air',
        'ID' => 'Batik Air',
        'IW' => 'Wings Air',
        'IN' => 'NAM Air',
        'XT' => 'AirAsia',
        '3K' => 'Jetstar',
        'AA' => 'American Airlines',
        'AK' => 'AirAsia',
        'BA' => 'BRITISH AIRWAYS',
        'CI' => 'CHINA AIRLINES',
        'CX' => 'CHATAY PACIFIC',
        'CZ' => 'CHINA SOUTHEN',
        'D7' => 'AirAsia',
        'EK' => 'Emirates',
        'EY' => 'ETIHAD AIRWAYS',
        'FD' => 'AirAsia',
        'I5' => 'AirAsia',
        'JL' => 'JAPAN AIRLINES',
        'JQ' => 'Jetstart',
        'KE' => 'KOREAN AIR',
        'KL' => 'KLM',
        'MH' => 'malaysia airlines',
        'MI' => 'SILKAIR',
        'NH' => 'ANA',
        'OD' => 'malindo air',
        'QF' => 'QANTAS',
        'QR' => 'QATAR AIRLINES',
        'SL' => 'Thai Lion air',
        'SQ' => 'SINGAPORE AIRLINES',
        'SV' => 'SAUDIA',
        'TG' => 'THAI',
        'TK' => 'TURKISH AIRLINES',
        'TL' => 'airnorth',
        'TR' => 'tigerair',
        'TZ' => 'scoot',
        'VY' => 'vueling',
        'XJ' => 'AirAsia',
        'Z2' => 'ZestAir'
    ];
    return $ac[$code];
}

function getAirlinesClass($flightNumber, $subclass)
{
    $ac = getAC($flightNumber);
    $class = [
        'SJ' => [
            'C' => 'Business',
            'D' => 'Business',
            'I' => 'Business',

            'Y' => 'Economy',
            'S' => 'Economy',
            'W' => 'Economy',
            'B' => 'Economy',
            'H' => 'Economy',
            'K' => 'Economy',
            'L' => 'Economy',
            'M' => 'Economy',
            'N' => 'Economy',
            'Q' => 'Economy',
            'T' => 'Economy',
            'V' => 'Economy',
            'G' => 'Economy',
            'E' => 'Economy',

            'X' => 'Promo',
            'U' => 'Promo',
            'O' => 'Promo'
        ],
        'GA' => [
            'F' => 'First',
            'A' => 'First',

            'J' => 'Business',
            'C' => 'Business',
            'D' => 'Business',
            'I' => 'Business',

            'Y' => 'Economy',
            'B' => 'Economy',
            'M' => 'Economy',
            'K' => 'Economy',
            'N' => 'Economy',
            'Q' => 'Economy',
            'T' => 'Economy',

            // buat manual
            'O' => 'Economy',
            //

            'V' => 'Promo',
            'S' => 'Promo',
            'H' => 'Promo',
            'L' => 'Promo',

        ],
        'QZ' => [
            'YF' => 'First',
            'ZF' => 'First',

            'Y' => 'Economy',
            'I' => 'Economy',
            'M' => 'Economy',
            'Q' => 'Economy',
            'T' => 'Economy',
            'U' => 'Economy',
            'L' => 'Economy',
            'P' => 'Economy',
            'V' => 'Economy',
            'A' => 'Economy',
            'O' => 'Economy',
            'E' => 'Economy',

            'I' => 'Promo',
            'Z' => 'Promo'
        ],
        'QG' => [
            'A' => 'Economy',
            'B' => 'Economy',
            'D' => 'Economy',
            'E' => 'Economy',
            'F' => 'Economy',
            'G' => 'Economy',
            'H' => 'Economy',
            'I' => 'Economy',
            'K' => 'Economy',
            'L' => 'Economy',
            'M' => 'Economy',
            'N' => 'Economy',
            'O' => 'Economy',
            'P' => 'Economy',
            'Q' => 'Economy',
            'R' => 'Economy',
            'S' => 'Economy',

            'Z' => 'Promo'
        ],
        'XN' => [

        ],
        'KD' => [
            'Y' => 'Economy',

            'X' => 'Economy',
            'W' => 'Economy',
            'V' => 'Economy',
            'A' => 'Economy',
            'B' => 'Economy',
            'C' => 'Economy',
            'D' => 'Economy',
            'E' => 'Economy',
            'F' => 'Economy',
            'G' => 'Economy',
            'H' => 'Economy',
            'I' => 'Economy',
            'J' => 'Economy',
            'Z' => 'Economy',
            'R' => 'Economy',
            'Q' => 'Economy',
            'K' => 'Economy',
            'L' => 'Economy',
            'M' => 'Economy',
            'N' => 'Economy',

            // buat manual
            'O' => 'Economy',
            //
        ],
        'JT' => [
            'C' => 'Business',
            'J' => 'Business',
            'D' => 'Business',
            'I' => 'Business',
            'Z' => 'Business',

            'Y' => 'Economy',
            'A' => 'Economy',
            'G' => 'Economy',
            'W' => 'Economy',
            'S' => 'Economy',
            'B' => 'Economy',
            'H' => 'Economy',
            'K' => 'Economy',
            'L' => 'Economy',
            'M' => 'Economy',
            'N' => 'Economy',
            'Q' => 'Economy',

            'T' => 'Promo',
            'V' => 'Promo',
            'X' => 'Promo',
            'R' => 'Promo',
            'O' => 'Promo',
            'U' => 'Promo'
        ],
        'MV' => [
            'Y' => 'Economy',
            'S' => 'Economy',
            'W' => 'Economy',
            'B' => 'Economy',
            'H' => 'Economy',
            'I' => 'Economy',
            'K' => 'Economy',
            'L' => 'Economy',
            'M' => 'Economy',
            'N' => 'Economy',
            'Q' => 'Economy',
            'T' => 'Economy',
            'V' => 'Economy',
            'G' => 'Economy',
            'E' => 'Economy',

            'X' => 'Promo',
            'U' => 'Promo',
            'O' => 'Promo'
        ],
        'IL' => [
            'Y' => 'Economy',
            'X' => 'Economy',
            'W' => 'Economy',
            'V' => 'Economy',
            'A' => 'Economy',
            'B' => 'Economy',
            'C' => 'Economy',
            'D' => 'Economy',
            'E' => 'Economy',
            'F' => 'Economy',
            'G' => 'Economy',
            'H' => 'Economy',
            'I' => 'Economy',
            'J' => 'Economy',
            'Z' => 'Economy',

            // buat manual

            'O' => 'Economy',
            //
        ]
    ];
    if (isset($class[$ac][$subclass])){
        return $class[$ac][$subclass];
    } else {
        return 'Economy';
    }
}

function v4() {
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

        // 32 bits for "time_low"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),

        // 16 bits for "time_mid"
        mt_rand(0, 0xffff),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand(0, 0x0fff) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand(0, 0x3fff) | 0x8000,

        // 48 bits for "node"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}
