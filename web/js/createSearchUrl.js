
function createSearchUrl(baseUrl = null, params = null) {

    var baseUrlTemp = baseUrl.split('?');
    var finalUrl;

    if (~baseUrlTemp[0].indexOf("/search/search")) {
        finalUrl = baseUrlTemp[0];
    } else if (~baseUrlTemp[0].indexOf("/search")) {
        finalUrl = baseUrlTemp[0] + '/search';
    }else{
        finalUrl = baseUrlTemp[0] + 'search/search';
    }

    finalUrl += '?';

    $.each(params, function (key, value) {
        finalUrl += '&' + key + '=' + value;
    });

    return finalUrl;
}