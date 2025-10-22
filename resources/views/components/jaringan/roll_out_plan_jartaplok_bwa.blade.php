{{-- <link href="/global_assets/css/extras/select2.min.css" rel="stylesheet" /> --}}
<script src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>
<script src="/global_assets/js/demo_pages/form_select2.js"></script>
{{-- <style>
    .table-custom th,
    .table-custom tr,
    .table-custom td {
        border: 1px solid #ddd;
        vertical-align: top;
    }

    .table-custom tr td .form-control {
        padding: 2px 10px;
    }

    .select2-selection--single {
        padding: 0;
    }

    .form-control {
        height: auto;
    }

    .select2-container--default .select2-selection--single {
        border-color: #ddd;
    }

    .select2-container {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        width: 100% !important;
    }

    .select2-container--default .select2-selection--multiple,
    .select2-container--default .select2-selection--multiple:focus {
        border: none !important;
        height: auto !important;
    }

    /* roll_out_plan_jartaplok_packet_switched */
</style> --}}
@php
    $is_editable = $needcorrection ?? false; // add || OR jika terdapat kondisi lainya untuk editable input dibawah
    $is_penyesuaian = $penyesuaian ?? false; // add || OR jika terdapat kondisi lainya untuk editable input dibawah
    $tgl_penetapan = $ulo->created_at ?? ''; // add || OR jika terdapat kondisi lainya untuk editable input dibawah
