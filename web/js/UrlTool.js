
function UrlTool(baseUrl = null, params = null) {

    if (baseUrl !== null) {
        this.baseUrlTemp = baseUrl.split('?');
        this.params = params;
}
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


UrlTool.prototype.replaceUrlLinks = function (container) {

    var homeUrl = $('#homeUrl').val();

    $(container + " a:not(.external):not(.new_version_page_link)").each(function () {

        var currentUrl = $(this).attr('href');

        if (typeof currentUrl !== 'undefined') {
            if (!currentUrl.includes("#cite_note") && !currentUrl.includes("File:")) {
                var currentUrlSplitted = currentUrl.split('/');
                var pageTitle = currentUrlSplitted[currentUrlSplitted.length - 1];
                var finalUrl = homeUrl + 'articles/article?title=' + pageTitle;

                $(this).attr('href', finalUrl);
            }
        }
    });

};
