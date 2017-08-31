
/*
 * Generic js called from the Generic and Specific Visualizer.
 */
$(document).on('ready', function () {

    $('a.external').attr('target', '_blank');

    /*
     * Add the external link image to all link
     */
    var eternalLinkImage = '<span class="glyphicon glyphicon-share light-gray" aria-hidden="true"></span>';
    $("a.external").append(eternalLinkImage);

    var urlTool = new UrlTool();
    urlTool.replaceUrlLinks('#article');

});
