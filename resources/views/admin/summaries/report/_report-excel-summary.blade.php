<html>
<body><table>
		<tr>
			<td>No</td>
			<td>Username</td>
			<td>Nama</td>
			<td>Jumlah Transaksi</td>
			<td>Market Price (IDR)</td>
			<td>Smartn Cash (IDR)</td>
			<td>Smartn Price (IDR)</td>
		</tr>
	@foreach($summaries as $key => $summary)
		<tr>
	    	<td>{{ $key+1 }}</td>
	    	<td>{{ $summary->username }}</td>
			<td>{{ $summary->name }}</td>
	    	<td>{{ $summary->total_transactions }}</td>
	    	<td>{{ $summary->total_market_price }}</td>
			<td>{{ $summary->total_smart_cash }}</td>
			<td>{{ $summary->total_market_price - $summary->total_smart_cash }}</td>
	    </tr>
	@endforeach
	</table>
</body>
</html>