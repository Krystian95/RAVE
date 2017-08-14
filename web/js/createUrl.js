
function createUrl(params = null, action = null) {

    var sPageURL = decodeURIComponent(window.location.href);
    var finalUrl;

    if (~sPageURL.indexOf("?")) {
        var sURLVariables = sPageURL.split('?');
        finalUrl = sURLVariables[0];
    } else {
        finalUrl = sPageURL + '/' + action;
    }

    finalUrl += '?';

    $.each(params, function (key, value) {
        finalUrl += '&' + key + '=' + value;
    });

    return finalUrl;
}