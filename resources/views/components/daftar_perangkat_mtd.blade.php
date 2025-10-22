@props(['devices' => []])

<div id="device-form-container">
	@foreach ($devices as $index => $device)
		<div class="device-form-row mb-3" data-index="{{ $index }}">
			<div class="row">
				<div class="col-md-3">
					<label for="brand_{{ $index }}">Brand</label>
					<input type="text" class="form-control" id="brand_{{ $index }}" name="devices[{{ $index }}][brand]"
						value="{{ $device['brand'] ?? '' }}">
				</div>
				<div class="col-md-3">
					<label for="sn_{{ $index }}">SN</label>
					<input type="text" class="form-control" id="sn_{{ $index }}" name="devices[{{ $index }}][sn]"
						value="{{ $device['sn'] ?? '' }}">
				</div>
				<div class="col-md-3">
					<label for="type_{{ $index }}">Type</label>
					<input type="text" class="form-control" id="type_{{ $index }}"
						name="devices[{{ $index }}][type]" value="{{ $device['type'] ?? '' }}">
				</div>
				<div class="col-md-3">
					<label for="photo_{{ $index }}">Photo</label>
					<input type="file" class="form-control" id="photo_{{ $index }}"
						name="devices[{{ $index }}][photo]">
				</div>
			</div>
			<button type="button" class="btn btn-danger mt-2" onclick="removeDeviceRow(this)">Remove</button>
		</div>
	@endforeach
</div>
<button type="button" class="btn btn-primary mt-3" onclick="addDeviceRow()">Add Device</button>

<script>
	let deviceIndex = @json(count($devices));

	function addDeviceRow() {
		const container = document.getElementById('device-form-container');
		const newRow = document.createElement('div');
		newRow.classList.add('device-form-row', 'mb-3');
		newRow.setAttribute('data-index', deviceIndex);

		newRow.innerHTML = `
            <div class="row">
                <div class="col-md-3">
                    <label for="brand_${deviceIndex}">Brand</label>
                    <input type="text" class="form-control" id="brand_${deviceIndex}" name="devices[${deviceIndex}][brand]">
                </div>
                <div class="col-md-3">
                    <label for="sn_${deviceIndex}">SN</label>
                    <input type="text" class="form-control" id="sn_${deviceIndex}" name="devices[${deviceIndex}][sn]">
                </div>
                <div class="col-md-3">
                    <label for="type_${deviceIndex}">Type</label>
                    <input type="text" class="form-control" id="type_${deviceIndex}" name="devices[${deviceIndex}][type]">
                </div>
                <div class="col-md-3">
                    <label for="photo_${deviceIndex}">Photo</label>
                    <input type="file" class="form-control" id="photo_${deviceIndex}" name="devices[${deviceIndex}][photo]">
                </div>
            </div>
            <button type="button" class="btn btn-danger mt-2" onclick="removeDeviceRow(this)">Remove</button>
        `;

		container.appendChild(newRow);
		deviceIndex++;
	}

	function removeDeviceRow(button) {
		button.closest('.device-form-row').remove();
	}
</script>
