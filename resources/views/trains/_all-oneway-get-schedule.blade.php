@foreach($result['schedule']['departure'] as $key => $trains)
  @foreach($trains['Fares'] as $val => $train)
    {!! Form::open(['route'=>'trains.booking_form','method'=>'post','id'=>$train['selectedIDdep']]) !!}
    {!! Form::hidden('indexTrain',$key) !!}
    {!! Form::hidden('indexFare',$val) !!}
    {!! Form::hidden('selectedIDdep',$train['selectedIDdep']) !!}
    {!! Form::hidden('result',json_encode($result)) !!}
    {!! Form::close() !!}
    <div class="row-rincian row-rincian-berangkat dep" data-price="{{$train['TotalFare']}}" data-time="{{strtotime($trains['ETD'])}}">
        <div class="items">
            <div class="label-circle inline-bl">
                <div class="circle-select"><i class="glyphicon glyphicon-ok"></i></div>
            </div>
            <div class="label-rincian inline-bl">
                <div class="row-rin">
                    <img class="logoFlight-from" style="height: auto;width: 125px;" src="{{asset('/assets/logo/kai.png')}}" alt="logo-kai">
                    <span class="code-penerbangan codeFrom">{{$trains['TrainName']}} - {{$trains['TrainNo']}}</span>
                </div>
                <div class="row-rin">
                    <div class="timeblock">
                        <h4 class="timeFrom">{{date('H:i',strtotime($trains['ETD']))}}</h4>
                        <p class="cityFrom">{{$origin->city}} - {{$origin->name}}</p>
                    </div>
                    <div class="timeblock">
                        <h4 class="timeFin">{{date('H:i',strtotime($trains['ETA']))}}</h4>
                        <p class="cityFin">{{$destination->city}} - {{$destination->name}}</p>
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
                        <p>{{$train['Class']}} ({{$train['SubClass']}})</p>
                    </div>
                </div>
            </div>
            <div class="label-detail-harga inline-bl">
              <h3 class="harga-real">IDR {{number_format($train['TotalFare'])}} </h3>
            </div>
            <div class="action-rincian inline-bl">
              @if((int)$train['SeatAvb']>0)
                <a class="block-btn block-blue" href="{{route('trains.booking_form')}}" data-toggle="tooltip" data-placement="top" title="Sisa tempat duduk : {{$train['SeatAvb']}}" onclick="event.preventDefault();document.getElementById('{{$train['selectedIDdep']}}').submit();">PESAN SEKARANG</a>
              @else
                <a class="block-btn block-orange" href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="HABIS">HABIS</a>
              @endif
            </div>
        </div>
    </div>
  @endforeach
    <!-- END -->
@endforeach
