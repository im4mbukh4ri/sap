@extends('layouts.public')
@section('css')
    @parent
@endsection
@section('content')
    <section class="section-pilih-seat">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="blue-title-big">MONITORING PASSENGER</h3>
                    <br>
                    <div class="table-responsive dataTable">
                        <table id="data-table" class="text-center table table-striped table-bordered dt-responsive nowrap table-custom-blue">
                            <thead>
                            <tr>
                                <th class="text-center">No. & Tgl. Transaksi</th>
                                <th class="text-center">PNR</th>
                                <th class="text-center">Time Limit</th>
                                <th class="text-center">Pemesan</th>
                                <th class="text-center">Penumpang</th>
                                <th class="text-center">Status</th>
                                <th></th>
                            </tr>

                            </thead>
                            <tbody>
                            @forelse($bookings as $booking)
                                <tr>
                                    <td><strong>{{ $booking->transaction->user->username }}</strong><br><strong>{{$booking->transaction->id}}</strong><br>{{date("d M y H:i",strtotime($booking->created_at))}}</td>
                                    <td>{{ acName($booking->airlines_code) }}<br>
                                        <strong style="color: red;">{{ $booking->itineraries->first()->pnr }}</strong><br>
                                        {!!($booking)?$booking->origin:'<label class=\'label label-danger\'>Error</label>'!!} - {!!($booking)?$booking->destination:'<label class=\'label label-danger\'>Error</label>'!!}
                                    </td>
                                    <td>{{date("d M y H:i:s",strtotime($booking->transaction->expired))}}</td>
                                    <td style="text-align: left;">{{$booking->transaction->buyer->name}}<br>{{$booking->transaction->buyer->phone}}<br>{{$booking->transaction->buyer->email}}</td>
                                    <td style="text-align: left;">
                                        <ol>
                                        @foreach($booking->transaction->passengers as $passenger)
                                            <li>{{ $passenger->title }}. {{ $passenger->first_name }} {{ $passenger->last_name }}</li>
                                        @endforeach
                                        </ol>
                                    </td>
                                    <td><label class='label label-primary'>BOOKED</label></td>
                                    <td><a href="{{ route('admin.operational_airlines_cancel_booking',$booking->transaction->id) }}" class="btn btn-md btn-danger"><span class="fa fa-close"></span></a></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">Tidak ada data</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="pull-right">
                            {!! $bookings->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    @parent
@endsection