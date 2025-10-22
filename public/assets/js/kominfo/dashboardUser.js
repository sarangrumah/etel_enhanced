"use strict";

var KTDatatableDashboardUser = function() {

    var dashboardUser = function () {
        var firstPath = window.location.pathname.split("/")[1];
        var path = window.location.pathname.split("/")[2];

        if (firstPath == "home") {
            $('#homeMenu').addClass("active");
        }
    };

    return {
        init: function() {
            dashboardUser();
        }
    };
}();

jQuery(document).ready(function() {
    KTDatatableDashboardUser.init();
});