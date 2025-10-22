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
<div class="table-responsive">
    <h5>
        @if ($datajson == 'kosong')
            <input type="checkbox" id="toggle-mtk">
        @endif
        Media Transmisi Kawat/Serat Optik
    </h5>
    {{-- @dump($needcorrection) --}}
    <div id="content-mtk">
        <table class="table table-custom table-sm" style="border-spacing:0px !important;width:100%;">
            <thead>
                <tr>
                    <th style="border-top: none;background: #fafafa;text-align: center;">Tahun</th>
                    <th style="border-top: none;background: #fafafa;text-align: center;">Rute</th>
                    <th style="border-top: none;background: #fafafa;text-align: center;">Panjang Rute (Km)</th>
                    <th style="border-top: none;background: #fafafa;text-align: center;">Kapasitas (Core)</th>
                    <th style="border-top: none;background: #fafafa;text-align: center;">Cakupan Wilayah Layanan</th>
                    {{-- <th style="border-top: none;background: #fafafa;text-align: center;">Alamat</th> --}}
                    @if ($needcorrection == 1)
                        <th></th>
                    @endif
                </tr>
            </thead>
            <tbody id="cakupanwilayahtelsus_mtk-lists">
                @if ($datajson !== 'kosong')
                    <?php
                    $datajson = json_decode($datajson, true);
                    // dd($datajson);
                    ?>
                    @foreach ($datajson as $key => $d)
                        @if (isset($d['isdeleted']))
                            @if ($d['isdeleted'] == '1')
                                <tr class="cakupanwilayahtelsus_mtk-item">
                                    @if ($triger == 'true')
                                        <td style="width: 10%;">
                                            <div style="text-align:center !important;">{{ $d['tahun'] }}</div>
                                        </td>
                                        <td>
                                            <div style="text-align:center !important;">{{ $d['rute'] }}</div>
                                        </td>
                                        <td>
                                            <div style="text-align:center !important;">{{ $d['panjang-rute'] }}</div>
                                        </td>
                                        <td>
                                            <div style="text-align:center !important;">{{ $d['kapasitas'] }}</div>
                                        </td>
                                        <td>
                                            <div style="text-align:center !important;">{{ $d['CWL'] }}</div>
                                        </td>
                                    @else
                                        <td style="width: 10%;">
                                            <input readonly value="{{ $d['tahun'] }}" type="number"
                                                oninput="validity.valid||(value='');" min="0"
                                                class="form-control tahun-cakupanwilayahtelsus_mtk"
                                                name="cakupanwilayahtelsus_mtk[{{ $key }}][tahun]" required />
                                        </td>
                                        <td>
                                            <input readonly value="{{ $d['rute'] }}" type="text"
                                                class="form-control rute-cakupanwilayahtelsus_mtk"
                                                name="cakupanwilayahtelsus_mtk[{{ $key }}][rute]" required />
                                        </td>
                                        <td>
                                            <input readonly value="{{ $d['panjang-rute'] }}" type="text"
                                                class="form-control panjang-rute-cakupanwilayahtelsus_mtk"
                                                name="cakupanwilayahtelsus_mtk[{{ $key }}][panjang-rute]"
                                                required />
                                        </td>
                                        <td>
                                            <input readonly value="{{ $d['kapasitas'] }}" type="text"
                                                class="form-control kapasitas-cakupanwilayahtelsus_mtk"
                                                name="cakupanwilayahtelsus_mtk[{{ $key }}][kapasitas]"
                                                required />
                                        </td>
                                        <td>
                                            <textarea class="form-control CWL-cakupanwilayahtelsus_mtk" name="cakupanwilayahtelsus_mtk[{{ $key }}][CWL]"
                                                rows="2" readonly>{{ $d['CWL'] }}</textarea>
                                        </td>
                                        @if ($needcorrection == 1)
                                            <td style="width: 10%;">
                                                <div>
                                                    <select
                                                        name="cakupanwilayahtelsus_mtk[{{ $key }}][isdeleted]"
                                                        id=""
                                                        class="form-control isdeleted_cakupanwilayahtelsus_mtk"
                                                        required>
                                                        <option
                                                            name="cakupanwilayahtelsus_mtk[{{ $key }}][isdeleted]"
                                                            value="1" selected>Tidak</option>
                                                        <option
                                                            name="cakupanwilayahtelsus_mtk[{{ $key }}][isdeleted]"
                                                            value="2">Hapus</option>

                                                    </select>
                                                </div>
                                            </td>
                                        @endif
                                    @endif

                                </tr>
                            @endif
                        @else
                            <tr class="cakupanwilayahtelsus_mtk-item">
                                @if ($triger == 'true')
                                    <td style="width: 10%;">
                                        <div style="text-align:center !important;">{{ $d['tahun'] }}</div>
                                    </td>
                                    <td>
                                        <div style="text-align:center !important;">{{ $d['rute'] }}</div>
                                    </td>
                                    <td>
                                        <div style="text-align:center !important;">{{ $d['panjang-rute'] }}</div>
                                    </td>
                                    <td>
                                        <div style="text-align:center !important;">{{ $d['kapasitas'] }}</div>
                                    </td>
                                    <td>
                                        <div style="text-align:center !important;">{{ $d['CWL'] }}</div>
                                    </td>
                                @else
                                    <td style="width: 10%;">
                                        <input readonly value="{{ $d['tahun'] }}" type="number"
                                            oninput="validity.valid||(value='');" min="0"
                                            class="form-control tahun-cakupanwilayahtelsus_mtk"
                                            name="cakupanwilayahtelsus_mtk[{{ $key }}][tahun]" required />
                                    </td>
                                    <td>
                                        <input readonly value="{{ $d['rute'] }}" type="text"
                                            class="form-control rute-cakupanwilayahtelsus_mtk"
                                            name="cakupanwilayahtelsus_mtk[{{ $key }}][rute]" required />
                                    </td>
                                    <td>
                                        <input readonly value="{{ $d['panjang-rute'] }}" type="text"
                                            class="form-control panjang-rute-cakupanwilayahtelsus_mtk"
                                            name="cakupanwilayahtelsus_mtk[{{ $key }}][panjang-rute]"
                                            required />
                                    </td>
                                    <td>
                                        <input readonly value="{{ $d['kapasitas'] }}" type="text"
                                            class="form-control kapasitas-cakupanwilayahtelsus_mtk"
                                            name="cakupanwilayahtelsus_mtk[{{ $key }}][kapasitas]" required />
                                    </td>
                                    <td>
                                        <textarea class="form-control CWL-cakupanwilayahtelsus_mtk" name="cakupanwilayahtelsus_mtk[{{ $key }}][CWL]"
                                            rows="2" readonly>{{ $d['CWL'] }}</textarea>
                                    </td>
                                    @if ($needcorrection == 1)
                                        <td style="width: 10%;">
                                            <div>
                                                <select name="cakupanwilayahtelsus_mtk[{{ $key }}][isdeleted]"
                                                    id=""
                                                    class="form-control isdeleted_cakupanwilayahtelsus_mtk" required>
                                                    <option
                                                        name="cakupanwilayahtelsus_mtk[{{ $key }}][isdeleted]"
                                                        value="1" selected>Tidak</option>
                                                    <option
                                                        name="cakupanwilayahtelsus_mtk[{{ $key }}][isdeleted]"
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
                        <tr class="cakupanwilayahtelsus_mtk-item">
                            <td style="width: 15%;">
                                <input type="number" oninput="validity.valid||(value='');" min="1"
                                    class="form-control tahun-cakupanwilayahtelsus_mtk"
                                    name="cakupanwilayahtelsus_mtk[{{ $i }}][tahun]" required />
                            </td>
                            <td>
                                <input type="text" class="form-control rute-cakupanwilayahtelsus_mtk"
                                    name="cakupanwilayahtelsus_mtk[{{ $i }}][rute]" required />
                            </td>
                            <td>
                                <input type="text" class="form-control panjang-rute-cakupanwilayahtelsus_mtk"
                                    name="cakupanwilayahtelsus_mtk[{{ $i }}][panjang-rute]" required />
                            </td>
                            <td>
                                <input type="text" class="form-control kapasitas-cakupanwilayahtelsus_mtk"
                                    name="cakupanwilayahtelsus_mtk[{{ $i }}][kapasitas]" required />
                            </td>
                            <td>
                                <textarea class="form-control CWL-cakupanwilayahtelsus_mtk" name="cakupanwilayahtelsus_mtk[{{ $i }}][CWL]"
                                    rows="2"></textarea>
                            </td>
                            {{-- <td>
                                <textarea class="form-control AlamatUlo-cakupanwilayahtelsus_mtk"
                                    name="cakupanwilayahtelsus_mtk[{{ $i }}][AlamatUlo]" rows="2"></textarea>
                            </td> --}}
                            <td></td>
                        </tr>
                    @endfor
                @endif
            </tbody>
        </table>
        @if ($datajson == 'kosong' || $needcorrection == 1)
            <div class="text-right">
                <button class="btn btn-secondary my-2 btn-sm" type="button" id="add-cakupanwilayahtelsus_mtk">Tambah
                    Data</button>
            </div>

            {{-- <script type="text/javascript">
                $('document').ready(function() {
                    let contentMtk = $('#content-mtk');
                    contentMtk.hide();
                    contentMtk.find('input').each(function(index) {
                        $(this).prop('disabled', true);
                    });
                    contentMtk.find('select').each(function(index) {
                        $(this).prop('disabled', true);
                    });
                    contentMtk.find('textarea').each(function(index) {
                        $(this).prop('disabled', true);
                    });

                    let show = false;
                    $('#toggle-mtk').on('click', function() {
                        show = !show;
                        let contentMtk = $('#content-mtk');
                        if (show) {
                            contentMtk.show();
                            contentMtk.find('input').each(function(index) {
                                $(this).prop('disabled', false);
                                $(this).prop('readonly', false);
                            });
                            contentMtk.find('select').each(function(index) {
                                $(this).prop('disabled', false);
                                $(this).prop('readonly', false);
                            });
                            contentMtk.find('textarea').each(function(index) {
                                $(this).prop('disabled', false);
                                $(this).prop('readonly', false);
                            });
                        } else {
                            contentMtk.hide();
                            contentMtk.find('input').each(function(index) {
                                $(this).prop('disabled', true);
                                $(this).prop('readonly', true);
                            });
                            contentMtk.find('select').each(function(index) {
                                $(this).prop('disabled', true);
                                $(this).prop('readonly', true);
                            });
                            contentMtk.find('textarea').each(function(index) {
                                $(this).prop('disabled', true);
                                $(this).prop('readonly', true);
                            });
                        }
                    });

                });
            </script> --}}
        @endif
    </div>

    @if ($triger != 'true')
        <small>Download Lampiran Template <a target="_blank"
                href="/storage/lampiran/telsus/badanhukum/PENJELASAN PENGISIAN DATA CAKUPAN WILAYAH LAYANAN PENYELENGGARAAN TELSUS.DOC
		">Disini</a></small>
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
                $('.pilih-kota-cakupanwilayahtelsus_mtk').each(function(index, element) {
                    $(this).select2({
                        placeholder: "Pilih Kota"
                    })
                })
            }

            function countTotalRencanaUsaha() {
                return document.querySelectorAll('.cakupanwilayahtelsus_mtk-item').length;
            }

            $('#add-cakupanwilayahtelsus_mtk').on('click', function() {
                this.totalRencanaUsaha = countTotalRencanaUsaha() + 1;
                const inputRow =
                    `
					<tr class="cakupanwilayahtelsus_mtk-item">
						<td>
							<input min="1" oninput="validity.valid||(value='');" type="number" class="form-control tahun-cakupanwilayahtelsus_mtk" name="cakupanwilayahtelsus_mtk[` +
                    this.totalRencanaUsaha + `][tahun]" required />
						</td>
						<td>
							<input type="text" class="form-control rute-cakupanwilayahtelsus_mtk" name="cakupanwilayahtelsus_mtk[` + this
                    .totalRencanaUsaha +
                    `][rute]" required />
						</td>
						<td>
							<input type="text"  class="form-control panjang-rute-cakupanwilayahtelsus_mtk" name="cakupanwilayahtelsus_mtk[` +
                    this
                    .totalRencanaUsaha + `][panjang-rute]" required />
						</td>
						<td>
							<input type="text" class="form-control kapasitas-cakupanwilayahtelsus_mtk" name="cakupanwilayahtelsus_mtk[` +
                    this.totalRencanaUsaha + `][kapasitas]" required />
						</td>
						<td>
							<textarea class="form-control CWL-cakupanwilayahtelsus_mtk" name="cakupanwilayahtelsus_mtk[` + this
                    .totalRencanaUsaha + `][CWL]" rows="2" ></textarea>
						</td>
					
						<td>
							<button
								class="btn btn-danger btn-samll btn-delete-cakupanwilayahtelsus_mtk"
								type="button"
								onclick="javascript:onDeleteRencanaUsahaItem(this);return false;"
							>&times;</button>
						</td>
					<tr>
				`;
                $('#cakupanwilayahtelsus_mtk-lists').append(inputRow);
                initSelect2();
            });
        }

        addRencanaUsahaItem();

        $('.btn-delete-cakupanwilayahtelsus_mtk').click(function(e) {
            console.log(e);
        })


        let contentMtk = $('#content-mtk');
        @if ($datajson == 'kosong')
            contentMtk.hide();
        @else
            $('#toggle-mtk').prop('checked', true);
            $('#toggle-mtk').prop('disabled', true);
        @endif

        @if ($needcorrection)
            contentMtk.find('input').each(function(index) {
                $(this).prop('disabled', false);
                $(this).prop('readonly', false);
            });
            contentMtk.find('select').each(function(index) {
                $(this).prop('disabled', false);
                $(this).prop('readonly', false);
            });
            contentMtk.find('textarea').each(function(index) {
                $(this).prop('disabled', false);
                $(this).prop('readonly', false);
            });
        @else
            contentMtk.find('input').each(function(index) {
                $(this).prop('disabled', true);
                $(this).prop('readonly', true);
            });
            contentMtk.find('select').each(function(index) {
                $(this).prop('disabled', true);
                $(this).prop('readonly', true);
            });
            contentMtk.find('textarea').each(function(index) {
                $(this).prop('disabled', true);
                $(this).prop('readonly', true);
            });
            let show = false;
            $('#toggle-mtk').on('click', function() {
                show = !show;
                let contentMtk = $('#content-mtk');
                if (show) {
                    contentMtk.show();
                    contentMtk.find('input').each(function(index) {
                        $(this).prop('disabled', false);
                        $(this).prop('readonly', false);
                    });
                    contentMtk.find('select').each(function(index) {
                        $(this).prop('disabled', false);
                        $(this).prop('readonly', false);
                    });
                    contentMtk.find('textarea').each(function(index) {
                        $(this).prop('disabled', false);
                        $(this).prop('readonly', false);
                    });
                } else {
                    contentMtk.hide();
                    contentMtk.find('input').each(function(index) {
                        $(this).prop('disabled', true);
                        $(this).prop('readonly', true);
                    });
                    contentMtk.find('select').each(function(index) {
                        $(this).prop('disabled', true);
                        $(this).prop('readonly', true);
                    });
                    contentMtk.find('textarea').each(function(index) {
                        $(this).prop('disabled', true);
                        $(this).prop('readonly', true);
                    });
                }
            });
        @endif
    });

    function onDeleteRencanaUsahaItem(e) {
        // remove selected item
        e.parentNode.parentNode.remove();
        // recons index
        $('.cakupanwilayahtelsus_mtk-item').each(function(index, element) {
            let tahun = $(this).find('.tahun-cakupanwilayahtelsus_mtk');
            let rute = $(this).find('.rute-cakupanwilayahtelsus_mtk');
            let panjangrute = $(this).find('.panjang-rute-cakupanwilayahtelsus_mtk');
            let kapasitas = $(this).find('.kapasitas-cakupanwilayahtelsus_mtk');
            let CWL = $(this).find('.CWL-cakupanwilayahtelsus_mtk');
            // let AlamatUlo = $(this).find('.AlamatUlo-cakupanwilayahtelsus_mtk');
            tahun.attr('name', 'cakupanwilayahtelsus_mtk[' + index + '][tahun]');
            rute.attr('name', 'cakupanwilayahtelsus_mtk[' + index + '][rute]');
            panjangrute.attr('name', 'cakupanwilayahtelsus_mtk[' + index + '][panjang-rute]');
            kapasitas.attr('name', 'cakupanwilayahtelsus_mtk[' + index + '][kapasitas]');
            CWL.attr('name', 'cakupanwilayahtelsus_mtk[' + index + '][CWL]');
            AlamatUlo.attr('name', 'cakupanwilayahtelsus_mtk[' + index + '][AlamatUlo]');
        });
    }
</script>
