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
            <input type="checkbox" id="toggle-skrd">
        @endif
        Media Transmisi Spektrum Frekuensi Radio untuk Sistem Komunikasi Radio untuk Data
    </h5>
    <div id="content-skrd">
        <table class="table table-custom table-sm" style="border-spacing:0px !important;width:100%;">
            <thead>
                <tr>
                    {{-- <th style="border-top: none;background: #fafafa;text-align: center;">No</th> --}}
                    <th style="border-top: none;background: #fafafa;text-align: center;">Tahun</th>
                    <th style="border-top: none;background: #fafafa;text-align: center;">Lokasi Perangkat (Kota/Kab)
                    </th>
                    <th style="border-top: none;background: #fafafa;text-align: center;">Jenis Perangkat</th>
                    @if ($triger !== 'true')
                        <th style="border-top: none;background: #fafafa;text-align: center;">Jumlah Perangkat</th>
                    @endif
                    <th style="border-top: none;background: #fafafa;text-align: center;">Cakupan Wilayah Layanan</th>
                    {{-- <th style="border-top: none;background: #fafafa;text-align: center;">Alamat</th> --}}

                    @if ($needcorrection == 1)
                        <th></th>
                    @endif
                </tr>
            </thead>
            <tbody id="cakupanwilayahtelsus_skrd-lists">
                @if ($datajson !== 'kosong')
                    <?php
                    $datajson = json_decode($datajson, true);
                    // var_dump($datajson);
                    // dd($datajson);
                    ?>
                    @foreach ($datajson as $key => $d)
                        @if (isset($d['isdeleted']))
                            @if ($d['isdeleted'] == '1')
                                <tr class="cakupanwilayahtelsus_skrd-item">
                                    @if ($triger == 'true')
                                        <td style="width: 10%;">
                                            <div style="text-align:center !important;">{{ $d['tahun'] }}</div>
                                        </td>
                                    @else
                                        <td style="width: 10%;">
                                            <input readonly value="{{ $d['tahun'] }}" type="number"
                                                oninput="validity.valid||(value='');" min="1"
                                                class="form-control tahun-cakupanwilayahtelsus_skrd"
                                                name="cakupanwilayahtelsus_skrd[{{ $key }}][tahun]" required />
                                        </td>
                                    @endif

                                    <td style="width: 20%;">
                                        @if ($triger == 'true')
                                            @foreach ($cities as $city)
                                                @if ($d['kota'] == $city->id)
                                                    <div style="text-align:center !important;">{{ $city->name }}</div>
                                                @endif
                                            @endforeach
                                        @else
                                            <select name="cakupanwilayahtelsus_skrd[{{ $key }}][kota]"
                                                id="" class="form-control pilih-kota-cakupanwilayahtelsus_skrd"
                                                required />
                                            <option value="">Pilih kota</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}" <?php echo $d['kota'] == $city->id ? 'selected' : ''; ?>>
                                                    {{ $city->name }}
                                                </option>
                                            @endforeach
                                            </select>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($triger == 'true')
                                            <div style="text-align:center !important;">{{ $d['jenis-perangkat'] }}
                                            </div>
                                        @else
                                            <input readonly value="{{ $d['jenis-perangkat'] }}" type="text"
                                                class="form-control jenis-perangkat-cakupanwilayahtelsus_skrd"
                                                name="cakupanwilayahtelsus_skrd[{{ $key }}][jenis-perangkat]"
                                                required />
                                        @endif
                                    </td>
                                    @if ($triger == 'true')
                                        {{-- <div style="text-align:center !important;">{{ $d['jumlah-perangkat'] }}
                                            </div> --}}
                                    @else
                                        <td>
                                            <input readonly value="{{ $d['jumlah-perangkat'] }}" type="text"
                                                class="form-control jumlah-perangkat-cakupanwilayahtelsus_skrd"
                                                name="cakupanwilayahtelsus_skrd[{{ $key }}][jumlah-perangkat]"
                                                required />
                                        </td>
                                    @endif
                                    <td>
                                        @if ($triger == 'true')
                                            <div style="text-align:center !important;">{{ $d['CWL'] }}
                                            </div>
                                        @else
                                            <textarea class="form-control CWL-cakupanwilayahtelsus_skrd" name="cakupanwilayahtelsus_skrd[{{ $key }}][CWL]"
                                                rows="2" readonly>{{ $d['CWL'] }}</textarea>
                                        @endif
                                    </td>
                                    @if ($triger != 'true')
                                        @if ($needcorrection == 1)
                                            <td style="width: 10%;">
                                                <div>
                                                    <select
                                                        name="cakupanwilayahtelsus_skrd[{{ $key }}][isdeleted]"
                                                        id=""
                                                        class="form-control isdeleted_cakupanwilayahtelsus_skrd"
                                                        required>
                                                        <option
                                                            name="cakupanwilayahtelsus_skrd[{{ $key }}][isdeleted]"
                                                            value="1" selected>Tidak</option>
                                                        <option
                                                            name="cakupanwilayahtelsus_skrd[{{ $key }}][isdeleted]"
                                                            value="2">Hapus</option>

                                                    </select>
                                                </div>
                                            </td>
                                        @endif
                                    @endif
                                </tr>
                            @endif
                        @else
                            <tr class="cakupanwilayahtelsus_skrd-item">
                                @if ($triger == 'true')
                                    <td style="width: 10%;">
                                        <div style="text-align:center !important;">{{ $d['tahun'] }}</div>
                                    </td>
                                @else
                                    <td style="width: 10%;">
                                        <input readonly value="{{ $d['tahun'] }}" type="number"
                                            oninput="validity.valid||(value='');" min="1"
                                            class="form-control tahun-cakupanwilayahtelsus_skrd"
                                            name="cakupanwilayahtelsus_skrd[{{ $key }}][tahun]" required />
                                    </td>
                                @endif

                                <td style="width: 20%;">
                                    @if ($triger == 'true')
                                        @foreach ($cities as $city)
                                            @if ($d['kota'] == $city->id)
                                                <div style="text-align:center !important;">{{ $city->name }}</div>
                                            @endif
                                        @endforeach
                                    @else
                                        <select name="cakupanwilayahtelsus_skrd[{{ $key }}][kota]"
                                            id="" class="form-control pilih-kota-cakupanwilayahtelsus_skrd"
                                            required />
                                        <option value="">Pilih kota</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" <?php echo $d['kota'] == $city->id ? 'selected' : ''; ?>>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                        </select>
                                    @endif
                                </td>
                                <td>
                                    @if ($triger == 'true')
                                        <div style="text-align:center !important;">{{ $d['jenis-perangkat'] }}
                                        </div>
                                    @else
                                        <input readonly value="{{ $d['jenis-perangkat'] }}" type="text"
                                            class="form-control jenis-perangkat-cakupanwilayahtelsus_skrd"
                                            name="cakupanwilayahtelsus_skrd[{{ $key }}][jenis-perangkat]"
                                            required />
                                    @endif
                                </td>
                                @if ($triger == 'true')
                                    {{-- <div style="text-align:center !important;">{{ $d['jumlah-perangkat'] }}
                                    </div> --}}
                                @else
                                    <td>
                                        <input readonly value="{{ $d['jumlah-perangkat'] }}" type="text"
                                            class="form-control jumlah-perangkat-cakupanwilayahtelsus_skrd"
                                            name="cakupanwilayahtelsus_skrd[{{ $key }}][jumlah-perangkat]"
                                            required />
                                    </td>
                                @endif
                                <td>
                                    @if ($triger == 'true')
                                        <div style="text-align:center !important;">{{ $d['CWL'] }}
                                        </div>
                                    @else
                                        <textarea class="form-control CWL-cakupanwilayahtelsus_skrd" name="cakupanwilayahtelsus_skrd[{{ $key }}][CWL]"
                                            rows="2" readonly>{{ $d['CWL'] }}</textarea>
                                    @endif
                                </td>
                                @if ($triger != 'true')
                                    @if ($needcorrection == 1)
                                        <td style="width: 10%;">
                                            <div>
                                                <select
                                                    name="cakupanwilayahtelsus_skrd[{{ $key }}][isdeleted]"
                                                    id=""
                                                    class="form-control isdeleted_cakupanwilayahtelsus_skrd" required>
                                                    <option
                                                        name="cakupanwilayahtelsus_skrd[{{ $key }}][isdeleted]"
                                                        value="1" selected>Tidak</option>
                                                    <option
                                                        name="cakupanwilayahtelsus_skrd[{{ $key }}][isdeleted]"
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
                        <tr class="cakupanwilayahtelsus_skrd-item">
                            {{-- <td style="width: 10%;">
                                <input type="number" oninput="validity.valid||(value='');" min="1"
                                    class="form-control urut-cakupanwilayahtelsus_skrd"
                                    name="cakupanwilayahtelsus_skrd[{{ $i }}][urut]" required />
                            </td> --}}
                            <td style="width: 10%;">
                                <input type="number" oninput="validity.valid||(value='');" min="1"
                                    class="form-control tahun-cakupanwilayahtelsus_skrd"
                                    name="cakupanwilayahtelsus_skrd[{{ $i }}][tahun]" required />
                            </td>
                            <td style="width: 20%;">
                                <select name="cakupanwilayahtelsus_skrd[{{ $i }}][kota]" id=""
                                    class="form-control pilih-kota-cakupanwilayahtelsus_skrd" required />
                                <option value="">Pilih kota</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control jenis-perangkat-cakupanwilayahtelsus_skrd"
                                    name="cakupanwilayahtelsus_skrd[{{ $i }}][jenis-perangkat]" required />
                            </td>
                            <td>
                                <input type="text" class="form-control jumlah-perangkat-cakupanwilayahtelsus_skrd"
                                    name="cakupanwilayahtelsus_skrd[{{ $i }}][jumlah-perangkat]"
                                    required />
                            </td>
                            <td>
                                <textarea class="form-control CWL-cakupanwilayahtelsus_skrd"
                                    name="cakupanwilayahtelsus_skrd[{{ $i }}][CWL]" rows="2"></textarea>

                            </td>
                            {{-- <td>
                                <textarea class="form-control AlamatUlo-cakupanwilayahtelsus_skrd"
                                    name="cakupanwilayahtelsus_skrd[{{ $i }}][AlamatUlo]" rows="2"></textarea>

                            </td> --}}
                            <td>
                                <input class="form-control isdeleted-cakupanwilayahtelsus_skrd" type="hidden"
                                    name="cakupanwilayahtelsus_skrd[{{ $i }}][isdeleted]" value="1">
                            </td>
                        </tr>
                    @endfor
                @endif
            </tbody>
        </table>
        @if ($datajson == 'kosong' || $needcorrection == 1)
            <div class="text-right">
                <button class="btn btn-secondary my-2 btn-sm" type="button"
                    id="add-cakupanwilayahtelsus_skrd">Tambah
                    Data</button>
            </div>
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
                $('.pilih-kota-cakupanwilayahtelsus_skrd').each(function(index, element) {
                    $(this).select2({
                        placeholder: "Pilih Kota"
                    })
                })
            }

            function countTotalRencanaUsaha() {
                return document.querySelectorAll('.cakupanwilayahtelsus_skrd-item').length;
            }

            $('#add-cakupanwilayahtelsus_skrd').on('click', function() {
                this.totalRencanaUsaha = countTotalRencanaUsaha() + 1;
                const inputRow =
                    `
					<tr class="cakupanwilayahtelsus_skrd-item">
					    <td>
							<input min="1" oninput="validity.valid||(value='');" type="number" class="form-control tahun-cakupanwilayahtelsus_skrd" name="cakupanwilayahtelsus_skrd[` +
                    this.totalRencanaUsaha + `][tahun]" required />
						</td>
						<td>
							<select
								name="cakupanwilayahtelsus_skrd[` + this.totalRencanaUsaha + `][kota]"
								class="form-control pilih-kota-cakupanwilayahtelsus_skrd"
								required
							><option value="">Pilih Kota</option>` + options + ` </select>
						</td>
						<td>
							<input class="form-control jenis-perangkat-cakupanwilayahtelsus_skrd" name="cakupanwilayahtelsus_skrd[` + this
                    .totalRencanaUsaha + `][jenis-perangkat]" required />
						</td>
						<td>
							<input class="form-control jumlah-perangkat-cakupanwilayahtelsus_skrd" name="cakupanwilayahtelsus_skrd[` + this
                    .totalRencanaUsaha + `][jumlah-perangkat]" required />
						</td>
						<td>
							<textarea class="form-control CWL-cakupanwilayahtelsus_skrd" name="cakupanwilayahtelsus_skrd[` + this
                    .totalRencanaUsaha +
                    `][CWL]" rows="2" ></textarea>
						</td>
						<td>
                            <input class="form-control isdeleted-cakupanwilayahtelsus_skrd" type="hidden" name="cakupanwilayahtelsus_skrd[` +
                    this.totalRencanaUsaha + `][isdeleted]" value="1">
							<button
								class="btn btn-danger btn-samll btn-delete-cakupanwilayahtelsus_skrd"
								type="button"
								onclick="javascript:onDeleteRencanaUsahaItem(this);return false;"
							>&times;</button>
						</td>
					<tr>
				`;
                $('#cakupanwilayahtelsus_skrd-lists').append(inputRow);
                initSelect2();
            });
        }

        addRencanaUsahaItem();

        $('.btn-delete-cakupanwilayahtelsus_skrd').click(function(e) {
            console.log(e);
        })

        let contentSkrd = $('#content-skrd');
        @if ($datajson == 'kosong')
            contentSkrd.hide();
        @else
            $('#toggle-skrd').prop('checked', true);
            $('#toggle-skrd').prop('disabled', true);
        @endif

        @if ($needcorrection)
            contentSkrd.find('input').each(function(index) {
                $(this).prop('disabled', false);
                $(this).prop('readonly', false);
            });
            // contentSkrd.find('select').each(function(index) {
            //     $(this).prop('disabled', false);
            //     $(this).prop('readonly', false);
            // });
            contentSkrd.find('textarea').each(function(index) {
                $(this).prop('disabled', false);
                $(this).prop('readonly', false);
            });
        @else
            contentSkrd.find('input').each(function(index) {
                $(this).prop('disabled', true);
            });
            contentSkrd.find('select').each(function(index) {
                $(this).prop('disabled', true);
            });
            contentSkrd.find('textarea').each(function(index) {
                $(this).prop('disabled', true);
            });
            let show = false;
            $('#toggle-skrd').on('click', function() {
                show = !show;
                let contentSkrd = $('#content-skrd');
                if (show) {
                    contentSkrd.show();
                    contentSkrd.find('input').each(function(index) {
                        $(this).prop('disabled', false);
                    });
                    contentSkrd.find('select').each(function(index) {
                        $(this).prop('disabled', false);
                    });
                    contentSkrd.find('textarea').each(function(index) {
                        $(this).prop('disabled', false);
                    });
                } else {
                    contentSkrd.hide();
                    contentSkrd.find('input').each(function(index) {
                        $(this).prop('disabled', true);
                    });
                    contentSkrd.find('select').each(function(index) {
                        $(this).prop('disabled', true);
                    });
                    contentSkrd.find('textarea').each(function(index) {
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
        $('.cakupanwilayahtelsus_skrd-item').each(function(index, element) {
            let tahun = $(this).find('.tahun-cakupanwilayahtelsus_skrd');
            let kota = $(this).find('.pilih-kota-cakupanwilayahtelsus_skrd');
            let jenis = $(this).find('.jenis-perangkat-cakupanwilayahtelsus_skrd');
            let jumlah = $(this).find('.jumlah-perangkat-cakupanwilayahtelsus_skrd');
            let CWL = $(this).find('.CWL-cakupanwilayahtelsus_skrd');
            // let AlamatUlo = $(this).find('.AlamatUlo-cakupanwilayahtelsus_skrd');
            let IsDeleted = $(this).find('.isdeleted-cakupanwilayahtelsus_skrd');
            tahun.attr('name', 'cakupanwilayahtelsus_skrd[' + index + '][tahun]');
            kota.attr('name', 'cakupanwilayahtelsus_skrd[' + index + '][kota]');
            jenis.attr('name', 'cakupanwilayahtelsus_skrd[' + index + '][jenis-perangkat]');
            jumlah.attr('name', 'cakupanwilayahtelsus_skrd[' + index + '][jumlah-perangkat]');
            CWL.attr('name', 'cakupanwilayahtelsus_skrd[' + index + '][CWL]');
            AlamatUlo.attr('name', 'cakupanwilayahtelsus_skrd[' + index + '][AlamatUlo]');
            IsDeleted.attr('name', 'cakupanwilayahtelsus_skrd[' + index + '][isdeleted]');
        });
    }
</script>
