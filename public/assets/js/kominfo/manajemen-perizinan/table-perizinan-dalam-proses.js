"use strict";

// Class definition
var KTTablePerizinanDalamProses = function () {
    // Shared variables
    var table;
    var dt;
    var currentId;

    // Private functions
    var initDatatable = function () {
        dt = $("#kt_datatable_permohonan_perizinan").DataTable({
        	serverFiltering: true,
            processing: true,
            serverSide: true,
            stateSave: true,
            bDestroy: true,
            ajax: {
                type: 'POST',
                url: "/perizinan/dalam-proses",
                dataType: "json",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                contentType: "application/x-www-form-urlencoded"
            },
            columns: [
            	// { data: 'id'},
                // { data: 'nomor_izin'},
                // { data: 'jenis_izin' },
                // { data: 'tanggal_kib', ordering: true},
                // { data: 'kbli' },
                // { data: 'jenis_penyelenggaraan' },
                // { data: 'sla',
                //     "render": function (data, type, row) {
                //         if(row.sla==""){
                //             return "-";
                //         }else{
                //             return row.sla+" Hari Kerja";
                //         }
                //     }
                // },
                // { data: 'status', ordering:false },
                // { data: null },

                { data: 'id'},
                { data: 'nomor_izin',
                    "render": function(data, type, row){
                        return "<b>"+row.nomor_izin+"</b><br>"+row.jenis_izin+"<br>"+row.jenis_penyelenggaraan;
                    }
                },
                { data: 'tanggal_kib', ordering: true},
                { data: 'sla',
                    "render": function (data, type, row) {
                        if(row.sla==""){
                            return "-";
                        }else{
                            return row.sla+" Hari Kerja";
                        }
                    }
                },
                { data: 'status', 
                    "render": function (data, type, row) {
                        if(row.status=="KBLI_VERIFIED"){
                            return "PEMILIHAN KBLI";
                        }else if(row.status=="PERSYARATAN"){
                            return "PEMENHUHAN PERSYARATAN";
                        }else if(row.status=="PERSYARATAN_VERIFIED"){
                            return "PEMENUHAN PERSYARATAN DISETUJUI ";
                        }else if(row.status=="PENOMORAN"){
                            return "PENGAJUAN PENOMORAN";
                        }else if(row.status=="PENOMORAN_VERIFIED"){
                            return "PENGAJUAN PENOMORAN DISETUJUI";
                        }else if(row.status=="ULO"){
                            return "PENGAJUAN ULO";
                        }else if(row.status=="ULO_VERIFIED"){
                            return "PENGAJUAN ULO DISETUJUI";
                        }else{
                            return row.status;
                        }
                    }
                },
                { data: null },
            ],
            bSort: false,
            columnDefs: [
            	{ orderable: false, targets: '_all' },
            	{targets: [0], visible: false},
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    className: 'text-end',
                    render: function (data, type, row) {
                        if(data.status=="KBLI_VERIFIED" || data.status=="PERSYARATAN_VERIFIED" || data.status=="PENOMORAN_VERIFIED" ){
                            if(data.penomoran==1 || data.penomoran=="Ya" || data.penomoran=="ya"){
                                return `
                                    <div class="btn-group mr-2 group-action" role="group">
                                    <button class="btn btn-icon btn-danger w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                        <span class="svg-icon svg-icon-light svg-icon-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M21 13H3C2.4 13 2 12.6 2 12C2 11.4 2.4 11 3 11H21C21.6 11 22 11.4 22 12C22 12.6 21.6 13 21 13Z" fill="black"/>
                                            </svg>
                                        </span>
                                    </button>
                                    <button class="btn btn-icon btn-warning w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                        <span class="svg-icon svg-icon-light svg-icon-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="black"/>
                                                <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="black"/>
                                                <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="black"/>
                                            </svg>
                                        </span>
                                    </button>
                                    <button class="btn btn-icon btn-secondary w-30px h-30px me-3" data-kt-docs-table-filter="next-step" 
                                        data-bs-toggle="modal" data-bs-target="#kt_modal_next_step" data-id="`+data.status+`">
                                        <span class="svg-icon svg-icon-light svg-icon-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M21 13H3C2.4 13 2 12.6 2 12C2 11.4 2.4 11 3 11H21C21.6 11 22 11.4 22 12C22 12.6 21.6 13 21 13Z" fill="black"/>
                                                <path d="M12 22C11.4 22 11 21.6 11 21V3C11 2.4 11.4 2 12 2C12.6 2 13 2.4 13 3V21C13 21.6 12.6 22 12 22Z" fill="black"/>
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                                `;
                            }else if(data.status=="ULO_VERIFIED"){
                                return '';
                            }else{
                                return `
                                    <div class="btn-group mr-2 group-action" role="group">
                                    <button class="btn btn-icon btn-danger w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                        <span class="svg-icon svg-icon-light svg-icon-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M21 13H3C2.4 13 2 12.6 2 12C2 11.4 2.4 11 3 11H21C21.6 11 22 11.4 22 12C22 12.6 21.6 13 21 13Z" fill="black"/>
                                            </svg>
                                        </span>
                                    </button>
                                    <button class="btn btn-icon btn-warning w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                        <span class="svg-icon svg-icon-light svg-icon-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="black"/>
                                                <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="black"/>
                                                <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="black"/>
                                            </svg>
                                        </span>
                                    </button>
                                    <button class="btn btn-icon btn-secondary w-30px h-30px me-3" data-kt-docs-table-filter="next-step" 
                                        data-bs-toggle="modal" data-bs-target="#kt_modal_next_step2"  data-id="`+data.status+`">
                                        <span class="svg-icon svg-icon-light svg-icon-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M21 13H3C2.4 13 2 12.6 2 12C2 11.4 2.4 11 3 11H21C21.6 11 22 11.4 22 12C22 12.6 21.6 13 21 13Z" fill="black"/>
                                                <path d="M12 22C11.4 22 11 21.6 11 21V3C11 2.4 11.4 2 12 2C12.6 2 13 2.4 13 3V21C13 21.6 12.6 22 12 22Z" fill="black"/>
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                                `;
                            }
                            
                        }else{
                            return '';
                        }
                        
                    },
                },
            ]
        });

        table = dt.$;

        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        dt.on('draw', function () {
            initToggleToolbar();
            toggleToolbars();
            handleDeleteRows();
            KTMenu.createInstances();
        });
    }    

    // Delete customer
    var handleDeleteRows = () => {
        // Select all delete buttons
        const nextStepButtons = document.querySelectorAll('[data-kt-docs-table-filter="next-step"]');
        

        nextStepButtons.forEach(next => {
            // Delete button on click
        	next.addEventListener('click', function (e) {
                e.preventDefault();                
//                $("#perizinan-id").val(next.getAttribute("data-id"));

                var currentRow = $(this).closest("tr");

                var data = $('#kt_datatable_permohonan_perizinan').DataTable().row(currentRow).data();
                currentId = data.id;
                $.ajax({
                    url: "/perizinan/get-perizinan/" + data.id,
                    type: "get",
                    dataType: "json",
                    headers: {"X-CSRF-TOKEN": $("meta[name='_csrf']").attr("content")},                    
                    success: function (data) {
                        if(data.status == "KBLI_VERIFIED") {
                            if(data.penomoran==1 || data.penomoran=="Ya" || data.penomoran=="ya"){
                                enablePenomoran();

                                disablePersyaratan();
                                disablePersyaratan2();
                                disableUlo();
                                disableUlo2();
                            }else{
                                enablePersyaratan2();

                                disablePenomoran();
                                disablePersyaratan();
                                disableUlo();
                                disableUlo2();
                            }
                        } else if(data.status=="PERSYARATAN_VERIFIED") {
                        	if(data.penomoran==1 || data.penomoran=="Ya" || data.penomoran=="ya"){
                                enableUlo();
                                console.log(data.metode_ulo);
                                $("#metode").val(data.metode_ulo);
                                $("#metode_ulo").html(data.metode_ulo);
                                $("#perizinan-id-ulo").val(data.id_izin);
                                console.log($("#perizinan-id-ulo").val());
                                

                                disablePenomoran();
                                disablePersyaratan();
                                disablePersyaratan2();
                                disableUlo2();
                            }else{
                                enableUlo2();
                                $("#metode").val(data.metode_ulo);
                                $("#metode_ulo").html(data.metode_ulo);
                                $("#perizinan-id-ulo").val(data.id_izin);
                                console.log($("#perizinan-id-ulo").val());

                                disablePenomoran();
                                disablePersyaratan();
                                disablePersyaratan2();
                                disableUlo();
                            }
                        } else if(data.status=="PENOMORAN_VERIFIED"){
                            enablePersyaratan();

                            disablePenomoran();
                            disablePersyaratan2();
                            disableUlo();
                            disableUlo2();
                        } else {
                        	// enablePersyaratan();
                        	// disablePenomoran();
                        	// disableUlo();
                        }
                    },
                    error: function(error) {
                        // enablePersyaratan();
                        // enablePenomoran();
                        // enableUlo();
                    }
                });
            })
        });
    }
    
    var enablePenomoran = () => {
    	// $("#kt_modal_next_step #penomoran-label").removeClass("btn-icon-info").addClass("btn-icon-success");
    	// $("#kt_modal_next_step #penomoran-label").removeClass("btn-outline-info").addClass("btn-outline-success");
    	// $("#kt_modal_next_step #penomoran-label").removeClass("btn-active-light-info").addClass("btn-active-light-success");
    	// $("#kt_modal_next_step #penomoran-text").removeClass("text-info").addClass("text-success");
    	$("#kt_modal_next_step #next_form_penomoran").removeAttr("disabled");
        $("#kt_modal_next_step #next_form_penomoran").prop("checked", true);
    }
    
    var disablePenomoran = () => {
    	// $("#kt_modal_next_step #penomoran-label").removeClass("btn-icon-success").addClass("btn-icon-info");
    	// $("#kt_modal_next_step #penomoran-label").removeClass("btn-outline-success").addClass("btn-outline-info");
    	// $("#kt_modal_next_step #penomoran-label").removeClass("btn-active-light-success").addClass("btn-active-light-info");
    	// $("#kt_modal_next_step #penomoran-text").removeClass("text-success").addClass("text-info");
    	$("#kt_modal_next_step #next_form_penomoran").attr("disabled", "disabled");
        $("#kt_modal_next_step #next_form_penomoran").prop("checked", false);
    }
    
    var enableUlo = () => {
    	// $("#kt_modal_next_step #ulo-label").removeClass("btn-icon-info").addClass("btn-icon-success");
    	// $("#kt_modal_next_step #ulo-label").removeClass("btn-outline-info").addClass("btn-outline-success");
    	// $("#kt_modal_next_step #ulo-label").removeClass("btn-active-light-info").addClass("btn-active-light-success");
    	// $("#kt_modal_next_step #ulo-text").removeClass("text-info").addClass("text-success");
    	$("#kt_modal_next_step #next_form_ulo").removeAttr("disabled");
        $("#kt_modal_next_step #next_form_ulo").prop("checked", true);
    }

    var enableUlo2 = () => {
        // $("#kt_modal_next_step2 #ulo-label").removeClass("btn-icon-info").addClass("btn-icon-success");
    	// $("#kt_modal_next_step2 #ulo-label").removeClass("btn-outline-info").addClass("btn-outline-success");
    	// $("#kt_modal_next_step2 #ulo-label").removeClass("btn-active-light-info").addClass("btn-active-light-success");
    	// $("#kt_modal_next_step2 #ulo-text").removeClass("text-info").addClass("text-success");
    	$("#kt_modal_next_step2 #next_form_ulo").removeAttr("disabled");
        $("#kt_modal_next_step2 #next_form_ulo").prop("checked", true);
    }
    
    var disableUlo = () => {
    	// $("#kt_modal_next_step #ulo-label").removeClass("btn-icon-success").addClass("btn-icon-info");
    	// $("#kt_modal_next_step #ulo-label").removeClass("btn-outline-success").addClass("btn-outline-info");
    	// $("#kt_modal_next_step #ulo-label").removeClass("btn-active-light-success").addClass("btn-active-light-info");
    	// $("#kt_modal_next_step #ulo-text").removeClass("text-success").addClass("text-info");
        $("#metode").val("");
    	$("#kt_modal_next_step #next_form_ulo").attr("disabled", "disabled");
        $("#kt_modal_next_step #next_form_ulo").prop('checked', false);
    }

    var disableUlo2 = () => {
        // $("#kt_modal_next_step2 #ulo-label").removeClass("btn-icon-success").addClass("btn-icon-info");
    	// $("#kt_modal_next_step2 #ulo-label").removeClass("btn-outline-success").addClass("btn-outline-info");
    	// $("#kt_modal_next_step2 #ulo-label").removeClass("btn-active-light-success").addClass("btn-active-light-info");
    	// $("#kt_modal_next_step2 #ulo-text").removeClass("text-success").addClass("text-info");
        $("#metode").val("");
    	$("#kt_modal_next_step2 #next_form_ulo").attr("disabled", "disabled");
        $("#kt_modal_next_step2 #next_form_ulo").prop('checked', false);
    }
    
    var enablePersyaratan = () => {
    	// $("#kt_modal_next_step #persyaratan-label").removeClass("btn-icon-info").addClass("btn-icon-success");
    	// $("#kt_modal_next_step #persyaratan-label").removeClass("btn-outline-info").addClass("btn-outline-success");
    	// $("#kt_modal_next_step #persyaratan-label").removeClass("btn-active-light-info").addClass("btn-active-light-success");
    	// $("#kt_modal_next_step #persyaratan-text").removeClass("text-info").addClass("text-success");
    	$("#kt_modal_next_step #next_form_persyaratan").removeAttr("disabled");
        $("#kt_modal_next_step #next_form_persyaratan").prop("checked", true);
    }

    var enablePersyaratan2 = () => {
         // $("#kt_modal_next_step2 #persyaratan-label").removeClass("btn-icon-info").addClass("btn-icon-success");
    	// $("#kt_modal_next_step2 #persyaratan-label").removeClass("btn-outline-info").addClass("btn-outline-success");
    	// $("#kt_modal_next_step2 #persyaratan-label").removeClass("btn-active-light-info").addClass("btn-active-light-success");
    	// $("#kt_modal_next_step2 #persyaratan-text").removeClass("text-info").addClass("text-success");
    	$("#kt_modal_next_step2 #next_form_persyaratan").removeAttr("disabled");
        $("#kt_modal_next_step2 #next_form_persyaratan").prop("checked", true);
    }

    var disablePersyaratan = () => {
    	// $("#kt_modal_next_step #persyaratan-label").removeClass("btn-icon-success").addClass("btn-icon-info");
    	// $("#kt_modal_next_step #persyaratan-label").removeClass("btn-outline-success").addClass("btn-outline-info");
    	// $("#kt_modal_next_step #persyaratan-label").removeClass("btn-active-light-success").addClass("btn-active-light-info");
    	// $("#kt_modal_next_step #persyaratan-text").removeClass("text-success").addClass("text-info");
    	$("#kt_modal_next_step #next_form_persyaratan").attr("disabled", "disabled");
        $("#kt_modal_next_step #next_form_persyaratan").prop('checked', false);
    }

    var disablePersyaratan2 = () => {
    	// $("#kt_modal_next_step2 #persyaratan-label").removeClass("btn-icon-success").addClass("btn-icon-info");
    	// $("#kt_modal_next_step2 #persyaratan-label").removeClass("btn-outline-success").addClass("btn-outline-info");
    	// $("#kt_modal_next_step2 #persyaratan-label").removeClass("btn-active-light-success").addClass("btn-active-light-info");
    	// $("#kt_modal_next_step2 #persyaratan-text").removeClass("text-success").addClass("text-info");
    	$("#kt_modal_next_step2 #next_form_persyaratan").attr("disabled", "disabled");
        $("#kt_modal_next_step2 #next_form_persyaratan").prop('checked', false);
    }

    // Reset Filter
    var handleResetForm = () => {        
    }

    // Init toggle toolbar
    var initToggleToolbar = function () {        
    }

    // Toggle toolbars
    var toggleToolbars = function () {        
    }
    
    //Init Action
    var initNextStep = function () {
    	$("#submit-next-step").on('click', function(e){
    		e.preventDefault();
    		$("#kt_modal_next_step").modal('hide');
            
    		let nextFormSelected = $('#kt_modal_next_step input[name="next_form"]:checked').val();
    		let id = currentId;
    		if (nextFormSelected=='ulo') {
                $("#kt_modal_ulo").modal('show');
    			$("#perizinan-id-ulo").val(id);
                $("#kt_modal_ulo").on('shown.bs.modal', function() {
                    var id = $('#perizinan-id-ulo').val();
                    $.ajax({
                        // url: '{{ url('/dashboard/getulo/') }}/'+id,
                        url: '/dashboard/getulo/'+id,
                        type: 'get',
                        success: function(e) {
                            console.log(id);
                            var metode = e;
                            $("#metode").val(e)
                            console.log("abcd");
                            if (metode == 'Mandiri') {
                                $('.ulo-mandiri').show();
                                // $('.uji-petik').hide();
                                $("#surattugas").attr('required', true);
                                $("#pengujian").attr('required', true);
                            } else {
                                $('.ulo-mandiri').hide();
                                $("#surattugas").attr('required', false);
                                $("#pengujian").attr('required', false);
                            }
                        }
                    });
                });
    		} else{
                if(nextFormSelected=="penomoran"){
                    window.location.href= window.location.origin + "/" + "form-penomoran" + "/" + id;
                }else{
                    window.location.href= window.location.origin + "/" + nextFormSelected + "/" + id;
                }
    		}    		
    	});
    }    

    var initNextStep2 = function () {
    	$("#submit-next-step2").on('click', function(e){
    		e.preventDefault();
    		$("#kt_modal_next_step2").modal('hide');
            
    		let nextFormSelected = $('#kt_modal_next_step2 input[name="next_form"]:checked').val();
    		let id = currentId;
    		if (nextFormSelected=='ulo') {
    			$("#kt_modal_ulo").modal('show');
    			$("#perizinan-id-ulo").val(id);
                $("#kt_modal_ulo").on('shown.bs.modal', function() {
                    var id = $('#perizinan-id-ulo').val();
                    $.ajax({
                        // url: '{{ url('/dashboard/getulo/') }}/'+id,
                        url: '/dashboard/getulo/'+id,
                        type: 'get',
                        success: function(e) {
                            var metode = e;
                            $("#metode").val(e)
                            if (metode == 'Mandiri') {
                                console.log(id);
                                $('.ulo-mandiri').show();
                                $("#surattugas").attr('required', true);
                                $("#pengujian").attr('required', true);
                            } else {
                                $('.ulo-mandiri').hide();
                                $("#surattugas").attr('required', false);
                                $("#pengujian").attr('required', false);
                            }
                        }
                    });
                });
    		} else{
                if(nextFormSelected=="penomoran"){
                    window.location.href= window.location.origin + "/" + "form-penomoran" + "/" + id;
                }else{
                    window.location.href= window.location.origin + "/" + nextFormSelected + "/" + id;
                }
    		}    		
    	});
    }
       
    // Public methods
    return {
        init: function () {
            initDatatable();            
            initToggleToolbar();            
            handleDeleteRows();
            handleResetForm();
            initNextStep();
            initNextStep2();
        },
        reload: function () {
        	dt.draw();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
	KTTablePerizinanDalamProses.init();
});