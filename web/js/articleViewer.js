
$(document).on('ready', function () {

    $('a.external').attr('target', '_blank');

    var eternalLinkImage = '<span class="glyphicon glyphicon-share light-gray" aria-hidden="true"></span>';
    $("a.external").append(eternalLinkImage);

    var urlTool = new UrlTool();
    urlTool.replaceUrlLinks('#article');

});
