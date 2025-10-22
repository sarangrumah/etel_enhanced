@extends('layouts.frontend.main')
@section('title', 'Dashboard')
@section('js')
    <script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="/global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
    <script src="/global_assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script src="/global_assets/js/demo_pages/datatables_extension_buttons_init.js"></script>

    <script src="/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
    <script src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>

    <script src="/global_assets/js/kominfo/form_option_kominfo.js"></script>
    <script src="/global_assets/js/demo_pages/form_select2.js"></script>

@endsection
@section('content')
    <!-- Quick stats boxes -->
    <!-- /quick stats boxes -->
    @if (session()->has('success'))
    <div class="alert alert-success">
        Persyaratan telah dikirim harap menunggu proses verifikasi, Terima kasih.
    </div>
@endif

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-8">
                    <h6 class="card-title font-weight-semibold py-3">Permohonan Penomoran</h6>
                </div>
                <div class="col-lg-4 ml-lg-auto">
                    <!-- <a href="{{url('penomoran/'.$id_izin)}}" class="btn btn-indigo btn-labeled btn-labeled-left btn-lg float-right"><b><i class="icon-add"></i></b> Permohonan Baru </a> -->
                    @if(count($permohonanizin)==0)
                    <a href="{{ url('penomoran/baru/'.$id_proyek.'/'.$id_izin) }}" class="btn-tambah-penomoran btn btn-indigo btn-labeled btn-labeled-left btn-lg float-right"><b><i class="icon-add"></i></b> Permohonan Baru </a>
                    @else
                    <a href="{{ url('penomoran/penambahan/'.$id_proyek.'/'.$id_izin) }}" class="btn-tambah-penomoran btn btn-indigo btn-labeled btn-labeled-left btn-lg float-right"><b><i class="icon-add"></i></b> Penambahan Permohonan Penomoran </a>
                    @endif
                </div>
            </div>

            <!-- <p><button type="button" class="btn btn-primary btn-labeled btn-labeled-left btn-lg"><b><i class="icon-pin-alt"></i></b> Large size</button></p> -->
        </div>

        <table class="table datatable-button-init-basic">
            <thead>
                <!-- <tr>
                    <th>Proyek</th>
                    <th>Lokasi Proyek</th>
                    {{-- <th class="text-center">Tanggal Permohonan</th>
                    <th class="text-center">Batas Verifikasi</th>
                    <th class="text-center">Status</th> --}}
                    <th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
                </tr> -->
                <tr>
                    <th>Penomoran</th>
                    {{-- <th class="text-center">Tanggal Efektif</th>
                    <th class="text-center">Tanggal Expired</th> --}}
                    <th class="text-center">Tanggal Permohonan</th>
                    <th class="text-center">Status</th>
                    <th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
                </tr>
            </thead>
            <tbody>
                @if(count($permohonanizin) == 0)
                <tr> 
                    <td colspan="4" class="text-center"> Belum ada pengajuan permohonan Penomoran</td>
                </tr>
                @endif
                <?php $i=0 ; $x = 0?>
                @foreach ($permohonanizin as $item)
                <?php
                    if($item->status_permohonan !== '50'){
                        $i++;
                    }
                    if($item->status_permohonan == '50'){
                        $i = 0;
                    }
                    if($item->status_permohonan !== '90'){
                        $x++;
                    }
                ?>
                
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div>
                                <a class="text-body font-weight-semibold" href="javascript:void(0)">{{ $item->full_name}}</a><br>
                                @if($item->full_name == "Blok Nomor")
                                Kode Wilayah : <a class="text-body font-weight-semibold" href="javascript:void(0)">{{ $item->kode_wilayah}}</a><br>
                                Prefix : <a class="text-body font-weight-semibold" href="javascript:void(0)">{{ $item->prefix}}</a>
                                @else
                                Kode Akses : <a class="text-body font-weight-semibold" href="javascript:void(0)">{{ $item->kode_akses}}</a>
                                @endif
                            </div>
                        </div>
                    </td>
                    @if(!isset($item->created_date))
                    <td class="text-center"> - </td>
                    @else
                    <td class="text-center"> {{$date_reformat->dateday_lang_reformat_long($item->created_date)}}</td>
                    @endif
                    <td class="text-center"><span class="badge badge-success-100 text-success">{{ $item->name_status_bo }}</span></td>
                    <td>
                        @if($item->status_permohonan == '50')
                        <div class="dropdown">
                            <a href="javascript:void(0)"
                                class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
                                data-toggle="dropdown">
                                <i class="icon-menu7"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="{{ url('penomoran/penyesuaian/'.$id_proyek.'/'.$id_izin.'/'.$item->idtrxkodeakses) }}" class="dropdown-item"><i class="icon-file-check"></i> Penyesuaian</a>
                                <a href="{{ url('penomoran/pengembalian/'.$id_proyek.'/'.$id_izin.'/'.$item->idtrxkodeakses) }}" class="dropdown-item"><i class="icon-file-upload"></i> Pengembalian</a>
                                {{-- <a href="{{ url('pb/historyperizinan/').'/'.$item->id_izin }}" class="dropdown-item" target="_blank"><i class="icon-file-pdf"></i> Riwayat Permohonan</a> --}}
                            </div>
                        </div>
                        @endif
                    </td>
                </tr>
                @endforeach
                
            </tbody>
        </table>
    </div>
    <!-- {{$i}} -->
    

    <!-- Modal -->
    <div id="modal_theme_primary" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-indigo text-white">
                    <h6 class="modal-title">Pilih KBLI</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <div class="mb-3">
                            <p>Permohonan</p>
                            <select class="form-control select-data-array-jenisizinpenomoran" data-fouc></select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Buat Izin baru</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            if({{$i}}>0){
                $('.btn-tambah-penomoran').addClass("disabled")
            }
        });
    </script>
@endsection
