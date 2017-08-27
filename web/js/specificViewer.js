
$(document).on('ready', function () {
    var youTubeImage = '<div class="img">';
    $("a#YouTubeLink").prepend(youTubeImage);
});

$(document).on('ready pjax:success', function () {
    $(".tab_opener#YouTubeLink").click(function () {
        $('.tab-pane').removeClass('active in');
        var destination = $(this).data('destination');
        $(destination).addClass('active in');
        $('ul.nav-tabs li').removeClass('active');  
        $(this).parent().addClass('active');
        $("#YouTube").html("");
    });
});
