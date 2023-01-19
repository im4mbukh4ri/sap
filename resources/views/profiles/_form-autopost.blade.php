<div class="panel panel-primary panel-click">
    <div class="panel-heading">
        <h3 class="panel-title">Konfigurasi Member</h3>
    </div>
    @if($user->type_user_id === 4)
    <?php
$android = $user->user_location_android()->first();
$ios = $user->user_location_ios()->first();
?>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-2">
                <h5>Location</h5>
            </div>
            <div class="col-md-10">
                <form action="{{ route('profiles.location_share',$user) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-2">
                            <label>Device</label>
                        </div>
                        <div class="col-md-4">
                            <label>Share Location</label>
                        </div>
                        <div class="col-md-4">
                            <label>Show on Map</label>
                        </div>
                        <div class="col-md-2">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Android</label>
                        </div>
                        <div class="col-md-4">
                          @if($android !==null)
                            <input type="radio" name="location_android" value=1 {{$android->share_location == '1' ? 'checked' : '' }}> Ya &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="location_android" value=0 {{$android->share_location == '0' ? 'checked' : '' }}> Tidak
                          @else
                            Login di Android terlebih dahulu
                          @endif
                        </div>
                        <div class="col-md-4">
                          @if($android !==null)
                            <input type="radio" name="show_on_map_android" value=1 {{$android->show_on_map == '1' ? 'checked' : '' }}> Ya &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="show_on_map_android" value=0 {{$android->show_on_map == '0' ? 'checked' : '' }}> Tidak
                          @else
                            Login di Android terlebih dahulu
                          @endif
                        </div>
                        <div class="col-md-2">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label>IOS</label> <br>
                        </div>
                        <div class="col-md-4">
                          @if($ios !==null)
                            <input type="radio" name="location_ios" value=1 {{$ios->share_location == '1' ? 'checked' : '' }}> Ya &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="location_ios" value=0 {{$ios->share_location == '0' ? 'checked' : '' }}> Tidak
                          @else
                            Login di IOS terlebih dahulu
                          @endif
                        </div>
                        <div class="col-md-4">
                          @if($ios !==null)
                            <input type="radio" name="show_on_map_ios" value=1 {{$ios->show_on_map == '1' ? 'checked' : '' }}> Ya &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="show_on_map_ios" value=0 {{$ios->show_on_map == '0' ? 'checked' : '' }}> Tidak
                          @else
                            Login di IOS terlebih dahulu
                          @endif
                        </div>
                        <div class="col-md-2">
                        </div>
                    </div>
                    @if($android !==null || $ios !==null )
                    <div class="row">
                        <br>
                        {{ Form::hidden('password','',['class'=> 'password'])  }}
                        <button type="submit" class="btn btn-blue js-submit-autopost">Simpan Perubahan</button>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
    @else
    <div class="panel-body">
      Tidak ada Konfigurasi Member
    </div>
    @endif
</div>
