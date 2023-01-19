<html>
<body>
		<tr>
			<td>No</td>
			<td>Waktu Transaksi</td>
			<td>Username</td>
			<td>Rekening</td>
			<td>Nomor Rekening</td>
			<td>Atas Nama</td>
			<td>Nominal</td>
			<td>Satatus</td>
		</tr>
		<?php $no =1 ;?>
	@forelse($tickets as $key => $history)
		<tr>
	    	<td>{{ $no++ }}</td>
	    	<td>{{date("d-m-Y H:i",strtotime($history->created_at))}}</td>
			<td>{{ $history->user->username }}</td>
	    	<td>{{$history->sip_bank->bank_name}}</td>
	    	<td>{{$history->sip_bank->number}}</td>
	    	<td>{{$history->sip_bank->owner_name}}</td>
	    	<td>{{ $history->nominal }}</td>
	    	<td>{{ $history->status }}</td>
	    </tr>
	@endforeach
</body>
</html>