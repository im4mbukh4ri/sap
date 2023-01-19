@extends('layouts.public')
@section('css')
    @parent
@endsection
@section('content')
<div id="step-booking-kereta">
    <section class="section-pilih-seat">
        <div class="container">
            <div class="row">
              <div id="autodebit">
                <div class="col-md-12">
                    <h3 class="blue-title-big">Daftar Nomor Tersimpan</h3>
                    <div class="rows">
                      <div class="panel-group panel-custom" id="accordion" role="tablist" aria-multiselectable="true">
                        <?php
                          $services=[
                            2=>'PLN Prabayar',
                            3=>'PLN Pascabayar',
                            4=>'Telepon',
                            5=>'Internet',
                            6=>'TV Berlangganan',
                            7=>'Multi Finance',
                            8=>'PDAM',
                            9=>'Asuransi'
                          ];
                        ?>
                        @for($i=2;$i<=9;$i++)
                          <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading{{$i}}">
                              <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$i}}" aria-expanded="true" aria-controls="collapse{{$i}}">
                                  {{$services[$i]}}
                                </a>
                              </h4>
                            </div>
                            <div id="collapse{{$i}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$i}}">
                              <div class="panel-body">
                                <a href="javascript:void(0)" @click="showForm({{$i}})"><i class="fa fa-plus"></i> Tambah Nomor</a>
                                <div class="table-responsive">
                                  <table class="table">
                                    <thead>
                                      <tr>
                                        <th>
                                          Nama
                                        </th>
                                        <th>
                                          Nomor
                                        </th>
                                        <th>

                                        </th>
                                        <th>

                                        </th>
                                        <th>

                                        </th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      @forelse ($user->number_saveds()->where('service',$i)->get() as $key => $number)
                                        <tr>
                                          <td>
                                            {{ $number->name }}
                                          </td>
                                          <td>
                                            {{ $number->number }}
                                          </td>
                                          <td>
                                            <button type="button" @click="editForm({{$number->id}})" class="btn btn-xs btn-info"/><i class="fa fa-edit"></i></button>
                                          </td>
                                          <td>
                                            <form action="{{route("number_saveds.destroy")}}" method="POST">
                                              {{csrf_field()}}
                                              <input type="hidden" name="id" value="{{$number->id}}" />
                                              <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-cross">X</i></button>
                                            </form>
                                          </td>
                                          <td>
                                            @if($number->service!==2&&$number->autodebit_status!==1)<a href="javascript:void(0)" @click="getNumberSaved({{$number->id}})">Tambahkan ke Autodebit</a>@endif
                                          </td>
                                        </tr>
                                      @empty
                                        <tr>
                                          <td colspan="3">
                                            Tidak ada data.
                                          </td>
                                        </tr>
                                      @endforelse
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        @endfor
                      </div>
                    </div>
                </div>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <form action="{{route('autodebit.store')}}" method="POST">
                      {{csrf_field()}}
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Data Nomor</h4>
                      </div>
                      <div class="modal-body">
                        <img v-show="loading" src="{{ asset('/assets/images/Preloader_2.gif') }}" class="img-responsive" alt="loading" style="display: block;margin-left: auto;margin-right: auto;" >
                        <div v-if="dataNumber!=null">
                          <input type="hidden" name="number_save_id" :value="dataNumber.details.number.id" />
                          <div class="table-responsive">
                            <table class="table">
                              <tbody>
                                <tr>
                                  <td>
                                    nama
                                  </td>
                                  <td>
                                    @{{dataNumber.details.number.name}}
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    Nomor
                                  </td>
                                  <td>
                                    @{{dataNumber.details.number.number}}
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    Layanan
                                  </td>
                                  <td>
                                    @{{dataNumber.details.number.service_name}}
                                  </td>
                                </tr>
                                <tr v-if="dataNumber.details.number.service!=2">
                                  <td>
                                    Produk
                                  </td>
                                  <td>
                                    @{{dataNumber.details.number.product}}
                                  </td>
                                </tr>
                                <tr v-else>
                                <td>
                                  Nominal
                                </td>
                                <td>
                                <select name="ppob_service_id" class="form-control">
                                  <?php
                                    $ppob_service_id=[
                                      19=>'Voucher PLN 20.000',
                                      20=>'Voucher PLN 50.000',
                                      21=>'Voucher PLN 100.000',
                                      22=>'Voucher PLN 200.000',
                                      23=>'Voucher PLN 500.000',
                                      24=>'Voucher PLN 1.000.000'
                                    ];
                                  ?>
                                  @for($h=19;$h<=24;$h++)
                                    <option value="{{$h}}">
                                      {{$ppob_service_id[$h]}}
                                    </option>
                                  @endfor
                                </select>
                                </td>
                                </tr>
                                <tr v-if="dataNumber.details.number.autodebit_status!=1">
                                  <td>
                                    Tgl. Autodebit
                                  </td>
                                  <td>
                                    <select name="date" class="form-control">
                                      @for($i=1;$i<29;$i++)
                                        <option value="{{$i}}">
                                          {{$i}}
                                        </option>
                                      @endfor
                                    </select>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button v-show="dataNumber!=null&&dataNumber.details.number.autodebit_status!=1" type="submit" class="btn btn-primary">Simpan</button>
                      </div>
                    </form>
                    </div>
                  </div>
                </div>


                <!--
                Modal form input
               -->
               <div class="modal fade" id="myForm" tabindex="-1" role="dialog" aria-labelledby="myFormLabel">
                 <div class="modal-dialog" role="document">
                   <div class="modal-content">
                   <form action="{{route('number_saveds.store')}}" method="POST">
                     {{csrf_field()}}
                     <input type="hidden" name="service" v-model="inputForm.service" />
                     <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                       <h4 class="modal-title" id="myModalLabel">Tambahkan nomor</h4>
                     </div>
                     <div class="modal-body">
                       <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama">
                      </div>
                      <div class="form-group">
                        <label for="number">Nomor</label>
                        <input type="number" class="form-control" id="number" name="number" placeholder="Nomor">
                      </div>
                      <div class="form-group" v-if="inputForm.service!=3">
                        <label for="product">Produk</label>
                        <select class="form-control" id="product" name="ppob_service_id">
                          <option v-for="product in inputForm.products" :value="product.id">
                            @{{product.name}}
                          </option>
                        </select>
                      </div>
                      <div v-else>
                        <input type="hidden" name="ppob_service_id" v-model="inputForm.service" />
                      </div>
                     </div>
                     <div class="modal-footer">
                       <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                       <button type="submit" class="btn btn-primary">Simpan</button>
                     </div>
                   </form>
                   </div>
                 </div>
               </div>
               <div class="modal fade" id="myEdit" tabindex="-1" role="dialog" aria-labelledby="myEditLabel">
                 <div class="modal-dialog" role="document">
                   <div class="modal-content">
                   <form action="{{route('number_saveds.update')}}" method="POST">
                     {{csrf_field()}}
                     <input type="hidden" name="id" v-model="inputEdit.id" />
                     <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                       <h4 class="modal-title" id="myModalLabel">Edit data</h4>
                     </div>
                     <div class="modal-body">
                       <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" v-model="inputEdit.name" id="name" name="name" placeholder="Nama">
                      </div>
                      <div class="form-group">
                        <label for="number">Nomor</label>
                        <input type="number" class="form-control" id="number" v-model="inputEdit.number" name="number" placeholder="Nomor" disabled="disabled">
                      </div>
                     </div>
                     <div class="modal-footer">
                       <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                       <button type="submit" class="btn btn-primary">Edit</button>
                     </div>
                   </form>
                   </div>
                 </div>
               </div>
              </div>
            </div>
        </div>
    </section>
