@extends('layouts.public')
@section('css')
    @parent
@endsection
@section('content')
    <div id="step-booking-kereta">
        <section class="section-pilih-seat">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="blue-title-big">WEB CHECK IN AIRLINE</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="content-middle">
                        <div class="col-md-12">
                            <div class="alert-custom alert alert-red alert-dismissible" role="alert">
                              <p>
                                CATATAN :<br />
                                <ol style="color: white;">
                                  <li>Web check in untuk Air Asia bisa dilakukan 14 hari sebelum keberangkatan dan akan ditutup 4 jam sebelum waktu keberangkatan.</li>
                                  <li>Web check in untuk Citilink bisa dilakukan 07 hari sebelum keberangkatan dan akan ditutup 24 jam sebelum waktu keberangkatan.</li>
                                  <li>Web check in untuk Lion Air, Batik Air, Garuda hanya bisa dilakukan paling cepat 24 jam sebelum keberangkatan dan akan ditutup 4 jam sebelum waktu keberangkatan.</li>
                                  <li>Apabila mengalami kegagalan pada saat check-in yang disebabkan sistem airline yang sedang kurang stabil ataupun jaringan internet, maka check in dilakukan di bandara.</li>
                                  <li>Tiket yang sudah melakukan check in tidak dapat di refund ataupun rebook (tiket hangus).</li>
                                  <li>Setelah melakukan web check in penumpang diharuskan hadir dibandara minimal 1 jam sebelum keberangkatan.</li>
                                </ol>
                              </p>
                            </div>
                            <table class="table">
                              <thead>
                                <tr>
                                  <td><img class="logoFlight-from" style="height: auto;width: 125px;" src="{{asset('/assets/images/airlines/AK.png')}}" alt="logo-airasia"></td>
                                  <td>Check In Ticket AirAsia<br /><small>silahkan lihat video tutorial terlebih dahulu</small></td>
                                  <td><a class="btn btn-warning" target="_blank" href="https://youtu.be/3tpWPvW9A-k">VIDEO TUTORIAL</a></td>
                                  <td><a class="btn btn-primary" target="_blank" href="https://checkin.airasia.com">CHECK IN</a></td>
                                </tr>
                                <tr>
                                  <td><img class="logoFlight-from" style="height: auto;width: 125px;" src="{{asset('/assets/images/airlines/ID.png')}}" alt="logo-airasia"></td>
                                  <td>Check In Ticket Batik Air<br /><small>silahkan lihat video tutorial terlebih dahulu</small></td>
                                  <td><a href=" https://youtu.be/E8bmI60im68" class="btn btn-warning">VIDEO TUTORIAL</a></td>
                                  <td><a class="btn btn-primary" target="_blank" href="https://wci-prod.sabresonicweb.com/SSW2010/IDC0/checkin.html?execution=e2s1">CHECK IN</a></td>
                                </tr>
                                <tr>
                                  <td><img class="logoFlight-from" style="height: auto;width: 125px;" src="{{asset('/assets/images/airlines/QG.png')}}" alt="logo-airasia"></td>
                                  <td>Check In Ticket Citilink<br /><small>silahkan lihat video tutorial terlebih dahulu</small></td>
                                  <td><a class="btn btn-warning" target="_blank" href="https://youtu.be/1-D1hU_sIbw">VIDEO TUTORIAL</a></td>
                                  <td><a class="btn btn-primary" target="_blank" href="https://book.citilink.co.id/SearchWebCheckin.aspx">CHECK IN</a></td>
                                </tr>
                                <tr>
                                  <td><img class="logoFlight-from" style="height: auto;width: 125px;" src="{{asset('/assets/images/airlines/GA.png')}}" alt="logo-airasia"></td>
                                  <td>Check In Ticket Garuda Indonesia<br /><small>silahkan lihat video tutorial terlebih dahulu</small></td>
                                  <td><a class="btn btn-warning" target="_blank" href=" https://youtu.be/29dejT-B5Dw">VIDEO TUTORIAL</a></td>
                                  <td><a class="btn btn-primary" target="_blank" href="https://checkin.si.amadeus.net/1ASIHSSCWEBGA/sscwga/checkin?ln=id">CHECK IN</a></td>
                                </tr>
                                <tr>
                                  <td><img class="logoFlight-from" style="height: auto;width: 125px;" src="{{asset('/assets/images/airlines/JT.png')}}" alt="logo-airasia"></td>
                                  <td>Check In Ticket Lion Air<br /><small>silahkan lihat video tutorial terlebih dahulu</small></td>
                                  <td><a  class="btn btn-warning" target="_blank" href="https://youtu.be/-RiJMj04jNU">VIDEO TUTORIAL</a></td>
                                  <td><a class="btn btn-primary" target="_blank" href="https://wci-prod.sabresonicweb.com/SSW2010/JTC0/checkin.html?execution=e2s1">CHECK IN</a></td>
                                </tr>
                                <tr>
                                  <td><img class="logoFlight-from" style="height: auto;width: 125px;" src="{{asset('/assets/images/airlines/SJ.png')}}" alt="logo-airasia"></td>
                                  <td>Check In Ticket Sriwijaya<br /><small>silahkan lihat video tutorial terlebih dahulu</small></td>
                                  <td><a href="https://youtu.be/9RsvZ4DMpQ8" class="btn btn-warning">VIDEO TUTORIAL</a></td>
                                  <td><a class="btn btn-primary" target="_blank" href="https://webcheckin.sriwijayaair.co.id/webcheckin/">CHECK IN</a></td>
                                </tr>
                              </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('js')
    @parent
@endsection