@endphp
<div class="table-responsive">
    <table class="table table-custom table-sm">
        <thead>
            <tr>
                <th style="text-align: center;">Periode</th>
                <th style="text-align: center;">Jumlah <i>Site</i> (Unit)</th>
                <th style="text-align: center;">Lokasi <i>Site</i> (Kab/Kota)</th>
                <th style="text-align: center;">Minimal Cakupan Layanan (Kab/Kota)</th>
                <th style="text-align: center;">Kapasitas <i>Bandwidth</i> (Mbps)</th>
            </tr>
        </thead>
        <tbody id="rolloutplan-lists">
            @if ($datajson !== 'kosong')
                <?php
                $datajson = json_decode($datajson, true);
                ?>
                @foreach ($datajson as $key => $d)
                    @if (isset($d['isdeleted']))
                        @if ($d['isdeleted'] == '1')
                            @if (\App\Helpers\DateHelper::getWorkingDays(date('Y-m-d'), date('Y') . '-02-28', []) < 20 && $is_penyesuaian)
                                @if (date('Y', strtotime('+1 year')) >= date('Y', strtotime('+' . $loop->index . ' year', strtotime($tgl_penetapan))))
                                    @php $is_editable = false @endphp
                                @else
                                    @php $is_editable = true @endphp
                                @endif
                            @elseif ($loop->first && $is_penyesuaian)
                                @php $is_editable = false @endphp
                            @elseif($is_penyesuaian)
                                @php $is_editable = true @endphp
                            @endif
                            <tr class="rolloutplan-item">
                                <td style="width: 10%;">
                                
                                    <input {{ $is_editable ? '' : 'readonly' }} value="{{ $d['periode'] }}" type="number"
                                        min="1" class="form-control periode"
                                        name="rolloutplan[{{ $key }}][periode]" required />
                                </td>
                                <td style="width: 10%;">
                                    <input {{ $is_editable ? '' : 'readonly' }} value="{{ $d['jumlah_site'] }}" type="number"
                                        min="1" class="form-control jumlah_site"
                                        name="rolloutplan[{{ $key }}][jumlah_site]" multiple="multiple" required />
                                
                                </td>
                                <td>
                                    <select {{ $is_editable ? '' : 'readonly' }}
                                        class="form-control lokasi_cable_landing_station select-multiple w-100"
                                        name="rolloutplan[{{ $key }}][lokasi_site][]" multiple="multiple" required>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}"
                                                {{ in_array($city->id, $d['lokasi_site']) ? 'selected' : '' }}>
                                                {{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select {{ $is_editable ? '' : 'readonly' }}
                                        class="form-control lokasi_cable_landing_station select-multiple w-100"
                                        name="rolloutplan[{{ $key }}][minimal_cakupan_layanan][]" multiple="multiple"
                                        required>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}"
                                                {{ in_array($city->id, $d['minimal_cakupan_layanan']) ? 'selected' : '' }}>
                                                {{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input {{ $is_editable ? '' : 'readonly' }} value="{{ $d['kapasitas_bandwidth'] }}"
                                        type="text" class="form-control kapasitas_bandwidth"
                                        name="rolloutplan[{{ $key }}][kapasitas_bandwidth]" required />
                                </td>
                                @if ($needcorrection == 1)
                                    <td style="width: 8%;">
                                            <div>
                                                <select name="rolloutplan[{{ $key }}][isdeleted]"
                                                    id="" class="form-control isdeleted_cakupanwilayahtelsus_mtk"
                                                    required>
                                                    <option
                                                        name="rolloutplan[{{ $key }}][isdeleted]"
                                                        value="1" selected>Tidak</option>
                                                    <option
                                                        name="rolloutplan[{{ $key }}][isdeleted]"
                                                        value="2">Hapus</option>
                                            
                                                </select>
                                            </div>
                                    </td>
                                @endif
                            </tr>
                        @endif
                    @else
                        @if (\App\Helpers\DateHelper::getWorkingDays(date('Y-m-d'), date('Y') . '-02-28', []) < 20 && $is_penyesuaian)
                            @if (date('Y', strtotime('+1 year')) >= date('Y', strtotime('+' . $loop->index . ' year', strtotime($tgl_penetapan))))
                                @php $is_editable = false @endphp
                            @else
                                @php $is_editable = true @endphp
                            @endif
                        @elseif ($loop->first && $is_penyesuaian)
                            @php $is_editable = false @endphp
                        @elseif($is_penyesuaian)
                            @php $is_editable = true @endphp
                        @endif
                        <tr class="rolloutplan-item">
                            <td style="width: 8%;">
                            
                                <input {{ $is_editable ? '' : 'readonly' }} value="{{ $d['periode'] }}" type="number"
                                    min="1" class="form-control periode"
                                    name="rolloutplan[{{ $key }}][periode]" required />
                            </td>
                            <td style="width: 10%;">
                                <input {{ $is_editable ? '' : 'readonly' }} value="{{ $d['jumlah_site'] }}" type="number"
                                    min="1" class="form-control jumlah_site"
                                    name="rolloutplan[{{ $key }}][jumlah_site]" multiple="multiple" required />
                            
                            </td>
                            <td style="width: 30%;">
                                <select {{ $is_editable ? '' : 'readonly' }}
                                    class="form-control lokasi_cable_landing_station select-multiple w-100"
                                    name="rolloutplan[{{ $key }}][lokasi_site][]" multiple="multiple" required>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}"
                                            {{ in_array($city->id, $d['lokasi_site']) ? 'selected' : '' }}>
                                            {{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td style="width: 30%;">
                                <select {{ $is_editable ? '' : 'readonly' }}
                                    class="form-control lokasi_cable_landing_station select-multiple w-100"
                                    name="rolloutplan[{{ $key }}][minimal_cakupan_layanan][]" multiple="multiple"
                                    required>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}"
                                            {{ in_array($city->id, $d['minimal_cakupan_layanan']) ? 'selected' : '' }}>
                                            {{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td style="width: 12%;">
                                <input {{ $is_editable ? '' : 'readonly' }} value="{{ $d['kapasitas_bandwidth'] }}"
                                    type="text" class="form-control kapasitas_bandwidth"
                                    name="rolloutplan[{{ $key }}][kapasitas_bandwidth]" required />
                            </td>
                            @if ($needcorrection == 1)
                                <td style="width: 10%;">
                                        <div>
                                            <select name="rolloutplan[{{ $key }}][isdeleted]"
                                                id="" class="form-control isdeleted_cakupanwilayahtelsus_mtk"
                                                required>
                                                <option
                                                    name="rolloutplan[{{ $key }}][isdeleted]"
                                                    value="1" selected>Tidak</option>
                                                <option
                                                    name="rolloutplan[{{ $key }}][isdeleted]"
                                                    value="2">Hapus</option>
                                        
                                            </select>
                                        </div>
                                </td>
                            @endif
                        </tr>
                    @endif
                    
                @endforeach
            @else
                @for ($i = 0; $i < 5; $i++)
                    <tr class="rolloutplan-item">
                        <td style="width: 8%;">

                            <input type="number" min="1" class="form-control periode"
                                name="rolloutplan[{{ $i }}][periode]" required />
                        </td>
                        <td style="width: 10%;">
                            <input type="number" min="1" class="form-control jumlah_site"
                                name="rolloutplan[{{ $i }}][jumlah_site]" multiple="multiple" required />

                        </td>
                        <td style="width: 30%;">
                            <select class="form-control lokasi_site select w-100"
                                name="rolloutplan[{{ $i }}][lokasi_site][]" multiple="multiple" required />
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                            </select>
                        </td>
                        <td style="width: 30%;">
                            <select type="text" class="form-control minimal_cakupan_layanan select w-100"
                                name="rolloutplan[{{ $i }}][minimal_cakupan_layanan][]" multiple="multiple"
                                required>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                            </select>
                        </td>
                        <td style="width: 12%;">
                            <input type="text" class="form-control kapasitas_bandwidth"
                                name="rolloutplan[{{ $i }}][kapasitas_bandwidth]" required />
                        </td>
                    </tr>
                @endfor
            @endif
        </tbody>
        <tfoot>
            <tr>
                <small for="" class="text-danger mr-2">*Komitmen bersifat tahunan (tidak bersifat
                    akumulasi)</small>
            </tr>
        </tfoot>
    </table>
    
    @if ($datajson == 'kosong' || $is_editable)
        <div class="text-right">
            <button class="btn btn-secondary my-2 btn-sm" type="button" id="add-RolloutPlan">Tambah Data</button>
        </div>
    @endif
</div>

<script type="text/javascript">
    $('.select-multiple').each(function(index, element) {
        $(this).select2({
            // placeholder: "Pilih Kota"
        })
    });
    
    $('document').ready(function() {

        const addRolloutPlanItem = function() {

            var cities = {!! json_encode($cities) !!};
            start = 0;
            totalRolloutPlan = 0;
            // console.log(options);

            initSelect2();

            function initSelect2() {
                $('.pilih-kota-rolloutplan').each(function(index, element) {
                    $(this).select2({
                        // placeholder: "Pilih Kota"
                    })
                })
            }

            function countTotalRolloutPlan() {
                return document.querySelectorAll('.rolloutplan-item').length;
            }

            $('#add-RolloutPlan').on('click', function() {
                this.totalRolloutPlan = countTotalRolloutPlan() + 1;
                options = ``;

                for (let item of cities) {
                    options += `<option value="` + item.id + `">` + item.name + `</option>`;
                }
                const inputRow =
                    `
					<tr class="rolloutplan-item">
						<td tyle="width: 8%;">
							<input min="1" oninput="validity.valid||(value='');" type="number" class="form-control periode" name="rolloutplan[` +
                    this.totalRolloutPlan + `][periode]" required />
						</td>
						<td tyle="width: 10%;">
							<input min="1" oninput="validity.valid||(value='');" type="number" class="form-control jumlah_site" name="rolloutplan[` +
                    this.totalRolloutPlan + `][jumlah_site]" required />
						</td>
						<td style="width: 32%;">
							<select class="form-control pilih-kota-rolloutplan lokasi_site select w-100"
								name="rolloutplan[` + this.totalRolloutPlan + `][lokasi_site][]"
								multiple="multiple"
								required />` + options + ` </select>
						</td>
						<td style="width: 30%;">
							<select
								name="rolloutplan[` + this.totalRolloutPlan + `][minimal_cakupan_layanan][]"
								class="form-control pilih-kota-rolloutplan minimal_cakupan_layanan select w-100"
                                multiple="multiple"
								required>` + options + ` </select>
						</td>
						<td style="width: 12%;">
							<input class="form-control kapasitas_bandwidth" name="rolloutplan[` + this.totalRolloutPlan + `][kapasitas_bandwidth]" required />
						</td>
						<td style="width: 10%;">
							<button
								class="btn btn-danger btn-samll btn-delete-rolloutplan"
								type="button"
								onclick="javascript:onDeleteRolloutPlanItem(this);return false;"
							>&times;</button>
						</td>
					<tr>
				`;
                $('#rolloutplan-lists').append(inputRow);
                initSelect2();
            });
        }

        addRolloutPlanItem();

        $('.btn-delete-rolloutplan').click(function(e) {
            console.log(e);
        })

    });

    function onDeleteRolloutPlanItem(e) {
        // remove selected item
        e.parentNode.parentNode.remove();
        // recons index
        $('.rolloutplan-item').each(function(index, element) {
            let periode = $(this).find('.periode');
            let jumlah_site = $(this).find('.jumlah_site');
            let lokasi_site = $(this).find('.lokasi_site');
            let minimal_cakupan_layanan = $(this).find('.minimal_cakupan_layanan');
            let kapasitas_bandwidth = $(this).find('.kapasitas_bandwidth');
            periode.attr('name', 'rolloutplan[' + index + '][periode]');
            jumlah_site.attr('name', 'rolloutplan[' + index + '][jumlah_site]');
            lokasi_site.attr('name', 'rolloutplan[' + index + '][lokasi_site]');
            minimal_cakupan_layanan.attr('name', 'rolloutplan[' + index + '][minimal_cakupan_layanan]');
            kapasitas_bandwidth.attr('name', 'rolloutplan[' + index + '][kapasitas_bandwidth]');
        });
    }
</script>
