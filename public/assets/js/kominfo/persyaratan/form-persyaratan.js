
// Class definition
var FormPersyaratan = function () {
	// Elements		
	var formDat;
	var submitButton;
	var cancelButton;
	var saveAllDataButton;
	var goToDashboardButton;
	
	//method
	var initForm = () => {
		goToDashboardButton.addEventListener('click', function (e) {
            e.preventDefault();
            window.location.href= window.location.origin + "/dashboard";
        })
		
	}
	
	var handleSubmit = () => {
		submitButton.addEventListener('click', function (e) {
            e.preventDefault();
            //Pop Up Modal Confirm  
			if($("#syarat").val()==""){
				swal("Peringatan!", "Silahkan Lengkapi Data!", "warning");
			}else{
				$("#kt_modal_confirmation").modal('show');
			}
        })
	}
	
	var handleCancel = () => {		
		cancelButton.addEventListener('click', function (e) {
            e.preventDefault();            
            //Popup
            Swal.fire({
            	title: 'Apakah Anda yakin?',
    	        text: "Data yang Anda isi akan hilang!",
    	        icon: 'warning',
    	        buttonsStyling: false,    	        
    	        showCancelButton: true,    	            	           	        
    	        confirmButtonText: 'Ya, saya yakin!',
    	        cancelButtonText: 'Kembali',
    	        customClass: {
    	            confirmButton: "btn btn-purple",
    	            cancelButton: "btn btn-secondary"
    	        }
    	    }).then((result) => {
	    	  if (result.isConfirmed) {
	    		  window.location.href= window.location.origin + "/dashboard";
    		  }
    		});
        })
	}
		
	var handleSaveAllData = () => {
		saveAllDataButton.addEventListener('click', function (e) {
            e.preventDefault();
            if ($('#checkbox-agreement').is(':checked')) {
            	//API
            	$("#kt_modal_confirmation").modal('hide');

				$.ajax({
                    url: "/perizinan/get-perizinan/"+$("#perizinanId").val(),
					dataType: "json",
					// contentType: "application/x-www-form-urlencoded",
                    success: function (data) {
                        console.log(data);
						$("#jenisizintext").text(data.jenis_izin);
						$("#mediatransmisitext").text(data.media_transmisi);
						$("#nomortext").text(data.nomor_izin);
						$("#namatext").text(data.nama_perusahaan);
						$("#nib").text(data.nib);
						$("#kblitext").text(data.kbli);
						$("#tanggaltext").text(data.tanggal_kib);
						$("#slaSummary").text(data.sla);
						$("#kt_modal_summary").modal('show');
                    },
                    error: function(error) {
                        // enablePersyaratan();
                        // enablePenomoran();
                        // enableUlo();
                    }
                });
				
            } else {
            	Swal.fire({
					text: "Anda harus memilih setuju",
					icon: "error",
					buttonsStyling: false,
					confirmButtonText: "OK",
					customClass: {
						confirmButton: "btn btn-purple"
					}
				}).then(function () {					
				});
            }
        })
	}
	
	
	return {
		// Public Functions
		init: function () {			
			submitButton = document.querySelector('#submit-document');			
			cancelButton = document.querySelector('#cancel-submision');
			saveAllDataButton = document.querySelector('#save-all-data');
			goToDashboardButton = document.querySelector('#go-to-dashboard');
			initForm();
			handleSubmit();
			handleCancel();
			handleSaveAllData();
		}
	};
}();

//On document ready
KTUtil.onDOMContentLoaded(function() {
	FormPersyaratan.init();
});

var SessionTime = 180000;
var tickDuration = 1000;

var myInterval = setInterval(function() {
    SessionTime = SessionTime - tickDuration
    // $("#countdown").text(SessionTime/1000);
}, 1000);

// var myTimeOut = setTimeout(SessionExpireEvent, SessionTime);

// $("input").click(function() {
//     clearTimeout(myTimeOut);
//     SessionTime = 10000;
//     myTimeOut = setTimeout(SessionExpireEvent, SessionTime);
// });

function SessionExpireEvent() {
    clearInterval(myInterval);
	// window.location.href = '/logout';
	$.ajax({
		url: "/logout",
		method: "POST",
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	  }).done(function(response) {
		alert("Sesi anda telah habis!");
		window.location.href = '/home';
	  }).fail(function( jqXHR, textStatus ) {
		
	  });
}