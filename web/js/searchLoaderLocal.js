
/*
 * Js that permits to search into the search page.
 */

/* global searchUrl */
$(document).on('ready pjax:success', function () {
    setupMarker();
    setupPaginator();
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
 * Setup the paginathing system.
 */
function setupPaginator() {

    var resultsCount = $('#results-container td.search-result').length;
    var resultsPerPage = 10;

    if (resultsCount !== 0) {

        var limitPagination;

        if (resultsCount < resultsPerPage) {
            limitPagination = 1;
        } else {
            limitPagination = Math.ceil(resultsCount / resultsPerPage);

            if (limitPagination > 10) {
                limitPagination = 10;
            }

            if (screen.width <= 320) {
                limitPagination = 3;
            } else if (screen.width <= 375) {
                limitPagination = 4;
            } else if (screen.width <= 425) {
                limitPagination = 5;
            }
        }

        $('.list-group').paginathing({
            perPage: resultsPerPage,
            limitPagination: limitPagination,
            containerClass: 'panel-footer',
            appendTo: '#results-container'
        });
    }
}

function setupMarker() {
    var query = $('#query-value-page').val();

    $('#marker').change(function () {
        if ($(this).is(":checked")) {
            $(".search-result-snippet").mark(query, {
                "accuracy": "complementary",
                "ignoreJoiners": true,
                "acrossElements": true,
                "diacritics": true,
                "each": function (element) {
                    setTimeout(function () {
                        $(element).addClass("animate");
                    }, 250);
                }
            });
        } else {
            $(".search-result-snippet").unmark();
        }
    });
}

function setupAutocomplete(input) {
    input.autocomplete({
        source: function (request, response) {
            $.ajax({
                url: searchUrl,
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