<html>
<body>
		<tr>
			<td>ID Transaksi</td>
			<td>Waktu Transaksi</td>
			<td>Username</td>
			<td>Produk</td>
			<td>No. Pelanggan</td>
			<td>Market Price</td>
			<td>Smart Value</td>
			<td>Smart Price</td>
			<td>Komisi</td>
			<td>Komisi 10</td>
			<td>Komisi 90</td>
			<td>Subsidi</td>
			<td>SIP</td>
			<td>Smart Point</td>
			<td>Smart Cash</td>
			<td>Smart Upline</td>
			<td>Markup Smart Point</td>
		</tr>
	{{-- @foreach ($transactions as $transaction)
		<tr>
	    	<td>{{ $transaction->id }}</td>
	    	<td>{{ $transaction->created_at }}</td>
			<td>{{ $transaction->user->username }}</td>
	    	<td>{{ $transaction->ppob_service->name }}</td>
	    	<td>{{ $transaction->number }}</td>
	    	<td>{{ $transaction->paxpaid }}</td>
	    	<td>{{ $transaction->nta }} </td>
	    	<td>{{ ($transaction->transaction_commission)?$transaction->paxpaid-$transaction->transaction_commission->member:0 }}</td>
	    	<td>{{ $transaction->nra }}</td>
	    	@if($transaction->transaction_commission)
	    	<td>{{ $transaction->transaction_commission->free}}</td>
	    	<td>{{ $transaction->transaction_commission->komisi}}</td>
	    	<td>{{ ($transaction->nta+$transaction->nra)-$transaction->paxpaid }}</td>
	    	<td>{{ $transaction->transaction_commission->pusat}}</td>
	    	<td>{{ $transaction->transaction_commission->bv }}</td>
	    	<td>{{ $transaction->transaction_commission->member }}</td>
	    	<td>{{ $transaction->transaction_commission->upline }}</td>
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
	@endforeach --}}
	@foreach ($transactions as $transaction)
		<tr>
			<td>{{ $transaction->id }}</td>
			<td>{{ $transaction->created_at }}</td>
			<td>{{ $transaction->username }}</td>
			<td>{{ $transaction->service }} {{ $transaction->name }}</td>
			<td>{{ $transaction->number }}</td>
			<td>{{ $transaction->paxpaid }}</td>
			<td>{{ $transaction->nta }}</td>
			<td>{{ (int) $transaction->paxpaid -  $transaction->commission_member }}</td>
			<td>{{ $transaction->nra }}</td>
			<td>{{ $transaction->commission_free }}</td>
			<td>{{ $transaction->commission_komisi }}</td>
			<td>{{ ((int) $transaction->nta + (int) $transaction->nra + (int) $transaction->bv_markup ) - (int) $transaction->paxpaid}}</td>
			<td>{{ $transaction->commission_pusat }}</td>
			<td>{{ $transaction->commission_bv }}</td>
			<td>{{ $transaction->commission_member }}</td>
			<td>{{ $transaction->commission_upline }}</td>
			<td>{{ $transaction->bv_markup }}</td>
		</tr>
	@endforeach
</body>
</html>
