/**
 * Created by Nicolas on 29/04/2017.
 */

$(document).ready(function() {

    // Material Select Initialization
    $('.mdb-select').material_select();

    // Item actif du menu
    var topMenuInfo = $("#topMenuInfo").text();
    $("#" + topMenuInfo).addClass("active");

    $("#writeMessage").click(function (e){
        $("#writeMessageBlock").css('display', "block");
        $(this).css('display', "none");
    });
});