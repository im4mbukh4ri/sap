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
                    <?php /*
                    <li role="presentation" class="text-center">
                        <a href="#holiday" aria-controls="holiday" role="tab" data-toggle="tab">
                            <i class="fa fa-suitcase"></i>
                            <span>KERETA API</span>
                        </a>
                    </li>
                    <li role="presentation" class="text-center">
                        <a href="#hotel" aria-controls="hotel" role="tab" data-toggle="tab">
                            <i class="fa fa-bed"></i>
                            <span>HOTEL</span>
                        </a>
                    </li>
                    <li role="presentation" class="text-center">
                        <a href="#taxi" aria-controls="taxi" role="tab" data-toggle="tab">
                            <i class="fa fa-cab"></i>
                            <span>SHUTTLE / BUS</span>
                        </a>
                    </li>
                    <li role="presentation" class="text-center">
                        <a href="#cruise" aria-controls="cruise" role="tab" data-toggle="tab">
                            <i class="fa fa-ship"></i>
                            <span>PPOB</span>
                        </a>
                    </li>
                        */ ?>
                </ul>
                <!-- END: CATEGORY TAB -->

                <!-- BEGIN: TAB PANELS -->
                <div class="tab-content">
                    <!-- BEGIN: FLIGHT SEARCH -->
                    <div role="tabpanel" class="tab-pane  active" id="flight">
                        <form id="searchAirlines" method="post">
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
                                            <option value="{{$airport['id']}}">{{$airport['name']}} ({{$airport['id']}}) - {{$airport['city']}}, {{$airport['country']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-3 search-col-padding">
                                    <label>Kota Tujuan</label>
                                    <select name="destination" class="select2" style="width:100%;border: 1px solid #BEC4C8;border-radius: 0;height: 40px;" required>
                                        <option value="">Pilih kota tujuan</option>
                                        @foreach($airports as $airport)
                                            <option value="{{$airport['id']}}">{{$airport['name']}} ({{$airport['id']}}) - {{$airport['city']}}, {{$airport['country']}}</option>
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
                                        <option value="">Pilih Maskapai</option>
                                        @foreach($airlines as $airline)
                                            <option value="{{$airline['code']}}">{{$airline['airline']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-2 search-col-padding">
                                    <label>Dewasa</label><br>
                                    <input type="number" min="1" max="7" id="adult_count" name="adt" value="1" class="form-control quantity-padding">
                                </div>
                                <div class="col-md-2 col-sm-2 search-col-padding">
                                    <label>Anak</label><br>
                                    <input type="number" min="0" max="7" id="chd_count" name="chd" value="0" class="form-control quantity-padding">
                                </div>
                                <div class="col-md-2 col-sm-2 search-col-padding">
                                    <label>Bayi</label><br>
                                    <input type="number" min="0" max="7" type="text" id="inf_count" name="inf" value="0" class="form-control quantity-padding">
                                </div>
                                <div class="col-md-3 search-col-padding">
                                    <button type="submit" class="search-button btn btn-sm transition-effect" id="buttonSearch" style="margin-top: 10%;">Cari Jadwal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- END: FLIGHT SEARCH -->

                    <?php
                    /*
                    <!-- START: BEGIN TRAIN -->
                    <div role="tabpanel" class="tab-pane" id="holiday">
                        <form >
                            <div class="col-md-12 product-search-title">Cari Jadwal Kereta Api</div>
                            <div class="clearfix"></div>
                            <div class="col-md-3 col-sm-3 search-col-padding">
                                <label>Stasiun Asal</label>
                                <div class="input-group">
                                    <input type="text" name="departure_city" class="form-control" required placeholder="E.g. London">
                                    <span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 search-col-padding">
                                <label>Stasiun Tujuan</label>
                                <div class="input-group">
                                    <input type="text" name="destination_city" class="form-control" required placeholder="E.g. New York">
                                    <span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 search-col-padding">
                                <label>Tanggal Keberangkatan</label>
                                <div class="input-group">
                                    <input type="text" id="train_departure_date" name="departure_date" class="form-control" placeholder="DD/MM/YYYY">
                                    <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-4 col-sm-4 search-col-padding">
                                <label>Dewasa / Anak</label><br>
                                <input id="train_adult_count" name="adult_count" value="1" class="form-control quantity-padding">
                            </div>
                            <div class="col-md-4 col-sm-4 search-col-padding">
                                <label>Bayi</label><br>
                                <input type="text" id="train_child_count" name="child_count" value="0" class="form-control quantity-padding">
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-12 search-col-padding">
                                <button type="submit" class="search-button btn transition-effect">Cari Jadwal</button>
                            </div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                    <!-- END: HOLIDAYS -->


                    <!-- START: HOTEL SEARCH -->
                    <div role="tabpanel" class="tab-pane" id="hotel">
                        <form >
                            <div class="col-md-12 product-search-title">Book Hotel Rooms</div>
                            <div class="col-md-4 col-sm-4 search-col-padding">
                                <label>I Want To Go</label>
                                <div class="input-group">
                                    <input type="text" name="destination-city" class="form-control" required placeholder="E.g. New York">
                                    <span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 search-col-padding">
                                <label>Check - In</label>
                                <div class="input-group">
                                    <input type="text" name="check-in" id="check_in" class="form-control" placeholder="DD/MM/YYYY">
                                    <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 search-col-padding">
                                <label>Check - Out</label>
                                <div class="input-group">
                                    <input type="text" name="check-out" id="check_out" class="form-control" placeholder="DD/MM/YYYY">
                                    <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-3 col-sm-3 search-col-padding">
                                <label>Adult</label><br>
                                <input id="hotel_adult_count" name="adult_count" value="1" class="form-control quantity-padding">
                            </div>
                            <div class="col-md-3 col-sm-3 search-col-padding">
                                <label>Child</label><br>
                                <input type="text" id="hotel_child_count" name="child_count" value="1" class="form-control quantity-padding">
                            </div>
                            <div class="col-md-3 col-sm-3 search-col-padding">
                                <label>Rooms</label><br>
                                <select class="selectpicker" name="rooms">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-3 search-col-padding">
                                <label>Nights</label><br>
                                <select class="selectpicker" name="nights">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                </select>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-12 search-col-padding">
                                <button type="submit" class="search-button btn transition-effect">Search Hotels</button>
                            </div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                    <!-- END: HOTEL SEARCH -->

                    <!-- START: CAR SEARCH -->
                    <div role="tabpanel" class="tab-pane" id="taxi">
                        <form >
                            <div class="col-md-12 product-search-title">Search Perfect Car</div>
                            <div class="col-md-4 col-sm-4 search-col-padding">
                                <label>Pick Up Location</label>
                                <div class="input-group">
                                    <input type="text" name="departure-city" class="form-control" required placeholder="E.g. New York">
                                    <span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 search-col-padding">
                                <label>Drop Off Location</label>
                                <div class="input-group">
                                    <input type="text" name="destination-city" class="form-control" required placeholder="E.g. New York">
                                    <span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 search-col-padding">
                                <label>Pick Up Date</label>
                                <div class="input-group">
                                    <input type="text" id="car_start" class="form-control" placeholder="MM/DD/YYYY">
                                    <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-4 col-sm-4 search-col-padding">
                                <label>Pick Off Date</label>
                                <div class="input-group">
                                    <input type="text" id="car_end" class="form-control" placeholder="MM/DD/YYYY">
                                    <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 search-col-padding">
                                <label>Car Brnad(Optional)</label><br>
                                <select class="selectpicker" name="brand">
                                    <option>BMW</option>
                                    <option>Audi</option>
                                    <option>Mercedes</option>
                                    <option>Suzuki</option>
                                    <option>Honda</option>
                                    <option>Hyundai</option>
                                    <option>Toyota</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-sm-4 search-col-padding">
                                <label>Car Type(Optional)</label><br>
                                <select class="selectpicker" name="car_type">
                                    <option>Limo</option>
                                    <option>Sedan</option>
                                </select>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-12 search-col-padding">
                                <button type="submit" class="search-button btn transition-effect">Search Cars</button>
                            </div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                    <!-- END: CAR SEARCH -->

                    <!-- START: CRUISE SEARCH -->
                    <div role="tabpanel" class="tab-pane" id="cruise">
                        <form >
                            <div class="col-md-12 product-search-title">Cruise Holidays</div>
                            <div class="col-md-4 col-sm-4 search-col-padding">
                                <label>From</label>
                                <div class="input-group">
                                    <input type="text" name="pack-departure-city" class="form-control" required placeholder="E.g. New York">
                                    <span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 search-col-padding">
                                <label>I Want To Go</label>
                                <div class="input-group">
                                    <input type="text" name="pack-destination-city" class="form-control" required placeholder="E.g. New York">
                                    <span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 search-col-padding">
                                <label>Starting From</label>
                                <div class="input-group">
                                    <input type="text" id="cruise_start" class="form-control" placeholder="DD/MM/YYYY">
                                    <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-4 col-sm-4 search-col-padding">
                                <label>Duration(Optional)</label><br>
                                <select class="selectpicker" name="holiday_duration">
                                    <option>3 Days</option>
                                    <option>5 Days</option>
                                    <option>1 Week</option>
                                    <option>2 Weeks</option>
                                    <option>1 Month</option>
                                    <option>1+ Month</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-sm-4 search-col-padding">
                                <label>Package Type(Optional)</label><br>
                                <select class="selectpicker" name="package_type">
                                    <option>Group</option>
                                    <option>Family</option>
                                    <option>Individual</option>
                                    <option>Honeymoon</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-sm-4 search-col-padding">
                                <label>Budget(Optional)</label><br>
                                <select class="selectpicker" name="package_budget">
                                    <option>500</option>
                                    <option>1000</option>
                                    <option>1000+</option>
                                </select>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-12 search-col-padding">
                                <button type="submit" class="search-button btn transition-effect">Search Cruises</button>
                            </div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                    <!-- END: CRUISE SEARCH -->
                    */ ?>
                </div>
                <!-- END: TAB PANE -->
            </div>
        </div>
    </div>
</div>
<!-- END: SEARCH SECTION -->
