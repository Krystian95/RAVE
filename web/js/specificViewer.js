
$(document).on('ready pjax:success', function () {
    $(".tab_opener").click(function () {
        $('.tab-pane').removeClass('active in');
        var destination = $(this).data('destination');
        $(destination).addClass('active in');
        $('ul.nav-tabs li').removeClass('active');
        $(this).parent().addClass('active');
    });
});
