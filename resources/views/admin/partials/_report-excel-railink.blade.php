<html>
<body>
		<tr>
			<td>ID Transaksi</td>
			<td>Waktu Transaksi</td>
			<td>Username</td>
			<td>Railink</td>
			<td>PNR</td>
			<td>Rute</td>
			<td>Smart Value</td>
			<td>Komisi</td>
			<td>Komisi 10</td>
			<td>Komisi 90</td>
			<td>SIP</td>
			<td>Smart Point</td>
			<td>Smart Cash</td>
			<td>Smart Upline</td>
		</tr>
	@foreach ($bookings as $booking)
		<tr>
	    	<td>{{ $booking->transaction->id }}</td>
	    	<td>{{ $booking->created_at }}</td>
			<td>{{ $booking->transaction->user->username }}</td>
	    	<td>{{ $booking->train_name}}</td>
	    	<td>{{ $booking->pnr }}</td>
	    	<td>{{ $booking->origin }} - {{ $booking->destination }}</td>
	    	<td>{{ $booking->nta }} </td>
	    	<td>{{ $booking->nra }}</td>
	    	@if($booking->transaction_commission)
	    	<td>{{ $booking->transaction_commission->free}}</td>
	    	<td>{{ $booking->transaction_commission->komisi}}</td>
	    	<td>{{ $booking->transaction_commission->pusat}}</td>
	    	<td>{{ $booking->transaction_commission->bv }}</td>
	    	<td>{{ $booking->transaction_commission->member }}</td>
	    	<td>{{ $booking->transaction_commission->upline }}</td>
	    	@else
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