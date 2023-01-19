<section class="pencarian">
    <form action="{{route('airlines.vue')}}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="airlines_code" value="ALL">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <button type="button" id="triggerSearch" class="btn btn-search">
                        <span class="glyphicon glyphicon-search"></span> Ganti Pencarian
                    </button>
                    <div id="box-search" class="box-orange">
                        <div class="rows">
                            <label class="radio-inline">
                                <input type="radio" name="flight" id="flight" value="O" <?=(old('flight')=='O')?'checked':''?>> Sekali Jalan
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="flight" id="flight" value="R" <?=(old('flight')=='R')?'checked':''?>> Pulang Pergi
                            </label>
                        </div>
                        <div class="search-row row">
                            <div class="col-md-4">
                                <div class="form-group group-addon-select">
                                    <label for="origin" >Dari</label>
                                    <div class="input-group custom-input">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                                        <select id="origin" name="origin" class="selectSearch1 full-width" required>
                                            <option value="">Pilih kota asal</option>
                                            @foreach($airports as $airport)
                                                <option value="{{$airport['id']}}" <?=(old('origin')==$airport['id'])?'selected':''?>>{{$airport['name']}} ({{$airport['id']}}) - {{$airport['city']}}, {{$airport['country']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group group-addon-select">
                                    <label for="destination">Ke</label>
                                    <div class="input-group custom-input">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                                        <select id="destination" name="destination"  class="selectSearch2 full-width">
                                            <option value="">Pilih kota tujuan</option>
                                            @foreach($airports as $airport)
                                                <option value="{{$airport['id']}}" <?=(old('destination')==$airport['id'])?'selected':''?>>{{$airport['name']}} ({{$airport['id']}}) - {{$airport['city']}}, {{$airport['country']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div><!--end.col4-->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="departure_date">Pergi</label>
                                    <div class="input-group custom-input">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                        <input readonly type="text" id="departure_date" name="departure_date" class="form-control datepicker" value="{{ old('departure_date') }}">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-menu-down"></i></span>
                                    </div>
                                </div>
                                <div class="form-group" id="js-flight">
                                    <label for="return_date">Pulang</label>
                                    <div class="input-group custom-input">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                        <input readonly type="text" id="return_date" name="return_date" class="form-control datepicker" value="{{ old('return_date') }}">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-menu-down"></i></span>
                                    </div>
                                </div>
                            </div><!--end.col4-->
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group group-addon-select">
                                            <label for="adt">Dewasa</label>
                                            <div class="input-group custom-input">
                                                <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                                <select id="adt" name="adt" class="form-control">
                                                    @for($adtCount=1;$adtCount<=7;$adtCount++)
                                                        <option value="{{ $adtCount }}" <?=(old('adt')==$adtCount)?'selected':''?>>{{ $adtCount }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group group-addon-select">
                                            <label for="chd">Anak</label>
                                            <div class="input-group custom-input">
                                                <span class="input-group-addon"><i class="fa fa-male" aria-hidden="true"></i></span>
                                                <select id="chd" name="chd" class="form-control">
                                                    @for($chdCount=0;$chdCount<=6;$chdCount++)
                                                        <option value="{{ $chdCount }}" <?=(old('chd')==$chdCount)?'selected':''?>>{{ $chdCount }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group group-addon-select">
                                            <label for="inf">Bayi</label>
                                            <div class="input-group custom-input">
                                                <span class="input-group-addon"><i class="fa fa-child" aria-hidden="true"></i></span>
                                                <select id="inf" name="inf" class="form-control">
                                                    @for($infCount=0;$infCount<=6;$infCount++)
                                                        <option value="{{ $infCount }}" <?=(old('inf')==$infCount)?'selected':''?>>{{ $infCount }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--end.row-->
                                <br>
                                <button type="submit" class="btn btn-cari">
                                    <span class="glyphicon glyphicon-search"></span> Cari Tiket
                                </button>
                            </div><!--end.col4-->
                        </div><!--end.search-row-->
                    </div>
                </div><!--end.col-->
            </div><!--end.row-->
        </div><!--end.container-->
    </form>
</section>
<?php /*
<!-- BEGIN: SEARCH SECTION -->
<div class="row full-width-search">
    <div class="container clear-padding">
        <div class="col-md-12 search-section">
            <div role="tabpanel">
                <!-- BEGIN: CATEGORY TAB -->
                <ul class="nav nav-tabs search-top" role="tablist" id="searchTab">
                    <li role="presentation" class="active text-center">
                        <a href="#flight" aria-controls="flight" role="tab" data-toggle="tab">
                            <i class="fa fa-plane"></i>
                            <span>AIRLINES</SPAN>
                        </a>
                    </li>
                </ul>
                <!-- END: CATEGORY TAB -->

                <!-- BEGIN: TAB PANELS -->
                <div class="tab-content">
                    <!-- BEGIN: FLIGHT SEARCH -->
                    <div role="tabpanel" class="tab-pane  active" id="flight">
                        <form action="{{route('airlines.vue')}}" method="post">
                            {{ csrf_field() }}
                            <div class="col-md-12 product-search-title">Cari Jadwal Penerbangan</div>
                            <div class="row">
                                <div class="col-md-12 search-col-padding">
                                    <label class="radio-inline">
                                        <input type="radio" name="flight" value="O" checked> One Way
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="flight" value="R"> Return
                                    </label>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row">
                                <div class="col-md-3 col-sm-3 search-col-padding">
                                    <label>Kota Asal</label>
                                    <select name="origin" class="select2 selectpicker"  style="width: 100%" required>
                                        <option value="">Pilih kota asal</option>
                                        @foreach($airports as $airport)
                                            <option value="{{$airport['iata']}}">{{$airport['city']}} ({{$airport['iata']}}) - {{$airport['bdrp']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-3 search-col-padding">
                                    <label>Kota Tujuan</label>
                                    <select name="destination" class="select2" style="width:100%;border: 1px solid #BEC4C8;border-radius: 0;height: 40px;" required>
                                        <option value="">Pilih kota tujuan</option>
                                        @foreach($airports as $airport)
                                            <option value="{{$airport['iata']}}">{{$airport['city']}} ({{$airport['iata']}}) - {{$airport['bdrp']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-3 search-col-padding">
                                    <label>Tanggal Berangkat</label>
                                    <div class="input-group">
                                        <input readonly type="text" id="departure_date" name="departure_date" class="form-control" placeholder="DD/MM/YYYY">
                                        <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3 search-col-padding">
                                    <div id="js-flight">
                                        <label>Tanggal Kembali</label>
                                        <div class="input-group">
                                            <input readonly type="text" id="return_date" class="form-control" name="return_date" placeholder="DD/MM/YYYY">
                                            <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row">
                                <div class="col-md-3 col-sm-3 search-col-padding">
                                    <label>Maskapai</label><br>
                                    <select name="airlines_code" class="selectpicker"  style="width: 100%" required>
                                        <option value="ALL">SEMUA MASKAPAI</option>
                                        @foreach($airlines as $airline)
                                            <option value="{{$airline['code']}}">{{$airline['airline']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-2 search-col-padding">
                                    <label>Dewasa</label><br>
                                    <input readonly type="number" min="1" max="7" id="adult_count" name="adt" value="1" class="form-control quantity-padding">
                                </div>
                                <div class="col-md-2 col-sm-2 search-col-padding">
                                    <label>Anak</label><br>
                                    <input readonly type="number" min="0" max="7" id="chd_count" name="chd" value="0" class="form-control quantity-padding">
                                </div>
                                <div class="col-md-2 col-sm-2 search-col-padding">
                                    <label>Bayi</label><br>
                                    <input readonly type="number" min="0" max="7" type="text" id="inf_count" name="inf" value="0" class="form-control quantity-padding">
                                </div>
                                <div class="col-md-3 search-col-padding">
                                    <button type="submit" class="search-button btn btn-sm transition-effect" style="margin-top: 10%;">Cari Jadwal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- END: FLIGHT SEARCH -->
                </div>
                <!-- END: TAB PANE -->
            </div>
        </div>
    </div>
</div>
<!-- END: SEARCH SECTION -->

 */ ?>
