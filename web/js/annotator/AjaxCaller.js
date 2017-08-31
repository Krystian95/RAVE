
/*
 * Performs the Ajax calls for annotations.
 */

/* global annotatorObj, annotatorViewerObj */
function AjaxCaller() {

    this.homeUrl = $('#homeUrl').val();
    this.article_revision_id = $('#article_revision_id').val();
    this.article_id = $('#article_id').val();
}

/*
 * Censures the annotation obj from the circular references.
 */
AjaxCaller.prototype.censor = function (censor) {

    var i = 0;

    return function (key, value) {
        if (i !== 0 && typeof (censor) === 'object' && typeof (value) == 'object' && censor == value)
            return '[Circular]';

        if (i >= 29) /* seems to be a harded maximum of 30 serialized objects? */
            return value;

        ++i; /* so we know we aren't using the original object anymore */

        return value;
    };
};

/*
 * Return all annotations for the current page and build them.
 */
AjaxCaller.prototype.loadAnnotations = function () {

    $.ajax({
        type: 'GET',
        cache: false,
        data: {
            'article_revision_id': this.article_revision_id
        },
        dataType: 'json',
        url: this.homeUrl + 'annotation/get-annotations',
        success: function (data) {

            $.each(data, function (index, value) {

                var annotation = JSON.parse(value['annotation']);

                /*
                 * Create the annotation into the page text
                 */
                annotatorObj.setupAnnotationCustom(annotation);

                /*
                 * Add the annotation into the panel
                 */
                annotatorViewerObj.createReferenceAnnotation(annotation);

                /*
                 * Update the annotations count (panel's label)
                 */
                $('#count-anotations').text($(".container-anotacions").find('.annotator-marginviewer-element').length);
            });
        },
        error: function (error) {
            console.log('ERROR on "loadAnnotations":');
            console.log(error);
        }
    });
};

/*
 * Creates a new annotation.
 */
AjaxCaller.prototype.createAnnotation = function (annotationInput) {

    var annotation = JSON.stringify(annotationInput, this.censor(annotationInput));

    $.ajax({
        type: 'POST',
        cache: false,
        data: {
            'annotation_id': annotationInput.id,
            'annotation': annotation,
            'article_id': this.article_id,
            'article_revision_id': this.article_revision_id,
            'global_visibility': annotationInput.permissions.read
        },
        dataType: 'json',
        url: this.homeUrl + 'annotation/create',
        error: function (error) {
            console.log('ERROR on "createAnnotation":');
            console.log(error);
        }
    });
};

/*
 * Update an annotation.
 */
AjaxCaller.prototype.updateAnnotation = function (annotationInput) {

    var annotation = JSON.stringify(annotationInput, this.censor(annotationInput));

    $.ajax({
        type: 'POST',
        cache: false,
        data: {
            'annotation_id': annotationInput.id,
            'annotation': annotation,
            'global_visibility': annotationInput.permissions.read
        },
        dataType: 'json',
        url: this.homeUrl + 'annotation/update',
        error: function (error) {
            console.log('ERROR on "updateAnnotation":');
            console.log(error);
        }
    });
};

/*
 * Delete an annotation.
 */
AjaxCaller.prototype.deleteAnnotation = function (annotationInput) {

    /* Avoid call if pressed "Cancel" button on annotation creation" */
    if (typeof annotationInput.id !== 'undefined') {
        $.ajax({
            type: 'POST',
            cache: false,
            data: {
                'annotation_id': annotationInput.id
            },
            dataType: 'json',
            url: this.homeUrl + 'annotation/delete',
            error: function (error) {
                console.log('ERROR on "deleteAnnotation":');
                console.log(error);
            }
        });
    }
};