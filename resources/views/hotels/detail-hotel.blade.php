@extends('layouts.public')
@section('css')
    @parent

@endsection
@section('content')
<!-- STEP BOOKING -->
    <div id="step-booking">
        <div class="container">
            <ul class="breadcrumb-step">
                <li class="done">
                    <a href="javascript:void(0)">
                        1. Pilih Hotel
                    </a>
                </li>
                <li class="active">
                    <a href="javascript:void(0)">
                        2. Pilih Kamar & Isi Data
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        3. Konfirmasi
                    </a>
                </li>
            </ul>
        </div><!--end.container-->
    </div><!--end.stepbooking-->
    <section class="slider-detail-hotel">
      <div class="container">
        <div class="row">
          <div class="col-md-10 col-sm-8">
            <div class="galeri_detail">
              <div class="detail-slider">
                <ul class="slidegal">
                  @foreach ($hotel['details']['images'] as $key => $image)
                    <li><img src="{{$image}}" class="img-responsive" style="margin: auto;padding:10px;width:50%"/></li>
                  @endforeach
                </ul>
                <div class="custom-pager">
                  <ul class="pager-album">
                    @foreach ($hotel['details']['images'] as $key => $image)
                      <li><a data-slideIndex="{{$key}}" href=""><img src="{{$image}}" /></a></li>
                    @endforeach
                  </ul>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <h2>{{$hotel['details']['data']['name']}}</h2>
                <div class="table-responsive">
                  <table class="table">
                    <tr>
                      <th>Rating</th>
                      <td>{{$hotel['details']['data']['rating']}}</td>
                    </tr>
                    <tr>
                      <th>Jumlah Kamar</th>
                      <td>{{$hotel['details']['data']['rooms']}}</td>
                    </tr>
                    <tr>
                      <th>Alamat</th>
                      <td>{{$hotel['details']['data']['address']}}</td>
                    </tr>
                    <tr>
                      <th>Email</th>
                      <td>{{$hotel['details']['data']['email']}}</td>
                    </tr>
                    <tr>
                      <th>Website</th>
                      <td><a href="{{$hotel['details']['data']['website']}}" target="_blank">{{$hotel['details']['data']['website']}}</a></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <form method="POST" action="{{route('hotels.hotel_confirmation')}}">
              {{ csrf_field() }}
              <input type="hidden" name="result" value="{{json_encode($hotel)}}" />
              <input type="hidden" name="selectedID" value="{{$hotel['selectedID']}}" />
              <div class="row">
                <h3 class="blue-title">Data Tamu Inap:</h3>
                  <div class="grey-box">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="row">
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="buyName">Title <span class="redFont">*</span></label>
                                  <select class="form-control" name="title">
                                    <<option value="MR">MR</option>
                                    <<option value="MRS">MRS</option>
                                    <<option value="MS">MISS</option>
                                  </select>
                              </div><!--end.form-grup-->
                          </div>
                          <div class="col-md-8">
                              <div class="form-group">
                                  <label for="buyName">Nama Lengkap <span class="redFont">*</span></label>
                                  <input type="text" class="form-control" name="name" autocomplete="on" onkeydown="return alphaOnly(event);" required>
                                  <p class="help-block"><i>Isi sesuai dengan KTP/Paspor/SIM(tanpa tanda baca/gelar)</i></p>
                              </div>
                        </div>
                      </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                                <label for="buyName">No. HP <span class="redFont">*</span></label>
                                <input type="number" class="form-control" name="phoneNumber" required>
                            </div><!--end.form-grup-->
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="buyName">Catatan Tambahan<span class="redFont">*</span></label>
                              <textarea name="note" rows="8" cols="80" class="form-control" placeholder="Opsional"></textarea>
                              <p class="help-block"><i>Jika ada request tambahan ke pihak hotel.</i></p>
                          </div><!--end.form-grup-->
                      </div>
                    </div>
                  </div>
                <hr />
              </div>
              @for($i=1;$i<=(int)$hotel['room'];$i++)
              <div class="row">
                <div class="col-md-12">
                  <div class="table-detail-hotel">
                    <div class="dataTable no-search">
                      <h4>Kamar ke-{{$i}}</h4>
                      <table id="data-table" class="text-center table table-striped table-bordered dt-responsive nowrap table-custom-blue" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th width="450">Tipe Kamar</th>
                            <th>Bed</th>
                            <th>Max</th>
                            <th>Keterangan</th>
                            <th>Harga</th>
                            <th>Pilih</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($hotel['details']['rooms'] as $key => $room)
                            <tr>
                              <td>{{$room['characteristic']}}</td>
                              <td>
                                @if($room['bed']=="Single")
                                   <img src="{{'/assets/images/material/single-bed.png'}}">
                                @else
                                  <img src="{{'/assets/images/material/twin-bed.png'}}">
                                @endif
                                &nbsp; {{$room['bed']}}
                              </td>
                              <td><img src="{{asset('/assets/images/material/bed-twin-ico.png')}}"></td>
                              <td>{{$room['board']}}</td>
                              <td>IDR {{number_format($room['price'])}}</td>
                              <td><input type="radio" name="bed_{{$i}}" <?=($key===0)?'checked':''?> value="{{$room['selectedIDroom']}}"/>  </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              @endfor
              <div class="row">
                <div class="col-md-12">
                  <button type="submit" class="block-btn block-blue right">Selanjutnya</button>
                </div>
              </div>
            </form>
          </div>
          <div class="col-md-2 col-sm-4">
            <div class="right-section">
              <h3 class="blue-muda-title">Fasilitas</h3>
              <div class="white-blue-box fac-box">
                <div class="fac-rows">
                  @foreach ($hotel['details']['fasilitas'] as $key => $value)
                    <div class="fac-items">
                      <i class="fa fa-check"></i>&nbsp; {{$value}}
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
            <hr />
            <div class="right-section">
                <h3 class="orange-title"><span class="small-title">Pesanan Anda</span></h3>
                <div class="white-box small-flight">
                    <div class="group-list">
                        <span class="label-infony">Check-in : </span>
                        <p class="label-detailny">{{date('d M y',strtotime($hotel['checkin']))}}</p>
                    </div>
                    <div class="group-list">
                        <span class="label-infony">Check-out : </span>
                        <p class="label-detailny">{{date('d M y',strtotime($hotel['checkout']))}}</p>
                    </div>
                    <div class="group-list">
                        <span class="label-infony">Room : </span>
                        <p class="label-detailny"><i class="fa fa-bed"></i> {{$hotel['room']}} Kamar</p>
                    </div>
                    <div class="group-list">
                        <span class="label-infony">Guest:</span>
                        <p class="label-detailny"><i class="fa fa-user"></i> {{$hotel['adt']}} Dewasa</p>
                        @if((int)$hotel['chd']>0)
                        <p class="label-detailny"><i class="fa fa-user"></i> {{$hotel['chd']}} Anak</p>
                        @endif
                    </div>
                </div><!--end.white-box-->
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection

@section('js')
    @parent
    <script>
        function alphaOnly(event) {
            var key = event.keyCode;
            return ((key >= 65 && key <= 90) || key === 8 || key === 32);
        }
    </script>
@endsection
