@php
    $is_editable = $needcorrection ?? false; // add || jika ada kondisi lain untuk edit input dibawah
@endphp
<div id="daftar_perangkat_telsus mt-4">
    <div id="daftar_perangkat_telsus_lists">
        @if ($datajson !== 'kosong')
            <?php
            $datajson = json_decode($datajson, true);
            ?>
            @foreach ($datajson as $key => $d)
                @if (isset($d['isdeleted_perangkat']))
                    @if ($d['isdeleted_perangkat'] == '1')
                        <div class="px-3 py-3 daftar-perangkat-telsus-item" style="border: 1px solid #ddd">
                            @if ($is_editable)
                                <div class="col-md-2">
                                    <label for="isdeleted_perangkat">{{ $key }} Hapus perangkat? </label>
                                </div>
                                <div>
                                    <select name="daftar_perangkat_telsus[{{ $key }}][isdeleted_perangkat]"
                                        id="" class="form-control isdeleted_perangkat" required>
                                        <option name="daftar_perangkat_telsus[{{ $key }}][isdeleted_perangkat]"
                                            value="1" selected>Tidak</option>
                                        <option name="daftar_perangkat_telsus[{{ $key }}][isdeleted_perangkat]"
                                            value="2">Hapus</option>

                                    </select>
                                </div>
                                <hr class="w-100" />
                            @endif
                            @if (isset($d['sertifikat_perangkat']))
                                @if ($is_editable)
                                    <div class="col-md-12">
                                        <label for="switchPerangkat">Apakah anda memiliki sertifikat perangkat?</label>
                                        <input type="checkbox" class="switchPerangkat" id="switchPerangkat"
                                            {{ $d['sertifikat_perangkat'] ? 'checked' : '' }}>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group {{ $d['sertifikat_perangkat'] ?? 'hidden' }}">
                                            <label for="">Nomor Sertifikat Perangkat</label>
                                            <input class="form-control sertifikat_perangkat"
                                                name="daftar_perangkat_telsus[{{ $key }}][sertifikat_perangkat]"
                                                value="{{ $d['sertifikat_perangkat'] }}"
                                                {{ $is_editable ? '' : 'disabled' }} />
                                        </div>
                                    </div>
                                @endif
                            @endif
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Lokasi Perangkat</label>
                                        <textarea class="form-control" name="daftar_perangkat_telsus[{{ $key }}][lokasi_perangkat]"
                                            {{ $is_editable ? '' : 'disabled' }} required>{{ $d['lokasi_perangkat'] }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Jenis Perangkat</label>
                                        <input class="form-control"
                                            name="daftar_perangkat_telsus[{{ $key }}][jenis_perangkat]"
                                            value="{{ $d['jenis_perangkat'] }}" required
                                            {{ $is_editable ? '' : 'disabled' }} />
                                    </div>
                                    <div class="form-group">
                                        <label for="">Merk Perangkat</label>
                                        <input class="form-control"
                                            name="daftar_perangkat_telsus[{{ $key }}][merk_perangkat]"
                                            value="{{ $d['merk_perangkat'] }}" required
                                            {{ $is_editable ? '' : 'disabled' }} />
                                    </div>

                                    <div class="form-group">
                                        <label for="">Nomor Serial Perangkat</label>
                                        {{-- <p class="font-weight-semibold">Nomor Serial Perangkat</p> --}}
                                        <div class="form-control input-group">
                                            <?php
                                            $name = explode('/', $d['foto_perangkat']);
                                            ?>
                                            <?php 
                                if ($is_editable) {
                                    ?><input type="file" accept="application/pdf"
                                                class="form-control"
                                                name="daftar_perangkat_telsus[{{ $key }}][foto_perangkat]"
                                                required />
                                            <input type="hidden" name="prv_foto_perangkat[{{ $key }}]"
                                                value="{{ $d['foto_perangkat'] }}">
                                            <?php
                                }else{
                                    ?>
                                            <input {{ $is_editable ? '' : 'disabled' }}
                                                name="daftar_perangkat_telsus[{{ $key }}][foto_perangkat]"
                                                value="{{ str_replace('storage/file_syarat/', '', $d['foto_perangkat']) }}"
                                                type="text" class="form-control border-right-0"
                                                placeholder="{{ isset($mi->nama_asli) ? $mi->nama_asli : '' }}">
                                            <?php
                                }
                                ?>
                                            <span class="input-group-append">
                                                <?php 
                                        if (isset($d['foto_perangkat']) && $d['foto_perangkat'] != '') {
                                            ?><a target="_blank"
                                                    href="{{ url($d['foto_perangkat']) }}" class="btn btn-teal"
                                                    type="button">Lihat Dokumen</a>
                                                <?php
                                        }else{
                                            ?><a href="#" class="btn btn-teal"
                                                    type="button">Lihat
                                                    Dokumen</a>
                                                <?php
                                        }
                                        ?>
                                            </span>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Model & Tipe Perangkat</label>
                                        <input class="form-control"
                                            name="daftar_perangkat_telsus[{{ $key }}][tipe_perangkat]"
                                            value="{{ $d['tipe_perangkat'] }}" required
                                            {{ $is_editable ? '' : 'disabled' }} />
                                    </div>
                                    <div class="form-group">
                                        <label for="">Nomor Sertifikat Perangkat</label>
                                        <input class="form-control"
                                            name="daftar_perangkat_telsus[{{ $key }}][sertifikat_perangkat]"
                                            value="{{ $d['sertifikat_perangkat'] }}" required
                                            {{ $is_editable ? '' : 'disabled' }} />
                                    </div>
                                    {{-- <div class="form-group">
                        <label for="">Sertifikat Alat / Perangkat</label>
                        <div class="form-control input-group">
                            <?php //$name = explode("/",$d['sertifikasi_alat']);
                            ?>
                            <?php
                            //if ($is_editable) {
                            ?><input type="file" accept="application/pdf" class="form-control"
                                name="daftar_perangkat_telsus[{{ $key }}][sertifikasi_alat]"
                                value="{{$d['sertifikasi_alat']}}" required />
                            <input type="hidden" name="prv_sertifikasi_alat[{{ $key }}]"
                                value="{{$d['sertifikasi_alat']}}">
                            <?php
                            //}else{
                            ?>
                            <input {{ $is_editable ? '' : 'disabled' }}
                                name="daftar_perangkat_telsus[{{ $key }}][sertifikasi_alat]"
                                value="{{str_replace('storage/file_syarat/', '', $d['sertifikasi_alat'])}}" type="text"
                                class="form-control border-right-0"
                                placeholder="{{ isset($mi->nama_asli) ? $mi->nama_asli : ''; }}">
                            <?php
                            //}
                            ?>

                            <span class="input-group-append">
                                <?php
                                //if (isset($d['sertifikasi_alat']) && $d['sertifikasi_alat'] != '') {
                                ?><a target="_blank" href="{{ url($d['sertifikasi_alat'])}}"
                                    class="btn btn-teal" type="button">Lihat Dokumen</a>
                                <?php
                                //}else{
                                ?><a href="#" class="btn btn-teal" type="button">Lihat Dokumen</a>
                                <?php
                                //}
                                ?>
                            </span>
                        </div>
                    </div> --}}
                                </div>
                            </div>
                            <hr class="my-4">
                        </div>
                    @endif
                @endif
            @endforeach
        @else
            <div>
                <div class="">
                    <label for="switchPerangkat">Apakah anda memiliki sertifikat perangkat?</label>
                    <input type="checkbox" class="switchPerangkat" id="switchPerangkat">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group hidden">
                        <label for="">No Sertifikat Perangkat</label>
                        <input class="form-control sertifikat_perangkat"
                            name="daftar_perangkat_telsus[0][sertifikat_perangkat]" required />

                        <hr class="w-100" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Lokasi Perangkat</label>
                        <textarea class="form-control" name="daftar_perangkat_telsus[0][lokasi_perangkat]" required></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Jenis Perangkat</label>
                        <input class="form-control jenis_perangkat" name="daftar_perangkat_telsus[0][jenis_perangkat]"
                            required />
                    </div>
                    <div class="form-group">
                        <label for="">Merk Perangkat</label>
                        <input class="form-control merk_perangkat" name="daftar_perangkat_telsus[0][merk_perangkat]"
                            required />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Model & Tipe Perangkat</label>
                        <input class="form-control tipe_perangkat" name="daftar_perangkat_telsus[0][tipe_perangkat]"
                            required />
                    </div>
                    <div class="form-group">
                        <label for="">Nomor Serial Perangkat</label>
                        <input type="file" accept="application/pdf" class="form-control"
                            name="daftar_perangkat_telsus[0][foto_perangkat]" required />
                    </div>
                    {{-- <div class="form-group">
                        <label for="">Sertifikat Alat / Perangkat</label>
                        <input type="file" accept="application/pdf" class="form-control"
                            name="daftar_perangkat_telsus[0][sertifikasi_alat]" required />
                    </div> --}}
                </div>
            </div>
            <div class="row mt-3">
                <hr class="w-100" />
                <div class="col-md-12">
                    <div class="form-group">
                        <a class="btn btn-success verifyPerangkat hidden">Verify</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <small>Download Lampiran Template <a target="_blank"
            href="/storage/lampiran/telsus/badanhukum/FORMAT DAFTAR PERANGKAT, BUKTI KEPEMILIKAN DAN SERTIFIKAT PERANGKAT YG DIGUNAKAN.DOC
        ">Disini</a></small>
</div>
@if ($datajson == 'kosong' || $is_editable)
    <div class="mt-2 text-right">
        <button id="add-daftar-perangkat-telsus" type="button" class="btn-secondary btn-sm">Tambah Data
            Alat/Perangkat</button>
    </div>
@endif

<script>
    $('document').ready(function() {
        $('body').on('click', '.switchPerangkat', function() {
            let perangkat = $(this).parents('.daftar-perangkat-telsus-item')
            if ($(this).is(':checked')) {
                perangkat.find('.verifyPerangkat').removeClass('hidden')
                perangkat.find('.sertifikat_perangkat').parent('div').removeClass('hidden')
                perangkat.find('.sertifikat_perangkat').attr('required', true)

                perangkat.find('.sertifikasi_alat').parent('div').removeClass('hidden')
                perangkat.find('.sertifikasi_alat').attr('required', true)
            } else {
                perangkat.find('.verifyPerangkat').addClass('hidden')
                perangkat.find('.sertifikat_perangkat').parent('div').addClass('hidden')
                perangkat.find('.sertifikat_perangkat').removeAttr('required')

                perangkat.find('.sertifikasi_alat').parent('div').addClass('hidden')
                perangkat.find('.sertifikasi_alat').removeAttr('required')
            }
        });

        const addDaftarPerangkatTelsusItem = function() {

            start = 0;
            totalDaftarPerangkatTelsus = 0;
            options = ``;

            function countTotalDaftarPerangkatTelsus() {
                return document.querySelectorAll('.daftar-perangkat-telsus-item').length - 1;
            }

            $('#add-daftar-perangkat-telsus').on('click', function() {
                this.totalDaftarPerangkatTelsus = countTotalDaftarPerangkatTelsus() + 1;
                const inputRow = `
                <div class="px-3 py-5 mt-3 daftar-perangkat-telsus-item" style="border: 1px solid #ddd;position: relative;">
                        <button
                            class="btn btn-danger btn-sm btn-delete-daftarperangkattelsus"
                            type="button"
                            style="position: absolute;bottom: 20px;right: 20px;z-index: 999;"
                            onclick="javascript:onDeleteRencanaDaftarPerangkatTelsus(this);return false;"
                        >Hapus Data Tambahan</button>
                        <div>
                            <div class="">
                                <label for="switchPerangkat">Apakah anda memiliki sertifikat perangkat?</label>
                                <input type="checkbox" class="switchPerangkat" id="switchPerangkat">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Lokasi Perangkat</label>
                                    <textarea class="form-control lokasi_perangkat" name="daftar_perangkat_telsus[` +
                    this.totalDaftarPerangkatTelsus + `][lokasi_perangkat]" required></textarea>
                                </div>
                                
                            </div>
                        </div>
                        <hr class="w-100"/>
                        <div class="row">
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Jenis Perangkat</label>
                                    <input class="form-control jenis_perangkat" name="daftar_perangkat_telsus[` + this
                    .totalDaftarPerangkatTelsus + `][jenis_perangkat]" required />
                                </div>
                                <div class="form-group">
                                    <label for="">Merk Perangkat</label>
                                    <input class="form-control merk_perangkat" name="daftar_perangkat_telsus[` + this
                    .totalDaftarPerangkatTelsus +
                    `][merk_perangkat]" required />
                                </div>
                                <div class="form-group">
                                    <label for="">Nomor Serial Perangkat</label>
                                    <input type="file" accept="application/pdf" class="form-control foto_perangkat" name="daftar_perangkat_telsus[` +
                    this.totalDaftarPerangkatTelsus + `][foto_perangkat]" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Model & Tipe Perangkat</label>
                                    <input class="form-control tipe_perangkat" name="daftar_perangkat_telsus[` + this
                    .totalDaftarPerangkatTelsus + `][tipe_perangkat]" required />
                                </div>
                                <div class="form-group">
                                    <label for="">No Sertifikat Perangkat</label>
                                    <input class="form-control sertifikat_perangkat" name="daftar_perangkat_telsus[` +
                    this.totalDaftarPerangkatTelsus + `][sertifikat_perangkat]" required />
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <hr class="w-100" />
                            <div class="col-md-12">
                                <div class="form-group">
                                    <a class="btn btn-success verifyPerangkat hidden">Verify</a>
                                </div>
                            </div>
                        </div>
                    </div>     
                `;
                $('#daftar_perangkat_telsus_lists').append(inputRow);
            });
        }

        addDaftarPerangkatTelsusItem();

        $('.btn-delete-daftarperangkattelsus').click(function(e) {
            console.log(e);
        });

    });

    function onDeleteRencanaDaftarPerangkatTelsus(e) {
        // remove selected item
        e.parentNode.remove();

        // recons index
        $('.daftar-perangkat-telsus-item').each(function(index, element) {
            $(this).find('.lokasi_perangkat').attr('name', 'daftar_perangkat_telsus[' + index +
                '][lokasi_perangkat]');
            $(this).find('.jenis_perangkat').attr('name', 'daftar_perangkat_telsus[' + index +
                '][jenis_perangkat]');
            $(this).find('.merk_perangkat').attr('name', 'daftar_perangkat_telsus[' + index +
                '][merk_perangkat]');
            $(this).find('.tipe_perangkat').attr('name', 'daftar_perangkat_telsus[' + index +
                '][tipe_perangkat]');
            // $(this).find('.sn_perangkat').attr('name', 'daftar_perangkat_telsus[' + index + '][sn_perangkat]');
            $(this).find('.sertifikat_perangkat').attr('name', 'daftar_perangkat_telsus[' + index +
                '][sertifikat_perangkat]');
            $(this).find('.foto_perangkat').attr('name', 'daftar_perangkat_telsus[' + index +
                '][foto_perangkat]');
            $(this).find('.sertifikasi_alat').attr('name', 'daftar_perangkat_telsus[' + index +
                '][sertifikasi_alat]');
        });

    }

    $(document).on('click', 'a.verifyPerangkat', function(e) {
        console.log('asd')
        let integration = $(this).parents('.daftar-perangkat-telsus-item')
        let val = integration.find('input.sertifikat_perangkat').val()
        let token
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: "https://dev-middleware.ditfrek.postel.go.id/middleware_sdppi/get_token",
            data: {
                username: "telecomunication", // < note use of 'this' here
                password: "tele324", // < note use of 'this' here
            },
            async: false,
            success: function(result) {
                token = result.tokens
            },
            error: function(error) {
                alert("Tidak dapat terhubung ke server!")
            }
        });

        $.ajax({
            type: "GET",
            url: "https://dev-middleware.ditfrek.postel.go.id/middleware_sdppi/certification/index",
            headers: {
                "Authorization": "Bearer " + token
            },
            data: {
                search: val, // < note use of 'this' here
            },
            success: function(result) {
                if (result.data) {
                    alert("Perangkat Ditemukan")
                    if (result.data[0].device_brand) {
                        integration.find('.merk_perangkat').val(result.data[0].device_brand)
                        integration.find('.merk_perangkat').attr('readonly')
                    }
                    if (result.data[0].device_model) {
                        integration.find('.jenis_perangkat').val(result.data[0].device_model)
                        integration.find('.jenis_perangkat').attr('readonly')
                    }
                } else {
                    alert("Perangkat tidak Ditemukan")
                }
            },
            error: function(error) {
                // alert(error)
                alert("Tidak dapat terhubung ke server!")
            }
        });
    });
</script>
