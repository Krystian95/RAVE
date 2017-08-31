
/*
 * Js called from the HomeWidget.
 */
$(document).on('ready pjax:success', function () {

    /*
     * Add the countries flags.
     */
    var toRemove = ' (country)';
    $(".post").each(function () {
        var countryName = $(this).data('title');
        var countryNameId = $(this).data('id');

        if (~countryName.indexOf(toRemove)) {
            countryName = countryName.replace(toRemove, '');
        }

        countryName = countryName.split(' ').join('-');
        countryName = countryName.toLowerCase(countryName);
        countryName = countryName.normalize('NFD').replace(/[\u0300-\u036f]/g, "");

        $(".flag[data-id='" + countryNameId + "']").css("background-image", "url(css/images/countries-flag/" + countryName + ".png)");
    });

    /*
     * Sets the hover effects.
     */
    $(".post").hover(function () {
        var id = $(this).data('id');
        $(".updated[data-id='" + id + "']").addClass('updated-hover');
    }, function () {
        var id = $(this).data('id');
        $(".updated[data-id='" + id + "']").removeClass('updated-hover');
    });

});