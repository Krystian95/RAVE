
function UrlTool(baseUrl = null, params = null) {

    this.baseUrlTemp = baseUrl.split('?');
    this.params = params;

}

UrlTool.prototype.createSearchUrl = function () {

    if (~this.baseUrlTemp[0].indexOf("/search/search")) {
        this.finalUrl = this.baseUrlTemp[0];
    } else if (~this.baseUrlTemp[0].indexOf("/search")) {
        this.finalUrl = this.baseUrlTemp[0] + '/search';
    } else {
        this.finalUrl = this.baseUrlTemp[0] + 'search/search';
    }

    this.finalUrl += '?';
    var params = '';

    $.each(this.params, function (key, value) {
        params += '&' + key + '=' + value;
    });

    this.finalUrl += params;

    return this.finalUrl;
};
