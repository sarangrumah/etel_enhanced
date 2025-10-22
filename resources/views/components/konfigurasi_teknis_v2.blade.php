@php
    $is_editable = ($needcorrection ?? false); // add || jika ada kondisi lain untuk edit input dibawah
@endphp
{{-- Layanan ISP --}}
<div id="konfigurasi_teknis mt-4">
    <div id="konfigurasi_teknis_lists">
        <div class="px-3 py-3 konfigurasi-teknis-item" style="border: 1px solid #ddd">
        @if($datajson !== "kosong")
            <?php
                $datajson = json_decode($datajson, true);
            ?>
            @foreach($datajson as $key => $d)
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Alamat PoP/Kantor Pusat Layanan Pelanggan</label>
                        <textarea class="form-control" name="konfigurasi_teknis[{{ $key }}][alamat_kantor_pusat_layanan_pelanggan]" {{ $is_editable ? "" : "disabled" }} required>{{$d['alamat_kantor_pusat_layanan_pelanggan']}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Alamat <i>Dummy Client</i></label>
                        <textarea class="form-control" name="konfigurasi_teknis[{{ $key }}][alamat_dummy_client]" {{ $is_editable ? "" : "disabled" }} required>{{$d['alamat_dummy_client']}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Alamat NOC</label>
                        <textarea class="form-control" name="konfigurasi_teknis[{{ $key }}][alamat_noc]" {{ $is_editable ? "" : "disabled" }} required>{{$d['alamat_noc']}}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Alamat Kolokasi</label>
                        <textarea class="form-control" name="konfigurasi_teknis[{{ $key }}][alamat_kolokasi]" {{ $is_editable ? "" : "disabled" }} required>{{$d['alamat_kolokasi']}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Alamat Instalasi NAP</label>
                        <textarea class="form-control" name="konfigurasi_teknis[{{ $key }}][alamat_instalasi_nap]" {{ $is_editable ? "" : "disabled" }} required>{{$d['alamat_instalasi_nap']}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Alamat Instalasi Jartup</label>
                        <textarea class="form-control" name="konfigurasi_teknis[{{ $key }}][alamat_instalasi_jartup]" {{ $is_editable ? "" : "disabled" }} required>{{$d['alamat_instalasi_jartup']}}</textarea>
                    </div>
                </div>
            </div>
            {{-- <hr class="w-100"/> --}}
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Nama Perangkat</label>
                        <input class="form-control" name="konfigurasi_teknis[{{ $key }}][nama_perangkat]" value="{{$d['nama_perangkat']}}" {{ $is_editable ? "" : "disabled" }} required />
                    </div>
                    <div class="form-group">
                        <label for="">Merk / Tipe Perangkat</label>
                        <input class="form-control" name="konfigurasi_teknis[{{ $key }}][merk_type]" value="{{$d['merk_type']}}" {{ $is_editable ? "" : "disabled" }} required />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Lokasi</label>
                        <textarea class="form-control" name="konfigurasi_teknis[{{ $key }}][alamat_kolokasi]" value="{{$d['alamat_kolokasi']}}" {{ $is_editable ? "" : "disabled" }} required ></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Media Akses</label>
                        <input class="form-control" name="konfigurasi_teknis[{{ $key }}][media_akses]" value="{{$d['media_akses']}}" {{ $is_editable ? "" : "disabled" }} required />
                    </div>
                    <div class="col-12">
                        <p class="font-weight-semibold">Sertifikat Alat / Perangkat</p>
                        <div class="input-group">
                            <?php
                                $name = explode("/",$d['sertifikasi_alat']);
                            ?>
                            <input {{ $is_editable ? "" : "disabled" }} name="konfigurasi_teknis[{{ $key }}][sertifikasi_alat]" value="{{$name[2]}}" type="text" class="form-control border-right-0" placeholder="{{ isset($mi->nama_asli) ? $mi->nama_asli : ''; }}">
                            <span class="input-group-append">
                                <?php 
                                if (isset($d['sertifikasi_alat']) && $d['sertifikasi_alat'] != '') {
                                    ?><a target="_blank" href="{{ url($d['sertifikasi_alat'])}}" class="btn btn-teal" type="button">Lihat Dokumen</a><?php
                                }else{
                                    ?><a href="#" class="btn btn-teal" type="button">Lihat Dokumen</a><?php
                                }
                                ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            @endforeach
        @else
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Alamat PoP/Kantor Pusat Layanan Pelanggan</label>
                        <textarea class="form-control" name="konfigurasi_teknis[0][alamat_kantor_pusat_layanan_pelanggan]" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Alamat <i>Dummy Client</i></label>
                        <textarea class="form-control" name="konfigurasi_teknis[0][alamat_dummy_client]" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Alamat NOC</label>
                        <textarea class="form-control" name="konfigurasi_teknis[0][alamat_noc]" required></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Alamat Kolokasi</label>
                        <textarea class="form-control" name="konfigurasi_teknis[0][alamat_kolokasi]" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Alamat Instalasi NAP</label>
                        <textarea class="form-control" name="konfigurasi_teknis[0][alamat_instalasi_nap]" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Alamat Instalasi Jartup</label>
                        <textarea class="form-control" name="konfigurasi_teknis[0][alamat_instalasi_jartup]" required></textarea>
                    </div>
                </div>
            </div>
            <hr class="w-100"/>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Nama Perangkat</label>
                        <input class="form-control" name="konfigurasi_teknis[0][nama_perangkat]" required />
                    </div>
                    <div class="form-group">
                        <label for="">Merk / Tipe Perangkat</label>
                        <input class="form-control" name="konfigurasi_teknis[0][merk_type]" required />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Lokasi</label>
                        <textarea class="form-control" name="konfigurasi_teknis[0][lokasi]" required ></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Media Akses</label>
                        <input class="form-control" name="konfigurasi_teknis[0][media_akses]" required />
                    </div>
                    <div class="form-group">
                        <label for="">Sertifikat Alat / Perangkat</label>
                        <input type="file" accept="application/pdf"  class="form-control" name="konfigurasi_teknis[0][sertifikasi_alat]" required />
                    </div>
                </div>
            </div>
        @endif
        </div>
    </div>
</div>
@if($datajson == "kosong")
<div class="mt-2 text-right">
    <button id="add-konfigurasi-tekns" type="button" class="btn-secondary btn-sm">Tambah Data Alat/Perangkat</button>
</div>
@endif
<script>
    $('document').ready(function() {

        const addRencanaUsahaItem = function() {

            start = 0;
            totalKonfigurasiTeknis = 0;
            options = ``;

            function countTotalKonfigurasiTeknis() {
                return document.querySelectorAll('.konfigurasi-teknis-item').length - 1;
            }

            $('#add-konfigurasi-tekns').on('click', function() {
                this.totalKonfigurasiTeknis = countTotalKonfigurasiTeknis() + 1;
                const inputRow = `
                    <div class="px-3 py-3 mt-3 konfigurasi-teknis-item" style="border: 1px solid #ddd;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Alamat PoP/Kantor Pusat Layanan Pelanggan</label>
                                    <textarea class="form-control alamat_kantor_pusat_layanan_pelanggan" name="konfigurasi_teknis[` + this.totalKonfigurasiTeknis + `][alamat_kantor_pusat_layanan_pelanggan]" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Alamat <i>Dummy Client</i></label>
                                    <textarea class="form-control alamat_dummy_client" name="konfigurasi_teknis[` + this.totalKonfigurasiTeknis + `][alamat_dummy_client]" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Alamat NOC</label>
                                    <textarea class="form-control alamat_noc" name="konfigurasi_teknis[` + this.totalKonfigurasiTeknis + `][alamat_noc]" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Alamat Kolokasi</label>
                                    <textarea class="form-control alamat_kolokasi" name="konfigurasi_teknis[` + this.totalKonfigurasiTeknis + `][alamat_kolokasi]" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Alamat Instalasi NAP</label>
                                    <textarea class="form-control alamat_instalasi_nap" name="konfigurasi_teknis[` + this.totalKonfigurasiTeknis + `][alamat_instalasi_nap]" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Alamat Instalasi Jartup</label>
                                    <textarea class="form-control alamat_instalasi_jartup" name="konfigurasi_teknis[` + this.totalKonfigurasiTeknis + `][alamat_instalasi_jartup]" required></textarea>
                                </div>    
                            </div>
                        </div>
                        <hr class="w-100"/>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Nama Perangkat</label>
                                    <input class="form-control nama_perangkat" name="konfigurasi_teknis[` + this.totalKonfigurasiTeknis + `][nama_perangkat]" required />
                                </div>
                                <div class="form-group">
                                    <label for="">Merk / Tipe Perangkat</label>
                                    <input class="form-control merk_type" name="konfigurasi_teknis[` + this.totalKonfigurasiTeknis + `][merk_type]" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Lokasi</label>
                                    <input class="form-control lokasi" name="konfigurasi_teknis[` + this.totalKonfigurasiTeknis + `][lokasi]" required />
                                </div>
                                <div class="form-group">
                                    <label for="">Media Akses</label>
                                    <input class="form-control media_akses" name="konfigurasi_teknis[` + this.totalKonfigurasiTeknis + `][media_akses]" required />
                                </div>
                                <div class="form-group">
                                    <label for="">Sertifikat Alat / Perangkat</label>
                                    <input type="file" accept="application/pdf" class="form-control sertifikasi_alat" name="konfigurasi_teknis[` + this.totalKonfigurasiTeknis + `][sertifikasi_alat]" required />
                                </div>
                            </div>
                        </div>
                        <button
                            class="btn btn-danger btn-sm btn-delete-rencanausaha mt-4"
                            type="button"
                            onclick="javascript:onDeleteRencanaKonfigurasiTeknis(this);return false;"
                        >Hapus Data Tambahan</button>
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
                $(this).find('.alamat_kantor_pusat_layanan_pelanggan').attr('name', 'konfigurasi_teknis[' + index + '][alamat_kantor_pusat_layanan_pelanggan]');
                $(this).find('.alamat_dummy_client').attr('name', 'konfigurasi_teknis[' + index + '][alamat_dummy_client]');
                $(this).find('.alamat_noc').attr('name', 'konfigurasi_teknis[' + index + '][alamat_noc]');
                $(this).find('.alamat_kolokasi').attr('name', 'konfigurasi_teknis[' + index + '][alamat_kolokasi]');
                $(this).find('.alamat_instalasi_nap').attr('name', 'konfigurasi_teknis[' + index + '][alamat_instalasi_nap]');
                $(this).find('.alamat_instalasi_jartup').attr('name', 'konfigurasi_teknis[' + index + '][alamat_instalasi_jartup]');
                $(this).find('.nama').attr('name', 'konfigurasi_teknis[' + index + '][nama]');
                $(this).find('.nama_perangkat').attr('name', 'konfigurasi_teknis[' + index + '][nama_perangkat]');
                $(this).find('.merk_type').attr('name', 'konfigurasi_teknis[' + index + '][merk_type]');
                $(this).find('.lokasi').attr('name', 'konfigurasi_teknis[' + index + '][lokasi]');
                $(this).find('.media_akses').attr('name', 'konfigurasi_teknis[' + index + '][media_akses]');
                $(this).find('.sertifikasi_alat').attr('name', 'konfigurasi_teknis[' + index + '][sertifikasi_alat]');
            });

        }

</script>

