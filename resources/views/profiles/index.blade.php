@extends('layouts.public')
@section('css')
    @parent
    <link href="{{ captcha_layout_stylesheet_url() }}" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('/assets/css/public/sweetalert.css')}}">
@endsection
@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section id="profiles">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="rows">
                        <div class="tabs-custom">
                            <div>
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    @if(!($user->role == 'admin') && !($user->role == 'acc'))
                                    <li role="presentation" class="active"><a href="#travel-agent" aria-controls="travel-agent" role="tab" data-toggle="tab">Profil Usaha</a></li>
                                    <li role="presentation"><a href="#data-profile" aria-controls="data-profile" role="tab" data-toggle="tab">Biodata</a></li>
                                    @else
                                    <li role="presentation" class="active"><a href="#data-profile" aria-controls="data-profile" role="tab" data-toggle="tab">Biodata</a></li>
                                    @endif
                                    {{-- <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Ganti Password</a></li> --}}
                                    @if(!($user->role == 'admin') && !($user->role == 'acc'))
{{--                                    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Reset Mobile Device</a></li>--}}
                                    <li role="presentation"><a href="#freeUser" aria-controls="messages" role="tab" data-toggle="tab">List Free User</a></li>
                                    <li role="presentation"><a href="#autoPost" aria-controls="messages" role="tab" data-toggle="tab">Konfigurasi</a></li>
                                    @endif
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    @if(!($user->role == 'admin') && !($user->role == 'acc'))
                                    <div role="tabpanel" class="tab-pane active" id="travel-agent">
                                        @include('profiles._form-travel-agent',$user)
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="data-profile">
                                        @include('profiles._form-profile-user',$user)
                                    </div>
                                    @else
                                    <div role="tabpanel" class="tab-pane active" id="data-profile">
                                        @include('profiles._form-profile-user',$user)
                                    </div>
                                    @endif
                                    {{-- <div role="tabpanel" class="tab-pane" id="profile">
                                        @include('profiles._form-change-password',$user)
                                    </div> --}}
                                    @if(!($user->role == 'admin') && !($user->role == 'acc'))
{{--                                    <div role="tabpanel" class="tab-pane" id="messages">--}}
{{--                                        @include('profiles._form-device',$user)--}}
{{--                                    </div>--}}
                                    <div role="tabpanel" class="tab-pane" id="freeUser">
                                        @include('profiles._list-free-user',$user)
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="autoPost">
                                        @include('profiles._form-autopost',$user)
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div><!--end.tabs-rows-->
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    @parent
    <script src="{{asset('/assets/js/public/sweetalert.min.js')}}"></script>
    <script>
        var xhr;
        var provinceSelector=$("#provinceSelector");
        var citySelector=$("#citySelector");
        var subdistrictSelector=$("#subdistrictSelector");
        var provinceSelectorUser=$("#provinceSelectorUser");
        var citySelectorUser=$("#citySelectorUser");
        var subdistrictSelectorUser=$("#subdistrictSelectorUser");
        provinceSelector.select2().on("select2:select",function (value){
            if(!value.length<0){
                citySelector.val('').trigger('change');
                citySelector.prop('disabled',true);
                subdistrictSelector.val('').trigger('change');
                subdistrictSelector.prop('disabled',true);
                console.log("Masuk !value");
                return
            }
            console.log("Masuk proses");
            citySelector.val('').trigger('change');
            citySelector.prop('disabled',true);
            subdistrictSelector.val('').trigger('change');
            subdistrictSelector.prop('disabled',true);
            console.log("diatas foreach");
            $("#citySelector option").each(function() {
                $(this).remove();
            });
            $("#subdistrictSelector option").each(function() {
                $(this).remove();
            });
            console.log("Dibawah foreach");
            xhr && xhr.abort();
            xhr = $.ajax({
                url:'/rest/location/cities?province_id='+ value.params.data.id,
                method:'GET',
                success: function (values) {
                    console.log("masuk ke sukses");
                    console.log(values);
                    var k= 1;
                    var names = [];
                    names[0]={id:'', text: '-----PILIH-----'};
                    values.forEach(function (data) {
                        names[k]={ id: data.id, text: data.name };
                        k++;
                    });
                    console.log(names);
                    citySelector.select2({
                        data:names
                    });
                    citySelector.prop('disabled',false);
                },
                error:function () {
                    console.log('Error');
                }
            });
        });
        citySelector.select2().on("select2:select",function (valueCities) {
            $("#subdistrictSelector option").each(function() {
                $(this).remove();
            });
            xhr && xhr.abort();
            xhr = $.ajax({
                url:'/rest/location/subdistricts?subdistrict_id='+ valueCities.params.data.id,
                method:'GET',
                success: function (values) {
                    var k= 1;
                    var names = [];
                    names[0]={id:'', text: '-----PILIH-----'};
                    console.log(names);
                    values.forEach(function (result) {
                        names[k]={ id: result.id, text: result.name };
                        k++;
                    });
                    console.log('names ke dua');
                    console.log(names);
                    subdistrictSelector.select2({
                        data:names
                    });
                    subdistrictSelector.prop('disabled',false);
                },
                error:function () {
                    console.log("Error");
                }
            });
        });
        subdistrictSelector.select2();
        provinceSelectorUser.select2().on("select2:select",function (value){
            if(!value.length<0){
                citySelectorUser.val('').trigger('change');
                citySelectorUser.prop('disabled',true);
                subdistrictSelectorUser.val('').trigger('change');
                subdistrictSelectorUser.prop('disabled',true);
                return
            }
            citySelectorUser.val('').trigger('change');
            citySelectorUser.prop('disabled',true);
            subdistrictSelectorUser.val('').trigger('change');
            subdistrictSelectorUser.prop('disabled',true);
            $("#citySelectorUser option").each(function() {
                $(this).remove();
            });
            $("#subdistrictSelectorUser option").each(function() {
                $(this).remove();
            });
            xhr && xhr.abort();
            xhr = $.ajax({
                url:'/rest/location/cities?province_id='+ value.params.data.id,
                method:'GET',
                success: function (values) {
                    console.log("masuk ke sukses");
                    console.log(values);
                    var k= 1;
                    var names = [];
                    names[0]={id:'', text: '-----PILIH-----'};
                    values.forEach(function (data) {
                        names[k]={ id: data.id, text: data.name };
                        k++;
                    });
                    console.log(names);
                    citySelectorUser.select2({
                        data:names
                    });
                    citySelectorUser.prop('disabled',false);
                },
                error:function () {
                    console.log('Error');
                }
            });
        });
        citySelectorUser.select2().on("select2:select",function (valueCities) {
            $("#subdistrictSelector option").each(function() {
                $(this).remove();
            });
            xhr && xhr.abort();
            xhr = $.ajax({
                url:'/rest/location/subdistricts?subdistrict_id='+ valueCities.params.data.id,
                method:'GET',
                success: function (values) {
                    console.log(this.url);
                    console.log("Masuk ke success");
                    var k= 1;
                    console.log(k);
                    var names = [];
                    names[0]={id:'', text: '-----PILIH-----'};
                    console.log(names);
                    values.forEach(function (result) {
                        names[k]={ id: result.id, text: result.name };
                        k++;
                    });
                    console.log('names ke dua');
                    console.log(names);
                    subdistrictSelectorUser.select2({
                        data:names
                    });
                    subdistrictSelectorUser.prop('disabled',false);
                },
                error:function () {
                    console.log("Error");
                }
            });
        });
        subdistrictSelectorUser.select2();
        $(document.body).on('click', '.js-submit-confirm', function (event) {
            event.preventDefault();
            var $form = $(this).closest('form');
            var $el = $(this);
            var text = $el.data('confirm-message') ? $el.data('confirm-message') : 'Anda tidak bisa membatalkan proses ini!'
            swal({
                    title: 'Anda akan melakukan reset device.',
                    text: text,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0c5484',
                    confirmButtonText: 'Ya!',
                    cancelButtonText: 'Batal',
                    closeOnConfirm: true
                },
                function () {
                    $form.submit()
                })
        });
    </script>
    <script>
        $(document).ready(function(){
             $(document.body).on('click', '.js-submit-autopost', function (event) {
                event.preventDefault();
                var $form = $(this).closest('form');
                var $el = $(this);
                var text = $el.data('confirm-message') ? $el.data('confirm-message') : 'Masukkan Password Anda';
                swal({
                        html: true,
                        title: "Password",
                        text: text,
                        type: "input",
                        inputType: "password",
                        showCancelButton: true,
                        confirmButtonColor: '#0c5484',
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Batal',
                        closeOnConfirm: false
                    },
                    function (inputValue) {
                        if (inputValue === false) return false;
                        $('.password').val(inputValue);
                        $form.submit()
                    })
            });
        });
    </script>
    <script>
        $(document).ready(function(){
             $(document.body).on('click', '.js-submit-upload', function (event) {
                event.preventDefault();
                var $form = $(this).closest('form');
                var $el = $(this);
                var text = $el.data('confirm-message') ? $el.data('confirm-message') : 'Ukuran file foto profil harus kurang dari 50KB. Silahkan upload ulang foto profil!';
                if (window.File && window.FileReader && window.FileList && window.Blob)
                {
                    //get the file size and file type from file input field
                    var fsize = $('#image_file')[0].files[0].size;

                    if(fsize>51000) //do something if file size more than 50 kb
                    {
                      swal({
                              title: "Foto Profil",
                              text: text,
                              showCancelButton: true,
                              showConfirmButton: false,
                              cancelButtonText: 'Batal',
                              closeOnConfirm: false
                          },
                          function () {
                              $form.submit()
                          })
                    }
                    else {
                      {
                        $form.submit()
                      }
                    }
                }else{
                    alert("Please upgrade your browser, because your current browser lacks some new features we need!");
                }

            });
        });
    </script>
    <script>
      $('#image_submit').click( function() {
        //check whether browser fully supports all File API

      });
    </script>
@endsection
