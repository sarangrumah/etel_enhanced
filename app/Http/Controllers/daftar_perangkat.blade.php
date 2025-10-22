@php
    $is_editable = $needcorrection ?? false; // add || jika ada kondisi lain untuk edit input dibawah
@endphp
<style>
    .hidden {
        display: none !important;
    }
</style>
<div id="daftar_perangkat mt-4">
    <div id="daftar_perangkat_lists">
        {{-- <div class="px-3 py-3 daftar-perangkat-item" style="border: 1px solid #ddd"> --}}
        @if ($datajson !== 'kosong')
            <?php
            $datajson = json_decode($datajson, true);
            ?>
            @foreach ($datajson as $key => $d)
                @if (isset($d['isdeleted_perangkat']))
                    @if ($d['isdeleted_perangkat'] = 'off')
                        <div class="px-3 py-3 daftar-perangkat-item" style="border: 1px solid #ddd">
                            @if ($is_editable)
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label for="deletePerangkat">Hapus perangkat? </label>
                                        </div>
                                        <div
                                            class="form-group custom-control custom-switch custom-switch-square custom-control-danger">
                                            <input type="checkbox"
                                                name="daftar_perangkat[{{ $key }}][isdeleted_perangkat]"
                                                class="form-control isdeleted_perangkat custom-control-input"
                                                id="isdeleted_perangkat">
                                            <label class="custom-control-label" for="isdeleted_perangkat"></label>
                                        </div>
                                    </div>

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
                                                name="daftar_perangkat[{{ $key }}][sertifikat_perangkat]"
                                                value="{{ $d['sertifikat_perangkat'] }}"
                                                {{ $is_editable ? '' : 'disabled' }} />
                                        </div>
                                    </div>
                                @endif
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Lokasi Perangkat</label>
                                        <textarea class="form-control lokasi_perangkat" name="daftar_perangkat[{{ $key }}][lokasi_perangkat]"
                                            {{ $is_editable ? '' : 'disabled' }} required>{{ $d['lokasi_perangkat'] }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Jenis Perangkat</label>
                                        <input class="form-control jenis_perangkat"
                                            name="daftar_perangkat[{{ $key }}][jenis_perangkat]"
                                            value="{{ $d['jenis_perangkat'] }}" required
                                            {{ $is_editable ? '' : 'disabled' }} />
                                    </div>
                                    <div class="form-group">
                                        <label for="">Merk Perangkat</label>
                                        <input class="form-control merk_perangkat"
                                            name="daftar_perangkat[{{ $key }}][merk_perangkat]"
                                            value="{{ $d['merk_perangkat'] }}" required
                                            {{ $is_editable ? '' : 'disabled' }} />
                                    </div>
                                    <div class="form-group">
                                        <label for="">Nomor <i>Serial Number</i> Perangkat</label>
                                        <input class="form-control sn_perangkat"
                                            name="daftar_perangkat[{{ $key }}][sn_perangkat]"
                                            value="{{ $d['sn_perangkat'] }}" required
                                            {{ $is_editable ? '' : 'disabled' }} />
                                    </div>
                                    <div class="form-group">
                                        <div class="col-12">
                                            <p class="font-weight-semibold">Foto Perangkat</p>
                                            <div class="input-group">
                                                <?php
                                                $name = explode('/', $d['foto_perangkat']);
                                                ?>
                                                <?php 
                                                if ($is_editable) {
                                                ?><input type="file" accept="application/pdf"
                                                    class="form-control"
                                                    name="daftar_perangkat[{{ $key }}][foto_perangkat]"
                                                    value="{{ str_replace('storage/file_syarat/', '', $d['foto_perangkat']) }}"
                                                    placeholder="{{ str_replace('storage/file_syarat/', '', $d['foto_perangkat']) }}" />
                                                <input type="hidden" name="prv_foto_perangkat[{{ $key }}]"
                                                    value="{{ $d['foto_perangkat'] }}">
                                                <?php
                                                }else{
                                                ?>
                                                <input {{ $is_editable ? '' : 'disabled' }}
                                                    name="daftar_perangkat[{{ $key }}][foto_perangkat]"
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
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Tipe Perangkat</label>
                                        <input class="form-control tipe_perangkat"
                                            name="daftar_perangkat[{{ $key }}][tipe_perangkat]"
                                            value="{{ $d['tipe_perangkat'] }}" required
                                            {{ $is_editable ? '' : 'disabled' }} />
                                    </div>
                                    <div class="form-group">
                                        <label for="">Negara Asal Pembuat Perangkat</label>
                                        <input class="form-control buatan_perangkat"
                                            name="daftar_perangkat[{{ $key }}][buatan_perangkat]"
                                            value="{{ $d['buatan_perangkat'] }}" required
                                            {{ $is_editable ? '' : 'disabled' }} />
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="">Foto <i>Serial Number</i> Perangkat</label>
                                            <div class="input-group">
                                                <?php $name = explode('/', $d['foto_sn_perangkat']); ?>
                                                <?php 
                                                if ($is_editable) {
                                                    ?><input type="file" accept="application/pdf"
                                                    class="form-control"
                                                    name="daftar_perangkat[{{ $key }}][foto_sn_perangkat]" />
                                                <input type="hidden" name="prv_foto_sn_perangkat[{{ $key }}]"
                                                    value="{{ $d['foto_sn_perangkat'] }}">
                                                <?php
                                                }else{
                                                    ?>
                                                <input {{ $is_editable ? '' : 'disabled' }}
                                                    name="daftar_perangkat[{{ $key }}][foto_sn_perangkat]"
                                                    value="{{ str_replace('storage/file_syarat/', '', $d['foto_sn_perangkat']) }}"
                                                    type="text" class="form-control border-right-0"
                                                    placeholder="{{ isset($mi->nama_asli) ? $mi->nama_asli : '' }}">
                                                <?php
                                                }
                                                ?>
                                                <span class="input-group-append">
                                                    <?php 
                                                if (isset($d['foto_sn_perangkat']) && $d['foto_sn_perangkat'] != '') {
                                                    ?><a target="_blank"
                                                        href="{{ url($d['foto_sn_perangkat']) }}"
                                                        class="btn btn-teal" type="button">Lihat Dokumen</a>
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
                                </div>
                            </div>
                            <div class="row mt-3">
                                @if (isset($d['sertifikasi_alat']) && $d['sertifikasi_alat'])
                                    <div class="col-12">
                                        <div class="form-group">
                                            <p class="font-weight-semibold">Lampiran Sertifikasi Perangkat</p>
                                            <div class="input-group">
                                                <?php $name = explode('/', $d['sertifikasi_alat']); ?>
                                                <?php 
                                                if ($is_editable) {
                                                    ?><input type="file" accept="application/pdf"
                                                    class="form-control"
                                                    name="daftar_perangkat[{{ $key }}][sertifikasi_alat]" />
                                                <input type="hidden"
                                                    name="prv_sertifikasi_alat[{{ $key }}]"
                                                    value="{{ $d['sertifikasi_alat'] }}">
                                                <?php
                                                }else{
                                                    ?>
                                                <input {{ $is_editable ? '' : 'disabled' }}
                                                    name="daftar_perangkat[{{ $key }}][sertifikasi_alat]"
                                                    value="{{ str_replace('storage/file_syarat/', '', $d['sertifikasi_alat']) }}"
                                                    type="text" class="form-control border-right-0"
                                                    placeholder="{{ isset($mi->nama_asli) ? $mi->nama_asli : '' }}">
                                                <?php
                                                }
                                                ?>

                                                <span class="input-group-append">
                                                    <?php 
                                                    if (isset($d['sertifikasi_alat']) && $d['sertifikasi_alat'] != '') {
                                                        ?><a target="_blank"
                                                        href="{{ url($d['sertifikasi_alat']) }}" class="btn btn-teal"
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
                                @else
                                    <div class="col-12">
                                        <div class="form-group hidden">
                                            <label for="">Lampiran Sertifikasi Perangkat</label>
                                            <input type="file" accept="application/pdf"
                                                class="form-control sertifikasi_alat"
                                                name="daftar_perangkat[{{ $key }}][sertifikasi_alat]" />
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <div class="px-3 py-3 daftar-perangkat-item" style="border: 1px solid #ddd">
                    <div>
                        <div class="">
                            <label for="switchPerangkat">Apakah anda memiliki sertifikat perangkat?</label>
                            <input type="checkbox" class="switchPerangkat" id="switchPerangkat">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group hidden">
                                <label for="">No Sertifikat Perangkat</label>
                                <input class="form-control sertifikat_perangkat"
                                    name="daftar_perangkat[0][sertifikat_perangkat]" />
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group hidden">
                                <label for="">Lampiran Sertifikasi Perangkat</label>
                                <input type="file" accept="application/pdf" class="form-control sertifikasi_alat"
                                    name="daftar_perangkat[0][sertifikasi_alat]" />

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <a class="btn btn-success verifyPerangkat hidden">Verifikasi Sertifikat</a>
                            </div>
                        </div>
                    </div>
                    <hr class="w-100" />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Lokasi Perangkat</label>
                                <textarea class="form-control lokasi_perangkat" name="daftar_perangkat[0][lokasi_perangkat]" required></textarea>
                            </div>
                        </div>
                    </div>
                    <hr class="w-100" />
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Jenis Perangkat</label>
                                <input class="form-control jenis_perangkat"
                                    name="daftar_perangkat[0][jenis_perangkat]" required />
                            </div>
                            <div class="form-group">
                                <label for="">Merk Perangkat</label>
                                <input class="form-control merk_perangkat" name="daftar_perangkat[0][merk_perangkat]"
                                    required />
                            </div>
                            <div class="form-group">
                                <label for="">Nomor <i>Serial Number</i> Perangkat</label>
                                <input class="form-control sn_perangkat" name="daftar_perangkat[0][sn_perangkat]"
                                    required />
                            </div>
                            <div class="form-group">
                                <label for="">Foto Perangkat</label>
                                <input type="file" accept="application/pdf" class="form-control foto_perangkat"
                                    name="daftar_perangkat[0][foto_perangkat]" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Tipe Perangkat</label>
                                <input class="form-control tipe_perangkat" name="daftar_perangkat[0][tipe_perangkat]"
                                    required />
                            </div>
                            <div class="form-group">
                                <label for="">Negara Asal Pembuat Perangkat</label>
                                <input class="form-control buatan_perangkat"
                                    name="daftar_perangkat[0][buatan_perangkat]" required />
                            </div>
                            {{-- <div class="form-group hidden">
                            <label for="">Nomor Sertifikat Perangkat</label>
                            <input class="form-control sertifikat_perangkat"
                                name="daftar_perangkat[0][sertifikat_perangkat]" />
                        </div> --}}
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label for="">Foto <i>Serial Number</i> Perangkat</label>
                                    <input type="file" accept="application/pdf" class="form-control"
                                        name="daftar_perangkat[0][foto_sn_perangkat]" required />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            {{-- </div> --}}
    </div>
</div>
@if ($datajson == 'kosong' || $is_editable)
    <div class="mt-2 text-right">
        <button id="add-daftar-perangkat" type="button" class="btn-secondary btn-sm">Tambah Data
            Alat/Perangkat</button>
    </div>
@endif

<script>
    $('document').ready(function() {

        const addDaftarPerangkatItem = function() {

            start = 0;
            totalDaftarPerangkat = 0;
            options = ``;

            function countTotalDaftarPerangkat() {
                return document.querySelectorAll('.daftar-perangkat-item').length - 1;
            }

            $('#add-daftar-perangkat').on('click', function() {
                this.totalDaftarPerangkat = countTotalDaftarPerangkat() + 1;
                console.log(this.totalDaftarPerangkat);
                const inputRow = `
                <div class="px-3 py-3 daftar-perangkat-item" style="border: 1px solid #ddd;position: relative;">
                        <button
                            class="btn btn-danger btn-sm btn-delete-daftarperangkat"
                            type="button"
                            style="position: absolute;bottom: 20px;right: 20px;z-index: 999;"
                            onclick="javascript:onDeleteRencanaDaftarPerangkat(this);return false;"
                        >Hapus Data Tambahan</button>
                        <div>
                            <div class="">
                                <label for="switchPerangkat">Apakah anda memiliki sertifikat perangkat?</label>
                                <input type="checkbox" class="switchPerangkat" id="switchPerangkat">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group hidden">
                                    <label for="">No Sertifikat Perangkat</label>
                                    <input class="form-control sertifikat_perangkat"
                                        name="daftar_perangkat[` + this.totalDaftarPerangkat + `][sertifikat_perangkat]" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group hidden">
                                    <label for="">Lampiran Sertifikasi Perangkat</label>
                                    <input type="file" accept="application/pdf" class="form-control sertifikasi_alat"
                                        name="daftar_perangkat[` + this.totalDaftarPerangkat + `][sertifikasi_alat]" />
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <a class="btn btn-success verifyPerangkat hidden">Verifikasi Sertifikat</a>
                                </div>
                            </div>
                        </div>
                        <hr class="w-100" />
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Lokasi Perangkat</label>
                                    <textarea class="form-control lokasi_perangkat" name="daftar_perangkat[` + this
                    .totalDaftarPerangkat + `][lokasi_perangkat]" required></textarea>
                                </div>
                            </div>
                        </div>
                        <hr class="w-100"/>
                        <div class="row">                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Jenis Perangkat</label>
                                    <input class="form-control jenis_perangkat" name="daftar_perangkat[` + this
                    .totalDaftarPerangkat + `][jenis_perangkat]" required />
                                </div>
                                <div class="form-group">
                                    <label for="">Merk Perangkat</label>
                                    <input class="form-control merk_perangkat" name="daftar_perangkat[` + this
                    .totalDaftarPerangkat + `][merk_perangkat]" required />
                                </div>
                                <div class="form-group">
                                    <label for="">Nomor <i>Serial Number</i> Perangkat</label>
                                    <input class="form-control sn_perangkat" name="daftar_perangkat[` + this
                    .totalDaftarPerangkat +
                    `][sn_perangkat]" required />
                                </div>
                                <div class="form-group">
                                    <label for="">Foto Perangkat</label>
                                    <input type="file" accept="application/pdf" class="form-control foto_perangkat" name="daftar_perangkat[` +
                    this.totalDaftarPerangkat + `][foto_perangkat]" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Tipe Perangkat</label>
                                    <input class="form-control tipe_perangkat" name="daftar_perangkat[` + this
                    .totalDaftarPerangkat + `][tipe_perangkat]" required />
                                </div>
                                <div class="form-group">
                                    <label for="">Negara Asal Pembuat Perangkat</label>
                                    <input class="form-control buatan_perangkat" name="daftar_perangkat[` + this
                    .totalDaftarPerangkat +
                    `][buatan_perangkat]" required />
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Foto <i>Serial Number</i> Perangkat</label>
                                        <input type="file" accept="application/pdf" class="form-control foto_sn_perangkat" name="daftar_perangkat[` +
                    this.totalDaftarPerangkat + `][foto_sn_perangkat]" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>     
                `;
                $('#daftar_perangkat_lists').append(inputRow);
            });
        }
        addDaftarPerangkatItem();

        $('.btn-delete-daftarperangkat').click(function(e) {
            console.log(e);
        });

        $(document).on('click', '.switchPerangkat', function() {
            let perangkat = $(this).parents('.daftar-perangkat-item')
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
        $(document).on('click', 'a.verifyPerangkat', function(e) {
            console.log('asd')
            let integration = $(this).parents('.daftar-perangkat-item')
            let val = integration.find('input.sertifikat_perangkat').val()
            let token
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "https://middleware.ditfrek.postel.go.id/middleware_sdppi/get_token",
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
                url: "https://middleware.ditfrek.postel.go.id/middleware_sdppi/certification/index",
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
                            integration.find('.merk_perangkat').val(result.data[0]
                                .device_brand)
                            integration.find('.merk_perangkat').attr('readonly')
                        }
                        if (result.data[0].device_model) {
                            integration.find('.jenis_perangkat').val(result.data[0]
                                .device_model)
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
    });

    function onDeleteRencanaDaftarPerangkat(e) {
        // remove selected item
        e.parentNode.remove();

        // recons index
        $('.daftar-perangkat-item').each(function(index, element) {
            $(this).find('.lokasi_perangkat').attr('name', 'daftar_perangkat[' + index + '][lokasi_perangkat]');
            $(this).find('.jenis_perangkat').attr('name', 'daftar_perangkat[' + index + '][jenis_perangkat]');
            $(this).find('.merk_perangkat').attr('name', 'daftar_perangkat[' + index + '][merk_perangkat]');
            $(this).find('.tipe_perangkat').attr('name', 'daftar_perangkat[' + index + '][tipe_perangkat]');
            $(this).find('.buatan_perangkat').attr('name', 'daftar_perangkat[' + index + '][buatan_perangkat]');
            $(this).find('.sn_perangkat').attr('name', 'daftar_perangkat[' + index + '][sn_perangkat]');
            $(this).find('.sertifikat_perangkat').attr('name', 'daftar_perangkat[' + index +
                '][sertifikat_perangkat]');
            $(this).find('.foto_perangkat').attr('name', 'daftar_perangkat[' + index + '][foto_perangkat]');
            $(this).find('.foto_sn_perangkat').attr('name', 'daftar_perangkat[' + index +
                '][foto_sn_perangkat]');
        });

    }

    function removeperangkat(index) {
        $(this).find('.lokasi_perangkat').attr('name', 'daftar_perangkat[' + index + '][lokasi_perangkat]').remove();
        $(this).find('.jenis_perangkat').attr('name', 'daftar_perangkat[' + index + '][jenis_perangkat]').remove();
        $(this).find('.merk_perangkat').attr('name', 'daftar_perangkat[' + index + '][merk_perangkat]').remove();
        $(this).find('.tipe_perangkat').attr('name', 'daftar_perangkat[' + index + '][tipe_perangkat]').remove();
        $(this).find('.buatan_perangkat').attr('name', 'daftar_perangkat[' + index + '][buatan_perangkat]').remove();
        $(this).find('.sn_perangkat').attr('name', 'daftar_perangkat[' + index + '][sn_perangkat]').remove();
        $(this).find('.sertifikat_perangkat').attr('name', 'daftar_perangkat[' + index +
            '][sertifikat_perangkat]').remove();
        $(this).find('.foto_perangkat').attr('name', 'daftar_perangkat[' + index + '][foto_perangkat]').remove();
        $(this).find('.foto_sn_perangkat').attr('name', 'daftar_perangkat[' + index +
            '][foto_sn_perangkat]').remove();

    }
</script>
