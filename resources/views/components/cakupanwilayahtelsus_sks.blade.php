<link href="/global_assets/css/extras/select2.min.css" rel="stylesheet" />
<script src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>
<style>
    .table-custom th,
    .table-custom tr,
    .table-custom td {
        border: 1px solid #ddd;
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
</style>
<?php
$datajson1 = json_decode($datajson, true);
// var_dump($datajson1['satelit']['name']);die;
?>
<div class="table-responsive">
    <h5>
        @if ($datajson == 'kosong')
            <input type="checkbox" id="toggle-sks">
        @endif
        Media Transmisi Spektrum Frekuensi Radio untuk Sistem Komunikasi Satelit
    </h5>
    <div id="content-sks">
        @if ($datajson !== 'kosong')
            <?php
            $datajson1 = json_decode($datajson, true);
            // var_dump($datajson1['satelit']['name']);die;
            ?>

            <div class="row">
                <label class="col-lg-2 col-form-label">Nama Satelit </label>: {{ $datajson1['satelit']['name'] }}
            </div>
            <div class="row">
                <label class="col-lg-2 col-form-label">Slot Orbit </label> : {{ $datajson1['satelit']['orbit'] }}
            </div>
        @else
        <div class="form-group row">
            <label for="satelit" class="col-sm-2 col-form-label">Nama Satelit </label>
            <div class="col-sm-6">
                <input type="text" class="form-control satelit-cakupanwilayahtelsus_sks"
                    name="cakupanwilayahtelsus_sks[satelit][name]">
            </div>
        </div>
        <div class="form-group row">
            <label for="orbitsatelit" class="col-sm-2 col-form-label">Slot Orbit </label>
            <div class="col-sm-6">
                <input type="text" class="form-control orbit-satelit-cakupanwilayahtelsus_sks"
                    name="cakupanwilayahtelsus_sks[satelit][orbit]">
            </div>
        </div>
        @endif

        <table class="table table-custom table-sm" style="border-spacing:0px !important;width:100%;">
            <thead>
                <tr>
                    <th style="background: #fafafa;text-align: center;">Tahun</th>
                    <th style="background: #fafafa;text-align: center;">Jumlah Transponder dan Band
                        Frekuensi yang Digunakan</th>
                    <th style="background: #fafafa;text-align: center;">Kapasitas Transponder</th>
                    <th style="background: #fafafa;text-align: center; ">Jumlah Hub</th>
                    <th style="background: #fafafa;text-align: center;">Lokasi Hub</th>
                    <th style="background: #fafafa;text-align: center;">Cakupan Wilayah Layanan
                        (Kota/Kab dan Kota/Kab Seluruh Indonesia)</th>
                    {{-- <th style="border-top: none;background: #fafafa;text-align: center;">Alamat</th> --}}

                    @if ($needcorrection == 1)
                        <th></th>
                    @endif
                </tr>
            </thead>
            <tbody id="cakupanwilayahtelsus_sks-lists">
                @if ($datajson !== 'kosong')
                    <?php
                    $datajson = json_decode($datajson, true);
                    // var_dump($datajson);
                    // dd($datajson);
                    ?>
                    @foreach ($datajson['table'] as $key => $d)
                        @if (isset($d['isdeleted']))
                            @if ($d['isdeleted'] == '1')
                                <tr class="cakupanwilayahtelsus_sks-item">
                                    @if ($triger == 'true')
                                        <td style="width: 10%;">
                                            <div style="text-align:center !important;">{{ $d['tahun'] }}</div>
                                        </td>
                                        <td style="width: 10%;">
                                            <div style="text-align:center !important;">{{ $d['jumlah-transponder'] }}
                                            </div>
                                        </td>
                                        <td>
                                            <div style="text-align:center !important;">{{ $d['kapasitas-transponder'] }}
                                            </div>
                                        </td>
                                        <td>
                                            <div style="text-align:center !important;">{{ $d['jumlah-hub'] }}</div>
                                        </td>
                                        <td>
                                            <div style="text-align:center !important;">{{ $d['lokasi-hub'] }}</div>
                                        </td>
                                        <td>
                                            <div style="text-align:center !important;">{{ $d['CWL'] }}</div>
                                        </td>
                                    @else
                                        <td style="width: 10%;">
                                            <input readonly value="{{ $d['tahun'] }}" type="number"
                                                oninput="validity.valid||(value='');" min="1"
                                                class="form-control tahun-cakupanwilayahtelsus_sks"
                                                name="cakupanwilayahtelsus_sks[table][{{ $key }}][tahun]"
                                                required />
                                        </td>
                                        <td>
                                            <input readonly value="{{ $d['jumlah-transponder'] }}" type="text"
                                                class="form-control jumlah-transponder-cakupanwilayahtelsus_sks"
                                                name="cakupanwilayahtelsus_sks[table][{{ $key }}][jumlah-transponder]"
                                                required />
                                        </td>
                                        <td>
                                            <input readonly value="{{ $d['kapasitas-transponder'] }}" type="text"
                                                class="form-control kapasitas-transponder-cakupanwilayahtelsus_sks"
                                                name="cakupanwilayahtelsus_sks[table][{{ $key }}][kapasitas-transponder]"
                                                required />
                                        </td>
                                        <td>
                                            <input readonly value="{{ $d['jumlah-hub'] }}" type="text"
                                                class="form-control jumlah-hub-cakupanwilayahtelsus_sks"
                                                name="cakupanwilayahtelsus_sks[table][{{ $key }}][jumlah-hub]"
                                                required />
                                        </td>
                                        <td>
                                            <input readonly value="{{ $d['lokasi-hub'] }}" type="text"
                                                class="form-control lokasi-hub-cakupanwilayahtelsus_sks"
                                                name="cakupanwilayahtelsus_sks[table][{{ $key }}][lokasi-hub]"
                                                required />
                                        </td>
                                        <td>
                                            <textarea class="form-control CWL-cakupanwilayahtelsus_sks"
                                                name="cakupanwilayahtelsus_sks[table][{{ $key }}][CWL]" rows="2" readonly>{{ $d['CWL'] }}</textarea>
                                        </td>
                                        @if ($needcorrection == 1)
                                            <td style="width: 10%;">
                                                <div>
                                                    <select
                                                        name="cakupanwilayahtelsus_sks[table][{{ $key }}][isdeleted]"
                                                        id=""
                                                        class="form-control isdeleted_cakupanwilayahtelsus_sks"
                                                        required>
                                                        <option
                                                            name="cakupanwilayahtelsus_sks[table][{{ $key }}][isdeleted]"
                                                            value="1" selected>Tidak</option>
                                                        <option
                                                            name="cakupanwilayahtelsus_sks[table][{{ $key }}][isdeleted]"
                                                            value="2">Hapus</option>

                                                    </select>
                                                </div>
                                            </td>
                                        @endif
                                    @endif
                                </tr>
                            @endif
                        @else
                            <tr class="cakupanwilayahtelsus_sks-item">
                                @if ($triger == 'true')
                                    <td style="width: 10%;">
                                        <div style="text-align:center !important;">{{ $d['tahun'] }}</div>
                                    </td>
                                    <td style="width: 10%;">
                                        <div style="text-align:center !important;">{{ $d['jumlah-transponder'] }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style="text-align:center !important;">{{ $d['kapasitas-transponder'] }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style="text-align:center !important;">{{ $d['jumlah-hub'] }}</div>
                                    </td>
                                    <td>
                                        <div style="text-align:center !important;">{{ $d['lokasi-hub'] }}</div>
                                    </td>
                                    <td>
                                        <div style="text-align:center !important;">{{ $d['CWL'] }}</div>
                                    </td>
                                @else
                                    <td style="width: 10%;">
                                        <input readonly value="{{ $d['tahun'] }}" type="number"
                                            oninput="validity.valid||(value='');" min="1"
                                            class="form-control tahun-cakupanwilayahtelsus_sks"
                                            name="cakupanwilayahtelsus_sks[table][{{ $key }}][tahun]"
                                            required />
                                    </td>
                                    <td>
                                        <input readonly value="{{ $d['jumlah-transponder'] }}" type="text"
                                            class="form-control jumlah-transponder-cakupanwilayahtelsus_sks"
                                            name="cakupanwilayahtelsus_sks[table][{{ $key }}][jumlah-transponder]"
                                            required />
                                    </td>
                                    <td>
                                        <input readonly value="{{ $d['kapasitas-transponder'] }}" type="text"
                                            class="form-control kapasitas-transponder-cakupanwilayahtelsus_sks"
                                            name="cakupanwilayahtelsus_sks[table][{{ $key }}][kapasitas-transponder]"
                                            required />
                                    </td>
                                    <td>
                                        <input readonly value="{{ $d['jumlah-hub'] }}" type="text"
                                            class="form-control jumlah-hub-cakupanwilayahtelsus_sks"
                                            name="cakupanwilayahtelsus_sks[table][{{ $key }}][jumlah-hub]"
                                            required />
                                    </td>
                                    <td>
                                        <input readonly value="{{ $d['lokasi-hub'] }}" type="text"
                                            class="form-control lokasi-hub-cakupanwilayahtelsus_sks"
                                            name="cakupanwilayahtelsus_sks[table][{{ $key }}][lokasi-hub]"
                                            required />
                                    </td>
                                    <td>
                                        <textarea class="form-control CWL-cakupanwilayahtelsus_sks"
                                            name="cakupanwilayahtelsus_sks[table][{{ $key }}][CWL]" rows="2" readonly>{{ $d['CWL'] }}</textarea>
                                    </td>
                                    @if ($needcorrection == 1)
                                        <td style="width: 10%;">
                                            <div>
                                                <select
                                                    name="cakupanwilayahtelsus_sks[table][{{ $key }}][isdeleted]"
                                                    id=""
                                                    class="form-control isdeleted_cakupanwilayahtelsus_sks" required>
                                                    <option
                                                        name="cakupanwilayahtelsus_sks[table][{{ $key }}][isdeleted]"
                                                        value="1" selected>Tidak</option>
                                                    <option
                                                        name="cakupanwilayahtelsus_sks[table][{{ $key }}][isdeleted]"
                                                        value="2">Hapus</option>

                                                </select>
                                            </div>
                                        </td>
                                    @endif
                                @endif
                            </tr>
                        @endif
                    @endforeach
                @else
                    @for ($i = 0; $i < 1; $i++)
                        <tr class="cakupanwilayahtelsus_sks-item">
                            <td style="width: 10%;">
                                <input type="number" oninput="validity.valid||(value='');" min="1"
                                    class="form-control tahun-cakupanwilayahtelsus_sks"
                                    name="cakupanwilayahtelsus_sks[table][{{ $i }}][tahun]" required />
                            </td>
                            <td>
                                <input type="text" class="form-control jumlah-transponder-cakupanwilayahtelsus_sks"
                                    name="cakupanwilayahtelsus_sks[table][{{ $i }}][jumlah-transponder]"
                                    required />
                            </td>
                            <td>
                                <input type="text"
                                    class="form-control kapasitas-transponder-cakupanwilayahtelsus_sks"
                                    name="cakupanwilayahtelsus_sks[table][{{ $i }}][kapasitas-transponder]"
                                    required />
                            </td>
                            <td>
                                <input type="text" class="form-control jumlah-hub-cakupanwilayahtelsus_sks"
                                    name="cakupanwilayahtelsus_sks[table][{{ $i }}][jumlah-hub]"
                                    required />
                            </td>
                            <td>
                                <textarea class="form-control lokasi-hub-cakupanwilayahtelsus_sks"
                                    name="cakupanwilayahtelsus_sks[table][{{ $i }}][lokasi-hub]" rows="2"></textarea>
                            </td>
                            <td>
                                <textarea class="form-control CWL-cakupanwilayahtelsus_sks"
                                    name="cakupanwilayahtelsus_sks[table][{{ $i }}][CWL]" rows="2"></textarea>
                            </td>
                            {{-- <td>
                                <textarea class="form-control AlamatUlo-cakupanwilayahtelsus_sks"
                                    name="cakupanwilayahtelsus_sks[table][{{ $i }}][AlamatUlo]" rows="2"></textarea>
                            </td> --}}
                            @if ($needcorrection == 1)
                                <td></td>
                            @endif
                        </tr>
                    @endfor
                @endif
            </tbody>
        </table>
        @if ($datajson == 'kosong' || $needcorrection == 1)
            <div class="text-right">
                <button class="btn btn-secondary my-2 btn-sm" type="button" id="add-cakupanwilayahtelsus_sks">Tambah
                    Data</button>
            </div>
            <script type="text/javascript">
                $('document').ready(function() {
                    let contentSks = $('#content-sks');
                    contentSks.hide();
                    contentSks.find('input').each(function(index) {
                        $(this).prop('disabled', true);
                    });
                    contentSks.find('select').each(function(index) {
                        $(this).prop('disabled', true);
                    });
                    contentSks.find('textarea').each(function(index) {
                        $(this).prop('disabled', true);
                    });

                    let show = false;
                    $('#toggle-sks').on('click', function() {
                        show = !show;
                        let contentSks = $('#content-sks');
                        if (show) {
                            contentSks.show();
                            contentSks.find('input').each(function(index) {
                                $(this).prop('disabled', false);
                            });
                            contentSks.find('select').each(function(index) {
                                $(this).prop('disabled', false);
                            });
                            contentSks.find('textarea').each(function(index) {
                                $(this).prop('disabled', false);
                            });
                        } else {
                            contentSks.hide();
                            contentSks.find('input').each(function(index) {
                                $(this).prop('disabled', true);
                            });
                            contentSks.find('select').each(function(index) {
                                $(this).prop('disabled', true);
                            });
                            contentSks.find('textarea').each(function(index) {
                                $(this).prop('disabled', true);
                            });
                        }
                    });
                });
            </script>
        @endif
    </div>
    @if ($triger != 'true')
        <small>Download Lampiran Template <a target="_blank"
                href="/storage/lampiran/telsus/badanhukum/PENJELASAN PENGISIAN DATA CAKUPAN WILAYAH LAYANAN PENYELENGGARAAN TELSUS.DOC">Disini</a></small>
    @endif

</div>

<script type="text/javascript">
    $('document').ready(function() {

        const addRencanaUsahaItem = function() {

            var cities = {!! json_encode($cities) !!};
            start = 0;
            totalRencanaUsaha = 0;
            options = ``;

            for (let item of cities) {
                options += `<option value="` + item.id + `">` + item.name + `</option>`;
            }

            initSelect2();

            function initSelect2() {
                $('.pilih-kota-cakupanwilayahtelsus_sks').each(function(index, element) {
                    $(this).select2({
                        placeholder: "Pilih Kota"
                    })
                })
            }

            function countTotalRencanaUsaha() {
                return document.querySelectorAll('.cakupanwilayahtelsus_sks-item').length - 1;
            }

            $('#add-cakupanwilayahtelsus_sks').on('click', function() {
                this.totalRencanaUsaha = countTotalRencanaUsaha() + 1;
                const inputRow =
                    `
					<tr class="cakupanwilayahtelsus_sks-item">
						<td>
							<input min="1" oninput="validity.valid||(value='');" type="number" class="form-control tahun-cakupanwilayahtelsus_sks" name="cakupanwilayahtelsus_sks[table][` +
                    this.totalRencanaUsaha +
                    `][tahun]" required />
						</td>
						<td>
							<input type="text" class="form-control jumlah-transponder-cakupanwilayahtelsus_sks" name="cakupanwilayahtelsus_sks[table][` +
                    this
                    .totalRencanaUsaha +
                    `][jumlah-transponder]" required />
						</td>
						<td>
							<input class="form-control  kapasitas-transponder-cakupanwilayahtelsus_sks" name="cakupanwilayahtelsus_sks[table][` +
                    this
                    .totalRencanaUsaha + `][kapasitas-transponder]" required />
						</td>
						<td>
							<input class="form-control jumlah-hub-cakupanwilayahtelsus_sks" name="cakupanwilayahtelsus_sks[table][` + this
                    .totalRencanaUsaha + `][jumlah-hub]" required />
						</td>
						<td>
							<textarea class="form-control lokasi-hub-cakupanwilayahtelsus_sks" name="cakupanwilayahtelsus_sks[table][` +
                    this.totalRencanaUsaha + `][lokasi-hub]" rows="2" ></textarea>
						</td>
						<td>
							<textarea class="form-control CWL-cakupanwilayahtelsus_sks" name="cakupanwilayahtelsus_sks[table][` + this
                    .totalRencanaUsaha + `][CWL]" rows="2" ></textarea>
						</td>
						<td>
							<button
								class="btn btn-danger btn-samll btn-delete-cakupanwilayahtelsus_sks"
								type="button"
								onclick="javascript:onDeleteRencanaUsahaItem(this);return false;"
							>&times;</button>
						</td>
					<tr>
				`;
                $('#cakupanwilayahtelsus_sks-lists').append(inputRow);
                initSelect2();
            });
        }

        addRencanaUsahaItem();

        $('.btn-delete-cakupanwilayahtelsus_sks').click(function(e) {
            console.log(e);
        })
        let contentSks = $('#content-sks');
        @if ($datajson == 'kosong')
            contentSks.hide();
        @else
            $('#toggle-sks').prop('checked', true);
            $('#toggle-sks').prop('disabled', true);
        @endif

        @if ($needcorrection)
            contentSks.find('input').each(function(index) {
                $(this).prop('disabled', false);
                $(this).prop('readonly', false);
            });
            contentSks.find('select').each(function(index) {
                $(this).prop('disabled', false);
                $(this).prop('readonly', false);
            });
            contentSks.find('textarea').each(function(index) {
                $(this).prop('disabled', false);
                $(this).prop('readonly', false);
            });
        @else
            contentSks.find('input').each(function(index) {
                $(this).prop('disabled', true);
                $(this).prop('readonly', true);
            });
            contentSks.find('select').each(function(index) {
                $(this).prop('disabled', true);
                $(this).prop('readonly', true);
            });
            contentSks.find('textarea').each(function(index) {
                $(this).prop('disabled', true);
                $(this).prop('readonly', true);
            });

            let show = false;
            $('#toggle-sks').on('click', function() {
                show = !show;
                let contentSks = $('#content-sks');
                if (show) {
                    contentSks.show();
                    contentSks.find('input').each(function(index) {
                        $(this).prop('disabled', false);
                        $(this).prop('readonly', false);
                    });
                    contentSks.find('select').each(function(index) {
                        $(this).prop('disabled', false);
                        $(this).prop('readonly', false);
                    });
                    contentSks.find('textarea').each(function(index) {
                        $(this).prop('disabled', false);
                        $(this).prop('readonly', false);
                    });
                } else {
                    contentSks.hide();
                    contentSks.find('input').each(function(index) {
                        $(this).prop('disabled', true);
                    });
                    contentSks.find('select').each(function(index) {
                        $(this).prop('disabled', true);
                    });
                    contentSks.find('textarea').each(function(index) {
                        $(this).prop('disabled', true);
                    });
                }
            });
        @endif


    });

    function onDeleteRencanaUsahaItem(e) {
        // remove selected item
        e.parentNode.parentNode.remove();
        // recons index
        $('.cakupanwilayahtelsus_sks-item').each(function(index, element) {
            let tahun = $(this).find('.tahun-cakupanwilayahtelsus_sks');
            let jumlah_transponder = $(this).find('.jumlah-transponder-cakupanwilayahtelsus_sks');
            let kapasitas_transponder = $(this).find('.kapasitas-transponder-cakupanwilayahtelsus_sks');
            let jumlah_hub = $(this).find('.jumlah-hub-cakupanwilayahtelsus_sks');
            let lokasi_hub = $(this).find('.lokasi-hub-cakupanwilayahtelsus_sks');
            let CWL = $(this).find('.CWL-cakupanwilayahtelsus_sks');
            // let AlamatUlo = $(this).find('AlamatUlo-cakupanwilayahtelsus_sks');
            tahun.attr('name', 'cakupanwilayahtelsus_sks[' + index + '][tahun]');
            jumlah_transponder.attr('name', 'cakupanwilayahtelsus_sks[' + index + '][jumlah-transponder]');
            kapasitas_transponder.attr('name', 'cakupanwilayahtelsus_sks[' + index +
                '][kapasitas-transponder]');
            jumlah_hub.attr('name', 'cakupanwilayahtelsus_sks[' + index + '][jumlah-hub]');
            lokasi_hub.attr('name', 'cakupanwilayahtelsus_sks[' + index + '][lokasi-hub]');
            CWL.attr('name', 'cakupanwilayahtelsus_sks[' + index + '][CWL]');
            AlamatUlo.attr('name', 'cakupanwilayahtelsus_sks[' + index + '][AlamatUlo]');
        });
    }
</script>