</div>
<!-- Modal -->
@endsection
@section('js')
    @parent
    <script>
    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
    Vue.http.options.emulateJSON = true;
    var autodebit = new Vue({
      el:"#autodebit",
      data:{
        url:"https://mysmartinpays.com",
        dataNumber:null,
        endPoint:"",
        loading:true,
        inputForm:{
          "service":null,
          "products":[],
        },
        inputEdit:{
          "id":null,
          "name":null,
          "number":null,
        }
      },
      methods:{
        getNumberSaved:function(numberSavedId){
          this.loading=true;
          this.dataNumber=null;
          $("#myModal").modal('show');
          this.endPoint=this.url+'/rest/number_saveds/'+numberSavedId;
          console.log("Url yang dikirim : "+this.endPoint);
          this.$http.get(this.endPoint).then((response)=>{
              // console.log(response.data);
              this.dataNumber=response.data;
              this.loading=false;

          },(response)=>{
              // console.log("FAILED")
          });
        },
        showForm:function(service){
          this.inputForm.service=service;
          this.ppobProduct(service);
          $("#myForm").modal("show");
        },
        ppobProduct:function(service_id){
          this.$http.get(this.url+"/rest/ppob/services?service_id="+service_id).then((response)=>{
            // console.log(response.data);
              this.inputForm.products=response.data.detail.services;
              console.log(this.inputForm);
          },(response)=>{
              // console.log("FAILED")
          });
        },
        editForm:function(id_number){
          this.$http.get(this.url+"/rest/number_saveds/"+id_number).then((response)=>{
            this.inputEdit.id=response.data.details.number.id;
            this.inputEdit.name=response.data.details.number.name;
            this.inputEdit.number=response.data.details.number.number;
          },(response)=>{

          });
          $("#myEdit").modal("show");
        }
      }
    });
    </script>
@endsection
