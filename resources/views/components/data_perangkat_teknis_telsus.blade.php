@php
$is_editable = ($needcorrection ?? false); // add || jika ada kondisi lain untuk edit input dibawah
@endphp
<div id="data_perangkat_teknis_jasa mt-4">
    <div id="konfigurasi_teknis_lists">
        <div class="px-3 py-3 data_perangkat_teknis_jasa-item" style="border: 1px solid #ddd">
            @if($datajson !== "kosong")
            <?php
					$datajson = json_decode($datajson, true);
				?>
            @foreach($datajson as $key => $d)
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Lokasi Perangkat</label>
                        <textarea class="form-control" name="data_perangkat_teknis_jasa[{{ $key }}][lokasi_perangkat]"
                            {{ $is_editable ? "" : "disabled" }} required>{{$d['lokasi_perangkat']}}</textarea>
                    </div>
                    {{-- <div class="form-group">
                        <label for="">Alamat <i>Dummy Client</i></label>
                        <textarea class="form-control" name="konfigurasi_teknis[{{ $key }}][alamat_dummy_client]" {{
                            $is_editable ? "" : "disabled" }} required>{{$d['alamat_dummy_client']}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Alamat NOC</label>
                        <textarea class="form-control" name="konfigurasi_teknis[{{ $key }}][alamat_noc]" {{ $is_editable
                            ? "" : "disabled" }} required>{{$d['alamat_noc']}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Alamat Kolokasi</label>
                        <textarea class="form-control" name="konfigurasi_teknis[{{ $key }}][alamat_kolokasi]" {{
                            $is_editable ? "" : "disabled" }} required>{{$d['alamat_kolokasi']}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Alamat Instalasi Jaringan</label>
                        <textarea class="form-control" name="konfigurasi_teknis[{{ $key }}][alamat_instalasi_jaringan]"
                            {{ $is_editable ? "" : "disabled" }} required>{{$d['alamat_instalasi_jaringan']}}</textarea>
                    </div> --}}
                </div>
            </div>
            {{--
            <hr class="w-100" /> --}}
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Jenis Perangkat</label>
                        <input class="form-control" name="data_perangkat_teknis_jasa[{{ $key }}][jenis_perangkat]"
                            value="{{$d['jenis_perangkat']}}" required {{ $is_editable ? "" : "disabled" }} />
                    </div>
                    <div class="form-group">
                        <label for="">Merk Perangkat</label>
                        <input class="form-control" name="data_perangkat_teknis_jasa[{{ $key }}][merk_perangkat]"
                            value="{{$d['merk_perangkat']}}" required {{ $is_editable ? "" : "disabled" }} />
                    </div>
                    <div class="form-group">
                        <label for="">Nomor Serial Perangkat</label>
                        <input class="form-control" name="data_perangkat_teknis_jasa[{{ $key }}][sn_perangkat]"
                            value="{{$d['sn_perangkat']}}" required {{ $is_editable ? "" : "disabled" }} />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Model & Tipe Perangkat</label>
                        <input class="form-control" name="data_perangkat_teknis_jasa[{{ $key }}][tipe_perangkat]"
                            value="{{$d['tipe_perangkat']}}" required {{ $is_editable ? "" : "disabled" }} />
                    </div>
                    {{-- <div class="form-group">
                        <label for="">Negara Asal Pembuat Perangkat</label>
                        <input class="form-control" name="data_perangkat_teknis_jasa[{{ $key }}][buatan_perangkat]"
                            value="{{$d['buatan_perangkat']}}" required {{ $is_editable ? "" : "disabled" }} />
                    </div> --}}
                    <div class="form-group">
                        <label for="">Nomor Sertifikat Perangkat</label>
                        <input class="form-control" name="data_perangkat_teknis_jasa[{{ $key }}][sertifikat_perangkat]"
                            value="{{$d['sertifikat_perangkat']}}" required {{ $is_editable ? "" : "disabled" }} />
                    </div>
                    {{-- <div class="form-group">
                        <div class="col-12">
                            <p class="font-weight-semibold">Sertifikat Alat / Perangkat</p>
                            <div class="input-group">
                                <?php //$name = explode("/",$d['sertifikasi_alat']); ?>
                                <input type="file" name="sertifikat_alat" class="form-control">
                                <input {{ $is_editable ? "" : "disabled" }}
                                    name="data_perangkat_teknis_jasa[{{ $key }}][sertifikasi_alat]" value="{{$name[2]}}"
                                    type="text" class="form-control border-right-0"
                                    placeholder="{{ isset($mi->nama_asli) ? $mi->nama_asli : ''; }}">
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
                        </div>
                    </div> --}}

                </div>
            </div>
        </div>
        <hr class="my-4">
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
                <div class="form-group">
                    <label for="">Lokasi Perangkat</label>
                    <textarea class="form-control" name="data_perangkat_teknis_jasa[0][lokasi_perangkat]"
                        required></textarea>
                </div>
                {{-- <div class="form-group">
                    <label for="">Alamat <i>Dummy Client</i></label>
                    <textarea class="form-control" name="konfigurasi_teknis[0][alamat_dummy_client]"
                        required></textarea>
                </div>
                <div class="form-group">
                    <label for="">Alamat NOC</label>
                    <textarea class="form-control" name="konfigurasi_teknis[0][alamat_noc]" required></textarea>
                </div>
                <div class="form-group">
                    <label for="">Alamat Kolokasi</label>
                    <textarea class="form-control" name="konfigurasi_teknis[0][alamat_kolokasi]" required></textarea>
                </div>
                <div class="form-group">
                    <label for="">Alamat Instalasi Jaringan</label>
                    <textarea class="form-control" name="konfigurasi_teknis[0][alamat_instalasi_jaringan]"
                        required></textarea>
                </div> --}}
            </div>
        </div>
        <hr class="w-100" />
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Jenis Perangkat</label>
                    <input class="form-control jenis_perangkat" name="data_perangkat_teknis_jasa[0][jenis_perangkat]" required />
                </div>
                <div class="form-group">
                    <label for="">Merk Perangkat</label>
                    <input class="form-control merk_perangkat" name="data_perangkat_teknis_jasa[0][merk_perangkat]" required />
                </div>
                <div class="form-group">
                    <label for="">Nomor Serial Perangkat</label>
                    <input type="file" accept="application/pdf" class="form-control"
                        name="data_perangkat_teknis_jasa[0][sn_perangkat]" required />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Model & Tipe Perangkat</label>
                    <input class="form-control model_tipe_perangkat" name="data_perangkat_teknis_jasa[0][model_tipe_perangkat]" required />
                </div>
                <div class="form-group">
                    <label for="">No Sertifikat Perangkat</label>
                    <input class="form-control sertifikat_perangkat" name="data_perangkat_teknis_jasa[0][sertifikat_perangkat]" required />
                </div>
                {{-- <div class="form-group">
                    <label for="">Sertifikat Alat / Perangkat</label>
                    <input type="file" accept="application/pdf" class="form-control"
                        name="data_perangkat_teknis_jasa[0][sertifikasi_alat]" required />
                </div> --}}
                {{-- <div class="form-group">
                    <label for="">Negara Asal Pembuat Perangkat</label>
                    <input class="form-control" name="data_perangkat_teknis_jasa[0][buatan_perangkat]" required />
                </div> --}}
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
        @endif
    </div>
</div>
</div>
@if($datajson == "kosong" || $is_editable)
<div class="mt-2 text-right">
    <button id="add-konfigurasi-tekns" type="button" class="btn-secondary btn-sm">Tambah Data Alat/Perangkat</button>
</div>
@endif

<script>
    $('document').ready(function() {
        $('body').on('click', '.switchPerangkat', function() {
            let perangkat = $(this).parents('.data_perangkat_teknis_jasa-item')
            if($(this).is(':checked')){
                perangkat.find('.verifyPerangkat').removeClass('hidden')
                // perangkat.find('.form-group.file').addClass('hidden')
                // perangkat.find('.form-group.file input').removeAttr('required')
            } else {
                perangkat.find('.verifyPerangkat').addClass('hidden')
                // perangkat.find('.form-group.file').removeClass('hidden')
                // perangkat.find('.form-group.file input').attr('required')
            }
        });

        const addRencanaUsahaItem = function() {

            start = 0;
            totalKonfigurasiTeknis = 0;
            options = ``;

            function countTotalKonfigurasiTeknis() {
                return document.querySelectorAll('.data_perangkat_teknis_jasa-item').length - 1;
            }

            $('#add-konfigurasi-tekns').on('click', function() {
                this.totalKonfigurasiTeknis = countTotalKonfigurasiTeknis() + 1;
                const inputRow = `
                    <div class="px-3 py-5 mt-3 data_perangkat_teknis_jasa-item" style="border: 1px solid #ddd;position: relative;">
                        <button
                            class="btn btn-danger btn-sm btn-delete-rencanausaha"
                            type="button"
                            style="position: absolute;bottom: 20px;right: 20px;z-index: 999;"
                            onclick="javascript:onDeleteRencanaKonfigurasiTeknis(this);return false;"
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
                                    <textarea class="form-control lokasi_perangkat" name="data_perangkat_teknis_jasa[` + this.totalKonfigurasiTeknis + `][lokasi_perangkat]" required></textarea>
                                </div>
                                
                            </div>
                        </div>
                        <hr class="w-100"/>
                        <div class="row">
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Jenis Perangkat</label>
                                    <input class="form-control jenis_perangkat" name="data_perangkat_teknis_jasa[` + this.totalKonfigurasiTeknis + `][jenis_perangkat]" required />
                                </div>
                                <div class="form-group">
                                    <label for="">Merk Perangkat</label>
                                    <input class="form-control merk_perangkat" name="data_perangkat_teknis_jasa[` + this.totalKonfigurasiTeknis + `][merk_perangkat]" required />
                                </div>
                                <div class="form-group">
                                    <label for="">Nomor Serial Perangkat</label>
                                    <input class="form-control sn_perangkat" name="data_perangkat_teknis_jasa[` + this.totalKonfigurasiTeknis + `][sn_perangkat]" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Model & Tipe Perangkat</label>
                                    <input class="form-control tipe_perangkat" name="data_perangkat_teknis_jasa[` + this.totalKonfigurasiTeknis + `][tipe_perangkat]" required />
                                </div>
                                <div class="form-group">
                                    <label for="">No Sertifikat Perangkat</label>
                                    <input class="form-control sertifikat_perangkat" name="konfigurasi_teknis[` + this.totalKonfigurasiTeknis + `][sertifikat_perangkat]" required />
                                </div>
                            </div>
                        </div>
                    </div>    
                `;
                $('#konfigurasi_teknis_lists').append(inputRow);
            });
        }

        addRencanaUsahaItem();

        $('.btn-delete-rencanausaha').click(function(e) {
            console.log(e);
        });

    });

    function onDeleteRencanaKonfigurasiTeknis(e) {
            // remove selected item
            e.parentNode.remove();

            // recons index
            $('.konfigurasi-teknis-item').each(function(index, element) {
                $(this).find('.lokasi_perangkat').attr('name', 'data_perangkat_teknis_jasa[' + index + '][lokasi_perangkat]');
                // $(this).find('.alamat_dummy_client').attr('name', 'konfigurasi_teknis[' + index + '][alamat_dummy_client]');
                // $(this).find('.alamat_noc').attr('name', 'konfigurasi_teknis[' + index + '][alamat_noc]');
                // $(this).find('.alamat_kolokasi').attr('name', 'konfigurasi_teknis[' + index + '][alamat_kolokasi]');
                // $(this).find('.alamat_instalasi_jaringan').attr('name', 'konfigurasi_teknis[' + index + '][alamat_instalasi_jaringan]');
                // $(this).find('.nama').attr('name', 'konfigurasi_teknis[' + index + '][nama]');
                $(this).find('.jenis_perangkat').attr('name', 'data_perangkat_teknis_jasa[' + index + '][jenis_perangkat]');
                $(this).find('.merk_perangkat').attr('name', 'data_perangkat_teknis_jasa[' + index + '][merk_perangkat]');
                $(this).find('.tipe_perangkat').attr('name', 'data_perangkat_teknis_jasa[' + index + '][tipe_perangkat]');
                // $(this).find('.buatan_perangkat').attr('name', 'data_perangkat_teknis_jasa[' + index + '][buatan_perangkat]');
                $(this).find('.sn_perangkat').attr('name', 'data_perangkat_teknis_jasa[' + index + '][sn_perangkat]');
                $(this).find('.sertifikat_perangkat').attr('name', 'data_perangkat_teknis_jasa[' + index + '][sertifikat_perangkat]');
                // $(this).find('.foto_perangkat').attr('name', 'data_perangkat_teknis_jasa[' + index + '][foto_perangkat]');
                $(this).find('.sertifikasi_alat').attr('name', 'data_perangkat_teknis_jasa[' + index + '][sertifikasi_alat]');
            });

        }

    $(document).on('click','a.verifyPerangkat',function(e){
        console.log('asd')
        let integration = $(this).parents('.data_perangkat_teknis_jasa-item')
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
            async:false,
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
                "Authorization":"Bearer "+token
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
                }else{
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