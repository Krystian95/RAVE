
$(document).on('ready pjax:success', function () {

    $('#query-value-page').click(function () {
        $('#query-value-menu').val('');
    });

    $('#query-value-menu').click(function () {
        $('#query-value-page').val('');
    });

    $('.button-search').click(function () {

        var params = {};
        var query;

        if ($('#query-value-menu').val() !== '') {
            query = $('#query-value-menu').val();
        } else if ($('#query-value-page').val() !== '') {
            query = $('#query-value-page').val();
        }

        params['query'] = query;

        var baseUrl = $(this).attr('href');
        var finalUrl = createSearchUrl(baseUrl, params);

        $(this).attr('href', finalUrl);
    });

    $('.query-value').bind('keypress', function (e) {

        var code = e.keyCode || e.which;

        if (code === 13) { //Enter keycode

            var params = {};

            params['query'] = $(this).val();

            var baseUrl = $('.button-search').attr('href');
            var finalUrl = createSearchUrl(baseUrl, params);

            window.location.replace(finalUrl);
        }
    });
});