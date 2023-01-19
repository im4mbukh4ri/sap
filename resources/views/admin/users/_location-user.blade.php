<div class="panel panel-primary panel-click">
    <div class="panel-heading">
        <h3 class="panel-title">Location Member</h3>
    </div>
    @if($user->type_user_id === 4)
    <?php
    $android = $user->user_location_android()->first();
    $ios = $user->user_location_ios()->first();
    // dd($ios->lat);
    ?>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-1">

            </div>
            <div class="col-md-11">
                @if(false)
                <form action="{{ route('admin.users_shareloc',$user) }}" method="POST">
                    <div class="row">
                        <div class="col-md-2">
                            <label>Device</label>
                        </div>
                        <div class="col-md-5">
                            <label>Share Location</label>
                        </div>
                        <div class="col-md-5">
                            <label>Show on Map</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Android</label>
                        </div>
                        <div class="col-md-5">
                          @if($android)
                            <input type="radio" name="location_android" value=1 {{$android->share_location == '1' ? 'checked' : '' }}> Ya &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="location_android" value=0 {{$android->share_location == '0' ? 'checked' : '' }}> Tidak
                          @else
                            Member harus login di Android terlebih dahulu
                          @endif
                        </div>
                        <div class="col-md-5">
                          @if($android)
                            <input type="radio" name="show_on_map_android" value=1 {{$android->show_on_map == '1' ? 'checked' : '' }}> Ya &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="show_on_map_android" value=0 {{$android->show_on_map == '0' ? 'checked' : '' }}> Tidak
                          @else
                            Member harus login di Android terlebih dahulu
                          @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label>IOS</label> <br>
                        </div>
                        <div class="col-md-5">
                          @if($ios)
                            <input type="radio" name="location_ios" value=1 {{$ios->share_location == '1' ? 'checked' : '' }}> Ya &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="location_ios" value=0 {{$ios->share_location == '0' ? 'checked' : '' }}> Tidak
                          @else
                            Member harus login di IOS terlebih dahulu
                          @endif
                        </div>
                        <div class="col-md-5">
                          @if($ios)
                            <input type="radio" name="show_on_map_ios" value=1 {{$ios->show_on_map == '1' ? 'checked' : '' }}> Ya &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="show_on_map_ios" value=0 {{$ios->show_on_map == '0' ? 'checked' : '' }}> Tidak
                          @else
                            Member harus login di IOS terlebih dahulu
                          @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Keterangan</label>
                        </div>
                        <div class="col-md-5">
                            Untuk mengirimkan lokasi Anda ke sistem
                        </div>
                        <div class="col-md-5">
                            Untuk menampilkan lokasi Anda di map
                        </div>
                    </div>
                    @if($android !==null || $ios !==null )
                    <div class="row">
                        <br>
                        {{ Form::hidden('password','',['class'=> 'password'])  }}
                        <button type="submit" class="btn btn-blue js-submit-autopost">Simpan Perubahan</button>
                    </div>
                    @endif
                    <div class="row">
                      <br>
                    </div>
                    <div class="row">
                      <br>
                    </div>
                </form>
                @endif
                <div class="row">
                    <div class="col-md-2">
                        <label>Map</label>
                    </div>
                    <div class="col-md-5">
                        @if($android !==null)
                          @if($android->lat !== null && $android->lng !== null && $android->lat !== 0 && $android->lng !== 0)
                            <button onclick="initMapA()">Show Android</button>
                          @else
                            Lokasi Member di Android belum tersimpan ke sistem
                          @endif
                        @else
                          Member harus login di Android terlebih dahulu
                        @endif
                    </div>
                    <div class="col-md-5">
                        @if($ios !==null)
                          @if($ios->lat !== null && $ios->lng !== null && $ios->lat !== 0 && $ios->lng !== 0 && $ios->lat !== "0" && $ios->lng !== "0" && $ios->lat !== "0.000000" && $ios->lng !== "0.000000")
                            <button onclick="initMapI()">Show IOS</button>
                          @else
                            Lokasi Member di IOS belum tersimpan ke sistem
                          @endif
                        @else
                          Member harus login di IOS terlebih dahulu
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-5">
                        <br>
                    </div>
                    <div class="col-md-5">
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-5">
                        <div id="android" style="width:100%;height:380px;"></div>
                    </div>
                    <div class="col-md-5">
                        <div id="ios" style="width:100%;height:380px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="panel-body">
      Tidak ada Konfigurasi Member
    </div>
    @endif
    <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC61esshu5HGWfb2K1pVHGNpKcm5i65HiA">
    </script>
    @if($user->type_user_id === 4 && $android)
    <script>
      function initMapA() {
        var uluru = {lat: {{$android->lat}}, lng: {{$android->lng}}};
        var map = new google.maps.Map(document.getElementById('android'), {
          zoom: 15,
          center: uluru
        });
        var marker = new google.maps.Marker({
          position: uluru,
          map: map
        });
      }
    </script>
    @endif
    @if($user->type_user_id === 4 && $ios)
    <script>
      function initMapI() {
        var uluru = {lat: {{$ios->lat}}, lng: {{$ios->lng}}};
        var map = new google.maps.Map(document.getElementById('ios'), {
          zoom: 15,
          center: uluru
        });
        var marker = new google.maps.Marker({
          position: uluru,
          map: map
        });
      }
    </script>
    @endif
</div>
