<style>
    .table-custom th,
    .table-custom tr,
    .table-custom td {
        border: 1px solid #ddd;
        vertical-align: top;
    }

    .table-custom tr td .form-control {
        padding: 2px 10px;
    }

    .select2-selection {
        width: 100%;
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
</style>
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
                <th style="text-align: center;">Jumlah Kanal</th>
                <th style="text-align: center;">Kapasitas Pelanggan yang dilayani</th>
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
                                
                                    <input type="number" min="1" {{ $is_editable ? '' : 'readonly' }}
                                        value="{{ $d['periode'] }}" class="form-control"
                                        name="rolloutplan[{{ $key }}][periode]" required />
                                </td>
                                <td style="width: 40%;">
                                    <input type="number" min="1" {{ $is_editable ? '' : 'readonly' }}
                                        value="{{ $d['jumlah_kanal'] }}" class="form-control"
                                        name="rolloutplan[{{ $key }}][jumlah_kanal]" required />
                                </td>
                                <td style="width: 40%;">
                                    <input type="text" {{ $is_editable ? '' : 'readonly' }}
                                        value="{{ $d['kapasitas_pelanggan'] }}" class="form-control"
                                        name="rolloutplan[{{ $key }}][kapasitas_pelanggan]" required />
                                
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
                            <td style="width: 10%;">
                            
                                <input type="number" min="1" {{ $is_editable ? '' : 'readonly' }}
                                    value="{{ $d['periode'] }}" class="form-control"
                                    name="rolloutplan[{{ $key }}][periode]" required />
                            </td>
                            <td style="width: 40%;">
                                <input type="number" min="1" {{ $is_editable ? '' : 'readonly' }}
                                    value="{{ $d['jumlah_kanal'] }}" class="form-control"
                                    name="rolloutplan[{{ $key }}][jumlah_kanal]" required />
                            </td>
                            <td style="width: 40%;">
                                <input type="text" {{ $is_editable ? '' : 'readonly' }}
                                    value="{{ $d['kapasitas_pelanggan'] }}" class="form-control"
                                    name="rolloutplan[{{ $key }}][kapasitas_pelanggan]" required />
                            
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
                    
                @endforeach
            @else
                @for ($i = 0; $i < 5; $i++)
                    <tr class="rolloutplan-item">
                        <td style="width: 20%;">

                            <input type="number" min="1" class="form-control"
                                name="rolloutplan[{{ $i }}][periode]" required />
                        </td>
                        <td style="width: 40%;">
                            <input type="number" min="1" class="form-control"
                                name="rolloutplan[{{ $i }}][jumlah_kanal]" required />
                        </td>
                        <td style="width: 40%;">
                            <input type="text" class="form-control"
                                name="rolloutplan[{{ $i }}][kapasitas_pelanggan]" required />

                        </td>
                    </tr>
                @endfor
            @endif

        </tbody>
        <tfoot>
            <tr>
                <small for="" class="text-danger mr-2">* Komitmen bersifat tahunan (tidak bersifat
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
    
    $('document').ready(function() {

        const addRolloutPlanItem = function() {

            start = 0;
            totalRolloutPlan = 0;
            // console.log(options);

            function countTotalRolloutPlan() {
                return document.querySelectorAll('.rolloutplan-item').length;
            }

            $('#add-RolloutPlan').on('click', function() {
                this.totalRolloutPlan = countTotalRolloutPlan() + 1;
                options = ``;

                const inputRow =
                    `
					<tr class="rolloutplan-item">
						<td tyle="width: 5%;">
							<input min="1" oninput="validity.valid||(value='');" type="number" class="form-control periode" name="rolloutplan[` +
                    this.totalRolloutPlan + `][periode]" required />
						</td>
						<td tyle="width: 5%;">
							<input min="1" oninput="validity.valid||(value='');" type="number" class="form-control jumlah_kanal" name="rolloutplan[` +
                    this.totalRolloutPlan + `][jumlah_kanal]" required />
						</td>
						<td tyle="width: 5%;">
							<input class="form-control kapasitas_pelanggan" name="rolloutplan[` +
                    this.totalRolloutPlan + `][kapasitas_pelanggan]" required />
						</td>
						<td style="width: 5%;">
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
            let jumlah_kanal = $(this).find('.jumlah_kanal');
            let kapasitas_pelanggan = $(this).find('.kapasitas_pelanggan');
            periode.attr('name', 'rolloutplan[' + index + '][periode]');
            jumlah_kanal.attr('name', 'rolloutplan[' + index + '][jumlah_kanal]');
            kapasitas_pelanggan.attr('name', 'rolloutplan[' + index + '][kapasitas_pelanggan]');
        });
    }
</script>
