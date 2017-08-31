
/*
 * Performs the creation of the links inside each Twitter's result.
 */
$(document).on('ready', function () {
    $('.twitter-results .result .text').linkify({
        target: "_blank"
    });
});
