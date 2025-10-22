
// Class definition
var FormUlo = function () {
	
	var submitButton
	
	//method
	var initForm = () => {		
		
	}				
	
    var handleCancelUlo = function () {
    	$("#cancel-ulo").on('click', function(e){
    		e.preventDefault();
    		$("#kt_modal_ulo").modal('hide')
    		KTTablePerizinanDalamProses.reload();
    	});
    }
    
    var handleSubmitUlo = function () {
		$('#submit-ulo').on('submit', function(e){
    		e.preventDefault();
			id_perijinan = $("#perizinan-id-ulo").val();
			date_ulo = $("#datePeriode").val();
			agree = $("#checkbox-agreement-pakta-integritas").prop("checked");
			pakta_integritas = $("#pakta-integritas").val();

			if (date_ulo == "" && agree == false && pakta_integritas == "") {
				swal("Peringatan!", "Mohon isi semua data!", "warning");
				return false;
			} else if(date_ulo == "" ){
				swal("Peringatan!", "Mohon isi Tanggal ULO!", "warning");
				return false;
			} else if(pakta_integritas == "" ){
				swal("Peringatan!", "Mohon lampirkan file PAKTA INTEGRITAS!", "warning");
				return false;
			}
			else if(agree == false ){
				swal("Peringatan!", "Mohon centang setuju jika ingin melanjutkan!", "warning");
				return false;
			}

            blockUI();

			$.ajax({
				url: "/perizinan/ulo",
				method:"POST",
				data:new FormData(this),
				dataType:'JSON',
				contentType: false,
				cache: false,
				processData: false,
				headers: {"X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")},         
				success: function (data) {  
					$.unblockUI();

    				$("#kt_modal_ulo").modal('hide')
					swal("Sukses Pengajuan ULO.", "success");

					$("#datePeriode").val('')
					$("#pakta-integritas").val('')

    				KTTablePerizinanDalamProses.reload();    		
				},
				error: function () {
					swal("Maaf, sepertinya terdapat kesalahan sistem. Silahkan coba kembali.", "error");
					$.unblockUI();

				}
			});	
    	});
    }
    
	return {
		// Public Functions
		init: function () {			
			submitButton = document.querySelector('#submit-ulo');			
			cancelButton = document.querySelector('#cancel-ulo');
			initForm();
			handleCancelUlo();
			handleSubmitUlo();			
		}
	};
}();

//On document ready
KTUtil.onDOMContentLoaded(function() {
	FormUlo.init();
});