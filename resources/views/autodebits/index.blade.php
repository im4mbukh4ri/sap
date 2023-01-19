@extends('layouts.public')
@section('css')
    @parent
@endsection
@section('content')
<div id="step-booking-kereta">
    <section class="section-pilih-seat">
        <div class="container">
          <div class="row">
                <div class="col-md-12">
                  <h3 class="blue-title-bog">Daftar Autodebet</h3>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>
                              Layanan
                            </th>
                            <th>
                              Produk
                            </th>
                            <th>
                              Nama
                            </th>
                            <th>
                              Nomor
                            </th>
                            <th>
                              Tgl.
                            </th>
                            <th>

                            </th>
                          </tr>
                        </thead>
                      <tbody>
                          @forelse ($user->autodebits as $key => $autodebit)
                            <tr>
                              @if($autodebit->number_saved->ppob_service->parent)
                                <td>
                                  {{$autodebit->number_saved->ppob_service->parent->name}}
                                </td>
                              @else
                                <td>
                                  {{$autodebit->number_saved->ppob_service->name}}
                                </td>
                              @endif
                              <td>
                                {{$autodebit->number_saved->ppob_service->name}}
                              </td>
                              <td>
                                {{$autodebit->number_saved->name}}
                              </td>
                              <td>
                                {{$autodebit->number_saved->number}}
                              </td>
                              <td>
                                {{$autodebit->date}}
                              </td>
                              <td>
                                <form action="{{route('autodebit.delete')}}" method="POST">
                                  {{csrf_field()}}
                                  <input type="hidden" name="id" value="{{$autodebit->id}}" />
                                  <button type="submit" class="btn btn-xs btn-danger">X</button>
                                </form>
                              </td>
                            </tr>
                          @empty
                            <tr>
                              <td colspan="6">
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
    </section>
</div>
<!-- Modal -->
@endsection
@section('js')
    @parent
@endsection
