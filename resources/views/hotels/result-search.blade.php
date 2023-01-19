@extends('layouts.public')
@section('css')
    @parent
    <style>
        .modal-mask {
            position: fixed;
            z-index: 9998;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, .5);
            display: table;
            transition: opacity .3s ease;
        }

        .modal-wrapper {
            display: table-cell;
            vertical-align: middle;
        }

        .modal-container {
            width: 300px;
            margin: 0px auto;
            padding: 20px 30px;
            background-color: #fff;
            border-radius: 2px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
            transition: all .3s ease;
            font-family: Helvetica, Arial, sans-serif;
        }

        .modal-header h3 {
            margin-top: 0;
            color: #42b983;
        }

        .modal-body {
            margin: 20px 0;
        }

        .modal-default-button {
            float: right;
        }
        .modal-enter {
            opacity: 0;
        }

        .modal-leave-active {
            opacity: 0;
        }

        .modal-enter .modal-container,
        .modal-leave-active .modal-container {
            -webkit-transform: scale(1.1);
            transform: scale(1.1);
        }
    </style>
@endsection
@section('content')
    <div id="step-booking">
        <div class="container">
            <ul class="breadcrumb-step">
                <li class="active">
                    <a href="javascript:void(0)">
                        1. Pilih Hotel
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        2. Pilih Kamar & Isi Data
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        3. Konfirmasi
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div id="hotel">
        <div class="row"><div id="load"></div></div>
        <section class="list-hotel">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div id="success"></div>
                        <list-hotels v-bind:hotels="hotels" v-bind:results="results"></list-hotels>
                    </div>
                </div>
            </div>
        </section>
    </div>

<script type="text/x-template" id="listHotel">
  <div class="right-search-result">
    <div v-if="results!=null && results.error_code=='000'">
      <h3 class="orange-title" >Hasil pencarian :</h3>
      <br />
      <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-6">
          <div class="form-inline">
            <div class="form-group">
              <label>Sortir : </label>
              <select class="form-control" v-model="sort" v-on:change="sortOnChange">
                <option></option>
                <option :value="1">Termurah</option>
                <option :value="2">Termahal</option>
                <option :value="3">Rating Terendah</option>
                <option :value="4">Rating Tertinggi</option>
                <option :value="5">Nama Hotel A-Z</option>
                <option :value="6">Nama Hotel Z-A</option>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-6 col-md-offset-4">
          <div class="form-inline">
            <div class="form-group">
              <input type="text" class="form-control" v-model="keyword" v-on:keyup.enter="onSubmit" placeholder="Nama Hotel">
            </div>
            <button @click="onSubmit" class="btn btn-default">Cari</button>
          </div>
        </div>
      </div>
      <p class="text-danger" v-if="error_code">@{{error_msg}}</p>
    </div>
    <div class="rows"  v-for="(hotel,index) in resultHotels">
      <div class="box-search-result">
        <div class="big-thumb"><img  v-if="hotel.image!='cdn.infiniqa.com'" :src="hotel.image" /><img  v-else :src="imgDefault" /></div>
        <div class="detail-thumb">
          <div class="top-detail">
            <div class="name-info left">
              <h2>@{{hotel.name}}</h2>
              <div class="star-rate">
                  <img src="{{asset('/assets/images/material/star-full-ico.png')}}" v-for="n in Number(hotel.star)">
              </div>
              <span>@{{hotel.address}}</span>
            </div>
            <div class="rate-info right">
              <h2><small>Start From &nbsp;&nbsp;&nbsp; </small><span style="color:red;">IDR @{{ addCommas(hotel.price) }}</span></h2>
            </div>
          </div>
          <div class="bottom-detail">
            <form method="POST" action="{{route('hotels.hotel_detail')}}">
              <input type="hidden" name="_token" v-model="token" />
              <input type="hidden" name="selectedID"  v-bind:value="hotel.selectedID" />
              <button @click="showLoad()" type="submit" class="block-btn block-blue right">Pilih Hotel</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div v-infinite-scroll="loadMore" infinite-scroll-disabled="busy" infinite-scroll-distance="10">

    </div>
    <img v-show="imgLoad" src="{{ asset('/assets/images/Preloader_2.gif') }}" class="img-responsive" alt="loading" style="display: block;margin-left: auto;margin-right: auto;">
    <transition v-if="showModal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <div class="modal-body text-center">
                        <slot name="body">
                            <p>Mohon tunggu.</p>
                            <img src="{{ asset('/assets/images/Preloader_2.gif') }}" class="img-responsive" alt="loading" style="display: block;margin-left: auto;margin-right: auto;">
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
  </div>

</script>
@endsection

@section('js')
    @parent
    @if(old()!=null)
        <script>
            var oldTrainDepartureDate=window.request.departure_date;
            if(window.request.trip=='R'){
                var oldTrainReturnDate=window.request.return_date;
            }
        </script>
    @endif
    <script src="https://unpkg.com/vue-infinite-scroll@2.0.1"></script>
    <script src="{{asset('/assets/js/aiwdugfiotel.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#load').html("<div class='col-md-12'><img src='{{asset('/assets/images/Preloader_2.gif')}}' style='height: auto;width:auto;margin:auto;display:block;' class='img-responsive'></div>");
            hotel.search(window.url,window.request,"#load");
            if ($('input[name="trip"]').length > 0) {
                var selected = $('input[name="trip"]:checked').val();
                if (selected === 'undefined' || selected !== 'R') {
                    $('#js-trip').hide();
                }
                $('input[name="trip"]').change(function () {
                    var selected = $('input[name="trip"]:checked').val();
                    if (selected === 'R') {
                        $('#js-trip').show();
                    } else {
                        $('#js-trip').hide();
                    }
                })
            }
          }
        );
    </script>
@endsection
