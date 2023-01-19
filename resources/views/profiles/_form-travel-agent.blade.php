<?php $travel=$user->travel_agent;?>
<div class="row">
    <form action="{{ route('profiles.travel_update_logo',(isset($travel))?$travel->id:'0') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ Form::hidden('travel_id',(isset($travel))?$travel->id:0) }}
    <div class="col-md-3">
        <div class="panel panel-primary panel-click">
            <div class="panel-heading">
                <h3 class="panel-title">Logo Usaha</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <img src="{{ asset( (isset($travel))?$travel->url_logo:'/assets/images/material/default_avatar.jpg') }}" alt="logo-travel" class="img-circle">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h3>Logo Usaha</h3>
                            <input type="file" name="logo" class="form-control">
                            <input type="submit" class="btn btn-blue" value="Upload">
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
    <form action="{{ route('profiles.travel_update', (isset($travel))?$travel->id:'0' )  }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}
        {{ Form::hidden('travel_id',(isset($travel))?$travel->id:0) }}
    <div class="col-md-9">
        <div class="panel panel-primary panel-click">
            <div class="panel-heading">
                <h3 class="panel-title">Profil Usaha</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Nama Usaha</label>
                            <div class="col-sm-9">
                                {!! Form::text('name',(isset($travel))?$user->travel_agent->name:'',['class'=>'form-control']) !!}
                            </div>
                            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">Alamat Usaha</label>
                            <div class="col-sm-9">
                                {!! Form::text('detail',(isset($travel))?$travel->address->detail:'',['class'=>'form-control'] )!!}
                            </div>
                        </div>
                        <div class="form-group group-addon-select">
                            <label for="provinceSelector" class="col-sm-3 control-label">Provinsi</label>
                            <div class="col-sm-9">
                                <div class="input-group custom-input">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                                    <select class="full-width" id="provinceSelector" name="province_id">
                                        <option value="">------PILIH-------</option>
                                        @foreach(\App\Province::all()->sortBy('name') as $province)
                                            <option value="{{$province->id}}" <?= (isset($travel)&&$travel->address->subdistrict->city->province->id==$province->id)?'selected':''?>>{{$province->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-addon">&nbsp;</span>
                                </div>
                                {!! $errors->first('province_id', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group group-addon-select">
                            <label for="citySelector" class="col-sm-3 control-label">Kota</label>
                            <div class="col-sm-9">
                                <div class="input-group custom-input">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                                    <select class="full-width" id="citySelector" name="city_id">
                                        <option value="">----PILIH----</option>
                                        <option value="{{ ( isset($travel) ) ? $travel->address->subdistrict->city->id:'' }}" selected>{{ (isset($travel))?$travel->address->subdistrict->city->name:'' }}</option>
                                    </select>
                                    <span class="input-group-addon">&nbsp;</span>
                                </div>
                                {!! $errors->first('city_id', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group group-addon-select">
                            <label for="subdistrict_id" class="col-sm-3 control-label">Kecamatan</label>
                            <div class="col-sm-9">
                                <div class="input-group custom-input">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                                    <select class="full-width" id="subdistrictSelector" name="subdistrict_id">
                                        <option value="">----PILIH----</option>
                                        <option value="{{(isset($travel))?$travel->address->subdistrict->id:'' }}" selected>{{ (isset($travel))?$travel->address->subdistrict->name:'' }}</option>
                                    </select>
                                    <span class="input-group-addon">&nbsp;</span>
                                </div>
                                {!! $errors->first('subdistrict_id', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">No Telp. / HP</label>
                            <div class="col-sm-9">
                                {!! Form::text('phone',(isset($travel))?$travel->address->phone:'',['class'=>'form-control'] )!!}
                            </div>
                            {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-9">
                                {!! Form::email('email',(isset($travel))?$travel->email:'',['class'=>'form-control'] )!!}
                            </div>
                            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                        </div>
                        {{-- <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">&nbsp;</label>
                            <div class="col-sm-9">
                                <div class="BDC_CaptchaDiv" id="ExampleCaptcha_CaptchaDiv" style="width:230px; height:50px;"><!--
--><div class="BDC_CaptchaImageDiv" id="ExampleCaptcha_CaptchaImageDiv" style="width:200px !important; height:50px !important;"><!--
--><div class="BDC_CaptchaImageDiv" style="width:200px; height:40px;"><img class="BDC_CaptchaImage" id="ExampleCaptcha_CaptchaImage" src="{{url('/')}}/captcha-handler?get=image&amp;c=examplecaptcha&amp;t=d8c3f2302807e2d38d79910fba11f236" alt="Retype the CAPTCHA code from the image" /></div><!--
--><!--
--></div><!--
--><div class="BDC_CaptchaIconsDiv" id="ExampleCaptcha_CaptchaIconsDiv" style="width: 24px !important;"><!--
--><a class="BDC_ReloadLink" id="ExampleCaptcha_ReloadLink" href="javascript:void(0)" onclick="ExampleCaptcha.ReloadImage(); this.blur(); return false;" title="Change the CAPTCHA code"><img class="BDC_ReloadIcon" id="ExampleCaptcha_ReloadIcon" src="{{url('/')}}/captcha-handler?get=bdc-reload-icon.gif" alt="Change the CAPTCHA code" /></a><!--
--><a rel="nofollow" class="BDC_SoundLink" id="ExampleCaptcha_SoundLink" href="{{url('/')}}/captcha-handler?get=sound&amp;c=examplecaptcha&amp;t=d8c3f2302807e2d38d79910fba11f236" onclick="ExampleCaptcha.PlaySound(); this.blur(); return false;" title="Speak the CAPTCHA code" target="_blank"><img class="BDC_SoundIcon" id="ExampleCaptcha_SoundIcon" src="{{url('/')}}/captcha-handler?get=bdc-sound-icon.gif" alt="Speak the CAPTCHA code" /></a><!--
--><div class="BDC_Placeholder" id="ExampleCaptcha_AudioPlaceholder">&nbsp;</div><!--
--></div>

                                    <input type="hidden" name="BDC_UserSpecifiedCaptchaId" id="BDC_UserSpecifiedCaptchaId" value="ExampleCaptcha" />
                                    <input type="hidden" name="BDC_VCID_ExampleCaptcha" id="BDC_VCID_ExampleCaptcha" value="d8c3f2302807e2d38d79910fba11f236" />
                                    <input type="hidden" name="BDC_BackWorkaround_ExampleCaptcha" id="BDC_BackWorkaround_ExampleCaptcha" value="0" />
                                </div>
                            </div>
                        </div> --}}
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">&nbsp;</label>
                            <div class="col-sm-4">
                                <input type="password" class="form-control" id="CaptchaCode" name="CaptchaCode" placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-blue">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>
</div>
