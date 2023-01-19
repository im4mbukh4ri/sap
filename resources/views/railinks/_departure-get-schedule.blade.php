<?php
$indexFare=0;
?>
  @foreach($trains['Fares'] as $val => $train)

    <div class="row-rincian row-rincian-berangkat dep{{$trains['TrainNo'].$indexDep.$indexFare}} dep" data-price="{{$train['TotalFare']}}" data-time="{{strtotime($trains['ETD'])}}">
      <span class="resultDep" style="display: none;">{{json_encode($result)}}</span>
      <span class="selectedIDdep" style="display: none;">{{$train['selectedIDdep']}}</span>
      <span class="indexDep" style="display: none;">{{$indexDep}}</span>
      <span class="indexFareDep" style="display: none;">{{$indexFare}}</span>
        <div class="items" @if((int)$train['SeatAvb']<1)style="cursor:not-allowed"@endif>
            <div class="label-circle inline-bl">
                <div class="circle-select"><i class="glyphicon glyphicon-ok"></i></div>
            </div>
            <div class="label-rincian inline-bl">
                <div class="row-rin">
                    <img class="logoFlight-from" style="height: 50px;width: auto;" src="{{asset('/assets/logo/railink.png')}}" alt="logo-railink">
                    <span class="code-penerbangan codeFrom">{{$trains['TrainName']}} - {{$trains['TrainNo']}}</span>
                </div>
                <div class="row-rin">
                    <div class="timeblock">
                        <h4 class="timeFrom">{{date('H:i',strtotime($trains['ETD']))}}</h4>
                        <p class="cityFrom">{{$origin->city}}</p>
                    </div>
                    <div class="timeblock">
                        <h4 class="timeFin">{{date('H:i',strtotime($trains['ETA']))}}</h4>
                        <p class="cityFin">{{$destination->city}}</p>
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
              <h3 class="harga-real">IDR <span class="totalFare"> {{number_format($train['TotalFare'])}}</span> </h3>
            </div>
        </div>
    </div>
    @if((int)$train['SeatAvb']>0)
      <script>
      function setDefaultValueDep(){
          if(!defaultValueDep){
              defaultValueDep=true;
              var timeFrom = $(".dep{{$trains['TrainNo'].$indexDep.$indexFare}}").find( ".timeFrom" ).text();
              var timeFin = $(".dep{{$trains['TrainNo'].$indexDep.$indexFare}}").find( ".timeFin" ).text();
              var FlightDate = $(".dep{{$trains['TrainNo'].$indexDep.$indexFare}}").find(".FlightDateDep0").text();
              var codeFrom = $(".dep{{$trains['TrainNo'].$indexDep.$indexFare}}").find( ".codeFrom" ).text();
              var cityFrom = $(".dep{{$trains['TrainNo'].$indexDep.$indexFare}}").find(".cityFrom").text();
              var cityFin=$(".dep{{$trains['TrainNo'].$indexDep.$indexFare}}").find(".cityFin").text();
              var logoFlight = $(".dep{{$trains['TrainNo'].$indexDep.$indexFare}}").find(".logoFlight-from").attr('src');
              var resultDep=$(".dep{{$trains['TrainNo'].$indexDep.$indexFare}}").find(".resultDep").text();
              var selectedIDdep=$(".dep{{$trains['TrainNo'].$indexDep.$indexFare}}").find(".selectedIDdep").text();
              var indexTrainDep=$(".dep{{$trains['TrainNo'].$indexDep.$indexFare}}").find(".indexDep").text();
              var indexFareDep=$(".dep{{$trains['TrainNo'].$indexDep.$indexFare}}").find(".indexFareDep").text();
              var stringTotalFareDep=$(".dep{{$trains['TrainNo'].$indexDep.$indexFare}}").find(".totalFare").text();
              var totalFareDep=parseFloat(stringTotalFareDep.replace(/,/g,''));
              var totalFareRet=parseFloat($("#totalFareRet").val());
              var totalFare=totalFareDep+totalFareRet;
              $("#totalFareDep").val(totalFareDep);
              $("#selectedIDdep").val(selectedIDdep);
              $("#indexTrainDep").val(indexTrainDep);
              $("#indexFareDep").val(indexFareDep);
              $("#resultDep").val(resultDep);
              $( ".result-berangkat .timeFrom-top" ).html( timeFrom );
              $( ".result-berangkat .cityFrom-top" ).html( cityFrom );
              $( ".result-berangkat .cityFin-top" ).html( cityFin );
              $( ".result-berangkat .timeFin-top" ).html( timeFin );
              $( ".result-berangkat .FlightDate" ).html( FlightDate );
              $( ".result-berangkat .codeFrom-top" ).html( codeFrom );
              $( ".result-berangkat .logoFlightFrom-top").attr("src", logoFlight);
              $( ".price-summary .totalFare").html(addCommas(totalFare));
              $("#chooseFlight").show();
          }
      }
      setDefaultValueDep();
      $(".dep{{$trains['TrainNo'].$indexDep.$indexFare}}").click(function (e) {
        if (!$(this).is('.actived')) {
              $(".row-rincian-berangkat").removeClass('actived');
              $(".row-rincian-berangkat").removeClass('selected');
              $(".row-rincian-berangkat").find('.items-detail:visible').slideUp("slow");
              $(this).addClass('actived');
              $(this).addClass('selected');
              $(this).find('.items-detail ').slideDown("slow");
              $(this).find('.items-detail ').addClass("actived");
              var timeFrom = $(this).find( ".timeFrom" ).text();
              var timeFin = $(this).find( ".timeFin" ).text();
              var FlightDate = $(this).find(".FlightDateDep0").text();
              var codeFrom = $(this).find( ".codeFrom" ).text();
              var cityFrom=$(this).find(".cityFrom").text();
              var cityFin=$(this).find(".cityFin").text();
              var logoFlight = $(this).find(".logoFlight-from").attr('src');
              var resultDep=$(this).find(".resultDep").text();
              var selectedIDdep=$(this).find(".selectedIDdep").text();
              var indexTrainDep=$(".dep{{$trains['TrainNo'].$indexDep.$indexFare}}").find(".indexDep").text();
              var indexFareDep=$(".dep{{$trains['TrainNo'].$indexDep.$indexFare}}").find(".indexFareDep").text();
              var stringTotalFareDep=$(this).find(".totalFare").text();
              var totalFareDep=parseFloat(stringTotalFareDep.replace(/,/g,''));
              var totalFareRet=parseFloat($("#totalFareRet").val());
              var totalFare=totalFareDep+totalFareRet;
              $("#totalFareDep").val(totalFareDep);
              $("#selectedIDdep").val(selectedIDdep);
              $("#indexTrainDep").val(indexTrainDep);
              $("#indexFareDep").val(indexFareDep);
              $("#resultDep").val(resultDep);
              $( ".result-berangkat .timeFrom-top" ).html( timeFrom );
              $( ".result-berangkat .timeFin-top" ).html( timeFin );
              $( ".result-berangkat .FlightDate" ).html( FlightDate );
              $( ".result-berangkat .codeFrom-top" ).html( codeFrom );
              $( ".result-berangkat .cityFrom-top" ).html( cityFrom );
              $( ".result-berangkat .cityFin-top" ).html( cityFin );
              $( ".result-berangkat .logoFlightFrom-top").attr("src", logoFlight);
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
