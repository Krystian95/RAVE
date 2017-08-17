
$(document).on('ready pjax:success', function () {

    $(".post").hover(function () {
        var id = $(this).data('id');
        $(".updated[data-id='" + id + "']").addClass('updated-hover');
    }, function () {
        var id = $(this).data('id');
        $(".updated[data-id='" + id + "']").removeClass('updated-hover');
    });

});