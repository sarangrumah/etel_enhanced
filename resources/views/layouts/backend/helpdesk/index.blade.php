@extends('layouts.backend.main')
@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#btnReset').hide();
        });
    </script>
    <script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="/global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
    <script src="/global_assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script src="/global_assets/js/demo_pages/datatables_extension_buttons_init.js"></script>

    <script src="/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
    <script src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>

    <script src="/global_assets/js/kominfo/form_option_kominfo.js"></script>
    <script src="/global_assets/js/demo_pages/form_select2.js"></script>

    <script src="/global_assets/js/plugins/visualization/d3/d3.min.js"></script>
    <script src="/global_assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
    <script src="/global_assets/js/plugins/ui/moment/moment.min.js"></script>
    <script src="/global_assets/js/plugins/pickers/daterangepicker.js"></script>

    <script src="/global_assets/js/demo_pages/dashboard.js"></script>
    <script src="/global_assets/js/demo_charts/pages/dashboard/light/streamgraph.js"></script>
    <script src="/global_assets/js/demo_charts/pages/dashboard/light/sparklines.js"></script>
    <script src="/global_assets/js/demo_charts/pages/dashboard/light/lines.js"></script>
    <script src="/global_assets/js/demo_charts/pages/dashboard/light/areas.js"></script>
    <script src="/global_assets/js/demo_charts/pages/dashboard/light/donuts.js"></script>
    <script src="/global_assets/js/demo_charts/pages/dashboard/light/bars.js"></script>
    <script src="/global_assets/js/demo_charts/pages/dashboard/light/progress.js"></script>
    <script src="/global_assets/js/demo_charts/pages/dashboard/light/heatmaps.js"></script>
    <script src="/global_assets/js/demo_charts/pages/dashboard/light/pies.js"></script>
    <script src="/global_assets/js/demo_charts/pages/dashboard/light/bullets.js"></script>
