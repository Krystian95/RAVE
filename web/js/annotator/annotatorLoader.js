
/* global i18n_dict */

$(document).on('ready', function () {

    $.i18n.load(i18n_dict);
    /* Customise the default plugin options with the third argument. */
    var annotator = $('body').annotator().annotator().data('annotator');
    var propietary = $('#username_logged_in').val();
    annotator.addPlugin('Permissions', {
        user: propietary,
        permissions: {
            'read': [propietary],
            'update': [propietary],
            'delete': [propietary],
            'admin': [propietary]
        },
        showViewPermissionsCheckbox: true,
        showEditPermissionsCheckbox: false
    });

    $('body').annotator().annotator('addPlugin', 'AnnotatorViewer');
    $('body').annotator().annotator("addPlugin", "Touch");
    $('body').annotator().annotator('addPlugin', 'Categories',
            {
                annotator_color_yellow: 'annotator-hl-annotator_color_yellow',
                annotator_color_red: 'annotator-hl-annotator_color_red',
                annotator_color_orange: 'annotator-hl-annotator_color_orange',
                annotator_color_light_green: 'annotator-hl-annotator_color_light_green',
                annotator_color_dark_green: 'annotator-hl-annotator_color_dark_green',
                annotator_color_azure: 'annotator-hl-annotator_color_azure',
                annotator_color_blue: 'annotator-hl-annotator_color_blue',
                annotator_color_brown: 'annotator-hl-annotator_color_brown',
                annotator_color_olive: 'annotator-hl-annotator_color_olive',
                annotator_color_gray: 'annotator-hl-annotator_color_gray',
                annotator_color_violet: 'annotator-hl-annotator_color_violet',
                annotator_color_pink: 'annotator-hl-annotator_color_pink'
            }
    );

    /*noinspection JSJQueryEfficiency*/
    $('body').annotator().annotator('addPlugin', 'Search');

    /*Annotation scroll*/
    $('#anotacions-uoc-panel').slimscroll({height: '95%'});
});