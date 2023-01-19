<?php
$indexFare=0;
?>
  @foreach($trains['Fares'] as $val => $train)

    <div class="row-rincian row-rincian-pulang ret{{$trains['TrainNo'].$indexRet.$indexFare}} ret" data-price="{{$train['TotalFare']}}" data-time="{{strtotime($trains['ETD'])}}">
      <span class="selectedIDret" style="display: none;">{{$train['selectedIDret']}}</span>
      <span class="indexRet" style="display: none;">{{$indexRet}}</span>
      <span class="indexFareRet" style="display: none;">{{$indexFare}}</span>
        <div class="items" @if((int)$train['SeatAvb']<1)style="cursor:not-allowed"@endif>
            <div class="label-circle inline-bl">
                <div class="circle-select"><i class="glyphicon glyphicon-ok"></i></div>
            </div>
            <div class="label-rincian inline-bl">
                <div class="row-rin">
                    <img class="logoFlight-from" style="height: 50px;width: auto;" src="{{asset('/assets/logo/kai.png')}}" alt="logo-kai">
                    <span class="code-penerbangan codeFrom">{{$trains['TrainName']}} - {{$trains['TrainNo']}}</span>
                </div>
                <div class="row-rin">
                    <div class="timeblock">
                        <h4 class="timeFrom">{{date('H:i',strtotime($trains['ETD']))}}</h4>
                        <p class="cityFrom">{{$destination->city}}</p>
                    </div>
                    <div class="timeblock">
                        <h4 class="timeFin">{{date('H:i',strtotime($trains['ETA']))}}</h4>
                        <p class="cityFin">{{$origin->city}}</p>
                    </div>
                    <div class="timeblock">
                        <?php
                        $etd=\Carbon\Carbon::createFromFormat('Y-m-d H:i', $trains['ETD']);
                        $eta=\Carbon\Carbon::createFromFormat('Y-m-d H:i', $trains['ETA']);
                        $h=$etd->diffInHours($eta, false);
                        $m=$etd->addHours($h)->diffInMinutes($eta, false);
                        $hShow= $h!="0"?$h.' jam':'';
                        $mShow= $m!="0"?$m.' mnt':'';
                        $showTime=$hShow.' '.$mShow;
                        ?>
                        <h4>{{$showTime}}</h4>
                    </div>
                </div>
            </div>
            <div class="label-detail-harga inline-bl" style="padding:15px 15px;">
              <span>{{$train['Class']}} ({{$train['SubClass']}})</span><br />
              @if($train['SeatAvb']>0)
                <span>Sisa {{$train['SeatAvb']}} kursi</span>
              @else
                <strong><span style="color:red;">HABIS</span></strong>
              @endif
              <hr />
              <h3 class="harga-real">IDR <span class="totalFare">{{number_format($train['TotalFare'])}}</span> </h3>
            </div>
        </div>
    </div>

    @if((int)$train['SeatAvb']>0)
      <script>
      function setDefaultValueRet(){
          if(!defaultValueRet){
              defaultValueRet=true;
              var timeFrom = $(".ret{{$trains['TrainNo'].$indexRet.$indexFare}}").find( ".timeFrom" ).text();
              var timeFin = $(".ret{{$trains['TrainNo'].$indexRet.$indexFare}}").find( ".timeFin" ).text();
              var FlightDate = $(".ret{{$trains['TrainNo'].$indexRet.$indexFare}}").find(".FlightDateRet0").text();
              var codeFrom = $(".ret{{$trains['TrainNo'].$indexRet.$indexFare}}").find( ".codeFrom" ).text();
              var cityFrom = $(".ret{{$trains['TrainNo'].$indexRet.$indexFare}}").find(".cityFrom").text();
              var cityFin=$(".ret{{$trains['TrainNo'].$indexRet.$indexFare}}").find(".cityFin").text();
              var logoFlight = $(".ret{{$trains['TrainNo'].$indexRet.$indexFare}}").find(".logoFlight-from").attr('src');
              var selectedIDret=$(".ret{{$trains['TrainNo'].$indexRet.$indexFare}}").find(".selectedIDret").text();
              var indexTrainRet=$(".ret{{$trains['TrainNo'].$indexRet.$indexFare}}").find(".indexRet").text();
              var indexFareRet=$(".ret{{$trains['TrainNo'].$indexRet.$indexFare}}").find(".indexFareRet").text();
              var stringTotalFareRet=$(".ret{{$trains['TrainNo'].$indexRet.$indexFare}}").find(".totalFare").text();
              var totalFareRet=parseFloat(stringTotalFareRet.replace(/,/g,''));
              var totalFareDep=parseFloat($("#totalFareDep").val());
              var totalFare=totalFareDep+totalFareRet;
              $("#totalFareRet").val(totalFareRet);
              $("#selectedIDret").val(selectedIDret);
              $("#indexTrainRet").val(indexTrainRet);
              $("#indexFareRet").val(indexFareRet);
              $( ".result-pulang .timeFrom-top" ).html( timeFrom );
              $( ".result-pulang .cityFrom-top" ).html( cityFrom );
              $( ".result-pulang .cityFin-top" ).html( cityFin );
              $( ".result-pulang .timeFin-top" ).html( timeFin );
              $( ".result-pulang .FlightDate" ).html( FlightDate );
              $( ".result-pulang .codeFrom-top" ).html( codeFrom );
              $( ".result-pulang .logoFlightFrom-top").attr("src", logoFlight);
              $( ".price-summary .totalFare").html(addCommas(totalFare));
              $("#chooseFlight").show();
          }
      }
      setDefaultValueRet();
      $(".ret{{$trains['TrainNo'].$indexRet.$indexFare}}").click(function (e) {
        if (!$(this).is('.actived')) {
              $(".row-rincian-pulang").removeClass('actived');
              $(".row-rincian-pulang").removeClass('selected');
              $(".row-rincian-pulang").find('.items-detail:visible').slideUp("slow");
              $(this).addClass('actived');
              $(this).addClass('selected');
              $(this).find('.items-detail ').slideDown("slow");
              $(this).find('.items-detail ').addClass("actived");
              var timeFrom = $(this).find( ".timeFrom" ).text();
              var timeFin = $(this).find( ".timeFin" ).text();
              var FlightDate = $(this).find(".FlightDateRet0").text();
              var codeFrom = $(this).find( ".codeFrom" ).text();
              var cityFrom=$(this).find(".cityFrom").text();
              var cityFin=$(this).find(".cityFin").text();
              var logoFlight = $(this).find(".logoFlight-from").attr('src');
              var selectedIDret=$(this).find(".selectedIDret").text();
              var indexTrainRet=$(".ret{{$trains['TrainNo'].$indexRet.$indexFare}}").find(".indexRet").text();
              var indexFareRet=$(".ret{{$trains['TrainNo'].$indexRet.$indexFare}}").find(".indexFareRet").text();
              var stringTotalFareRet=$(this).find(".totalFare").text();
              var totalFareRet=parseFloat(stringTotalFareRet.replace(/,/g,''));
              var totalFareDep=parseFloat($("#totalFareDep").val());
              var totalFare=totalFareDep+totalFareRet;
              $("#totalFareRet").val(totalFareRet);
              $("#selectedIDret").val(selectedIDret);
              $("#indexTrainRet").val(indexTrainRet);
              $("#indexFareRet").val(indexFareRet);
              $( ".result-pulang .timeFrom-top" ).html( timeFrom );
              $( ".result-pulang .timeFin-top" ).html( timeFin );
              $( ".result-pulang .FlightDate" ).html( FlightDate );
              $( ".result-pulang .codeFrom-top" ).html( codeFrom );
              $( ".result-pulang .cityFrom-top" ).html( cityFrom );
              $( ".result-pulang .cityFin-top" ).html( cityFin );
              $( ".result-pulang .logoFlightFrom-top").attr("src", logoFlight);
              $( ".price-summary .totalFare").html(addCommas(totalFare));
            } else {
                $(this).removeClass('actived');
            }
      });
      </script>
    @endif
    <?php
    $indexFare++;
    ?>
  @endforeach
