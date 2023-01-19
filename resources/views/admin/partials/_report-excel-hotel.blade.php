<html>
<body>
		<tr>
			<td>ID Transaksi</td>
			<td>Waktu Transaksi</td>
			<td>Username</td>
			<td>Hotel</td>
			<td>Voucher</td>
			<td>Checkin</td>
			<td>Checkout</td>
			<td>Room</td>
			<td>Tamu</td>
			<td>No Telpon</td>
			<td>Market Price</td>
			<td>Smart Value</td>
			<td>Komisi</td>
			<td>Komisi 10</td>
			<td>Komisi 90</td>
			<td>Smart Price</td>
			<td>SIP</td>
			<td>Smart Point</td>
			<td>Smart Cash</td>
		</tr>
	@foreach ($bookings as $booking)
		<tr>
	    	<td>{{ $booking->id }}</td>
	    	<td>{{ $booking->created_at}}</td>
			<td>{{ $booking->user->username }}</td>
	    	<td>{{ $booking->hotel->name }}</td>
	    	<td>{{ $booking->voucher->voucher }}</td>
	    	<td>{{ $booking->checkin }}</td>
	    	<td>{{ $booking->checkout }}
	    	<td>{{ $booking->room }}</td>
	    	<td>{{ $booking->hotel_guest->title}}.{{ $booking->hotel_guest->name }}</td>
	    	<td>{{ $booking->hotel_guest->phone }}</td>
	    	@if( $booking->commission)
	    	<td>{{ $booking->total_fare }}</td>
	    	<td>{{ $booking->nta }}</td>
	    	<td>{{ $booking->nra }}</td>
	    	<td>{{ $booking->nra * 10 / 100 }}</td>
	    	<td>{{ $booking->nra * 90 / 100 }}</td>	    	
	    	<td>{{(isset($booking->commission))?$booking->total_fare-$booking->commission->member:0 }}</td>
	    	<td>{{ (isset($booking->commission))?$booking->commission->pusat:0 }}</td>
	    	<td>{{ (isset($booking->commission))?$booking->commission->bv:0 }}</td>
	    	<td>{{ (isset($booking->commission))?$booking->commission->member:0 }}</td>
	    	@else
	    	<td>0</td>
	    	<td>0</td>
	    	<td>0</td>
	    	<td>0</td>
	    	<td>0</td>
	    	<td>0</td>
	    	<td>0</td>
	    	<td>0</td>
	    	<td>0</td>
	    	@endif
	    </tr>
	@endforeach
</body>
</html>