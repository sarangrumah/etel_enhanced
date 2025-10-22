@extends('layouts.backend.main')
@section('js')
    <script src="{{ url('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ url('global_assets/js/demo_pages/form_layouts.js') }}"></script>
@endsection
@section('content')
    <form method="post" id="formEvaluasi">
        <div class="form-group">
            <!-- Section Detail Permohonan -->
            <div>
                <div class="card">
                    <div class="card-header bg-indigo text-white header-elements-inline">
                        <div class="row">
                            <div class="col-lg">
                                <h6 class="card-title font-weight-semibold py-3">Informasi Permohonan </h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">No Permohonan </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">: {{ $izin['id_izin'] }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Jenis Permohonan </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">: {!! $izin['jenis_layanan_html'] !!}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Tanggal Permohonan </label>
                                    <div class="col-lg">
                                        @if ($izin['submitted_at'] == null)
                                            <label class="col-lg col-form-label">: - </label>
                                        @else
                                            <label class="col-lg col-form-label">:
                                                {{ $date_reformat->dateday_lang_reformat_long($izin['submitted_at']) }}</label>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Status Permohonan </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">: {{ $izin['status_bo'] }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($izin['updated_at_ulo'] != '-')
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <label class="col-lg-4 col-form-label">Tanggal Permohonan ULO</label>
                                        <div class="col-lg">
                                            @if ($izin['submitted_at'] == null)
                                                <label class="col-lg col-form-label">: - </label>
                                            @else
                                                <label class="col-lg col-form-label">:
                                                    {{ $date_reformat->dateday_lang_reformat_long($ulo['updated_date']) }}</label>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <label class="col-lg-4 col-form-label">Status Permohonan ULO</label>
                                        <div class="col-lg">
                                            <label class="col-lg col-form-label">: {{ $ulo['name_status_bo'] }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- End Section Detail Permohonan -->

            <!-- Section Detail Perusahaan -->
            <div>
                <div class="card">
                    <div class="card-header bg-indigo text-white header-elements-inline">
                        <div class="row">
                            <div class="col-lg">
                                <h6 class="card-title font-weight-semibold py-3">Informasi Perusahaan </h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <legend class="text-uppercase font-size-sm font-weight-bold">Data Perusahaan</legend>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">NIB </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">: {{ $detailnib['nib'] }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Nama </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">: {{ $detailnib['nama_perseroan'] }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">NPWP </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">: {{ $detailnib['npwp_perseroan'] }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">No Telp </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ $detailnib['nomor_telpon_perseroan'] }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <legend class="text-uppercase font-size-sm font-weight-bold">Data Penanggung Jawab</legend>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">NIK </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penanggungjawab['no_ktp']) ? $penanggungjawab['no_ktp'] : '-' }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Nama </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penanggungjawab['nama_user_proses']) ? $penanggungjawab['nama_user_proses'] : '-' }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Email </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penanggungjawab['email_user_proses']) ? $penanggungjawab['email_user_proses'] : '-' }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">No Telp/Mobile </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penanggungjawab['hp_user_proses']) ? $penanggungjawab['hp_user_proses'] : '-' }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Section Detail Perusahaan -->

            <div class="card">
                <div class="card-header bg-indigo text-white header-elements-inline">
                    <div class="row">
                        <div class="col-lg">
                            <h6 class="card-title font-weight-semibold py-3">Persyaratan Permohonan Izin</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        @csrf
                        <input type="hidden" name="id_izin" value="{{ $izin['id_izin'] }}">
                        @if (count($map_izin) > 0)
                            @foreach ($map_izin as $mi)
                                @if ($mi->file_type == 'pdf')
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-12">
                                                    <p class="font-weight-semibold">{!! $mi->persyaratan_html !!}</p>
                                                    <div class="input-group">
                                                        <input disabled="disabled" type="text"
                                                            class="form-control border-right-0"
                                                            placeholder="{{ isset($mi->nama_asli) ? $mi->nama_asli : '' }}">
                                                        <span class="input-group-append">
                                                            <?php 
                                                    if (isset($mi->form_isian) && $mi->form_isian != '') {
                                                        ?><a target="_blank"
                                                                href="{{ asset($mi->form_isian) }}" class="btn btn-teal"
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

                                    </div>
                                @elseif($mi->file_type == 'table' && $mi->component_name != null)
                                    @if (isset($mi->form_isian))
                                        <p class="font-weight-bold">{!! $mi->persyaratan_html !!}</p>
                                        <x-dynamic-component :component="$mi->component_name" :triger="$triger ?? 'null'" :datajson="$mi->form_isian ?? 'kosong'"
                                            :needcorrection="$mi->need_correction ?? ''" :correctionnote="$mi->correction_note ?? ''" />
                                        <hr>
                                    @endif
                                @elseif($mi->file_type == 'integration')
                                    @if ($mi->is_mandatory == '1')
                                        <p class="font-weight-semibold">{{ $mi->persyaratan }}</p>
                                        <?php
                                        if ($mi->form_isian) {
                                            $datajson = json_decode($mi->form_isian, true)[0];
                                        }
                                        ?>
                                        @if (isset($datajson))
                                            <table class="table">
                                                @foreach ($datajson as $key => $d)
                                                    <tr>
                                                        <td width="30">{{ ucwords(str_replace('_', ' ', $key)) }}
                                                        </td>
                                                        <td>{{ $d }}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                            @php
                                                $datajson = '';
                                            @endphp
                                        @else
                                            <p>Data Kosong!</p>
                                        @endif
                                        <hr>
                                    @else
                                        <div class="form-group">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-12">
                                                        {{-- <p class="font-weight-semibold">Surat Pernyataan Tidak Menggunakan --}}
                                                        <p class="font-weight-semibold">
                                                            {!! $mi->persyaratan_html !!}</p>
                                                        <div class="input-group">
                                                            <input disabled="disabled" type="text"
                                                                class="form-control border-right-0"
                                                                placeholder="{{ isset($mi->nama_asli) ? $mi->nama_asli : '' }}">
                                                            <span class="input-group-append">
                                                                <?php 
                                                    if (isset($mi->form_isian) && $mi->form_isian != '') {
                                                        ?><a target="_blank"
                                                                    href="{{ asset($mi->form_isian) }}"
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
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    </div>

                </div>
            </div>
            @if(isset($ulo['id_izin']))
            <div class="card">
                <div class="card-header bg-indigo text-white header-elements-inline">
                    <div class="row">
                        <div class="col-lg">
                            <h6 class="card-title font-weight-semibold py-3">Evaluasi Uji Laik Operasi </h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div>
    
                        @csrf
                        <input type="hidden" name="id_izin" value="{{$ulo['id_izin']}}">
    
                        <div class="form-group">
                            <div class="col-lg-12">
    
                                @if($ulo['tipe_ulo'] == '1')
                                <div class="row">
    
                                    <div class="col-12">
                                        <p class="font-weight-semibold">Dokumen Surat Permohonan Uji Laik Operasi</p>
                                        <div class="input-group">
                                            <input disabled="disabled" type="text" class="form-control border-right-0"
                                                placeholder="Dokumen"
                                                value="{{ isset($ulo['surat_permohonan_ulo_asli'])?$ulo['surat_permohonan_ulo_asli']:''; }}">
                                            <span class="input-group-append">
                                                <?php 
                                            if (isset($ulo['surat_permohonan_ulo']) && $ulo['surat_permohonan_ulo'] != '') {
                                                ?><a target="_blank" href="{{ url($ulo['surat_permohonan_ulo']) }}"
                                                    class="btn btn-teal" type="button">Lihat Dokumen</a>
                                                <?php
                                            }else{
                                                ?><a href="#" class="btn btn-teal" type="button">Lihat Dokumen</a>
                                                <?php
                                            }
                                            ?>
                                            </span>
                                        </div>
                                    </div>
    
                                </div>
                                @else
                                <div class="row">
                                    <div class="col-12">
                                        <p class="font-weight-semibold">Dokumen Surat Tugas </p>
                                        <div class="input-group">
                                            <input disabled="disabled" type="text" class="form-control border-right-0"
                                                placeholder="Dokumen"
                                                value="{{ isset($ulo['surat_tugas_pelaksanaan_ulo_mandiri_asli'])?$ulo['surat_tugas_pelaksanaan_ulo_mandiri_asli']:''; }}">
                                            <span class="input-group-append">
                                                <?php 
                                            if (isset($ulo['surat_tugas_pelaksanaan_ulo_mandiri']) && $ulo['surat_tugas_pelaksanaan_ulo_mandiri'] != '') {
                                                ?><a target="_blank"
                                                    href="{{ url($ulo['surat_tugas_pelaksanaan_ulo_mandiri']) }}"
                                                    class="btn btn-teal" type="button">Lihat Dokumen</a>
                                                <?php
                                            }else{
                                                ?><a href="#" class="btn btn-teal" type="button">Lihat Dokumen</a>
                                                <?php
                                            }
                                            ?>
                                            </span>
                                        </div>
                                    </div>
    
                                </div>
    
                                <div class="row">
                                    <div class="col-12">
                                        <p class="font-weight-semibold">Dokumen Hasil Pengujian </p>
                                        <div class="input-group">
                                            <input disabled="disabled" type="text" class="form-control border-right-0"
                                                placeholder="Dokumen"
                                                value="{{ isset($ulo['hasil_pengujian_ulo_mandiri_asli'])?$ulo['hasil_pengujian_ulo_mandiri_asli']:''; }}">
                                            <span class="input-group-append">
                                                <?php 
                                            if (isset($ulo['hasil_pengujian_ulo_mandiri']) && $ulo['hasil_pengujian_ulo_mandiri'] != '') {
                                                ?><a target="_blank" href="{{ url($ulo['hasil_pengujian_ulo_mandiri']) }}"
                                                    class="btn btn-teal" type="button">Lihat Dokumen</a>
                                                <?php
                                            }else{
                                                ?><a href="#" class="btn btn-teal" type="button">Lihat Dokumen</a>
                                                <?php
                                            }
                                            ?>
                                            </span>
                                        </div>
                                    </div>
    
                                </div>
                                @endif
                            </div>
                        </div>
    
                    </div>
    
                </div>
            </div>
    
            <div class="card">
                <div class="card-header bg-indigo text-white header-elements-inline">
                    <div class="row">
                        <div class="col-lg">
                            <h6 class="card-title font-weight-semibold py-3">Catatan Hasil Evaluasi</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($ulo['nama_master_izin'] == 'TELSUS')
                    <div class="form-group">
                        <label for="MediaTransmisiYangDigunakan">Media Transmisi yang Digunakan </label>
                        <textarea class="form-control" readonly
                            rows="3">{{$ulo['media_transmisi_yang_digunakan']}}</textarea>
                    </div>
                    @else
                    <div class="form-group">
                        <label for="alamatPusatLayananPelangan">Alamat Pusat Layanan Pelanggan </label>
                        <textarea class="form-control" id="alamatPusatLayananPelangan" readonly
                            rows="3">{!! $ulo['alamat_pusat_layanan_pelangan'] !!}</textarea>
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="AlamatPelaksanaanUlo">Alamat Pelaksanaan ULO</label>
                        <textarea class="form-control" id="AlamatPelaksanaanUlo" readonly
                            rows="3">{!! $ulo['alamat_pelaksanaan_ulo'] !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="TanggalEvaluasiPelaksanaanUlo">Tanggal Evaluasi Pelaksanaan ULO </label>
                        <input type="text" class="form-control" readonly
                            value="{{ $date_reformat->dateday_lang_reformat_long($ulo['tanggal_evaluasi_pelaksanaan_ulo']) }}"
                            placeholder="dd-mm-yyyy">
                    </div>
                    <div class="form-group">
                        <label for="NoSuratPerintahTugas">No Surat Perintah Tugas (SPT) ULO </label>
                        <input type="text" class="form-control" readonly value="{{$ulo['no_surat_perintah_tugas']}}">
                    </div>
                    <div class="form-group">
                        <label for="TanggalSuratPerintahTugas">Tanggal Surat Perintah Tugas (SPT) ULO </label>
                        <input type="text" class="form-control" readonly
                            value="{{ $date_reformat->dateday_lang_reformat_long($ulo['tanggal_surat_perintah_tugas']) }}"
                            placeholder="dd-mm-yyyy">
                    </div>
                    <div class="form-group">
                        <label for="uploadSuratPerintahTugas">Surat Perintah Tugas (SPT) ULO </label>
                        <div class="input-group">
                            <input disabled="disabled" type="text" class="form-control border-right-0" placeholder="Dokumen"
                                value="{{ isset($ulo['upload_surat_perintah_tugas_asli'])?$ulo['upload_surat_perintah_tugas_asli']:''; }}">
                            <span class="input-group-append">
                                <?php 
                            if (isset($ulo['upload_surat_perintah_tugas_asli']) && $ulo['upload_surat_perintah_tugas_asli'] != '') {
                                ?><a target="_blank" href="{{ url($ulo['upload_surat_perintah_tugas']) }}" class="btn btn-teal"
                                    type="button">Lihat Dokumen</a>
                                <?php
                            }else{
                                ?><a href="#" class="btn btn-teal" type="button">Lihat Dokumen</a>
                                <?php
                            }
                            ?>
                            </span>
                        </div>
                    </div>
    
                    <div class="form-group">
                        <label for="DasarSuratPermohonanUlo">Dasar surat permohonan ULO dari perusahaan Pemohon ULO </label>
                        <textarea class="form-control" readonly rows="3">{{$ulo['dasar_surat_permohonan_ulo']}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="UploadDokumenHasilEvaluasiPelaksanaanUlo">Upload dokumen hasil evaluasi pelaksanaan ULO
                        </label>
                        <div class="input-group">
                            <input disabled="disabled" type="text" class="form-control border-right-0" placeholder="Dokumen"
                                value="{{ isset($ulo['upload_dokumen_hasil_evaluasi_pelaksanaan_ulo_asli'])?$ulo['upload_dokumen_hasil_evaluasi_pelaksanaan_ulo_asli']:''; }}">
                            <span class="input-group-append">
                                <?php 
                            if (isset($ulo['upload_dokumen_hasil_evaluasi_pelaksanaan_ulo_asli']) && $ulo['upload_dokumen_hasil_evaluasi_pelaksanaan_ulo_asli'] != '') {
                                ?><a target="_blank" href="{{ url($ulo['upload_dokumen_hasil_evaluasi_pelaksanaan_ulo']) }}"
                                    class="btn btn-teal" type="button">Lihat Dokumen</a>
                                <?php
                            }else{
                                ?><a href="#" class="btn btn-teal" type="button">Lihat Dokumen</a>
                                <?php
                            }
                            ?>
                            </span>
                        </div>
                    </div>
    
    
                    <div class="form-group">
                        <label for="status_laik">Hasil Evaluasi Status Laik</label>
                        <select name="status_laik" id="status_laik" data-placeholder="Silakan Pilih" class="form-control"
                            disabled>
                            <option value="null">--Silakan Pilih --</option>
                            <option value="1" @if($ulo['status_laik'] == '1') selected @endif>Laik Operasi</option>
                            <option value="0" @if($ulo['status_laik'] == '0') selected @endif>Tidak Laik Operasi</option>
                        </select>
                    </div>
                    
                    {{-- <div class="form-group">
                        <label for="catatan_hasil_evaluasi">Catatan Hasil Evaluasi</label>
                        <textarea class="form-control" class="form-control" placeholder="Hasil Evaluasi"
                            name="catatan_hasil_evaluasi" id="catatan_hasil_evaluasi" rows="3"></textarea>
                    </div> --}}
                </div>
            </div>
            @endif

            <div class="card">
                <div class="card-header bg-indigo text-white header-elements-inline">
                    <div class="row">
                        <div class="col-lg">
                            <h6 class="card-title font-weight-semibold py-3">Riwayat Permohonan</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('layouts.backend.historyperizinan.dashboard-request', ['history'=>$history,'historyizin'=>$historyizin,'itemkodestatus'=>$itemkodestatus,'itemnamakodestatus'=>$itemnamakodestatus])
                </div>
            </div>

            <div class="form-group text-right">
                <a href="{{ route('admin.laporan-request') }}" class="btn btn-secondary border-transparent"><i
                        class="icon-backward2 ml-2"></i> Kembali </a>
                <!-- <button type="submit" class="btn btn-primary">Kirim Evaluasi Pendaftaran <i class="icon-paperplane ml-2"></i></button> -->
                {{-- <a target="_blank" href="{{ route('admin.historyperizinan', $izin['id_izin']) }}"
                    class="btn btn-info">Riwayat Permohonan <i class="icon-history ml-2"></i></a> --}}
                {{-- <a href="{{ route('admin.sk.draftIzinPrinsip', $izin['id_izin']) }}" target="_blank"
                    class="btn btn-success">Draf SKLO <i class="icon-file-pdf ml-2"></i></a> --}}
            </div>
        </div>
@endsection
