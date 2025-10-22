var firstPath = window.location.pathname.split("/")[1];

function swalAlertRegistration(text, type, url) {
    Swal.fire({
        text: text,
        icon: type,
        buttonsStyling: false,
        confirmButtonText: "Ok",
        customClass: {
            confirmButton: "btn btn-primary"
        }
    }).then(function () {
        window.location.href = window.location.origin + url;
    });
}

var showLoading = function() {
    Swal.fire({
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
    });
    Swal.showLoading();
};

function getKotaKab(sel) {
    if(sel.value) {
        $.ajax({
            url: "/get/kotaKab",
            type: "post",
            headers: {"X-CSRF-TOKEN": $("meta[name='_csrf']").attr("content")},
            data: {id: sel.value},
            success: function (data) {
                $('#kotaKab').empty();
                $('#kotaKab').append($("<option></option>").attr("value", "").text("Pilih Kota / Kabupaten"));
                $.each(data, function (key, value) {
                    $('#kotaKab')
                        .append($("<option></option>")
                            .attr("value", value['id'])
                            .text(value['description']));
                });
            },
        });
    }else{
        $('#kotaKab').empty();
        $('#kotaKab').append($("<option></option>").text("Pilih Provinsi"));
        $('#kecamatan').empty();
        $('#kecamatan').append($("<option></option>").text("Pilih Kota / Kabupaten"));
        $('#kelurahan').empty();
        $('#kelurahan').append($("<option></option>").text("Pilih Kecamatan"));
        $('#kodePos').empty();
        $('#kodePos').append($("<option></option>").text("Pilih Kelurahan"));
    }
}

function getKecamatan(sel) {
    if(sel.value) {
        $.ajax({
            url: "/get/kecamatan",
            type: "post",
            headers: {"X-CSRF-TOKEN": $("meta[name='_csrf']").attr("content")},
            data: {id: sel.value},
            success: function (data) {
                $('#kecamatan').empty();
                $('#kecamatan').append($("<option></option>").attr("value", "").text("Pilih Kecamatan"));
                $.each(data, function (key, value) {
                    $('#kecamatan')
                        .append($("<option></option>")
                            .attr("value", value['id'])
                            .text(value['description']));
                });
            },
        });
    }else{
        $('#kecamatan').empty();
        $('#kecamatan').append($("<option></option>").text("Pilih Kota / Kabupaten"));
        $('#kelurahan').empty();
        $('#kelurahan').append($("<option></option>").text("Pilih Kecamatan"));
        $('#kodePos').empty();
        $('#kodePos').append($("<option></option>").text("Pilih Kelurahan"));
    }
}

function getKelurahan(sel) {
    if(sel.value) {
        $.ajax({
            url: "/get/kelurahan",
            type: "post",
            headers: {"X-CSRF-TOKEN": $("meta[name='_csrf']").attr("content")},
            data: {id: sel.value},
            success: function (data) {
                $('#kelDesa').empty();
                $('#kelDesa').append($("<option></option>").attr("value", "").text("Pilih Kelurahan"));
                $.each(data, function (key, value) {
                    $('#kelDesa')
                        .append($("<option></option>")
                            .attr("value", value['id'])
                            .text(value['description']));
                });
            },
        });
    }else{
        $('#kelDesa').empty();
        $('#kelDesa').append($("<option></option>").text("Pilih Kecamatan"));
        $('#kodePos').empty();
        $('#kodePos').append($("<option></option>").text("Pilih Kelurahan"));
    }
}

function getKodePos(sel) {
    if(sel.value) {
        $.ajax({
            url: "/get/kodePos",
            type: "post",
            headers: {"X-CSRF-TOKEN": $("meta[name='_csrf']").attr("content")},
            data: {id: sel.value},
            success: function (data) {
                $('#kodePos').empty();
                $('#kodePos').append($("<option></option>").attr("value", "").text("Pilih Kode Pos"));
                $.each(data, function (key, value) {
                    $('#kodePos')
                        .append($("<option></option>")
                            .attr("value", value['id'])
                            .text(value['description']));
                });
            },
        });
    }else{
        $('#kodePos').empty();
        $('#kodePos').append($("<option></option>").text("Pilih Kelurahan"));
    }
}

function uploadFile(elm, type){
    $("<span class='uploadSpinner position-absolute top-50 end-0 translate-middle-y lh-0 me-1' data-kt-search-element='spinner'><span class='spinner-border h-15px w-15px align-middle text-gray-400'></span></span>").insertAfter("#"+elm.id);
    $('#'+elm.id).nextAll().remove();
    var formData = new FormData();
    formData.append('file', $(elm).prop('files')[0]);
    formData.append('type', type);
    formData.append('personId', $("#personId").val());
    // $.ajax({
    //     url: "/proses/uploadFile",
    //     type: "post",
    //     headers: {"X-CSRF-TOKEN": $("meta[name='_csrf']").attr("content")},
    //     enctype: 'multipart/form-data',
    //     data: formData,
    //     processData: false,
    //     contentType: false,
    //     cache: false,
    //     success: function (data) {
    //         if (data !== null) {
    //             $('#'+elm.id).nextAll().remove();
    //             // $("<span class='uploadSpinner position-absolute top-50 end-0 translate-middle-y lh-0 me-1' data-kt-search-element='spinner'><span style='margin-left: -20px;'><i class='fa fa-check text-success'></i></span></span>").insertAfter("#"+elm.id);
    //             $("<div class='dropzone-items wm-200px mt-2'><span class='badge badge-light-primary'>"+data+"</span></div>").insertAfter("#"+elm.id);
    //         }else{
    //             $('#'+elm.id).nextAll().remove();
    //             swalAlertRegistration("File gagal di upload", "error", "/"+firstPath)
    //         }
    //     },
    //     error: function () {
    //         $('#'+elm.id).nextAll().remove();
    //         swalAlertRegistration("File gagal di upload", "error", "/"+firstPath)
    //     }
    // });

}