@endsection
@section('content')
    <!-- Support tickets -->
    <div class="card">
        <div class="card-header header-elements-sm-inline">
            <h6 class="card-title">Layanan Bantuan e-Telekomunikasi</h6>
        </div>

        <div class="card-body d-lg-flex align-items-lg-center justify-content-lg-between flex-lg-wrap">
            <div class="d-flex align-items-center mb-3 mb-lg-0">
                <div id="tickets-status"></div>
                <div class="ml-3">
                    <h5 class="font-weight-semibold mb-0">{{ $hld_count }} </h5>
                    <span class="text-muted">Total Layanan</span>
                </div>
            </div>

            <div class="d-flex align-items-center mb-3 mb-lg-0">
                <a href="#" class="btn bg-transparent border-indigo text-indigo rounded-pill border-2 btn-icon">
                    <i class="icon-alarm-add"></i>
                </a>
                <div class="ml-3">
                    <h5 class="font-weight-semibold mb-0">{{ $vwhld_open_count }}</h5>
                    <span class="text-muted">Total Layanan Terbuka</span>
                </div>
            </div>

            <div class="d-flex align-items-center mb-3 mb-lg-0">
                <a href="#" class="btn bg-transparent border-indigo text-indigo rounded-pill border-2 btn-icon">
                    <i class="icon-file-zip"></i>
                </a>
                <div class="ml-3">
                    <h5 class="font-weight-semibold mb-0">{{ $vwhld_done_count }}</h5>
                    <span class="text-muted">Total Layanan Selesai</span>
                </div>
            </div>

            <div class="d-flex align-items-center mb-3 mb-lg-0">
                <a href="#" class="btn bg-transparent border-indigo text-indigo rounded-pill border-2 btn-icon">
                    <i class="icon-spinner11"></i>
                </a>
                <div class="ml-3">
                    <h5 class="font-weight-semibold mb-0">{{ $vwhld_cancelled_count }}</h5>
                    <span class="text-muted">Total Layanan Dibatalkan</span>
                </div>
            </div>

            <div class="d-flex align-items-center mb-3 mb-lg-0">
                <a href="#" class="btn bg-transparent border-indigo text-indigo rounded-pill border-2 btn-icon">
                    <i class="icon-spinner11"></i>
                </a>
                <div class="ml-3">
                    <h5 class="font-weight-semibold mb-0">{{ $vwhld_wia_count }}</h5>
                    <span class="text-muted">Total Layanan Menunggu Konfirmasi</span>
                </div>
            </div>

            <div>
                <a href="#" class="btn btn-teal"><i class="icon-statistics mr-2"></i> Report</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table text-nowrap">
                <thead>
                    <tr>
                        <th style="width: 50px">Durasi</th>
                        <th style="width: 300px;">Detail Pengguna Layanan</th>
                        <th>Pesan Layanan</th>
                        <th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="table-active table-border-double">
                        <td colspan="3">Layanan Bantuan Terbuka</td>
                        <td class="text-right">
                            <span class="badge badge-primary badge-pill">{{ $vwhld_open_count }}</span>
                        </td>
                    </tr>
                    @if ($vwhld_open_count > 0)
                    @foreach ($vwhld_open as $help_open)
                        <tr>
                            <td class="text-center">
                                <h6 class="mb-0">{{ $help_open->due }}</h6>
                                <div class="font-size-sm text-muted line-height-1">hari</div>
                            </td>
                            <td>
                                <div>{{ $help_open->nama_pengirim_layanan }} </div>
                                <div>{{ $help_open->email_pengirim_layanan }} </div>
                                <div>{{ $help_open->telp_pengirim_layanan }} </div>
                            </td>
                            <td style="word-wrap: break-word;min-width: 160px;max-width: 160px;" >
                                <a href="/admin/updatelayanan/{{ $help_open->id }}" class="text-body">
                                    <div class="font-weight-semibold">[Layanan {{ $help_open->jenis_layanan }}
                                        #{{ $help_open->id }}]</div>
                                    <span style="max-width: 300px;" class="d-inline-block text-truncate text-muted">{{ $help_open->judul_pesan_layanan }}</span>
                                </a>
                            </td>
                            <td class="text-center">
                                <div class="list-icons">
                                    <div class="dropdown">
                                        <a href="#" class="list-icons-item" data-toggle="dropdown">
                                            <i class="icon-menu9"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right">
                                            @if ($help_open->status == 'Closed')
                                                <a href="/admin/updatelayanan/{{ $help_open->id }}" class="dropdown-item"><i
                                                        class="icon-search4"></i>
                                                    Lihat
                                                    Detail</a>
                                            @else
                                                <a href="/admin/updatelayanan/{{ $help_open->id }}" class="dropdown-item"><i
                                                        class="icon-search4"></i>
                                                    Lihat
                                                    Detail</a>
                                                <a href="/tutuplayanan/{{ $help_open->id }}" class="dropdown-item"><i
                                                        class="icon-task"></i>
                                                    Tutup Ticket</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @endif

                    <tr class="table-active table-border-double">
                        <td colspan="3">Layanan Bantuan Selesai</td>
                        <td class="text-right">
                            <span class="badge badge-success badge-pill">{{ $vwhld_done_count }}</span>
                        </td>
                    </tr>
                    @foreach ($vwhld_done as $help_done)
                        <tr>
                            <td class="text-center">
                                <i class="icon-checkmark3 text-success"></i>
                            </td>
                            <td>
                                <div>{{ $help_done->nama_pengirim_layanan }} </div>
                                <div>{{ $help_done->email_pengirim_layanan }} </div>
                                <div>{{ $help_done->telp_pengirim_layanan }} </div>
                            </td>
                            <td>
                                <a href="/admin/updatelayanan/{{ $help_done->id }}" class="text-body">
                                    <div class="font-weight-semibold">[Layanan {{ $help_done->jenis_layanan }}
                                        #{{ $help_done->id }}]</div>
                                    <span class="text-muted">{{ $help_done->judul_pesan_layanan }}</span>
                                </a>
                            </td>
                            <td class="text-center">
                                <div class="list-icons">
                                    <div class="dropdown">
                                        <a href="#" class="list-icons-item" data-toggle="dropdown">
                                            <i class="icon-menu9"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right">
                                            @if ($help_done->status == 'Closed')
                                                <a href="/admin/updatelayanan/{{ $help_done->id }}" class="dropdown-item"><i
                                                        class="icon-search4"></i>
                                                    Lihat
                                                    Detail</a>
                                            @else
                                                <a href="/admin/updatelayanan/{{ $help_done->id }}" class="dropdown-item"><i
                                                        class="icon-search4"></i>
                                                    Lihat
                                                    Detail</a>
                                                <a href="/tutuplayanan/{{ $help_open->id }}" class="dropdown-item"><i
                                                        class="icon-task"></i>
                                                    Tutup Ticket</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    <tr class="table-active table-border-double">
                        <td colspan="3">Layanan Bantuan Dibatalkan</td>
                        <td class="text-right">
                            <span class="badge badge-danger badge-pill">{{ $vwhld_cancelled_count }}</span>
                        </td>
                    </tr>

                    @foreach ($vwhld_cancelled as $help_cancelled)
                        <tr>
                            <td class="text-center">
                                <i class="icon-checkmark3 text-success"></i>
                            </td>
                            <td>
                                <div>{{ $help_cancelled->nama_pengirim_layanan }} </div>
                                <div>{{ $help_cancelled->email_pengirim_layanan }} </div>
                                <div>{{ $help_cancelled->telp_pengirim_layanan }} </div>
                            </td>
                            <td>
                                <a href="/admin/updatelayanan/{{ $help_cancelled->id }}" class="text-body">
                                    <div class="font-weight-semibold">[Layanan {{ $help_cancelled->jenis_layanan }}
                                        #{{ $help_cancelled->id }}]</div>
                                    <span class="text-muted">{{ $help_cancelled->judul_pesan_layanan }}</span>
                                </a>
                            </td>
                            <td class="text-center">
                                <div class="list-icons">
                                    <div class="dropdown">
                                        <a href="#" class="list-icons-item" data-toggle="dropdown">
                                            <i class="icon-menu9"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right">
                                            @if ($help_cancelled->status == 'Closed')
                                                <a href="/admin/updatelayanan/{{ $help_cancelled->id }}"
                                                    class="dropdown-item"><i class="icon-search4"></i>
                                                    Lihat
                                                    Detail</a>
                                            @else
                                                <a href="/admin/updatelayanan/{{ $help_cancelled->id }}"
                                                    class="dropdown-item"><i class="icon-search4"></i>
                                                    Lihat
                                                    Detail</a>
                                                <a href="/tutuplayanan/{{ $help_cancelled->id }}"
                                                    class="dropdown-item"><i class="icon-task"></i>
                                                    Tutup Ticket</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    <tr class="table-active table-border-double">
                        <td colspan="3">Layanan Bantuan Menunggu Konfirmasi</td>
                        <td class="text-right">
                            <span class="badge badge-danger badge-pill">{{ $vwhld_wia_count }}</span>
                        </td>
                    </tr>

                    @foreach ($vwhld_wia as $help_wia)
                        <tr>
                            <td class="text-center">
                                <h6 class="mb-0">{{ $help_wia->due }}</h6>
                                <div class="font-size-sm text-muted line-height-1">hari</div>
                            </td>
                            <td>
                                <div>{{ $help_wia->nama_pengirim_layanan }} </div>
                                <div>{{ $help_wia->email_pengirim_layanan }} </div>
                                <div>{{ $help_wia->telp_pengirim_layanan }} </div>
                            </td>
                            <td>
                                <a href="/admin/updatelayanan/{{ $help_wia->id }}" class="text-body">
                                    <div class="font-weight-semibold">[Layanan {{ $help_wia->jenis_layanan }}
                                        #{{ $help_wia->id }}]</div>
                                    <span class="text-muted">{{ $help_wia->judul_pesan_layanan }}</span>
                                </a>
                            </td>
                            <td class="text-center">
                                <div class="list-icons">
                                    <div class="dropdown">
                                        <a href="#" class="list-icons-item" data-toggle="dropdown">
                                            <i class="icon-menu9"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right">
                                            @if ($help_wia->status == 'Closed')
                                                <a href="/admin/updatelayanan/{{ $help_wia->id }}" class="dropdown-item"><i
                                                        class="icon-search4"></i>
                                                    Lihat
                                                    Detail</a>
                                            @else
                                                <a href="/admin/updatelayanan/{{ $help_wia->id }}" class="dropdown-item"><i
                                                        class="icon-search4"></i>
                                                    Lihat
                                                    Detail</a>
                                                <a href="/tutuplayanan/{{ $help_wia->id }}" class="dropdown-item"><i
                                                        class="icon-task"></i>
                                                    Tutup Ticket</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- /support tickets -->

    <!-- Basic datatable -->
    {{-- <div class="card">
        <div class="card-header">
            <h5 class="card-title">Daftar Layanan e-Telekomunikasi</h5>
        </div>

        <table class="table datatable-basic">
            <thead>
                <tr>
                    <th>Detail Pengirim</th>
                    <th>Jenis Layanan</th>
                    <th>Status</th>
                    <th>Tanggal Pengajuan Layanan</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hld as $help)
                    <tr>
                        <td>
                            <div>{{ $help->nama_pengirim_layanan }} </div>
                            <div>{{ $help->email_pengirim_layanan }} </div>
                            <div>{{ $help->telp_pengirim_layanan }} </div>
                        </td>
                        <td><a href="#">{{ $help->jenis_layanan }}</a></td>
                        <td><span class="badge badge-success">{{ $help->status }}</span></td>
                        <td>{{ $help->created_date }}</td>

                        <td class="text-center">
                            <div class="list-icons">
                                <div class="dropdown">
                                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                                        <i class="icon-menu9"></i>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right">
                                        @if ($help->status == 'Closed')
                                            <a href="/updatelayanan/{{ $help->id }}" class="dropdown-item"><i
                                                    class="icon-search4"></i> Lihat
                                                Detail</a>
                                        @else
                                            <a href="/updatelayanan/{{ $help->id }}" class="dropdown-item"><i
                                                    class="icon-search4"></i> Lihat
                                                Detail</a>
                                            <a href="/tutuplayanan/{{ $help->id }}" class="dropdown-item"><i
                                                    class="icon-task"></i>
                                                Tutup Ticket</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach


            </tbody>
        </table>
    </div> --}}
    <!-- /basic datatable -->
@endsection
