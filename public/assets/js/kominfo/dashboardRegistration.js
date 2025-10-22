"use strict";

var KTDatatableDashboardRegistration = function () {

    var passwordMeter;
    var firstPath = window.location.pathname.split("/")[1];

    var handleLogin = function () {
        $('#loginButton').click(function (e) {
            e.preventDefault();
            var form = $(this).closest('form');
            var url = form.attr('action');

            form.validate({
                rules: {
                    username: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true
                    }
                }
            });

            if (!form.valid()) {
                return;
            }

            $('.indicator-label').css('display', 'none');
            $('.indicator-progress').css('display', 'block');
            form.ajaxSubmit({
                url: url,
                success: function (response) {
                    $('.indicator-progress').css('display', 'none');
                    $('.indicator-label').css('display', 'block');
                    var title = response.match("<title>(.*?)</title>")[1];
                    if (title === "Aplikasi Perizinan Kominfo") {
                        swalAlertRegistration("Username dan Password salah", "error", "/" + firstPath);
                    } else {
                        window.location.href = window.location.origin + "/dashboard";
                    }
                },
                error: function () {
                    window.location.href = window.location.origin + "/dashboard";
                }
            });
        });
    };

    var handleDaftar = function () {
        $("#formDaftarJaringanJasa, #formDaftarTelsusBHukum").validate({
            rules: {
                nib: {
                    required: true,
                    minlength: 13,
                    maxlength: 13,
                    number: true
                },
                nmPenanggungJawab: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 8,
                    pwcheck: true,
                },
                confirmpassword: {
                    required: true,
                    equalTo: "#password"
                },
            },
            submitHandler: function () {
                showLoading();
                $.ajax({
                    url: "/proses/daftar",
                    type: "post",
                    headers: {
                        "X-CSRF-TOKEN": $("meta[name='_csrf']").attr("content")
                    },
                    data: {
                        registrationTypeId: $('#registrationTypeId').val(),
                        nib: $('#nib').val(),
                        nmPenanggungJawab: $('#nmPenanggungJawab').val(),
                        email: $('#email').val(),
                        password: $('#password').val(),
                    },
                    success: function (data) {
                        var url = 'loginTelsusBH';
                        if (firstPath === "daftarJaringanJasa") {
                            url = 'loginJaringanJasa';
                        }

                        if (data === "000") {
                            swalAlertRegistration("Anda berhasil mendaftar, silahkan verifikasi email.", "success", "/" + url);
                        } else if (data === "001") {
                            swalAlertRegistration("Username sudah terdaftar", "error", "/" + firstPath);
                        } else {
                            swalAlertRegistration("Data tidak ditemukan", "error", "/" + firstPath);
                        }
                    },
                    error: function () {
                        swalAlertRegistration("Maaf, sepertinya terdapat kesalahan sistem. Silahkan coba kembali.", "error", "/" + firstPath);
                    }
                });
            }
        });
    };

    var handleNewPassword = function () {
        $("#formNewPassword").validate({
            rules: {
                password: {
                    required: true,
                    minlength: 8,
                    pwcheck: true,
                },
                confirmpassword: {
                    required: true,
                    equalTo: "#password"
                },
            },
            submitHandler: function () {
                showLoading();
                $.ajax({
                    url: "/proses/resetPassword",
                    type: "post",
                    headers: {
                        "X-CSRF-TOKEN": $("meta[name='_csrf']").attr("content")
                    },
                    data: {
                        password: $('#password').val(),
                        appUserId: $('#appUserId').val()
                    },
                    success: function (data) {
                        if (data === "000") {
                            swalAlertRegistration("Password berhasil diubah, silahkan login.", "success", "/loginJaringanJasa");
                        } else if (data === "001") {
                            swalAlertRegistration("Data gagal diproses", "error", "/" + firstPath);
                        } else {
                            swalAlertRegistration("Data tidak ditemukan", "error", "/" + firstPath);
                        }
                    },
                    error: function () {
                        swalAlertRegistration("Maaf, sepertinya terdapat kesalahan sistem. Silahkan coba kembali.", "error", "/" + firstPath);
                    }
                });
            }
        });
    };

    var handleLupaPassword = function () {
        $("#formLupaPassword").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
            },
            submitHandler: function () {
                showLoading();
                $.ajax({
                    url: "/proses/lupaPassword",
                    type: "post",
                    headers: {
                        "X-CSRF-TOKEN": $("meta[name='_csrf']").attr("content")
                    },
                    data: {
                        email: $('#email').val()
                    },
                    success: function (data) {
                        if (data === "000") {
                            swalAlertRegistration("Silahkan cek email untuk perbaharui kata sandi.", "success", "/" + firstPath);
                        } else if (data === "001") {
                            swalAlertRegistration("Data gagal diproses", "error", "/" + firstPath);
                        } else {
                            swalAlertRegistration("Data tidak ditemukan", "error", "/" + firstPath);
                        }
                    },
                    error: function () {
                        swalAlertRegistration("Maaf, sepertinya terdapat kesalahan sistem. Silahkan coba kembali.", "error", "/" + firstPath);
                    }
                });
            }
        });
    };

    var handleDaftarIdentitas = function () {
        $(".kriteriaRadio").click(function () {
            $(".kriteriaRadio").prop("checked", false);
            $(this).prop("checked", true);
        });

        $("#formDaftarIdentitas").validate({
            rules: {
                kriteriaRadio: {
                    required: true
                },
                account_plan: {
                    required: true
                },
                namaPengguna: {
                    required: true
                },
                emailPengguna: {
                    required: true
                },
                noKTP: {
                    required: true,
                    minlength: 16,
                    maxlength: 16,
                    number: true
                },
                noTelp: {
                    required: true,
                    number: true
                },
                namaJalan: {
                    required: true
                },
                kelDesa: {
                    required: true
                },
                kecamatan: {
                    required: true
                },
                kotaKab: {
                    required: true
                },
                provinsi: {
                    required: true
                },
                kodePos: {
                    required: true
                },
            },
            submitHandler: function (form) {
                showLoading();
                var kriteriaVal = $('input[name="kriteriaRadio"]:checked').val();
                $.ajax({
                    url: "/proses/registrationPersonResponsible",
                    type: "post",
                    headers: {
                        "X-CSRF-TOKEN": $("meta[name='_csrf']").attr("content")
                    },
                    data: {
                        putData: $('#putData').val(),
                        kriteriaVal: kriteriaVal,
                        namaPengguna: $('#namaPengguna').val(),
                        emailPengguna: $('#emailPengguna').val(),
                        noKTP: $('#noKTP').val(),
                        noTelp: $('#noTelp').val(),
                        namaJalan: $('#namaJalan').val(),
                        kelDesa: $('#kelDesa').val(),
                        kecamatan: $('#kecamatan').val(),
                        kotaKab: $('#kotaKab').val(),
                        provinsi: $('#provinsi').val(),
                        kodePos: $('#kodePos').val(),
                    },
                    success: function (data) {
                        if (data === "000") {
                            swalAlertRegistration("Data Identitas berhasil disimpan. Selanjutnya silahkan isi Data Perusahaan.", "success", "/stepPerusahaan");
                        } else if (data === "001") {
                            swalAlertRegistration("Data gagal diproses", "error", "/" + firstPath);
                        } else {
                            swalAlertRegistration("Data tidak ditemukan", "error", "/" + firstPath);
                        }
                    },
                    error: function () {
                        swalAlertRegistration("Maaf, sepertinya terdapat kesalahan sistem. Silahkan coba kembali.", "error", "/" + firstPath);
                    }
                });
            }

        });
    };

    var handleDataPerusahaan = function () {
        $("#formDaftarDataPerusahaan").validate({
            rules: {
                nib: {
                    required: true,
                    number: true,
                    minlength: 13,
                    maxlength: 13,
                },
                dokumenNIB: {
                    required: $("#nibDoc").val() == '',
                    accept: "application/pdf"
                },
                namaPerusahaan: {
                    required: true
                },
                jenisPerusahaan: {
                    required: true,
                    number: true,
                },
                jenisPenanamanModal: {
                    required: true,
                    number: true,
                },
                namaJalan: {
                    required: true
                },
                kelDesa: {
                    required: true
                },
                kecamatan: {
                    required: true
                },
                kotaKab: {
                    required: true
                },
                provinsi: {
                    required: true
                },
                kodePos: {
                    required: true
                },
                noTelp: {
                    required: true,
                    minlength: 10,
                    maxlength: 14,
                    number: true
                },
                npwp: {
                    required: true,
                    minlength: 15,
                    maxlength: 15,
                    number: true
                },
                skDomisili: {
                    required: $("#domicileCertificateDoc").val() == ''
                },
                skKuasa: {
                    required: $("#companyAttornyDoc").val() == ''
                },
                dasarHukum: {
                    required: $("#companyLegalBasisDoc").val() == ''
                },
                toc: {
                    required: true
                },

            },
            submitHandler: function () {
                showLoading();
                var dtPerusahaan = {};
                dtPerusahaan["personId"] = $('#personId').val();
                dtPerusahaan["nib"] = $('#nib').val();
                dtPerusahaan["nibDoc"] = $('#dokumenNIB').val().substr($('#dokumenNIB').val().lastIndexOf('\\') + 1);
                dtPerusahaan["companyName"] = $('#namaPerusahaan').val();
                dtPerusahaan["companyTypeId"] = $('#jenisPerusahaan').val();
                dtPerusahaan["investmentTypeId"] = $('#jenisPenanamanModal').val();
                dtPerusahaan["streetName"] = $('#namaJalan').val();
                dtPerusahaan["kelDesa"] = $('#kelDesa').val();
                dtPerusahaan["kecamatan"] = $('#kecamatan').val();
                dtPerusahaan["kotaKab"] = $('#kotaKab').val();
                dtPerusahaan["provinsi"] = $('#provinsi').val();
                dtPerusahaan["villageId"] = $('#kodePos').val();
                dtPerusahaan["companyPhone"] = $('#noTelp').val();
                dtPerusahaan["companyNpwp"] = $('#npwp').val();
                dtPerusahaan["domicileCertificateDoc"] = $('#skDomisili').val().substr($('#skDomisili').val().lastIndexOf('\\') + 1);
                dtPerusahaan["companyAttornyDoc"] = $('#skKuasa').val().substr($('#skKuasa').val().lastIndexOf('\\') + 1);
                dtPerusahaan["companyLegalDoc"] = $('#dasarHukum').val().substr($('#dasarHukum').val().lastIndexOf('\\') + 1);
                $.ajax({
                    url: "/proses/registrationPersonCompany",
                    type: "post",
                    contentType: "application/json",
                    headers: {
                        "X-CSRF-TOKEN": $("meta[name='_csrf']").attr("content")
                    },
                    data: JSON.stringify(dtPerusahaan),
                    dataType: 'text',
                    success: function (data) {
                        if (data === "000") {
                            swalAlertRegistration("Data Perusahaan berhasil disimpan. Selanjutnya silahkan isi Data Direktur.", "success", "/stepDataPemohon");
                        } else if (data === "001") {
                            swalAlertRegistration("Data gagal diproses", "error", "/" + firstPath);
                        } else {
                            swalAlertRegistration("Data tidak ditemukan", "error", "/" + firstPath);
                        }
                    },
                    error: function () {
                        swalAlertRegistration("Maaf, sepertinya terdapat kesalahan sistem. Silahkan coba kembali.", "error", "/" + firstPath);
                    }
                });
            }
        });
    };

    var handleDataPemohon = function () {
        $("#formDaftarDataPemohon").validate({
            rules: {
                namaPemohon: {
                    required: true,
                },
                emailPemohon: {
                    required: true
                },
                noHpPemohon: {
                    required: true
                },
                noKTPPemohon: {
                    required: true
                },
                fileKTPPemohon: {
                    required: $("#identityUpload").val() == ''
                },
                jabatan: {
                    required: true
                },
                fileKartuPegawai: {
                    required: $("#applicantEmployeeLetter").val() == ''
                },
            },
            submitHandler: function () {
                showLoading();
                var dtPemohon = {};
                dtPemohon["applicantName"] = $('#namaPemohon').val();
                dtPemohon["applicantEmail"] = $('#emailPemohon').val();
                dtPemohon["applicantPhone"] = $('#noHpPemohon').val();
                dtPemohon["applicantIdentity"] = $('#noKTPPemohon').val();
                dtPemohon["applicantRole"] = $('#jabatan').val();
                dtPemohon["identityUpload"] = $('#fileKTPPemohon').val().substr($('#fileKTPPemohon').val().lastIndexOf('\\') + 1);
                dtPemohon["applicantEmployeeLetter"] = $('#fileKartuPegawai').val().substr($('#fileKartuPegawai').val().lastIndexOf('\\') + 1);
                $.ajax({
                    url: "/proses/registrationPersonApplicant",
                    type: "post",
                    contentType: "application/json",
                    headers: {
                        "X-CSRF-TOKEN": $("meta[name='_csrf']").attr("content")
                    },
                    data: JSON.stringify(dtPemohon),
                    dataType: 'text',
                    success: function (data) {
                        if (data === "000") {
                            swalAlertRegistration("Data pemohon berhasil disimpan.", "success", "/stepKonfirmasiData");
                        } else if (data === "001") {
                            swalAlertRegistration("Data gagal diproses", "error", "/" + firstPath);
                        } else {
                            swalAlertRegistration("Data tidak ditemukan", "error", "/" + firstPath);
                        }
                    },
                    error: function () {
                        swalAlertRegistration("Maaf, sepertinya terdapat kesalahan sistem. Silahkan coba kembali.", "error", "/" + firstPath);
                    }
                });
            }
        });
    };

    var handleDataKonfirmasi = function () {
        $("#formKonfirmasiData").validate({
            rules: {
                toc: {
                    required: true,
                },
            },
            submitHandler: function () {
                showLoading();
                $.ajax({
                    url: "/proses/konfirmasiData",
                    type: "post",
                    contentType: "application/json",
                    headers: {
                        "X-CSRF-TOKEN": $("meta[name='_csrf']").attr("content")
                    },
                    dataType: 'text',
                    success: function (data) {
                        if (data === "000") {
                            swalAlertRegistration("Pengajuan registrasi berhasil. Mohon menunggu proses verifikasi.", "success", "/dashboard");
                        } else if (data === "001") {
                            swalAlertRegistration("Data gagal diproses", "error", "/" + firstPath);
                        } else {
                            swalAlertRegistration("Data tidak ditemukan", "error", "/" + firstPath);
                        }
                    },
                    error: function () {
                        swalAlertRegistration("Maaf, sepertinya terdapat kesalahan sistem. Silahkan coba kembali.", "error", "/" + firstPath);
                    }
                });
            }
        });
    };

    return {
        init: function () {
            passwordMeter = KTPasswordMeter.getInstance(document.querySelector('[data-kt-password-meter="true"]'));

            handleLogin();
            handleDaftar();
            handleLupaPassword();
            handleDaftarIdentitas();
            handleDataPerusahaan();
            handleDataPemohon();
            handleDataKonfirmasi();
            handleNewPassword();
        }
    };
}();

jQuery(document).ready(function () {
    KTDatatableDashboardRegistration.init();
});