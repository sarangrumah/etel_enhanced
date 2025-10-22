
// Class definition
var FormKpltPjbSatelit = function () {
	var periode = [];		
	var kapasitas_transponder = [];
	var kapasitas_sistem = [];
		
	
	
	//method
	var initForm = () => {
		
		$("#simpan-kplt-pjb-satelit").click(function() {			
			periode = [];		
			kapasitas_transponder = [];
			kapasitas_sistem = [];

			$("#body-kplt-pjb-satelit input[name=periode\\[\\]]").each(function() {
			   periode.push($(this).val());
			});
			$("#body-kplt-pjb-satelit input[name=kapasitas_transponder\\[\\]]").each(function() {
				kapasitas_transponder.push($(this).val());
			});
			$("#body-kplt-pjb-satelit input[name=kapasitas_sistem\\[\\]]").each(function() {
				kapasitas_sistem.push($(this).val());
			 });
			 $.ajax({
				type: "post",
				url: "prosesKpltPjbSatelit",
				headers: {"X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")},
				data: {
					perizinan_id: $("#kplt-pjb-satelit input[name=perizinan_id]").val(),
					periode: periode,
					kapasitas_transponder: kapasitas_transponder,
					kapasitas_sistem: kapasitas_sistem,
				},
				success: function(data){
					swal("Berhasil!", "Disimpan", "success");
				},
				error: function(data){
					 alert("Error")
				}
			});    
		});
		
		$("#tambah-kplt-pjb-satelit").click(function() {			
			$("#body-kplt-pjb-satelit").append(kpltRow);
		});
		
		$("#body-kplt-pjb-satelit").on('click','.remove',function(){
	        $(this).parent().parent().remove();
	    });
		
	}
	
	var kpltRow = `
		<tr>
            <td><input type="text" name="periode[]" class="form-control" placeholder=""/></td>				            				            
            <td><input type="text" name="kapasitas_transponder[]" class="form-control" placeholder=""/></td>
            <td><input type="text" name="kapasitas_sistem[]" class="form-control" placeholder=""/></td>
            <td class="items-align-center text-end">
            <button class="btn btn-icon btn-danger remove w-30px h-30px">
				<!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
				<span class="svg-icon svg-icon-light svg-icon-3">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
						<path d="M21 13H3C2.4 13 2 12.6 2 12C2 11.4 2.4 11 3 11H21C21.6 11 22 11.4 22 12C22 12.6 21.6 13 21 13Z" fill="black"/>
					</svg>
				</span>
			</button>
			</td>
        </tr>	
				  `
	
	return {
		// Public Functions
		init: function () {
			initForm();	
		}
	};
}();

//On document ready
KTUtil.onDOMContentLoaded(function() {
	FormKpltPjbSatelit.init();
});