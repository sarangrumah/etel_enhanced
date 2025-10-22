
// Class definition
var FormKpltJartupMicrowave = function () {
	var periode = [];
	var jumlah_hop = [];	
	var kapasitas_bw = [];
		
	
	
	//method
	var initForm = () => {
		
		$("#simpan-kplt-jartup-microwave").click(function() {
			periode = [];
			jumlah_hop = [];
			kapasitas_bw = [];	
			$("#body-kplt-jartup-microwave input[name=periode\\[\\]]").each(function() {
			   periode.push($(this).val());
			});
			$("#body-kplt-jartup-microwave input[name=jumlah_hop\\[\\]]").each(function() {
				jumlah_hop.push($(this).val());
			 });
			 $("#body-kplt-jartup-microwave input[name=kapasitas_bw\\[\\]]").each(function() {
				kapasitas_bw.push($(this).val());
			 });
			 $.ajax({
				type: "post",
				url: "prosesKpltJartupMicrowave",
				headers: {"X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")},
				data: {
					perizinan_id: $("#kplt-jartup-microwave input[name=perizinan_id]").val(),
					periode: periode,
					jumlah_hop: jumlah_hop,
					kapasitas_bw: kapasitas_bw,
				},
				success: function(data){
					//   alert("Data Save: " + data);
					swal("Berhasil!", "Disimpan", "success");
				},
				error: function(data){
					 alert("Error")
				}
			});
		});
		
		$("#tambah-kplt-jartup-microwave").click(function() {			
			$("#body-kplt-jartup-microwave").append(kpltRow);
		});
		
		$("#body-kplt-jartup-microwave").on('click','.remove',function(){
	        $(this).parent().parent().remove();
	    });
		
	}
	
	var kpltRow = `
		<tr>
	        <td><input type="text" name="periode[]" class="form-control" placeholder="xxx"/></td>
	        <td><input type="text" name="jumlah_hop[]" class="form-control" placeholder="xxx"/></td>				            
	        <td><input type="text" name="kapasitas_bw[]" class="form-control" placeholder="xxx"/></td>
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
	FormKpltJartupMicrowave.init();
});