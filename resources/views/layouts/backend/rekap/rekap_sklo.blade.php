@extends('layouts.backend.main')
<!-- @section('title', 'Dashboard') -->
@section('content')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#btnReset').hide();
        });
    </script>
    <div>
        @if (Session::get('message') != '')
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>    
                <strong>{{ Session::get('message') }}</strong>
            </div>
        @endif

        <!-- Latest orders -->
        <div class="card">
            <div class="card-header">
                <div class="row">
					<div class="col-lg-8">
                        <h6 class="card-title font-weight-semibold py-3">Rekap SKLO</h6>
					</div>
					<div class="d-inline-flex align-items-center ml-auto">
						<div class="dropdown ml-2">
							<a href="javascript:void(0)" class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill" data-toggle="dropdown">
								<i class="icon-more2"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right"></a>
								<a href="javascript:void(0)" class="dropdown-item"><i class="icon-database-refresh"></i> Perbaharui Data</a>
								<a href="javascript:void(0)" class="dropdown-item"><i class="icon-file-plus"></i></b> Tambah Data Perizinan</a>
							</div>
						</div>
					</div>
				</div>
                {{-- <div class="row">
                    <form  action="{{ url('/pb/get_by_date') }}" method="post" enctype="multipart/form-data" id="">
                        @csrf
                        <div class="row">
                            <div class="col col-sm-6 col-xs-6 mt-2">
                            <input type="date" class="form-control" name="tglAwal" id="tglAwal" placeholder="Tanggal Awal" required>
                            </div>
                            <div class="col col-sm-6 col-xs-6 mt-2">
                            <input type="date" class="form-control" name="tglAkhir" id="tglAkhir" placeholder="Tanggal Akhir" required>
                            </div>
                            <div class="col col-sm-6 col-xs-6 mt-2">
                                <a type="butoon" id="btnReset" onclick="location.reload()" class="btn btn-block btn-info">Reset Tanggal</a>
                            </div>
                            <div class="col col-sm-6 col-xs-6 mt-2">
                            <input type="submit" id="btnSubmit" class="btn btn-block btn-primary" value="Cari">
                            </div>
                        </div>
                    </form>
                </div> --}}
            </div>

            <div class="table-responsive border-top-0">
                <table class="table text-nowrap datatable-button-init-basic" id="table">
                    <thead>
                        <tr>
                            <th>Nomor SKLO</th>
                            <th class="text-center">Tanggal Terbit</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
                        </tr>
                    </thead>
                    <tbody>

                        @if (isset($izin['data']) && count($izin['data']) > 0)
                            @foreach ($izin['data'] as $izins)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="text-muted font-size-sm">{{ $izins['jenis_izin'] }}</div>
                                                <div class="text-muted font-size-sm">{{ $izins['kbli'] }} -
                                                    {{ $izins['kbli_name'] }}</div>
                                                <div class="text-muted font-size-sm">{!! $izins['jenis_layanan_html'] !!}</div>
                                            </div>

                                        </div>
                                    </td>
                                    @if(!isset($izins['updated_at']))
                                    <td class="text-center"> - </td>
                                    @else
                                    <td class="text-center"> {{$date_reformat->dateday_lang_reformat_long($izins['updated_at'])}}</td>
                                    @endif
                                    <td class="text-center">3 Hari</td>
                                    <td class="text-center"><span
                                            class="badge badge-success-100 text-success">{{ $izins['status_bo'] }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <a href="#"
                                                class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
                                                data-toggle="dropdown">
                                                <i class="icon-menu7"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a target="_blank" href="{{ route('admin.historyperizinan', $izins['id_izin']) }}" class="dropdown-item"><i class="icon-file-pdf"></i> Log Perizinan</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>


            </div>

        </div>
        <div class="text-right pagination-flat" style="float:right">
            @if ($paginate != null && $paginate->count() > 0)
                {{ $paginate->links() }}
            @endif
        </div>
        <!-- /latest orders -->
    </div>
    <script type="text/javascript">
	$(document).ready(function(){
		$('#form_get_by_date').submit(function(e) {
			e.preventDefault();

			$('#btnSubmit').val("Mencari ...");


			var formData = new FormData(this);

			// console.log(formData)
			$.ajax({
				type:'POST',
				url: "{{  url('/pb/get_by_date') }}",
				data: formData,
				cache:false,
				contentType: false,
				processData: false,
				success: (data) => {
					console.log(data);
					table = $('#table').DataTable({
						destroy : true,
						data: data,
						columns: [
							{ data: null,
								render: function ( data, type, row ) {
									// Combine the first and last names into a single table field
									var view = "<div class='d-flex align-items-center'><div><a class='text-body font-weight-semibold' href='javascript:void(0)'>"+data.id_izin+"</a><div class='text-muted font-size-sm'>"+data.kbli+" - "+data.jenis_izin+"</div><div class='text-muted font-size-sm'>"+data.jenis_layanan+"</div><div class='text-muted font-size-sm'>"+data.id_proyek+"</div></div></div>"
									return view;
								},
								editField: ['id_izin', 'jenis_izin','kbli','jenis_layanan','id_proyek']
							},
							{ data: 'updated_at',
								"render" : function (data, type, row) {
									const myArray = data.split("T");
									const thbl = myArray[0].split("-");
									// console.log(myArray[0]);

									switch (thbl[1]){
										case "01":
											teks = "Januari";
											break;
										case "02":
											teks = "Februari";
											break;
										case "3":
											teks = "Maret";
											break;
										case "04":
											teks = "April";
											break;
										case "05":
											teks = "Mei";
											break;
										case "06":
											teks = "Juni";
											break;
										case "07":
											teks = "Juli";
											break;
										case "08":
											teks = "Agustus";
											break;
										case "09":
											teks = "September";
											break;
										case "10":
											teks = "Oktober";
											break;
										case "11":
											teks = "November";
											break;
										case "12":
											teks = "Desember";
											break;
										default:
											teks = "Bulan Tidak Valid";
									}		
									const jam = myArray[1].split(".");
									var all = thbl[2]+" "+teks+" "+thbl[0]+" - "+jam[0]
									return all
								}
							},
							{ data: 'status_fo',
								"render": function ( data, type, row ) {
									var button = "<span class='badge badge-success-100 text-success'>"+data+"</spam>"
									return button;
								},
							},
							{ data: 'id_izin',
								"render": function ( data, type, row ) {
									var button = "<div class='dropdown'><a href='javascript:void(0)' class='btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill' data-toggle='dropdown'> <i class='icon-menu7'></i></a> <div class='dropdown-menu dropdown-menu-right'> <a href='javascript:void(0)' class='dropdown-item'><i class='icon-file-eye'></i> Detil Perizinan</a> <a href='{{ url('pb/historyperizinan/')}}/"+ data +"' class='dropdown-item' target='_blank'><i class='icon-file-pdf'></i> Log Perizinan</a> </div> </div>"
									return button;
								},
							}
						],
						"order": [[ 1, 'asc' ]]
					});
					$('#btnReset').show();
					$('#btnSubmit').val("Cari");

				},
				error: function(data){
					// console.log(data);
					
				}
			});
		});

	});
	</script>
@endsection
