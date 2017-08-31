<?php

namespace app\models;

use app\models\Annotation;
use yii\db\Query;
use yii\base\Model;
use Yii;

/**
 * Class that perform the action requested by annotation's controller.
 */
class Annotations extends Model {

    public function __construct() {
        
    }

    /*
     * Returns all annotations made in a specific page (via article revision id).
     */

    public function getAnnotations($article_revision_id) {

        if (Yii::$app->user->isGuest) {
            $visibility = 1;
        } else {
            $visibility = 0;
        }

        $query = new Query;
        $annotations = $query
                ->select('annotation')
                ->from([
                    'annotation'
                ])
                ->where([
                    'annotation.article_revision_id' => $article_revision_id,
                    'annotation.global_visibility' => [$visibility, '1'],
                ])
                ->all();

        return $annotations;
    }

    /*
     * Creates a new annotation.
     */

    public function createNewAnnotation($annotation_id, $annotationInput, $user_id, $article_id, $article_revision_id, $global_visibility) {

        $annotation = Annotation::findOne([
                    'IdAnnotation' => $annotation_id,
        ]);

        if ($annotation === NULL) {
            $annotation = new Annotation();
            $annotation->IdAnnotation = $annotation_id;
            $annotation->annotation = $annotationInput;
            $annotation->user_id = $user_id;
            $annotation->page_id = $article_id;
            $annotation->article_revision_id = $article_revision_id;

            if ($global_visibility === null) {
                /*
                 * TRUE (public annotation)
                 */
                $annotation->global_visibility = 1;
            } else {
                /*
                 * FALSE (private annotation)
                 */
                $annotation->global_visibility = 0;
            }
        }

        if (!$annotation->save()) {
            return $annotation->errors;
        }
    }

    /*
     * Update an annotation.
     */

    public function updateAnnotation($annotation_id, $annotationInput, $global_visibility) {

        $annotation = Annotation::findOne([
                    'IdAnnotation' => $annotation_id,
        ]);

        if ($global_visibility === null) {
            /*
             * TRUE (public annotation)
             */
            $annotation->global_visibility = 1;
        } else {
            /*
             * FALSE (private annotation)
             */
            $annotation->global_visibility = 0;
        }

        $annotation->annotation = $annotationInput;

        if (!$annotation->update()) {
            return $annotation->errors;
        }
    }

    /*
     * Delete an annotation.
     */

    public function deleteAnnotation($annotation_id) {

        $annotation = Annotation::findOne([
                    'IdAnnotation' => $annotation_id,
        ]);

        if (!$annotation->delete()) {
            return $annotation->errors;
        }
    }

}
