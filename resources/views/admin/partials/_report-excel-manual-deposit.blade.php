<html>
<body>
		<tr>
			<td>No</td>
			<td>Waktu Transaksi</td>
			<td>Username</td>
			<td>Debet</td>
			<td>Kredit</td>
			<td>Keterangan</td>
			<td>Admin</td>
		</tr>
		<?php $no = 1;?>
	@forelse($tickets as $key => $history)
		<tr>
	    	<td>{{ $no++ }}</td>
	    	<td>{{date("d-m-Y H:i",strtotime($history->created_at))}}</td>
			<td>{{ $history->user->username }}</td>
	    	<td>{{ $history->debit }}</td>
	    	<td>{{ $history->credit }}</td>
	    	<td>{{ $history->note }}</td>
	    	<td>{{ $history->admin->username }}</td>
	    </tr>
	@endforeach
</body>
</html>