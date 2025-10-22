@extends('layouts.frontend.main')
<!-- @section('title', 'Permohonan Penomoran Baru') -->
@section('js')

    <script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>
    <script src="global_assets/js/demo_pages/form_layouts.js"></script>

@endsection
@section('content')
    {{-- <x-perizinan /> --}}

    <div class="card">

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <h4>UMKU Penomoran Untuk Proyek: </h4>
                </div>
                <div class="col-12">
                    <a class="text-body font-weight-semibold" href="javascript:void(0)">{{ $izin->id_izin }}</a>
                    <div class="text-muted font-size-sm">{{ $izin->kbli }} - {{ $izin->jenis_izin }}</div>
                    <div class="text-muted font-size-sm">{!! $izin->jenis_layanan_html !!}</div>
                    <div class="text-muted font-size-sm">{{ $izin->id_proyek }}</div>
                </div>
            </div>
        </div>


    </div>
    <div class="card">
        <div class="card-header bg-indigo text-white header-elements-inline">
            <div class="row">
                <div class="col-lg">
                    <h6 class="card-title font-weight-semibold py-3">Permohonan Penomoran Yang diajukan</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table datatable-button-init-basic">
                <thead>
                    <tr>
                        <th>Permohonan Penomoran</th>
                        {{-- <th class="text-center">Tanggal Permohonan</th>
                        <th class="text-center">Batas Verifikasi</th>
                        <th class="text-center">Status</th> --}}
                        <th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penomoran as $item)
                        <tr>
                            <td class="text-left">
                                <div>{{ $item->id_izin }}</div>
                                <div>{{ $item->nama_izin }}</div>
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <a href="#"
                                        class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
                                        data-toggle="dropdown">
                                        <i class="icon-menu7"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="{{ url('penomoran/baru/' . $item->id_proyek . '/' . $item->id_izin) }}"
                                            class="dropdown-item"><i class="icon-file-upload"></i> Ajukan Penomoran Baru</a>
                                        <a href="{{ url('penomoran/pengajuan/' . $item->id_proyek . '/' . $item->id_izin) }}"
                                            class="dropdown-item"><i class="icon-file-eye"></i> Lihat Pengajuan
                                            Penomoran</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>


    </div>



    @push('scripts')
        <script>
            function pilihjenislayanan() {
                let jenislayananval = $("#jenislayanan").val();
                $("#jenisnomor").children().remove()
                // $("#availno").prop('disabled', true)
                console.log(jenislayananval);
                if (jenislayananval != '' && jenislayananval != null) {
                    $.ajax({
                        url: "{{ url('') }}/jenisnomor/" + jenislayananval,
                        type: 'GET',
                        datatype: 'json',
                        success: function(res) {
                            var temp = res;
                            $("#jenisnomor").empty();
                            $("#jenisnomor").append('<option selected disabled>-- Pilih Nomor --</option>');
                        }

                    });
                }

            }

            function pilihjenisno() {
                let jenisno = $("#jenisnomor").val();
                $("#availno").children().remove()
                // $("#availno").prop('disabled', true)
                console.log(jenisno);
                if (jenisno != '' && jenisno != null) {
                    $.ajax({
                        url: "{{ url('') }}/ambilnomor/" + jenisno,
                        type: 'GET',
                        datatype: 'json',
                        success: function(res) {
                            var temp = res;
                            $("#availno").empty();
                            $("#availno").append('<option selected disabled>-- Pilih Nomor --</option>');
                            var len = 0;
                            console.log(res['datano']);
                            if (res['datano'] != null) {
                                len = res['datano'].length;
                            }
                            if (len > 0) {
                                for (var i = 0; i < len; i++) {
                                    var id = res['datano'][i].id;
                                    console.log(res['datano'][i].id);
                                    var name = res['datano'][i].list_nomor;

                                    var option = '<option value="' + id + '"">' + name + '</option>';

                                    $("#availno").append(option);

                                }
                            }

                        }

                    });
                }

            }

            function noselected() {
                $('#availno').on("change", function() {
                    var value = $(this).val();
                    var text = $(this).find('option:selected').text();
                    console.log(text);
                });
                // let nopilih = $("#availno").val();
                // console.log(nopilih)
            }
        </script>
    @endpush
@endsection
