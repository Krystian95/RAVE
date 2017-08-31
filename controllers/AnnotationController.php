<?php

namespace app\controllers;

use Yii;
use app\models\Annotations;

/*
 * Controller class for the annotation.
 * It handles the possible actions.
 */
class AnnotationController extends \yii\web\Controller {

    /*
     * Returns all annotations made in a specific page (via article revision id).
     */
    public function actionGetAnnotations() {

        $article_revision_id = Yii::$app->request->get('article_revision_id');

        $annotations = new Annotations();
        $annotations_result = $annotations->getAnnotations($article_revision_id);

        return \yii\helpers\Json::encode($annotations_result);
    }

    /*
     * Creates a new annotation.
     */
    public function actionCreate() {

        $annotation_id = Yii::$app->request->post('annotation_id');
        $annotation = Yii::$app->request->post('annotation');
        $article_revision_id = Yii::$app->request->post('article_revision_id');
        $article_id = Yii::$app->request->post('article_id');
        $user_id = Yii::$app->user->id;
        $global_visibility = Yii::$app->request->post('global_visibility');

        $annotations = new Annotations();
        $result = $annotations->createNewAnnotation($annotation_id, $annotation, $user_id, $article_id, $article_revision_id, $global_visibility);

        return \yii\helpers\Json::encode($result);
    }

    /*
     * Update an annotation.
     */
    public function actionUpdate() {

        $annotation_id = Yii::$app->request->post('annotation_id');
        $annotation = Yii::$app->request->post('annotation');
        $global_visibility = Yii::$app->request->post('global_visibility');

        $annotations = new Annotations();
        $result = $annotations->updateAnnotation($annotation_id, $annotation, $global_visibility);

        return \yii\helpers\Json::encode($result);
    }

    /*
     * Delete an annotation.
     */
    public function actionDelete() {

        $annotation_id = Yii::$app->request->post('annotation_id');

        $annotations = new Annotations();
        $result = $annotations->deleteAnnotation($annotation_id);

        return \yii\helpers\Json::encode($result);
    }

}
