<section class="pencarian">
    <form action="{{route('trains.result_schedule')}}" method="post">
        {{ csrf_field() }}
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <button type="button" id="triggerSearch" class="btn btn-search">
                        <span class="glyphicon glyphicon-search"></span> Ganti Pencarian
                    </button>
                    <div id="box-search" class="box-orange">
                        <div class="rows">
                            <label class="radio-inline">
                                <input type="radio" name="flight" id="flight" value="O" <?=(old('trip')=='O')?'checked':''?>> Sekali Jalan
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="flight" id="flight" value="R" <?=(old('trip')=='R')?'checked':''?>> Pulang Pergi
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
                                            @foreach($stations as $station)
                                                <option value="{{$station['code']}}" <?=(old('origin')==$station['code'])?'selected':''?>>{{$station['city']}} ({{$station['code']}}) - {{$station['name']}}</option>
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
                                            @foreach($stations as $station)
                                                <option value="{{$station['code']}}" <?=(old('destination')==$station['code'])?'selected':''?>>{{$station['city']}} ({{$station['code']}}) - {{$station['name']}}</option>
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
                                    <div class="col-md-6">
                                        <div class="form-group group-addon-select">
                                            <label for="adt">Dewasa ( > 3thn )</label>
                                            <div class="input-group custom-input">
                                                <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                                <select id="adt" name="adt" class="form-control">
                                                    @for($adtCount=1;$adtCount<=4;$adtCount++)
                                                        <option value="{{ $adtCount }}" <?=(old('adt')==$adtCount)?'selected':''?>>{{ $adtCount }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group group-addon-select">
                                            <label for="chd">Bayi ( < 3thn )</label>
                                            <div class="input-group custom-input">
                                                <span class="input-group-addon"><i class="fa fa-male" aria-hidden="true"></i></span>
                                                <select id="chd" name="inf" class="form-control">
                                                    @for($chdCount=0;$chdCount<=4;$chdCount++)
                                                        <option value="{{ $chdCount }}" <?=(old('chd')==$chdCount)?'selected':''?>>{{ $chdCount }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--end.row-->
                                <input type="hidden" name="chd" value="0" />
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
