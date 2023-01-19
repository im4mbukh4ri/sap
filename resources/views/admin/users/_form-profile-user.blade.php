<?php
$address=$user->address;
?>
<div class="panel panel-primary panel-click">
    <div class="panel-heading">
        <h3 class="panel-title">Profil Member</h3>
    </div>
    <div class="panel-body">
        <form action="{{ route('admin.users_update',$user) }}" method="POST">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-3">
                    <strong>Personal Detail</strong>
                    <p class="muted">Masukkan informasi detail personal anda.</p>
                </div>
                <div class="col-md-9">
                    @if($user->role!='free')
                        <div class="form-group">
                            <div class="form-group">
                                <label for="user-name">Kode Referral</label>
                                {!! Form::text('referral',$user->username,['class'=>'form-control','id'=>'user-name','readonly']) !!}
                            </div>
                        </div>
                    @endif
                        <div class="form-group">
                            <div class="form-group">
                                <label for="user-name">Tipe Member</label>
                                {!! Form::text('referral',$user->type_user->name,['class'=>'form-control','id'=>'user-name','readonly']) !!}
                            </div>
                        </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label for="user-name">Nama</label>
                            {!! Form::text('name',$user->name,['class'=>'form-control','id'=>'user-name']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label for="user-name">Alamat</label>
                            {!! Form::text('detail',$address->detail,['class'=>'form-control','id'=>'user-name']) !!}
                        </div>
                    </div>

                        @if($address->subdistrict)
                        <div class="form-group group-addon-select">
                            <label for="provinceSelectorUser">Provinsi</label>
                            <div class="input-group custom-input">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                                <select class="full-width" id="provinceSelectorUser" name="province_id">
                                    <option value="">------PILIH-------</option>
                                    @foreach(\App\Province::all()->sortBy('name') as $province)
                                        <option value="{{$province->id}}" <?= (isset($address)&&$address->subdistrict->city->province->id==$province->id)?'selected':''?>>{{$province->name}}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-addon">&nbsp;</span>
                                {!! $errors->first('province_id', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                    <div class="form-group group-addon-select">
                        <label for="citySelectorUser" >Kota</label>
                        <div class="input-group custom-input">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                            <select class="full-width" id="citySelectorUser" name="city_id">
                                <option value="">----PILIH----</option>
                                <option value="{{ ( isset($address) ) ? $address->subdistrict->city->id:'' }}" selected>{{ (isset($address))?$address->subdistrict->city->name:'' }}</option>
                            </select>
                            <span class="input-group-addon">&nbsp;</span>
                        </div>
                        {!! $errors->first('city_id', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group group-addon-select">
                        <label for="subdistrictSelectorUser">Kecamatan</label>
                        <div class="input-group custom-input">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                            <select class="full-width" id="subdistrictSelectorUser" name="subdistrict_id">
                                <option value="">----PILIH----</option>
                                <option value="{{(isset($address))?$address->subdistrict->id:'' }}" selected>{{ (isset($address))?$address->subdistrict->name:'' }}</option>
                            </select>
                            <span class="input-group-addon">&nbsp;</span>
                        </div>
                        {!! $errors->first('subdistrict_id', '<p class="help-block">:message</p>') !!}
                    </div>
                            @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <strong>Kontak Detail</strong>
                    <p class="muted">Masukkan informasi detail personal anda.</p>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="user-name">No. Telp. / HP</label>
                            {!! Form::text('phone',$user->address->phone,['class'=>'form-control','id'=>'user-name','readonly']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label for="user-name">Email</label>
                            {!! Form::email('email',$user->email,['class'=>'form-control','id'=>'user-name','readonly']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <strong>Kode Akses</strong>
                    <p class="muted">Masukkan kode akses untuk melanjutkan proses.</p>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <label for="inputPassword3" class="control-label">&nbsp;</label>
                        <div class="BDC_CaptchaDiv" id="LoginCaptcha_CaptchaDiv" style="width:280px; height:50px;"><!--
 --><div class="BDC_CaptchaImageDiv" id="LoginCaptcha_CaptchaImageDiv" style="width:250px !important; height:50px !important;"><!--
   --><div class="BDC_CaptchaImageDiv" style="width:250px; height:40px;"><img class="BDC_CaptchaImage" id="LoginCaptcha_CaptchaImage" src="{{url('/')}}/captcha-handler?get=image&amp;c=logincaptcha&amp;t=8c5dced1e3ccd069ac393bb7d4a27d48" alt="Retype the CAPTCHA code from the image" /></div><!--
   --><!--
 --></div><!--
 --><div class="BDC_CaptchaIconsDiv" id="LoginCaptcha_CaptchaIconsDiv" style="width: 24px !important;"><!--
   --><a class="BDC_ReloadLink" id="LoginCaptcha_ReloadLink" href="#" onclick="LoginCaptcha.ReloadImage(); this.blur(); return false;" title="Change the CAPTCHA code"><img class="BDC_ReloadIcon" id="LoginCaptcha_ReloadIcon" src="{{url('/')}}/captcha-handler?get=bdc-reload-icon.gif" alt="Change the CAPTCHA code" /></a><!--
   --><a rel="nofollow" class="BDC_SoundLink" id="LoginCaptcha_SoundLink" href="{{url('/')}}/captcha-handler?get=sound&amp;c=logincaptcha&amp;t=8c5dced1e3ccd069ac393bb7d4a27d48" onclick="LoginCaptcha.PlaySound(); this.blur(); return false;" title="Speak the CAPTCHA code" target="_blank"><img class="BDC_SoundIcon" id="LoginCaptcha_SoundIcon" src="{{url('/')}}/captcha-handler?get=bdc-sound-icon.gif" alt="Speak the CAPTCHA code" /></a><!--
   --><div class="BDC_Placeholder" id="LoginCaptcha_AudioPlaceholder">&nbsp;</div><!--
 --></div>

                            <input type="hidden" name="BDC_UserSpecifiedCaptchaId" id="BDC_UserSpecifiedCaptchaId" value="LoginCaptcha" />
                            <input type="hidden" name="BDC_VCID_LoginCaptcha" id="BDC_VCID_LoginCaptcha" value="8c5dced1e3ccd069ac393bb7d4a27d48" />
                            <input type="hidden" name="BDC_BackWorkaround_LoginCaptcha" id="BDC_BackWorkaround_LoginCaptcha" value="0" />

                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="CaptchaCodeLogin" name="CaptchaCodeLogin" placeholder="Masukan kode akses">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-9 col-md-offset-3">
                    <button type="submit" class="btn btn-blue">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
