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
            <input type="checkbox" id="toggle-skrk">
        @endif
        Media Transmisi Spektrum Frekuensi Radio untuk Sistem Komunikasi Radio Konvensional
    </h5>
    <div id="content-skrk">
        <table class="table table-custom table-sm" style="border-spacing:0px !important;width:100%;">
            <thead>

                <tr>
                    <th style="background: #fafafa;text-align: center;">Tahun</th>
                    <th style="background: #fafafa;text-align: center;">Lokasi Perangkat (Kota/Kab)
                    </th>
                    <th style="background: #fafafa;text-align: center;">Jenis Perangkat</th>
                    @if ($triger !== 'true')
                        <th style="background: #fafafa;text-align: center;">Jumlah Perangkat</th>
                    @endif
                    <th style="background: #fafafa;text-align: center;">Cakupan Wilayah Layanan</th>
                    {{-- <th style="border-top: none;background: #fafafa;text-align: center;">Alamat</th> --}}

                    @if ($needcorrection == 1)
                        <th></th>
                    @endif
                </tr>
            </thead>
            <tbody id="cakupanwilayahtelsus_skrk-lists">
                @if ($datajson !== 'kosong')
                    <?php
                    $datajson = json_decode($datajson, true);
                    // var_dump($datajson);
                    // dd($datajson);
                    // dd($triger);
                    ?>
                    @foreach ($datajson as $key => $d)
                        @if (isset($d['isdeleted']))
                            @if ($d['isdeleted'] == '1')
                                <tr class="cakupanwilayahtelsus_skrk-item">
                                    @if ($triger == 'true')
                                        <td style="width: 10%;">
                                            <div style="text-align:center !important;">{{ $d['tahun'] }}</div>
                                        </td>
                                    @else
                                        <td style="width: 10%;">
                                            <input readonly value="{{ $d['tahun'] }}" type="number"
                                                oninput="validity.valid||(value='');" min="1"
                                                class="form-control tahun-cakupanwilayahtelsus_skrk"
                                                name="cakupanwilayahtelsus_skrk[{{ $key }}][tahun]" required />
                                        </td>
                                    @endif

                                    <td style="width: 35%;">
                                        @if ($triger == 'true')
                                            @foreach ($cities as $city)
                                                @if ($d['kota'] == $city->id)
                                                    <div style="text-align:center !important;">{{ $city->name }}</div>
                                                @endif
                                            @endforeach
                                        @else
                                            <select @if ($needcorrection != 1) readonly @endif
                                                name="cakupanwilayahtelsus_skrk[{{ $key }}][kota]"
                                                id="" class="form-control pilih-kota-cakupanwilayahtelsus_skrk"
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
                                                class="form-control jenis-perangkat-cakupanwilayahtelsus_skrk"
                                                name="cakupanwilayahtelsus_skrk[{{ $key }}][jenis-perangkat]"
                                                required />
                                        @endif
                                    </td>

                                    @if ($triger == 'true')
                                        {{-- <div style="text-align:center !important;">{{ $d['jumlah-perangkat'] }}
                                                </div> --}}
                                    @else
                                        <td>
                                            <input readonly value="{{ $d['jumlah-perangkat'] }}" type="text"
                                                class="form-control jumlah-perangkat-cakupanwilayahtelsus_skrk"
                                                name="cakupanwilayahtelsus_skrk[{{ $key }}][jumlah-perangkat]"
                                                required />
                                        </td>
                                    @endif
                                    <td>
                                        @if ($triger == 'true')
                                            <div style="text-align:center !important;">{{ $d['CWL'] }}
                                            </div>
                                        @else
                                            <textarea class="form-control CWL-cakupanwilayahtelsus_skrk" name="cakupanwilayahtelsus_skrk[{{ $key }}][CWL]"
                                                rows="2" readonly>{{ $d['CWL'] }}</textarea>
                                        @endif

                                    </td>
                                    {{-- <td>
                                    <textarea class="form-control AlamatUlo-cakupanwilayahtelsus_skrk"
                                        name="cakupanwilayahtelsus_skrk[{{ $key }}][AlamatUlo]" rows="2" readonly>{{ isset($d['AlamatUlo']) ? $d['AlamatUlo'] : '' }}</textarea>
                                </td> --}}
                                    @if ($triger != 'true')
                                        @if ($needcorrection == 1)
                                            <td style="width: 10%;">
                                                <div>
                                                    <select
                                                        name="cakupanwilayahtelsus_skrk[{{ $key }}][isdeleted]"
                                                        id=""
                                                        class="form-control isdeleted_cakupanwilayahtelsus_skrk"
                                                        required>
                                                        <option
                                                            name="cakupanwilayahtelsus_skrk[{{ $key }}][isdeleted]"
                                                            value="1" selected>Tidak</option>
                                                        <option
                                                            name="cakupanwilayahtelsus_skrk[{{ $key }}][isdeleted]"
                                                            value="2">Hapus</option>

                                                    </select>
                                                </div>
                                            </td>
                                        @endif
                                    @endif
                                </tr>
                            @endif
                        @else
                            <tr class="cakupanwilayahtelsus_skrk-item">
                                @if ($triger == 'true')
                                    <td style="width: 10%;">
                                        <div style="text-align:center !important;">{{ $d['tahun'] }}</div>
                                    </td>
                                @else
                                    <td style="width: 10%;">
                                        <input readonly value="{{ $d['tahun'] }}" type="number"
                                            oninput="validity.valid||(value='');" min="1"
                                            class="form-control tahun-cakupanwilayahtelsus_skrk"
                                            name="cakupanwilayahtelsus_skrk[{{ $key }}][tahun]" required />
                                    </td>
                                @endif

                                <td style="width: 35%;">
                                    @if ($triger == 'true')
                                        @foreach ($cities as $city)
                                            @if ($d['kota'] == $city->id)
                                                <div style="text-align:center !important;">{{ $city->name }}</div>
                                            @endif
                                        @endforeach
                                    @else
                                        <select @if ($needcorrection != 1) readonly @endif
                                            name="cakupanwilayahtelsus_skrk[{{ $key }}][kota]" id=""
                                            class="form-control pilih-kota-cakupanwilayahtelsus_skrk" required />
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
                                            class="form-control jenis-perangkat-cakupanwilayahtelsus_skrk"
                                            name="cakupanwilayahtelsus_skrk[{{ $key }}][jenis-perangkat]"
                                            required />
                                    @endif
                                </td>

                                @if ($triger == 'true')
                                    {{-- <div style="text-align:center !important;">{{ $d['jumlah-perangkat'] }}
                                        </div> --}}
                                @else
                                    <td>
                                        <input readonly value="{{ $d['jumlah-perangkat'] }}" type="text"
                                            class="form-control jumlah-perangkat-cakupanwilayahtelsus_skrk"
                                            name="cakupanwilayahtelsus_skrk[{{ $key }}][jumlah-perangkat]"
                                            required />
                                    </td>
                                @endif
                                <td>
                                    @if ($triger == 'true')
                                        <div style="text-align:center !important;">{{ $d['CWL'] }}
                                        </div>
                                    @else
                                        <textarea class="form-control CWL-cakupanwilayahtelsus_skrk" name="cakupanwilayahtelsus_skrk[{{ $key }}][CWL]"
                                            rows="2" readonly>{{ $d['CWL'] }}</textarea>
                                    @endif

                                </td>
                                {{-- <td>
                                    <textarea class="form-control AlamatUlo-cakupanwilayahtelsus_skrk"
                                        name="cakupanwilayahtelsus_skrk[{{ $key }}][AlamatUlo]" rows="2" readonly>{{ isset($d['AlamatUlo']) ? $d['AlamatUlo'] : '' }}</textarea>
                                </td> --}}
                                @if ($triger != 'true')
                                    @if ($needcorrection == 1)
                                        <td style="width: 10%;">
                                            <div>
                                                <select
                                                    name="cakupanwilayahtelsus_skrk[{{ $key }}][isdeleted]"
                                                    id=""
                                                    class="form-control isdeleted_cakupanwilayahtelsus_skrk" required>
                                                    <option
                                                        name="cakupanwilayahtelsus_skrk[{{ $key }}][isdeleted]"
                                                        value="1" selected>Tidak</option>
                                                    <option
                                                        name="cakupanwilayahtelsus_skrk[{{ $key }}][isdeleted]"
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
                        <tr class="cakupanwilayahtelsus_skrk-item">
                            <td style="width: 10%;">
                                <input type="number" oninput="validity.valid||(value='');" min="1"
                                    class="form-control tahun-cakupanwilayahtelsus_skrk"
                                    name="cakupanwilayahtelsus_skrk[{{ $i }}][tahun]" required />
                            </td>
                            <td style="width: 35%;">
                                <select name="cakupanwilayahtelsus_skrk[{{ $i }}][kota]" id=""
                                    class="form-control pilih-kota-cakupanwilayahtelsus_skrk" required />
                                <option value="">Pilih kota</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control jenis-perangkat-cakupanwilayahtelsus_skrk"
                                    name="cakupanwilayahtelsus_skrk[{{ $i }}][jenis-perangkat]" required />
                            </td>
                            <td>
                                <input type="text" class="form-control jumlah-perangkat-cakupanwilayahtelsus_skrk"
                                    name="cakupanwilayahtelsus_skrk[{{ $i }}][jumlah-perangkat]"
                                    required />
                            </td>
                            <td>
                                <textarea class="form-control CWL-cakupanwilayahtelsus_skrk"
                                    name="cakupanwilayahtelsus_skrk[{{ $i }}][CWL]" rows="2"></textarea>

                            </td>
                            {{-- <td>
                                <textarea class="form-control AlamatUlo-cakupanwilayahtelsus_skrk"
                                    name="cakupanwilayahtelsus_skrk[{{ $i }}][AlamatUlo]" rows="2"></textarea>
                            </td> --}}
                            @if ($needcorrection == 1)
                                <td style="width: 10%;">
                                    <div>
                                        <select name="cakupanwilayahtelsus_skrk[{{ $key }}][isdeleted]"
                                            id="" class="form-control isdeleted_cakupanwilayahtelsus_skrk"
                                            required>
                                            <option name="cakupanwilayahtelsus_skrk[{{ $key }}][isdeleted]"
                                                value="1" selected>Tidak</option>
                                            <option name="cakupanwilayahtelsus_skrk[{{ $key }}][isdeleted]"
                                                value="2">Hapus</option>

                                        </select>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endfor
                @endif
            </tbody>
        </table>
        @if ($datajson == 'kosong' || $needcorrection == 1)
            <div class="text-right">
                <button class="btn btn-secondary my-2 btn-sm" type="button"
                    id="add-cakupanwilayahtelsus_skrk">Tambah
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
                $('.pilih-kota-cakupanwilayahtelsus_skrk').each(function(index, element) {
                    $(this).select2({
                        placeholder: "Pilih Kota"
                    })
                })
            }

            function countTotalRencanaUsaha() {
                return document.querySelectorAll('.cakupanwilayahtelsus_skrk-item').length;
            }

            $('#add-cakupanwilayahtelsus_skrk').on('click', function() {
                this.totalRencanaUsaha = countTotalRencanaUsaha() + 1;
                const inputRow =
                    `
					<tr class="cakupanwilayahtelsus_skrk-item">
						<td>
							<input min="1" oninput="validity.valid||(value='');" type="number" class="form-control tahun-cakupanwilayahtelsus_skrk" name="cakupanwilayahtelsus_skrk[` +
                    this.totalRencanaUsaha + `][tahun]" required />
						</td>
						<td>
							<select
								name="cakupanwilayahtelsus_skrk[` + this.totalRencanaUsaha + `][kota]"
								class="form-control pilih-kota-cakupanwilayahtelsus_skrk"
								required
							><option value="">Pilih Kota</option>` + options + ` </select>
						</td>
						<td>
							<input class="form-control jenis-perangkat-cakupanwilayahtelsus_skrk" name="cakupanwilayahtelsus_skrk[` + this
                    .totalRencanaUsaha + `][jenis-perangkat]" required />
						</td>
						<td>
							<input class="form-control jumlah-perangkat-cakupanwilayahtelsus_skrk" name="cakupanwilayahtelsus_skrk[` + this
                    .totalRencanaUsaha + `][jumlah-perangkat]" required />
						</td>
						<td>
							<textarea class="form-control CWL-cakupanwilayahtelsus_skrk" name="cakupanwilayahtelsus_skrk[` + this
                    .totalRencanaUsaha + `][CWL]" rows="2" ></textarea>
						</td>
						<td>
							<button
								class="btn btn-danger btn-samll btn-delete-cakupanwilayahtelsus_skrk"
								type="button"
								onclick="javascript:onDeleteRencanaUsahaItem(this);return false;"
							>&times;</button>
						</td>
					<tr>
				`;
                $('#cakupanwilayahtelsus_skrk-lists').append(inputRow);
                initSelect2();
            });
        }

        addRencanaUsahaItem();

        $('.btn-delete-cakupanwilayahtelsus_skrk').click(function(e) {
            console.log(e);
        });

        let contentSkrk = $('#content-skrk');
        @if ($datajson == 'kosong')
            contentSkrk.hide();
        @else
            $('#toggle-skrk').prop('checked', true);
            $('#toggle-skrk').prop('disabled', true);
        @endif

        @if ($needcorrection)
            contentSkrk.find('input').each(function(index) {
                $(this).prop('disabled', false);
                $(this).prop('readonly', false);
            });
            // contentSkrk.find('select').each(function(index) {
            //     $(this).prop('disabled', false);
            //     $(this).prop('readonly', false);
            // });
            contentSkrk.find('textarea').each(function(index) {
                $(this).prop('disabled', false);
                $(this).prop('readonly', false);
            });
        @else
            contentSkrk.find('input').each(function(index) {
                $(this).prop('disabled', true);
            });
            contentSkrk.find('select').each(function(index) {
                $(this).prop('disabled', true);
            });
            contentSkrk.find('textarea').each(function(index) {
                $(this).prop('disabled', true);
            });

            let show = false;
            $('#toggle-skrk').on('click', function() {
                show = !show;
                let contentSkrk = $('#content-skrk');
                if (show) {
                    contentSkrk.show();
                    contentSkrk.find('input').each(function(index) {
                        $(this).prop('disabled', false);
                    });
                    contentSkrk.find('select').each(function(index) {
                        $(this).prop('disabled', false);
                    });
                    contentSkrk.find('textarea').each(function(index) {
                        $(this).prop('disabled', false);
                    });
                } else {
                    contentSkrk.hide();
                    contentSkrk.find('input').each(function(index) {
                        $(this).prop('disabled', true);
                    });
                    contentSkrk.find('select').each(function(index) {
                        $(this).prop('disabled', true);
                    });
                    contentSkrk.find('textarea').each(function(index) {
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
        $('.cakupanwilayahtelsus_skrk-item').each(function(index, element) {
            let tahun = $(this).find('.tahun-cakupanwilayahtelsus_skrk');
            let kota = $(this).find('.pilih-kota-cakupanwilayahtelsus_skrk');
            let jenis = $(this).find('.jenis-perangkat-cakupanwilayahtelsus_skrk');
            let jumlah = $(this).find('.jumlah-perangkat-cakupanwilayahtelsus_skrk');
            let CWL = $(this).find('.CWL-cakupanwilayahtelsus_skrk');
            // let AlamatUlo = $(this).find('.AlamatUlo-cakupanwilayahtelsus_skrk');
            tahun.attr('name', 'cakupanwilayahtelsus_skrk[' + index + '][tahun]');
            kota.attr('name', 'cakupanwilayahtelsus_skrk[' + index + '][kota]');
            jenis.attr('name', 'cakupanwilayahtelsus_skrk[' + index + '][jenis-perangkat]');
            jumlah.attr('name', 'cakupanwilayahtelsus_skrk[' + index + '][jumlah-perangkat]');
            CWL.attr('name', 'cakupanwilayahtelsus_skrk[' + index + '][CWL]');
            AlamatUlo.attr('name', 'cakupanwilayahtelsus_skrk[' + index + '][AlamatUlo]');
        });
    }
</script>
