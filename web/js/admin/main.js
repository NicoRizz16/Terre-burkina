$(document).ready(function() {

    // ==========================================================
    // =================== MARK MENU ============================
    // ==========================================================
    var menuTopInfo = $("#menuTopInfo").text();
    $("#"+menuTopInfo).addClass("activeItem");

    var menuLeftInfo = $("#menuLeftInfo").text();
    $("#"+menuLeftInfo).find(".mark").css("display", "inline");

    var menuChildInfo = $("#menuChildInfo").text();
    $("#"+menuChildInfo).addClass('active');

});/**
 * Created by Nicolas on 29/04/2017.
 */
