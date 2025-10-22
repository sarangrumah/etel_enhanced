
// Class definition
var FormPenomoran = function () {
	// Elements		
	var formDat;
	var submitButton;
	var cancelButton;
	var saveAllDataButton;
	var goToDashboardButton;
	var penomoranList =  [
	    {	        
	        text: 'Bogor',
	        children: [
	            { id: '1', text: '0251' },
	            { id: '2', text: '0252' }	            
	        ]
	    },
	    {	        
	        text: 'Rangkasbitung',
	        children: [
	            { id: '3', text: '0253' },
	            { id: '4', text: '0254' }
	        ]
	    }
	];
	
	//method
	var initForm = () => {
		goToDashboardButton.addEventListener('click', function (e) {
            e.preventDefault();
            window.location.href= window.location.origin + "/dashboard/jaringan-telekomunikasi";
        })
		
	}
	
	var handleSelectNomor = () => {		
		$('#nomor').select2({
		    placeholder: "Kode Area | Nomor...",
		    data: penomoranList
		});
	}
	
	var handleSubmit = () => {		
		submitButton.addEventListener('click', function (e) {
            e.preventDefault();
            //Pop Up Summary
            if ($('#checkbox-agreement').is(':checked')) {
            	//hit API
            	$("#kt_modal_summary").modal('show');
            } else{
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
	    		  window.location.href= window.location.origin + "/dashboard/jaringan-telekomunikasi";
    		  }
    		});
        })
	}		
	
	return {
		// Public Functions
		init: function () {			
			submitButton = document.querySelector('#submit-penomoran');			
			cancelButton = document.querySelector('#cancel-submision');			
			goToDashboardButton = document.querySelector('#go-to-dashboard');
			initForm();
			handleSelectNomor();
			handleSubmit();
			handleCancel();			
		}
	};
}();

//On document ready
KTUtil.onDOMContentLoaded(function() {
	FormPenomoran.init();
});