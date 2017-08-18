
$(document).on('ready pjax:success', function () {

    $('a.external').attr('target', '_blank');

    var eternalLinkImage = '<span class="glyphicon glyphicon-share light-gray" aria-hidden="true"></span>'
    $("a.external").append(eternalLinkImage);

});
