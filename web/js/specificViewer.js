
/*
 * Specific js called from the Specific Visualizer.
 */
$(document).on('ready pjax:success', function () {

    /*
     * Performs the appearing effect of YouTube tab.
     */
    $(".tab_opener#YouTubeLink").click(function () {
        $('.tab-pane').removeClass('active in');
        var destination = $(this).data('destination');
        $(destination).addClass('active in');
        $('ul.nav-tabs li').removeClass('active');
        $(this).parent().addClass('active');
        $("#YouTube").html("");
    });

    /*
     * Performs the scroll to tab content on mobile.
     */
    window.onresize = function (event) {
        if (screen.width < 769) {
            $(".nav-tabs li").click(function () {
                var id = $(this).attr('class');
                id = id.replace("active ", "");
                id = id.replace(" active", "");
                setTimeout(function () {
                    $('html, body').animate({
                        scrollTop: ($('#' + id).offset().top - 10)
                    }, 500);
                }, 500);
            });
        }
    };

});
