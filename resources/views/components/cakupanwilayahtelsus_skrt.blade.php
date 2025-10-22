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
            <input type="checkbox" id="toggle-skrt">
        @endif
        Media Transmisi Spektrum Frekuensi Radio untuk Sistem Komunikasi Radio Trunking
    </h5>
    <div id="content-skrt">
        <table class="table table-custom table-sm" style="border-spacing:0px !important;width:100%;">
            <thead>

                <tr>
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
            <tbody id="cakupanwilayahtelsus_skrt-lists">
                @if ($datajson !== 'kosong')
                    <?php
                    $datajson = json_decode($datajson, true);
                    // var_dump($datajson);
                    // dd($datajson);
                    ?>
                    @foreach ($datajson as $key => $d)
                        @if (isset($d['isdeleted']))
                            @if ($d['isdeleted'] == '1')
                                <tr class="cakupanwilayahtelsus_skrt-item">
                                    @if ($triger == 'true')
                                        <td style="width: 10%;">
                                            <div style="text-align:center !important;">{{ $d['tahun'] }}</div>
                                        </td>
                                        <td style="width: 35%;">
                                            @foreach ($cities as $city)
                                                @if ($d['kota'] == $city->id)
                                                    <div style="text-align:center !important;">{{ $city->name }}</div>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            <div style="text-align:center !important;">{{ $d['jenis-perangkat'] }}</div>
                                        </td>
                                        {{-- <td>
                                            <div style="text-align:center !important;">{{ $d['jumlah-perangkat'] }}
                                            </div>
                                        </td> --}}
                                        <td>
                                            <div style="text-align:center !important;">{{ $d['CWL'] }}</div>
                                        </td>
                                    @else
                                        <td style="width: 10%;">
                                            <input readonly value="{{ $d['tahun'] }}" type="number"
                                                oninput="validity.valid||(value='');" min="1"
                                                class="form-control tahun-cakupanwilayahtelsus_skrt"
                                                name="cakupanwilayahtelsus_skrt[{{ $key }}][tahun]" required />
                                        </td>
                                        <td style="width: 35%;">
                                            <select @if ($needcorrection != 1) readonly @endif
                                                name="cakupanwilayahtelsus_skrt[{{ $key }}][kota]"
                                                id="" class="form-control pilih-kota-cakupanwilayahtelsus_skrt"
                                                required />
                                            <option value="">Pilih kota</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}" <?php echo $d['kota'] == $city->id ? 'selected' : ''; ?>>
                                                    {{ $city->name }}
                                                </option>
                                            @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input readonly value="{{ $d['jenis-perangkat'] }}" type="text"
                                                class="form-control jenis-perangkat-cakupanwilayahtelsus_skrt"
                                                name="cakupanwilayahtelsus_skrt[{{ $key }}][jenis-perangkat]"
                                                required />
                                        </td>
                                        <td>
                                            <input readonly value="{{ $d['jumlah-perangkat'] }}" type="text"
                                                class="form-control jumlah-perangkat-cakupanwilayahtelsus_skrt"
                                                name="cakupanwilayahtelsus_skrt[{{ $key }}][jumlah-perangkat]"
                                                required />
                                        </td>
                                        <td>
                                            <textarea class="form-control CWL-cakupanwilayahtelsus_skrt" name="cakupanwilayahtelsus_skrt[{{ $key }}][CWL]"
                                                rows="2" readonly>{{ $d['CWL'] }}</textarea>
                                        </td>
                                        @if ($needcorrection == 1)
                                            <td style="width: 10%;">
                                                <div>
                                                    <select
                                                        name="cakupanwilayahtelsus_skrt[{{ $key }}][isdeleted]"
                                                        id=""
                                                        class="form-control isdeleted_cakupanwilayahtelsus_skrt"
                                                        required>
                                                        <option
                                                            name="cakupanwilayahtelsus_skrt[{{ $key }}][isdeleted]"
                                                            value="1" selected>Tidak</option>
                                                        <option
                                                            name="cakupanwilayahtelsus_skrt[{{ $key }}][isdeleted]"
                                                            value="2">Hapus</option>

                                                    </select>
                                                </div>
                                            </td>
                                        @endif
                                    @endif

                                </tr>
                            @endif
                        @else
                            <tr class="cakupanwilayahtelsus_skrt-item">
                                @if ($triger == 'true')
                                    <td style="width: 10%;">
                                        <div style="text-align:center !important;">{{ $d['tahun'] }}</div>
                                    </td>
                                    <td style="width: 35%;">
                                        @foreach ($cities as $city)
                                            @if ($d['kota'] == $city->id)
                                                <div style="text-align:center !important;">{{ $city->name }}</div>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        <div style="text-align:center !important;">{{ $d['jenis-perangkat'] }}</div>
                                    </td>
                                    {{-- <td>
                                        <div style="text-align:center !important;">{{ $d['jumlah-perangkat'] }}</div>
                                    </td> --}}
                                    <td>
                                        <div style="text-align:center !important;">{{ $d['CWL'] }}</div>
                                    </td>
                                @else
                                    <td style="width: 10%;">
                                        <input readonly value="{{ $d['tahun'] }}" type="number"
                                            oninput="validity.valid||(value='');" min="1"
                                            class="form-control tahun-cakupanwilayahtelsus_skrt"
                                            name="cakupanwilayahtelsus_skrt[{{ $key }}][tahun]" required />
                                    </td>
                                    <td style="width: 35%;">
                                        <select @if ($needcorrection != 1) readonly @endif
                                            name="cakupanwilayahtelsus_skrt[{{ $key }}][kota]" id=""
                                            class="form-control pilih-kota-cakupanwilayahtelsus_skrt" required />
                                        <option value="">Pilih kota</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" <?php echo $d['kota'] == $city->id ? 'selected' : ''; ?>>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input readonly value="{{ $d['jenis-perangkat'] }}" type="text"
                                            class="form-control jenis-perangkat-cakupanwilayahtelsus_skrt"
                                            name="cakupanwilayahtelsus_skrt[{{ $key }}][jenis-perangkat]"
                                            required />
                                    </td>
                                    <td>
                                        <input readonly value="{{ $d['jumlah-perangkat'] }}" type="text"
                                            class="form-control jumlah-perangkat-cakupanwilayahtelsus_skrt"
                                            name="cakupanwilayahtelsus_skrt[{{ $key }}][jumlah-perangkat]"
                                            required />
                                    </td>
                                    <td>
                                        <textarea class="form-control CWL-cakupanwilayahtelsus_skrt" name="cakupanwilayahtelsus_skrt[{{ $key }}][CWL]"
                                            rows="2" readonly>{{ $d['CWL'] }}</textarea>
                                    </td>
                                    @if ($needcorrection == 1)
                                        <td style="width: 10%;">
                                            <div>
                                                <select
                                                    name="cakupanwilayahtelsus_skrt[{{ $key }}][isdeleted]"
                                                    id=""
                                                    class="form-control isdeleted_cakupanwilayahtelsus_skrt" required>
                                                    <option
                                                        name="cakupanwilayahtelsus_skrt[{{ $key }}][isdeleted]"
                                                        value="1" selected>Tidak</option>
                                                    <option
                                                        name="cakupanwilayahtelsus_skrt[{{ $key }}][isdeleted]"
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
                        <tr class="cakupanwilayahtelsus_skrt-item">
                            <td style="width: 10%;">
                                <input type="number" oninput="validity.valid||(value='');" min="1"
                                    class="form-control tahun-cakupanwilayahtelsus_skrt"
                                    name="cakupanwilayahtelsus_skrt[{{ $i }}][tahun]" required />
                            </td>
                            <td style="width: 35%;">
                                <select name="cakupanwilayahtelsus_skrt[{{ $i }}][kota]" id=""
                                    class="form-control pilih-kota-cakupanwilayahtelsus_skrt" required />
                                <option value="">Pilih kota</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control jenis-perangkat-cakupanwilayahtelsus_skrt"
                                    name="cakupanwilayahtelsus_skrt[{{ $i }}][jenis-perangkat]" required />
                            </td>
                            <td>
                                <input type="text" class="form-control jumlah-perangkat-cakupanwilayahtelsus_skrt"
                                    name="cakupanwilayahtelsus_skrt[{{ $i }}][jumlah-perangkat]"
                                    required />
                            </td>
                            <td>
                                <textarea class="form-control CWL-cakupanwilayahtelsus_skrt"
                                    name="cakupanwilayahtelsus_skrt[{{ $i }}][CWL]" rows="2"></textarea>

                            </td>
                            {{-- <td>
                                <textarea class="form-control AlamatUlo-cakupanwilayahtelsus_skrt"
                                    name="cakupanwilayahtelsus_skrt[{{ $i }}][AlamatUlo]" rows="2"></textarea>
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
                <button class="btn btn-secondary my-2 btn-sm" type="button"
                    id="add-cakupanwilayahtelsus_skrt">Tambah
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
                $('.pilih-kota-cakupanwilayahtelsus_skrt').each(function(index, element) {
                    $(this).select2({
                        placeholder: "Pilih Kota"
                    })
                })
            }

            function countTotalRencanaUsaha() {
                return document.querySelectorAll('.cakupanwilayahtelsus_skrt-item').length - 1;
            }

            $('#add-cakupanwilayahtelsus_skrt').on('click', function() {
                this.totalRencanaUsaha = countTotalRencanaUsaha() + 1;
                const inputRow =
                    `
					<tr class="cakupanwilayahtelsus_skrt-item">
						<td>
							<input min="1" oninput="validity.valid||(value='');" type="number" class="form-control tahun-cakupanwilayahtelsus_skrt" name="cakupanwilayahtelsus_skrt[` +
                    this.totalRencanaUsaha + `][tahun]" required />
						</td>
						<td>
							<select
								name="cakupanwilayahtelsus_skrt[` + this.totalRencanaUsaha + `][kota]"
								class="form-control pilih-kota-cakupanwilayahtelsus_skrt"
								required
							><option value="">Pilih Kota</option>` + options + ` </select>
						</td>
						<td>
							<input class="form-control jenis-perangkat-cakupanwilayahtelsus_skrt" name="cakupanwilayahtelsus_skrt[` + this
                    .totalRencanaUsaha + `][jenis-perangkat]" required />
						</td>
						<td>
							<input class="form-control jumlah-perangkat-cakupanwilayahtelsus_skrt" name="cakupanwilayahtelsus_skrt[` + this
                    .totalRencanaUsaha + `][jumlah-perangkat]" required />
						</td>
						<td>
							<textarea class="form-control CWL-cakupanwilayahtelsus_skrt" name="cakupanwilayahtelsus_skrt[` + this
                    .totalRencanaUsaha + `][CWL]" rows="2" ></textarea>
						</td>
						<td>
							<button
								class="btn btn-danger btn-samll btn-delete-cakupanwilayahtelsus_skrt"
								type="button"
								onclick="javascript:onDeleteRencanaUsahaItem(this);return false;"
							>&times;</button>
						</td>
					<tr>
				`;
                $('#cakupanwilayahtelsus_skrt-lists').append(inputRow);
                initSelect2();
            });
        }

        addRencanaUsahaItem();

        $('.btn-delete-cakupanwilayahtelsus_skrt').click(function(e) {
            console.log(e);
        })

        let contentSkrt = $('#content-skrt');
        @if ($datajson == 'kosong')
            contentSkrt.hide();
        @else
            $('#toggle-skrt').prop('checked', true);
            $('#toggle-skrt').prop('disabled', true);
        @endif

        @if ($needcorrection)
            contentSkrt.find('input').each(function(index) {
                $(this).prop('disabled', false);
                $(this).prop('readonly', false);
            });
            // contentSkrt.find('select').each(function(index) {
            //     $(this).prop('disabled', false);
            //     $(this).prop('readonly', false);
            // });
            contentSkrt.find('textarea').each(function(index) {
                $(this).prop('disabled', false);
                $(this).prop('readonly', false);
            });
        @else
            contentSkrt.find('input').each(function(index) {
                $(this).prop('disabled', true);
            });
            contentSkrt.find('select').each(function(index) {
                $(this).prop('disabled', true);
            });
            contentSkrt.find('textarea').each(function(index) {
                $(this).prop('disabled', true);
            });
            let show = false;
            $('#toggle-skrt').on('click', function() {
                show = !show;
                let contentSkrt = $('#content-skrt');
                if (show) {
                    contentSkrt.show();
                    contentSkrt.find('input').each(function(index) {
                        $(this).prop('disabled', false);
                    });
                    contentSkrt.find('select').each(function(index) {
                        $(this).prop('disabled', false);
                    });
                    contentSkrt.find('textarea').each(function(index) {
                        $(this).prop('disabled', false);
                    });
                } else {
                    contentSkrt.hide();
                    contentSkrt.find('input').each(function(index) {
                        $(this).prop('disabled', true);
                    });
                    contentSkrt.find('select').each(function(index) {
                        $(this).prop('disabled', true);
                    });
                    contentSkrt.find('textarea').each(function(index) {
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
        $('.cakupanwilayahtelsus_skrt-item').each(function(index, element) {
            let tahun = $(this).find('.tahun-cakupanwilayahtelsus_skrt');
            let kota = $(this).find('.pilih-kota-cakupanwilayahtelsus_skrt');
            let jenis = $(this).find('.jenis-perangkat-cakupanwilayahtelsus_skrt');
            let jumlah = $(this).find('.jumlah-perangkat-cakupanwilayahtelsus_skrt');
            let CWL = $(this).find('.CWL-cakupanwilayahtelsus_skrt');
            // let AlamatUlo = $(this).find('.AlamatUlo-cakupanwilayahtelsus_skrt');
            tahun.attr('name', 'cakupanwilayahtelsus_skrt[' + index + '][tahun]');
            kota.attr('name', 'cakupanwilayahtelsus_skrt[' + index + '][kota]');
            jenis.attr('name', 'cakupanwilayahtelsus_skrt[' + index + '][jenis-perangkat]');
            jumlah.attr('name', 'cakupanwilayahtelsus_skrt[' + index + '][jumlah-perangkat]');
            CWL.attr('name', 'cakupanwilayahtelsus_skrt[' + index + '][CWL]');
            AlamatUlo.attr('name', 'cakupanwilayahtelsus_skrt[' + index + '][AlamatUlo]');
        });
    }
</script>
