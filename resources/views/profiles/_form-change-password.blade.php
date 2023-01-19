<div class="panel panel-primary panel-click">
    <div class="panel-heading">
        <h3 class="panel-title">Ganti Password</h3>
    </div>
    <div class="panel-body">
        <form action="{{ route('profiles.change_password',$user) }}" method="POST">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-3">
                    <strong>Password Lama</strong>
                    <p class="muted">Password lama anda.</p>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="user-name">Password Lama</label>
                            {!! Form::password('old_password',['class'=>'form-control','id'=>'user-name']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <strong>Password Baru</strong>
                    <p class="muted">Masukkan password baru yang anda inginkan.</p>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="user-name">Password Baru</label>
                            {!! Form::password('new_password',['class'=>'form-control','id'=>'newPassword']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label for="user-name">Ketik Ulang</label>
                            {!! Form::password('confirm_password',['class'=>'form-control','id'=>'confirmPassword']) !!}
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
                        <div class="BDC_CaptchaDiv" id="ResetPasswordCaptcha_CaptchaDiv" style="width:280px; height:50px;"><!--
 --><div class="BDC_CaptchaImageDiv" id="ResetPasswordCaptcha_CaptchaImageDiv" style="width:250px !important; height:50px !important;"><!--
   --><div class="BDC_CaptchaImageDiv" style="width:250px; height:40px;"><img class="BDC_CaptchaImage" id="ResetPasswordCaptcha_CaptchaImage" src="{{url('/')}}/captcha-handler?get=image&amp;c=resetpasswordcaptcha&amp;t=740c2722924a49c88e5e7387d75c89fd" alt="Retype the CAPTCHA code from the image" /></div><!--
   --></div><!--
 --><div class="BDC_CaptchaIconsDiv" id="ResetPasswordCaptcha_CaptchaIconsDiv" style="width: 24px !important;"><!--
   --><a class="BDC_ReloadLink" id="ResetPasswordCaptcha_ReloadLink" href="#" onclick="ResetPasswordCaptcha.ReloadImage(); this.blur(); return false;" title="Change the CAPTCHA code"><img class="BDC_ReloadIcon" id="ResetPasswordCaptcha_ReloadIcon" src="{{url('/')}}/captcha-handler?get=bdc-reload-icon.gif" alt="Change the CAPTCHA code" /></a><!--
   --><a rel="nofollow" class="BDC_SoundLink" id="ResetPasswordCaptcha_SoundLink" href="{{url('/')}}/captcha-handler?get=sound&amp;c=resetpasswordcaptcha&amp;t=740c2722924a49c88e5e7387d75c89fd" onclick="ResetPasswordCaptcha.PlaySound(); this.blur(); return false;" title="Speak the CAPTCHA code" target="_blank"><img class="BDC_SoundIcon" id="ResetPasswordCaptcha_SoundIcon" src="{{url('/')}}/captcha-handler?get=bdc-sound-icon.gif" alt="Speak the CAPTCHA code" /></a><!--
   --><div class="BDC_Placeholder" id="ResetPasswordCaptcha_AudioPlaceholder">&nbsp;</div><!--
 --></div>
                            <input type="hidden" name="BDC_UserSpecifiedCaptchaId" id="BDC_UserSpecifiedCaptchaId" value="ResetPasswordCaptcha" />
                            <input type="hidden" name="BDC_VCID_ResetPasswordCaptcha" id="BDC_VCID_ResetPasswordCaptcha" value="740c2722924a49c88e5e7387d75c89fd" />
                            <input type="hidden" name="BDC_BackWorkaround_ResetPasswordCaptcha" id="BDC_BackWorkaround_ResetPasswordCaptcha" value="0" />
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="CaptchaCodeReset" name="CaptchaCodeReset" placeholder="Masukan kode akses">
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