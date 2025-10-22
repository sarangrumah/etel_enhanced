
// Class definition
var FormKpltJartupSkkl = function () {
	var periode = [];
	var jumlah_unit = [];
	var lokasi_landing_station = [];
	var rute = [];
	var jumlah_kabel = [];
	var kapasitas_bw = [];
		
	
	
	//method
	var initForm = () => {
		
		$("#simpan-kplt-jartup-skkl").click(function() {			
			periode = [];
			jumlah_unit = [];
			lokasi_landing_station = [];
			rute = [];
			jumlah_kabel = [];
			kapasitas_bw = [];	
			$("#body-kplt-jartup-skkl input[name=periode\\[\\]]").each(function() {
			   periode.push($(this).val());
			});
			$("#body-kplt-jartup-skkl input[name=jumlah_unit\\[\\]]").each(function() {
				jumlah_unit.push($(this).val());
			 });
			 $("#body-kplt-jartup-skkl input[name=lokasi_landing_station\\[\\]]").each(function() {
				lokasi_landing_station.push($(this).val());
			 });
			 $("#body-kplt-jartup-skkl input[name=rute\\[\\]]").each(function() {
				rute.push($(this).val());
			 });
			 $("#body-kplt-jartup-skkl input[name=jumlah_kabel\\[\\]]").each(function() {
				jumlah_kabel.push($(this).val());
			 });
			 $("#body-kplt-jartup-skkl input[name=kapasitas_bw\\[\\]]").each(function() {
				kapasitas_bw.push($(this).val());
			 });

			// console.log($("#body-kplt-jartup-terestrial input[name=kapasistas-bw\\[\\]]").map(function(){return $(this).val();}).get());
			 $.ajax({
				type: "post",
				url: "prosesKpltJartupFoSkkl",
				headers: {"X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")},
				data: {
					perizinan_id: $("#kplt-jartup-skkl input[name=perizinan_id]").val(),
					periode: periode,
					jumlah_unit: jumlah_unit,
					lokasi_landing_station: lokasi_landing_station,
					rute: rute,
					jumlah_kabel: jumlah_kabel,
					kapasitas_bw: kapasitas_bw,
				},
				success: function(data){
					//   alert("Data Save: " + data);
					console.log("Data Save: " , data);
					swal("Berhasil!", "Disimpan", "success");
				},
				error: function(data){
					 alert("Error")
				}
			});
		});
		
		$("#tambah-kplt-jartup-skkl").click(function() {			
			$("#body-kplt-jartup-skkl").append(kpltRow);
		});
		
		$("#body-kplt-jartup-skkl").on('click','.remove',function(){
	        $(this).parent().parent().remove();
	    });
		
	}
	
	var kpltRow = `
		<tr>
		    <td><input type="text" name="periode[]" class="form-control" placeholder="xxx"/></td>
		    <td><input type="text" name="jumlah_unit[]" class="form-control" placeholder="xxx"/></td>
		    <td><input type="text" name="lokasi_landing_station[]" class="form-control" placeholder="xxx"/></td>
		    <td><input type="text" name="rute[]" class="form-control" placeholder="xxx"/></td>
		    <td><input type="text" name="jumlah_kabel[]" class="form-control" placeholder="xxx"/></td>
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
		</tr>`
	
	return {
		// Public Functions
		init: function () {
			initForm();	
		}
	};
}();

//On document ready
KTUtil.onDOMContentLoaded(function() {
	FormKpltJartupSkkl.init();
});