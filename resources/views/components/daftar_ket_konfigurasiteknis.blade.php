@php
$is_editable = ($needcorrection ?? false); // add || jika ada kondisi lain untuk edit input dibawah
@endphp
<div id="daftar_ket_konfigurasiteknis mt-4">
    <div id="daftar_ket_konfigurasiteknis_lists">
        <div class="px-3 py-3 daftar-ket-konfigurasiteknis-item" style="border: 1px solid #ddd">
            @if($datajson !== "kosong")
            <?php
					$datajson = json_decode($datajson, true);
				?>
            @foreach($datajson as $key => $d)
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Alamat PoP/Kantor Pusat Layanan Pelanggan</label>
                        <textarea class="form-control"
                            name="daftar_ket_konfigurasiteknis[{{ $key }}][alamat_kantor_pusat_layanan_pelanggan]" {{
                            $is_editable ? "" : "" }}
                            required>{{$d['alamat_kantor_pusat_layanan_pelanggan']}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Alamat <i>Dummy Client</i></label>
                        <textarea class="form-control"
                            name="daftar_ket_konfigurasiteknis[{{ $key }}][alamat_dummy_client]" {{ $is_editable ? ""
                            : "" }} required>{{$d['alamat_dummy_client']}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Alamat NOC</label>
                        <textarea class="form-control" name="daftar_ket_konfigurasiteknis[{{ $key }}][alamat_noc]" {{
                            $is_editable ? "" : "" }} required>{{$d['alamat_noc']}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Alamat Kolokasi</label>
                        <textarea class="form-control" name="daftar_ket_konfigurasiteknis[{{ $key }}][alamat_kolokasi]"
                            {{ $is_editable ? "" : "" }} required>{{$d['alamat_kolokasi']}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Alamat Instalasi Jaringan</label>
                        <textarea class="form-control"
                            name="daftar_ket_konfigurasiteknis[{{ $key }}][alamat_instalasi_jaringan]" {{ $is_editable
                            ? "" : "" }} required>{{$d['alamat_instalasi_jaringan']}}</textarea>
                    </div>
                </div>
            </div>

            @endforeach
            @else
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Alamat PoP/Kantor Pusat Layanan Pelanggan</label>
                        <textarea class="form-control"
                            name="daftar_ket_konfigurasiteknis[0][alamat_kantor_pusat_layanan_pelanggan]"
                            required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Alamat <i>Dummy Client</i></label>
                        <textarea class="form-control" name="daftar_ket_konfigurasiteknis[0][alamat_dummy_client]"
                            required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Alamat NOC</label>
                        <textarea class="form-control" name="daftar_ket_konfigurasiteknis[0][alamat_noc]"
                            required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Alamat Kolokasi</label>
                        <textarea class="form-control" name="daftar_ket_konfigurasiteknis[0][alamat_kolokasi]"
                            required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Alamat Instalasi Jaringan</label>
                        <textarea class="form-control" name="daftar_ket_konfigurasiteknis[0][alamat_instalasi_jaringan]"
                            required></textarea>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@if($datajson == "kosong" || $is_editable)
<div class="mt-2 text-right">
    <button id="add-daftar-ket-konfigurasiteknis" type="button" class="btn-secondary btn-sm">Tambah Data
        Alat/Perangkat</button>
</div>
@endif

<script>
    $('document').ready(function() {

        const addDaftarKetKonfigurasiTeknisItem = function() {

            start = 0;
            totalDaftarKetKonfigurasiTeknis = 0;
            options = ``;

            function counttotalDaftarKetKonfigurasiTeknis() {
                return document.querySelectorAll('.daftar-ket-konfigurasiteknis-item').length - 1;
            }

            $('#add-daftar-ket-konfigurasiteknis').on('click', function() {
                this.totalDaftarKetKonfigurasiTeknis = counttotalDaftarKetKonfigurasiTeknis() + 1;
                const inputRow = `
                    <div class="px-3 py-3 mt-3 daftar-ket-konfigurasiteknis-item" style="border: 1px solid #ddd;position: relative;">
                        <button
                            class="btn btn-danger btn-sm btn-delete-rencanausaha"
                            type="button"
                            style="position: absolute;bottom: 20px;right: 20px;z-index: 999;"
                            onclick="javascript:onDeleteRencanaDaftarKetKonfigurasiTeknis(this);return false;"
                        >Hapus Data Tambahan</button>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Alamat PoP/Kantor Pusat Layanan Pelanggan</label>
                                    <textarea class="form-control alamat_kantor_pusat_layanan_pelanggan" name="daftar_ket_konfigurasiteknis[` + this.totalDaftarKetKonfigurasiTeknis + `][alamat_kantor_pusat_layanan_pelanggan]" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Alamat <i>Dummy Client</i></label>
                                    <textarea class="form-control alamat_dummy_client" name="daftar_ket_konfigurasiteknis[` + this.totalDaftarKetKonfigurasiTeknis + `][alamat_dummy_client]" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Alamat NOC</label>
                                    <textarea class="form-control alamat_noc" name="daftar_ket_konfigurasiteknis[` + this.totalDaftarKetKonfigurasiTeknis + `][alamat_noc]" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Alamat Kolokasi</label>
                                    <textarea class="form-control alamat_kolokasi" name="daftar_ket_konfigurasiteknis[` + this.totalDaftarKetKonfigurasiTeknis + `][alamat_kolokasi]" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Alamat Instalasi Jaringan</label>
                                    <textarea class="form-control alamat_instalasi_jaringan" name="daftar_ket_konfigurasiteknis[` + this.totalDaftarKetKonfigurasiTeknis + `][alamat_instalasi_jaringan]" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>    
                `;
                $('#daftar_ket_konfigurasiteknis_lists').append(inputRow);
            });
        }

        addDaftarKetKonfigurasiTeknisItem();

        $('.btn-delete-daftarketkonfigurasiteknis').click(function(e) {
            console.log(e);
        });

    });

    function onDeleteRencanaDaftarKetKonfigurasiTeknis(e) {
            // remove selected item
            e.parentNode.remove();

            // recons index
            $('.daftar-ket-konfigurasiteknis-item').each(function(index, element) {
                $(this).find('.alamat_kantor_pusat_layanan_pelanggan').attr('name', 'daftar_ket_konfigurasiteknis[' + index + '][alamat_kantor_pusat_layanan_pelanggan]');
                $(this).find('.alamat_dummy_client').attr('name', 'daftar_ket_konfigurasiteknis[' + index + '][alamat_dummy_client]');
                $(this).find('.alamat_noc').attr('name', 'daftar_ket_konfigurasiteknis[' + index + '][alamat_noc]');
                $(this).find('.alamat_kolokasi').attr('name', 'daftar_ket_konfigurasiteknis[' + index + '][alamat_kolokasi]');
                $(this).find('.alamat_instalasi_jaringan').attr('name', 'daftar_ket_konfigurasiteknis[' + index + '][alamat_instalasi_jaringan]');
            });

        }

</script>