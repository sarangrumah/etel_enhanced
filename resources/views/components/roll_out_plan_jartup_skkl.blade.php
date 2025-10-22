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
                <th style="text-align: center;">Jumlah <i>Cable Landing Station</i></th>
                <th style="text-align: center;">Lokasi <i>Cable Landing Station</i> (Kab/Kota)</th>
                <th style="text-align: center;">Rute Jaringan Sistem Komunikasi Kabel Laut</th>
                <th style="text-align: center;">Jumlah Kabel Fiber Optik (core)</th>
                <th style="text-align: center;">Kapasitas <i>Bandwidth</i> (Gbps)</th>
            </tr>
        </thead>
        <tbody id="rolloutplan-lists">
            @if ($datajson != 'kosong')
                <?php
                $datajson = json_decode($datajson, true);
                ?>
                @foreach ($datajson as $key => $d)
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
                        <td style="width: 5%;">

                            <input type="number" min="1" value="{{ $d['periode'] }}"
                                {{ $is_editable ? '' : 'readonly' }} class="form-control periode"
                                name="rolloutplan[{{ $key }}][periode]" required />
                        </td>
                        <td style="width: 10%;">
                            <input type="number" min="1" value="{{ $d['jumlah_cable_landing_station'] }}"
                                {{ $is_editable ? '' : 'readonly' }} class="form-control periode"
                                name="rolloutplan[{{ $key }}][jumlah_cable_landing_station]" required />

                        </td>
                        <td style="width: 25%;">
                            <select {{ $is_editable ? '' : 'readonly' }}
                                class="form-control lokasi_cable_landing_station select-multiple w-100"
                                name="rolloutplan[{{ $key }}][lokasi_cable_landing_station][]"
                                multiple="multiple" required>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}"
                                        {{ in_array($city->id, $d['lokasi_cable_landing_station']) ? 'selected' : '' }}>
                                        {{ $city->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td style="width: 30%;">

                            {{-- <input type="number" min="1" value="{{$d['rute_jaringan_sistem_komunikasi_kabel_laut']}}" {{
                        $is_editable ? '' : 'readonly' }}
                        class="form-control rute_jaringan_sistem_komunikasi_kabel_laut"
                        name="rolloutplan[{{ $key }}][rute_jaringan_sistem_komunikasi_kabel_laut]" required /> --}}
                            <select {{ $is_editable ? '' : 'readonly' }}
                                class="form-control lokasi_cable_landing_station select-multiple w-100"
                                name="rolloutplan[{{ $key }}][rute_jaringan_sistem_komunikasi_kabel_laut][]"
                                multiple="multiple" required>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}"
                                        {{ in_array($city->id, $d['lokasi_cable_landing_station']) ? 'selected' : '' }}>
                                        {{ $city->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td style="width: 30%;">
                            <input type="number" min="1" value="{{ $d['jumlah_kabel_fiber_optik'] }}"
                                {{ $is_editable ? '' : 'readonly' }} class="form-control jumlah_kabel_fiber_optik"
                                name="rolloutplan[{{ $key }}][jumlah_kabel_fiber_optik]" multiple="multiple"
                                required />

                        </td>
                        <td style="width: 15%;">
                            <input type="text" value="{{ $d['kapasitas_bandwidth'] }}"
                                {{ $is_editable ? '' : 'readonly' }} class="form-control kapasitas_bandwidth"
                                name="rolloutplan[{{ $key }}][kapasitas_bandwidth]" required />
                        </td>
                    </tr>
                @endforeach
            @else
                @for ($i = 0; $i < 5; $i++)
                    <tr class="rolloutplan-item">
                        <td style="width: 5%;">

                            <input type="number" min="1" class="form-control periode"
                                name="rolloutplan[{{ $i }}][periode]" required />
                        </td>
                        <td style="width: 10%;">
                            <input type="number" min="1" class="form-control periode"
                                name="rolloutplan[{{ $i }}][jumlah_cable_landing_station]" required />

                        </td>
                        <td style="width: 30%;">
                            <select class="form-control lokasi_cable_landing_station select w-100"
                                name="rolloutplan[{{ $i }}][lokasi_cable_landing_station][]"
                                multiple="multiple" required />
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                            </select>
                        </td>
                        <td style="width: 30%;">

                            {{-- <input type="number" min="1" class="form-control rute_jaringan_sistem_komunikasi_kabel_laut"
                        name="rolloutplan[{{ $i }}][rute_jaringan_sistem_komunikasi_kabel_laut]" required /> --}}
                            <select class="form-control lokasi_cable_landing_station select w-100"
                                name="rolloutplan[{{ $i }}][rute_jaringan_sistem_komunikasi_kabel_laut][]"
                                multiple="multiple" required>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td style="width: 10%;">
                            <input type="number" min="1" class="form-control jumlah_kabel_fiber_optik"
                                name="rolloutplan[{{ $i }}][jumlah_kabel_fiber_optik]" multiple="multiple"
                                required />

                        </td>
                        <td style="width: 15%;">
                            <input type="text" class="form-control kapasitas_bandwidth"
                                name="rolloutplan[{{ $i }}][kapasitas_bandwidth]" required />
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
</div>

<script type="text/javascript">
    $('.select-multiple').each(function(index, element) {
        console.log(index);
        $(this).select2({
            placeholder: "Pilih Kota"
        })
    });
</script>
