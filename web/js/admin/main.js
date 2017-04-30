$(document).ready(function() {

    // ==========================================================
    // =================== MARK MENU ============================
    // ==========================================================
    var menuTopInfo = $("#menuTopInfo").text();
    $("#"+menuTopInfo).addClass("active");

    var menuLeftInfo = $("#menuLeftInfo").text();
    $("#"+menuLeftInfo).find(".mark").css("display", "inline");

});/**
 * Created by Nicolas on 29/04/2017.
 */
