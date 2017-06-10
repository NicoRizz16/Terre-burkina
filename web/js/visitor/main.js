/**
 * Created by Nicolas on 29/04/2017.
 */


// Material Select Initialization
$(document).ready(function() {

    $('.mdb-select').material_select();

    /*********************
     *     Newsletter    *
     *********************/
    // Modal newsletter cachée par défaut
    $('#newsletterModal').modal({ show: false});

    // TTT AJAX form newsletter
    $("body").on("submit", "#newsletterForm", function(e){
        e.preventDefault();
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize()
        })
            .done(function (data, textStatus, errorThrown) {
                if (data['title'] !== 'undefined' && data['body'] !== 'undefined') {
                    $('#newsletterModalTitle').html(data['title']);
                    $('#newsletterModalBody').html(data['body']);
                    $('#newsletterModal').modal('show');
                    $('#newsletter_email').val("");
                } else {
                    alert(errorThrown);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            });
    });

});