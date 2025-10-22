<!DOCTYPE html>
<html>

<head>
	<title>PDF</title>
</head>

<body>
	@foreach ($data as $item)
		<h3>Lokasi Perangkat: {{ $item['lokasi_perangkat'] }}</h3>
		<p>Jenis Perangkat: {{ $item['jenis_perangkat'] }}</p>
		<p>Merk Perangkat: {{ $item['merk_perangkat'] }}</p>
		<p>SN Perangkat: {{ $item['sn_perangkat'] }}</p>
		<p>Tipe Perangkat: {{ $item['tipe_perangkat'] }}</p>
		<p>Buatan Perangkat: {{ $item['buatan_perangkat'] }}</p>
		<br>
	@endforeach
</body>

</html>
