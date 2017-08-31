
/*
 * Js that permits to search into the menu's search bar.
 */
var cache = {};
$(document).on('ready pjax:success', function () {

    setupAutocomplete($('#query-value-menu'));
    setupAutocomplete($('#query-value-page'));

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
        var urlTool = new UrlTool(baseUrl, params);
        var finalUrl = urlTool.createSearchUrl();

        $(this).attr('href', finalUrl);
    });

    $('.query-value').bind('keypress', function (e) {

        var code = e.keyCode || e.which;
        if (code === 13) { /*Enter keycode*/

            var params = {};
            params['query'] = $(this).val();
            var baseUrl = $('.button-search').attr('href');
            var urlTool = new UrlTool(baseUrl, params);
            var finalUrl = urlTool.createSearchUrl();
            window.location.replace(finalUrl);
        }
    });
});

/*
 * Return to the top of the results' section.
 * (Called by paginathing.js from the "show()" function)
 */
function scrollToTopResult() {
    $('html, body').animate({
        scrollTop: $("#results-container-anchor").offset().top
    }, 500);
}

/*
 * Setup the autocomplete form.
 */
function setupAutocomplete(input) {

    input.autocomplete({
        source: function (request, response) {

            var term = request.term;
            if (term in cache) {
                response(cache[ term ]);
                return;
            }

            $.ajax({
                url: 'https://en.wikipedia.org/w/api.php',
                dataType: 'jsonp',
                data: {
                    'action': "opensearch",
                    'format': "json",
                    'search': request.term
                },
                success: function (data) {
                    response(data[1]);
                }
            });
        }
    });
}