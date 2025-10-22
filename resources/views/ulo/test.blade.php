@extends('layouts.frontend.main')
@section('title', 'Pengajuan Uji Laik Operasi')
@section('js')
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

	<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
	</script>

	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
	<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
@endsection

<body>
	<div class="col-md-10 bg-light  border p-3 my-3">
		<div class="form-group">
			<h3> EX 03: Disabled date from 27th aug to 30th aug 2023</h3>
			<label for="datepicker_c3">Select date</label>
			<input type="text" name="" id="datepicker_c3" class="form-control" placeholder="select date">
		</div>
	</div>
	<script>
		// Disabled date from 27th aug to 30th aug 2023
		var disabledDates1 = ["27-08-2023", "28-08-2023", "29-08-2023", "30-08-2023"];
		$('#datepicker_c3').datepicker({
			beforeShowDay: function(date) {
				var string = jQuery.datepicker.formatDate('dd-mm-yy', date);
				//var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
				return [disabledDates1.indexOf(string) == -1]
			}
		});
	</script>
</body>
