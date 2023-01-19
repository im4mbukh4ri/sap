<?php

namespace App\Http\Controllers\Rest;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class RestWebcheckinController extends Controller
{
    public function index(){
      return Response::json([
        'notes' => [
          'Web check in untuk Air Asia bisa dilakukan 14 hari sebelum keberangkatan dan akan ditutup 4 jam sebelum waktu keberangkatan.',
          'Web check in untuk Citilink bisa dilakukan 07 hari sebelum keberangkatan dan akan ditutup 24 jam sebelum waktu keberangkatan.',
          'Web check in untuk Lion Air, Batik Air, Garuda hanya bisa dilakukan paling cepat 24 jam sebelum keberangkatan dan akan ditutup 4 jam sebelum waktu keberangkatan.',
          'Apabila mengalami kegagalan pada saat check-in yang disebabkan sistem airline yang sedang kurang stabil ataupun jaringan internet, maka check in dilakukan di bandara.',
          'Tiket yang sudah melakukan check in tidak dapat di refund ataupun rebook (tiket hangus).',
          'Setelah melakukan web check in penumpang diharuskan hadir dibandara minimal 1 jam sebelum keberangkatan.'
        ],
        'checkin_lists'=>[
          [
            'name' => 'AirAsia',
            'url_image' => asset('/assets/images/airlines/AK.png'),
            'url_web' => 'https://checkin.airasia.com',
            'url_tutorial' => 'https://youtu.be/3tpWPvW9A-k'
          ],
          [
            'name' => 'Batik Air',
            'url_image' => asset('/assets/images/airlines/ID.png'),
            'url_web' => 'https://wci-prod.sabresonicweb.com/SSW2010/IDC0/checkin.html?execution=e2s1',
            'url_tutorial' => 'https://youtu.be/E8bmI60im68'
          ],
          [
            'name' => 'Citilink',
            'url_image' => asset('/assets/images/airlines/QG.png'),
            'url_web' => 'https://book.citilink.co.id/SearchWebCheckin.aspx',
            'url_tutorial' => 'https://youtu.be/1-D1hU_sIbw'
          ],
          [
            'name' => 'Garuda',
            'url_image' => asset('/assets/images/airlines/GA.png'),
            'url_web' => 'https://checkin.si.amadeus.net/1ASIHSSCWEBGA/sscwga/checkin?ln=id',
            'url_tutorial' => 'https://youtu.be/29dejT-B5Dw'
          ],
          [
            'name' => 'Lion Air',
            'url_image' => asset('/assets/images/airlines/JT.png'),
            'url_web' => 'https://wci-prod.sabresonicweb.com/SSW2010/JTC0/checkin.html?execution=e2s1',
            'url_tutorial' => 'https://youtu.be/-RiJMj04jNU'
          ],
          [
            'name' => 'Sriwijaya',
            'url_image' => asset('/assets/images/airlines/SJ.png'),
            'url_web' => 'https://webcheckin.sriwijayaair.co.id/webcheckin/',
            'url_tutorial' => 'https://youtu.be/9RsvZ4DMpQ8'
          ],
        ]
      ]);
    }
}
