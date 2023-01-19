<!-- BEGIN: SEARCH SECTION -->
<div class="row full-width-search">
    <div class="container clear-padding">
        <div class="col-md-12 search-section">
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
                        <select name="origin" class="select2" style="width:100%;border: 1px solid #BEC4C8;border-radius: 0;height: 40px;" required>
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
                            <input type="text" id="departure_date" name="departure_date" class="form-control" placeholder="DD/MM/YYYY">
                            <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 search-col-padding">
                        <div id="js-flight">
                            <label>Tanggal Kembali</label>
                            <div class="input-group">
                                <input type="text" id="return_date" class="form-control" name="return_date" placeholder="DD/MM/YYYY">
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
    </div>
</div>
<!-- END: SEARCH SECTION -->